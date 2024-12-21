<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth_check.php';

// Set page-specific variables
$page = 'invoices';
$title = "Billing History - Artifitech";

// Initialize all variables with default values
$invoices = [];
$error = null;
$totalSpent = 0;
$monthSpent = 0;
$pendingAmount = 0;

// Get user's invoices and billing stats
try {
    $conn = getDBConnection();
    
    // Get all invoices
    $stmt = $conn->prepare("
        SELECT i.*, s.product_id, p.name as product_name
        FROM invoices i
        LEFT JOIN subscriptions s ON i.subscription_id = s.id
        LEFT JOIN products p ON s.product_id = p.id
        WHERE i.customer_id = ?
        ORDER BY i.created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get total amount spent
    $stmt = $conn->prepare("
        SELECT COALESCE(SUM(amount), 0) as total_spent
        FROM invoices
        WHERE customer_id = ? AND status = 'paid'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $totalSpent = $stmt->fetch(PDO::FETCH_ASSOC)['total_spent'];

    // Get this month's spending
    $stmt = $conn->prepare("
        SELECT COALESCE(SUM(amount), 0) as month_spent
        FROM invoices
        WHERE customer_id = ? 
        AND status = 'paid'
        AND MONTH(created_at) = MONTH(CURRENT_DATE())
        AND YEAR(created_at) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $monthSpent = $stmt->fetch(PDO::FETCH_ASSOC)['month_spent'];

    // Get pending payments
    $stmt = $conn->prepare("
        SELECT COALESCE(SUM(amount), 0) as pending_amount
        FROM invoices
        WHERE customer_id = ? AND status = 'pending'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $pendingAmount = $stmt->fetch(PDO::FETCH_ASSOC)['pending_amount'];

} catch (PDOException $e) {
    error_log("Error fetching invoices: " . $e->getMessage());
    $error = "An error occurred while loading your billing history. Our team has been notified.";
}

ob_start();
?>

<div class="content-wrapper">
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stats-value">R<?php echo number_format($totalSpent, 0); ?></div>
            <div class="stats-label">Total Spent</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stats-value">R<?php echo number_format($monthSpent, 0); ?></div>
            <div class="stats-label">This Month</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">R<?php echo number_format($pendingAmount, 0); ?></div>
            <div class="stats-label">Pending Payments</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stats-value"><?php echo count($invoices); ?></div>
            <div class="stats-label">Total Invoices</div>
        </div>
    </div>

    <!-- Recent Invoices -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">Recent Invoices</h5>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="?filter=all">All Invoices</a></li>
                    <li><a class="dropdown-item" href="?filter=paid">Paid Only</a></li>
                    <li><a class="dropdown-item" href="?filter=pending">Pending Only</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?filter=this-month">This Month</a></li>
                    <li><a class="dropdown-item" href="?filter=last-month">Last Month</a></li>
                </ul>
            </div>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Product</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($invoices)): ?>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-invoice text-primary me-3"></i>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($invoice['invoice_number']); ?></h6>
                                            <small class="text-muted">Invoice</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($invoice['product_name']): ?>
                                        <div class="d-flex align-items-center">
                                            <img src="../img/products/<?php echo strtolower(str_replace(' ', '-', $invoice['product_name'])); ?>.png" 
                                                 class="me-3" style="width: 32px; height: 32px; border-radius: 6px; object-fit: cover;" 
                                                 alt="<?php echo htmlspecialchars($invoice['product_name']); ?>">
                                            <span><?php echo htmlspecialchars($invoice['product_name']); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo date('M d, Y', strtotime($invoice['created_at'])); ?>
                                    <br>
                                    <small class="text-muted"><?php echo date('h:i A', strtotime($invoice['created_at'])); ?></small>
                                </td>
                                <td>
                                    <h6 class="mb-0">R<?php echo number_format($invoice['amount'], 2); ?></h6>
                                    <?php if ($invoice['status'] === 'pending'): ?>
                                        <small class="text-warning">Due <?php echo date('M d, Y', strtotime($invoice['due_date'])); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $invoice['status'] === 'paid' ? 'success' : 
                                            ($invoice['status'] === 'pending' ? 'warning' : 'danger'); 
                                    ?>">
                                        <?php echo ucfirst($invoice['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="invoice-download.php?id=<?php echo $invoice['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-download me-2"></i>Download
                                        </a>
                                        <?php if ($invoice['status'] === 'pending'): ?>
                                            <a href="process-payment.php?invoice_id=<?php echo $invoice['id']; ?>" 
                                               class="btn btn-sm btn-primary ms-2">
                                                <i class="fas fa-credit-card me-2"></i>Pay Now
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-file-invoice fa-2x text-muted mb-3"></i>
                                <p class="mb-0">No invoices found.</p>
                                <p class="text-muted">Your billing history will appear here.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">Payment Methods</h5>
            <a href="add-payment-method.php" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-2"></i>Add New
            </a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Card</th>
                        <th>Type</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get payment methods
                    try {
                        $stmt = $conn->prepare("
                            SELECT * FROM payment_methods
                            WHERE customer_id = ?
                            ORDER BY is_default DESC, created_at DESC
                        ");
                        $stmt->execute([$_SESSION['user_id']]);
                        $paymentMethods = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
                    } catch (PDOException $e) {
                        $paymentMethods = [];
                    }
                    ?>
                    <?php if (!empty($paymentMethods)): ?>
                        <?php foreach ($paymentMethods as $method): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="<?php 
                                            echo $method['card_type'] === 'visa' ? 'fab fa-cc-visa' : 
                                                ($method['card_type'] === 'mastercard' ? 'fab fa-cc-mastercard' : 
                                                'fas fa-credit-card'); 
                                        ?> fa-2x text-primary me-3"></i>
                                        <div>
                                            <h6 class="mb-0">**** **** **** <?php echo htmlspecialchars($method['last_four']); ?></h6>
                                            <small class="text-muted"><?php echo $method['is_default'] ? 'Default Card' : ''; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo ucfirst($method['card_type']); ?></td>
                                <td><?php echo date('m/y', strtotime($method['expiry_date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $method['status'] === 'active' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($method['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <?php if (!$method['is_default']): ?>
                                            <a href="set-default-payment.php?id=<?php echo $method['id']; ?>" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-star me-2"></i>Set Default
                                            </a>
                                        <?php endif; ?>
                                        <a href="remove-payment-method.php?id=<?php echo $method['id']; ?>" 
                                           class="btn btn-sm btn-danger ms-2"
                                           onclick="return confirm('Are you sure you want to remove this payment method?');">
                                            <i class="fas fa-trash me-2"></i>Remove
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-credit-card fa-2x text-muted mb-3"></i>
                                <p class="mb-0">No payment methods added yet.</p>
                                <a href="add-payment-method.php" class="btn btn-sm btn-primary mt-3">
                                    Add Payment Method
                                </a>
                            </td>
                        </tr>
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