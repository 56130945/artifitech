<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../includes/config.php';

// Log file path
$logFile = __DIR__ . '/register_debug.log';

// Log function
function logDebug($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

header('Content-Type: application/json');

logDebug("Registration attempt started");
logDebug("POST data: " . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logDebug("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    logDebug("CSRF token validation failed");
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

// Get and sanitize inputs
$firstName = sanitizeInput($_POST['first_name'] ?? '');
$lastName = sanitizeInput($_POST['last_name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$phone = sanitizeInput($_POST['phone'] ?? '');
$institution = sanitizeInput($_POST['institution'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

logDebug("Sanitized inputs received");
logDebug("First Name: $firstName");
logDebug("Last Name: $lastName");
logDebug("Email: $email");
logDebug("Phone: $phone");
logDebug("Institution: $institution");

// Validate inputs
$errors = [];

if (empty($firstName)) $errors['first_name'] = 'First name is required';
if (empty($lastName)) $errors['last_name'] = 'Last name is required';
if (empty($email)) $errors['email'] = 'Email is required';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format';
if (empty($institution)) $errors['institution'] = 'Institution is required';
if (empty($password)) $errors['password'] = 'Password is required';
if (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters';
if ($password !== $confirmPassword) $errors['confirm_password'] = 'Passwords do not match';

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['errors' => $errors]);
    exit;
}

try {
    // Get database connection
    $conn = getDBConnection();
    if (!$conn) {
        logDebug("Database connection failed");
        throw new Exception("Database connection failed");
    }
    logDebug("Database connection successful");

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        logDebug("Email already exists: $email");
        http_response_code(400);
        echo json_encode(['error' => 'Email already registered']);
        exit;
    }
    logDebug("Email check passed");

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    logDebug("Password hashed");

    // Insert new user
    $stmt = $conn->prepare("
        INSERT INTO users (first_name, last_name, email, phone, institution, password, created_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    
    logDebug("Attempting to insert user");
    $stmt->execute([
        $firstName,
        $lastName,
        $email,
        $phone,
        $institution,
        $hashedPassword
    ]);

    $userId = $conn->lastInsertId();
    logDebug("User inserted successfully with ID: $userId");

    // Set session variables
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $firstName . ' ' . $lastName;
    logDebug("Session variables set");

    echo json_encode([
        'success' => true,
        'message' => 'Registration successful',
        'user' => [
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email']
        ]
    ]);
    logDebug("Registration completed successfully");

} catch (Exception $e) {
    logDebug("Error occurred: " . $e->getMessage());
    logDebug("Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred during registration']);
} 