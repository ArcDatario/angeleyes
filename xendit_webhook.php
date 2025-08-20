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

// Check if input is empty
if (empty($input)) {
    http_response_code(400);
    echo 'Empty payload received';
    error_log('Xendit webhook empty payload received');
    exit;
}

// Decode the JSON payload
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo 'Invalid JSON payload: ' . json_last_error_msg();
    error_log('Xendit webhook invalid JSON: ' . $input);
    exit;
}

// Log the received webhook for debugging
error_log('Xendit webhook received: ' . print_r($data, true));

try {
    // Process different webhook events
    $eventType = $data['event'] ?? 'unknown';
    
    switch ($eventType) {
        case 'invoice.paid':
        case 'invoice.expired':
        case 'invoice.failed':
            processInvoiceEvent($data, $conn);
            break;
            
        case 'payment.succeeded':
        case 'payment.failed':
        case 'payment.awaiting_capture':
            processPaymentEvent($data, $conn);
            break;
            
        case 'capture.succeeded':
        case 'capture.failed':
            processCaptureEvent($data, $conn);
            break;
            
        case 'ewallet.capture':
            processEwalletEvent($data, $conn);
            break;
            
        case 'qr.payment':
            processQRPaymentEvent($data, $conn);
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
 * Process invoice events (v2 invoices)
 */
function processInvoiceEvent($data, $conn) {
    $invoiceData = $data['data'] ?? [];
    
    // Extract common fields
    $xenditId = $invoiceData['id'] ?? '';
    $externalId = $invoiceData['external_id'] ?? '';
    $amount = $invoiceData['amount'] ?? 0;
    $currency = $invoiceData['currency'] ?? 'PHP';
    $status = $invoiceData['status'] ?? '';
    $created = isset($invoiceData['created']) ? date('Y-m-d H:i:s', strtotime($invoiceData['created'])) : date('Y-m-d H:i:s');
    $updated = isset($invoiceData['updated']) ? date('Y-m-d H:i:s', strtotime($invoiceData['updated'])) : date('Y-m-d H:i:s');
    
    // Extract payment details
    $payerEmail = $invoiceData['payer_email'] ?? '';
    $description = $invoiceData['description'] ?? '';
    $invoiceUrl = $invoiceData['invoice_url'] ?? '';
    
    // Try to find subscription_id from external_id
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
                updated_at = ?,
                invoice_url = ?
            WHERE xendit_id = ?
        ");
        
        $updatedAt = date('Y-m-d H:i:s');
        
        $stmt->bind_param(
            "sdsss", 
            $status, 
            $amount, 
            $updatedAt,
            $invoiceUrl,
            $xenditId
        );
    } else {
        // Insert new payment
        $stmt = $conn->prepare("
            INSERT INTO payments (
                xendit_id, external_id, amount, currency, status, 
                description, payer_email, created_at, updated_at, 
                invoice_url, subscription_id, user_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param(
            "ssddssssssii", 
            $xenditId, 
            $externalId, 
            $amount, 
            $currency, 
            $status,
            $description, 
            $payerEmail, 
            $created, 
            $updated,
            $invoiceUrl, 
            $subscriptionId, 
            $userId
        );
    }
    
    $stmt->execute();
    $stmt->close();
    
    // If payment is successful, update subscription status
    if ($status === 'PAID') {
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
 * Process payment events (v3 payments)
 */
function processPaymentEvent($data, $conn) {
    $paymentData = $data['data'] ?? [];
    
    // Extract common fields
    $xenditId = $paymentData['id'] ?? '';
    $externalId = $paymentData['external_id'] ?? $paymentData['reference_id'] ?? '';
    $amount = $paymentData['amount'] ?? $paymentData['request_amount'] ?? 0;
    $currency = $paymentData['currency'] ?? 'PHP';
    $status = $paymentData['status'] ?? '';
    $created = isset($paymentData['created']) ? date('Y-m-d H:i:s', strtotime($paymentData['created'])) : date('Y-m-d H:i:s');
    $updated = isset($paymentData['updated']) ? date('Y-m-d H:i:s', strtotime($paymentData['updated'])) : date('Y-m-d H:i:s');
    
    // Extract payment method details
    $paymentMethod = '';
    $channelCode = '';
    $paymentMethodData = $paymentData['payment_method'] ?? [];
    
    if (!empty($paymentMethodData)) {
        $paymentMethod = $paymentMethodData['type'] ?? '';
        $channelCode = $paymentMethodData['channel_code'] ?? 
                      ($paymentMethodData['over_the_counter']['channel_code'] ?? '');
    }
    
    // Extract customer info
    $customerId = $paymentData['customer_id'] ?? '';
    $payerEmail = $paymentData['payer_email'] ?? '';
    
    // Extract additional metadata
    $metadata = json_encode($paymentData['metadata'] ?? []);
    $paymentDetail = json_encode($paymentData['payment_detail'] ?? []);
    $channelProperties = json_encode($paymentData['channel_properties'] ?? []);
    
    // Try to find subscription_id from external_id
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
                updated_at = ?,
                payment_method = ?,
                channel_code = ?,
                payment_detail = ?,
                channel_properties = ?
            WHERE xendit_id = ?
        ");
        
        $updatedAt = date('Y-m-d H:i:s');
        
        $stmt->bind_param(
            "sdssssss", 
            $status, 
            $amount, 
            $updatedAt,
            $paymentMethod,
            $channelCode,
            $paymentDetail,
            $channelProperties,
            $xenditId
        );
    } else {
        // Insert new payment
        $stmt = $conn->prepare("
            INSERT INTO payments (
                xendit_id, external_id, amount, currency, status, 
                payment_method, channel_code, payer_email, 
                metadata, payment_detail, channel_properties, 
                created_at, updated_at, subscription_id, user_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param(
            "ssddsssssssssii", 
            $xenditId, 
            $externalId, 
            $amount, 
            $currency, 
            $status,
            $paymentMethod, 
            $channelCode, 
            $payerEmail,
            $metadata, 
            $paymentDetail, 
            $channelProperties,
            $created, 
            $updated, 
            $subscriptionId, 
            $userId
        );
    }
    
    $stmt->execute();
    $stmt->close();
    
    // If payment is successful, update subscription status
    if ($status === 'SUCCEEDED' || $status === 'COMPLETED') {
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
 * Process capture events
 */
function processCaptureEvent($data, $conn) {
    // Similar to processPaymentEvent but for capture-specific data
    processPaymentEvent($data, $conn);
}

/**
 * Process e-wallet events
 */
function processEwalletEvent($data, $conn) {
    // Similar to processPaymentEvent but for e-wallet specific data
    processPaymentEvent($data, $conn);
}

/**
 * Process QR payment events
 */
function processQRPaymentEvent($data, $conn) {
    // Similar to processPaymentEvent but for QR payment specific data
    processPaymentEvent($data, $conn);
}