<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'activity-logs';
$title = "Activity Logs - Artifitech Admin";
$description = "View system activity and user actions";

// Initialize variables
$logs = [];
$error = null;
$total_pages = 1;

// Get logs with pagination
$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 20;
$offset = ($page_number - 1) * $items_per_page;

// Filter parameters
$filter_user_type = $_GET['user_type'] ?? '';
$filter_action = $_GET['action'] ?? '';
$filter_date = $_GET['date'] ?? '';
$search = $_GET['search'] ?? '';

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Get recent authentication activities
    $auth_logs = [];
    $stmt = $conn->query("
        SELECT al.*, 
            COALESCE(a.email, c.email) as user_email,
            COALESCE(CONCAT(a.first_name, ' ', a.last_name), 
                     CONCAT(c.first_name, ' ', c.last_name)) as user_name,
            al.created_at as activity_time
        FROM auth_logs al
        LEFT JOIN administrators a ON (al.user_type = 'admin' AND al.user_id = a.id)
        LEFT JOIN customers c ON (al.user_type = 'customer' AND al.user_id = c.id)
        ORDER BY al.created_at DESC
        LIMIT 5
    ");
    $auth_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Build the WHERE clause based on filters
    $where_conditions = [];
    $params = [];
    
    if ($filter_user_type) {
        $where_conditions[] = "user_type = ?";
        $params[] = $filter_user_type;
    }
    
    if ($filter_action) {
        $where_conditions[] = "action = ?";
        $params[] = $filter_action;
    }
    
    if ($filter_date) {
        $where_conditions[] = "DATE(created_at) = ?";
        $params[] = $filter_date;
    }
    
    if ($search) {
        $where_conditions[] = "(user_email LIKE ? OR details LIKE ? OR ip_address LIKE ?)";
        $search_param = "%$search%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
    }
    
    $where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";
    
    // Get total logs count
    $count_query = "SELECT COUNT(*) FROM activity_log $where_clause";
    $stmt = $conn->prepare($count_query);
    $stmt->execute($params);
    $total_logs = $stmt->fetchColumn();
    $total_pages = ceil($total_logs / $items_per_page);
    
    // Get logs for current page
    $query = "
        SELECT 
            al.*,
            COALESCE(a.email, c.email) as user_email,
            COALESCE(CONCAT(a.first_name, ' ', a.last_name), 
                     CONCAT(c.first_name, ' ', c.last_name)) as user_name
        FROM activity_log al
        LEFT JOIN administrators a ON al.admin_id = a.id
        LEFT JOIN customers c ON al.customer_id = c.id
        $where_clause
        ORDER BY al.created_at DESC
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $items_per_page;
    $params[] = $offset;
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log("Error in activity-logs.php: " . $e->getMessage());
    $error = "An error occurred while fetching activity logs.";
}

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="page-header wow fadeIn" data-wow-delay="0.1s">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="display-6 text-white mb-0">Activity Logs</h1>
            <p class="text-white-50 mb-0">Monitor system activity and user actions</p>
        </div>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($error); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Recent Authentication Activities Start -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="table-card">
            <div class="table-header">
                <h5 class="table-title">Recent Authentication Activities</h5>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>IP Address</th>
                            <th>Browser</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($auth_logs)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <p class="text-muted mb-0">No recent authentication activities</p>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($auth_logs as $log): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-<?php echo $log['user_type'] === 'admin' ? 'primary' : 'info'; ?> text-white rounded-circle p-2 me-3">
                                        <?php 
                                            $names = explode(' ', $log['user_name']);
                                            $initials = '';
                                            foreach ($names as $name) {
                                                $initials .= strtoupper(substr($name, 0, 1));
                                            }
                                            echo $initials;
                                        ?>
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($log['user_name']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($log['user_email']); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php
                                $action_class = match($log['action']) {
                                    'login' => 'success',
                                    'logout' => 'secondary',
                                    'failed_login' => 'danger',
                                    'password_reset' => 'warning',
                                    default => 'primary'
                                };
                                ?>
                                <span class="badge bg-<?php echo $action_class; ?>">
                                    <?php echo ucwords(str_replace('_', ' ', $log['action'])); ?>
                                </span>
                            </td>
                            <td><code><?php echo htmlspecialchars($log['ip_address']); ?></code></td>
                            <td><small><?php echo htmlspecialchars($log['user_agent']); ?></small></td>
                            <td><?php echo date('M d, Y H:i:s', strtotime($log['activity_time'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Filters Start -->
<div class="card border-0 shadow-sm mb-4 wow fadeInUp" data-wow-delay="0.1s">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">User Type</label>
                <select name="user_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="admin" <?php echo $filter_user_type === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="customer" <?php echo $filter_user_type === 'customer' ? 'selected' : ''; ?>>Customer</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Action</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    <option value="login" <?php echo $filter_action === 'login' ? 'selected' : ''; ?>>Login</option>
                    <option value="logout" <?php echo $filter_action === 'logout' ? 'selected' : ''; ?>>Logout</option>
                    <option value="failed_login" <?php echo $filter_action === 'failed_login' ? 'selected' : ''; ?>>Failed Login</option>
                    <option value="password_reset" <?php echo $filter_action === 'password_reset' ? 'selected' : ''; ?>>Password Reset</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo $filter_date; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Email, IP, or Details" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table Start -->
<div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.1s">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Action</th>
                        <th>IP Address</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted mb-0">No activity logs found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo date('M d, Y H:i:s', strtotime($log['created_at'])); ?></td>
                        <td>
                            <div>
                                <h6 class="mb-0"><?php echo htmlspecialchars($log['user_name'] ?? 'N/A'); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($log['user_email'] ?? ''); ?></small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo $log['user_type'] === 'admin' ? 'primary' : 'info'; ?>">
                                <?php echo ucfirst($log['user_type']); ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            $action_class = match($log['action']) {
                                'login' => 'success',
                                'logout' => 'secondary',
                                'failed_login' => 'danger',
                                'password_reset' => 'warning',
                                default => 'primary'
                            };
                            ?>
                            <span class="badge bg-<?php echo $action_class; ?>">
                                <?php echo ucwords(str_replace('_', ' ', $log['action'])); ?>
                            </span>
                        </td>
                        <td>
                            <code><?php echo htmlspecialchars($log['ip_address'] ?? 'N/A'); ?></code>
                        </td>
                        <td>
                            <small><?php echo htmlspecialchars($log['details'] ?? ''); ?></small>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Start -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $page_number <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page_number - 1; ?>&user_type=<?php echo urlencode($filter_user_type); ?>&action=<?php echo urlencode($filter_action); ?>&date=<?php echo urlencode($filter_date); ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $page_number === $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&user_type=<?php echo urlencode($filter_user_type); ?>&action=<?php echo urlencode($filter_action); ?>&date=<?php echo urlencode($filter_date); ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
                
                <li class="page-item <?php echo $page_number >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page_number + 1; ?>&user_type=<?php echo urlencode($filter_user_type); ?>&action=<?php echo urlencode($filter_action); ?>&date=<?php echo urlencode($filter_date); ?>&search=<?php echo urlencode($search); ?>">Next</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
        <!-- Pagination End -->
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    font-weight: 600;
    font-family: 'Exo 2', sans-serif;
    color: #2124B1;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

code {
    padding: 0.2rem 0.4rem;
    font-size: 87.5%;
    color: #e83e8c;
    background-color: #f8f9fa;
    border-radius: 0.2rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 0.75rem 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #4777F5;
    box-shadow: 0 0 0 0.2rem rgba(71, 119, 245, 0.25);
}
</style>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 