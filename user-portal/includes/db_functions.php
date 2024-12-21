<?php
require_once 'config/db.php';

/**
 * Get product details from the database
 * @param int $product_id
 * @return array|false Product details or false if not found
 */
function get_product_details($product_id) {
    global $db;
    
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Save order details to the database
 * @param array $order_data Order details
 * @return int|false The order ID or false on failure
 */
function save_order($order_data) {
    global $db;
    
    $stmt = $db->prepare("
        INSERT INTO orders (product_id, user_email, amount, payment_id, status)
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $order_data['product_id'],
        $order_data['user_email'],
        $order_data['amount'],
        $order_data['payment_id'],
        $order_data['status']
    ]);
    
    return $success ? $db->lastInsertId() : false;
}

/**
 * Get order details from the database
 * @param int $order_id
 * @return array|false Order details or false if not found
 */
function get_order_details($order_id) {
    global $db;
    
    $stmt = $db->prepare("
        SELECT o.*, p.name as product_name 
        FROM orders o 
        JOIN products p ON o.product_id = p.id 
        WHERE o.id = ?
    ");
    $stmt->execute([$order_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
} 