<?php
// test_xendit.php
$webhookUrl = "http://localhost/xendit_webhook.php"; // change to your actual URL
$token = "9uz7HZwDcrXCNLcdsJO5JU0OVYWreOjPGWrfnJCn2XZ5p1KL";

// Example payload (from your xendit_response.txt)
$payload = '{
    "event": "payment.succeeded",
    "business_id": "sample_business_id",
    "created": "2022-02-16T06:01:09.997108276Z",
    "data": {
        "id": "pymt-2e9badf8-1473-4e8a-a1cf-d1e3214afc0f",
        "amount": 15000,
        "country": "ID",
        "created": "2022-02-16T06:01:07.322974428Z",
        "currency": "IDR",
        "payment_request_id": "pr-df560c7d-b059-4789-ad2f-3cee5d8230a8",
        "reference_id": "a5151a05-e84d-4cef-bb17-1ref3e7fb3a",
        "status": "SUCCEEDED",
        "customer_id": null,
        "description": "Test payment",
        "payment_method": {
            "id": "pm-e12563a5-a970-4fff-ba3b-242cs0443db7",
            "type": "OVER_THE_COUNTER",
            "over_the_counter": {
                "channel_code": "INDOMARET",
                "channel_properties": {
                    "customer_name": "John Doe",
                    "payment_code": "XENVCQKCUBNRQ"
                }
            }
        },
        "metadata": {
            "key": "value"
        },
        "failure_code": null
    }
}';

// Send the request
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-CALLBACK-TOKEN: ' . $token
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo "Response: " . $response;
}
curl_close($ch);
