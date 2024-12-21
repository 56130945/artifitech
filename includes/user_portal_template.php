<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo isset($title) ? $title : 'User Portal - Artifitech'; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Exo+2:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- Custom Portal Styles -->
    <style>
    :root {
        --primary: #06BBCC;
        --primary-dark: #0597a5;
        --primary-light: #0dcee1;
        --secondary: #FFFFFF;
        --secondary-dark: #F0FBFC;
        --light: #F0FBFC;
        --dark: #181d38;
        --gray-600: #666;
    }

    body {
        font-family: 'Exo 2', sans-serif;
        background: var(--light);
    }

    /* Sidebar */
    .portal-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 280px;
        background: var(--secondary);
        padding: 0;
        transition: all 0.3s;
        z-index: 1000;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .portal-sidebar .logo {
        padding: 25px;
        background: var(--light);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .portal-sidebar .logo img {
        height: 45px;
    }

    .portal-sidebar nav {
        padding: 20px;
    }

    .portal-sidebar .nav-link {
        color: var(--dark);
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: all 0.3s;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .portal-sidebar .nav-link:hover,
    .portal-sidebar .nav-link.active {
        color: #fff;
        background: var(--primary);
        transform: translateX(5px);
    }

    .portal-sidebar .nav-link i {
        width: 24px;
        text-align: center;
        margin-right: 12px;
        font-size: 1.1rem;
    }

    /* Main Content */
    .portal-main {
        margin-left: 280px;
        padding: 30px;
        min-height: 100vh;
        background: var(--light);
        transition: all 0.3s;
    }

    /* Top Navigation */
    .portal-topnav {
        background: #fff;
        padding: 20px 30px;
        margin: -30px -30px 30px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .portal-topnav .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .portal-topnav .user-info img {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid var(--primary);
    }

    .portal-topnav h4 {
        color: var(--dark);
        margin: 0;
        font-weight: 600;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        background: #fff;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 25px;
    }

    /* Tables */
    .table-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .table-header {
        padding: 25px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }

    .table-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark);
    }

    .admin-table {
        width: 100%;
        margin-bottom: 0;
    }

    .admin-table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 15px 25px;
        background: var(--light);
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
        color: var(--dark);
    }

    .admin-table td {
        padding: 15px 25px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: var(--dark);
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    /* Buttons */
    .btn {
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn i {
        font-size: 1rem;
    }

    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background: #bb2d3b;
        border-color: #bb2d3b;
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 6px 15px;
        font-size: 0.875rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .stats-card {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: #fff;
        font-size: 1.5rem;
    }

    .stats-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .stats-label {
        color: var(--gray-600);
        font-weight: 500;
    }

    /* Progress Bars */
    .progress {
        height: 8px;
        background-color: var(--light);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: var(--primary);
        transition: width 0.3s ease;
    }

    /* Badges */
    .badge {
        padding: 0.5em 0.75em;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .badge.bg-success {
        background-color: #10b981 !important;
    }

    .badge.bg-warning {
        background-color: #f59e0b !important;
        color: #fff;
    }

    .badge.bg-danger {
        background-color: #ef4444 !important;
    }

    /* Empty States */
    .text-center.py-4 {
        padding: 2.5rem 0;
    }

    .text-center.py-4 i {
        color: #ccc;
        margin-bottom: 1rem;
        display: block;
    }

    .text-center.py-4 p {
        color: var(--gray-600);
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
        .portal-sidebar {
            margin-left: -280px;
        }
        
        .portal-sidebar.active {
            margin-left: 0;
        }
        
        .portal-main {
            margin-left: 0;
        }
        
        .portal-main.active {
            margin-left: 280px;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 767.98px) {
        .portal-main {
            padding: 20px;
        }

        .portal-topnav {
            margin: -20px -20px 20px;
            padding: 15px 20px;
        }

        .table-header {
            padding: 20px;
        }

        .admin-table th,
        .admin-table td {
            padding: 12px 20px;
        }

        .user-info .text-end {
            display: none;
        }
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="portal-sidebar">
        <div class="logo">
            <a href="../index.php">
                <img src="../img/logo.png" alt="Artifitech Logo">
            </a>
        </div>
        <nav class="mt-4">
            <a href="dashboard.php" class="nav-link <?php echo $page === 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="courses.php" class="nav-link <?php echo $page === 'courses' ? 'active' : ''; ?>">
                <i class="fas fa-graduation-cap"></i> My Courses
            </a>
            <a href="subscriptions.php" class="nav-link <?php echo $page === 'subscriptions' ? 'active' : ''; ?>">
                <i class="fas fa-credit-card"></i> Subscriptions
            </a>
            <a href="invoices.php" class="nav-link <?php echo $page === 'invoices' ? 'active' : ''; ?>">
                <i class="fas fa-file-invoice"></i> Billing History
            </a>
            <a href="profile.php" class="nav-link <?php echo $page === 'profile' ? 'active' : ''; ?>">
                <i class="fas fa-user"></i> My Profile
            </a>
            <a href="../logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="portal-main">
        <!-- Top Navigation -->
        <div class="portal-topnav">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="mb-0"><?php echo isset($title) ? $title : 'User Portal'; ?></h4>
                </div>
                <div class="user-info">
                    <?php
                    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User';
                    $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
                    ?>
                    <div class="text-end me-3">
                        <h6 class="mb-0"><?php echo htmlspecialchars($user_name); ?></h6>
                        <small class="text-muted"><?php echo htmlspecialchars($user_email); ?></small>
                    </div>
                    <img src="../img/user.jpg" alt="User Avatar">
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <?php echo $content; ?>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <!-- Portal Javascript -->
    <script>
    // Toggle sidebar on mobile
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('.portal-sidebar').classList.toggle('active');
        document.querySelector('.portal-main').classList.toggle('active');
    });

    // Initialize WOW.js
    new WOW().init();
    </script>
</body>
</html> 