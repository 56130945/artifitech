<?php
require_once '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: ../login.php');
    exit;
}

// Set page title if not set
$title = $title ?? "Artifitech User Portal";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Exo+2:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/back-office.css" rel="stylesheet">
    <link href="../css/dashboard-common.css" rel="stylesheet">
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
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
                                <span>My Courses</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Learning</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page === 'browse-courses' ? 'active' : ''; ?>" href="browse-courses.php">
                                <i class="fas fa-book"></i>
                                <span>Browse Courses</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page === 'certificates' ? 'active' : ''; ?>" href="certificates.php">
                                <i class="fas fa-certificate"></i>
                                <span>Certificates</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Account</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page === 'profile' ? 'active' : ''; ?>" href="profile.php">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page === 'subscriptions' ? 'active' : ''; ?>" href="subscriptions.php">
                                <i class="fas fa-credit-card"></i>
                                <span>Subscriptions</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-content">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button type="button" class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="header-title"><?php echo htmlspecialchars($title); ?></h1>
                </div>
                <div class="header-right">
                    <div class="header-search">
                        <form action="search.php" method="GET">
                            <input type="text" name="q" placeholder="Search courses...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <div class="header-notifications">
                        <button type="button" class="notifications-toggle">
                            <i class="fas fa-bell"></i>
                            <span class="badge">2</span>
                        </button>
                        <div class="notifications-dropdown">
                            <div class="notifications-header">
                                <h6>Notifications</h6>
                                <a href="notifications.php">View All</a>
                            </div>
                            <div class="notifications-list">
                                <!-- Notifications will be dynamically loaded -->
                            </div>
                        </div>
                    </div>
                    <div class="header-profile">
                        <button type="button" class="profile-toggle">
                            <img src="../img/user-avatar.png" alt="Profile" class="profile-image">
                            <span class="profile-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="profile-dropdown">
                            <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                            <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                            <div class="dropdown-divider"></div>
                            <a href="../logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="admin-main">
                <?php echo $content ?? ''; ?>
            </main>

            <!-- Footer -->
            <footer class="admin-footer">
                <div class="container-fluid text-white" style="background: #061429;">
                    <div class="container">
                        <div class="row py-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center" style="height: 40px;">
                                    <p class="mb-0">&copy; <?php echo date('Y'); ?> <a class="text-white border-bottom" href="#">Artifitech</a>. All Rights Reserved.</p>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="text-white me-3" href="privacy.php">Privacy Policy</a>
                                <a class="text-white me-3" href="terms.php">Terms of Use</a>
                                <a class="text-white" href="contact.php">Contact</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script>
    $(document).ready(function() {
        // Toggle sidebar on mobile
        $('.sidebar-toggle').click(function() {
            $('.admin-sidebar').toggleClass('show');
        });

        // Toggle notifications dropdown
        $('.notifications-toggle').click(function(e) {
            e.stopPropagation();
            $('.notifications-dropdown').toggleClass('show');
            $('.profile-dropdown').removeClass('show');
        });

        // Toggle profile dropdown
        $('.profile-toggle').click(function(e) {
            e.stopPropagation();
            $('.profile-dropdown').toggleClass('show');
            $('.notifications-dropdown').removeClass('show');
        });

        // Close dropdowns when clicking outside
        $(document).click(function() {
            $('.notifications-dropdown, .profile-dropdown').removeClass('show');
        });

        // Prevent dropdown close when clicking inside
        $('.notifications-dropdown, .profile-dropdown').click(function(e) {
            e.stopPropagation();
        });
    });
    </script>
</body>
</html> 