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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn-user dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <?php if ($_SESSION['user_type'] === 'admin'): ?>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>/back_office/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>/user-portal/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo $base_url; ?>/user-portal/profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo $base_url; ?>/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn-login <?php echo ($page === 'login') ? 'active' : ''; ?>">
                        <i class="bi bi-person"></i> Login
                    </a>
                    <a href="register.php" class="btn-register <?php echo ($page === 'register') ? 'active' : ''; ?>">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                <?php endif; ?>
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

.btn-user {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
    color: #2124B1;
    background: transparent;
    border: 2px solid #2124B1;
    gap: 0.5rem;
}

.btn-user:hover {
    color: #fff;
    background: #2124B1;
}

.btn-user i {
    font-size: 1.2rem;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    font-weight: 500;
}

.dropdown-item i {
    opacity: 0.7;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.text-danger:hover {
    background-color: #dc3545;
    color: #fff !important;
}

.dropdown-item.text-danger:hover i {
    color: #fff;
}

/* Modal Custom Styles */
.modal-content {
    border-radius: 0.75rem;
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
}

.modal-header {
    background-color: #2124B1;
    color: #fff;
    border-bottom: none;
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
}

.modal-title {
    font-weight: 600;
}

.modal-footer {
    border-top: none;
    justify-content: center;
}

.btn-secondary {
    background-color: #1b1e8f;
    border: none;
    transition: background-color 0.3s ease;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #3a3dbf;
}

.btn-close {
    color: #fff;
    opacity: 0.8;
}

.btn-close:hover {
    color: #fff;
    opacity: 1;
}
</style> 

<!-- Modal HTML -->
<div class="modal fade" id="timeoutModal" tabindex="-1" aria-labelledby="timeoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timeoutModalLabel">Session Timeout Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You will be logged out in 20 seconds due to inactivity.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stay Logged In</button>
            </div>
        </div>
    </div>
</div>

<script>
    let warningTimeout;
    let logoutTimeout;

    function resetTimers() {
        clearTimeout(warningTimeout);
        clearTimeout(logoutTimeout);

        // Check if user is logged in
        <?php if (isset($_SESSION['user_id'])): ?>
            // Show warning modal after 40 seconds
            warningTimeout = setTimeout(() => {
                const timeoutModal = new bootstrap.Modal(document.getElementById('timeoutModal'));
                timeoutModal.show();
            }, 40000);

            // Auto logout after 60 seconds
            logoutTimeout = setTimeout(() => {
                window.location.href = '<?php echo $base_url; ?>/logout.php';
            }, 60000);
        <?php endif; ?>
    }

    // Christmas Modal Logic
    const christmasModalId = 'christmasModal';
    const christmasModalInterval = 10 * 60 * 1000; // 10 minutes in milliseconds

    function showChristmasModal() {
        const lastShown = localStorage.getItem('lastChristmasModalShown');
        const now = new Date().getTime();

        if (!lastShown || now - lastShown > christmasModalInterval) {
            const christmasModal = new bootstrap.Modal(document.getElementById(christmasModalId));
            christmasModal.show();
            localStorage.setItem('lastChristmasModalShown', now);
        }
    }

    // Show Christmas modal on page load
    window.onload = function() {
        resetTimers(); // Reset session timeout timers
        showChristmasModal(); // Show Christmas modal
    };

    // Reset timers on any user interaction
    document.onmousemove = resetTimers;
    document.onkeypress = resetTimers;
</script> 