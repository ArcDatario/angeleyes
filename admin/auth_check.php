
<?php
session_start();

// Check if user is logged in
function is_logged_in() {
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        return true;
    }
    
    // Check for remember me cookie
    if (isset($_COOKIE['admin_remember'])) {
        require_once('../db.php');
        global $conn;
        
        $token = $_COOKIE['admin_remember'];
        $query = "SELECT id, username, profile FROM admin WHERE remember_token = ? AND remember_expiry > NOW()";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_profile'] = !empty($admin['profile']) ? 
                '../admin/uploads/'.$admin['profile'] : '../user.png';
            
            $stmt->close();
            return true;
        }
        
        $stmt->close();
    }
    
    return false;
}

// Get current admin ID
function get_admin_id() {
    return $_SESSION['admin_id'] ?? null;
}

// Get admin profile image
function get_admin_profile() {
    return $_SESSION['admin_profile'] ?? '../user.png';
}

// Redirect to login if not authenticated
function require_login() {
    // If this is an AJAX request, do not send a redirect; return 401 so client can handle it
    if (!is_logged_in()) {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        header("Location: authentication-login");
        exit();
    }
}

// Redirect to dashboard if already logged in
function redirect_if_logged_in() {
    if (is_logged_in()) {
        header("Location: dashboard");
        exit();
    }
}

// Logout function
function logout() {
    session_destroy();
    
    // Clear remember me cookie
    if (isset($_COOKIE['admin_remember'])) {
        setcookie('admin_remember', '', time() - 3600, "/");
    }
    
    header("Location: authentication-login");
    exit();
}
?>
