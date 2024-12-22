<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    header('Location: dashboard.php');
    exit();
}

try {
    // Get order details
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT o.*, p.name as product_name 
        FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE o.payment_id = ? AND o.customer_id = ?
    ");
    $stmt->execute([$_GET['order_id'], $_SESSION['user_id']]);
    $order = $stmt->fetch();

    if (!$order) {
        header('Location: dashboard.php');
        exit();
    }
} catch (Exception $e) {
    error_log("Payment success error: " . $e->getMessage());
    header('Location: dashboard.php?error=1');
    exit();
}

// Set page-specific variables
$title = "Payment Successful";
$page = 'payment-success';

// Start output buffering
ob_start();
?>

<!-- Success Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light rounded h-100 p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="mb-4">Payment Successful!</h2>
                    <div class="order-details bg-white p-4 rounded mb-4">
                        <h5 class="mb-3">Order Details</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Product:</span>
                            <span class="fw-bold"><?php echo htmlspecialchars($order['product_name']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Plan:</span>
                            <span class="fw-bold"><?php echo ucfirst($order['plan']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Amount Paid:</span>
                            <span class="fw-bold">R<?php echo number_format($order['amount'], 2); ?></span>
                        </div>
                    </div>
                    <p class="text-muted mb-4">
                        Thank you for your purchase. Your subscription has been activated successfully.
                        You can now access all the features of your plan.
                    </p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-center">
                        <a href="dashboard.php" class="btn btn-primary rounded-pill py-3 px-5">Go to Dashboard</a>
                        <a href="support.php" class="btn btn-outline-primary rounded-pill py-3 px-5">Need Help?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Success Section End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 