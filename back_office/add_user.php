<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

try {
    // Validate required fields
    $required_fields = ['first_name', 'last_name', 'email', 'password', 'confirm_password'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            throw new Exception("$field is required");
        }
    }

    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format");
    }

    // Validate password match
    if ($password !== $confirmPassword) {
        throw new Exception("Passwords do not match");
    }

    // Validate password strength
    if (strlen($password) < 8) {
        throw new Exception("Password must be at least 8 characters long");
    }

    $conn = getDBConnection();

    // Check if email is already taken
    $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception("Email address is already in use");
    }

    // Insert new user
    $stmt = $conn->prepare("
        INSERT INTO customers (first_name, last_name, email, password, is_active, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $isActive]);

    $userId = $conn->lastInsertId();

    // Log the action
    error_log("Admin {$_SESSION['user_id']} created new user {$userId}");

    // Set success message and redirect
    $_SESSION['success_message'] = "User created successfully";
    header('Location: users.php');
    exit;

} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: users.php');
    exit;
} 