<?php
// xendit_webhook.php
require_once 'db.php';

// Xendit webhook secret token for verification
$webhookToken = '9uz7HZwDcrXCNLcdsJO5JU0OVYWreOjPGWrfnJCn2XZ5p1KL';

// Get the raw input
$input = file_get_contents('php://input');
$headers = getallheaders();

// Verify webhook signature (Xendit sends X-Callback-Token header)
$callbackToken = isset($headers['X-Callback-Token']) ? $headers['X-Callback-Token'] : '';

if ($callbackToken !== $webhookToken) {
    http_response_code(401);
    echo 'Unauthorized - Invalid webhook token';
    error_log('Xendit webhook unauthorized access attempt. Received token: ' . $callbackToken);
    exit;
}

// Decode the JSON payload
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo 'Invalid JSON payload';
    error_log('Xendit webhook invalid JSON: ' . $input);
    exit;
}

// Log the received webhook for debugging
error_log('Xendit webhook received: ' . print_r($data, true));

try {
    // Process different webhook events
    $eventType = $data['event'] ?? 'unknown';
    
    switch ($eventType) {
        case 'payment.succeeded':
        case 'payment.failed':
        case 'payment.awaiting_capture':
        case 'capture.succeeded':
        case 'capture.failed':
        case 'invoice.paid':
        case 'invoice.expired':
        case 'invoice.failed':
            processPaymentEvent($data, $conn);
            break;
            
        case 'ewallet.capture':
            processEwalletEvent($data, $conn);
            break;
            
        case 'qr.payment':
            processQRPaymentEvent($data, $conn);
            break;
            
        case 'payment_session.completed':
        case 'payment_session.expired':
            processPaymentSessionEvent($data, $conn);
            break;
            
        default:
            // Log unknown event types but still respond with 200
            error_log('Unknown Xendit event type: ' . $eventType);
            break;
    }
    
    http_response_code(200);
    echo 'Webhook processed successfully';
    
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error processing webhook: ' . $e->getMessage();
    error_log('Xendit webhook processing error: ' . $e->getMessage());
}

/**
 * Process payment events (v2/v3 payments)
 */
function processPaymentEvent($data, $conn) {
    $paymentData = $data['data'] ?? [];
    
    // Extract common fields
    $xenditId = $paymentData['id'] ?? '';
    $externalId = $paymentData['external_id'] ?? $paymentData['reference_id'] ?? '';
    $amount = $paymentData['amount'] ?? $paymentData['request_amount'] ?? 0;
    $currency = $paymentData['currency'] ?? 'PHP';
    $status = $paymentData['status'] ?? '';
    $created = $paymentData['created'] ?? date('Y-m-d H:i:s');
    $updated = $paymentData['updated'] ?? date('Y-m-d H:i:s');
    
    // Extract payment method details
    $paymentMethod = '';
    $channelCode = '';
    $paymentMethodData = $paymentData['payment_method'] ?? [];
    
    if (!empty($paymentMethodData)) {
        $paymentMethod = $paymentMethodData['type'] ?? '';
        $channelCode = $paymentMethodData['channel_code'] ?? 
                      ($paymentMethodData['over_the_counter']['channel_code'] ?? '');
    }
    
    // Extract customer and business info
    $businessId = $data['business_id'] ?? '';
    $customerId = $paymentData['customer_id'] ?? '';
    $payerEmail = $paymentData['payer_email'] ?? '';
    
    // Extract capture details for captured payments
    $capturedAmount = $paymentData['captured_amount'] ?? $amount;
    $authorizedAmount = $paymentData['authorized_amount'] ?? $amount;
    $captureId = '';
    $captureTimestamp = null;
    
    if (isset($paymentData['captures']) && is_array($paymentData['captures']) && !empty($paymentData['captures'])) {
        $capture = $paymentData['captures'][0];
        $captureId = $capture['capture_id'] ?? '';
        $captureTimestamp = $capture['capture_timestamp'] ?? null;
    }
    
    // Extract additional metadata
    $metadata = json_encode($paymentData['metadata'] ?? []);
    $paymentDetail = json_encode($paymentData['payment_detail'] ?? []);
    $channelProperties = json_encode($paymentData['channel_properties'] ?? []);
    
    // Try to find subscription_id from external_id (assuming external_id is your subscription reference)
    $subscriptionId = null;
    $userId = null;
    
    if (!empty($externalId)) {
        $stmt = $conn->prepare("SELECT id, user_id FROM subscriptions WHERE reference = ?");
        $stmt->bind_param("s", $externalId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $subscription = $result->fetch_assoc();
            $subscriptionId = $subscription['id'];
            $userId = $subscription['user_id'];
        }
        $stmt->close();
    }
    
    // Check if payment already exists
    $stmt = $conn->prepare("SELECT id FROM payments WHERE xendit_id = ?");
    $stmt->bind_param("s", $xenditId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    if ($result->num_rows > 0) {
        // Update existing payment
        $stmt = $conn->prepare("
            UPDATE payments SET 
                status = ?, 
                amount = ?, 
                captured_amount = ?, 
                authorized_amount = ?, 
                capture_id = ?, 
                capture_timestamp = ?, 
                updated_at = ?,
                failure_code = ?,
                payment_detail = ?,
                channel_properties = ?
            WHERE xendit_id = ?
        ");
        
        $failureCode = $paymentData['failure_code'] ?? null;
        $updatedAt = date('Y-m-d H:i:s');
        
        $stmt->bind_param(
            "sddssssssss", 
            $status, 
            $amount, 
            $capturedAmount, 
            $authorizedAmount, 
            $captureId, 
            $captureTimestamp, 
            $updatedAt,
            $failureCode,
            $paymentDetail,
            $channelProperties,
            $xenditId
        );
    } else {
        // Insert new payment
        $stmt = $conn->prepare("
            INSERT INTO payments (
                xendit_id, external_id, reference_id, business_id, payment_request_id,
                customer_id, amount, currency, status, payment_method, channel_code,
                description, payer_email, failure_code, metadata, payment_detail,
                channel_properties, created_at, updated_at, captured_amount,
                authorized_amount, capture_id, capture_timestamp, subscription_id, user_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $referenceId = $paymentData['reference_id'] ?? '';
        $paymentRequestId = $paymentData['payment_request_id'] ?? '';
        $description = $paymentData['description'] ?? '';
        $failureCode = $paymentData['failure_code'] ?? null;
        
        $stmt->bind_param(
            "ssssssdsdssssssssssdssssss", 
            $xenditId, 
            $externalId, 
            $referenceId, 
            $businessId, 
            $paymentRequestId,
            $customerId, 
            $amount, 
            $currency, 
            $status, 
            $paymentMethod, 
            $channelCode,
            $description, 
            $payerEmail, 
            $failureCode, 
            $metadata, 
            $paymentDetail,
            $channelProperties, 
            $created, 
            $updated, 
            $capturedAmount,
            $authorizedAmount, 
            $captureId, 
            $captureTimestamp, 
            $subscriptionId, 
            $userId
        );
    }
    
    $stmt->execute();
    $stmt->close();
    
    // If payment is successful, update subscription status
    if ($status === 'SUCCEEDED' || $status === 'PAID' || $status === 'COMPLETED') {
        if ($subscriptionId) {
            $updateStmt = $conn->prepare("
                UPDATE subscriptions 
                SET status = 'active', payment_status = 'paid', last_payment_date = NOW() 
                WHERE id = ?
            ");
            $updateStmt->bind_param("i", $subscriptionId);
            $updateStmt->execute();
            $updateStmt->close();
        }
    }
}

/**
 * Process e-wallet events
 */
function processEwalletEvent($data, $conn) {
    $ewalletData = $data['data'] ?? [];
    
    $xenditId = $ewalletData['id'] ?? '';
    $externalId = $ewalletData['reference_id'] ?? '';
    $amount = $ewalletData['charge_amount'] ?? $ewalletData['amount'] ?? 0;
    $currency = $ewalletData['currency'] ?? 'PHP';
    $status = $ewalletData['status'] ?? '';
    $channelCode = $ewalletData['channel_code'] ?? '';
    $created = $ewalletData['created'] ?? date('Y-m-d H:i:s');
    $updated = $ewalletData['updated'] ?? date('Y-m-d H:i:s');
    
    // Process similar to regular payments
    $paymentData = [
        'id' => $xenditId,
        'external_id' => $externalId,
        'reference_id' => $externalId,
        'amount' => $amount,
        'currency' => $currency,
        'status' => $status,
        'created' => $created,
        'updated' => $updated,
        'payment_method' => [
            'type' => 'EWALLET',
            'channel_code' => $channelCode
        ]
    ];
    
    $eventData = [
        'event' => $data['event'],
        'business_id' => $data['business_id'] ?? '',
        'data' => $paymentData
    ];
    
    processPaymentEvent($eventData, $conn);
}

/**
 * Process QR payment events
 */
function processQRPaymentEvent($data, $conn) {
    $qrData = $data['data'] ?? [];
    
    $xenditId = $qrData['id'] ?? '';
    $externalId = $qrData['reference_id'] ?? '';
    $amount = $qrData['amount'] ?? 0;
    $currency = $qrData['currency'] ?? 'PHP';
    $status = $qrData['status'] ?? '';
    $channelCode = $qrData['channel_code'] ?? '';
    $created = $qrData['created'] ?? date('Y-m-d H:i:s');
    
    // Process similar to regular payments
    $paymentData = [
        'id' => $xenditId,
        'external_id' => $externalId,
        'reference_id' => $externalId,
        'amount' => $amount,
        'currency' => $currency,
        'status' => $status,
        'created' => $created,
        'updated' => $created,
        'payment_method' => [
            'type' => 'QR_CODE',
            'channel_code' => $channelCode
        ]
    ];
    
    $eventData = [
        'event' => $data['event'],
        'business_id' => $data['business_id'] ?? '',
        'data' => $paymentData
    ];
    
    processPaymentEvent($eventData, $conn);
}

/**
 * Process payment session events
 */
function processPaymentSessionEvent($data, $conn) {
    // Payment sessions are typically for payment links
    // You might want to handle these differently based on your needs
    error_log('Payment session event received: ' . print_r($data, true));
    
    // For now, we'll just log these events but not process them as payments
}