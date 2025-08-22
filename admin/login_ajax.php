<?php
session_start();
require_once('../db.php');

header('Content-Type: application/json');

// Initialize response array
$response = array('success' => false, 'message' => '');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] == 1;
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $response['message'] = 'Please enter both username and password.';
        echo json_encode($response);
        exit();
    }
    
    // Check credentials against database
    $query = "SELECT id, username, password FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            
            // Set remember me cookie if requested
            if ($remember_me) {
                $token = bin2hex(random_bytes(32));
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days
                
                // Update token in database
                $update_query = "UPDATE admin SET remember_token = ?, remember_expiry = DATE_ADD(NOW(), INTERVAL 30 DAY) WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $token, $admin['id']);
                $update_stmt->execute();
                $update_stmt->close();
                
                // Set cookie
                setcookie('admin_remember', $token, $expiry, "/");
            }
            
            // Update last login
            $update_login = "UPDATE admin SET last_login = NOW() WHERE id = ?";
            $update_stmt = $conn->prepare($update_login);
            $update_stmt->bind_param("i", $admin['id']);
            $update_stmt->execute();
            $update_stmt->close();
            
            $response['success'] = true;
            $response['message'] = 'Login successful!';
            // Tell the client where to redirect on success
            $response['redirect'] = 'dashboard.php';
        } else {
            $response['message'] = 'Invalid username or password.';
        }
    } else {
        $response['message'] = 'Invalid username or password.';
    }
    
    $stmt->close();
} else {
    $response['message'] = 'Invalid request method.';
}
// Set appropriate HTTP status code for failures so client-side JS can handle it
if (isset($response['success']) && $response['success'] === true) {
    http_response_code(200);
} else {
    // Unauthorized for invalid credentials or bad requests
    http_response_code(401);
}

echo json_encode($response);
$conn->close();
?>