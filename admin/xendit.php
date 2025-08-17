<?php
// Xendit Payment Test Script

// Your Xendit API Key
$apiKey = 'xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha';

// Xendit API endpoint for creating invoices
$endpoint = 'https://api.xendit.co/v2/invoices';

// Payment details
$paymentData = [
    'external_id' => 'test-invoice-' . time(), // Unique ID for the invoice
    'amount' => 10, // Amount in IDR (100,000 IDR in this example)
    'payer_email' => 'arcjdatario@gmail.com',
    'description' => 'Test Payment Invoice',
    'success_redirect_url' => 'https://yourwebsite.com/success', // Redirect after successful payment
    'failure_redirect_url' => 'https://yourwebsite.com/failed'  // Redirect after failed payment
];

// Initialize cURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($apiKey . ':') // Xendit uses Basic Auth with API key
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
        // Redirect to the payment page
        header('Location: ' . $responseData['invoice_url']);
        exit();
    } else {
        // Display error if invoice creation failed
        echo 'Failed to create invoice. Response: ';
        print_r($responseData);
    }
}

// Close cURL
curl_close($ch);
?>