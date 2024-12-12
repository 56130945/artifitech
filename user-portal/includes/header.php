<?php
// Get current page for active menu highlighting
$current_page = basename($_SERVER['SCRIPT_NAME'], '.php');

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

<!-- Topbar Start -->
<div class="container-fluid bg-dark px-5 d-none d-lg-block">
    <div class="row gx-0">
        <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
            <div class="d-inline-flex align-items-center" style="height: 45px;">
                <small class="text-light"><i class="fa fa-user-circle me-2"></i>Welcome, <?php echo htmlspecialchars($display_name); ?></small>
            </div>
        </div>
        <div class="col-lg-4 text-center text-lg-end">
            <div class="d-inline-flex align-items-center" style="height: 45px;">
                <a href="../index.php" class="text-light me-3"><i class="fa fa-home me-2"></i>Main Site</a>
                <a href="support.php" class="text-light me-3"><i class="fa fa-headset me-2"></i>Support</a>
                <a href="logout.php" class="text-light"><i class="fa fa-sign-out-alt me-2"></i>Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
        <a href="dashboard.php" class="navbar-brand p-0">
            <h1 class="m-0">Artifitech</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="dashboard.php" class="nav-item nav-link <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?php echo in_array($current_page, ['my-courses', 'available-courses', 'certificates']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">Academy</a>
                    <div class="dropdown-menu m-0">
                        <a href="my-courses.php" class="dropdown-item <?php echo $current_page === 'my-courses' ? 'active' : ''; ?>">My Courses</a>
                        <a href="available-courses.php" class="dropdown-item <?php echo $current_page === 'available-courses' ? 'active' : ''; ?>">Available Courses</a>
                        <a href="certificates.php" class="dropdown-item <?php echo $current_page === 'certificates' ? 'active' : ''; ?>">Certificates</a>
                    </div>
                </div>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?php echo in_array($current_page, ['my-subscriptions', 'available-products']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">Products</a>
                    <div class="dropdown-menu m-0">
                        <a href="my-subscriptions.php" class="dropdown-item <?php echo $current_page === 'my-subscriptions' ? 'active' : ''; ?>">My Subscriptions</a>
                        <a href="available-products.php" class="dropdown-item <?php echo $current_page === 'available-products' ? 'active' : ''; ?>">Available Products</a>
                    </div>
                </div>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?php echo in_array($current_page, ['profile', 'billing', 'support']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">Account</a>
                    <div class="dropdown-menu m-0">
                        <a href="profile.php" class="dropdown-item <?php echo $current_page === 'profile' ? 'active' : ''; ?>">Profile</a>
                        <a href="billing.php" class="dropdown-item <?php echo $current_page === 'billing' ? 'active' : ''; ?>">Billing</a>
                        <a href="support.php" class="dropdown-item <?php echo $current_page === 'support' ? 'active' : ''; ?>">Support</a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar End --> 