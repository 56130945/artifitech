<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';

// Set page-specific variables
$page = 'login';
$title = "Artifitech - Login | Educational Technology Solutions";
$keywords = "Login, Artifitech Login, User Access, Account Login";
$description = "Login to your Artifitech account to access our educational technology solutions and services.";
$og_title = "Login - Artifitech Educational Technology Solutions";
$og_description = "Access your Artifitech account";
$og_url = "https://artifitech.com/login";

// Process login form
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Login attempt started");
    
    // Get and sanitize inputs
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    error_log("Login attempt for email: " . $email);

    if (empty($email) || empty($password)) {
        $message = 'Email and password are required';
        $messageType = 'danger';
        error_log("Empty email or password");
    } else {
        try {
            $conn = getDBConnection();
            if (!$conn) {
                throw new Exception("Database connection failed");
            }

            // First check administrators table
            $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password_hash as password, 'admin' as user_type FROM administrators WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // If not found in administrators, check users table
            if (!$user) {
                $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, 'user' as user_type FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            error_log("User query executed");

            if (!$user || !password_verify($password, $user['password'])) {
                $message = 'Invalid email or password';
                $messageType = 'danger';
                error_log("Invalid credentials for email: " . $email);
            } else {
                error_log("Valid credentials for user ID: " . $user['id']);

                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_type'] = $user['user_type'];

                // Handle remember me
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $expires = time() + (30 * 24 * 60 * 60); // 30 days

                    // Store token in database
                    $stmt = $conn->prepare("INSERT INTO remember_tokens (user_id, token, expires) VALUES (?, ?, ?)");
                    $stmt->execute([$user['id'], password_hash($token, PASSWORD_DEFAULT), date('Y-m-d H:i:s', $expires)]);

                    // Set cookie
                    setcookie('remember_token', $token, $expires, '/', '', true, true);
                    error_log("Remember me token set for user ID: " . $user['id']);
                }

                // Redirect based on user type
                if ($user['user_type'] === 'admin') {
                    error_log("Redirecting admin to back_office/dashboard.php");
                    header('Location: back_office/dashboard.php');
                } else {
                    error_log("Redirecting user to dashboard.php");
                    header('Location: dashboard.php');
                }
                exit;
            }
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $message = 'An error occurred during login. Please try again.';
            $messageType = 'danger';
        }
    }
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
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Welcome Back</h4>
                        <p class="text-muted mb-4">Login to access your account and manage your services</p>
                    </div>

                    <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $messageType; ?> mb-4">
                        <?php echo $message; ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="login.php">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="Your Email" required 
                                           value="<?php echo htmlspecialchars($email ?? ''); ?>">
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
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="forgot-password.php" class="text-primary">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5 w-100" type="submit">
                                    Login
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <p class="text-muted mb-0">Don't have an account? <a href="register.php" class="text-primary">Register here</a></p>
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