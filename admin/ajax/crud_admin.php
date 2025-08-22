<?php
// File: ajax/crud_admin.php
header('Content-Type: application/json');
require_once '../../db.php';
require_once '../../admin/auth_check.php';
require_once 'log_helper.php';

$response = ['success' => false, 'message' => ''];

try {
    $action = $_POST['action'] ?? '';

    // CREATE/UPDATE ADMIN
    if ($action === 'save_admin') {
        $id = $_POST['id'] ?? 0;
        $username = trim($_POST['username']);
        $password = $_POST['password'] ?? '';
        
        if (empty($username)) {
            throw new Exception('Username is required');
        }

        // Check if username already exists (for new admin)
        if ($id == 0) {
            $check = $conn->prepare("SELECT id FROM admin WHERE username = ?");
            $check->bind_param("s", $username);
            $check->execute();
            if ($check->get_result()->num_rows > 0) {
                throw new Exception('Username already exists');
            }
        }

        // Get old data for update log
        $old_data = [];
        if ($id > 0) {
            $old_data_result = $conn->query("SELECT * FROM admin WHERE id = $id");
            $old_data = $old_data_result->fetch_assoc();
        }

        // Handle file upload
        $upload_dir = '../../admin/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $profile_filename = $old_data['profile'] ?? '';
        
        if (!empty($_FILES['profile']['name'])) {
            // Generate new filename
            $file_extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
            $profile_filename = 'admin_' . time() . '.' . $file_extension;
            
            if (move_uploaded_file($_FILES['profile']['tmp_name'], $upload_dir . $profile_filename)) {
                // Delete old profile image if it exists and is not the default
                if ($id > 0 && !empty($old_data['profile']) && $old_data['profile'] !== 'default.png' && file_exists($upload_dir . $old_data['profile'])) {
                    unlink($upload_dir . $old_data['profile']);
                }
            } else {
                throw new Exception('Failed to upload profile image');
            }
        } else if ($id == 0) { // New admin and no profile image uploaded
            // Copy and rename the default user.png
            $default_src = '../../user.png';
            $file_extension = pathinfo($default_src, PATHINFO_EXTENSION);
            $profile_filename = 'admin_' . time() . '_default.' . $file_extension;
            
            if (file_exists($default_src)) {
                if (!copy($default_src, $upload_dir . $profile_filename)) {
                    throw new Exception('Failed to create default profile image');
                }
            } else {
                throw new Exception('Default user image not found');
            }
        }

        if ($id > 0) { // Update
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE admin SET username=?, password=?, profile=? WHERE id=?");
                $stmt->bind_param("sssi", $username, $hashed_password, $profile_filename, $id);
            } else {
                $stmt = $conn->prepare("UPDATE admin SET username=?, profile=? WHERE id=?");
                $stmt->bind_param("ssi", $username, $profile_filename, $id);
            }
        } else { // Insert
            if (empty($password)) {
                throw new Exception('Password is required for new admin');
            }
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admin (username, password, profile) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $profile_filename);
        }

        if (!$stmt->execute()) {
            throw new Exception('Failed to save admin');
        }

        $admin_id = $id > 0 ? $id : $stmt->insert_id;
        
        // Add detailed log entry
        if ($id > 0) {
            $changes = [];
            if ($old_data['username'] !== $username) $changes[] = "username: {$old_data['username']} → $username";
            if (isset($profile_filename) && ($old_data['profile'] !== $profile_filename)) $changes[] = "profile image";
            
            $log_content = "Updated admin ID: $admin_id - " . implode(', ', $changes);
        } else {
            $log_content = "Created new admin: $username";
        }
        
        add_log($log_content);
        
        $response['success'] = true;
        $response['message'] = 'Admin saved successfully';
    }
    // DELETE ADMIN
    elseif ($action === 'delete_admin') {
        $id = (int)$_POST['id'];
        
        // Cannot delete yourself
        if ($id == $_SESSION['admin_id']) {
            throw new Exception('You cannot delete your own account');
        }
        
        // Get admin details for log
        $admin = $conn->query("SELECT username, profile FROM admin WHERE id = $id")->fetch_assoc();
        
        if (!$admin) {
            throw new Exception('Admin not found');
        }
        
        // Delete profile image if it exists and is not default
        $profile_file = $admin['profile'];
        $upload_dir = '../../admin/uploads/';
        if ($profile_file && !empty($profile_file) && file_exists($upload_dir . $profile_file)) {
            unlink($upload_dir . $profile_file);
        }
        
        $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute() || $stmt->affected_rows === 0) {
            throw new Exception('Admin not found or already deleted');
        }
        
        // Add detailed log entry
        $log_content = "Deleted admin: {$admin['username']} (ID: $id)";
        add_log($log_content);
        
        $response['success'] = true;
        $response['message'] = 'Admin deleted successfully';
    }
    // GET ADMIN DETAILS
    elseif ($action === 'get_admin') {
        $id = (int)$_POST['id'];
        
        $admin = $conn->query("SELECT id, username, profile FROM admin WHERE id = $id")->fetch_assoc();
        if (!$admin) {
            throw new Exception('Admin not found');
        }
        
        $response['success'] = true;
        $response['admin'] = $admin;
    }
    // GET ALL ADMINS (EXCEPT CURRENT SESSION ADMIN)
    elseif ($action === 'get_admins') {
        $current_admin_id = $_SESSION['admin_id'];
        $stmt = $conn->prepare("SELECT id, username, profile FROM admin WHERE id != ? ORDER BY username");
        $stmt->bind_param("i", $current_admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
        
        $response['success'] = true;
        $response['admins'] = $admins;
    }
    else {
        throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);