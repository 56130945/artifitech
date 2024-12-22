<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'dashboard';
$title = "Dashboard - Artifitech Admin";
$description = "Overview of system activity and statistics";

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Get quick stats
    $stats = [
        'total_users' => 0,
        'active_users' => 0,
        'total_orders' => 0,
        'total_revenue' => 0
    ];

    // Get total and active users
    $stmt = $conn->query("SELECT COUNT(*) FROM customers");
    $stats['total_users'] = $stmt->fetchColumn();

    $stmt = $conn->query("SELECT COUNT(*) FROM customers WHERE is_active = 1");
    $stats['active_users'] = $stmt->fetchColumn();

    // Get total orders
    $stmt = $conn->query("SELECT COUNT(*) FROM orders");
    $stats['total_orders'] = $stmt->fetchColumn();

    // Get total revenue
    $stmt = $conn->query("SELECT COALESCE(SUM(amount), 0) FROM orders WHERE status = 'completed'");
    $stats['total_revenue'] = $stmt->fetchColumn();

} catch (Exception $e) {
    error_log("Error in dashboard.php: " . $e->getMessage());
    $error = "An error occurred while loading the dashboard.";
}

// Start output buffering
ob_start();
?>

<!-- Stats Cards Start -->
<div class="stats-grid">
    <div class="stats-card">
        <div class="stats-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stats-value">
            <?php echo number_format($stats['total_users']); ?>
        </div>
        <div class="stats-label">Total Users</div>
    </div>

    <div class="stats-card">
        <div class="stats-icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stats-value">
            <?php echo number_format($stats['active_users']); ?>
        </div>
        <div class="stats-label">Active Users</div>
    </div>

    <div class="stats-card">
        <div class="stats-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stats-value">
            <?php echo number_format($stats['total_orders']); ?>
        </div>
        <div class="stats-label">Total Orders</div>
    </div>

    <div class="stats-card">
        <div class="stats-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stats-value">
            R<?php echo number_format($stats['total_revenue'], 2); ?>
        </div>
        <div class="stats-label">Total Revenue</div>
    </div>

    <div class="stats-card action-card">
        <a href="orders.php" class="text-decoration-none">
            <div class="stats-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stats-value text-primary">
                <i class="fas fa-arrow-right"></i>
            </div>
            <div class="stats-label">View Orders</div>
        </a>
    </div>
</div>

<style>
.action-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.action-card a {
    color: inherit;
}

.action-card .stats-value {
    font-size: 24px;
}

.action-card:hover .stats-value i {
    transform: translateX(5px);
}

.action-card .stats-value i {
    transition: transform 0.3s ease;
}
</style>

<!-- Recent Users and Activity -->
<div class="row g-4 mb-4">
    <!-- Recent Users -->
    <div class="col-12 col-xl-6">
        <div class="table-card">
            <div class="table-header">
                <h5 class="table-title">Recent Users</h5>
                <a href="users.php" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $conn->query("
                                SELECT first_name, last_name, email, created_at, is_active 
                                FROM customers 
                                ORDER BY created_at DESC 
                                LIMIT 5
                            ");
                            $recent_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            if (empty($recent_users)) {
                                echo '<tr><td colspan="4" class="text-center">No users found</td></tr>';
                            } else {
                                foreach ($recent_users as $user) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                                    echo "<td>" . date('M d, Y', strtotime($user['created_at'])) . "</td>";
                                    echo "<td>" . ($user['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>') . "</td>";
                                    echo "</tr>";
                                }
                            }
                        } catch (Exception $e) {
                            echo '<tr><td colspan="4" class="text-center text-danger">Error loading users</td></tr>';
                            error_log("Error loading recent users: " . $e->getMessage());
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-12 col-xl-6">
        <div class="table-card">
            <div class="table-header">
                <h5 class="table-title">Recent Orders</h5>
                <a href="orders.php" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $conn->query("
                                SELECT o.*, c.first_name, c.last_name, c.email, p.name as product_name
                                FROM orders o
                                JOIN customers c ON o.customer_id = c.id
                                JOIN products p ON o.product_id = p.id
                                ORDER BY o.created_at DESC
                                LIMIT 5
                            ");
                            $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (empty($recent_orders)) {
                                echo '<tr><td colspan="4" class="text-center">No orders found</td></tr>';
                            } else {
                                foreach ($recent_orders as $order) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($order['product_name']) . "</td>";
                                    echo "<td>R" . number_format($order['amount'], 2) . "</td>";
                                    echo "<td><span class='badge bg-" . 
                                        ($order['status'] === 'completed' ? 'success' : 
                                        ($order['status'] === 'pending' ? 'warning' : 'danger')) . 
                                        "'>" . ucfirst($order['status']) . "</span></td>";
                                    echo "</tr>";
                                }
                            }
                        } catch (Exception $e) {
                            echo '<tr><td colspan="4" class="text-center text-danger">Error loading orders</td></tr>';
                            error_log("Error loading recent orders: " . $e->getMessage());
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 