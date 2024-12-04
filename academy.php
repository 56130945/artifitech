<?php
// Include global configuration
require_once 'includes/config.php';

// Set page-specific variables
$page = 'academy';
$title = "Artifitech Academy - Professional Training & Certification";
$keywords = "Artifitech Academy, Professional Training, Software Certification, EduManager Training, HR System Training";
$description = "Join Artifitech Academy for professional training and certification in our suite of enterprise solutions. Master EduManager LMS, HR Systems, and more.";
$og_title = "Artifitech Academy - Professional Training & Certification";
$og_description = "Get certified in Artifitech's enterprise solutions through our professional training programs";
$og_url = "https://artifitech.com/academy";

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">All the skills you need in one place</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Academy</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Category Navigation Start -->
<div class="container-xxl py-3">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Our Courses</h6>
            <h1 class="display-6 mb-4">Choose Your Learning Path</h1>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="category-nav wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <a href="#" class="btn btn-primary rounded-pill px-4 active" data-category="all">All Courses</a>
                        <a href="#" class="btn btn-light rounded-pill px-4" data-category="lms">LMS Solutions</a>
                        <a href="#" class="btn btn-light rounded-pill px-4" data-category="hr">HR Systems</a>
                        <a href="#" class="btn btn-light rounded-pill px-4" data-category="finance">Financial Management</a>
                        <a href="#" class="btn btn-light rounded-pill px-4" data-category="analytics">Business Analytics</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Category Navigation End -->

<!-- Popular Topics Start -->
<div class="container-xxl py-3">
    <div class="container">
        <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                        <h5>EduManager LMS</h5>
                        <p class="mb-0">12K+ learners</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-users text-primary mb-4"></i>
                        <h5>HR System</h5>
                        <p class="mb-0">8K+ learners</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-chart-line text-primary mb-4"></i>
                        <h5>Financial System</h5>
                        <p class="mb-0">5K+ learners</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-chart-pie text-primary mb-4"></i>
                        <h5>Analytics</h5>
                        <p class="mb-0">3K+ learners</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-cogs text-primary mb-4"></i>
                        <h5>Integration</h5>
                        <p class="mb-0">2K+ learners</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-shield-alt text-primary mb-4"></i>
                        <h5>Security</h5>
                        <p class="mb-0">1K+ learners</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Popular Topics End -->

<!-- Courses Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <!-- EduManager Mastery Course -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="course-item bg-light">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid" src="img/courses/edumanager-master.jpg" alt="EduManager Mastery">
                        <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                        </div>
                    </div>
                    <div class="text-center p-4 pb-0">
                        <h3 class="mb-0">R1,999</h3>
                        <div class="mb-3">
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small>(2,145)</small>
                        </div>
                        <h5 class="mb-4">EduManager LMS Complete Guide</h5>
                    </div>
                    <div class="d-flex border-top">
                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>John Smith</small>
                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>40 Hrs</small>
                        <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                    </div>
                </div>
            </div>

            <!-- HR System Professional -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="course-item bg-light">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid" src="img/courses/hr-professional.jpg" alt="HR System Professional">
                        <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                        </div>
                    </div>
                    <div class="text-center p-4 pb-0">
                        <h3 class="mb-0">R1,799</h3>
                        <div class="mb-3">
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star-half-alt text-primary"></small>
                            <small>(1,687)</small>
                        </div>
                        <h5 class="mb-4">HR System Professional Certification</h5>
                    </div>
                    <div class="d-flex border-top">
                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Sarah Johnson</small>
                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>35 Hrs</small>
                        <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>25 Students</small>
                    </div>
                </div>
            </div>

            <!-- Financial System Expert -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="course-item bg-light">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid" src="img/courses/finance-expert.jpg" alt="Financial System Expert">
                        <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                            <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                        </div>
                    </div>
                    <div class="text-center p-4 pb-0">
                        <h3 class="mb-0">R2,199</h3>
                        <div class="mb-3">
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small>(923)</small>
                        </div>
                        <h5 class="mb-4">Financial System Implementation & Management</h5>
                    </div>
                    <div class="d-flex border-top">
                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Michael Chen</small>
                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>45 Hrs</small>
                        <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>20 Students</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Courses End -->

<!-- Features Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Why Choose Us</h6>
            <h1 class="display-6 mb-4">Learning Benefits</h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="feature-item bg-light rounded text-center p-4">
                    <i class="fa fa-3x fa-certificate text-primary mb-4"></i>
                    <h5 class="mb-3">Professional Certification</h5>
                    <p class="m-0">Earn industry-recognized certifications upon completion</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="feature-item bg-light rounded text-center p-4">
                    <i class="fa fa-3x fa-users text-primary mb-4"></i>
                    <h5 class="mb-3">Expert Instructors</h5>
                    <p class="m-0">Learn from industry professionals with real experience</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="feature-item bg-light rounded text-center p-4">
                    <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                    <h5 class="mb-3">24/7 Support</h5>
                    <p class="m-0">Get help anytime through our dedicated support team</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="feature-item bg-light rounded text-center p-4">
                    <i class="fa fa-3x fa-book text-primary mb-4"></i>
                    <h5 class="mb-3">Lifetime Access</h5>
                    <p class="m-0">Access course materials and updates forever</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Features End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 