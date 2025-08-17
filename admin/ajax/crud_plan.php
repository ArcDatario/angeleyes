<?php
header('Content-Type: application/json');
require_once '../../db.php';

$response = ['success' => false, 'message' => ''];

try {
    $action = $_POST['action'] ?? '';

    // CREATE/UPDATE PLAN
    if ($action === 'save_plan') {
        $id = $_POST['id'] ?? 0;
        $plan_name = trim($_POST['plan_name']);
        $badge = in_array($_POST['badge'] ?? '', ['popular', 'top rated', 'premium', '']) ? $_POST['badge'] : null;
        $price = (float)$_POST['price'];
        $inclusions = $_POST['inclusions'] ?? [];

        if (empty($plan_name) || $price <= 0) {
            throw new Exception('Plan name and valid price are required');
        }

        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE plans SET plan_name=?, badge=?, price=? WHERE id=?");
            $stmt->bind_param("ssdi", $plan_name, $badge, $price, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO plans (plan_name, badge, price) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $plan_name, $badge, $price);
        }

        if (!$stmt->execute()) {
            throw new Exception('Failed to save plan');
        }

        $plan_id = $id > 0 ? $id : $stmt->insert_id;

        // Handle inclusions
        if (!empty($inclusions)) {
            $conn->query("DELETE FROM inclusions WHERE plan_id = $plan_id");
            
            $stmt = $conn->prepare("INSERT INTO inclusions (plan_id, inclusion_text) VALUES (?, ?)");
            foreach ($inclusions as $inc) {
                $inc = trim($inc);
                if (!empty($inc)) {
                    $stmt->bind_param("is", $plan_id, $inc);
                    $stmt->execute();
                }
            }
        }

        $response['success'] = true;
        $response['message'] = 'Plan saved successfully';
        $response['id'] = $plan_id;
    }
    // DELETE PLAN
    elseif ($action === 'delete_plan') {
        $id = (int)$_POST['id'];
        
        $conn->begin_transaction();
        try {
            $conn->query("DELETE FROM inclusions WHERE plan_id = $id");
            
            $stmt = $conn->prepare("DELETE FROM plans WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute() || $stmt->affected_rows === 0) {
                throw new Exception('Plan not found or already deleted');
            }
            
            $conn->commit();
            $response['success'] = true;
            $response['message'] = 'Plan deleted successfully';
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
    }
    // GET PLAN DETAILS
    elseif ($action === 'get_plan') {
        $id = (int)$_POST['id'];
        
        $plan = $conn->query("SELECT * FROM plans WHERE id = $id")->fetch_assoc();
        if (!$plan) {
            throw new Exception('Plan not found');
        }
        
        $inclusions = $conn->query("SELECT inclusion_text FROM inclusions WHERE plan_id = $id")->fetch_all(MYSQLI_ASSOC);
        
        $response['success'] = true;
        $response['plan'] = $plan;
        $response['inclusions'] = array_column($inclusions, 'inclusion_text');
    }
    // GET ALL PLANS
    elseif ($action === 'get_plans') {
        $plans = $conn->query("
            SELECT p.*, 
                   (SELECT COUNT(*) FROM subscribers WHERE plan_id = p.id) AS subs_count,
                   GROUP_CONCAT(i.inclusion_text SEPARATOR '||') AS inclusions
            FROM plans p
            LEFT JOIN inclusions i ON p.id = i.plan_id
            GROUP BY p.id
        ")->fetch_all(MYSQLI_ASSOC);
        
        $response['success'] = true;
        $response['plans'] = $plans;
    }
    else {
        throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);