<?php
require_once 'includes/config.php';

// Set page-specific variables
$page = 'login';
$title = "Login - Artifitech";
$description = "Login to access your Artifitech account";

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
        $isAdmin = true;

        // If not found in administrators, check customers table
        if (!$user) {
            $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            $isAdmin = false;
        }

        // Verify credentials
        if ($user && password_verify($password, $user['password_hash'])) {
            // Set common session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_type'] = $isAdmin ? 'admin' : 'customer';

            // Update last login
            $table = $isAdmin ? 'administrators' : 'customers';
            $stmt = $conn->prepare("UPDATE {$table} SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);

            // Log the successful login
            $stmt = $conn->prepare("
                INSERT INTO auth_logs (user_type, user_id, action, ip_address, user_agent) 
                VALUES (?, ?, 'login', ?, ?)
            ");
            $stmt->execute([
                $isAdmin ? 'admin' : 'customer',
                $user['id'],
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT']
            ]);

            // Handle remember me
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', time() + (30 * 24 * 60 * 60)); // 30 days

                // Store token in database
                $stmt = $conn->prepare("
                    INSERT INTO remember_me_tokens (user_type, user_id, token, expires_at) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([
                    $isAdmin ? 'admin' : 'customer',
                    $user['id'],
                    password_hash($token, PASSWORD_DEFAULT),
                    $expires
                ]);

                // Set cookie
                setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
            }

            // Redirect based on user type
            if ($isAdmin) {
                header('Location: back_office/dashboard.php');
            } else {
                header('Location: user-portal/dashboard.php');
            }
            exit;
        } else {
            $message = 'Invalid email or password';
            $messageType = 'danger';
        }
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        $message = 'An error occurred during login. Please try again.';
        $messageType = 'danger';
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
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
                        <h4 class="mb-3">Welcome Back!</h4>
                        <p class="text-muted mb-4">Please login to access your account</p>
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
                                           placeholder="Your Email" value="<?php echo htmlspecialchars($email); ?>" required>
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" 
                                           name="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
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
                                <p class="text-muted mb-0">Don't have an account? <a href="register.php" class="text-primary">Register here</a></p>
                                <p class="text-muted mt-2 mb-0">
                                    <a href="forgot-password.php" class="text-primary">Forgot your password?</a>
                                </p>
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