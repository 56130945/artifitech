<?php
require_once '../includes/config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Set base path for assets
$base_path = '../';

// Common meta defaults
$title = $title ?? "Artifitech Admin - Dashboard";
$keywords = "Admin Dashboard, Management, Educational Technology";
$description = "Artifitech admin dashboard for managing educational technology solutions.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo htmlspecialchars($keywords); ?>" name="keywords">
    <meta content="<?php echo htmlspecialchars($description); ?>" name="description">

    <!-- Favicon -->
    <link href="<?php echo $base_path; ?>img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Exo+2:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo $base_path; ?>lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo $base_path; ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo $base_path; ?>css/style.css" rel="stylesheet">

    <!-- Admin Stylesheet -->
    <style>
    .admin-wrapper {
        display: flex;
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .admin-sidebar {
        width: 280px;
        background: linear-gradient(45deg, #2124B1, #4777F5);
        color: #fff;
        transition: all 0.3s;
        z-index: 1000;
    }

    .admin-sidebar .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 0.75rem 1.25rem;
        display: flex;
        align-items: center;
        transition: all 0.3s;
        border-radius: 0;
        font-family: 'Exo 2', sans-serif;
    }

    .admin-sidebar .nav-link:hover {
        color: #fff;
        background: rgba(255,255,255,0.1);
        padding-left: 1.5rem;
    }

    .admin-sidebar .nav-link i {
        width: 24px;
        text-align: center;
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }

    .admin-sidebar .nav-link.active {
        background: rgba(255,255,255,0.2);
        color: #fff;
        font-weight: 500;
    }

    .admin-content {
        flex: 1;
        padding: 2rem;
        overflow-x: hidden;
    }

    .admin-header {
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        padding: 1rem 2rem;
        margin: -2rem -2rem 2rem -2rem;
    }

    .stat-card {
        background: #fff;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        border: none;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    @media (max-width: 991.98px) {
        .admin-sidebar {
            position: fixed;
            left: -280px;
            height: 100vh;
        }

        .admin-sidebar.show {
            left: 0;
        }

        .admin-content {
            padding: 1rem;
        }

        .admin-header {
            margin: -1rem -1rem 1rem -1rem;
            padding: 1rem;
        }
    }

    .table th {
        font-weight: 600;
        font-family: 'Exo 2', sans-serif;
        color: #2124B1;
    }

    .btn-primary {
        background: #2124B1;
        border-color: #2124B1;
    }

    .btn-primary:hover {
        background: #4777F5;
        border-color: #4777F5;
    }

    .page-header {
        background: linear-gradient(45deg, #2124B1, #4777F5);
        color: #fff;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Admin Wrapper Start -->
    <div class="admin-wrapper">
        <!-- Sidebar Start -->
        <div class="admin-sidebar">
            <div class="p-4">
                <h4 class="text-white mb-0">Artifitech</h4>
                <p class="text-white-50 small mb-0">Admin Panel</p>
            </div>
            <nav class="nav flex-column p-3">
                <a class="nav-link <?php echo $page === 'dashboard' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link <?php echo $page === 'users' ? 'active' : ''; ?>" href="users.php">
                    <i class="fas fa-users"></i> Users
                </a>
                <a class="nav-link <?php echo $page === 'courses' ? 'active' : ''; ?>" href="courses.php">
                    <i class="fas fa-graduation-cap"></i> Courses
                </a>
                <a class="nav-link <?php echo $page === 'enrollments' ? 'active' : ''; ?>" href="enrollments.php">
                    <i class="fas fa-user-graduate"></i> Enrollments
                </a>
                <a class="nav-link <?php echo $page === 'certificates' ? 'active' : ''; ?>" href="certificates.php">
                    <i class="fas fa-certificate"></i> Certificates
                </a>
                <a class="nav-link <?php echo $page === 'reports' ? 'active' : ''; ?>" href="reports.php">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
                <a class="nav-link <?php echo $page === 'settings' ? 'active' : ''; ?>" href="settings.php">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider bg-light my-3 opacity-25"></div>
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="admin-content">
            <!-- Header Start -->
            <div class="admin-header d-flex justify-content-between align-items-center">
                <button class="btn btn-link text-dark d-lg-none" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-dark" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
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
            </div>
            <!-- Header End -->

            <!-- Main Content Start -->
            <?php echo $content; ?>
            <!-- Main Content End -->
        </div>
        <!-- Content End -->
    </div>
    <!-- Admin Wrapper End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_path; ?>lib/wow/wow.min.js"></script>
    <script src="<?php echo $base_path; ?>lib/easing/easing.min.js"></script>
    <script src="<?php echo $base_path; ?>lib/waypoints/waypoints.min.js"></script>
    <script src="<?php echo $base_path; ?>lib/counterup/counterup.min.js"></script>
    <script src="<?php echo $base_path; ?>lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?php echo $base_path; ?>lib/isotope/isotope.pkgd.min.js"></script>
    <script src="<?php echo $base_path; ?>lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="<?php echo $base_path; ?>js/main.js"></script>

    <!-- Admin Javascript -->
    <script>
    $(document).ready(function() {
        // Initialize WOW.js
        new WOW().init();

        // Toggle sidebar on mobile
        $('#sidebarToggle').click(function() {
            $('.admin-sidebar').toggleClass('show');
        });

        // Close sidebar when clicking outside on mobile
        $(document).click(function(e) {
            if ($(window).width() < 992) {
                if (!$(e.target).closest('.admin-sidebar, #sidebarToggle').length) {
                    $('.admin-sidebar').removeClass('show');
                }
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
    </script>
</body>

</html> 