<?php
require_once '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Set page title if not set
$title = $title ?? "Artifitech Admin - Dashboard";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Artifitech Admin Dashboard" name="keywords">
    <meta content="Artifitech administration and management system" name="description">

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
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- Admin Specific Styles -->
    <style>
        .admin-content {
            min-height: calc(100vh - 90px);
            padding: 2rem;
            margin-top: 90px;
            background-color: #F7FAFF;
        }

        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
        }

        .navbar-light {
            background: #FFFFFF;
            box-shadow: 0 0 45px rgba(0, 0, 0, .08);
        }

        .admin-card {
            background: #FFFFFF;
            border: none;
            border-radius: 5px;
            box-shadow: 0 0 45px rgba(0, 0, 0, .08);
        }

        .admin-stats {
            transition: .5s;
        }

        .admin-stats:hover {
            transform: translateY(-5px);
        }

        .table-container {
            background: #FFFFFF;
            border-radius: 5px;
            box-shadow: 0 0 45px rgba(0, 0, 0, .08);
            padding: 1.5rem;
        }

        .page-title {
            color: var(--dark);
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 1.5rem;
        }

        /* Ensure footer stays at bottom */
        .footer {
            margin-top: auto;
        }

        @media (max-width: 991.98px) {
            .admin-content {
                margin-top: 70px;
                padding: 1rem;
            }
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

    <!-- Navbar Start -->
    <?php include 'header.php'; ?>
    <!-- Navbar End -->

    <!-- Content Start -->
    <div class="admin-content">
        <?php echo $content ?? ''; ?>
    </div>
    <!-- Content End -->

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/isotope/isotope.pkgd.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <!-- Admin Javascript -->
    <script>
        $(document).ready(function() {
            // Initialize WOW.js
            new WOW().init();

            // Initialize CounterUp
            $('.counter').counterUp({
                delay: 10,
                time: 2000
            });

            // Back to top button
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.back-to-top').fadeIn('slow');
                } else {
                    $('.back-to-top').fadeOut('slow');
                }
            });
            $('.back-to-top').click(function () {
                $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
                return false;
            });
        });
    </script>
</body>

</html> 