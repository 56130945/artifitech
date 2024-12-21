<?php
require_once 'includes/template.php';
require_once 'includes/db.php';

if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit();
}

$order = get_order_details($_GET['order_id']);
render_header("Payment Successful");
?>

<div class="success-container">
    <div class="success-message">
        <h1>Thank You for Your Purchase!</h1>
        <p>Your order has been successfully processed.</p>
        <div class="order-details">
            <h2>Order Details</h2>
            <p>Order ID: <?php echo htmlspecialchars($order['id']); ?></p>
            <p>Amount: $<?php echo number_format($order['amount'], 2); ?></p>
            <p>Product: <?php echo htmlspecialchars($order['product_name']); ?></p>
        </div>
        <p>A confirmation email has been sent to your email address.</p>
        <a href="index.php" class="button">Return to Homepage</a>
    </div>
</div>

<?php render_footer(); ?> 