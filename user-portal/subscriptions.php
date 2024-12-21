<?php
require_once '../includes/config.php';

$page = 'subscriptions';
$title = 'My Subscriptions - Artifitech';
require_once 'includes/template.php';

// Create subscriptions table if it doesn't exist
$conn->query("
    CREATE TABLE IF NOT EXISTS subscriptions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        status ENUM('active', 'cancelled', 'expired') NOT NULL DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        renewal_date DATE,
        FOREIGN KEY (user_id) REFERENCES customers(id) ON DELETE CASCADE
    )
");

// Create products table if it doesn't exist
$conn->query("
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Get user's subscriptions
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT s.*, p.name as product_name, p.description as product_description, p.price 
    FROM subscriptions s 
    JOIN products p ON s.product_id = p.id 
    WHERE s.user_id = ? 
    ORDER BY s.status = 'active' DESC, s.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$subscriptions = $result->fetch_all(MYSQLI_ASSOC);
?>

<!-- Main Content -->
<div class="admin-main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="admin-card">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <h4>My Subscriptions</h4>
                        <a href="checkout.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Subscription
                        </a>
                    </div>
                    <div class="admin-card-body">
                        <?php if (!empty($subscriptions)): ?>
                            <div class="table-responsive">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Start Date</th>
                                            <th>Renewal Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($subscriptions as $subscription): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($subscription['product_name']); ?></td>
                                                <td><?php echo htmlspecialchars($subscription['product_description']); ?></td>
                                                <td>$<?php echo number_format($subscription['price'], 2); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($subscription['created_at'])); ?></td>
                                                <td>
                                                    <?php 
                                                    echo $subscription['renewal_date'] 
                                                        ? date('M d, Y', strtotime($subscription['renewal_date']))
                                                        : 'N/A'; 
                                                    ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?php echo $subscription['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($subscription['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($subscription['status'] === 'active'): ?>
                                                        <a href="subscription.php?id=<?php echo $subscription['id']; ?>" 
                                                           class="btn btn-sm btn-primary">Manage</a>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-danger"
                                                                onclick="confirmCancellation(<?php echo $subscription['id']; ?>)">
                                                            Cancel
                                                        </button>
                                                    <?php else: ?>
                                                        <a href="checkout.php?product_id=<?php echo $subscription['product_id']; ?>" 
                                                           class="btn btn-sm btn-success">Renew</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-subscription fa-3x text-muted mb-3"></i>
                                <h5>No Subscriptions Found</h5>
                                <p class="text-muted">You don't have any subscriptions yet.</p>
                                <a href="checkout.php" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i> Get Started
                                </a>
                            </div>
                        <?php endif; ?>
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