<?php
// success.php - Handle successful payments and insert record

// Include database connection
require_once '../db.php';

// Set timezone to GMT+8
date_default_timezone_set('Asia/Manila');

// Check if external_id is provided
if (!isset($_GET['external_id']) || empty($_GET['external_id'])) {
    die('Invalid payment reference');
}

$externalId = $_GET['external_id'];

// Check if this payment already exists in database to prevent duplicates
$checkStmt = $conn->prepare("SELECT id FROM payments WHERE external_id = ?");
$checkStmt->bind_param("s", $externalId);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // Payment already exists, just show success message
    echo '<h1>Payment Successful</h1>';
    echo '<p>Thank you for your payment. Your transaction has been completed successfully.</p>';
    $checkStmt->close();
    $conn->close();
    exit();
}

$checkStmt->close();

// If payment doesn't exist, create a basic record
// Note: More details will be added by the webhook later
$currentTimeGMT8 = date('Y-m-d H:i:s');
$status = 'PENDING'; // Will be updated by webhook

$stmt = $conn->prepare("
    INSERT INTO payments (
        event_type, external_id, status, created_time_gmt8, updated_time_gmt8
    ) VALUES (?, ?, ?, ?, ?)
");

$eventType = 'payment.redirect_success';

$stmt->bind_param(
    "sssss", 
    $eventType, 
    $externalId, 
    $status,
    $currentTimeGMT8,
    $currentTimeGMT8
);

if ($stmt->execute()) {
    echo '<h1>Payment Successful</h1>';
    echo '<p>Thank you for your payment. Your transaction has been completed successfully.</p>';
    echo '<p>Your payment reference: ' . htmlspecialchars($externalId) . '</p>';
} else {
    echo '<h1>Payment Successful</h1>';
    echo '<p>Thank you for your payment. There was a minor issue recording your transaction, but your payment was successful.</p>';
    echo '<p>Please keep this reference number: ' . htmlspecialchars($externalId) . '</p>';
    error_log('Error storing payment data: ' . $conn->error);
}

$stmt->close();
$conn->close();
?>