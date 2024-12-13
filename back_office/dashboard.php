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
        'total_courses' => 0,
        'total_enrollments' => 0
    ];

    // Get total and active users
    $stmt = $conn->query("SELECT COUNT(*) FROM customers");
    $stats['total_users'] = $stmt->fetchColumn();

    $stmt = $conn->query("SELECT COUNT(*) FROM customers WHERE is_active = 1");
    $stats['active_users'] = $stmt->fetchColumn();

    // Get total courses
    $stmt = $conn->query("SELECT COUNT(*) FROM courses");
    $stats['total_courses'] = $stmt->fetchColumn();

    // Get total enrollments
    $stmt = $conn->query("SELECT COUNT(*) FROM user_courses");
    $stats['total_enrollments'] = $stmt->fetchColumn();

} catch (Exception $e) {
    error_log("Error in dashboard.php: " . $e->getMessage());
    $error = "An error occurred while loading the dashboard.";
}

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="page-header wow fadeIn" data-wow-delay="0.1s">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="display-6 text-white mb-0">Dashboard</h1>
            <p class="text-white-50 mb-0">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        </div>
    </div>
</div>

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
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="stats-value">
            <?php echo number_format($stats['total_courses']); ?>
        </div>
        <div class="stats-label">Total Courses</div>
    </div>

    <div class="stats-card">
        <div class="stats-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stats-value">
            <?php echo number_format($stats['total_enrollments']); ?>
        </div>
        <div class="stats-label">Total Enrollments</div>
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
                        $recent_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($recent_users)): 
                        ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <p class="text-muted mb-0">No users found</p>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($recent_users as $user): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle p-2 me-3">
                                        <?php 
                                            $first = $user['first_name'] ? substr($user['first_name'], 0, 1) : '';
                                            $last = $user['last_name'] ? substr($user['last_name'], 0, 1) : '';
                                            echo strtoupper($first . $last); 
                                        ?>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">
                                            <?php 
                                                $fullName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
                                                echo htmlspecialchars($fullName ?: 'N/A'); 
                                            ?>
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($user['institution'] ?? 'N/A'); ?></td>
                            <td>
                                <?php if ($user['is_active'] == 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
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
                                COALESCE(CONCAT(a.first_name, ' ', a.last_name), 
                                         CONCAT(c.first_name, ' ', c.last_name)) as user_name,
                                al.created_at as activity_time
                            FROM activity_log al
                            LEFT JOIN administrators a ON al.admin_id = a.id
                            LEFT JOIN customers c ON al.customer_id = c.id
                            ORDER BY al.created_at DESC
                            LIMIT 5
                        ");
                        $recent_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($recent_activities)): 
                        ?>
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <p class="text-muted mb-0">No activities found</p>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($recent_activities as $activity): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle p-2 me-3">
                                        <?php 
                                            $names = explode(' ', $activity['user_name']);
                                            $initials = '';
                                            foreach ($names as $name) {
                                                $initials .= strtoupper(substr($name, 0, 1));
                                            }
                                            echo $initials;
                                        ?>
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($activity['user_name']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($activity['user_email']); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($activity['action']); ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($activity['activity_time'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
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