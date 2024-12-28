<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

try {
    // Get database connection using PDO
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Validate input
    if (!isset($input['product_id']) || !isset($input['plan']) || !isset($input['payment_method_id'])) {
        throw new Exception('Missing required fields');
    }

    $product_id = $input['product_id'];
    $plan = $input['plan'];
    $payment_method_id = $input['payment_method_id'];

    // Get product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        throw new Exception('Product not found or inactive');
    }

    // Calculate amount with VAT
    $amount = $product['monthly_price'] * 1.15;

    // Simulate payment confirmation
    $paymentSucceeded = true; // Always succeed

    if ($paymentSucceeded) {
        // Start transaction
        $conn->beginTransaction();

        // Create order
        $stmt = $conn->prepare("
            INSERT INTO orders (customer_id, product_id, plan, amount, status, payment_id)
            VALUES (?, ?, ?, ?, 'completed', ?)
        ");
        $stmt->execute([
            $_SESSION['user_id'],
            $product_id,
            $plan,
            $amount,
            uniqid('dummy_', true) // Use a unique ID for dummy payment
        ]);

        // Insert new subscription
        $stmt = $conn->prepare("
            INSERT INTO subscriptions (user_id, product_id, plan, renewal_date, status)
            VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 1 MONTH), 'active')
        ");
        $stmt->execute([$_SESSION['user_id'], $product_id, $plan]);

        // Commit transaction
        $conn->commit();

        // Return success response
        echo json_encode(['success' => true]);
        exit();
    } else {
        throw new Exception('Payment failed');
    }

} catch (Exception $e) {
    // Rollback transaction if started
    if ($conn && $conn->inTransaction()) {
        $conn->rollBack();
    }

    error_log("Payment processing error: " . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
} 