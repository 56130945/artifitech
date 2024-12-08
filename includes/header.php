<?php if (!isset($page)) $page = ''; ?>
<!-- Particle Background -->
<canvas id="particle-canvas"></canvas>
<link href="css/particles.css" rel="stylesheet">
<script src="js/particles.js"></script>

<!-- Brand & Contact Start -->
<div class="container-fluid py-4 px-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="row align-items-center top-bar">
        <div class="col-lg-4 col-md-12 text-center text-lg-start">
            <a href="index.php" class="navbar-brand m-0 p-0">
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
        <a class="navbar-brand d-lg-none" href="index.php">
            <img src="img/logo.png" alt="Artifitech Logo" height="40">
        </a>
        <button type="button" class="navbar-toggler me-3" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto p-3 p-lg-0">
                <a href="index.php" class="nav-item nav-link <?php echo ($page === 'home') ? 'active' : ''; ?>">Home</a>
                <a href="about.php" class="nav-item nav-link <?php echo ($page === 'about') ? 'active' : ''; ?>">About Us</a>
                <a href="products.php" class="nav-item nav-link <?php echo ($page === 'products') ? 'active' : ''; ?>">Products</a>
                <a href="academy.php" class="nav-item nav-link <?php echo ($page === 'academy') ? 'active' : ''; ?>">Academy</a>
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
                <a href="login.php" class="btn-login <?php echo ($page === 'login') ? 'active' : ''; ?>">
                    <i class="bi bi-person"></i> Login
                </a>
                <a href="register.php" class="btn-register <?php echo ($page === 'register') ? 'active' : ''; ?>">
                    <i class="bi bi-person-plus"></i> Register
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<style>
.auth-buttons {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-login, .btn-register {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-login {
    color: #2124B1;
    background: transparent;
    border: 2px solid #2124B1;
}

.btn-login:hover, .btn-login.active {
    color: #fff;
    background: #2124B1;
}

.btn-register {
    color: #fff;
    background: #2124B1;
    border: 2px solid #2124B1;
}

.btn-register:hover, .btn-register.active {
    background: #1b1e8f;
    border-color: #1b1e8f;
}

.btn-login i, .btn-register i {
    margin-right: 0.5rem;
}

@media (max-width: 991.98px) {
    .auth-buttons {
        margin-top: 1rem;
        justify-content: center;
    }
    
    .auth-buttons.d-none.d-lg-flex {
        display: flex !important;
    }
}
</style> 