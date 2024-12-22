<?php
// Include global configuration
require_once 'includes/config.php';

// Set page-specific variables
$page = 'products';
$title = "Artifitech - Our Products | Leading Educational Technology Solutions";
$keywords = "EduManager, LMS, HR System, Financial System, Analytics Suite";
$description = "Explore Artifitech's suite of educational technology solutions, including our flagship LMS - EduManager, and enterprise solutions.";
$og_title = "Artifitech Products - Educational Technology Solutions";
$og_description = "Discover our comprehensive suite of educational technology solutions";
$og_url = "https://artifitech.com/products";

// Start output buffering
ob_start();
?>

<!-- Products Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3">Our Products</h6>
            <h1 class="display-6 mb-4">Transforming Education Through Innovation</h1>
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

        <!-- EduManager Section -->
        <div id="edumanager" class="product-section active">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                            <i class="fa fa-graduation-cap text-primary fs-4"></i>
                        </div>
                        <h4 class="mb-3">EduManager LMS</h4>
                        <p class="mb-4">Complete Learning Management System for modern educational institutions. EduManager LMS offers seamless integration with other educational tools, a user-friendly interface, and customization options to fit your institution's needs. It supports mobile learning and offline access, ensuring education is accessible anytime, anywhere.</p>
                        <div class="row gy-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Virtual Classrooms</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Interactive Learning Tools</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Student Progress Tracking</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <img src="img/edumanager.jpg" alt="EduManager Platform" class="img-fluid rounded mb-4">
                    </div>
                </div>
            </div>
        </div>

        <!-- HR System Section -->
        <div id="hr" class="product-section">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                            <i class="fa fa-users text-primary fs-4"></i>
                        </div>
                        <h4 class="mb-3">HR System</h4>
                        <p class="mb-4">Comprehensive HR management solution for educational institutions. Our HR System ensures compliance with labor laws and regulations, provides advanced analytics for workforce planning, and integrates seamlessly with payroll systems to streamline HR processes.</p>
                        <div class="row gy-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Employee Management</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Leave Management</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Performance Tracking</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <img src="img/hr-system.jpg" alt="HR System" class="img-fluid rounded mb-4">
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial System Section -->
        <div id="finance" class="product-section">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                            <i class="fa fa-chart-line text-primary fs-4"></i>
                        </div>
                        <h4 class="mb-3">Financial System</h4>
                        <p class="mb-4">Advanced financial management and reporting system. Our Financial System supports multi-currency transactions, ensures international compliance, and offers real-time financial dashboards and reporting. It includes robust security features to protect your financial data.</p>
                        <div class="row gy-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Budgeting Tools</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Financial Reporting</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Payment Processing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <img src="img/finance-system.jpg" alt="Financial System" class="img-fluid rounded mb-4">
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Suite Section -->
        <div id="analytics" class="product-section">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                            <i class="fa fa-chart-pie text-primary fs-4"></i>
                        </div>
                        <h4 class="mb-3">Analytics Suite</h4>
                        <p class="mb-4">Powerful analytics and reporting platform. Our Analytics Suite provides AI-driven insights and predictive analytics capabilities, customizable dashboards, and report generation. It integrates with various data sources and tools to deliver comprehensive analytics solutions.</p>
                        <div class="row gy-2">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Data Visualization</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Predictive Analytics</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3">
                                        <i class="fa fa-check text-white"></i>
                                    </div>
                                    <span>Custom Reports</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded h-100 p-5">
                        <img src="img/analytics-suite.jpg" alt="Analytics Suite" class="img-fluid rounded mb-4">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Products End -->

<!-- Add JavaScript for product section switching -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show EduManager section by default
    const defaultSection = document.getElementById('edumanager');
    if (defaultSection) {
        defaultSection.style.display = 'block';
        defaultSection.classList.add('active');
    }
    
    const productNav = document.querySelector('.product-nav');
    const productSections = document.querySelectorAll('.product-section');
    
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
            
            // Hide all product sections first
            productSections.forEach(section => {
                section.style.display = 'none';
                section.classList.remove('active');
            });
            
            // Show selected product section with animation
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

<style>
.product-section {
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.product-section.active {
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

/* Ensure product sections are visible when active */
#hr.active,
#finance.active,
#analytics.active,
#edumanager.active {
    display: block !important;
    opacity: 1 !important;
}

/* Animation for section transitions */
.product-section {
    animation-duration: 0.3s;
    animation-fill-mode: both;
}

.product-section.active {
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

.feature-item {
    height: 100%;
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
}
</style>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 