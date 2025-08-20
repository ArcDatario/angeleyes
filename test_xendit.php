<?php
// test_xendit.php
require_once 'db.php';

class XenditPayment {
    private $apiKey;
    private $baseUrl = 'https://api.xendit.co';
    private $conn;

    public function __construct($apiKey, $conn) {
        $this->apiKey = $apiKey;
        $this->conn = $conn;
    }

    public function createPaymentRequest($amount, $referenceId, $customerName, $channelCode = 'INDOMARET') {
        $paymentData = [
            'reference_id' => $referenceId,
            'amount' => $amount,
            'currency' => 'IDR',
            'payment_method' => [
                'type' => 'OVER_THE_COUNTER',
                'reusability' => 'ONE_TIME_USE',
                'over_the_counter' => [
                    'channel_code' => $channelCode
                ]
            ],
            'customer' => [
                'given_names' => $customerName,
                'surname' => 'Customer',
                'email' => $customerName . 'datarioarc@gmail.com',
                'mobile_number' => '+639686409348'
            ],
            'metadata' => [
                'test' => 'true'
            ]
        ];

        $ch = curl_init($this->baseUrl . '/payment_requests');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->apiKey . ':')
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return json_decode($response, true);
        } else {
            error_log("Xendit API Error: HTTP $httpCode - $response");
            return null;
        }
    }

    public function insertPayment($paymentData, $eventType) {
        $xenditPaymentId = $paymentData['id'] ?? '';
        $paymentRequestId = $paymentData['payment_request_id'] ?? '';
        $referenceId = $paymentData['reference_id'] ?? '';
        $amount = $paymentData['amount'] ?? 0;
        $status = $paymentData['status'] ?? '';
        $country = $paymentData['country'] ?? '';
        $customerId = $paymentData['customer_id'] ?? '';
        $description = $paymentData['description'] ?? '';
        $failureCode = $paymentData['failure_code'] ?? '';
        
        $paymentMethodType = $paymentData['payment_method']['type'] ?? '';
        $paymentMethodId = $paymentData['payment_method']['id'] ?? '';
        $customerName = $paymentData['payment_method']['over_the_counter']['channel_properties']['customer_name'] ?? '';
        
        $metadata = isset($paymentData['metadata']) ? json_encode($paymentData['metadata']) : '';
        $channelProperties = isset($paymentData['channel_properties']) ? json_encode($paymentData['channel_properties']) : '';
        $paymentDetail = isset($paymentData['payment_detail']) ? json_encode($paymentData['payment_detail']) : '';
        
        $created = date('Y-m-d H:i:s', strtotime($paymentData['created']));
        $updated = date('Y-m-d H:i:s', strtotime($paymentData['updated']));
        
        $expiresAt = '';
        if (isset($paymentData['payment_method']['over_the_counter']['channel_properties']['expires_at'])) {
            $expiresAt = date('Y-m-d H:i:s', strtotime($paymentData['payment_method']['over_the_counter']['channel_properties']['expires_at']));
        }
        
        $capturedAmount = $paymentData['captured_amount'] ?? 0;
        $authorizedAmount = $paymentData['authorized_amount'] ?? 0;

        $stmt = $this->conn->prepare("INSERT INTO payments (
            xendit_payment_id, payment_request_id, reference_id, amount, currency, status, country, 
            event_type, payment_method_type, payment_method_id, customer_name, customer_id, 
            description, failure_code, metadata, channel_properties, payment_detail, 
            created_at, updated_at, expires_at, captured_amount, authorized_amount
        ) VALUES (?, ?, ?, ?, 'IDR', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssdssssssssssssssssdd", 
            $xenditPaymentId, $paymentRequestId, $referenceId, $amount, $status, $country, 
            $eventType, $paymentMethodType, $paymentMethodId, $customerName, $customerId, 
            $description, $failureCode, $metadata, $channelProperties, $paymentDetail, 
            $created, $updated, $expiresAt, $capturedAmount, $authorizedAmount
        );

        return $stmt->execute();
    }
}

// Initialize Xendit Payment
$xendit = new XenditPayment("xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha", $conn);

// Handle form submission
$message = '';
$paymentDetails = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = intval($_POST['amount']);
    $customerName = trim($_POST['customer_name']);
    $channelCode = $_POST['channel_code'];
    
    if ($amount > 0 && !empty($customerName)) {
        $referenceId = 'test_ref_' . uniqid();
        $paymentDetails = $xendit->createPaymentRequest($amount, $referenceId, $customerName, $channelCode);
        
        if ($paymentDetails) {
            $message = "Payment request created successfully!";
        } else {
            $message = "Failed to create payment request. Please check the error logs.";
        }
    } else {
        $message = "Please provide valid amount and customer name.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xendit Payment Test</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 30px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .card h2 {
            color: #6a11cb;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        
        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
        }
        
        button {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 14px 25px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: block;
            width: 100%;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .payment-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            font-family: monospace;
            white-space: pre-wrap;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .instructions {
            background-color: #e8f4fd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #2196F3;
        }
        
        .instructions h3 {
            color: #2196F3;
            margin-bottom: 15px;
        }
        
        .instructions ol {
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 10px;
        }
        
        .channel-codes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .channel-code {
            background: #f0f5ff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #d9e4ff;
        }
        
        .channel-code h4 {
            color: #6a11cb;
            margin-bottom: 5px;
        }
        
        .webhook-info {
            background-color: #fff4e6;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #ffa94d;
        }
        
        .webhook-info h3 {
            color: #e67700;
            margin-bottom: 15px;
        }
        
        .token {
            background-color: #495057;
            color: #20c997;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            word-break: break-all;
            margin: 10px 0;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #777;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            header {
                padding: 20px 15px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .channel-codes {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Xendit Payment Integration</h1>
            <p class="subtitle">Test payment integration with Xendit API</p>
        </header>
        
        <div class="card">
            <h2>Create Test Payment</h2>
            
            <?php if (!empty($message)): ?>
                <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="amount">Amount (IDR)</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount" value="15000" required>
                </div>
                
                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name" placeholder="Enter customer name" value="John Doe" required>
                </div>
                
                <div class="form-group">
                    <label for="channel_code">Payment Channel</label>
                    <select id="channel_code" name="channel_code" required>
                        <option value="INDOMARET">INDOMARET</option>
                        <option value="ALFAMART">ALFAMART</option>
                        <option value="7ELEVEN">7ELEVEN</option>
                    </select>
                </div>
                
                <button type="submit">Create Payment Request</button>
            </form>
            
            <div class="instructions">
                <h3>Testing Instructions</h3>
                <ol>
                    <li>Fill in the amount and customer name</li>
                    <li>Select a payment channel (Indomaret, Alfamart, or 7Eleven)</li>
                    <li>Click "Create Payment Request" to generate a test payment</li>
                    <li>Use the Xendit dashboard to simulate different payment statuses</li>
                    <li>Check the webhook response below to see payment details</li>
                </ol>
            </div>
            
            <div class="webhook-info">
                <h3>Webhook Configuration</h3>
                <p>Your webhook token has been integrated for secure webhook processing.</p>
                <p>Webhook Token: <span class="token">9uz7HZwDcrXCNLcdsJO5JU0OVYWreOjPGWrfnJCn2XZ5p1KL</span></p>
                <p>Make sure to configure your Xendit webhooks to point to: <strong>https://yourdomain.com/xendit_webhook.php</strong></p>
            </div>
        </div>
        
        <?php if ($paymentDetails): ?>
        <div class="card">
            <h2>Payment Response</h2>
            <div class="payment-details">
                <?php echo json_encode($paymentDetails, JSON_PRETTY_PRINT); ?>
            </div>
            
            <?php if (isset($paymentDetails['actions'])): ?>
            <div class="instructions">
                <h3>Payment Instructions</h3>
                <?php foreach ($paymentDetails['actions'] as $action): ?>
                    <p><strong><?php echo ucfirst(str_replace('_', ' ', $action['action'])); ?>:</strong> 
                    <?php echo $action['url']; ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="card">
            <h2>Available Channel Codes</h2>
            <div class="channel-codes">
                <div class="channel-code">
                    <h4>INDOMARET</h4>
                    <p>Indonesia</p>
                </div>
                <div class="channel-code">
                    <h4>ALFAMART</h4>
                    <p>Indonesia</p>
                </div>
                <div class="channel-code">
                    <h4>7ELEVEN</h4>
                    <p>Philippines</p>
                </div>
            </div>
        </div>
        
        <footer>
            <p>Xendit Payment Integration Test &copy; <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>