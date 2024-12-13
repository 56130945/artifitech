<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/config.php';

// Function to check if user is logged in and is an admin
function isAdminLoggedIn() {
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['user_type']) && 
           $_SESSION['user_type'] === 'admin';
}

// Function to check remember me token for admin
function checkAdminRememberToken() {
    if (isset($_COOKIE['remember_token'])) {
        try {
            $conn = getDBConnection();
            $token = $_COOKIE['remember_token'];
            
            // Get valid remember token
            $stmt = $conn->prepare("
                SELECT rmt.*, a.* 
                FROM remember_me_tokens rmt
                JOIN administrators a ON rmt.user_id = a.id
                WHERE rmt.user_type = 'admin'
                AND rmt.expires_at > NOW()
                AND a.is_active = 1
                ORDER BY rmt.created_at DESC
                LIMIT 1
            ");
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result && password_verify($token, $result['token'])) {
                // Set session variables
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['user_email'] = $result['email'];
                $_SESSION['user_name'] = $result['first_name'] . ' ' . $result['last_name'];
                $_SESSION['user_type'] = 'admin';
                
                // Update last login
                $stmt = $conn->prepare("UPDATE administrators SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$result['user_id']]);
                
                // Log the auto-login
                $stmt = $conn->prepare("
                    INSERT INTO auth_logs (user_type, user_id, action, ip_address, user_agent) 
                    VALUES ('admin', ?, 'login', ?, ?)
                ");
                $stmt->execute([
                    $result['user_id'],
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT']
                ]);
                
                return true;
            }
        } catch (PDOException $e) {
            error_log("Remember token check error: " . $e->getMessage());
        }
    }
    return false;
}

// Check if user is logged in or has valid remember me token
if (!isAdminLoggedIn() && !checkAdminRememberToken()) {
    // Store the requested URL for redirect after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    // Redirect to login page
    header('Location: ../login.php');
    exit;
}

// Ensure the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    // Clear session and redirect to login
    session_destroy();
    header('Location: ../login.php');
    exit;
}
?> 