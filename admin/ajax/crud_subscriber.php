
<?php
// File: ajax/crud_subscriber.php
header('Content-Type: application/json');
require_once '../../db.php';
require_once '../../admin/auth_check.php'; // Add this line
require_once 'log_helper.php'; // Add this line

$response = ['success' => false, 'message' => ''];

try {
    $action = $_POST['action'] ?? '';

    // CREATE/UPDATE SUBSCRIBER
    if ($action === 'save_subscriber') {
        $id = $_POST['id'] ?? 0;
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $status = $_POST['status'] ?? 'Active';

        if (empty($full_name) || empty($email) || empty($phone)) {
            throw new Exception('Full name, email and phone are required');
        }

        // Get old data for update log
        $old_data = [];
        if ($id > 0) {
            $old_data_result = $conn->query("SELECT * FROM subscribers WHERE id = $id");
            $old_data = $old_data_result->fetch_assoc();
        }

        if ($id > 0) { // Update
            $stmt = $conn->prepare("UPDATE subscribers SET full_name=?, email=?, phone=?, address=?, status=? WHERE id=?");
            $stmt->bind_param("sssssi", $full_name, $email, $phone, $address, $status, $id);
        } else { // Insert
            // Generate unique user_id (10 chars)
            $user_id = generateUniqueUserId($conn);
            $stmt = $conn->prepare("INSERT INTO subscribers (user_id, full_name, email, phone, address, status, subscription_count) VALUES (?, ?, ?, ?, ?, ?, 0)");
            $stmt->bind_param("ssssss", $user_id, $full_name, $email, $phone, $address, $status);
        }

        if (!$stmt->execute()) {
            throw new Exception('Failed to save subscriber');
        }

        $subscriber_id = $id > 0 ? $id : $stmt->insert_id;
        $subscriber_user_id = $id > 0 ? $old_data['user_id'] : $user_id;
        
        // Add detailed log entry
        if ($id > 0) {
            $changes = [];
            if ($old_data['full_name'] !== $full_name) $changes[] = "name: {$old_data['full_name']} → $full_name";
            if ($old_data['email'] !== $email) $changes[] = "email: {$old_data['email']} → $email";
            if ($old_data['phone'] !== $phone) $changes[] = "phone: {$old_data['phone']} → $phone";
            if ($old_data['address'] !== $address) $changes[] = "address: {$old_data['address']} → $address";
            if ($old_data['status'] !== $status) $changes[] = "status: {$old_data['status']} → $status";
            
            $log_content = "Updated subscriber USER_ID: $subscriber_user_id - " . implode(', ', $changes);
        } else {
            $log_content = "Created new subscriber: $full_name, USER_ID: $subscriber_user_id, Email: $email, Phone: $phone, Status: $status";
        }
        
        add_log($log_content);
        
        $response['success'] = true;
        $response['message'] = 'Subscriber saved successfully';
        $response['id'] = $subscriber_id;
        $response['user_id'] = $subscriber_user_id;
    }
    // DELETE SUBSCRIBER
    elseif ($action === 'delete_subscriber') {
        $id = (int)$_POST['id'];
        
        // Get subscriber details for log
        $subscriber = $conn->query("SELECT user_id, full_name, email, phone, subscription_count FROM subscribers WHERE id = $id")->fetch_assoc();
        
        if (!$subscriber) {
            throw new Exception('Subscriber not found');
        }
        
        $stmt = $conn->prepare("DELETE FROM subscribers WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute() || $stmt->affected_rows === 0) {
            throw new Exception('Subscriber not found or already deleted');
        }
        
        // Add detailed log entry
        $log_content = "Deleted subscriber: {$subscriber['full_name']}, USER_ID: {$subscriber['user_id']}, Email: {$subscriber['email']}, Phone: {$subscriber['phone']}, Had {$subscriber['subscription_count']} subscriptions";
        add_log($log_content);
        
        $response['success'] = true;
        $response['message'] = 'Subscriber deleted successfully';
    }
    // GET SUBSCRIBER DETAILS
    elseif ($action === 'get_subscriber') {
        $id = (int)$_POST['id'];
        
        $subscriber = $conn->query("SELECT * FROM subscribers WHERE id = $id")->fetch_assoc();
        if (!$subscriber) {
            throw new Exception('Subscriber not found');
        }
        
        $response['success'] = true;
        $response['subscriber'] = $subscriber;
    }
    // GET ALL SUBSCRIBERS (for listing)
    elseif ($action === 'get_subscribers') {
        $subscribers = $conn->query("
            SELECT s.*
            FROM subscribers s
            ORDER BY s.created_at DESC
        ")->fetch_all(MYSQLI_ASSOC);
        
        $response['success'] = true;
        $response['subscribers'] = $subscribers;
    }
    // UPDATE SUBSCRIPTION COUNT
    elseif ($action === 'update_subscription_count') {
        $id = (int)$_POST['id'];
        $increment = (int)$_POST['increment'];
        
        // Get subscriber details for log
        $subscriber = $conn->query("SELECT user_id, full_name, subscription_count FROM subscribers WHERE id = $id")->fetch_assoc();
        
        $stmt = $conn->prepare("UPDATE subscribers SET subscription_count = subscription_count + ? WHERE id = ?");
        $stmt->bind_param("ii", $increment, $id);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to update subscription count');
        }
        
        // Get new count
        $new_count = $subscriber['subscription_count'] + $increment;
        
        // Add detailed log entry
        $action = $increment > 0 ? "increased" : "decreased";
        $log_content = "$action subscription count for subscriber: {$subscriber['full_name']} (USER_ID: {$subscriber['user_id']}) from {$subscriber['subscription_count']} to $new_count";
        add_log($log_content);
        
        $response['success'] = true;
        $response['message'] = 'Subscription count updated';
        $response['new_count'] = $new_count;
    }
    else {
        throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Function to generate unique user_id
function generateUniqueUserId($conn) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $maxAttempts = 10;
    $attempt = 0;
    
    do {
        $user_id = '';
        for ($i = 0; $i < 10; $i++) {
            $user_id .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // Check if exists in database
        $exists = $conn->query("SELECT id FROM subscribers WHERE user_id = '$user_id'")->num_rows;
        $attempt++;
    } while ($exists > 0 && $attempt < $maxAttempts);
    
    if ($attempt >= $maxAttempts) {
        throw new Exception('Failed to generate unique user ID');
    }
    
    return $user_id;
}

echo json_encode($response);
