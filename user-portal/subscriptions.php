<?php
require_once '../includes/config.php';
require_once '../includes/auth_check.php';
require_once '../includes/db.php';

// Set page-specific variables
$page = 'subscriptions';
$title = "My Subscriptions - Artifitech User Portal";

// Get user's subscriptions
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT s.*, p.name as product_name, p.description as product_description, p.monthly_price,
               o.payment_id, o.amount as order_amount 
        FROM subscriptions s 
        JOIN products p ON s.product_id = p.id 
        LEFT JOIN orders o ON s.user_id = o.customer_id AND s.product_id = o.product_id 
        WHERE s.user_id = ? 
        ORDER BY s.created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $subscriptions = $stmt->fetchAll();
} catch (Exception $e) {
    error_log("Error fetching subscriptions: " . $e->getMessage());
    $subscriptions = [];
}

// Start output buffering
ob_start();
?>
<div class="content-wrapper">
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="stats-value"><?php echo count($subscriptions); ?></div>
            <div class="stats-label">Active Subscriptions</div>
        </div>

        <?php
        // Get total spent from orders
        try {
            $stmt = $conn->prepare("
                SELECT SUM(amount) as total 
                FROM orders 
                WHERE customer_id = ? AND status = 'completed'
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $total = $stmt->fetch()['total'] ?? 0;
        } catch (Exception $e) {
            $total = 0;
        }
        ?>
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-value">R<?php echo number_format($total, 0); ?></div>
            <div class="stats-label">Total Spent</div>
        </div>

        <?php
        // Get next renewal date
        try {
            $stmt = $conn->prepare("
                SELECT MIN(renewal_date) as next_date 
                FROM subscriptions 
                WHERE user_id = ? AND status = 'active'
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $next_date = $stmt->fetch()['next_date'];
        } catch (Exception $e) {
            $next_date = null;
        }
        ?>
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stats-value"><?php echo $next_date ? date('d M', strtotime($next_date)) : '-'; ?></div>
            <div class="stats-label">Next Renewal</div>
        </div>

        <?php
        // Get active products count
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM products WHERE status = 'active'");
            $stmt->execute();
            $products_count = $stmt->fetch()['count'];
        } catch (Exception $e) {
            $products_count = 0;
        }
        ?>
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-cube"></i>
            </div>
            <div class="stats-value"><?php echo $products_count; ?></div>
            <div class="stats-label">Available Products</div>
        </div>
    </div>

    <!-- Active Subscriptions -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">My Subscriptions</h5>
            <a href="../products.php" class="btn btn-sm" style="background-color: #06BBCC; color: white;">
                <i class="fas fa-plus me-2"></i>Subscribe to New Product
            </a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Start Date</th>
                        <th>Renewal Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($subscriptions)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-credit-card fa-2x text-muted mb-3"></i>
                            <p class="mb-0">You don't have any subscriptions yet.</p>
                            <a href="../products.php" class="btn btn-sm mt-3" style="background-color: #06BBCC; color: white;">
                                View Available Products
                            </a>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($subscriptions as $sub): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0"><?php echo htmlspecialchars($sub['product_name']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($sub['subscription_type']); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?php echo $sub['status'] === 'active' ? 'bg-success' : ($sub['status'] === 'cancelled' ? 'bg-danger' : 'bg-warning'); ?>">
                                <?php echo ucfirst($sub['status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($sub['subscription_type']); ?></td>
                        <td>R<?php echo number_format($sub['monthly_price'], 2); ?>/month</td>
                        <td><?php echo date('d M Y', strtotime($sub['start_date'])); ?></td>
                        <td><?php echo date('d M Y', strtotime($sub['renewal_date'])); ?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm" style="background-color: #06BBCC; color: white;" 
                                        data-bs-toggle="modal" data-bs-target="#subscriptionModal<?php echo $sub['id']; ?>">
                                    <i class="fas fa-eye me-2"></i>Details
                                </button>
                                <?php if ($sub['status'] === 'active'): ?>
                                <button type="button" class="btn btn-sm btn-danger ms-2" 
                                        onclick="cancelSubscription(<?php echo $sub['id']; ?>)">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <?php endif; ?>
                            </div>

                            <!-- Subscription Details Modal -->
                            <div class="modal fade" id="subscriptionModal<?php echo $sub['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Subscription Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <h6>Product Information</h6>
                                                <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($sub['product_name']); ?></p>
                                                <p class="mb-1"><strong>Description:</strong> <?php echo htmlspecialchars($sub['product_description']); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Subscription Details</h6>
                                                <p class="mb-1"><strong>Plan:</strong> <?php echo htmlspecialchars($sub['subscription_type']); ?></p>
                                                <p class="mb-1"><strong>Status:</strong> <?php echo ucfirst($sub['status']); ?></p>
                                                <p class="mb-1"><strong>Start Date:</strong> <?php echo date('d M Y', strtotime($sub['start_date'])); ?></p>
                                                <p class="mb-1"><strong>Renewal Date:</strong> <?php echo date('d M Y', strtotime($sub['renewal_date'])); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Payment Information</h6>
                                                <p class="mb-1"><strong>Monthly Amount:</strong> R<?php echo number_format($sub['monthly_price'], 2); ?></p>
                                                <p class="mb-1"><strong>Payment ID:</strong> <?php echo $sub['payment_id'] ?? 'N/A'; ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Billing History -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">Payment History</h5>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Product</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get payment history
                    try {
                        $stmt = $conn->prepare("
                            SELECT o.*, p.name as product_name 
                            FROM orders o
                            JOIN products p ON o.product_id = p.id
                            WHERE o.customer_id =?
                            ORDER BY o.created_at DESC
                        ");
                        $stmt->execute([$_SESSION['user_id']]);
                        $orders = $stmt->fetchAll();

                        if (empty($orders)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-receipt fa-2x text-muted mb-3"></i>
                                    <p class="mb-0">No payment history available.</p>
                                </td>
                            </tr>
                        <?php else:
                            foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['payment_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                                    <td>R<?php echo number_format($order['amount'], 2); ?></td>
                                    <td>
                                        <span class="badge <?php echo $order['status'] === 'completed' ? 'bg-success' : 'bg-warning'; ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif;
                    } catch (Exception $e) {
                        echo '<tr><td colspan="5" class="text-center">Error loading payment history.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Cancel Subscription Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this subscription? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep It</button>
                <button type="button" class="btn btn-danger" id="confirmCancel">Yes, Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
let subscriptionToCancel = null;

function cancelSubscription(id) {
    subscriptionToCancel = id;
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}

document.getElementById('confirmCancel').addEventListener('click', async function() {
    if (!subscriptionToCancel) return;

    try {
        const response = await fetch('process-cancellation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                subscription_id: subscriptionToCancel
            })
        });

        const result = await response.json();

        if (result.success) {
            location.reload();
        } else {
            alert(result.error || 'Failed to cancel subscription');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while cancelling the subscription');
    }
});
</script>

<?php
$content = ob_get_clean();
include '../includes/user_portal_template.php';
?>