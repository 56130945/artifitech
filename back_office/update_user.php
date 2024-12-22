<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

$response = ['success' => false, 'message' => ''];

try {
    // Validate required fields
    $required_fields = ['user_id', 'first_name', 'last_name', 'email'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            throw new Exception("$field is required");
        }
    }

    $userId = $_POST['user_id'];
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone'] ?? '');
    $isActive = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
    $password = trim($_POST['password'] ?? '');

    $conn = getDBConnection();

    // Check if email is already taken by another user
    $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ? AND id != ?");
    $stmt->execute([$email, $userId]);
    if ($stmt->fetch()) {
        throw new Exception("Email address is already in use by another user");
    }

    // Start building the update query
    $updateFields = [
        'first_name = ?',
        'last_name = ?',
        'email = ?',
        'phone = ?',
        'is_active = ?'
    ];
    $params = [$firstName, $lastName, $email, $phone, $isActive];

    // Add password update if provided
    if ($password !== '') {
        $updateFields[] = 'password = ?';
        $params[] = password_hash($password, PASSWORD_DEFAULT);
    }

    // Add user ID to params
    $params[] = $userId;

    // Build and execute the update query
    $query = "UPDATE customers SET " . implode(', ', $updateFields) . " WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'User updated successfully';
        
        // Log the action
        error_log("Admin {$_SESSION['user_id']} updated user {$userId}");
    } else {
        $response['message'] = 'No changes were made';
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("Error in update_user.php: " . $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response); 