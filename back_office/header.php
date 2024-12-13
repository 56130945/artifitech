<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
?>
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <img src="../img/logo.png" alt="Logo" class="logo">
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo $page === 'dashboard' ? 'active' : ''; ?>" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $page === 'courses' ? 'active' : ''; ?>" href="courses.php">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Courses</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Management</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo $page === 'users' ? 'active' : ''; ?>" href="users.php">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $page === 'enrollments' ? 'active' : ''; ?>" href="enrollments.php">
                        <i class="fas fa-user-graduate"></i>
                        <span>Enrollments</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Settings</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">
                        <i class="fas fa-cog"></i>
                        <span>General Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">
                        <i class="fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>

<header class="admin-header">
    <h1 class="header-title"><?php echo $title; ?></h1>
    <div class="header-actions">
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</header> 