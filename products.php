<?php
$page = 'products';

// Meta information
$title = "Artifitech - Flagship Products | Leading Educational Technology Solutions";
$keywords = "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing";
$description = "Discover Artifitech's flagship products including EduManager, our comprehensive Learning Management System, and innovative technology solutions.";
$og_title = "Flagship Products - Artifitech Educational Technology Solutions";
$og_description = "Explore our innovative educational technology products";
$og_url = "https://artifitech.co.za/products";

// Start output buffering
ob_start();
?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-3">Flagship Products</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Products Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">Our Products</h6>
                <h1 class="display-6 mb-4">Transforming Education Through Innovation</h1>
                <p class="text-muted">Discover our cutting-edge solutions designed to revolutionize the educational landscape in South Africa.</p>
            </div>

            <!-- Product Navigation -->
            <div class="product-nav mb-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="nav-wrapper text-center">
                    <button class="product-nav-btn active" data-filter="all">All Products</button>
                    <button class="product-nav-btn" data-filter="lms">LMS</button>
                    <button class="product-nav-btn" data-filter="ai">AI & IoT</button>
                    <button class="product-nav-btn" data-filter="xr">XR</button>
                    <button class="product-nav-btn" data-filter="cloud">Cloud</button>
                </div>
            </div>

            <!-- Featured Product - EduManager -->
            <div class="featured-product mb-5 wow fadeInUp" data-wow-delay="0.3s">
                <div class="product-spotlight">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="spotlight-content p-4 p-lg-5">
                                <span class="badge bg-primary mb-3">Featured Product</span>
                                <h2 class="mb-4">EduManager</h2>
                                <p class="lead mb-4">The next generation learning management system, powered by AI and designed for the future of education.</p>
                                <div class="spotlight-features mb-4">
                                    <div class="feature-item">
                                        <i class="fas fa-brain"></i>
                                        <span>AI-Powered</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-mobile-alt"></i>
                                        <span>Mobile-First</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-shield-alt"></i>
                                        <span>Secure</span>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary btn-lg rounded-pill">
                                    Learn More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="spotlight-image">
                                <img src="img/edumanager.jpg" alt="EduManager Platform" class="img-fluid rounded-4">
                                <div class="floating-badge top">
                                    <i class="fas fa-award"></i>
                                    <span>Top Rated</span>
                                </div>
                                <div class="floating-badge bottom">
                                    <i class="fas fa-users"></i>
                                    <span>10K+ Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="row g-4">
                <!-- AI & IoT Solutions Card -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="product-card" data-category="ai">
                        <div class="product-image">
                            <img src="img/ai-solutions.jpg" alt="AI Solutions" class="img-fluid">
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h4>AI & IoT Solutions</h4>
                                    <p>Transform your campus with intelligent automation</p>
                                    <a href="#" class="btn btn-light rounded-pill">Explore <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-details">
                            <div class="tech-stack">
                                <span class="tech-badge">Machine Learning</span>
                                <span class="tech-badge">IoT Sensors</span>
                                <span class="tech-badge">Analytics</span>
                            </div>
                            <div class="product-features">
                                <div class="feature">
                                    <i class="fas fa-robot"></i>
                                    <span>Smart Automation</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-chart-line"></i>
                                    <span>Predictive Analytics</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-network-wired"></i>
                                    <span>IoT Integration</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Extended Reality Card -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="product-card" data-category="xr">
                        <div class="product-image">
                            <img src="img/xr-solutions.jpg" alt="XR Solutions" class="img-fluid">
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h4>Extended Reality</h4>
                                    <p>Immersive learning experiences that inspire</p>
                                    <a href="#" class="btn btn-light rounded-pill">Discover <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-details">
                            <div class="tech-stack">
                                <span class="tech-badge">VR</span>
                                <span class="tech-badge">AR</span>
                                <span class="tech-badge">3D Modeling</span>
                            </div>
                            <div class="product-features">
                                <div class="feature">
                                    <i class="fas fa-vr-cardboard"></i>
                                    <span>Virtual Labs</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-cube"></i>
                                    <span>3D Learning</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-glasses"></i>
                                    <span>AR Overlay</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cloud Solutions Card -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="product-card" data-category="cloud">
                        <div class="product-image">
                            <img src="img/cloud-solutions.jpg" alt="Cloud Solutions" class="img-fluid">
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h4>Cloud Infrastructure</h4>
                                    <p>Scalable and secure cloud solutions</p>
                                    <a href="#" class="btn btn-light rounded-pill">Learn More <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-details">
                            <div class="tech-stack">
                                <span class="tech-badge">Cloud Native</span>
                                <span class="tech-badge">Security</span>
                                <span class="tech-badge">Scalable</span>
                            </div>
                            <div class="product-features">
                                <div class="feature">
                                    <i class="fas fa-cloud"></i>
                                    <span>Cloud Storage</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>POPIA Compliant</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-sync"></i>
                                    <span>Auto Scaling</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="row mt-5 g-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="col-12">
                    <div class="stats-container">
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-school"></i>
                                    </div>
                                    <h3 class="counter">100+</h3>
                                    <p>Educational Institutions</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <h3 class="counter">50K+</h3>
                                    <p>Active Students</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <h3 class="counter">99.9%</h3>
                                    <p>Uptime</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h3 class="counter">4.8</h3>
                                    <p>User Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="row mt-5 wow fadeInUp" data-wow-delay="0.3s">
                <div class="col-12">
                    <div class="cta-container text-center">
                        <h2>Ready to Transform Your Institution?</h2>
                        <p class="lead">Join the educational revolution with our cutting-edge solutions</p>
                        <div class="cta-buttons">
                            <a href="#" class="btn btn-primary btn-lg rounded-pill me-3">
                                Schedule Demo <i class="fas fa-play-circle ms-2"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-lg rounded-pill">
                                Contact Sales <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 