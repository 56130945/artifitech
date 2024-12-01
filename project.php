<?php
$page = 'projects';

// Meta information
$title = "Artifitech - Our Projects | Leading Educational Technology Solutions Provider";
$keywords = "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing";
$description = "Explore Artifitech's innovative educational technology projects. See how we're transforming education through cutting-edge technology solutions.";
$og_title = "Our Projects - Artifitech Educational Technology Solutions";
$og_description = "Discover our innovative educational technology projects and solutions";
$og_url = "https://artifitech.com/projects";

// Start output buffering
ob_start();
?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-3">Projects</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Projects</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Portfolio Filter Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">Our Projects</h6>
                <h1 class="display-6 mb-4">Discover Our Innovation Lab</h1>
                <p class="text-muted">Explore our cutting-edge projects that are reshaping the future of education through technology.</p>
            </div>

            <!-- Filter Controls -->
            <div class="portfolio-filters text-center mb-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="filter-wrapper">
                    <button class="filter-button active" data-filter="*">
                        <i class="fas fa-globe"></i> All Projects
                    </button>
                    <button class="filter-button" data-filter="web">
                        <i class="fas fa-laptop-code"></i> Web Development
                    </button>
                    <button class="filter-button" data-filter="app">
                        <i class="fas fa-mobile-alt"></i> Mobile Apps
                    </button>
                    <button class="filter-button" data-filter="ai">
                        <i class="fas fa-brain"></i> AI Solutions
                    </button>
                    <button class="filter-button" data-filter="iot">
                        <i class="fas fa-microchip"></i> IoT Projects
                    </button>
                </div>
            </div>

            <!-- Portfolio Grid -->
            <div class="portfolio-container row g-4 wow fadeInUp" data-wow-delay="0.4s">
                <!-- Web Development Projects -->
                <div class="col-lg-4 col-md-6 portfolio-item web" data-name="EduManager" data-date="20230915">
                    <div class="portfolio-card">
                        <div class="portfolio-img">
                            <img class="img-fluid" src="img/project-1.jpg" alt="EduManager Platform">
                            <div class="portfolio-overlay">
                                <div class="portfolio-overlay-content">
                                    <a href="#" class="btn btn-light btn-sm">
                                        <i class="fas fa-link"></i> View Project
                                    </a>
                                    <a href="img/project-1.jpg" class="btn btn-light btn-sm" data-lightbox="portfolio">
                                        <i class="fas fa-search"></i> Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <div class="portfolio-tags">
                                <span class="tag"><i class="fas fa-laptop-code"></i> Web</span>
                                <span class="tag"><i class="fas fa-graduation-cap"></i> Education</span>
                            </div>
                            <h4>EduManager Platform</h4>
                            <p class="text-muted">A comprehensive learning management system designed for modern education.</p>
                            <div class="portfolio-stats">
                                <span><i class="fas fa-users"></i> 10K+ Users</span>
                                <span><i class="fas fa-star"></i> 4.8/5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile App Projects -->
                <div class="col-lg-4 col-md-6 portfolio-item app" data-name="StudentApp" data-date="20230801">
                    <div class="portfolio-card">
                        <div class="portfolio-img">
                            <img class="img-fluid" src="img/project-2.jpg" alt="Student Mobile App">
                            <div class="portfolio-overlay">
                                <div class="portfolio-overlay-content">
                                    <a href="#" class="btn btn-light btn-sm">
                                        <i class="fas fa-link"></i> View Project
                                    </a>
                                    <a href="img/project-2.jpg" class="btn btn-light btn-sm" data-lightbox="portfolio">
                                        <i class="fas fa-search"></i> Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <div class="portfolio-tags">
                                <span class="tag"><i class="fas fa-mobile-alt"></i> Mobile</span>
                                <span class="tag"><i class="fas fa-graduation-cap"></i> Education</span>
                            </div>
                            <h4>Student Mobile App</h4>
                            <p class="text-muted">Mobile learning platform with personalized study paths and progress tracking.</p>
                            <div class="portfolio-stats">
                                <span><i class="fas fa-download"></i> 50K+ Downloads</span>
                                <span><i class="fas fa-star"></i> 4.7/5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Solutions -->
                <div class="col-lg-4 col-md-6 portfolio-item ai" data-name="AITutor" data-date="20230710">
                    <div class="portfolio-card">
                        <div class="portfolio-img">
                            <img class="img-fluid" src="img/project-3.jpg" alt="AI Tutor System">
                            <div class="portfolio-overlay">
                                <div class="portfolio-overlay-content">
                                    <a href="#" class="btn btn-light btn-sm">
                                        <i class="fas fa-link"></i> View Project
                                    </a>
                                    <a href="img/project-3.jpg" class="btn btn-light btn-sm" data-lightbox="portfolio">
                                        <i class="fas fa-search"></i> Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <div class="portfolio-tags">
                                <span class="tag"><i class="fas fa-brain"></i> AI</span>
                                <span class="tag"><i class="fas fa-robot"></i> Machine Learning</span>
                            </div>
                            <h4>AI Tutor System</h4>
                            <p class="text-muted">Intelligent tutoring system powered by advanced AI algorithms.</p>
                            <div class="portfolio-stats">
                                <span><i class="fas fa-graduation-cap"></i> 100K+ Students</span>
                                <span><i class="fas fa-star"></i> 4.9/5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IoT Projects -->
                <div class="col-lg-4 col-md-6 portfolio-item iot" data-name="SmartCampus" data-date="20230620">
                    <div class="portfolio-card">
                        <div class="portfolio-img">
                            <img class="img-fluid" src="img/project-4.jpg" alt="Smart Campus Solution">
                            <div class="portfolio-overlay">
                                <div class="portfolio-overlay-content">
                                    <a href="#" class="btn btn-light btn-sm">
                                        <i class="fas fa-link"></i> View Project
                                    </a>
                                    <a href="img/project-4.jpg" class="btn btn-light btn-sm" data-lightbox="portfolio">
                                        <i class="fas fa-search"></i> Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <div class="portfolio-tags">
                                <span class="tag"><i class="fas fa-microchip"></i> IoT</span>
                                <span class="tag"><i class="fas fa-university"></i> Smart Campus</span>
                            </div>
                            <h4>Smart Campus Solution</h4>
                            <p class="text-muted">Connected campus infrastructure for enhanced learning experience.</p>
                            <div class="portfolio-stats">
                                <span><i class="fas fa-building"></i> 50+ Campuses</span>
                                <span><i class="fas fa-star"></i> 4.8/5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-5">
                <button class="btn btn-primary btn-lg load-more">
                    <i class="fas fa-sync-alt"></i> Load More Projects
                </button>
            </div>
        </div>
    </div>
    <!-- Portfolio Filter End -->

    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="display-6 mb-4">What Our Clients Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item bg-light rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-1.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-light rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-2.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-light rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-3.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item bg-light rounded p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img class="flex-shrink-0 rounded-circle border p-1" src="img/testimonial-4.jpg" alt="">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 