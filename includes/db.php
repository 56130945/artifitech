<?php
// Database connection function
function getDBConnection() {
    static $conn = null;
    
    if ($conn === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }
    }
    
    return $conn;
}

// Close database connection
function closeDBConnection() {
    global $conn;
    $conn = null;
}

// Authentication logging
function logAuthActivity($user_type, $user_id, $action, $details = []) {
    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

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

// Remember me token management
function createRememberMeToken($user_type, $user_id) {
    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }
        
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