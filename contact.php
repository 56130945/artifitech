<?php
// Include global configuration
require_once 'includes/config.php';

// Set page-specific variables
$page = 'contact';
$title = "Artifitech - Contact Us | Educational Technology Solutions";
$keywords = "Contact Artifitech, Support, Sales Inquiry, Technical Support, Educational Technology";
$description = "Get in touch with Artifitech for all your educational technology needs. Contact our team for support, sales inquiries, or partnership opportunities.";
$og_title = "Contact Artifitech - Educational Technology Solutions";
$og_description = "Reach out to our team for educational technology solutions";
$og_url = "https://artifitech.com/contact";

// Add Black Friday Modal CSS with correct path
$additional_css = '<link rel="stylesheet" href="' . $base_url . '/css/black-friday-modal.css">';

// Add Black Friday Modal JS with correct path
$additional_js = '<script src="' . $base_url . '/js/black-friday-modal.js"></script>';

// Start output buffering
ob_start();
?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-3">Contact</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">Contact Us</h6>
                <h1 class="display-6 mb-4">Let's Connect</h1>
            </div>

            <!-- Contact Info Cards -->
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded text-center h-100 p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                            <i class="fa fa-map-marker-alt text-primary fs-4"></i>
                        </div>
                        <h4 class="mb-3">Visit Us</h4>
                        <p class="m-0">123 Innovation Hub<br>Tech District<br>Johannesburg, South Africa</p>
                        <a href="#map" class="btn btn-primary rounded-pill mt-4">
                            <i class="fa fa-directions me-2"></i>Get Directions
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded text-center h-100 p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                            <i class="fa fa-phone-alt text-primary fs-4"></i>
                        </div>
                        <h4 class="mb-3">Call Us</h4>
                        <p class="m-0">Support: +27 123 456 789<br>Sales: +27 987 654 321</p>
                        <a href="tel:+27123456789" class="btn btn-primary rounded-pill mt-4">
                            <i class="fa fa-phone me-2"></i>Call Now
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="feature-item bg-light rounded text-center h-100 p-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
                            <i class="fa fa-envelope text-primary fs-4"></i>
                        </div>
                        <h4 class="mb-3">Email Us</h4>
                        <p class="m-0">Support: support@artifitech.co.za<br>Sales: sales@artifitech.co.za</p>
                        <a href="mailto:info@artifitech.co.za" class="btn btn-primary rounded-pill mt-4">
                            <i class="fa fa-envelope me-2"></i>Send Email
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-light rounded h-100 p-5">
                        <h4 class="mb-4">Send Us a Message</h4>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="name" placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-0" id="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select border-0" id="subject">
                                            <option value="">Select a topic</option>
                                            <option value="general">General Inquiry</option>
                                            <option value="support">Technical Support</option>
                                            <option value="sales">Sales</option>
                                            <option value="partnership">Partnership</option>
                                        </select>
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-0" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">
                                        <i class="fa fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-light rounded h-100 p-5">
                        <h4 class="mb-4">Why Choose Us</h4>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="d-flex align-items-start">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3" style="width: 45px; height: 45px;">
                                        <i class="fa fa-headset text-white fa-lg pt-3"></i>
                                    </div>
                                    <div>
                                        <h5>24/7 Support</h5>
                                        <p class="mb-0">Our dedicated support team is available around the clock to assist you with any queries.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3" style="width: 45px; height: 45px;">
                                        <i class="fa fa-comments text-white fa-lg pt-3"></i>
                                    </div>
                                    <div>
                                        <h5>Live Chat</h5>
                                        <p class="mb-0">Connect with us instantly through our live chat support for immediate assistance.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start">
                                    <div class="btn-sm-square bg-primary rounded-circle me-3" style="width: 45px; height: 45px;">
                                        <i class="fa fa-video text-white fa-lg pt-3"></i>
                                    </div>
                                    <div>
                                        <h5>Video Consultation</h5>
                                        <p class="mb-0">Schedule a video call with our experts for personalized solutions and demos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="mb-4">Connect With Us</h5>
                            <div class="d-flex pt-2">
                                <a class="btn btn-square btn-primary rounded-circle me-2" href="">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a class="btn btn-square btn-primary rounded-circle me-2" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="btn btn-square btn-primary rounded-circle me-2" href="">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a class="btn btn-square btn-primary rounded-circle me-2" href="">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Google Map Start -->
    <div id="map" class="container-xxl py-5 px-0 wow fadeIn" data-wow-delay="0.1s">
        <iframe class="w-100 mb-n2" 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
            style="height: 450px; border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
        </iframe>
    </div>
    <!-- Google Map End -->

<style>
.feature-item {
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.form-control {
    border: 1px solid #ced4da;
    padding: 0.75rem;
}

.form-control:focus {
    box-shadow: none;
    border-color: #2124B1;
}

.btn-square {
    width: 38px;
    height: 38px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: normal;
}

.btn-square:hover {
    transform: translateY(-2px);
}
</style>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 