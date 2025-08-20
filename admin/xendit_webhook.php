<?php
// Xendit Webhook Handler - Complete Payment Method Capture

// Include database connection
require_once '../db.php';

// Set timezone to GMT+8
date_default_timezone_set('Asia/Manila');

// Xendit webhook token
$webhookToken = '9uz7HZwDcrXCNLcdsJO5JU0OVYWreOjPGWrfnJCn2XZ5p1KL';

// Get the raw input
$input = file_get_contents('php://input');
$headers = getallheaders();

// Verify the webhook token
if (!isset($headers['X-Callback-Token']) || $headers['X-Callback-Token'] !== $webhookToken) {
    http_response_code(401);
    echo 'Unauthorized: Invalid webhook token';
    exit();
}

// Decode the JSON data
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo 'Invalid JSON data';
    exit();
}

// Check if this is a payment event we want to handle
$validEvents = [
    'payment.succeeded',
    'payment.failed',
    'payment.awaiting_capture',
    'capture.succeeded',
    'capture.failed',
    'invoice.paid',
    'invoice.expired',
    'invoice.created'
];

if (!isset($data['event']) || !in_array($data['event'], $validEvents)) {
    http_response_code(400);
    echo 'Unhandled event type: ' . ($data['event'] ?? 'unknown');
    exit();
}

// Process the event
try {
    $eventType = $data['event'];
    $paymentData = $data['data'];
    
    // Extract identifier
    $identifier = $paymentData['id'] ?? $paymentData['reference_id'] ?? $paymentData['external_id'] ?? '';
    
    if (empty($identifier)) {
        throw new Exception("No valid identifier found in webhook data");
    }
    
    // Check if payment already exists
    $checkStmt = $conn->prepare("SELECT id, external_id, payment_id FROM payments WHERE payment_id = ? OR external_id = ?");
    $checkStmt->bind_param("ss", $identifier, $identifier);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $existingPayment = $result->fetch_assoc();
    $checkStmt->close();
    
    // If it's an invoice.created event and we already have a record, skip creating a new one
    if ($eventType === 'invoice.created' && $existingPayment) {
        http_response_code(200);
        echo 'Invoice already exists, skipping creation';
        exit();
    }
    
    // Extract payment information
    $paymentId = $paymentData['id'] ?? ($existingPayment['payment_id'] ?? '');
    $paymentRequestId = $paymentData['payment_request_id'] ?? '';
    $externalId = $paymentData['reference_id'] ?? $paymentData['external_id'] ?? ($existingPayment['external_id'] ?? '');
    $amount = $paymentData['amount'] ?? $paymentData['captured_amount'] ?? 0;
    $authorizedAmount = $paymentData['authorized_amount'] ?? NULL;
    $capturedAmount = $paymentData['captured_amount'] ?? NULL;
    $currency = $paymentData['currency'] ?? 'PHP';
    $status = $paymentData['status'] ?? '';
    $referenceId = $paymentData['reference_id'] ?? '';
    $payerEmail = $paymentData['payer_email'] ?? '';
    $description = $paymentData['description'] ?? '';
    $failureCode = $paymentData['failure_code'] ?? '';
    $failureMessage = $paymentData['failure_message'] ?? '';
    
    // Extract payment method details
    $paymentMethodType = '';
    $paymentMethodId = '';
    $paymentMethod = '';
    $channelCode = '';
    $channelName = '';
    $reusability = '';
    $methodStatus = '';
    $accountDetails = '';
    
    // Card payment details
    $cardTokenId = '';
    $maskedCardNumber = '';
    $cardholderName = '';
    $expiryMonth = '';
    $expiryYear = '';
    $cardType = '';
    $cardNetwork = '';
    $cardCountry = '';
    $cardIssuer = '';
    $cardFingerprint = '';
    $threeDSecureFlow = '';
    $eciCode = '';
    $threeDSecureResult = '';
    $threeDSecureVersion = '';
    $cvvResult = '';
    $addressVerificationResult = '';
    
    // Extract payment method details
    if (isset($paymentData['payment_method'])) {
        $pm = $paymentData['payment_method'];
        
        // Extract basic payment method info
        $paymentMethodType = $pm['type'] ?? '';
        $paymentMethodId = $pm['id'] ?? '';
        $reusability = $pm['reusability'] ?? '';
        $methodStatus = $pm['status'] ?? '';
        
        // Extract channel code based on payment method type
        switch ($paymentMethodType) {
            case 'OVER_THE_COUNTER':
                $channelCode = $pm['channel_code'] ?? ($pm['over_the_counter']['channel_code'] ?? '');
                $channelName = 'Over the Counter - ' . $channelCode;
                $paymentMethod = 'Over the Counter';
                break;
                
            case 'CARD':
                $channelCode = 'CARDS';
                $channelName = 'Credit/Debit Card';
                $paymentMethod = 'Credit/Debit Card';
                
                // Extract card details
                if (isset($pm['card_information'])) {
                    $cardInfo = $pm['card_information'];
                    $cardTokenId = $cardInfo['token_id'] ?? '';
                    $maskedCardNumber = $cardInfo['masked_card_number'] ?? '';
                    $cardholderName = $cardInfo['cardholder_name'] ?? '';
                    $expiryMonth = $cardInfo['expiry_month'] ?? '';
                    $expiryYear = $cardInfo['expiry_year'] ?? '';
                    $cardType = $cardInfo['type'] ?? '';
                    $cardNetwork = $cardInfo['network'] ?? '';
                    $cardCountry = $cardInfo['country'] ?? '';
                    $cardIssuer = $cardInfo['issuer'] ?? '';
                    $cardFingerprint = $cardInfo['fingerprint'] ?? '';
                }
                
                // Extract card verification results
                if (isset($pm['card_verification_results'])) {
                    $verification = $pm['card_verification_results'];
                    
                    if (isset($verification['three_d_secure'])) {
                        $threeDSecure = $verification['three_d_secure'];
                        $threeDSecureFlow = $threeDSecure['three_d_secure_flow'] ?? '';
                        $eciCode = $threeDSecure['eci_code'] ?? '';
                        $threeDSecureResult = $threeDSecure['three_d_secure_result'] ?? '';
                        $threeDSecureVersion = $threeDSecure['three_d_secure_version'] ?? '';
                    }
                    
                    $cvvResult = $verification['cvv_result'] ?? '';
                    $addressVerificationResult = $verification['address_verification_result'] ?? '';
                }
                break;
                
            case 'EWALLET':
                $channelCode = $pm['channel_code'] ?? ($pm['ewallet']['channel_code'] ?? '');
                $channelName = 'E-Wallet - ' . $channelCode;
                $paymentMethod = 'E-Wallet';
                
                if (isset($pm['ewallet']['account'])) {
                    $accountDetails = json_encode(['account' => $pm['ewallet']['account']]);
                }
                break;
                
            case 'BANK_TRANSFER':
            case 'DIRECT_BANK_TRANSFER':
                $channelCode = $pm['channel_code'] ?? ($pm['bank_transfer']['bank_code'] ?? $pm['direct_bank_transfer']['bank_code'] ?? '');
                $channelName = 'Bank Transfer - ' . $channelCode;
                $paymentMethod = 'Bank Transfer';
                
                if (isset($pm['bank_transfer']['account_number'])) {
                    $accountDetails = json_encode(['account_number' => $pm['bank_transfer']['account_number']]);
                } elseif (isset($pm['direct_bank_transfer']['account_number'])) {
                    $accountDetails = json_encode(['account_number' => $pm['direct_bank_transfer']['account_number']]);
                }
                break;
                
            case 'DIRECT_DEBIT':
                $channelCode = $pm['channel_code'] ?? ($pm['direct_debit']['channel_code'] ?? '');
                $channelName = 'Direct Debit - ' . $channelCode;
                $paymentMethod = 'Direct Debit';
                break;
                
            case 'QR_CODE':
                $channelCode = $pm['channel_code'] ?? ($pm['qr_code']['channel_code'] ?? '');
                $channelName = 'QR Code - ' . $channelCode;
                $paymentMethod = 'QR Code';
                break;
                
            case 'VIRTUAL_ACCOUNT':
                $channelCode = $pm['channel_code'] ?? ($pm['virtual_account']['bank_code'] ?? '');
                $channelName = 'Virtual Account - ' . $channelCode;
                $paymentMethod = 'Virtual Account';
                
                if (isset($pm['virtual_account']['account_number'])) {
                    $accountDetails = json_encode(['account_number' => $pm['virtual_account']['account_number']]);
                }
                break;
                
            default:
                $paymentMethod = $paymentMethodType;
                $channelName = $paymentMethodType;
                $channelCode = $paymentMethodType;
                break;
        }
    }
    
    // Extract country information
    $payerCountry = $paymentData['country'] ?? 'PH';
    
    // Extract metadata and other properties
    $metadata = isset($paymentData['metadata']) ? json_encode($paymentData['metadata']) : '';
    
    // Extract channel properties based on payment method type
    $channelProperties = '';
    if (isset($paymentData['channel_properties'])) {
        $channelProperties = json_encode($paymentData['channel_properties']);
    } elseif (isset($paymentData['payment_method']['channel_properties'])) {
        $channelProperties = json_encode($paymentData['payment_method']['channel_properties']);
    }
    
    $paymentDetail = isset($paymentData['payment_detail']) ? json_encode($paymentData['payment_detail']) : '';
    
    // Extract settlement information
    $settlementStatus = $paymentData['settlement_status'] ?? NULL;
    $settlementTime = NULL;
    if (isset($paymentData['settlement_time'])) {
        $settlementTime = date('Y-m-d H:i:s', strtotime($paymentData['settlement_time']));
    }
    
    // Get current time in GMT+8
    $currentTimeGMT8 = date('Y-m-d H:i:s');
    
    // Handle created/updated dates from webhook
    $createdTime = $currentTimeGMT8;
    $updatedTime = $currentTimeGMT8;
    
    if (isset($paymentData['created'])) {
        $createdTime = date('Y-m-d H:i:s', strtotime($paymentData['created']));
    }
    
    if (isset($paymentData['updated'])) {
        $updatedTime = date('Y-m-d H:i:s', strtotime($paymentData['updated']));
    }
    
    // Business ID
    $businessId = $data['business_id'] ?? '';
    
    if ($existingPayment) {
        // Update existing payment
        $stmt = $conn->prepare("
            UPDATE payments 
            SET event_type = ?, payment_request_id = ?, status = ?, amount = ?, authorized_amount = ?, captured_amount = ?, 
                currency = ?, failure_code = ?, failure_message = ?, payment_method_type = ?, payment_method = ?, 
                payment_method_id = ?, channel_code = ?, channel_name = ?, reusability = ?, method_status = ?,
                card_token_id = ?, masked_card_number = ?, cardholder_name = ?, expiry_month = ?, expiry_year = ?,
                card_type = ?, card_network = ?, card_country = ?, card_issuer = ?, card_fingerprint = ?,
                three_d_secure_flow = ?, eci_code = ?, three_d_secure_result = ?, three_d_secure_version = ?,
                cvv_result = ?, address_verification_result = ?, account_details = ?, payer_email = ?, 
                payer_country = ?, description = ?, metadata = ?, channel_properties = ?, payment_detail = ?, 
                updated_time_gmt8 = ?, settlement_status = ?, settlement_time_gmt8 = ?, business_id = ?
            WHERE id = ?
        ");
        
        $stmt->bind_param(
            "sssdddsdssssssssssssssssssssssssssssssssssssi", 
            $eventType, 
            $paymentRequestId,
            $status, 
            $amount,
            $authorizedAmount,
            $capturedAmount,
            $currency,
            $failureCode,
            $failureMessage,
            $paymentMethodType,
            $paymentMethod,
            $paymentMethodId,
            $channelCode,
            $channelName,
            $reusability,
            $methodStatus,
            $cardTokenId,
            $maskedCardNumber,
            $cardholderName,
            $expiryMonth,
            $expiryYear,
            $cardType,
            $cardNetwork,
            $cardCountry,
            $cardIssuer,
            $cardFingerprint,
            $threeDSecureFlow,
            $eciCode,
            $threeDSecureResult,
            $threeDSecureVersion,
            $cvvResult,
            $addressVerificationResult,
            $accountDetails,
            $payerEmail,
            $payerCountry,
            $description,
            $metadata, 
            $channelProperties, 
            $paymentDetail, 
            $updatedTime,
            $settlementStatus,
            $settlementTime,
            $businessId,
            $existingPayment['id']
        );
        
        $stmt->execute();
        $stmt->close();
    } else {
        // Only insert new payment if it's not an invoice.created event (which should be handled by xendit.php)
        if ($eventType !== 'invoice.created') {
            // Insert new payment
            $stmt = $conn->prepare("
                INSERT INTO payments (
                    event_type, payment_id, payment_request_id, external_id, amount, authorized_amount, captured_amount, 
                    currency, status, failure_code, failure_message, payment_method_type, payment_method, payment_method_id, 
                    channel_code, channel_name, reusability, method_status, card_token_id, masked_card_number, 
                    cardholder_name, expiry_month, expiry_year, card_type, card_network, card_country, card_issuer, 
                    card_fingerprint, three_d_secure_flow, eci_code, three_d_secure_result, three_d_secure_version, 
                    cvv_result, address_verification_result, account_details, reference_id, payer_email, payer_country, 
                    description, metadata, channel_properties, payment_detail, created_time_gmt8, updated_time_gmt8, 
                    settlement_status, settlement_time_gmt8, business_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->bind_param(
                "ssssddddssdssssssssssssssssssssssssssssssssssssss", 
                $eventType, 
                $paymentId,
                $paymentRequestId,
                $externalId, 
                $amount,
                $authorizedAmount,
                $capturedAmount,
                $currency, 
                $status,
                $failureCode,
                $failureMessage,
                $paymentMethodType,
                $paymentMethod,
                $paymentMethodId,
                $channelCode,
                $channelName,
                $reusability,
                $methodStatus,
                $cardTokenId,
                $maskedCardNumber,
                $cardholderName,
                $expiryMonth,
                $expiryYear,
                $cardType,
                $cardNetwork,
                $cardCountry,
                $cardIssuer,
                $cardFingerprint,
                $threeDSecureFlow,
                $eciCode,
                $threeDSecureResult,
                $threeDSecureVersion,
                $cvvResult,
                $addressVerificationResult,
                $accountDetails,
                $referenceId,
                $payerEmail,
                $payerCountry,
                $description, 
                $metadata, 
                $channelProperties, 
                $paymentDetail,
                $createdTime,
                $updatedTime,
                $settlementStatus,
                $settlementTime,
                $businessId
            );
            
            $stmt->execute();
            $stmt->close();
        }
    }
    
    // Success response
    http_response_code(200);
    echo 'Webhook processed successfully';
    
} catch (Exception $e) {
    http_response_code(500);
    error_log('Error processing webhook: ' . $e->getMessage());
    echo 'Error processing webhook: ' . $e->getMessage();
}

// Close connection
$conn->close();
?>