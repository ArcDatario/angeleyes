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
                    
        // ... previous code ...

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
                    $mail->setFrom('capstoneproject0101@gmail.com', 'Angel Eyes Solutions');
                    $mail->addAddress($user['email']);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Angel Eyes Solutions Verification Code';
                    
                    // Professional email template
                    $mail->Body    = "
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset='utf-8'>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333;
                                    max-width: 600px;
                                    margin: 0 auto;
                                    padding: 20px;
                                }
                                .header {
                                    text-align: center;
                                    border-bottom: 2px solid #f0f0f0;
                                    padding-bottom: 20px;
                                    margin-bottom: 30px;
                                }
                                .logo {
                                    max-width: 180px;
                                    margin-bottom: 15px;
                                }
                                .company-name {
                                    font-size: 24px;
                                    font-weight: bold;
                                    color: #2c3e50;
                                    margin: 0;
                                }
                                .code-container {
                                    background-color: #f8f9fa;
                                    border: 2px dashed #dee2e6;
                                    border-radius: 8px;
                                    padding: 25px;
                                    text-align: center;
                                    margin: 30px 0;
                                }
                                .verification-code {
                                    font-size: 32px;
                                    font-weight: bold;
                                    letter-spacing: 5px;
                                    color: #2c3e50;
                                    padding: 10px;
                                    background-color: #fff;
                                    border-radius: 5px;
                                    display: inline-block;
                                }
                                .footer {
                                    text-align: center;
                                    margin-top: 30px;
                                    padding-top: 20px;
                                    border-top: 2px solid #f0f0f0;
                                    color: #7f8c8d;
                                    font-size: 12px;
                                }
                            </style>
                        </head>
                        <body>
                            <div class='header'>
                                <img src='cid:company_logo' alt='Angel Eyes Solutions' class='logo'>
                                <h1 class='company-name'>Angel Eyes Solutions</h1>
                            </div>
                            
                            <p>Hello {$user['full_name']},</p>
                            <p>Your verification code for payment processing is:</p>
                            
                            <div class='code-container'>
                                <div class='verification-code'>{$code}</div>
                            </div>
                            
                            <p>This code will expire in 10 minutes for security purposes.</p>
                            <p>If you didn't request this verification, please ignore this email or contact our support team.</p>
                            
                            <div class='footer'>
                                <p>&copy; " . date('Y') . " Angel Eyes Solutions. All rights reserved.</p>
                                <p>This is an automated message, please do not reply to this email.</p>
                            </div>
                        </body>
                        </html>
                    ";
                    
                    // Add embedded image
                    $mail->AddEmbeddedImage('angeleyes-logo.png', 'company_logo', 'angeleyes-logo.png');
                    
                    $mail->AltBody = "Your Angel Eyes Solutions verification code is: {$code}. This code will expire in 10 minutes.";

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
            
            // Process payment with Xendit - create invoice
            $xenditResponse = processXenditInvoice($subscription);
            
            if (!isset($xenditResponse['invoice_url'])) {
                error_log("Xendit Error: " . json_encode($xenditResponse));
                throw new Exception('Payment failed: ' . ($xenditResponse['message'] ?? 'Unknown error'));
            }
            
            // Store payment ID in session for status checking
            $_SESSION['payment_flow']['xendit_id'] = $xenditResponse['id'];
            $_SESSION['payment_flow']['xendit_invoice_id'] = $xenditResponse['id'];
            
            $response['success'] = true;
            $response['payment_url'] = $xenditResponse['invoice_url'];
            $response['transaction_data'] = [
                'reference' => $subscription['reference'],
                'amount' => $subscription['price'],
                'plan_name' => $subscription['plan_name']
            ];
            break;
            
        case 'check_payment_status':
            if (!isset($_SESSION['payment_flow']['xendit_invoice_id'])) {
                throw new Exception('No payment in progress');
            }
            
            $invoiceId = $_SESSION['payment_flow']['xendit_invoice_id'];
            $invoiceStatus = getXenditInvoiceStatus($invoiceId);
            
            $response['success'] = true;
            $response['status'] = $invoiceStatus['status'];
            $response['paid'] = ($invoiceStatus['status'] === 'PAID');
            
            // If paid, update subscription
            if ($response['paid'] && isset($_SESSION['payment_flow']['subscription'])) {
                $subscription = $_SESSION['payment_flow']['subscription'];
                $updateStmt = $conn->prepare("
                    UPDATE subscriptions 
                    SET status = 'active', payment_status = 'paid', last_payment_date = NOW() 
                    WHERE reference = ?
                ");
                $updateStmt->bind_param("s", $subscription['reference']);
                $updateStmt->execute();
                $updateStmt->close();
            }
            break;
            
        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("Payment Error: " . $e->getMessage());
}

echo json_encode($response);

// Create invoice via Xendit (v2 invoices)
function processXenditInvoice($subscription) {
    $xenditApiKey = 'xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha';

    $payload = [
        'external_id' => $subscription['reference'],
        'amount' => (float)$subscription['price'],
        'payer_email' => $subscription['email'],
        'description' => 'Payment for ' . $subscription['plan_name'],
        'success_redirect_url' => 'https://angeleyesolutions.online/payment.php?success=true',
        'failure_redirect_url' => 'https://angeleyesolutions.online/payment.php?failed=true',
        'currency' => 'PHP'
    ];

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
        error_log("Xendit API Error: HTTP $httpCode - $response");
        throw new Exception('Xendit API returned HTTP ' . $httpCode);
    }

    $decoded = json_decode($response, true);
    if ($decoded === null) {
        throw new Exception('Invalid JSON from Xendit');
    }

    return $decoded;
}

// Fetch invoice status from Xendit
function getXenditInvoiceStatus($invoiceId) {
    $xenditApiKey = 'xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha';
    $url = 'https://api.xendit.co/v2/invoices/' . $invoiceId;

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
        throw new Exception('Xendit status check returned HTTP ' . $httpCode);
    }

    $decoded = json_decode($response, true);
    if ($decoded === null) {
        throw new Exception('Invalid JSON from Xendit status endpoint');
    }

    return $decoded;
}