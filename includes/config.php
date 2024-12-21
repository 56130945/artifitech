<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'artifitech');
define('DB_USER', 'root'); // Change this to your database username
define('DB_PASS', '');     // Change this to your database password

// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Time zone
date_default_timezone_set('Africa/Johannesburg');

// Site URL
define('SITE_URL', 'http://localhost/artifitech');

// Define base URL
$base_url = '/artifitech';

// Common meta defaults (can be overridden by individual pages)
$title = "Artifitech - Leading Educational Technology Solutions Provider";
$keywords = "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing";
$description = "Artifitech is South Africa's leading provider of educational technology solutions, specializing in Learning Management Systems and enterprise solutions.";
$og_title = "Artifitech - Leading Educational Technology Solutions";
$og_description = "South Africa's leading provider of educational technology solutions";
$og_url = "https://artifitech.com";

// Initialize additional CSS and JS variables
$additional_css = '';
$additional_js = '';

// Security functions
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Authentication utility functions
function logAuthActivity($user_type, $user_id, $action, $details = []) {
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare("
            INSERT INTO auth_logs (user_type, user_id, action, details, ip_address, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $details_json = !empty($details) ? json_encode($details) : null;
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
        
        $stmt->execute([$user_type, $user_id, $action, $details_json, $ip_address]);
        return true;
    } catch (Exception $e) {
        error_log("Auth logging error: " . $e->getMessage());
        return false;
    }
}

function createRememberMeToken($user_type, $user_id) {
    try {
        $conn = getDBConnection();
        
        // Delete any existing tokens for this user
        $stmt = $conn->prepare("
            DELETE FROM remember_me_tokens 
            WHERE user_type = ? AND user_id = ?
        ");
        $stmt->execute([$user_type, $user_id]);
        
        // Create new token
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        $stmt = $conn->prepare("
            INSERT INTO remember_me_tokens (user_type, user_id, token, expires_at)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$user_type, $user_id, $token, $expires_at]);
        
        // Set cookie for 30 days
        setcookie('remember_token', $token, time() + (86400 * 30), '/', '', true, true);
        
        return true;
    } catch (Exception $e) {
        error_log("Remember me token error: " . $e->getMessage());
        return false;
    }
}
?> 