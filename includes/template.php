<?php
// Define base path based on the current script location
$is_back_office = strpos($_SERVER['SCRIPT_NAME'], '/back_office/') !== false;
$base_path = $is_back_office ? '../' : '';

// Common meta defaults (can be overridden by individual pages)
$title = $title ?? "Artifitech - Leading Educational Technology Solutions Provider";
$keywords = $keywords ?? "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing";
$description = $description ?? "Artifitech is South Africa's leading provider of educational technology solutions, specializing in Learning Management Systems and enterprise solutions.";
$og_title = $og_title ?? "Artifitech - Leading Educational Technology Solutions";
$og_description = $og_description ?? "South Africa's leading provider of educational technology solutions";
$og_url = $og_url ?? "https://artifitech.com";
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
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <?php 
    if ($is_back_office) {
        include $base_path . 'back_office/header.php';
    } else {
        include $base_path . 'includes/header.php';
    }
    ?>

    <?php echo $content; ?>

    <?php 
    if ($is_back_office) {
        include $base_path . 'back_office/footer.php';
    } else {
        include $base_path . 'includes/footer.php';
    }
    ?>

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
</body>

</html> 