<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['ajax_action'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$response = ['success' => false, 'message' => ''];
$action = $_POST['ajax_action'];

try {
    switch ($action) {
        case 'verify_reference':
    $reference = trim($_POST['reference']);
    if (empty($reference)) {
        throw new Exception('Reference number is required');
    }
    
    $stmt = $conn->prepare("
        SELECT s.*, p.plan_name, p.price, u.full_name, u.email, u.phone 
        FROM subscriptions s
        JOIN plans p ON s.plan_id = p.id
        JOIN subscribers u ON s.user_id = u.id
        WHERE s.reference = ?
    ");
    $stmt->bind_param("s", $reference);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Subscription not found with this reference');
    }
    
    $subscription = $result->fetch_assoc();
    $_SESSION['payment_flow'] = [
        'reference' => $reference,
        'subscription' => $subscription,
        'step' => 2
    ];
    
    $response['success'] = true;
    $response['user'] = [
        'name' => $subscription['full_name'],
        'email' => $subscription['email'],
        'phone' => $subscription['phone']
    ];
    $response['subscription'] = $subscription;
    break;
            
        case 'send_verification':
            if (!isset($_SESSION['payment_flow'])) {
                throw new Exception('Session expired. Please start again.');
            }
            
            $method = $_POST['method']; // 'email' or 'sms'
            $code = rand(100000, 999999);
            $_SESSION['payment_flow']['verification_code'] = $code;
            $_SESSION['payment_flow']['verification_method'] = $method;
            
            $user = $_SESSION['payment_flow']['subscription'];
            
            if ($method === 'sms') {
                // Send SMS via Semaphore
                $ch = curl_init();
                $parameters = array(
                    'apikey' => '0e1eb241cf70f66127f683cfb8a90e34',
                    'number' => $user['phone'],
                    'message' => "Your Angel Eyes verification code is: $code",
                    'sendername' => 'CSH'
                );
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
                
                if (strpos($output, 'message_id') === false) {
                    error_log("SMS sending failed. Response: " . $output);
                    throw new Exception('Failed to send SMS. Please try email instead.');
                }
            } else {
                // Send Email via PHPMailer
                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'capstoneproject0101@gmail.com';
                    $mail->Password   = 'sgox knuc kool pftq';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    // Recipients
                    $mail->setFrom('capstoneproject0101@gmail.com', 'Angel Eyes');
                    $mail->addAddress($user['email']);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Angel Eyes Verification Code';
                    $mail->Body    = "
                        <h3>Angel Eyes Verification Code</h3>
                        <p>Hello {$user['full_name']},</p>
                        <p>Your verification code is: <strong>{$code}</strong></p>
                        <p>This code will expire in 10 minutes.</p>
                        <p>If you didn't request this, please ignore this email.</p>
                    ";
                    $mail->AltBody = "Your Angel Eyes verification code is: {$code}";

                    if (!$mail->send()) {
                        throw new Exception('Failed to send email: ' . $mail->ErrorInfo);
                    }
                } catch (Exception $e) {
                    error_log("PHPMailer Error: " . $e->getMessage());
                    throw new Exception('Failed to send email. Please try SMS instead.');
                }
            }
            
            $_SESSION['payment_flow']['verification_code_sent_at'] = time();
            $_SESSION['payment_flow']['step'] = 3;
            $response['success'] = true;
            break;
            
        case 'verify_code':
            if (!isset($_SESSION['payment_flow']['verification_code'])) {
                throw new Exception('Session expired. Please start again.');
            }
            
            if (time() - $_SESSION['payment_flow']['verification_code_sent_at'] > 600) {
                unset($_SESSION['payment_flow']['verification_code']);
                throw new Exception('Verification code has expired. Please request a new one.');
            }
            
            $enteredCode = implode('', $_POST['code']);
            if ($enteredCode != $_SESSION['payment_flow']['verification_code']) {
                $_SESSION['payment_flow']['failed_attempts'] = ($_SESSION['payment_flow']['failed_attempts'] ?? 0) + 1;
                
                if ($_SESSION['payment_flow']['failed_attempts'] >= 3) {
                    unset($_SESSION['payment_flow']['verification_code']);
                    throw new Exception('Too many failed attempts. Please start the verification process again.');
                }
                
                throw new Exception('Invalid verification code. ' . (3 - $_SESSION['payment_flow']['failed_attempts']) . ' attempts remaining.');
            }
            
            unset($_SESSION['payment_flow']['failed_attempts']);
            
            $_SESSION['payment_flow']['step'] = 4;
            $response['success'] = true;
            $response['subscription'] = $_SESSION['payment_flow']['subscription'];
            break;
            
        case 'process_payment':
            if (!isset($_SESSION['payment_flow'])) {
                throw new Exception('Session expired. Please start again.');
            }
            
            $subscription = $_SESSION['payment_flow']['subscription'];
            
            // Process payment with Xendit
            $xenditResponse = $this->processXenditPayment($subscription);
            
            if (!isset($xenditResponse['id'])) {
                error_log("Xendit Error: " . json_encode($xenditResponse));
                throw new Exception('Payment failed: ' . ($xenditResponse['message'] ?? 'Unknown error'));
            }
            
            // Save transaction to database
            $stmt = $conn->prepare("
                INSERT INTO transactions (
                    subscription_id, user_id, reference_number, payment_method, amount, 
                    status, xendit_id, invoice_url, description, payer_email, currency,
                    created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $paymentMethod = 'E-WALLET';
            $status = 'PENDING';
            
            $stmt->bind_param(
                "iissdssssss",
                $subscription['id'],
                $subscription['user_id'],
                $subscription['reference'],
                $paymentMethod,
                $subscription['price'],
                $status,
                $xenditResponse['id'],
                $xenditResponse['invoice_url'],
                'Payment for ' . $subscription['plan_name'],
                $subscription['email'],
                'PHP'
            );
            
            if (!$stmt->execute()) {
                error_log("Database Error: " . $stmt->error);
            }
            
            // Store payment ID in session for status checking
            $_SESSION['payment_flow']['xendit_id'] = $xenditResponse['id'];
            
            $response['success'] = true;
            $response['payment_url'] = $xenditResponse['invoice_url'];
            $response['transaction_data'] = [
                'reference' => $subscription['reference'],
                'amount' => $subscription['price'],
                'plan_name' => $subscription['plan_name']
            ];
            break;
            
        case 'check_payment_status':
            if (!isset($_SESSION['payment_flow']['xendit_id'])) {
                throw new Exception('No payment in progress');
            }
            
            $paymentId = $_SESSION['payment_flow']['xendit_id'];
            $paymentStatus = $this->getXenditPaymentStatus($paymentId);
            
            $response['success'] = true;
            $response['status'] = $paymentStatus['status'];
            $response['paid'] = ($paymentStatus['status'] === 'PAID' || $paymentStatus['status'] === 'COMPLETED');
            break;
            
        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("Payment Error: " . $e->getMessage());
}

echo json_encode($response);

// Create invoice via Xendit (v2 invoices). Returns decoded JSON array or throws Exception.
function processXenditPayment($subscription, $paymentMethod = null) {
    $xenditApiKey = 'xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha';

    $payload = [
        'external_id' => $subscription['reference'] ?? uniqid('ext_'),
        'amount' => (float)($subscription['price'] ?? 0),
        'payer_email' => $subscription['email'] ?? null,
        'description' => 'Payment for ' . ($subscription['plan_name'] ?? 'subscription'),
        'success_redirect_url' => 'https://yourdomain.com/payment/success',
        'failure_redirect_url' => 'https://yourdomain.com/payment/failed'
    ];

    if (!empty($paymentMethod)) {
        $payload['payment_methods'] = [$paymentMethod];
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.xendit.co/v2/invoices');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode($xenditApiKey . ':'),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode < 200 || $httpCode >= 300) {
        throw new Exception('Xendit API returned HTTP ' . $httpCode . ' - ' . substr($response, 0, 512));
    }

    $decoded = json_decode($response, true);
    if ($decoded === null) {
        throw new Exception('Invalid JSON from Xendit');
    }

    return $decoded;
}

// Fetch payment/invoice status from Xendit. Accepts a payment/invoice id and returns decoded JSON.
function getXenditPaymentStatus($id, $isPayment = false) {
    $xenditApiKey = 'xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha';
    $url = $isPayment ? 'https://api.xendit.co/v3/payments/' . $id : 'https://api.xendit.co/v2/invoices/' . $id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode($xenditApiKey . ':'),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode < 200 || $httpCode >= 300) {
        throw new Exception('Xendit status check returned HTTP ' . $httpCode . ' - ' . substr($response, 0, 512));
    }

    $decoded = json_decode($response, true);
    if ($decoded === null) {
        throw new Exception('Invalid JSON from Xendit status endpoint');
    }

    return $decoded;
}