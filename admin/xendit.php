<?php
// Xendit Payment Script with Single Insertion
require_once '../db.php';

// Set timezone to GMT+8
date_default_timezone_set('Asia/Manila');

// Your Xendit API Key
$apiKey = 'xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha';

// Xendit API endpoint for creating invoices
$endpoint = 'https://api.xendit.co/v2/invoices';

// Generate a unique external ID
$externalId = 'invoice-' . time() . '-' . rand(1000, 9999);

// Payment details
$paymentData = [
    'external_id' => $externalId,
    'amount' => 1000,
    'currency' => 'PHP',
    'payer_email' => 'arcjdatario@gmail.com',
    'description' => 'Test Payment Invoice',
    'success_redirect_url' => 'https://angeleyesolutions.online/success', 
    'failure_redirect_url' => 'https://angeleyesolutions.online/failed',
];

// Initialize cURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($apiKey . ':')
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    exit();
}

$responseData = json_decode($response, true);

if (isset($responseData['invoice_url'])) {
    $invoiceId = $responseData['id'] ?? '';
    
    // Delete any previous records with the same payment_id or external_id
    $deleteStmt = $conn->prepare("DELETE FROM payments WHERE payment_id = ? OR external_id = ?");
    $deleteStmt->bind_param("ss", $invoiceId, $externalId);
    $deleteStmt->execute();
    $deleteStmt->close();
    
    // Extract invoice data
    $amount = $responseData['amount'] ?? 0;
    $currency = $responseData['currency'] ?? 'PHP';
    $status = 'PENDING'; // Always set initial status as PENDING
    $payerEmail = $responseData['payer_email'] ?? '';
    $description = $responseData['description'] ?? '';
    $invoiceUrl = $responseData['invoice_url'] ?? '';
    $expiryDate = $responseData['expiry_date'] ?? '';
    
    // Extract available payment methods
    $availableMethods = [];
    if (isset($responseData['available_banks'])) {
        foreach ($responseData['available_banks'] as $bank) {
            $availableMethods[] = [
                'type' => 'BANK',
                'name' => $bank['name'] ?? '',
                'channel_code' => $bank['bank_code'] ?? ''
            ];
        }
    }
    if (isset($responseData['available_ewallets'])) {
        foreach ($responseData['available_ewallets'] as $ewallet) {
            $availableMethods[] = [
                'type' => 'E-WALLET',
                'name' => $ewallet['name'] ?? '',
                'channel_code' => $ewallet['ewallet_type'] ?? ''
            ];
        }
    }
    if (isset($responseData['available_retail_outlets'])) {
        foreach ($responseData['available_retail_outlets'] as $retail) {
            $availableMethods[] = [
                'type' => 'RETAIL',
                'name' => $retail['name'] ?? '',
                'channel_code' => $retail['retail_outlet_name'] ?? ''
            ];
        }
    }
    if (isset($responseData['available_direct_debits'])) {
        foreach ($responseData['available_direct_debits'] as $debit) {
            $availableMethods[] = [
                'type' => 'DIRECT_DEBIT',
                'name' => $debit['name'] ?? '',
                'channel_code' => $debit['direct_debit_type'] ?? ''
            ];
        }
    }
    
    $availableMethodsJson = json_encode($availableMethods);
    
    // Convert expiry date to GMT+8 format
    $expiryDateFormatted = !empty($expiryDate) ? date('Y-m-d H:i:s', strtotime($expiryDate)) : null;
    
    // Prepare channel properties
    $channelProperties = [
        'invoice_url' => $invoiceUrl,
        'expiry_date' => $expiryDateFormatted
    ];
    
    // Get current time in GMT+8
    $currentTimeGMT8 = date('Y-m-d H:i:s');
    
    // Insert invoice record - only one row
    $stmt = $conn->prepare("
        INSERT INTO payments (
            event_type, payment_id, external_id, amount, currency, status,
            payer_email, payer_country, description, channel_properties, 
            available_payment_methods, created_time_gmt8, updated_time_gmt8
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $channelPropertiesJson = json_encode($channelProperties);
    $eventType = 'invoice.created';
    $payerCountry = 'PH';
    
    $stmt->bind_param(
        "sssdsssssssss", 
        $eventType, 
        $invoiceId, 
        $externalId, 
        $amount, 
        $currency,
        $status,
        $payerEmail, 
        $payerCountry,
        $description, 
        $channelPropertiesJson,
        $availableMethodsJson,
        $currentTimeGMT8,
        $currentTimeGMT8
    );
    
    if ($stmt->execute()) {
        // Redirect to the payment page
        header('Location: ' . $invoiceUrl);
        exit();
    } else {
        echo 'Error storing invoice data: ' . $conn->error;
    }
    
    $stmt->close();
} else {
    echo 'Failed to create invoice. Response: ';
    print_r($responseData);
}

// Close cURL and database connection
curl_close($ch);
$conn->close();
?>