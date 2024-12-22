<?php
// Include global configuration
require_once 'includes/config.php';

// Set page-specific variables
$page = 'academy';
$title = "Artifitech Academy | Learn Essential Tech Skills";
$keywords = "Tech Academy, Online Learning, Digital Skills, Professional Development";
$description = "Join Artifitech Academy to learn essential tech skills and advance your career with our expert-led courses.";
$og_title = "Artifitech Academy - Professional Tech Education";
$og_description = "Advance your career with our comprehensive tech education programs";
$og_url = "https://artifitech.com/academy";

// Start output buffering
ob_start();
?>

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
                        <a href="#ai-ml" class="btn btn-primary rounded-pill px-4 active" data-category="ai-ml">AI & Machine Learning</a>
                        <a href="#deep-learning" class="btn btn-light rounded-pill px-4" data-category="deep-learning">Deep Learning</a>
                        <a href="#nlp" class="btn btn-light rounded-pill px-4" data-category="nlp">NLP</a>
                        <a href="#ai-data-analytics" class="btn btn-light rounded-pill px-4" data-category="ai-data-analytics">AI-Powered Data Analytics</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Category Navigation End -->

<!-- Course Sections Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- AI & Machine Learning Section -->
        <div id="ai-ml" class="course-section active">
            <div class="row g-4">
                <!-- AI & Machine Learning Fundamentals -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/ai-ml-fundamentals.jpg" alt="AI & Machine Learning Fundamentals">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Beginner</span>
                                <h3 class="mb-0">R1,299</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(60)</small>
                            </div>
                            <h5 class="mb-4">AI & Machine Learning Fundamentals</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Dr. Amanda Davis</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>25 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>60 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Intermediate Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/ai-ml-intermediate.jpg" alt="AI & Machine Learning Intermediate">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-success mb-2">Intermediate</span>
                                <h3 class="mb-0">R2,299</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(40)</small>
                            </div>
                            <h5 class="mb-4">AI & Machine Learning Intermediate</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Dr. Amanda Davis</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>40 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>40 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Mastery Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/ai-ml-mastery.jpg" alt="AI & Machine Learning Mastery">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-danger mb-2">Mastery</span>
                                <h3 class="mb-0">R3,299</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(20)</small>
                            </div>
                            <h5 class="mb-4">AI & Machine Learning Mastery</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Dr. Amanda Davis</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>60 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>20 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deep Learning Section -->
        <div id="deep-learning" class="course-section">
            <div class="row g-4">
                <!-- Deep Learning for Professionals -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/deep-learning-beginner.jpg" alt="Deep Learning for Professionals">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Beginner</span>
                                <h3 class="mb-0">R1,499</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(50)</small>
                            </div>
                            <h5 class="mb-4">Deep Learning for Professionals</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Prof. Mark Nguyen</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>20 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>50 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Intermediate Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/deep-learning-intermediate.jpg" alt="Deep Learning Intermediate">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-success mb-2">Intermediate</span>
                                <h3 class="mb-0">R2,499</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(30)</small>
                            </div>
                            <h5 class="mb-4">Deep Learning Intermediate</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Prof. Mark Nguyen</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>45 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Mastery Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/deep-learning-mastery.jpg" alt="Deep Learning Mastery">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-danger mb-2">Mastery</span>
                                <h3 class="mb-0">R3,499</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(15)</small>
                            </div>
                            <h5 class="mb-4">Deep Learning Mastery</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Prof. Mark Nguyen</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>60 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>15 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NLP Section -->
        <div id="nlp" class="course-section">
            <div class="row g-4">
                <!-- NLP Essentials -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/nlp-beginner.jpg" alt="NLP Essentials">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Beginner</span>
                                <h3 class="mb-0">R1,199</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(40)</small>
                            </div>
                            <h5 class="mb-4">NLP Essentials</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Sarah Johnson</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>20 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>40 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Intermediate Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/nlp-intermediate.jpg" alt="NLP Intermediate">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-success mb-2">Intermediate</span>
                                <h3 class="mb-0">R2,199</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(25)</small>
                            </div>
                            <h5 class="mb-4">NLP Intermediate</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Sarah Johnson</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>35 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>25 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Mastery Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/nlp-mastery.jpg" alt="NLP Mastery">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-danger mb-2">Mastery</span>
                                <h3 class="mb-0">R3,199</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(15)</small>
                            </div>
                            <h5 class="mb-4">NLP Mastery</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Sarah Johnson</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>50 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>15 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI-Powered Data Analytics Section -->
        <div id="ai-data-analytics" class="course-section">
            <div class="row g-4">
                <!-- AI-Powered Data Analytics -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/ai-data-analytics-beginner.jpg" alt="AI-Powered Data Analytics">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-primary mb-2">Beginner</span>
                                <h3 class="mb-0">R1,399</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(45)</small>
                            </div>
                            <h5 class="mb-4">AI-Powered Data Analytics</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Emily Wong</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>20 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>45 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Intermediate Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/ai-data-analytics-intermediate.jpg" alt="AI-Powered Data Analytics Intermediate">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-success mb-2">Intermediate</span>
                                <h3 class="mb-0">R2,399</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(30)</small>
                            </div>
                            <h5 class="mb-4">AI-Powered Data Analytics Intermediate</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Emily Wong</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>40 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Mastery Level -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="img/courses/ai-data-analytics-mastery.jpg" alt="AI-Powered Data Analytics Mastery">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="#" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Enroll Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <div class="mb-3">
                                <span class="badge bg-danger mb-2">Mastery</span>
                                <h3 class="mb-0">R3,499</h3>
                            </div>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>(20)</small>
                            </div>
                            <h5 class="mb-4">AI-Powered Data Analytics Mastery</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>Michael Chen</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>55 Hrs</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>20 Students</small>
                        </div>
                        <div class="text-center mt-4">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?php echo $base_url; ?>/user-portal/checkout.php?course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/login.php?redirect=checkout&course_id=1" class="btn btn-primary rounded-pill py-3 px-5">Get Started</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Course Sections End -->

<!-- Add JavaScript for course section switching -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show AI & Machine Learning section by default
    const defaultSection = document.getElementById('ai-ml');
    if (defaultSection) {
        defaultSection.style.display = 'block';
        defaultSection.classList.add('active');
    }
    
    const categoryNav = document.querySelector('.category-nav');
    const courseSections = document.querySelectorAll('.course-section');
    
    // Set first nav button as active by default
    const defaultButton = categoryNav.querySelector('[data-category="ai-ml"]');
    if (defaultButton) {
        defaultButton.classList.remove('btn-light');
        defaultButton.classList.add('active', 'btn-primary');
    }
    
    categoryNav.addEventListener('click', function(e) {
        if (e.target.matches('[data-category]')) {
            e.preventDefault();
            
            // Remove active class from all buttons
            categoryNav.querySelectorAll('a').forEach(a => {
                a.classList.remove('active', 'btn-primary');
                a.classList.add('btn-light');
            });
            
            // Add active class to clicked button
            e.target.classList.remove('btn-light');
            e.target.classList.add('active', 'btn-primary');
            
            // Hide all course sections first
            courseSections.forEach(section => {
                section.style.display = 'none';
                section.classList.remove('active');
            });
            
            // Show selected course section with animation
            const targetCategory = e.target.getAttribute('data-category');
            const targetSection = document.getElementById(targetCategory);
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
.course-section {
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.course-section.active {
    display: block;
    opacity: 1;
}

.category-nav {
    margin-bottom: 2rem;
}

.category-nav .btn {
    margin: 0 0.5rem;
    min-width: 150px;
    transition: all 0.3s ease;
}

.category-nav .btn.active {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Ensure course sections are visible when active */
#lms.active,
#hr.active,
#finance.active,
#analytics.active {
    display: block !important;
    opacity: 1 !important;
}

/* Animation for section transitions */
.course-section {
    animation-duration: 0.3s;
    animation-fill-mode: both;
}

.course-section.active {
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

.course-item {
    transition: transform 0.3s ease;
}

.course-item:hover {
    transform: translateY(-5px);
}

/* Add styles for level badges */
.badge {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.course-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.course-item {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.course-item .position-relative {
    border-radius: 10px 10px 0 0;
}

/* Price styling */
.course-item h3 {
    font-weight: bold;
    color: #2124B1;
}

/* Add hover effect to buttons */
.btn-sm:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>

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