<?php
// File: ajax/crud_subscriber.php
header('Content-Type: application/json');
require_once '../../db.php';

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
        
        $response['success'] = true;
        $response['message'] = 'Subscriber saved successfully';
        $response['id'] = $subscriber_id;
    }
    // DELETE SUBSCRIBER
    elseif ($action === 'delete_subscriber') {
        $id = (int)$_POST['id'];
        
        $stmt = $conn->prepare("DELETE FROM subscribers WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute() || $stmt->affected_rows === 0) {
            throw new Exception('Subscriber not found or already deleted');
        }
        
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
        
        $stmt = $conn->prepare("UPDATE subscribers SET subscription_count = subscription_count + ? WHERE id = ?");
        $stmt->bind_param("ii", $increment, $id);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to update subscription count');
        }
        
        $response['success'] = true;
        $response['message'] = 'Subscription count updated';
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