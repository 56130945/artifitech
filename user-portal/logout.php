<?php
require_once '../includes/config.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Get database connection
    $conn = getDBConnection();
    
    if (isset($_SESSION['user_id'])) {
        // Log the logout action
        $stmt = $conn->prepare("
            INSERT INTO auth_logs (user_type, user_id, action, ip_address, user_agent) 
            VALUES ('customer', ?, 'logout', ?, ?)
        ");
        $stmt->execute([
            $_SESSION['user_id'],
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        ]);

        // Remove remember me token if exists
        if (isset($_COOKIE['remember_token'])) {
            // Delete token from database
            $stmt = $conn->prepare("
                DELETE FROM remember_me_tokens 
                WHERE user_id = ? AND user_type = 'customer'
            ");
            $stmt->execute([$_SESSION['user_id']]);
            
            // Remove the cookie
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }
    }
} catch (PDOException $e) {
    error_log("Logout error: " . $e->getMessage());
}

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to main login page
header('Location: ../login.php');
exit;
?> 