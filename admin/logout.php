<?php
require_once('auth_check.php');

// Clear remember token from database if exists
if (isset($_COOKIE['admin_remember'])) {
    require_once('../db.php');
    global $conn;
    
    $token = $_COOKIE['admin_remember'];
    $query = "UPDATE admin SET remember_token = NULL, remember_expiry = NULL WHERE remember_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();
}

// Destroy session and redirect to login
logout();
?>