<?php
require_once '../includes/config.php';

$page = 'subscriptions';
$title = 'Manage Subscription - Artifitech';
require_once 'includes/template.php';

if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "No subscription specified.";
    header('Location: subscriptions.php');
    exit;
}

$subscription_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Get subscription details
$stmt = $conn->prepare("
    SELECT s.*, p.name as product_name, p.description as product_description, p.price 
    FROM subscriptions s 
    JOIN products p ON s.product_id = p.id 
    WHERE s.id = ? AND s.user_id = ?
");
$stmt->bind_param("ii", $subscription_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$subscription = $result->fetch_assoc();

if (!$subscription) {
    $_SESSION['error_message'] = "Subscription not found.";
    header('Location: subscriptions.php');
    exit;
}
?>

<!-- Main Content -->
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="admin-card">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <h4>Manage Subscription</h4>
                        <a href="subscriptions.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Subscriptions
                        </a>
                    </div>
                    <div class="admin-card-body">
                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                echo $_SESSION['success_message'];
                                unset($_SESSION['success_message']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                echo $_SESSION['error_message'];
                                unset($_SESSION['error_message']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-4">Subscription Details</h5>
                                <table class="table">
                                    <tr>
                                        <th>Product:</th>
                                        <td><?php echo htmlspecialchars($subscription['product_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Description:</th>
                                        <td><?php echo htmlspecialchars($subscription['product_description']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Price:</th>
                                        <td>$<?php echo number_format($subscription['price'], 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge bg-<?php echo $subscription['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                <?php echo ucfirst($subscription['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Start Date:</th>
                                        <td><?php echo date('M d, Y', strtotime($subscription['created_at'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Next Renewal:</th>
                                        <td>
                                            <?php 
                                            echo $subscription['renewal_date'] 
                                                ? date('M d, Y', strtotime($subscription['renewal_date']))
                                                : 'N/A'; 
                                            ?>
                                        </td>
                                    </tr>
                                </table>

                                <?php if ($subscription['status'] === 'active'): ?>
                                    <div class="mt-4">
                                        <button type="button" 
                                                class="btn btn-danger"
                                                onclick="confirmCancellation(<?php echo $subscription['id']; ?>)">
                                            <i class="fas fa-times"></i> Cancel Subscription
                                        </button>
                                    </div>
                                <?php elseif ($subscription['status'] === 'cancelled' || $subscription['status'] === 'expired'): ?>
                                    <div class="mt-4">
                                        <a href="checkout.php?product_id=<?php echo $subscription['product_id']; ?>" 
                                           class="btn btn-success">
                                            <i class="fas fa-sync"></i> Renew Subscription
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-4">Payment History</h5>
                                <!-- Add payment history table here when implemented -->
                                <div class="alert alert-info">
                                    Payment history will be available soon.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmCancellation(subscriptionId) {
    if (confirm('Are you sure you want to cancel this subscription? This action cannot be undone.')) {
        window.location.href = `process-cancellation.php?subscription_id=${subscriptionId}`;
    }
}
</script>

<?php require_once 'includes/footer.php'; ?> 