<?php
require_once '../includes/config.php';
require_once 'includes/template.php';

if (!isset($_GET['subscription_id'])) {
    $_SESSION['error_message'] = "No subscription specified.";
    header('Location: subscriptions.php');
    exit;
}

$subscription_id = (int)$_GET['subscription_id'];
$user_id = $_SESSION['user_id'];

try {
    // Verify the subscription belongs to the user
    $stmt = $conn->prepare("
        SELECT * FROM subscriptions 
        WHERE id = ? AND user_id = ? AND status = 'active'
    ");
    $stmt->bind_param("ii", $subscription_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "Invalid subscription or already cancelled.";
        header('Location: subscriptions.php');
        exit;
    }

    // Cancel the subscription
    $stmt = $conn->prepare("
        UPDATE subscriptions 
        SET status = 'cancelled', 
            updated_at = CURRENT_TIMESTAMP 
        WHERE id = ? AND user_id = ?
    ");
    $stmt->bind_param("ii", $subscription_id, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Subscription cancelled successfully.";
    } else {
        $_SESSION['error_message'] = "Error cancelling subscription. Please try again.";
    }

} catch (Exception $e) {
    error_log("Error cancelling subscription: " . $e->getMessage());
    $_SESSION['error_message'] = "An error occurred. Please try again later.";
}

header('Location: subscriptions.php');
exit;
  </rewritten_file> 