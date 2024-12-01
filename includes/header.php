<?php if (!isset($page)) $page = ''; ?>
<!-- Brand & Contact Start -->
<div class="container-fluid py-4 px-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="row align-items-center top-bar">
        <div class="col-lg-4 col-md-12 text-center text-lg-start">
            <a href="" class="navbar-brand m-0 p-0">
                <img src="img/logo.png" alt="Artifitech Logo" height="60">
            </a>
        </div>
        <div class="col-lg-8 col-md-7 d-none d-lg-block">
            <div class="row">
                <div class="col-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                            <i class="far fa-clock text-primary"></i>
                        </div>
                        <div class="ps-3">
                            <p class="mb-2">Opening Hour</p>
                            <h6 class="mb-0">Mon - Fri, 8:00 - 17:00</h6>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                            <i class="fa fa-phone text-primary"></i>
                        </div>
                        <div class="ps-3">
                            <p class="mb-2">Call Us</p>
                            <h6 class="mb-0">+27 123 456 789</h6>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                            <i class="far fa-envelope text-primary"></i>
                        </div>
                        <div class="ps-3">
                            <p class="mb-2">Email Us</p>
                            <h6 class="mb-0">info@artifitech.co.za</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand & Contact End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-lg-none" href="#">
            <img src="img/logo.png" alt="Artifitech Logo" height="40">
        </a>
        <button type="button" class="navbar-toggler me-3" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto p-3 p-lg-0">
                <a href="index.php" class="nav-item nav-link <?php echo ($page === 'home') ? 'active' : ''; ?>">Home</a>
                <a href="about.php" class="nav-item nav-link <?php echo ($page === 'about') ? 'active' : ''; ?>">About Us</a>
                <a href="products.php" class="nav-item nav-link <?php echo ($page === 'products') ? 'active' : ''; ?>">Flagship Products</a>
                <a href="project.php" class="nav-item nav-link <?php echo ($page === 'project') ? 'active' : ''; ?>">Projects</a>
                <a href="contact.php" class="nav-item nav-link <?php echo ($page === 'contact') ? 'active' : ''; ?>">Contact Us</a>
            </div>
            <div class="auth-buttons d-none d-lg-flex">
                <div class="search-wrapper">
                    <input type="text" class="search-input" placeholder="Search...">
                    <button class="search-button">
                        <i class="bi bi-search"></i>
                    </button>
                    <div class="search-results"></div>
                </div>
                <a href="#" class="btn-login" id="loginBtn">
                    <i class="bi bi-person"></i> Login
                </a>
                <a href="#" class="btn-register" id="registerBtn">
                    <i class="bi bi-person-plus"></i> Register
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End --> 