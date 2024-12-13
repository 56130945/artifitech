<!-- Footer Start -->
<div class="container-fluid bg-dark text-light mt-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-4 col-md-6 footer-about">
                <div class="d-flex flex-column align-items-center justify-content-center text-center h-100 bg-primary p-4">
                    <a href="../index.php" class="navbar-brand">
                        <img src="../img/logo.png" alt="Artifitech Logo" class="img-fluid mb-3" style="height: 60px;">
                    </a>
                    <p class="mt-3 mb-4">Manage your Artifitech platform efficiently.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Quick Links</h5>
                <a class="btn btn-link" href="dashboard.php">Dashboard</a>
                <a class="btn btn-link" href="users.php">Users</a>
                <a class="btn btn-link" href="courses.php">Courses</a>
                <a class="btn btn-link" href="enrollments.php">Enrollments</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Management</h5>
                <a class="btn btn-link" href="certificates.php">Certificates</a>
                <a class="btn btn-link" href="reports.php">Reports</a>
                <a class="btn btn-link" href="settings.php">Settings</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Contact</h5>
                <p><i class="fa fa-phone-alt me-3"></i>+27 123 456 789</p>
                <p><i class="fa fa-envelope me-3"></i>support@artifitech.com</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Follow Us</h5>
                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-2" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-2" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-outline-secondary rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-white" style="background: #061429;">
    <div class="container text-center">
        <div class="row justify-content-end">
            <div class="col-lg-8 col-md-6">
                <div class="d-flex align-items-center justify-content-center" style="height: 75px;">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> <a class="text-white border-bottom" href="#">Artifitech</a>. All Rights Reserved.</p>
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