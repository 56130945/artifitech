<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Set page-specific variables
$page = 'login';
$title = "Login - Artifitech";
$description = "Login to access your Artifitech account";
$keywords = "Login, User Account, Authentication";
$og_title = "Login to Artifitech";
$og_description = "Access your Artifitech account and services";
$og_url = "https://artifitech.com/login";

// Initialize variables
$email = '';
$message = '';
$messageType = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    try {
        $conn = getDBConnection();
        
        // Try to find the user in customers table first
        $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Customer login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = 'customer';
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

            // Log the successful login
            logAuthActivity('customer', $user['id'], 'login');

            // Handle remember me
            if ($remember) {
                createRememberMeToken('customer', $user['id']);
            }

            // Check if there's a checkout redirect
            if (isset($_GET['redirect']) && $_GET['redirect'] === 'checkout') {
                $product_id = $_GET['product_id'] ?? '';
                $plan = $_GET['plan'] ?? '';
                header("Location: $base_url/user-portal/checkout.php?product_id=$product_id&plan=$plan");
            } else {
                header("Location: $base_url/user-portal/dashboard.php");
            }
            exit;
        }

        // If not found in customers, try administrators table
        $stmt = $conn->prepare("SELECT * FROM administrators WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Admin login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = 'admin';
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

            // Log the successful login
            logAuthActivity('admin', $user['id'], 'login');

            // Handle remember me
            if ($remember) {
                createRememberMeToken('admin', $user['id']);
            }

            header("Location: $base_url/back_office/dashboard.php");
            exit;
        }

        // If we get here, login failed
        $message = "Invalid email or password.";
        $messageType = "error";
        error_log("Login failed for email: " . $email); // Add logging
        logAuthActivity('unknown', null, 'failed_login', ['email' => $email]);

    } catch (Exception $e) {
        $message = "An error occurred. Please try again later.";
        $messageType = "error";
        error_log("Login error: " . $e->getMessage());
    }
}

// Check for remember me cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    try {
        $token = $_COOKIE['remember_token'];
        
        // Check token in remember_me_tokens table
        $stmt = $conn->prepare("
            SELECT * FROM remember_me_tokens 
            WHERE token = ? AND expires_at > NOW()
        ");
        $stmt->execute([$token]);
        $tokenData = $stmt->fetch();

        if ($tokenData) {
            if ($tokenData['user_type'] === 'admin') {
                $stmt = $conn->prepare("SELECT * FROM administrators WHERE id = ? AND is_active = 1");
            } else {
                $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ? AND is_active = 1");
            }
            
            $stmt->execute([$tokenData['user_id']]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $tokenData['user_type'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

                // Refresh the remember me token
                createRememberMeToken($tokenData['user_type'], $user['id']);
            }
        }
    } catch (Exception $e) {
        error_log("Remember me token error: " . $e->getMessage());
    }
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] === 'admin') {
        header('Location: back_office/dashboard.php');
    } else {
        header('Location: user-portal/dashboard.php');
    }
    exit;
}

// Start output buffering
ob_start();
?>

<!-- Login Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Login to Your Account</h4>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $messageType === 'error' ? 'danger' : 'success'; ?>" role="alert">
                                <?php echo htmlspecialchars($message); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill py-3 px-5 w-100">Login</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Don't have an account? <a href="register.php">Register now</a></p>
                        <p class="mt-2"><a href="forgot-password.php">Forgot your password?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Section End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 