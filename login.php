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
        
        // First, try to find the user in administrators table
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

            header('Location: back_office/dashboard.php');
            exit;
        }

        // If not found in administrators, try customers table
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
                header("Location: user-portal/checkout.php?product_id=$product_id&plan=$plan");
            } else {
                header('Location: user-portal/dashboard.php');
            }
            exit;
        }

        // If we get here, login failed
        $message = "Invalid email or password.";
        $messageType = "error";
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

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Login</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Login</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Login Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Welcome Back</h4>
                        <p class="text-muted mb-4">Access your Artifitech account to manage your educational technology solutions</p>
                    </div>

                    <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType === 'error' ? 'danger' : 'success'; ?> mb-4">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="login.php">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="Your Email" value="<?php echo htmlspecialchars($email); ?>" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Password" required>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5 w-100" type="submit">
                                    Login
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <a href="forgot-password.php" class="text-primary">Forgot your password?</a>
                                <p class="text-muted mt-3 mb-0">Don't have an account? <a href="register.php" class="text-primary">Register here</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 