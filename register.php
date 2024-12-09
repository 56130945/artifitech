<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';

// Set page-specific variables
$page = 'register';
$title = "Artifitech - Register | Educational Technology Solutions";
$keywords = "Register, Create Account, Sign Up, New User Registration";
$description = "Create your Artifitech account to access our full range of educational technology solutions and services.";
$og_title = "Register - Artifitech Educational Technology Solutions";
$og_description = "Create your Artifitech account";
$og_url = "https://artifitech.com/register";

// Process form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log the start of registration process
    error_log("Registration process started");
    error_log("POST data: " . print_r($_POST, true));

    // Get and sanitize inputs
    $firstName = sanitizeInput($_POST['first_name'] ?? '');
    $lastName = sanitizeInput($_POST['last_name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $institution = sanitizeInput($_POST['institution'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    error_log("Sanitized inputs received:");
    error_log("First Name: $firstName");
    error_log("Last Name: $lastName");
    error_log("Email: $email");
    error_log("Phone: $phone");
    error_log("Institution: $institution");

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
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
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

                // Insert new user
                $sql = "INSERT INTO users (first_name, last_name, email, phone, institution, password, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())";
                error_log("Preparing SQL: $sql");
                
                $stmt = $conn->prepare($sql);
                error_log("Statement prepared successfully");
                
                $params = [
                    $firstName,
                    $lastName,
                    $email,
                    $phone,
                    $institution,
                    $hashedPassword
                ];
                error_log("Parameters ready: " . print_r($params, true));
                
                $stmt->execute($params);
                error_log("User inserted successfully");

                $userId = $conn->lastInsertId();
                error_log("New user ID: $userId");

                // Set session variables
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $firstName . ' ' . $lastName;
                error_log("Session variables set");

                // Redirect to home page
                error_log("Redirecting to index.php");
                header('Location: index.php');
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

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Register</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Register</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Register Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Create Your Account</h4>
                        <p class="text-muted mb-4">Join Artifitech and get access to our comprehensive educational technology solutions</p>
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
                                    <input type="text" class="form-control <?php echo isset($errors['institution']) ? 'is-invalid' : ''; ?>" 
                                           id="institution" name="institution" placeholder="Institution" 
                                           value="<?php echo htmlspecialchars($institution ?? ''); ?>" required>
                                    <label for="institution">Institution</label>
                                    <?php if (isset($errors['institution'])): ?>
                                        <div class="invalid-feedback"><?php echo $errors['institution']; ?></div>
                                    <?php endif; ?>
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