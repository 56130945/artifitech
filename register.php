<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';
require_once 'includes/db.php';

// Set page-specific variables
$page = 'register';
$title = "Artifitech - Register | Educational Technology Solutions";
$keywords = "Register, Create Account, Sign Up, New User Registration";
$description = "Create your Artifitech account to access our full range of educational technology solutions and services.";
$og_title = "Register - Artifitech Educational Technology Solutions";
$og_description = "Create your Artifitech account";
$og_url = "https://artifitech.com/register";

// Initialize variables
$message = '';
$messageType = '';
$firstName = '';
$lastName = '';
$email = '';
$phone = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log the start of registration process
    error_log("Registration process started");
    error_log("POST data: " . print_r($_POST, true));

    // Get and sanitize inputs
    $firstName = sanitizeInput($_POST['first_name'] ?? '');
    $lastName = sanitizeInput($_POST['last_name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    error_log("Sanitized inputs received:");
    error_log("First Name: $firstName");
    error_log("Last Name: $lastName");
    error_log("Email: $email");
    error_log("Phone: $phone");

    // Validate inputs
    if (empty($firstName)) $errors['first_name'] = 'First name is required';
    if (empty($lastName)) $errors['last_name'] = 'Last name is required';
    if (empty($email)) $errors['email'] = 'Email is required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format';
    if (empty($password)) $errors['password'] = 'Password is required';
    if (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters';
    if ($password !== $confirmPassword) $errors['confirm_password'] = 'Passwords do not match';

    if (!empty($errors)) {
        error_log("Validation errors found: " . print_r($errors, true));
        $message = 'Please correct the errors below.';
        $messageType = 'danger';
    } else {
        error_log("Validation passed, attempting database connection");
        try {
            $conn = getDBConnection();
            if (!$conn) {
                throw new Exception("Database connection failed");
            }
            error_log("Database connection successful");

            // Check if email already exists
            $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
            error_log("Checking for existing email: $email");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                error_log("Email already exists: $email");
                $message = 'Email already registered';
                $messageType = 'danger';
            } else {
                error_log("Email is unique, proceeding with registration");
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                error_log("Password hashed successfully");

                // Prepare SQL and parameters
                $sql = "INSERT INTO customers (first_name, last_name, email, password_hash, is_active, created_at) 
                        VALUES (?, ?, ?, ?, 1, NOW())";
                $params = [
                    $firstName,
                    $lastName,
                    $email,
                    $hashedPassword
                ];

                error_log("Preparing SQL: $sql");
                error_log("Parameters ready: " . print_r($params, true));
                
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                error_log("User inserted successfully");

                $userId = $conn->lastInsertId();
                error_log("New user ID: $userId");

                // Set session variables
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $firstName . ' ' . $lastName;
                $_SESSION['user_type'] = 'customer';
                error_log("Session variables set");

                // Redirect to user portal dashboard
                error_log("Redirecting to user portal dashboard");
                header('Location: user-portal/dashboard.php');
                exit;
            }
        } catch (PDOException $e) {
            error_log("Database error occurred:");
            error_log("Error message: " . $e->getMessage());
            error_log("Error code: " . $e->getCode());
            error_log("SQL State: " . $e->errorInfo[0]);
            error_log("Stack trace: " . $e->getTraceAsString());
            
            $message = 'An error occurred during registration. Please try again.';
            $messageType = 'danger';
        } catch (Exception $e) {
            error_log("General error occurred:");
            error_log("Error message: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            $message = 'An error occurred during registration. Please try again.';
            $messageType = 'danger';
        }
    }
}

// Start output buffering
ob_start();
?>

<!-- Register Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Create Your Account</h4>
                        <p class="text-muted mb-4">Join Artifitech and get access to our comprehensive educational technology solutions</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            This registration is for customers interested in our flagship products and academy courses only.
                            For administrative access, please contact the system administrator.
                        </div>
                    </div>
                    
                    <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $messageType; ?> mb-4">
                        <?php echo $message; ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="register.php">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?php echo isset($errors['first_name']) ? 'is-invalid' : ''; ?>" 
                                           id="firstName" name="first_name" placeholder="First Name" 
                                           value="<?php echo htmlspecialchars($firstName ?? ''); ?>" required>
                                    <label for="firstName">First Name</label>
                                    <?php if (isset($errors['first_name'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['first_name']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control <?php echo isset($errors['last_name']) ? 'is-invalid' : ''; ?>" 
                                           id="lastName" name="last_name" placeholder="Last Name" 
                                           value="<?php echo htmlspecialchars($lastName ?? ''); ?>" required>
                                    <label for="lastName">Last Name</label>
                                    <?php if (isset($errors['last_name'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['last_name']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                           id="email" name="email" placeholder="Your Email" 
                                           value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                                    <label for="email">Email Address</label>
                                    <?php if (isset($errors['email'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           placeholder="Phone Number" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                                    <label for="phone">Phone Number (Optional)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                                           id="password" name="password" placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <?php if (isset($errors['password'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['password']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                           id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>
                                    <label for="confirmPassword">Confirm Password</label>
                                    <?php if (isset($errors['confirm_password'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['confirm_password']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5 w-100" type="submit">
                                    Create Account
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <p class="text-muted mb-0">Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 