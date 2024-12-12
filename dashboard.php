<?php
require_once 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user data
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get user stats
    $stmt = $conn->prepare("SELECT COUNT(*) as course_count FROM enrollments WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $courseStats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get recent activity
    $stmt = $conn->prepare("
        SELECT * FROM activity_log 
        WHERE user_id = ? 
        ORDER BY created_at DESC 
        LIMIT 5
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $recentActivity = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    error_log("Dashboard error: " . $e->getMessage());
}

// Set page-specific variables
$page = 'dashboard';
$title = "Artifitech - Dashboard | Welcome " . htmlspecialchars($_SESSION['user_name']);
$keywords = "Dashboard, User Account, Profile";
$description = "Manage your Artifitech account and access your services.";

// Start output buffering
ob_start();
?>

<!-- Particle Background -->
<canvas id="particle-canvas"></canvas>
<link href="css/particles.css" rel="stylesheet">
<script src="js/particles.js"></script>

<!-- Brand & Contact Start -->
<div class="container-fluid py-4 px-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="row align-items-center top-bar">
        <div class="col-lg-4 col-md-12 text-center text-lg-start">
            <a href="index.php" class="navbar-brand m-0 p-0">
                <img src="img/logo.png" alt="Artifitech Logo" height="60">
            </a>
        </div>
        <div class="col-lg-8 col-md-7 d-none d-lg-block">
            <div class="row">
                <div class="col-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                            <i class="far fa-clock text-primary"></i>
                        </div>
                        <div class="ps-3">
                            <p class="mb-2">Opening Hour</p>
                            <h6 class="mb-0">Mon - Fri, 8:00 - 17:00</h6>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                            <i class="fa fa-phone text-primary"></i>
                        </div>
                        <div class="ps-3">
                            <p class="mb-2">Call Us</p>
                            <h6 class="mb-0">+27 123 456 789</h6>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                            <i class="far fa-envelope text-primary"></i>
                        </div>
                        <div class="ps-3">
                            <p class="mb-2">Email Us</p>
                            <h6 class="mb-0">info@example.com</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand & Contact End -->

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Dashboard</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Dashboard Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- Welcome Message -->
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Welcome Back</h6>
            <h1 class="display-6 mb-4"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="fact-item bg-light rounded text-center h-100 p-5">
                    <i class="fa fa-book-reader fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Enrolled Courses</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up"><?php echo $courseStats['course_count'] ?? 0; ?></h1>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="fact-item bg-light rounded text-center h-100 p-5">
                    <i class="fa fa-certificate fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Certificates Earned</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">0</h1>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="fact-item bg-light rounded text-center h-100 p-5">
                    <i class="fa fa-tasks fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Completion Rate</h5>
                    <h1 class="display-5 mb-0">0%</h1>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="row g-4">
            <!-- Recent Activity -->
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="section-title position-relative mb-4">
                        <h6 class="position-relative text-primary ps-4">Activity</h6>
                        <h3 class="mb-0">Recent Activity</h3>
                    </div>
                    <div class="activity-feed">
                        <?php if (!empty($recentActivity)): ?>
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                    <div class="btn-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1"><?php echo htmlspecialchars($activity['action']); ?></h6>
                                        <small class="text-body"><?php echo date('M j, Y g:i A', strtotime($activity['created_at'])); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fa fa-info-circle fa-2x text-primary mb-3"></i>
                                <p class="text-muted">No recent activity to display</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="section-title position-relative mb-4">
                        <h6 class="position-relative text-primary ps-4">Actions</h6>
                        <h3 class="mb-0">Quick Actions</h3>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <a href="courses.php" class="btn btn-primary py-3 px-5">
                            <i class="fa fa-book-open me-2"></i>Browse Courses
                        </a>
                        <a href="profile.php" class="btn btn-outline-primary py-3 px-5">
                            <i class="fa fa-user me-2"></i>Edit Profile
                        </a>
                        <a href="certificates.php" class="btn btn-outline-primary py-3 px-5">
                            <i class="fa fa-certificate me-2"></i>View Certificates
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course Progress -->
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <div class="section-title position-relative mb-4">
                        <h6 class="position-relative text-primary ps-4">Learning</h6>
                        <h3 class="mb-0">Course Progress</h3>
                    </div>
                    <?php if ($courseStats['course_count'] > 0): ?>
                        <!-- Course progress content here -->
                        <div class="row g-4">
                            <!-- Example course progress -->
                            <div class="col-md-6">
                                <div class="border rounded p-4">
                                    <h5 class="mb-3">Introduction to AI</h5>
                                    <div class="progress mb-2">
                                        <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                    </div>
                                    <small class="text-muted">Last accessed: 2 days ago</small>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fa fa-book fa-3x text-primary mb-4"></i>
                            <h5 class="mb-3">No Courses Yet</h5>
                            <p class="text-muted mb-4">You haven't enrolled in any courses yet.</p>
                            <a href="courses.php" class="btn btn-primary rounded-pill py-3 px-5">Browse Courses</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 