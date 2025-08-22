
<?php
require_once '../../admin/auth_check.php';
require_once '../../db.php';

function add_log($content) {
    global $conn;
    
    $admin_id = get_admin_id();
    if (!$admin_id) {
        return false;
    }
    
    $stmt = $conn->prepare("INSERT INTO logs (admin_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $admin_id, $content);
    return $stmt->execute();
}
?>
