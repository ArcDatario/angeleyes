<?php
// xendit_webhook.php
include "db.php"; // your DB connection

// Verify token
$headers = getallheaders();
if (!isset($headers['X-CALLBACK-TOKEN']) || $headers['X-CALLBACK-TOKEN'] !== "9uz7HZwDcrXCNLcdsJO5JU0OVYWreOjPGWrfnJCn2XZ5p1KL") {
    http_response_code(403);
    echo json_encode(["error" => "Invalid token"]);
    exit;
}

// Get raw input
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON"]);
    exit;
}

// Only insert on success
if (isset($data['event']) && $data['event'] === "payment.succeeded") {
    $p = $data['data'];

    $xendit_id = $p['id'] ?? null;
    $external_id = $p['reference_id'] ?? null; // treat reference_id as external_id
    $reference_id = $p['reference_id'] ?? null;
    $business_id = $data['business_id'] ?? null;
    $payment_request_id = $p['payment_request_id'] ?? null;
    $customer_id = $p['customer_id'] ?? null;
    $amount = $p['amount'] ?? 0;
    $currency = $p['currency'] ?? "PHP";
    $status = $p['status'] ?? null;
    $payment_method = $p['payment_method']['type'] ?? null;
    $channel_code = $p['payment_method']['over_the_counter']['channel_code'] ?? null;
    $description = $p['description'] ?? null;
    $payer_email = null; // not provided in sample
    $failure_code = $p['failure_code'] ?? null;
    $metadata = json_encode($p['metadata'] ?? []);
    $payment_detail = null;
    $channel_properties = json_encode($p['payment_method']['over_the_counter']['channel_properties'] ?? []);
    $created_at = date("Y-m-d H:i:s", strtotime($p['created']));
    $updated_at = date("Y-m-d H:i:s", strtotime($p['updated'] ?? $p['created']));

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO payments 
        (xendit_id, external_id, reference_id, business_id, payment_request_id, customer_id, amount, currency, status, payment_method, channel_code, description, payer_email, failure_code, metadata, payment_detail, channel_properties, created_at, updated_at) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param(
        "ssssssdssssssssssss",
        $xendit_id,
        $external_id,
        $reference_id,
        $business_id,
        $payment_request_id,
        $customer_id,
        $amount,
        $currency,
        $status,
        $payment_method,
        $channel_code,
        $description,
        $payer_email,
        $failure_code,
        $metadata,
        $payment_detail,
        $channel_properties,
        $created_at,
        $updated_at
    );

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
} else {
    http_response_code(200);
    echo json_encode(["message" => "Event ignored"]);
}
