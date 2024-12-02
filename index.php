<?php
$page = 'home';

// Meta information
$title = "Artifitech - Leading Educational Technology Solutions Provider";
$keywords = "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing";
$description = "Artifitech is South Africa's leading provider of educational technology solutions, specializing in Learning Management Systems and enterprise solutions.";
$og_title = "Artifitech - Leading Educational Technology Solutions";
$og_description = "South Africa's leading provider of educational technology solutions";
$og_url = "https://artifitech.com";

// Start output buffering
ob_start();
?>

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
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1">
                <img class="img-fluid" src="img/carousel-1.jpg" alt="Image">
            </button>
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="1" aria-label="Slide 2">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="Image">
            </button>
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="2" aria-label="Slide 3">
                <img class="img-fluid" src="img/carousel-3.jpg" alt="Image">
            </button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-4 animated zoomIn">Welcome to Artifitech</h4>
                        <h1 class="display-1 text-white mb-0 animated zoomIn">Transforming Business Through Technology</h1>
                        <p class="fs-5 text-white mb-4 animated zoomIn">Artifitech delivers innovative solutions in AI, IoT, Cloud Computing, and Extended Reality to empower businesses and educational institutions across South Africa and beyond.</p>
                        <a href="#contact" class="btn btn-primary py-3 px-5 animated zoomIn">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-4 animated zoomIn">We Are Leader In</h4>
                        <h1 class="display-1 text-white mb-0 animated zoomIn">Creative & Innovative Digital Solution</h1>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="img/carousel-3.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-4 animated zoomIn">We Are Leader In</h4>
                        <h1 class="display-1 text-white mb-0 animated zoomIn">Creative & Innovative Digital Solution</h1>
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

<!-- EduManager Spotlight -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title gradient-text bg-white text-center px-3">EduManager</h6>
            <h1 class="display-6 mb-4">The Complete Education Management Solution</h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="feature-item bg-light rounded text-center p-4 floating">
                    <i class="fa fa-video fa-3x text-primary mb-4"></i>
                    <h5 class="mb-3">Virtual Classrooms</h5>
                    <p class="m-0">Enable seamless online learning with interactive virtual classrooms. Real-time engagement tools and collaboration features.</p>
                </div>
            </div>
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="feature-item bg-light rounded text-center p-4 floating">
                    <i class="fa fa-tasks fa-3x text-primary mb-4"></i>
                    <h5 class="mb-3">Administrative Hub</h5>
                    <p class="m-0">Streamline operations with integrated HR, finance, and academic administration. Centralized management of all institutional processes.</p>
                </div>
            </div>
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="feature-item bg-light rounded text-center p-4 floating">
                    <i class="fa fa-chart-line fa-3x text-primary mb-4"></i>
                    <h5 class="mb-3">Analytics Dashboard</h5>
                    <p class="m-0">Make data-driven decisions with real-time analytics. Track performance, attendance, and resource utilization.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- EduManager Spotlight End -->

<!-- Pricing Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title gradient-text bg-white text-center px-3">Pricing Plans</h6>
            <h1 class="display-6 mb-4">Choose the Perfect Plan for Your Institution</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Starter Plan -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="price-item bg-light rounded h-100 p-4 position-relative overflow-hidden">
                    <div class="border-bottom pb-4 mb-4 text-center">
                        <h5 class="mb-1">Starter Plan</h5>
                        <p class="text-muted mb-0">For Small Institutions</p>
                        <div class="display-5 fw-bold text-primary my-4">
                            <small class="align-top fs-6">R</small>2,499<small class="align-bottom fs-6">/mo</small>
                        </div>
                    </div>
                    <div class="row gy-4">
                        <!-- 1. Student Capacity -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Up to 500 students</span>
                            </div>
                        </div>
                        <!-- 2. LMS Features -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Basic LMS features</span>
                            </div>
                        </div>
                        <!-- 3. Virtual Classrooms -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Virtual classrooms</span>
                            </div>
                        </div>
                        <!-- 4. Assignment Management -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Assignment management</span>
                            </div>
                        </div>
                        <!-- 5. Analytics -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Basic analytics</span>
                            </div>
                        </div>
                        <!-- 6. Support Level -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Email support</span>
                            </div>
                        </div>
                        <!-- 7. HR & Finance -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-danger rounded-circle me-3">
                                    <i class="fa fa-times text-white"></i>
                                </div>
                                <span class="text-muted">HR & Finance modules</span>
                            </div>
                        </div>
                        <!-- 8. Branding -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-danger rounded-circle me-3">
                                    <i class="fa fa-times text-white"></i>
                                </div>
                                <span class="text-muted">Custom branding</span>
                            </div>
                        </div>
                        <!-- 9. API Access -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-danger rounded-circle me-3">
                                    <i class="fa fa-times text-white"></i>
                                </div>
                                <span class="text-muted">API access</span>
                            </div>
                        </div>
                        <!-- 10. Premium Support -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-danger rounded-circle me-3">
                                    <i class="fa fa-times text-white"></i>
                                </div>
                                <span class="text-muted">24/7 dedicated support</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-modern w-100 mt-4 py-3 position-absolute bottom-0 start-0 mb-4 mx-4" style="width: calc(100% - 2rem) !important;" href="">Get Started</a>
                </div>
            </div>
            <!-- Professional Plan -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="price-item bg-light rounded h-100 p-4 position-relative overflow-hidden">
                    <div class="ribbon-wrapper">
                        <div class="glow"></div>
                        <div class="ribbon-text">Most Popular</div>
                    </div>
                    <div class="border-bottom pb-4 mb-4 text-center">
                        <h5 class="mb-1">Professional</h5>
                        <p class="text-muted mb-0">For Medium Institutions</p>
                        <div class="display-5 fw-bold text-primary my-4">
                            <small class="align-top fs-6">R</small>4,999<small class="align-bottom fs-6">/mo</small>
                        </div>
                    </div>
                    <div class="row gy-4">
                        <!-- 1. Student Capacity -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Up to 2000 students</span>
                            </div>
                        </div>
                        <!-- 2. LMS Features -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Advanced LMS features</span>
                            </div>
                        </div>
                        <!-- 3. Virtual Classrooms -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Virtual classrooms</span>
                            </div>
                        </div>
                        <!-- 4. Assignment Management -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Assignment management</span>
                            </div>
                        </div>
                        <!-- 5. Analytics -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Advanced analytics</span>
                            </div>
                        </div>
                        <!-- 6. Support Level -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Priority support</span>
                            </div>
                        </div>
                        <!-- 7. HR & Finance -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>HR & Finance modules</span>
                            </div>
                        </div>
                        <!-- 8. Branding -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Custom branding</span>
                            </div>
                        </div>
                        <!-- 9. API Access -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-danger rounded-circle me-3">
                                    <i class="fa fa-times text-white"></i>
                                </div>
                                <span class="text-muted">API access</span>
                            </div>
                        </div>
                        <!-- 10. Premium Support -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-danger rounded-circle me-3">
                                    <i class="fa fa-times text-white"></i>
                                </div>
                                <span class="text-muted">24/7 dedicated support</span>
                            </div>
                        </div>
                        <!-- 11. Custom Integrations -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-danger rounded-circle me-3">
                                    <i class="fa fa-times text-white"></i>
                                </div>
                                <span class="text-muted">Custom integrations</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-modern w-100 mt-4 py-3 position-absolute bottom-0 start-0 mb-4 mx-4" style="width: calc(100% - 2rem) !important;" href="">Get Started</a>
                </div>
            </div>
            <!-- Premium Plan -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="price-item bg-light rounded h-100 p-4 position-relative overflow-hidden">
                    <div class="border-bottom pb-4 mb-4 text-center">
                        <h5 class="mb-1">Premium Plan</h5>
                        <p class="text-muted mb-0">For Large Institutions</p>
                        <div class="display-5 fw-bold text-primary my-4">
                            <small class="align-top fs-6">R</small>9,999<small class="align-bottom fs-6">/mo</small>
                        </div>
                    </div>
                    <div class="row gy-4">
                        <!-- 1. Student Capacity -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Up to 5000 students</span>
                            </div>
                        </div>
                        <!-- 2. LMS Features -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Full feature access</span>
                            </div>
                        </div>
                        <!-- 3. Virtual Classrooms -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Virtual classrooms</span>
                            </div>
                        </div>
                        <!-- 4. Assignment Management -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Assignment management</span>
                            </div>
                        </div>
                        <!-- 5. Analytics -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>AI-powered analytics</span>
                            </div>
                        </div>
                        <!-- 6. Support Level -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>24/7 dedicated support</span>
                            </div>
                        </div>
                        <!-- 7. HR & Finance -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>HR & Finance modules</span>
                            </div>
                        </div>
                        <!-- 8. Branding -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Custom branding</span>
                            </div>
                        </div>
                        <!-- 9. API Access -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>API access</span>
                            </div>
                        </div>
                        <!-- 10. Premium Support -->
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Custom integrations</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-modern w-100 mt-4 py-3 position-absolute bottom-0 start-0 mb-4 mx-4" style="width: calc(100% - 2rem) !important;" href="">Get Started</a>
                </div>
            </div>
            <!-- Enterprise Plan -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="price-item bg-light rounded h-100 p-4 position-relative overflow-hidden">
                    <div class="border-bottom pb-4 mb-4 text-center">
                        <h5 class="mb-1">Enterprise Plan</h5>
                        <p class="text-muted mb-0">Custom Solutions</p>
                        <div class="display-5 fw-bold text-primary my-4">
                            Custom<small class="align-bottom fs-6"> pricing</small>
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
                                <span>Custom development</span>
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
                                <span>Tailored solutions</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Full customization</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>On-premise option</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <span>Custom SLA</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-modern w-100 mt-4 py-3 position-absolute bottom-0 start-0 mb-4 mx-4" style="width: calc(100% - 2rem) !important;" href="">Contact Us</a>
                </div>
            </div>
        </div>
        
        <!-- Additional Pricing Information -->
        <div class="row mt-5 g-4">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-4 h-100 position-relative overflow-hidden">
                    <div class="border-bottom pb-4 mb-4">
                        <h5 class="mb-0">All Plans Include</h5>
                    </div>
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-check text-primary"></i>
                                </div>
                                <span>Security & compliance features</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-check text-primary"></i>
                                </div>
                                <span>Regular updates</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-check text-primary"></i>
                                </div>
                                <span>Basic technical support</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-check text-primary"></i>
                                </div>
                                <span>Mobile app access</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-check text-primary"></i>
                                </div>
                                <span>Cloud storage</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-check text-primary"></i>
                                </div>
                                <span>SSL security</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-light rounded p-4 h-100 position-relative overflow-hidden">
                    <div class="border-bottom pb-4 mb-4">
                        <h5 class="mb-0">Optional Add-ons</h5>
                    </div>
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-plus text-primary"></i>
                                </div>
                                <span>Additional storage: <strong>R499/500GB</strong></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-plus text-primary"></i>
                                </div>
                                <span>Extra virtual classroom capacity: R299/100 users</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-plus text-primary"></i>
                                </div>
                                <span>Advanced reporting module: R799/month</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-plus text-primary"></i>
                                </div>
                                <span>White-label option: R1,499/month</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <div class="btn-sm-square bg-white rounded-circle me-3">
                                    <i class="fa fa-plus text-primary"></i>
                                </div>
                                <span>Additional admin users: R199/user/month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pricing End -->

<!-- Facts Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="fact-item bg-light rounded text-center h-100 p-5 parallax" data-speed="0.2">
                    <i class="fa fa-certificate fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Years Experience</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">5</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="fact-item bg-light rounded text-center h-100 p-5 parallax" data-speed="0.2">
                    <i class="fa fa-users-cog fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Team Members</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">1234</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="fact-item bg-light rounded text-center h-100 p-5 parallax" data-speed="0.2">
                    <i class="fa fa-users fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Satisfied Clients</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">1234</h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="fact-item bg-light rounded text-center h-100 p-5 parallax" data-speed="0.2">
                    <i class="fa fa-check fa-4x text-primary mb-4"></i>
                    <h5 class="mb-3">Projects Done</h5>
                    <h1 class="display-5 mb-0" data-toggle="counter-up">1234</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Facts End -->

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Login</h2>
        <form id="loginForm">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="#" onclick="showRegisterModal(); loginModal.style.display='none';">Register here</a></p>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Register</h2>
        <form id="registerForm">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="#" onclick="showLoginModal(); registerModal.style.display='none';">Login here</a></p>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 