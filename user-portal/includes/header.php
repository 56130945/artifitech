<?php
// Get current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Check if user is logged in and get display name
$display_name = 'Guest';
if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
    $display_name = $_SESSION['user_name'];
} elseif (isset($_SESSION['user_id'])) {
    // Fetch user name from database if session variable is missing
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) as full_name FROM customers WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        if ($user) {
            $display_name = $user['full_name'];
            $_SESSION['user_name'] = $display_name; // Update session
        }
    } catch (PDOException $e) {
        error_log("Error fetching user name: " . $e->getMessage());
    }
}
?>

<!-- Sidebar Start -->
<div class="portal-sidebar">
    <div class="logo-container">
        <a href="dashboard.php">
            <img src="../img/logo.png" alt="Artifitech Logo">
        </a>
    </div>

    <!-- Main Navigation -->
    <div class="nav-section">
        <h6 class="nav-section-title">Main</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fa fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Academy Section -->
    <div class="nav-section">
        <h6 class="nav-section-title">Academy</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="my-courses.php" class="nav-link <?php echo $current_page === 'my-courses' ? 'active' : ''; ?>">
                    <i class="fa fa-graduation-cap"></i>
                    <span>My Courses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="available-courses.php" class="nav-link <?php echo $current_page === 'available-courses' ? 'active' : ''; ?>">
                    <i class="fa fa-book"></i>
                    <span>Available Courses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="certificates.php" class="nav-link <?php echo $current_page === 'certificates' ? 'active' : ''; ?>">
                    <i class="fa fa-certificate"></i>
                    <span>Certificates</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Products Section -->
    <div class="nav-section">
        <h6 class="nav-section-title">Products</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="my-subscriptions.php" class="nav-link <?php echo $current_page === 'my-subscriptions' ? 'active' : ''; ?>">
                    <i class="fa fa-cube"></i>
                    <span>My Subscriptions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="available-products.php" class="nav-link <?php echo $current_page === 'available-products' ? 'active' : ''; ?>">
                    <i class="fa fa-cubes"></i>
                    <span>Available Products</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Account Section -->
    <div class="nav-section">
        <h6 class="nav-section-title">Account</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="profile.php" class="nav-link <?php echo $current_page === 'profile' ? 'active' : ''; ?>">
                    <i class="fa fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="billing.php" class="nav-link <?php echo $current_page === 'billing' ? 'active' : ''; ?>">
                    <i class="fa fa-credit-card"></i>
                    <span>Billing</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="support.php" class="nav-link <?php echo $current_page === 'support' ? 'active' : ''; ?>">
                    <i class="fa fa-question-circle"></i>
                    <span>Support</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../logout.php" class="nav-link text-danger">
                    <i class="fa fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Sidebar End -->

<!-- Header Start -->
<div class="portal-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-0"><?php echo htmlspecialchars($title ?? 'Dashboard'); ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($current_page); ?></li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="btn btn-link text-dark dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user-circle me-2"></i>
                    <?php echo htmlspecialchars($display_name); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item" href="profile.php"><i class="fa fa-user me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="billing.php"><i class="fa fa-credit-card me-2"></i>Billing</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../logout.php"><i class="fa fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Header End --> 