<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

// Import Stripe namespaces
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Exception\ApiErrorException;

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json');

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate input
    if (!isset($input['payment_method_id']) || !isset($input['product_id']) || !isset($input['plan'])) {
        throw new Exception('Missing required parameters');
    }

    $conn = getDBConnection();
    
    // Get product details
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE id = ? AND status = 'active'
    ");
    $stmt->execute([$input['product_id']]);
    $product = $stmt->fetch();
    
    if (!$product) {
        throw new Exception('Invalid product');
    }

    // Get user details
    $stmt = $conn->prepare("
        SELECT * FROM customers 
        WHERE id = ? AND is_active = 1
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception('Invalid user');
    }

    // Initialize Stripe
    require_once '../vendor/autoload.php';
    
    // Check if STRIPE_SECRET_KEY is defined
    if (!defined('STRIPE_SECRET_KEY')) {
        throw new Exception('Stripe secret key is not configured');
    }
    
    Stripe::setApiKey(STRIPE_SECRET_KEY);

    // Create or get Stripe customer
    if (!$user['stripe_customer_id']) {
        $stripe_customer = Customer::create([
            'email' => $user['email'],
            'payment_method' => $input['payment_method_id'],
            'invoice_settings' => [
                'default_payment_method' => $input['payment_method_id'],
            ],
        ]);

        // Save Stripe customer ID
        $stmt = $conn->prepare("
            UPDATE customers 
            SET stripe_customer_id = ? 
            WHERE id = ?
        ");
        $stmt->execute([$stripe_customer->id, $user['id']]);
    } else {
        $stripe_customer = Customer::retrieve($user['stripe_customer_id']);
        
        // Update default payment method
        Customer::update($stripe_customer->id, [
            'invoice_settings' => [
                'default_payment_method' => $input['payment_method_id'],
            ],
        ]);
    }

    // Calculate price in cents
    $price_in_cents = (int)($product['monthly_price'] * 100);

    // Create subscription
    $subscription = Subscription::create([
        'customer' => $stripe_customer->id,
        'items' => [[
            'price_data' => [
                'currency' => 'zar',
                'product' => $product['stripe_product_id'],
                'unit_amount' => $price_in_cents,
                'recurring' => [
                    'interval' => 'month',
                ],
            ],
        ]],
        'payment_behavior' => 'default_incomplete',
        'expand' => ['latest_invoice.payment_intent'],
    ]);

    // Save subscription to database
    $stmt = $conn->prepare("
        INSERT INTO subscriptions (
            user_id, product_id, stripe_subscription_id, 
            plan_type, status, monthly_price, 
            start_date, renewal_date
        ) VALUES (?, ?, ?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))
    ");
    $stmt->execute([
        $user['id'],
        $product['id'],
        $subscription->id,
        $input['plan'],
        'active',
        $product['monthly_price']
    ]);

    echo json_encode([
        'success' => true,
        'subscription' => [
            'id' => $subscription->id,
            'client_secret' => $subscription->latest_invoice->payment_intent->client_secret,
        ],
    ]);

} catch (ApiErrorException $e) {
    // Handle Stripe API errors
    error_log("Stripe API error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    error_log("Payment processing error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 