<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<div class="sidebar bg-light border-end">
    <div class="sidebar-header p-3 border-bottom">
        <img src="../img/logo.png" alt="Artifitech Logo" class="img-fluid mb-3" style="max-height: 40px;">
        <h5 class="mb-0">User Portal</h5>
    </div>
    
    <div class="sidebar-menu p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            
            <!-- Academy Section -->
            <li class="nav-item mt-3">
                <h6 class="sidebar-heading px-3 text-muted text-uppercase">
                    <span>Academy</span>
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'my-courses' ? 'active' : ''; ?>" href="my-courses.php">
                    <i class="fas fa-graduation-cap me-2"></i> My Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'available-courses' ? 'active' : ''; ?>" href="available-courses.php">
                    <i class="fas fa-book me-2"></i> Available Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'certificates' ? 'active' : ''; ?>" href="certificates.php">
                    <i class="fas fa-certificate me-2"></i> Certificates
                </a>
            </li>
            
            <!-- Products Section -->
            <li class="nav-item mt-3">
                <h6 class="sidebar-heading px-3 text-muted text-uppercase">
                    <span>Products</span>
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'my-subscriptions' ? 'active' : ''; ?>" href="my-subscriptions.php">
                    <i class="fas fa-cube me-2"></i> My Subscriptions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'available-products' ? 'active' : ''; ?>" href="available-products.php">
                    <i class="fas fa-cubes me-2"></i> Available Products
                </a>
            </li>
            
            <!-- Account Section -->
            <li class="nav-item mt-3">
                <h6 class="sidebar-heading px-3 text-muted text-uppercase">
                    <span>Account</span>
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'profile' ? 'active' : ''; ?>" href="profile.php">
                    <i class="fas fa-user me-2"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'billing' ? 'active' : ''; ?>" href="billing.php">
                    <i class="fas fa-credit-card me-2"></i> Billing
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'support' ? 'active' : ''; ?>" href="support.php">
                    <i class="fas fa-question-circle me-2"></i> Support
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
}

.sidebar-header {
    background: #fff;
}

.sidebar-menu .nav-link {
    color: #6c757d;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    transition: all 0.3s ease;
}

.sidebar-menu .nav-link:hover {
    color: #2124B1;
    background: rgba(33, 36, 177, 0.05);
}

.sidebar-menu .nav-link.active {
    color: #2124B1;
    background: rgba(33, 36, 177, 0.1);
    font-weight: 500;
}

.sidebar-heading {
    font-size: 0.75rem;
    font-weight: 600;
}

/* Main content adjustment */
.main-content {
    margin-left: 260px;
    padding: 20px;
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
    .main-content {
        margin-left: 0;
    }
}
</style> 