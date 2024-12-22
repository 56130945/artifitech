<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'artifitech');
define('DB_USER', 'root'); // Change this to your database username
define('DB_PASS', '');     // Change this to your database password

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Time zone
date_default_timezone_set('Africa/Johannesburg');

// Site URL and base URL (used for links and redirects)
define('SITE_URL', 'http://localhost/artifitech');
$base_url = 'http://localhost/artifitech';

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

// Include database functions
require_once __DIR__ . '/db.php';

// Get initial database connection
$conn = getDBConnection();
?> 