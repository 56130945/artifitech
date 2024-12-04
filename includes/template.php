<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo $keywords; ?>" name="keywords">
    <meta content="<?php echo $description; ?>" name="description">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="<?php echo $og_title; ?>">
    <meta property="og:description" content="<?php echo $og_description; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $og_url; ?>">
    <meta property="og:image" content="<?php echo $base_url; ?>/img/og-image.jpg">

    <!-- Favicon -->
    <link href="<?php echo $base_url; ?>/img/favicon.ico" rel="icon">
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="<?php echo $base_url; ?>/css/bootstrap.min.css" as="style">
    <link rel="preload" href="<?php echo $base_url; ?>/css/style.css" as="style">
    <link rel="preload" href="<?php echo $base_url; ?>/js/main.js" as="script">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Exo+2:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo $base_url; ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo $base_url; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/header.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/dark-mode.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/back-to-top.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/form-validation.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/search.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/auth-buttons.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/auth-modals.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/styles/theme.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/css/black-friday-modal.css" rel="stylesheet">

    <!-- Additional CSS -->
    <?php if(isset($additional_css)) echo $additional_css; ?>

    <!-- Performance Optimizations -->
    <script>
        // Add support for native lazy loading
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        } else {
            // Fallback for browsers that don't support lazy loading
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lozad.js/1.16.0/lozad.min.js';
            document.head.appendChild(script);
        }
    </script>

    <!-- Add these in the <head> section -->
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/auth.css">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border position-relative text-primary" style="width: 6rem; height: 6rem;" role="status"></div>
        <i class="fas fa-robot fa-2x" style="color: #7FB3D5; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid bg-light px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Career</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Terms</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Privacy</a></li>
                </ol>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <div class="h-100 d-inline-flex align-items-center">
                    <div class="btn-group">
                        <div class="form-check form-switch ms-3">
                            <input class="form-check-input" type="checkbox" id="darkModeToggle">
                            <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <?php include 'includes/header.php'; ?>

    <?php echo $content; ?>

    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script>
    // Counter-Up Plugin
    (function($){"use strict";$.fn.counterUp=function(options){var settings=$.extend({time:400,delay:10,offset:100,beginAt:0,formatter:false,context:"window",callback:function(){}},options),s;return this.each(function(){var $this=$(this),counter={time:$(this).data("counterup-time")||settings.time,delay:$(this).data("counterup-delay")||settings.delay,offset:$(this).data("counterup-offset")||settings.offset,beginAt:$(this).data("counterup-beginat")||settings.beginAt,context:$(this).data("counterup-context")||settings.context};var counterUpper=function(){var nums=[],divisions=counter.time/counter.delay,num=$(this).attr("data-num")?$(this).attr("data-num"):$this.text(),isComma=/[0-9]+,[0-9]+/.test(num),isFloat=/^[0-9]+\.[0-9]+$/.test(num),decimalPlaces=isFloat?(num.split(".")[1]||[]).length:0;num=num.replace(/,/g,"");for(var i=divisions;i>=1;i--){var newNum=parseInt(num/divisions*i);if(isFloat){newNum=parseFloat(num/divisions*i).toFixed(decimalPlaces)}if(isComma)while(/(\d+)(\d{3})/.test(newNum.toString()))newNum=newNum.toString().replace(/(\d+)(\d{3})/,"$1,$2");nums.unshift(newNum)}$this.data("counterup-nums",nums);$this.text(counter.beginAt);var f=function(){if(!$this.data("counterup-nums")){settings.callback.call(this);return}$this.html($this.data("counterup-nums").shift());if($this.data("counterup-nums").length){setTimeout($this.data("counterup-func"),counter.delay)}else{$this.data("counterup-nums",null);$this.data("counterup-func",null);settings.callback.call(this)}};$this.data("counterup-func",f);setTimeout($this.data("counterup-func"),counter.delay)};$this.waypoint(function(direction){counterUpper();this.destroy()},{offset:counter.offset+"%",context:counter.context})})}})(jQuery);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="<?php echo $base_url; ?>/js/main.js"></script>
    
    <!-- Additional JavaScript -->
    <?php if(isset($additional_js)) echo $additional_js; ?>

    <script>
        // Initialize WOW.js
        new WOW().init();
        
        // Initialize other plugins
        $(document).ready(function() {
            // Counter Up
            $('.counter').counterUp({
                delay: 10,
                time: 2000,
                offset: 70
            });
            
            // Owl Carousel
            $(".owl-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                margin: 25,
                loop: true,
                center: true,
                dots: false,
                nav: true,
                navText: [
                    '<i class="bi bi-chevron-left"></i>',
                    '<i class="bi bi-chevron-right"></i>'
                ],
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    768: { items: 3 },
                    992: { items: 4 }
                }
            });
            
            // Isotope
            $('.portfolio-container').isotope({
                itemSelector: '.portfolio-item',
                layoutMode: 'fitRows'
            });
            
            // Lightbox
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            });
        });
    </script>
</body>

</html> 