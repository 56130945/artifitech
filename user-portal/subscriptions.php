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
        SELECT s.*, p.name as product_name, p.description as product_description 
        FROM subscriptions s 
        JOIN products p ON s.product_id = p.id 
        WHERE s.customer_id = ? 
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
        // Get total spent
        try {
            $stmt = $conn->prepare("
                SELECT SUM(amount) as total 
                FROM invoices 
                WHERE customer_id = ? AND status = 'paid'
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
        // Get next payment
        try {
            $stmt = $conn->prepare("
                SELECT MIN(next_billing_date) as next_date 
                FROM subscriptions 
                WHERE customer_id = ? AND status = 'active'
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
            <div class="stats-label">Next Payment</div>
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
            <h5 class="table-title">Active Subscriptions</h5>
            <a href="../products.php" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-2"></i>Add New
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
                        <th>Next Billing</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($subscriptions)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-credit-card fa-2x text-muted mb-3"></i>
                            <p class="mb-0">You don't have any active subscriptions.</p>
                            <a href="../products.php" class="btn btn-sm btn-primary mt-3">
                                View Available Products
                            </a>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($subscriptions as $sub): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="../img/products/<?php echo strtolower(str_replace(' ', '-', $sub['product_name'])); ?>.png" 
                                     class="me-3" style="width: 40px; height: 40px; border-radius: 8px;" 
                                     alt="<?php echo htmlspecialchars($sub['product_name']); ?>">
                                <div>
                                    <h6 class="mb-0"><?php echo htmlspecialchars($sub['product_name']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($sub['plan_name']); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo $sub['status'] === 'active' ? 'success' : 'warning'; ?>">
                                <?php echo ucfirst($sub['status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($sub['plan_name']); ?></td>
                        <td>R<?php echo number_format($sub['amount'], 2); ?>/mo</td>
                        <td><?php echo date('d M Y', strtotime($sub['next_billing_date'])); ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="subscription-details.php?id=<?php echo $sub['id']; ?>" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-2"></i>View
                                </a>
                                <?php if ($sub['status'] === 'active'): ?>
                                <a href="subscription-cancel.php?id=<?php echo $sub['id']; ?>" 
                                   class="btn btn-sm btn-danger ms-2"
                                   onclick="return confirm('Are you sure you want to cancel this subscription?');">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <?php endif; ?>
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
            <h5 class="table-title">Billing History</h5>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get billing history
                    try {
                        $stmt = $conn->prepare("
                            SELECT * FROM invoices 
                            WHERE customer_id = ? 
                            ORDER BY created_at DESC 
                            LIMIT 10
                        ");
                        $stmt->execute([$_SESSION['user_id']]);
                        $invoices = $stmt->fetchAll();
                    } catch (Exception $e) {
                        error_log("Error fetching invoices: " . $e->getMessage());
                        $invoices = [];
                    }
                    ?>
                    <?php if (empty($invoices)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="fas fa-file-invoice fa-2x text-muted mb-3"></i>
                            <p class="mb-0">No billing history available</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-invoice text-primary me-3"></i>
                                <span><?php echo htmlspecialchars($invoice['invoice_number']); ?></span>
                            </div>
                        </td>
                        <td><?php echo date('d M Y', strtotime($invoice['created_at'])); ?></td>
                        <td>R<?php echo number_format($invoice['amount'], 2); ?></td>
                        <td>
                            <span class="badge bg-<?php 
                                echo $invoice['status'] === 'paid' ? 'success' : 
                                    ($invoice['status'] === 'pending' ? 'warning' : 'danger'); 
                            ?>">
                                <?php echo ucfirst($invoice['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="invoice-download.php?id=<?php echo $invoice['id']; ?>" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../includes/user_portal_template.php';
?> 