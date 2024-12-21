<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Check if product_id is provided
if (!isset($_GET['product_id']) || !isset($_GET['plan'])) {
    header('Location: dashboard.php');
    exit();
}

$product_id = $_GET['product_id'];
$plan = $_GET['plan'];

try {
    $conn = getDBConnection();
    
    // Get product details
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE id = ? AND status = 'active'
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        header('Location: dashboard.php');
        exit();
    }

    // Get user details
    $stmt = $conn->prepare("
        SELECT * FROM customers 
        WHERE id = ? AND is_active = 1
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

} catch (Exception $e) {
    error_log("Checkout error: " . $e->getMessage());
    header('Location: dashboard.php?error=1');
    exit();
}

// Set page-specific variables
$page = 'checkout';
$title = "Checkout - " . htmlspecialchars($product['name']);

// Start output buffering
ob_start();
?>

<!-- Checkout Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Complete Your Purchase</h4>
                        <p class="text-muted mb-4">You're about to subscribe to <?php echo htmlspecialchars($product['name']); ?></p>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary mb-4">
                        <h5 class="mb-3">Order Summary</h5>
                        <div class="bg-white p-4 rounded">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Plan</span>
                                <span class="fw-bold"><?php echo ucfirst($plan); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Price</span>
                                <span class="fw-bold">R<?php echo number_format($product['monthly_price'], 2); ?>/month</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Total (incl. VAT)</span>
                                <span class="fw-bold text-primary">R<?php echo number_format($product['monthly_price'] * 1.15, 2); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form id="payment-form">
                        <input type="hidden" id="product-id" value="<?php echo $product_id; ?>">
                        <input type="hidden" id="plan" value="<?php echo $plan; ?>">
                        
                        <div class="mb-4">
                            <label class="form-label">Card Information</label>
                            <div id="card-element" class="form-control">
                                <!-- Stripe Card Element will be inserted here -->
                            </div>
                            <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill py-3 px-5 w-100" id="submit-button">
                            <span id="button-text">Pay Now</span>
                            <span id="spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            By completing this purchase, you agree to our 
                            <a href="../terms.php" class="text-primary">Terms of Service</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Section End -->

<!-- Add Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
    const elements = stripe.elements();

    // Create card element
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
            },
        },
    });

    card.mount('#card-element');

    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('button-text');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        // Disable form submission
        submitButton.disabled = true;
        spinner.classList.remove('d-none');
        buttonText.textContent = 'Processing...';

        try {
            const {paymentMethod, error} = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                throw error;
            }

            // Send payment to server
            const response = await fetch('process-payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethod.id,
                    product_id: document.getElementById('product-id').value,
                    plan: document.getElementById('plan').value
                }),
            });

            const result = await response.json();

            if (result.error) {
                throw new Error(result.error);
            }

            // Redirect to success page
            window.location.href = 'payment-success.php';

        } catch (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            
            // Re-enable form submission
            submitButton.disabled = false;
            spinner.classList.add('d-none');
            buttonText.textContent = 'Pay Now';
        }
    });
});
</script>

<?php
$content = ob_get_clean();
include '../includes/template.php';
?> 