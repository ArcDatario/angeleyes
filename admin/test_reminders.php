<?php
// test_email_automation.php

require_once 'auth_check.php';
require_login();
require_once '../db.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to manually trigger email for a specific subscription
function triggerTestEmail($subscriptionId) {
    global $conn;
    
    // Get the specific subscription
    $query = "
        SELECT s.*, sub.email, sub.full_name, sub.phone, p.plan_name, p.price
        FROM subscriptions s 
        JOIN subscribers sub ON s.user_id = sub.id 
        JOIN plans p ON s.plan_id = p.id
        WHERE s.id = $subscriptionId
    ";
    
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $subscription = $result->fetch_assoc();
        
        try {
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'capstoneproject0101@gmail.com';
            $mail->Password   = 'sgox knuc kool pftq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->setFrom('capstoneproject0101@gmail.com', 'Angel Eyes Internet');
            $mail->addAddress($subscription['email']);
            
            // Format dates
            $startDate = date('M j, Y', strtotime($subscription['started_date']));
            $dueDate = date('M j, Y', strtotime($subscription['due_date']));
            $formattedDueDate = date('m/d/Y', strtotime($subscription['due_date']));
            
            // Get the absolute path to the logo
            $logoPath = realpath(__DIR__ . '/../angeleyes-logo.png');
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'TEST: Angel Eyes Billing Notice';
            
            // Embed the logo directly in the email
            if (file_exists($logoPath)) {
                $mail->AddEmbeddedImage($logoPath, 'logo', 'angeleyes-logo.png');
                $logoHtml = '<img src="cid:logo" alt="Angel Eyes Logo" style="max-width: 200px;">';
            } else {
                $logoHtml = '<h2>Angel Eyes Internet</h2>';
            }
            
            $emailBody = "
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                            max-width: 600px;
                            margin: 0 auto;
                        }
                        .logo-container {
                            text-align: center;
                            margin: 20px 0;
                        }
                        .header {
                            background-color: #f8f9fa;
                            padding: 20px;
                            text-align: center;
                            border-radius: 5px;
                        }
                        .billing-summary {
                            background-color: #f1f8ff;
                            padding: 15px;
                            border-radius: 5px;
                            margin: 20px 0;
                        }
                        .payment-options {
                            background-color: #f8f9fa;
                            padding: 15px;
                            border-radius: 5px;
                            margin: 20px 0;
                        }
                        .footer {
                            margin-top: 30px;
                            padding-top: 20px;
                            border-top: 1px solid #ddd;
                            font-size: 14px;
                            color: #666;
                        }
                        .due-date {
                            color: #dc3545;
                            font-weight: bold;
                        }
                        .test-notice {
                            background-color: #fff3cd;
                            color: #856404;
                            padding: 10px;
                            border-radius: 5px;
                            margin-bottom: 20px;
                            text-align: center;
                            border: 1px solid #ffeaa7;
                        }
                    </style>
                </head>
                <body>
                   
                    
                    <div class='logo-container'>
                        $logoHtml
                    </div>
                    
                    <div class='header'>
                        <h2>Angel Eyes Billing Notice</h2>
                    </div>
                    
                    <p>Dear {$subscription['full_name']},</p>
                    
                    <p>This is a friendly reminder that your internet subscription with Angel Eyes is due for renewal. Please find the billing details below:</p>
                    
                    <div class='billing-summary'>
                        <h3>Billing Summary</h3>
                        <p><strong>Account Name:</strong> {$subscription['full_name']}</p>
                        <p><strong>Subscription Plan:</strong> {$subscription['plan_name']}</p>
                        <p><strong>Reference Number:</strong> {$subscription['reference']}</p>
                        <p><strong>Billing Period:</strong> {$startDate} – {$dueDate}</p>
                        <p><strong>Amount Due:</strong> ₱{$subscription['price']}</p>
                        <p><strong class='due-date'>Due Date:</strong> {$formattedDueDate}</p>
                    </div>
                    
                    <p>To avoid service interruption, kindly settle your payment on or before the due date.</p>
                    
                    <div class='payment-options'>
                        <h3>Payment Options:</h3>
                        <p><strong>Online Payment Portal:</strong> <a href='https://angeleyesolutions.online/payment'>angeleyesolutions.online/payment</a></p>
                    </div>
                    
                    <p>If you have already made your payment, please disregard this notice. For any questions or concerns, feel free to contact us at <a href='mailto:support@angeleyesolutions.online'>support@angeleyesolutions.online</a> or <a href='tel:09123456789'>0912 345 6789</a>.</p>
                    
                    <p>Thank you for choosing Angel Eyes as your trusted internet service provider.</p>
                    
                    <div class='footer'>
                        <p>Best regards,<br>
                        <strong>Billing & Accounts Department</strong><br>
                        Angel Eyes Internet</p>
                    </div>
                </body>
                </html>
            ";
            
            $mail->Body = $emailBody;
            $mail->AltBody = "TEST EMAIL - Angel Eyes Billing Notice

Dear {$subscription['full_name']},

This is a TEST of the billing notice system. Your internet subscription with Angel Eyes is due for renewal.

Billing Summary
- Account Name: {$subscription['full_name']}
- Subscription Plan: {$subscription['plan_name']}
- Reference Number: {$subscription['reference']}
- Billing Period: {$startDate} – {$dueDate}
- Amount Due: ₱{$subscription['price']}
- Due Date: {$formattedDueDate}

To avoid service interruption, kindly settle your payment on or before the due date.

Payment Options:
- Online Payment Portal: https://angeleyesolutions.online/payment

If you have already made your payment, please disregard this notice. For any questions or concerns, feel free to contact us at support@angeleyesolutions.online or 0912 345 6789.

Thank you for choosing Angel Eyes as your trusted internet service provider.

Best regards,
Billing & Accounts Department
Angel Eyes Internet";
            
            if ($mail->send()) {
                // Log this action
                $adminId = $_SESSION['user_id'] ?? 0;
                $logContent = "Manual test billing notice sent to: {$subscription['email']} for subscription {$subscription['reference']}";
                $conn->query("INSERT INTO logs (admin_id, content) VALUES ($adminId, '$logContent')");
                
                return [
                    'success' => true,
                    'message' => "Test billing notice successfully sent to {$subscription['email']}"
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "Failed to send test billing notice to {$subscription['email']}"
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => "Mailer Error: " . $e->getMessage()
            ];
        }
    } else {
        return [
            'success' => false,
            'message' => "Subscription not found with ID: $subscriptionId"
        ];
    }
}

// Handle form submission
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['test_specific'])) {
        $subscriptionId = intval($_POST['subscription_id']);
        $result = triggerTestEmail($subscriptionId);
    } elseif (isset($_POST['run_automation'])) {
        // Run the full automation
        require_once 'email_automation.php';
        $result = sendReminderEmails();
        $result = [
            'success' => true,
            'message' => "Automation ran. Billing notices sent: {$result['emails_sent']}. Check logs for details."
        ];
    }
}

// Get all subscriptions for the dropdown
$subscriptions = [];
$subsQuery = "
    SELECT s.id, s.reference, s.due_date, sub.full_name, sub.email 
    FROM subscriptions s 
    JOIN subscribers sub ON s.user_id = sub.id 
    WHERE s.status = 'Active'
    ORDER BY s.due_date DESC
";
$subsResult = $conn->query($subsQuery);
if ($subsResult && $subsResult->num_rows > 0) {
    while ($row = $subsResult->fetch_assoc()) {
        $subscriptions[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Billing Notice Automation - Angel Eyes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select, input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 4px;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Billing Notice Automation Testing</h1>
        
        <div class="card">
            <h3>Test Specific Subscription</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="subscription_id">Select Subscription:</label>
                    <select id="subscription_id" name="subscription_id" required>
                        <option value="">-- Select a Subscription --</option>
                        <?php foreach ($subscriptions as $sub): ?>
                            <option value="<?= $sub['id'] ?>">
                                <?= $sub['reference'] ?> - <?= $sub['full_name'] ?> (Due: <?= $sub['due_date'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" name="test_specific" class="btn-primary">Send Test Billing Notice</button>
            </form>
        </div>
        
        <div class="card">
            <h3>Run Full Automation</h3>
            <p>This will check all subscriptions due in 7 days and send billing notices.</p>
            <form method="POST" action="">
                <button type="submit" name="run_automation" class="btn-success">Run Full Automation Now</button>
            </form>
        </div>
        
        <div class="card">
            <h3>Quick Setup for Testing</h3>
            <p>To test the automation, follow these steps:</p>
            <ol>
                <li>Find a subscription in the table below</li>
                <li>Update its due date to exactly 7 days from now:
                    <pre>UPDATE subscriptions SET due_date = DATE_ADD(NOW(), INTERVAL 7 DAY) WHERE id = [subscription_id];</pre>
                </li>
                <li>Use the "Run Full Automation Now" button above</li>
                <li>Or select the subscription and use "Send Test Billing Notice"</li>
            </ol>
        </div>
        
        <?php if ($result): ?>
            <div class="result <?= $result['success'] ? 'success' : 'error' ?>">
                <strong><?= $result['success'] ? 'Success!' : 'Error!' ?></strong>
                <?= $result['message'] ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <h3>All Active Subscriptions</h3>
            <div style="max-height: 400px; overflow-y: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reference</th>
                            <th>Subscriber</th>
                            <th>Due Date</th>
                            <th>Days Until Due</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscriptions as $sub): 
                            $dueDate = new DateTime($sub['due_date']);
                            $now = new DateTime();
                            $interval = $now->diff($dueDate);
                            $daysUntilDue = $interval->format('%r%a');
                        ?>
                            <tr>
                                <td><?= $sub['id'] ?></td>
                                <td><?= $sub['reference'] ?></td>
                                <td><?= $sub['full_name'] ?></td>
                                <td><?= $sub['due_date'] ?></td>
                                <td>
                                    <span class="<?= $daysUntilDue <= 7 ? 'text-danger' : '' ?>">
                                        <?= $daysUntilDue ?> days
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="subscription_id" value="<?= $sub['id'] ?>">
                                        <button type="submit" name="test_specific" class="btn-primary" style="padding: 5px 10px; font-size: 14px;">
                                            Test This
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>