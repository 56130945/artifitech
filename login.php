<?php
// Include global configuration
require_once 'includes/config.php';

// Set page-specific variables
$page = 'login';
$title = "Artifitech - Login | Educational Technology Solutions";
$keywords = "Login, Artifitech Login, User Access, Account Login";
$description = "Login to your Artifitech account to access our educational technology solutions and services.";
$og_title = "Login - Artifitech Educational Technology Solutions";
$og_description = "Access your Artifitech account";
$og_url = "https://artifitech.com/login";

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Login</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Login</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Login Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Welcome Back</h4>
                        <p class="text-muted mb-4">Login to access your account and manage your services</p>
                    </div>
                    <form>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control border-0" id="email" placeholder="Your Email">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control border-0" id="password" placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="#" class="text-primary">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5 w-100" type="submit">
                                    Login
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <p class="text-muted mb-0">Don't have an account? <a href="register.php" class="text-primary">Register here</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login End -->

<style>
.form-control {
    border: 1px solid #ced4da;
    padding: 0.75rem;
}

.form-control:focus {
    box-shadow: none;
    border-color: #2124B1;
}

.form-check-input:checked {
    background-color: #2124B1;
    border-color: #2124B1;
}

.form-check-input:focus {
    box-shadow: none;
    border-color: #2124B1;
}
</style>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 