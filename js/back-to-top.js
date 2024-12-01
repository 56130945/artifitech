// Back to top button functionality
document.addEventListener('DOMContentLoaded', function() {
    // Create the button element
    const button = document.createElement('button');
    button.className = 'back-to-top';
    button.setAttribute('aria-label', 'Back to top');
    button.innerHTML = '<i class="bi bi-arrow-up-short"></i>';
    document.body.appendChild(button);

    // Show/hide button based on scroll position with throttling
    let isScrolling = false;
    window.addEventListener('scroll', function() {
        if (!isScrolling) {
            window.requestAnimationFrame(function() {
                if (window.pageYOffset > 200) {
                    button.classList.add('show');
                } else {
                    button.classList.remove('show');
                }
                isScrolling = false;
            });
            isScrolling = true;
        }
    });

    // Smooth scroll to top when clicked
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get the current scroll position
        const startPosition = window.pageYOffset;
        const startTime = performance.now();
        
        // Smooth scroll animation
        function scrollToTop(currentTime) {
            const timeElapsed = currentTime - startTime;
            const progress = Math.min(timeElapsed / 800, 1); // 800ms duration
            
            // Easing function for smooth animation
            const easeInOutQuad = t => t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            
            window.scrollTo(0, startPosition * (1 - easeInOutQuad(progress)));
            
            if (progress < 1) {
                requestAnimationFrame(scrollToTop);
            }
        }
        
        requestAnimationFrame(scrollToTop);
    });
}); 