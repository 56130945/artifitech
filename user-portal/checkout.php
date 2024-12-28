<?php
// Include necessary files
require_once '../includes/config.php';
require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Check if product_id is provided
if (!isset($_GET['product_id']) || !isset($_GET['plan'])) {
    header('Location: ../user-portal/dashboard.php');
    exit();
}

$product_id = $_GET['product_id'];
$plan = $_GET['plan'];

try {
    // Get database connection using PDO
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Get product details
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE id = ? AND status = 'active'
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        header('Location: ../user-portal/dashboard.php');
        exit();
    }

    // Get user details
    $stmt = $conn->prepare("
        SELECT * FROM customers 
        WHERE id = ? AND is_active = 1
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: ../login.php');
        exit();
    }

} catch (Exception $e) {
    error_log("Checkout error: " . $e->getMessage());
    header('Location: ../user-portal/dashboard.php?error=1');
    exit();
}

// Set page-specific variables
$title = "Checkout - " . htmlspecialchars($product['name']);
$page = 'checkout';

// Start output buffering
ob_start();
?>

<!-- Checkout Section Start -->
<div class="container-xxl py-5" style="background-color: #F0F2F5;">
    <div class="container">
        <!-- Branding -->
        <div class="text-center mb-4">
            <img src="../img/logo.png" alt="Artifitech" class="img-fluid mb-3" style="height: 50px;">
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <!-- Order Header -->
                        <div class="text-center mb-4">
                            <h4 style="color: #06BBCC;" class="fw-bold mb-3">Complete Your Purchase</h4>
                            <p class="text-muted">You're about to subscribe to <?php echo htmlspecialchars($product['name']); ?></p>
                        </div>

                        <!-- Order Summary -->
                        <div class="order-summary mb-4">
                            <h5 class="card-title fw-bold mb-3">Order Summary</h5>
                            <div class="bg-light p-4 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Plan</span>
                                    <span class="fw-bold" style="color: #06BBCC;"><?php echo ucfirst($plan); ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Price</span>
                                    <span class="fw-bold">R<?php echo number_format($product['monthly_price'], 2); ?>/month</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Total (incl. VAT)</span>
                                    <span class="fw-bold h5 mb-0" style="color: #06BBCC;">R<?php echo number_format($product['monthly_price'] * 1.15, 2); ?></span>
                                </div>
                            </div>
                        </div>

                        <?php if (false): ?>
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-tools" style="font-size: 3rem; color: #06BBCC;"></i>
                            </div>
                            <h5 class="fw-bold mb-3" style="color: #06BBCC;">Payment System Unavailable</h5>
                            <p class="text-muted mb-4">
                                Our payment system is currently being set up. Please try again later or contact support for assistance.
                            </p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-center">
                                <a href="dashboard.php" class="btn rounded-pill py-3 px-5" style="background-color: #06BBCC; color: white;">
                                    <i class="fas fa-arrow-left me-2"></i>Return to Dashboard
                                </a>
                                <a href="support.php" class="btn rounded-pill py-3 px-5" style="color: #06BBCC; border-color: #06BBCC;">
                                    <i class="fas fa-headset me-2"></i>Contact Support
                                </a>
                            </div>
                        </div>
                        <?php else: ?>
                        <!-- Simplified Payment Form -->
                        <form id="payment-form">
                            <input type="hidden" id="product-id" value="<?php echo $product_id; ?>">
                            <input type="hidden" id="plan" value="<?php echo $plan; ?>">
                            <button type="submit" class="btn rounded-pill py-3 px-5 w-100 fw-bold" style="background-color: #06BBCC; color: white;" id="submit-button">
                                <span id="button-text">Pay Now</span>
                                <span id="spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                            </button>
                        </form>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('payment-form');
                            const submitButton = document.getElementById('submit-button');
                            const spinner = document.getElementById('spinner');
                            const buttonText = document.getElementById('button-text');

                            if (!form) return;

                            form.addEventListener('submit', async function(event) {
                                event.preventDefault();
                                submitButton.disabled = true;
                                spinner.classList.remove('d-none');
                                buttonText.textContent = 'Processing...';

                                try {
                                    const response = await fetch('process-payment.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            payment_method_id: 'dummy_method',
                                            product_id: document.getElementById('product-id').value,
                                            plan: document.getElementById('plan').value
                                        })
                                    });

                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }

                                    const result = await response.json();

                                    if (result.error) {
                                        throw new Error(result.error);
                                    }

                                    window.location.href = 'dashboard.php';

                                } catch (error) {
                                    console.error('Payment error:', error);
                                    submitButton.disabled = false;
                                    spinner.classList.add('d-none');
                                    buttonText.textContent = 'Pay Now';
                                }
                            });
                        });
                        </script>
                        <?php endif; ?>

                        <div class="text-center mt-4">
                            <a href="dashboard.php" class="btn btn-secondary rounded-pill py-3 px-5">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Security Badges -->
                <div class="text-center mt-4">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <i class="fas fa-lock" style="font-size: 1.2rem; color: #06BBCC;"></i>
                        <span class="text-muted small">Secure Payment Processing</span>
                        <i class="fas fa-shield-alt" style="font-size: 1.2rem; color: #06BBCC;"></i>
                        <span class="text-muted small">SSL Encrypted</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Section End -->

<!-- Pay Now Button -->
<form method="post" action="">
    <div class="text-center mt-4">
        <button type="submit" name="pay_now" class="btn btn-primary btn-lg">Pay Now</button>
    </div>
</form>

<?php
// Handle Pay Now button click
if (isset($_POST['pay_now'])) {
    // Simulate successful payment
    echo '<div class="alert alert-success text-center mt-4">Payment Successful!</div>';
    
    // Redirect to dashboard with product details after 2 seconds
    echo '<script>
        setTimeout(function() {
            window.location.href = "../user-portal/dashboard.php?product_name=' . urlencode($product['name']) . '&renewal_date=' . urlencode(date('Y-m-d', strtotime('+1 month'))) . '";
        }, 2000);
    </script>';
}
?>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 