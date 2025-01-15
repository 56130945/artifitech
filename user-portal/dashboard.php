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
$error = isset($_GET['error']) ? 'An error occurred. Please try again.' : null;
$success = isset($_GET['success']) ? 'Operation completed successfully.' : null;

// Check if user is logged in and is a customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: $base_url/login.php");
    exit;
}

// Get user's current subscriptions and courses
try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Debug log
    error_log("Dashboard - User ID: " . $_SESSION['user_id']);
    
    // Get user's active courses
    $stmt = $conn->prepare("
        SELECT c.* 
        FROM courses c 
        WHERE c.status = 'active' 
        AND EXISTS (
            SELECT 1 
            FROM user_courses uc 
            WHERE uc.course_id = c.id 
            AND uc.user_id = ? 
            AND uc.status = 'active'
        )
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $activeCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    error_log("Active courses query executed. Count: " . count($activeCourses));

    // Get user's subscriptions
    $stmt = $conn->prepare("
        SELECT products.name AS product_name, subscriptions.renewal_date, subscriptions.status
        FROM subscriptions
        JOIN products ON subscriptions.product_id = products.id
        WHERE subscriptions.user_id = ? AND subscriptions.status = 'active'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $activeSubscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Active subscriptions query executed. Count: " . count($activeSubscriptions));

    // Get available courses
    $stmt = $conn->prepare("
        SELECT * 
        FROM courses 
        WHERE status = 'active' 
        AND id NOT IN (
            SELECT COALESCE(course_id, 0) 
            FROM user_courses 
            WHERE user_id = ?
        )
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $availableCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    error_log("Available courses query executed. Count: " . count($availableCourses));

    // Get available products
    $stmt = $conn->prepare("
        SELECT * 
        FROM products 
        WHERE status = 'active'
        AND id NOT IN (
            SELECT COALESCE(product_id, 0) 
            FROM subscriptions 
            WHERE user_id = ? 
            AND status = 'active'
        )
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $availableProducts = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    error_log("Available products query executed. Count: " . count($availableProducts));

    // Clear any error if queries were successful
    $error = null;

} catch (Exception $e) {
    error_log("Dashboard error: " . $e->getMessage() . "\nTrace: " . $e->getTraceAsString());
    $error = "An error occurred while loading your dashboard. Please try again later. Error: " . $e->getMessage();
    
    // Initialize empty arrays if there was an error
    $activeCourses = [];
    $activeSubscriptions = [];
    $availableCourses = [];
    $availableProducts = [];
}

// Use product details from query string if available
if (isset($_GET['product_name']) && isset($_GET['renewal_date'])) {
    $activeSubscriptions[] = [
        'product_name' => $_GET['product_name'],
        'renewal_date' => $_GET['renewal_date'],
        'status' => 'active'
    ];
}

// Start output buffering
ob_start();
?>
<!-- Dashboard Content Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="container text-center mb-4">
            <!-- Remove the existing 'Back to Website' button from the main content -->
        </div>

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
                <div class="stats-label">Explorer Courses</div>
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
                        <a href="courses.php" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye me-2"></i>View All
                        </a>
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
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="../img/courses/<?php echo strtolower(str_replace(' ', '-', $course['name'])); ?>.jpg" 
                                                         class="me-3" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" 
                                                         alt="<?php echo htmlspecialchars($course['name']); ?>">
                                                    <div>
                                                        <h6 class="mb-0"><?php echo htmlspecialchars($course['name'] ?? ''); ?></h6>
                                                        <small class="text-muted">Course</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress" style="width: 100px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: <?php echo $course['progress'] ?? 0; ?>%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <a href="course.php?id=<?php echo $course['id']; ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-play me-2"></i>Continue
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-book-open fa-2x text-muted mb-3"></i>
                                            <p class="mb-0">You haven't enrolled in any courses yet.</p>
                                            <a href="browse-courses.php" class="btn btn-sm btn-primary mt-3">
                                                Browse Courses
                                            </a>
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
                        <a href="subscriptions.php" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye me-2"></i>View All
                        </a>
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
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="../img/products/<?php echo strtolower(str_replace(' ', '-', $subscription['product_name'])); ?>.png" 
                                                         class="me-3" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" 
                                                         alt="<?php echo htmlspecialchars($subscription['product_name']); ?>">
                                                    <div>
                                                        <h6 class="mb-0"><?php echo htmlspecialchars($subscription['product_name'] ?? ''); ?></h6>
                                                        <small class="text-muted">Subscription</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $subscription['renewal_date'] ? date('M d, Y', strtotime($subscription['renewal_date'])) : ''; ?></td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <a href="subscription.php?id=<?php echo $subscription['id'] ?? ''; ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-cog me-2"></i>Manage
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-cube fa-2x text-muted mb-3"></i>
                                            <p class="mb-0">You don't have any active subscriptions.</p>
                                            <a href="../index.php#products" class="btn btn-sm btn-primary mt-3">
                                                View Products
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Explorer Courses -->
        <div class="table-card">
            <div class="table-header">
                <h5 class="table-title">Explorer Courses</h5>
                <a href="browse-courses.php" class="btn btn-sm btn-primary">
                    <i class="fas fa-search me-2"></i>Browse All
                </a>
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
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../img/courses/<?php echo strtolower(str_replace(' ', '-', $course['name'])); ?>.jpg" 
                                                 class="me-3" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" 
                                                 alt="<?php echo htmlspecialchars($course['name']); ?>">
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($course['name'] ?? ''); ?></h6>
                                                <small class="text-muted">New Course</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($course['duration'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($course['students_count'] ?? '0'); ?> students</td>
                                    <td>
                                        <a href="course-details.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-2"></i>Enroll Now
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-graduation-cap fa-2x text-muted mb-3"></i>
                                    <p class="mb-0">No new courses available at the moment.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="sidebar">
    <!-- Existing sidebar content -->
</div>

<?php
$content = ob_get_clean();
require_once 'includes/template.php';
?>