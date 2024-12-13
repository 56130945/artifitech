<?php
$title = "Admin Dashboard";
$page = "dashboard";

// Include database connection
require_once '../includes/config.php';
require_once '../includes/db.php';

try {
    $conn = getDBConnection();
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

ob_start();
?>

<div class="content-wrapper">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-value">
                <?php
                $stmt = $conn->query("SELECT COUNT(*) FROM customers WHERE is_active = 1");
                echo $stmt->fetchColumn();
                ?>
            </div>
            <div class="stats-label">Active Customers</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stats-value">
                <?php
                $stmt = $conn->query("SELECT COUNT(*) FROM administrators WHERE is_active = 1");
                echo $stmt->fetchColumn();
                ?>
            </div>
            <div class="stats-label">Active Administrators</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stats-value">
                <?php
                $stmt = $conn->query("SELECT COUNT(*) FROM activity_log WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)");
                echo $stmt->fetchColumn();
                ?>
            </div>
            <div class="stats-label">24h Activities</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stats-value">
                <?php
                $stmt = $conn->query("SELECT COUNT(*) FROM auth_logs WHERE action = 'login' AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)");
                echo $stmt->fetchColumn();
                ?>
            </div>
            <div class="stats-label">24h Logins</div>
        </div>
    </div>

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
                                <th>Institution</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("
                                SELECT first_name, last_name, email, institution, is_active 
                                FROM customers 
                                ORDER BY created_at DESC 
                                LIMIT 5
                            ");
                            while ($row = $stmt->fetch()) {
                                $name = ($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '');
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars(trim($name)) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['institution'] ?? '') . "</td>";
                                echo "<td><span class='badge bg-" . ($row['is_active'] ? 'success' : 'warning') . "'>" 
                                    . ($row['is_active'] ? 'Active' : 'Inactive') . "</span></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-12 col-xl-6">
            <div class="table-card">
                <div class="table-header">
                    <h5 class="table-title">Recent Activities</h5>
                    <a href="activity-logs.php" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("
                                SELECT al.*, 
                                    COALESCE(a.email, c.email) as user_email,
                                    al.created_at as activity_time
                                FROM activity_log al
                                LEFT JOIN administrators a ON al.admin_id = a.id
                                LEFT JOIN customers c ON al.customer_id = c.id
                                ORDER BY al.created_at DESC
                                LIMIT 5
                            ");
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['user_email'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['action'] ?? '') . "</td>";
                                echo "<td>" . ($row['activity_time'] ? date('M d, H:i', strtotime($row['activity_time'])) : '') . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Authentication Logs -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">Recent Authentication Activities</h5>
            <a href="auth-logs.php" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User Type</th>
                        <th>Action</th>
                        <th>IP Address</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->query("
                        SELECT * FROM auth_logs
                        ORDER BY created_at DESC
                        LIMIT 10
                    ");
                    while ($row = $stmt->fetch()) {
                        $actionClass = '';
                        switch ($row['action']) {
                            case 'login': $actionClass = 'success'; break;
                            case 'logout': $actionClass = 'info'; break;
                            case 'failed_login': $actionClass = 'danger'; break;
                            default: $actionClass = 'secondary';
                        }
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['user_type'] ?? '') . "</td>";
                        echo "<td><span class='badge bg-{$actionClass}'>" . htmlspecialchars(str_replace('_', ' ', $row['action'] ?? '')) . "</span></td>";
                        echo "<td>" . htmlspecialchars($row['ip_address'] ?? '') . "</td>";
                        echo "<td>" . ($row['created_at'] ? date('M d, H:i', strtotime($row['created_at'])) : '') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 