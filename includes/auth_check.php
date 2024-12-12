<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

// Function to check if user is logged in and is a customer
function isCustomerLoggedIn() {
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['user_type']) && 
           $_SESSION['user_type'] === 'customer';
}

// Function to check remember me token
function checkRememberMeToken() {
    if (isset($_COOKIE['remember_token'])) {
        try {
            $conn = getDBConnection();
            $token = $_COOKIE['remember_token'];
            
            // Get valid remember token
            $stmt = $conn->prepare("
                SELECT rmt.*, c.* 
                FROM remember_me_tokens rmt
                JOIN customers c ON rmt.user_id = c.id
                WHERE rmt.user_type = 'customer'
                AND rmt.expires_at > NOW()
                AND c.is_active = 1
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
                $_SESSION['user_type'] = 'customer';
                
                // Update last login
                $stmt = $conn->prepare("UPDATE customers SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$result['user_id']]);
                
                // Log the auto-login
                $stmt = $conn->prepare("
                    INSERT INTO auth_logs (user_type, user_id, action, ip_address, user_agent) 
                    VALUES ('customer', ?, 'login', ?, ?)
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
if (!isCustomerLoggedIn() && !checkRememberMeToken()) {
    // Store the requested URL for redirect after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    // Redirect to main login page
    header('Location: /artifitech/login.php');
    exit;
}

// Ensure the user is a customer
if ($_SESSION['user_type'] !== 'customer') {
    // Clear session and redirect to login
    session_destroy();
    header('Location: /artifitech/login.php');
    exit;
}
?> 