<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth_check.php';

// Set page-specific variables
$page = 'dashboard';
$title = "User Dashboard - Artifitech";
$description = "Manage your Artifitech courses and subscriptions";

// Initialize variables
$activeCourses = [];
$activeSubscriptions = [];
$availableCourses = [];
$availableProducts = [];
$error = null;

// Check if user is logged in and is a customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: ../login.php');
    exit;
}

// Get user's current subscriptions and courses
try {
    $conn = getDBConnection();
    
    // Get user's active courses
    $stmt = $conn->prepare("
        SELECT c.* FROM courses c
        JOIN user_courses uc ON c.id = uc.course_id
        WHERE uc.user_id = ? AND uc.status = 'active'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $activeCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get user's subscriptions
    $stmt = $conn->prepare("
        SELECT s.*, p.name as product_name, p.description as product_description 
        FROM subscriptions s
        JOIN products p ON s.product_id = p.id
        WHERE s.user_id = ? AND s.status = 'active'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $activeSubscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get available courses
    $stmt = $conn->prepare("
        SELECT * FROM courses 
        WHERE status = 'active' 
        AND id NOT IN (
            SELECT course_id FROM user_courses 
            WHERE user_id = ?
        )
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $availableCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get available products
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE status = 'active'
        AND id NOT IN (
            SELECT product_id FROM subscriptions 
            WHERE user_id = ? AND status = 'active'
        )
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $availableProducts = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

} catch (PDOException $e) {
    error_log("Error in user dashboard: " . $e->getMessage());
    $error = "An error occurred while loading your dashboard. Our team has been notified.";
}

ob_start();
?>

<div class="content-wrapper">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stats-value">
                <?php echo count($activeCourses); ?>
            </div>
            <div class="stats-label">Active Courses</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="stats-value">
                <?php echo count($activeSubscriptions); ?>
            </div>
            <div class="stats-label">Active Subscriptions</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stats-value">
                <?php echo count($availableCourses); ?>
            </div>
            <div class="stats-label">Available Courses</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-award"></i>
            </div>
            <div class="stats-value">
                <?php echo count($availableProducts); ?>
            </div>
            <div class="stats-label">Available Products</div>
        </div>
    </div>

    <!-- Active Courses and Subscriptions -->
    <div class="row g-4 mb-4">
        <!-- Active Courses -->
        <div class="col-12 col-xl-6">
            <div class="table-card">
                <div class="table-header">
                    <h5 class="table-title">Your Active Courses</h5>
                    <a href="courses.php" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($activeCourses)): ?>
                                <?php foreach ($activeCourses as $course): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($course['name'] ?? ''); ?></td>
                                        <td>
                                            <div class="progress" style="height: 8px; width: 100px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: <?php echo $course['progress'] ?? 0; ?>%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <a href="course.php?id=<?php echo $course['id']; ?>" 
                                               class="btn btn-sm btn-primary">Continue</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-book-open fa-2x text-muted mb-3"></i>
                                        <p class="mb-0">You haven't enrolled in any courses yet.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="col-12 col-xl-6">
            <div class="table-card">
                <div class="table-header">
                    <h5 class="table-title">Your Active Subscriptions</h5>
                    <a href="subscriptions.php" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Renewal Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($activeSubscriptions)): ?>
                                <?php foreach ($activeSubscriptions as $subscription): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subscription['product_name'] ?? ''); ?></td>
                                        <td><?php echo $subscription['renewal_date'] ? date('M d, Y', strtotime($subscription['renewal_date'])) : ''; ?></td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <a href="subscription.php?id=<?php echo $subscription['id']; ?>" 
                                               class="btn btn-sm btn-primary">Manage</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-cube fa-2x text-muted mb-3"></i>
                                        <p class="mb-0">You don't have any active subscriptions.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Courses -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">Available Courses</h5>
            <a href="browse-courses.php" class="btn btn-sm btn-primary">Browse All</a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Duration</th>
                        <th>Students</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($availableCourses)): ?>
                        <?php foreach ($availableCourses as $course): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($course['duration'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($course['students_count'] ?? '0'); ?> students</td>
                                <td>
                                    <a href="course-details.php?id=<?php echo $course['id']; ?>" 
                                       class="btn btn-sm btn-primary">Enroll Now</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <p class="mb-0">No courses available at the moment.</p>
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
include 'includes/template.php';
?> 