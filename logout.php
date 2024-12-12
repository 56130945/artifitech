<?php
require_once 'includes/config.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear remember-me token if it exists
if (isset($_COOKIE['remember_token'])) {
    try {
        $conn = getDBConnection();
        if ($conn) {
            // Delete the token from database
            $stmt = $conn->prepare("DELETE FROM remember_tokens WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id'] ?? null]);
        }
    } catch (Exception $e) {
        error_log("Error clearing remember token: " . $e->getMessage());
    }
    
    // Remove the cookie
    setcookie('remember_token', '', time() - 3600, '/', '', true, true);
}

// Destroy session
$_SESSION = array();
session_destroy();

// Redirect to login page
header('Location: login.php');
exit;
?> 