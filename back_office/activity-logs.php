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
$success = null;
$total_pages = 1;
$log_stats = [];

// Get logs with pagination
$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 20;
$offset = ($page_number - 1) * $items_per_page;

// Filter parameters
$filter_user_type = $_GET['user_type'] ?? '';
$filter_action = $_GET['action'] ?? '';
$filter_date_start = $_GET['date_start'] ?? '';
$filter_date_end = $_GET['date_end'] ?? '';
$filter_ip = $_GET['ip'] ?? '';
$search = $_GET['search'] ?? '';

// Handle export request
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="activity_logs_' . date('Y-m-d') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Time', 'User', 'Type', 'Action', 'IP Address', 'Details', 'Browser']);
    // Export logic will be handled here
    exit();
}

// Handle log cleanup
if (isset($_POST['cleanup']) && isset($_POST['days'])) {
    try {
        $days = (int)$_POST['days'];
        $conn = getDBConnection();
        $stmt = $conn->prepare("DELETE FROM auth_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)");
        $stmt->execute([$days]);
        $success = "Successfully cleaned up logs older than {$days} days.";
    } catch (Exception $e) {
        $error = "Failed to clean up logs: " . $e->getMessage();
    }
}

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Get log statistics
    $stats_query = "
        SELECT 
            COUNT(*) as total_logs,
            COUNT(DISTINCT user_id) as unique_users,
            COUNT(CASE WHEN action = 'failed_login' THEN 1 END) as failed_logins,
            COUNT(CASE WHEN action = 'login' THEN 1 END) as successful_logins,
            COUNT(CASE WHEN created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 END) as last_24h
        FROM auth_logs
    ";
    $log_stats = $conn->query($stats_query)->fetch(PDO::FETCH_ASSOC);
    
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
    
    if ($filter_date_start) {
        $where_conditions[] = "DATE(created_at) >= ?";
        $params[] = $filter_date_start;
    }
    
    if ($filter_date_end) {
        $where_conditions[] = "DATE(created_at) <= ?";
        $params[] = $filter_date_end;
    }
    
    if ($filter_ip) {
        $where_conditions[] = "ip_address LIKE ?";
        $params[] = "%$filter_ip%";
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
    $count_query = "SELECT COUNT(*) FROM auth_logs $where_clause";
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
        FROM auth_logs al
        LEFT JOIN administrators a ON (al.user_type = 'admin' AND al.user_id = a.id)
        LEFT JOIN customers c ON (al.user_type = 'customer' AND al.user_id = c.id)
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

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($error); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($success); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Statistics Cards Start -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Total Logs</h6>
                    <div class="bg-primary rounded-circle p-2">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0"><?php echo number_format($log_stats['total_logs']); ?></h3>
                <small class="text-muted">All time activity logs</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Last 24 Hours</h6>
                    <div class="bg-success rounded-circle p-2">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0"><?php echo number_format($log_stats['last_24h']); ?></h3>
                <small class="text-muted">Recent activities</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Failed Logins</h6>
                    <div class="bg-danger rounded-circle p-2">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0"><?php echo number_format($log_stats['failed_logins']); ?></h3>
                <small class="text-muted">Total failed login attempts</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Unique Users</h6>
                    <div class="bg-info rounded-circle p-2">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0"><?php echo number_format($log_stats['unique_users']); ?></h3>
                <small class="text-muted">Distinct users logged</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Authentication Activities Start -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Recent Authentication Activities</h5>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cleanupModal">
                            <i class="fas fa-trash-alt me-1"></i> Cleanup
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>IP Address</th>
                                <th>Browser</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($auth_logs)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
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
                                                $names = explode(' ', $log['user_name'] ?? '');
                                                $initials = '';
                                                foreach ($names as $name) {
                                                    $initials .= strtoupper(substr($name, 0, 1));
                                                }
                                                echo $initials ?: 'U';
                                            ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($log['user_name'] ?? 'Unknown User'); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($log['user_email'] ?? ''); ?></small>
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
                                <td><code><?php echo htmlspecialchars($log['ip_address'] ?? 'N/A'); ?></code></td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo $log['user_agent'] ? htmlspecialchars($log['user_agent']) : 'Not available'; ?>
                                    </small>
                                </td>
                                <td><?php echo date('M d, Y H:i:s', strtotime($log['activity_time'])); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="showLogDetails(<?php echo htmlspecialchars(json_encode($log)); ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Filters Start -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Advanced Filters</h5>
    </div>
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
            <div class="col-md-3">
                <label class="form-label">Date Range</label>
                <div class="input-group">
                    <input type="date" name="date_start" class="form-control" value="<?php echo $filter_date_start; ?>" placeholder="Start Date">
                    <input type="date" name="date_end" class="form-control" value="<?php echo $filter_date_end; ?>" placeholder="End Date">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">IP Address</label>
                <input type="text" name="ip" class="form-control" placeholder="Search IP" value="<?php echo htmlspecialchars($filter_ip); ?>">
            </div>
            <div class="col-md-9">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by email, details, or IP" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Items per page</label>
                <select name="per_page" class="form-select">
                    <option value="20" <?php echo $items_per_page === 20 ? 'selected' : ''; ?>>20</option>
                    <option value="50" <?php echo $items_per_page === 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $items_per_page === 100 ? 'selected' : ''; ?>>100</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Apply Filters
                </button>
                <a href="activity-logs.php" class="btn btn-outline-secondary">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody id="logDetailsContent">
                            <!-- Log details will be inserted here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="activity-logs.php" method="GET">
                    <input type="hidden" name="export" value="csv">
                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="date" name="export_date_start" class="form-control" required>
                            <input type="date" name="export_date_end" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Include Fields</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="export_fields[]" value="user_agent" checked>
                            <label class="form-check-label">Browser Information</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="export_fields[]" value="ip_address" checked>
                            <label class="form-check-label">IP Address</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="export_fields[]" value="details" checked>
                            <label class="form-check-label">Details</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Export to CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cleanup Modal -->
<div class="modal fade" id="cleanupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clean Up Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="activity-logs.php" method="POST">
                    <input type="hidden" name="cleanup" value="1">
                    <div class="mb-3">
                        <label class="form-label">Delete logs older than</label>
                        <select name="days" class="form-select" required>
                            <option value="30">30 days</option>
                            <option value="60">60 days</option>
                            <option value="90">90 days</option>
                            <option value="180">180 days</option>
                            <option value="365">1 year</option>
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        This action cannot be undone. Please make sure you have exported any important logs before proceeding.
                    </div>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Clean Up Logs
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showLogDetails(log) {
    const content = document.getElementById('logDetailsContent');
    content.innerHTML = `
        <tr>
            <th>Time</th>
            <td>${new Date(log.activity_time).toLocaleString()}</td>
        </tr>
        <tr>
            <th>User</th>
            <td>${log.user_name || 'Unknown'} (${log.user_email || 'No email'})</td>
        </tr>
        <tr>
            <th>Type</th>
            <td><span class="badge bg-${log.user_type === 'admin' ? 'primary' : 'info'}">${log.user_type}</span></td>
        </tr>
        <tr>
            <th>Action</th>
            <td>${log.action}</td>
        </tr>
        <tr>
            <th>IP Address</th>
            <td><code>${log.ip_address || 'N/A'}</code></td>
        </tr>
        <tr>
            <th>Browser</th>
            <td><small>${log.user_agent || 'Not available'}</small></td>
        </tr>
        <tr>
            <th>Details</th>
            <td>${log.details || 'No additional details'}</td>
        </tr>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('logDetailsModal'));
    modal.show();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
});
</script>

<style>
.card {
    border-radius: 10px;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.table th {
    font-weight: 600;
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

.btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
}

.modal-content {
    border-radius: 10px;
    border: none;
}

.modal-header {
    border-bottom: 1px solid #e0e0e0;
}

.table-responsive {
    border-radius: 8px;
}

.rounded-circle {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-primary, .btn-primary {
    background-color: #4777F5 !important;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

.text-primary {
    color: #4777F5 !important;
}
</style>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 