<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
?>
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
    <a href="../index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h1 class="m-0 text-primary">Artifitech</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="dashboard.php" class="nav-item nav-link <?php echo $page === 'dashboard' ? 'active' : ''; ?>">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a href="users.php" class="nav-item nav-link <?php echo $page === 'users' ? 'active' : ''; ?>">
                <i class="fa fa-users me-2"></i>Users
            </a>
            <a href="courses.php" class="nav-item nav-link <?php echo $page === 'courses' ? 'active' : ''; ?>">
                <i class="fa fa-graduation-cap me-2"></i>Courses
            </a>
            <a href="enrollments.php" class="nav-item nav-link <?php echo $page === 'enrollments' ? 'active' : ''; ?>">
                <i class="fa fa-user-graduate me-2"></i>Enrollments
            </a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">More</a>
                <div class="dropdown-menu m-0">
                    <a href="certificates.php" class="dropdown-item <?php echo $page === 'certificates' ? 'active' : ''; ?>">
                        <i class="fa fa-certificate me-2"></i>Certificates
                    </a>
                    <a href="reports.php" class="dropdown-item <?php echo $page === 'reports' ? 'active' : ''; ?>">
                        <i class="fa fa-chart-bar me-2"></i>Reports
                    </a>
                    <a href="settings.php" class="dropdown-item <?php echo $page === 'settings' ? 'active' : ''; ?>">
                        <i class="fa fa-cog me-2"></i>Settings
                    </a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-user-circle me-2"></i><?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </a>
                <div class="dropdown-menu m-0">
                    <a href="profile.php" class="dropdown-item">
                        <i class="fa fa-user me-2"></i>Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="../logout.php" class="dropdown-item text-danger">
                        <i class="fa fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End --> 