document.addEventListener('DOMContentLoaded', function() {
    // Get all news content collapse elements
    const newsCollapses = document.querySelectorAll('.news-content');
    
    // Add event listeners for each collapse
    newsCollapses.forEach(collapse => {
        collapse.addEventListener('show.bs.collapse', function() {
            // Smooth scroll to the expanded content
            setTimeout(() => {
                this.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 350);
        });
    });

    // Optional: Add animation to the content when expanded
    const observers = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeIn');
            }
        });
    });

    document.querySelectorAll('.news-content').forEach((item) => {
        observers.observe(item);
    });
});
