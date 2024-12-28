<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Get JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['product_id']) || !isset($data['plan'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required data']);
    exit();
}

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Start transaction
    $conn->beginTransaction();

    // Validate product exists and is active
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
    $stmt->execute([$data['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("Invalid or inactive product");
    }

    // Check if user exists and is active
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ? AND is_active = 1");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Invalid or inactive user");
    }

    // Check for existing active subscription
    $stmt = $conn->prepare("
        SELECT id FROM subscriptions 
        WHERE user_id = ? AND product_id = ? AND status = 'active'
    ");
    $stmt->execute([$_SESSION['user_id'], $data['product_id']]);
    
    if ($stmt->fetch()) {
        throw new Exception("Active subscription already exists for this product");
    }

    // Calculate dates
    $start_date = date('Y-m-d');
    $renewal_date = date('Y-m-d', strtotime('+1 month'));

    // Insert new subscription
    $stmt = $conn->prepare("
        INSERT INTO subscriptions (
            user_id,
            product_id,
            subscription_type,
            status,
            start_date,
            renewal_date
        ) VALUES (
            :user_id,
            :product_id,
            :subscription_type,
            'active',
            :start_date,
            :renewal_date
        )
    ");

    $result = $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':product_id' => $data['product_id'],
        ':subscription_type' => $data['plan'],
        ':start_date' => $start_date,
        ':renewal_date' => $renewal_date
    ]);

    if (!$result) {
        throw new Exception("Failed to create subscription");
    }

    $subscription_id = $conn->lastInsertId();

    // Create an order record
    $stmt = $conn->prepare("
        INSERT INTO orders (
            customer_id,
            product_id,
            plan,
            amount,
            status,
            payment_id
        ) VALUES (
            :customer_id,
            :product_id,
            :plan,
            :amount,
            'completed',
            :payment_id
        )
    ");

    $payment_id = 'PAY_' . time() . '_' . rand(1000, 9999);
    $amount = $product['monthly_price'] * 1.15; // Including VAT

    $result = $stmt->execute([
        ':customer_id' => $_SESSION['user_id'],
        ':product_id' => $data['product_id'],
        ':plan' => $data['plan'],
        ':amount' => $amount,
        ':payment_id' => $payment_id
    ]);

    if (!$result) {
        throw new Exception("Failed to create order record");
    }

    // Commit transaction
    $conn->commit();

    // Log the successful subscription
    error_log("New subscription created - User ID: {$_SESSION['user_id']}, Product ID: {$data['product_id']}, Plan: {$data['plan']}, Payment ID: {$payment_id}");

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Subscription created successfully',
        'subscription' => [
            'id' => $subscription_id,
            'product_name' => $product['name'],
            'start_date' => $start_date,
            'renewal_date' => $renewal_date,
            'status' => 'active',
            'payment_id' => $payment_id
        ]
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Subscription error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
