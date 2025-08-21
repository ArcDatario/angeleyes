<?php
// Xendit Payment Script - Only creates invoice, doesn't insert record

// Include database connection
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
    'success_redirect_url' => 'https://angeleyesolutions.online/success.php?external_id=' . $externalId, 
    'failure_redirect_url' => 'https://angeleyesolutions.online/failed.php',
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
} else {
    $responseData = json_decode($response, true);
    
    if (isset($responseData['invoice_url'])) {
        // Redirect to the payment page - NO DATABASE INSERTION HERE
        header('Location: ' . $responseData['invoice_url']);
        exit();
    } else {
        echo 'Failed to create invoice. Response: ';
        print_r($responseData);
    }
}

// Close cURL and database connection
curl_close($ch);
$conn->close();
?>