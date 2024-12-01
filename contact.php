<?php
$page = 'contact';

// Meta information
$title = "Artifitech - Contact Us | Leading Educational Technology Solutions Provider";
$keywords = "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing";
$description = "Contact Artifitech - South Africa's leading provider of educational technology solutions. Get in touch with us for your educational technology needs.";
$og_title = "Contact Artifitech - Leading Educational Technology Solutions";
$og_description = "Get in touch with South Africa's leading provider of educational technology solutions";
$og_url = "https://artifitech.com/contact";

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
                <p class="text-muted">Reach out to us for any questions about our educational technology solutions. We're here to help transform your learning experience.</p>
            </div>

            <!-- Contact Info Cards -->
            <div class="row g-4 mb-5">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Visit Us</h4>
                        <p>123 Innovation Hub, Tech District<br>Johannesburg, South Africa</p>
                        <a href="#" class="direction-link">
                            <i class="fas fa-directions"></i> Get Directions
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Call Us</h4>
                        <p class="mb-2">Support: +27 123 456 789</p>
                        <p>Sales: +27 987 654 321</p>
                        <a href="tel:+27123456789" class="direction-link">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <p class="mb-2">Support: support@artifitech.co.za</p>
                        <p>Sales: sales@artifitech.co.za</p>
                        <a href="mailto:info@artifitech.co.za" class="direction-link">
                            <i class="fas fa-envelope"></i> Send Email
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="row g-5 justify-content-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="contact-form-card">
                        <h3 class="mb-4">Send Us a Message</h3>
                        <form id="contactForm" class="contact-form">
                            <div class="form-group mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="Your Name">
                                    <label for="name"><i class="fas fa-user"></i> Your Name</label>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Your Email">
                                    <label for="email"><i class="fas fa-envelope"></i> Your Email</label>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="form-floating">
                                    <select class="form-control" id="subject">
                                        <option value="">Select a topic</option>
                                        <option value="general">General Inquiry</option>
                                        <option value="support">Technical Support</option>
                                        <option value="sales">Sales</option>
                                        <option value="partnership">Partnership</option>
                                    </select>
                                    <label for="subject"><i class="fas fa-tag"></i> Subject</label>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                    <label for="message"><i class="fas fa-comment"></i> Message</label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg rounded-pill px-5" type="submit">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Contact Features -->
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="contact-features">
                        <div class="contact-feature-card mb-4">
                            <div class="feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="feature-content">
                                <h5>24/7 Support</h5>
                                <p>Our dedicated support team is available around the clock to assist you with any queries.</p>
                            </div>
                        </div>
                        <div class="contact-feature-card mb-4">
                            <div class="feature-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="feature-content">
                                <h5>Live Chat</h5>
                                <p>Connect with us instantly through our live chat support for immediate assistance.</p>
                            </div>
                        </div>
                        <div class="contact-feature-card mb-4">
                            <div class="feature-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="feature-content">
                                <h5>Video Consultation</h5>
                                <p>Schedule a video call with our experts for personalized solutions and demos.</p>
                            </div>
                        </div>
                        <div class="contact-social">
                            <h5>Connect With Us</h5>
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Google Map Start -->
    <div class="container-xxl pt-5 px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="map-container">
            <iframe class="w-100"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                style="height: 450px; border: 0;" allowfullscreen="" aria-hidden="false" tabindex="0">
            </iframe>
            <div class="map-overlay">
                <div class="overlay-content">
                    <h4>Visit Our Office</h4>
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Innovation Hub, Tech District, Johannesburg</p>
                    <button class="btn btn-primary rounded-pill">
                        <i class="fas fa-directions me-2"></i>Get Directions
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map End -->

<?php
$content = ob_get_clean();
include 'includes/template.php';
?> 