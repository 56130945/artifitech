<?php
// Include global configuration
require_once 'includes/config.php';

// Set page-specific variables
$page = 'register';
$title = "Artifitech - Register | Educational Technology Solutions";
$keywords = "Register, Create Account, Sign Up, New User Registration";
$description = "Create your Artifitech account to access our full range of educational technology solutions and services.";
$og_title = "Register - Artifitech Educational Technology Solutions";
$og_description = "Create your Artifitech account";
$og_url = "https://artifitech.com/register";

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Register</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Register</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Register Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="text-center mb-4">
                        <h4 class="mb-3">Create Your Account</h4>
                        <p class="text-muted mb-4">Join Artifitech and get access to our comprehensive educational technology solutions</p>
                    </div>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="firstName" placeholder="First Name">
                                    <label for="firstName">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="lastName" placeholder="Last Name">
                                    <label for="lastName">Last Name</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control border-0" id="email" placeholder="Your Email">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="tel" class="form-control border-0" id="phone" placeholder="Phone Number">
                                    <label for="phone">Phone Number</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select border-0" id="institution">
                                        <option value="">Select your institution type</option>
                                        <option value="school">School</option>
                                        <option value="college">College</option>
                                        <option value="university">University</option>
                                        <option value="corporate">Corporate Training</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <label for="institution">Institution Type</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control border-0" id="password" placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control border-0" id="confirmPassword" placeholder="Confirm Password">
                                    <label for="confirmPassword">Confirm Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms">
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5 w-100" type="submit">
                                    Create Account
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <p class="text-muted mb-0">Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register End -->

<style>
.form-control, .form-select {
    border: 1px solid #ced4da;
    padding: 0.75rem;
}

.form-control:focus, .form-select:focus {
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

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}
</style>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 