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

// Add required CSS and JS
$additional_css = '
    <link rel="stylesheet" href="' . $base_url . '/css/black-friday-modal.css">
';

$additional_js = '
    <script src="' . $base_url . '/js/black-friday-modal.js"></script>
    <script src="' . $base_url . '/js/news.js"></script>
';

// Start output buffering
ob_start();

// Include the news modal template
include 'includes/news-modal.php';
?>

<!-- Christmas Modal -->
<div class="modal fade" id="christmasModal" tabindex="-1" aria-labelledby="christmasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="christmas-modal">
                <button class="christmas-close" id="closeButton" aria-label="Close">&times;</button>
                <div class="christmas-content">
                    <h1 class="christmas-header">🎉 New Year Special! 🎊</h1>
                    <div class="christmas-body">
                        <p style="font-size: 1.2rem;">Start 2025 with Innovation!</p>
                        <p>Get our Premium EduManager Suite at an exclusive price:</p>
                        <div class="pricing-info">
                            <span class="old-price">R3,999/mo</span>
                            <span class="new-price">R2,499/mo</span>
                        </div>
                        <p class="offer-ends">Limited Time Offer - Valid until January 31st!</p>
                        <a href="#products" class="christmas-cta">Claim Your New Year Offer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .christmas-modal {
        position: relative;
        background: linear-gradient(135deg, #06BBCC 0%, #0891a1 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
    }
    .christmas-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: transparent;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        z-index: 1;
    }
    .christmas-header {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: white;
    }
    .christmas-body {
        padding: 1rem;
    }
    .christmas-body h2 {
        color: white;
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }
    .christmas-body p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    .pricing-info {
        margin: 2rem 0;
    }
    .old-price {
        text-decoration: line-through;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.3rem;
        margin-right: 1rem;
    }
    .new-price {
        color: white;
        font-size: 2rem;
        font-weight: bold;
    }
    .offer-ends {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        margin: 1rem 0;
    }
    .christmas-cta {
        display: inline-block;
        padding: 0.8rem 2rem;
        background: white;
        color: #06BBCC;
        text-decoration: none;
        border-radius: 50px;
        font-weight: bold;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }
    .christmas-cta:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
        color: #06BBCC;
    }
</style>

<script>
// Function to create snowflakes
function createSnowflakes() {
    const numberOfSnowflakes = 50;
    const overlay = document.getElementById('modalOverlay');
    
    for (let i = 0; i < numberOfSnowflakes; i++) {
        const snowflake = document.createElement('div');
        snowflake.className = 'snowflake';
        snowflake.innerHTML = '❄';
        snowflake.style.left = Math.random() * 100 + 'vw';
        snowflake.style.animationDuration = Math.random() * 3 + 2 + 's';
        snowflake.style.opacity = Math.random();
        snowflake.style.fontSize = Math.random() * 20 + 10 + 'px';
        overlay.appendChild(snowflake);
    }
}

// Function to show modal
function showModal() {
    const modal = document.getElementById('christmasModal');
    if (modal) {
        modal.style.display = 'block';
        createSnowflakes();
    }
}

// Function to hide modal
function hideModal() {
    const modal = document.getElementById('christmasModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Initialize modal functionality
document.addEventListener('DOMContentLoaded', function() {
    // Show modal after a delay
    setTimeout(showModal, 3000);

    // Close modal when clicking close button
    const closeButton = document.getElementById('closeButton');
    if (closeButton) {
        closeButton.addEventListener('click', hideModal);
    }

    // Close modal when clicking outside
    const modalOverlay = document.getElementById('christmasModal');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal();
            }
        });
    }
});
</script>

<!-- Add this right after the opening body tag -->
<div class="preloader">
    <div class="loader">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
</div>


<!-- Pricing Plans Start -->
<div class="container-fluid py-5" style="margin-top: 2rem;">
    <div class="row g-0">
        <!-- Left Column - News & Notices -->
        <div class="col-lg-2 wow fadeInUp px-3" data-wow-delay="0.1s">
            <!-- Latest News -->
            <div class="bg-light p-4 rounded shadow-hover mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-primary mb-0">Latest News</h3>
                </div>
                <div class="news-item mb-4">
                    <img src="img/index/news-1.jpg.png" class="img-fluid rounded mb-3" alt="AI Integration in Education">
                    <div class="date text-primary mb-2"><i class="far fa-calendar-alt me-2"></i>15 Nov 2023</div>
                    <h5>AI Integration in Education</h5>
                    <p class="text-muted">Discover how our AI solutions are revolutionizing the education sector...</p>
                    <a href="news.php?id=1" class="btn btn-outline-primary btn-sm">Read More</a>
                </div>
                <div class="news-item">
                    <img src="img/index/news-1.jpg.png" class="img-fluid rounded mb-3" alt="New Features in EduManager">
                    <div class="date text-primary mb-2"><i class="far fa-calendar-alt me-2"></i>10 Nov 2023</div>
                    <h5>New Features in EduManager</h5>
                    <p class="text-muted">Explore the latest features added to our flagship LMS platform...</p>
                    <a href="news.php?id=2" class="btn btn-outline-primary btn-sm">Read More</a>
                </div>
            </div>

            <!-- Important Notices -->
            <div class="bg-light p-4 rounded shadow-hover">
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

        <!-- Center Column - Pricing Plans -->
        <div class="col-lg-8 px-4">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">Pricing Plans</h6>
                <h1 class="display-6 mb-4">Choose the Perfect Solution for Your Institution</h1>
            </div>

            <!-- Product Navigation -->
        <div class="product-nav text-center mb-5">
            <a href="#edumanager" class="btn btn-primary active" data-product="edumanager">EduManager LMS</a>
            <a href="#hr" class="btn btn-light" data-product="hr">HR System</a>
            <a href="#finance" class="btn btn-light" data-product="finance">Financial System</a>
            <a href="#analytics" class="btn btn-light" data-product="analytics">Analytics Suite</a>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=1&plan=starter" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=1&plan=starter" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=2&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=2&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=3&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=3&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=4&plan=basic" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=4&plan=basic" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=5&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=5&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=6&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=6&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=7&plan=basic" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=7&plan=basic" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=8&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=8&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=9&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=9&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=10&plan=basic" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=10&plan=basic" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=11&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=11&plan=professional" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
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
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="<?php echo $base_url; ?>/user-portal/checkout.php?product_id=12&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php else: ?>
                                    <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&product_id=12&plan=enterprise" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 pt-5">
                <?php include 'includes/products-section.php'; ?>
            </div>
        </div>

        <!-- Right Column - Events -->
        <div class="col-lg-2 wow fadeInUp px-3" data-wow-delay="0.5s">
            <?php require_once 'includes/business-hours.php'; ?>
            <div class="bg-light p-4 rounded shadow-hover mb-4">
                <h3 class="mb-4 text-primary">Business Hours</h3>
                <div class="d-flex align-items-center bg-white rounded p-3 shadow-sm">
                    <div class="flex-shrink-0 btn-square bg-primary rounded-circle me-3">
                        <i class="far fa-clock text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-1"><?php echo getFormattedBusinessHours(); ?></h6>
                        <?php if (isBusinessOpen()): ?>
                            <small class="text-success"><i class="fas fa-door-open me-1"></i>We're Open</small>
                        <?php else: ?>
                            <small class="text-danger"><i class="fas fa-door-closed me-1"></i>Currently Closed</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="bg-light p-4 h-100 rounded shadow-hover">
                <h3 class="mb-4 text-primary">Upcoming Events</h3>
                <div class="event-item mb-4">
                    <div class="position-relative overflow-hidden rounded">
                        <img src="img/index/news-1.jpg.png" class="img-fluid w-100" alt="Event Image">
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
                        <img src="img/index/news-1.jpg.png" class="img-fluid w-100" alt="Event Image">
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
<!-- Pricing Plans End -->

<!-- Add JavaScript for tab switching -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all pricing sections
    const pricingSections = document.querySelectorAll('.pricing-section');
    
    // Hide all sections except edumanager by default
    pricingSections.forEach(section => {
        if (section.id === 'edumanager') {
            section.style.display = 'block';
            section.classList.add('active');
        } else {
            section.style.display = 'none';
            section.classList.remove('active');
        }
    });
    
    // Get product navigation buttons
    const productButtons = document.querySelectorAll('.product-nav [data-product]');
    
    // Set first button as active by default
    if (productButtons.length > 0) {
        productButtons[0].classList.remove('btn-light');
        productButtons[0].classList.add('active', 'btn-primary');
    }
    
    // Handle hash change (direct URL access)
    function handleHashChange() {
        const hash = window.location.hash.substring(1); // Remove the # symbol
        if (hash) {
            const targetSection = document.getElementById(hash);
            if (targetSection) {
                // Hide all sections
                pricingSections.forEach(section => {
                    section.style.display = 'none';
                    section.classList.remove('active');
                });
                
                // Show target section
                targetSection.style.display = 'block';
                setTimeout(() => targetSection.classList.add('active'), 10);
                
                // Update navigation buttons
                productButtons.forEach(button => {
                    if (button.getAttribute('data-product') === hash) {
                        button.classList.remove('btn-light');
                        button.classList.add('active', 'btn-primary');
                    } else {
                        button.classList.remove('active', 'btn-primary');
                        button.classList.add('btn-light');
                    }
                });
            }
        }
    }
    
    // Handle click events on product navigation
    document.querySelector('.product-nav').addEventListener('click', function(e) {
        if (e.target.matches('[data-product]')) {
            e.preventDefault();
            
            const targetProduct = e.target.getAttribute('data-product');
            window.location.hash = targetProduct;
            
            // Remove active class from all buttons
            productButtons.forEach(button => {
                button.classList.remove('active', 'btn-primary');
                button.classList.add('btn-light');
            });
            
            // Add active class to clicked button
            e.target.classList.remove('btn-light');
            e.target.classList.add('active', 'btn-primary');
            
            // Hide all sections first
            pricingSections.forEach(section => {
                section.style.display = 'none';
                section.classList.remove('active');
            });
            
            // Show selected section with animation
            const targetSection = document.getElementById(targetProduct);
            if (targetSection) {
                targetSection.style.display = 'block';
                // Force a reflow
                void targetSection.offsetWidth;
                targetSection.classList.add('active');
            }
        }
    });
    
    // Handle initial hash on page load
    if (window.location.hash) {
        handleHashChange();
    }
    
    // Listen for hash changes
    window.addEventListener('hashchange', handleHashChange);
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
    display: block !important;
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

<style>
/* Add these styles for better visual appearance */
.shadow-hover {
    transition: all 0.3s ease;
}

.shadow-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
}

.news-item img, 
.event-item img {
    transition: transform 0.3s ease;
}

.news-item:hover img, 
.event-item:hover img {
    transform: scale(1.05);
}

.notice-item {
    transition: transform 0.3s ease;
}

.notice-item:hover {
    transform: translateX(5px);
}

.event-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.event-item:hover .event-overlay {
    opacity: 1;
}

@media (max-width: 991.98px) {
    .col-lg-2 {
        margin-bottom: 2rem;
    }
    .col-lg-8 {
        padding: 0 1rem;
    }
}

@media (min-width: 992px) {
    .price-item {
        padding: 2rem !important;
    }
}

/* Add spacing for the main container */
.container-xxl {
    margin-top: 6rem;
}

@media (max-width: 991.98px) {
    .container-xxl {
        margin-top: 4rem;
    }
}

/* Add container fluid styles */
.container-fluid {
    max-width: 1920px;
    margin: 0 auto;
}

@media (min-width: 1400px) {
    .container-fluid {
        padding-left: 2.5rem;
        padding-right: 2.5rem;
    }
}

@media (min-width: 1600px) {
    .container-fluid {
        padding-left: 4rem;
        padding-right: 4rem;
    }
}

/* Update container styles */
.container-fluid {
    padding-left: 0;
    padding-right: 0;
    width: 100%;
}

.row.g-0 {
    margin-left: 0;
    margin-right: 0;
}

@media (max-width: 991.98px) {
    .col-lg-2, .col-lg-8 {
        padding: 0 1rem;
    }
}
</style>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?>