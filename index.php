<?php
// Include global configuration
require_once 'includes/config.php';

// Set page-specific variables
$page = 'home';
$title = "Artifitech - Leading Educational Technology Solutions Provider";
$keywords = "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing";
$description = "Artifitech is South Africa's leading provider of educational technology solutions, specializing in Learning Management Systems and enterprise solutions.";
$og_title = "Artifitech - Leading Educational Technology Solutions";
$og_description = "South Africa's leading provider of educational technology solutions";
$og_url = "https://artifitech.com";

// Add Black Friday Modal CSS with correct path
$additional_css = '<link rel="stylesheet" href="' . $base_url . '/css/black-friday-modal.css">';

// Add Black Friday Modal JS with correct path
$additional_js = '<script src="' . $base_url . '/js/black-friday-modal.js"></script>';

// Start output buffering
ob_start();
?>

<!-- Black Friday Modal -->
<div class="black-friday-overlay" id="modalOverlay">
    <div class="black-friday-modal" role="dialog" aria-labelledby="modalTitle">
        <button class="black-friday-close" id="closeButton" aria-label="Close">&times;</button>
        <div class="black-friday-content">
            <h1 class="black-friday-header" id="modalTitle">🎉 Black Friday Special 🚀</h1>
            <div class="black-friday-body">
                <h2>70% OFF EduManager LMS</h2>
                <p>Transform your institution with South Africa's leading Learning Management System</p>
                <ul class="black-friday-features">
                    <li>✓ Virtual Classrooms</li>
                    <li>✓ Advanced Analytics</li>
                    <li>✓ Student Management</li>
                    <li>✓ 24/7 Support</li>
                </ul>
                <p class="black-friday-price">
                    <span class="original-price">R4,999/mo</span>
                    <span class="new-price">R1,499/mo</span>
                </p>
                <p class="offer-ends">Offer ends in 48 hours!</p>
                <a href="products.php" class="black-friday-cta">Get Started Now</a>
            </div>
        </div>
    </div>
</div>

<!-- Add this right after the opening body tag -->
<div class="preloader">
    <div class="loader">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
</div>

<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <h4 class="text-white text-uppercase mb-4 animated zoomIn">Welcome to Artifitech</h4>
                                <h1 class="display-1 text-white mb-4 animated slideInDown">Transforming Business Through Technology</h1>
                                <p class="fs-5 text-white mb-4 animated zoomIn">Artifitech delivers innovative solutions in AI, IoT, Cloud Computing, and Extended Reality.</p>
                                <a href="" class="btn btn-primary py-3 px-5 animated zoomIn">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <h4 class="text-white text-uppercase mb-4 animated zoomIn">We Are Leaders In</h4>
                                <h1 class="display-1 text-white mb-4 animated slideInDown">Educational Technology Solutions</h1>
                                <p class="fs-5 text-white mb-4 animated zoomIn">Empowering institutions with cutting-edge learning management systems.</p>
                                <a href="" class="btn btn-primary py-3 px-5 animated zoomIn">Discover More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="img/carousel-3.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <h4 class="text-white text-uppercase mb-4 animated zoomIn">Innovation & Excellence</h4>
                                <h1 class="display-1 text-white mb-4 animated slideInDown">Creative Digital Solutions</h1>
                                <p class="fs-5 text-white mb-4 animated zoomIn">Building the future of education through innovative technology.</p>
                                <a href="" class="btn btn-primary py-3 px-5 animated zoomIn">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->

<!-- Pricing Plans Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Pricing Plans</h6>
            <h1 class="display-6 mb-4">Choose the Perfect Solution for Your Institution</h1>
        </div>

        <!-- Product Navigation -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="product-nav wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <a href="#edumanager" class="btn btn-primary rounded-pill px-4 active" data-product="edumanager">EduManager LMS</a>
                        <a href="#hr" class="btn btn-light rounded-pill px-4" data-product="hr">HR System</a>
                        <a href="#finance" class="btn btn-light rounded-pill px-4" data-product="finance">Financial System</a>
                        <a href="#analytics" class="btn btn-light rounded-pill px-4" data-product="analytics">Analytics Suite</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- EduManager Pricing -->
        <div id="edumanager" class="pricing-section active">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Starter Plan</h5>
                            <p class="text-muted">For Small Institutions</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>2,499<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Up to 500 students</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Basic LMS features</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Virtual classrooms</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Basic analytics</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Email support</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="price-item bg-light rounded h-100 p-5 position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-0 bg-primary text-white px-4 py-1">Popular</div>
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Professional Plan</h5>
                            <p class="text-muted">For Medium Institutions</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>4,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Up to 2000 students</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced LMS features</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Interactive virtual classrooms</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced analytics</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>24/7 support</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Custom branding</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Enterprise Plan</h5>
                            <p class="text-muted">For Large Institutions</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>9,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Unlimited students</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Full LMS suite</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced virtual classrooms</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Enterprise analytics</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Dedicated support team</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>API access</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HR System Pricing -->
        <div id="hr" class="pricing-section">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Basic HR</h5>
                            <p class="text-muted">Essential HR Management</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>1,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Up to 50 employees</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Employee management</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Leave management</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Basic reporting</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="price-item bg-light rounded h-100 p-5 position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-0 bg-primary text-white px-4 py-1">Popular</div>
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Professional HR</h5>
                            <p class="text-muted">Advanced HR Solutions</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>3,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Up to 200 employees</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Full HR management</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Payroll processing</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Performance management</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced reporting</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Enterprise HR</h5>
                            <p class="text-muted">Complete HR Suite</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>7,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Unlimited employees</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Complete HR suite</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced payroll</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Custom workflows</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>API integration</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial System Pricing -->
        <div id="finance" class="pricing-section">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Basic Finance</h5>
                            <p class="text-muted">Essential Financial Management</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>2,499<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Basic accounting features</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Invoice management</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Basic reporting</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Up to 1000 transactions/month</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="price-item bg-light rounded h-100 p-5 position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-0 bg-primary text-white px-4 py-1">Popular</div>
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Professional Finance</h5>
                            <p class="text-muted">Advanced Financial Solutions</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>4,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced accounting</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Budgeting tools</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Financial forecasting</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Unlimited transactions</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Multi-currency support</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Enterprise Finance</h5>
                            <p class="text-muted">Complete Financial Suite</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>8,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Full financial suite</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced analytics</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Custom workflows</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>API integration</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Dedicated support</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Suite Pricing -->
        <div id="analytics" class="pricing-section">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Basic Analytics</h5>
                            <p class="text-muted">Essential Insights</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>1,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Basic dashboards</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Standard reports</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Data visualization</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Up to 100K data points</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="price-item bg-light rounded h-100 p-5 position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-0 bg-primary text-white px-4 py-1">Popular</div>
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Advanced Analytics</h5>
                            <p class="text-muted">Professional Insights</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>3,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Advanced dashboards</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Custom reports</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Predictive analytics</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Up to 1M data points</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Data export</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="price-item bg-light rounded h-100 p-5">
                        <div class="text-center mb-4">
                            <h5 class="mb-1">Enterprise Analytics</h5>
                            <p class="text-muted">Complete Analytics Suite</p>
                            <div class="display-5 fw-bold text-primary my-4">
                                <small class="align-top fs-6">R</small>7,999<small class="align-bottom fs-6">/mo</small>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>AI-powered analytics</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Real-time insights</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Custom integrations</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Unlimited data points</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>24/7 priority support</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pricing Plans End -->

<!-- Add JavaScript for tab switching -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show EduManager section by default
    const defaultSection = document.getElementById('edumanager');
    if (defaultSection) {
        defaultSection.style.display = 'block';
        defaultSection.classList.add('active');
    }
    
    const productNav = document.querySelector('.product-nav');
    const pricingSections = document.querySelectorAll('.pricing-section');
    
    // Set first nav button as active by default
    const defaultButton = productNav.querySelector('[data-product="edumanager"]');
    if (defaultButton) {
        defaultButton.classList.remove('btn-light');
        defaultButton.classList.add('active', 'btn-primary');
    }
    
    productNav.addEventListener('click', function(e) {
        if (e.target.matches('[data-product]')) {
            e.preventDefault();
            
            // Remove active class from all buttons
            productNav.querySelectorAll('a').forEach(a => {
                a.classList.remove('active', 'btn-primary');
                a.classList.add('btn-light');
            });
            
            // Add active class to clicked button
            e.target.classList.remove('btn-light');
            e.target.classList.add('active', 'btn-primary');
            
            // Hide all pricing sections first
            pricingSections.forEach(section => {
                section.style.display = 'none';
                section.classList.remove('active');
            });
            
            // Show selected pricing section with animation
            const targetProduct = e.target.getAttribute('data-product');
            const targetSection = document.getElementById(targetProduct);
            if (targetSection) {
                targetSection.style.display = 'block';
                // Force a reflow
                void targetSection.offsetWidth;
                targetSection.classList.add('active');
            }
        }
    });
});
</script>

<!-- Add CSS for pricing sections -->
<style>
.pricing-section {
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.pricing-section.active {
    display: block;
    opacity: 1;
}

.product-nav {
    margin-bottom: 2rem;
}

.product-nav .btn {
    margin: 0 0.5rem;
    min-width: 150px;
    transition: all 0.3s ease;
}

.product-nav .btn.active {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Ensure pricing sections are visible when active */
#hr.active,
#finance.active,
#analytics.active,
#edumanager.active {
    display: block !important;
    opacity: 1 !important;
}

/* Animation for section transitions */
.pricing-section {
    animation-duration: 0.3s;
    animation-fill-mode: both;
}

.pricing-section.active {
    animation-name: fadeIn;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- News & Events Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Latest Updates</h6>
            <h1 class="display-6 mb-4">News, Notices & Events</h1>
        </div>
        
        <div class="row g-4">
            <!-- Latest News Column -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light p-4 h-100">
                    <h3 class="mb-4 text-primary">Latest News</h3>
                    <div class="news-item mb-4">
                        <img src="img/news-1.jpg" class="img-fluid rounded mb-3" alt="News Image">
                        <div class="date text-primary mb-2"><i class="far fa-calendar-alt me-2"></i>15 Nov 2023</div>
                        <h5>AI Integration in Education</h5>
                        <p class="text-muted">Discover how our AI solutions are revolutionizing the education sector...</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                    <div class="news-item">
                        <img src="img/news-2.jpg" class="img-fluid rounded mb-3" alt="News Image">
                        <div class="date text-primary mb-2"><i class="far fa-calendar-alt me-2"></i>10 Nov 2023</div>
                        <h5>New Features in EduManager</h5>
                        <p class="text-muted">Explore the latest features added to our flagship LMS platform...</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>

            <!-- Important Notices Column -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-light p-4 h-100">
                    <h3 class="mb-4 text-primary">Important Notices</h3>
                    <div class="notice-item mb-4">
                        <div class="d-flex align-items-center bg-white rounded p-3 shadow-sm">
                            <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                                <i class="fa fa-bell text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">System Maintenance Notice</h6>
                                <small class="text-muted">Scheduled maintenance on Nov 20</small>
                            </div>
                        </div>
                    </div>
                    <div class="notice-item mb-4">
                        <div class="d-flex align-items-center bg-white rounded p-3 shadow-sm">
                            <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                                <i class="fa fa-star text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">New Feature Release</h6>
                                <small class="text-muted">Virtual classroom updates</small>
                            </div>
                        </div>
                    </div>
                    <div class="notice-item">
                        <div class="d-flex align-items-center bg-white rounded p-3 shadow-sm">
                            <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                                <i class="fa fa-certificate text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Certification Program</h6>
                                <small class="text-muted">New courses available</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Column -->
            <div class="col-lg-4 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light p-4 h-100">
                    <h3 class="mb-4 text-primary">Upcoming Events</h3>
                    <div class="event-item mb-4">
                        <div class="position-relative overflow-hidden rounded">
                            <img src="img/event-1.jpg" class="img-fluid w-100" alt="Event Image">
                            <div class="event-overlay">
                                <a href="#" class="btn btn-outline-light">Join Now</a>
                            </div>
                        </div>
                        <div class="pt-3">
                            <div class="d-flex mb-2">
                                <small class="me-3"><i class="far fa-calendar-alt text-primary me-2"></i>25 Nov 2023</small>
                                <small><i class="far fa-clock text-primary me-2"></i>10:00 AM</small>
                            </div>
                            <h5 class="mb-2">EdTech Summit 2023</h5>
                            <p class="text-muted">Join us for the biggest EdTech event of the year</p>
                        </div>
                    </div>
                    <div class="event-item">
                        <div class="position-relative overflow-hidden rounded">
                            <img src="img/event-2.jpg" class="img-fluid w-100" alt="Event Image">
                            <div class="event-overlay">
                                <a href="#" class="btn btn-outline-light">Register Now</a>
                            </div>
                        </div>
                        <div class="pt-3">
                            <div class="d-flex mb-2">
                                <small class="me-3"><i class="far fa-calendar-alt text-primary me-2"></i>30 Nov 2023</small>
                                <small><i class="far fa-clock text-primary me-2"></i>2:00 PM</small>
                            </div>
                            <h5 class="mb-2">EduManager Workshop</h5>
                            <p class="text-muted">Learn advanced features of our LMS platform</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- News & Events Section End -->

<style>
/* Add these styles to your existing CSS */
.event-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: 0.5s;
}

.event-item:hover .event-overlay {
    opacity: 1;
}

.news-item img, .event-item img {
    transition: 0.5s;
}

.news-item:hover img, .event-item:hover img {
    transform: scale(1.05);
}

.notice-item:hover {
    transform: translateY(-2px);
    transition: 0.3s;
}
</style>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 