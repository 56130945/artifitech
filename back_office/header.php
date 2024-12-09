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
            <a href="dashboard.php" class="nav-item nav-link <?php echo $page === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
            <a href="profile.php" class="nav-item nav-link <?php echo $page === 'profile' ? 'active' : ''; ?>">Profile</a>
            <a href="courses.php" class="nav-item nav-link <?php echo $page === 'courses' ? 'active' : ''; ?>">My Courses</a>
            <a href="certificates.php" class="nav-item nav-link <?php echo $page === 'certificates' ? 'active' : ''; ?>">Certificates</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account</a>
                <div class="dropdown-menu m-0">
                    <a href="settings.php" class="dropdown-item">Settings</a>
                    <a href="support.php" class="dropdown-item">Support</a>
                    <div class="dropdown-divider"></div>
                    <a href="../logout.php" class="dropdown-item text-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End --> 