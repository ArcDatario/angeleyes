
<?php
// File: ajax/crud_subscription.php
header('Content-Type: application/json');
require_once '../../db.php';
require_once '../../admin/auth_check.php'; // Add this line
require_once 'log_helper.php'; // Add this line

/**
 * Normalize a user-supplied date string into MySQL 'Y-m-d' format.
 * Accepts a few common formats and falls back to strtotime.
 * Returns formatted date string on success, false on invalid input.
 */
function normalize_date($dateStr)
{
    $dateStr = trim((string)$dateStr);
    if ($dateStr === '') {
        return false;
    }

    $formats = ['Y-m-d', 'm/d/Y', 'd/m/Y', 'd-m-Y', 'm-d-Y', 'Y/m/d'];
    foreach ($formats as $fmt) {
        $d = DateTime::createFromFormat($fmt, $dateStr);
        if ($d && $d->format($fmt) === $dateStr) {
            return $d->format('Y-m-d');
        }
    }

    // Try a generic parse as last resort
    $ts = strtotime($dateStr);
    if ($ts !== false) {
        return date('Y-m-d', $ts);
    }

    return false;
}

try {
    $action = $_POST['action'] ?? '';

    // CREATE/UPDATE SUBSCRIPTION
    if ($action === 'save_subscription') {
        $id = $_POST['id'] ?? 0;
        $user_id = (int)$_POST['user_id'];
        $plan_id = (int)$_POST['plan_id'];
        $reference = trim($_POST['reference']);
        $address = trim($_POST['address']);
    $started_date_raw = $_POST['started_date'] ?? '';
    $due_date_raw = $_POST['due_date'] ?? '';
        $status = $_POST['status'] ?? 'Active';

        // Normalize dates and validate
        $started_date = normalize_date($started_date_raw);
        $due_date = normalize_date($due_date_raw);

        if (empty($user_id) || empty($plan_id) || empty($address) || !$started_date || !$due_date) {
            throw new Exception('All fields are required and dates must be valid (e.g. YYYY-MM-DD or MM/DD/YYYY)');
        }

        // Get subscriber and plan details for logging
        $subscriber = $conn->query("SELECT user_id, full_name FROM subscribers WHERE id = $user_id")->fetch_assoc();
        $plan = $conn->query("SELECT plan_name, price FROM plans WHERE id = $plan_id")->fetch_assoc();

        if (!$subscriber) {
            throw new Exception('Subscriber not found');
        }
        if (!$plan) {
            throw new Exception('Plan not found');
        }

        // Get old data for update log
        $old_data = [];
        if ($id > 0) {
            $old_data_result = $conn->query("SELECT * FROM subscriptions WHERE id = $id");
            $old_data = $old_data_result->fetch_assoc();
        }

        if ($id > 0) { // Update
            $stmt = $conn->prepare("UPDATE subscriptions SET 
                plan_id = ?, 
                address = ?, 
                started_date = ?, 
                due_date = ?, 
                status = ? 
                WHERE id = ?");
            $stmt->bind_param("issssi", $plan_id, $address, $started_date, $due_date, $status, $id);
        } else { // Insert
            $stmt = $conn->prepare("INSERT INTO subscriptions (
                user_id, 
                plan_id, 
                reference, 
                address, 
                started_date, 
                due_date, 
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssss", $user_id, $plan_id, $reference, $address, $started_date, $due_date, $status);
        }

        if (!$stmt->execute()) {
            throw new Exception('Failed to save subscription');
        }

        $subscription_id = $id > 0 ? $id : $stmt->insert_id;
        
        // Add detailed log entry
        if ($id > 0) {
            $changes = [];
            if ($old_data['plan_id'] != $plan_id) {
                $old_plan = $conn->query("SELECT plan_name, price FROM plans WHERE id = {$old_data['plan_id']}")->fetch_assoc();
                $changes[] = "plan: {$old_plan['plan_name']} (₱{$old_plan['price']}) → {$plan['plan_name']} (₱{$plan['price']})";
            }
            if ($old_data['address'] !== $address) $changes[] = "address: {$old_data['address']} → $address";
            if ($old_data['started_date'] !== $started_date) $changes[] = "start date: {$old_data['started_date']} → $started_date";
            if ($old_data['due_date'] !== $due_date) $changes[] = "due date: {$old_data['due_date']} → $due_date";
            if ($old_data['status'] !== $status) $changes[] = "status: {$old_data['status']} → $status";
            
            $log_content = "Updated subscription ref: $reference for subscriber: {$subscriber['full_name']} (USER_ID: {$subscriber['user_id']}) - " . implode(', ', $changes);
        } else {
            $log_content = "Created new subscription ref: $reference for subscriber: {$subscriber['full_name']} (USER_ID: {$subscriber['user_id']}) - Plan: {$plan['plan_name']} (₱{$plan['price']}), Address: $address, Started: $started_date, Due: $due_date, Status: $status";
        }
        
        add_log($log_content);
        
        $response['success'] = true;
        $response['message'] = 'Subscription saved successfully';
        $response['id'] = $subscription_id;
    }
    // DELETE SUBSCRIPTION
    elseif ($action === 'delete_subscription') {
        $id = (int)$_POST['id'];
        
        // Get subscription details for log
        $subscription = $conn->query("
            SELECT s.*, sub.user_id, sub.full_name, p.plan_name, p.price 
            FROM subscriptions s
            JOIN subscribers sub ON s.user_id = sub.id
            JOIN plans p ON s.plan_id = p.id
            WHERE s.id = $id
        ")->fetch_assoc();
        
        if (!$subscription) {
            throw new Exception('Subscription not found');
        }
        
        $stmt = $conn->prepare("DELETE FROM subscriptions WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute() || $stmt->affected_rows === 0) {
            throw new Exception('Subscription not found or already deleted');
        }
        
        // Add detailed log entry
        $log_content = "Deleted subscription ID: $id for subscriber: {$subscription['full_name']} (USER_ID: {$subscription['user_id']}) - Plan: {$subscription['plan_name']} (₱{$subscription['price']}), Started: {$subscription['started_date']}, Due: {$subscription['due_date']}, Status: {$subscription['status']}";
        add_log($log_content);
        
        $response['success'] = true;
        $response['message'] = 'Subscription deleted successfully';
    }
    // GET SUBSCRIPTION DETAILS
    elseif ($action === 'get_subscription') {
        $id = (int)$_POST['id'];
        
        $subscription = $conn->query("
            SELECT s.*, p.plan_name, p.price 
            FROM subscriptions s
            LEFT JOIN plans p ON s.plan_id = p.id
            WHERE s.id = $id
        ")->fetch_assoc();
        
        if (!$subscription) {
            throw new Exception('Subscription not found');
        }
        
        $response['success'] = true;
        $response['subscription'] = $subscription;
    }
    // GET ALL SUBSCRIPTIONS FOR USER
    elseif ($action === 'get_subscriptions') {
        $user_id = (int)$_POST['user_id'];
        
        $subscriptions = $conn->query("
            SELECT s.*, p.plan_name, p.price 
            FROM subscriptions s
            LEFT JOIN plans p ON s.plan_id = p.id
            WHERE s.user_id = $user_id
            ORDER BY s.started_date DESC
        ")->fetch_all(MYSQLI_ASSOC);
        
        $response['success'] = true;
        $response['subscriptions'] = $subscriptions;
    }
    else {
        throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
