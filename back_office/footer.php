<!-- Footer Start -->
<div class="container-fluid bg-dark text-body footer mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-3">
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-3">Quick Links</h5>
                <a class="btn btn-link" href="dashboard.php">Dashboard</a>
                <a class="btn btn-link" href="profile.php">Profile</a>
                <a class="btn btn-link" href="courses.php">My Courses</a>
                <a class="btn btn-link" href="certificates.php">Certificates</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-3">Help & Support</h5>
                <a class="btn btn-link" href="support.php">Get Support</a>
                <a class="btn btn-link" href="faq.php">FAQs</a>
                <a class="btn btn-link" href="settings.php">Settings</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-3">Contact Us</h5>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+27 123 456 789</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>support@artifitech.com</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-3">Follow Us</h5>
                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href="#"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-0" href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a href="../index.php">Artifitech</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    Logged in as <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<style>
/* Ensure footer stays at bottom but doesn't overlap content */
body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.footer {
    margin-top: auto !important;
}

/* Reduce footer padding for back office */
.footer .container {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.footer .btn-link {
    padding: 0.25rem 0;
}
</style> 