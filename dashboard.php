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
        <div class="row g-4">
            <!-- Welcome Section -->
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-4 mb-4">
                    <h2 class="mb-3">Welcome Back, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
                    <p class="text-muted">Manage your account and access your services from here.</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Profile</h5>
                        <a href="profile.php" class="text-primary">Edit</a>
                    </div>
                    <p class="mb-2"><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                    <p class="mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="mb-0"><strong>Institution:</strong> <?php echo htmlspecialchars($user['institution']); ?></p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-light rounded p-4 h-100">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="courses.php" class="btn btn-primary">My Courses</a>
                        <a href="certificates.php" class="btn btn-outline-primary">Certificates</a>
                        <a href="support.php" class="btn btn-outline-primary">Get Support</a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded p-4 h-100">
                    <h5 class="mb-3">Recent Activity</h5>
                    <div class="timeline">
                        <div class="timeline-item pb-3">
                            <p class="mb-0 text-muted small">Just now</p>
                            <p class="mb-0">Logged into your account</p>
                        </div>
                        <!-- Add more activity items here -->
                    </div>
                </div>
            </div>

            <!-- Course Progress -->
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="mb-0">Course Progress</h5>
                        <a href="courses.php" class="text-primary">View All Courses</a>
                    </div>
                    <div class="alert alert-info">
                        No active courses found. <a href="academy.php" class="alert-link">Browse our courses</a> to get started!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard End -->

<!-- Add custom styles -->
<style>
.timeline-item {
    position: relative;
    padding-left: 20px;
    border-left: 2px solid #2124B1;
}
.timeline-item:before {
    content: '';
    position: absolute;
    left: -6px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #2124B1;
}
</style>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 