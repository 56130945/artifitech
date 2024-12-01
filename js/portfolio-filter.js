// Portfolio Filter System
document.addEventListener('DOMContentLoaded', function() {
    const portfolioContainer = document.querySelector('.portfolio-container');
    const filterButtons = document.querySelectorAll('.filter-button');
    const sortSelect = document.querySelector('.sort-select');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    // Initialize Isotope
    const iso = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item',
        layoutMode: 'fitRows',
        transitionDuration: '0.4s'
    });

    // Filter items on button click
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterValue = this.getAttribute('data-filter');
            
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter items
            if (filterValue === '*') {
                iso.arrange({ filter: '*' });
            } else {
                iso.arrange({ filter: `.${filterValue}` });
            }
        });
    });

    // Sort items
    sortSelect?.addEventListener('change', function() {
        const sortValue = this.value;
        let sortBy;

        switch(sortValue) {
            case 'date-desc':
                sortBy = (itemElem) => -parseInt(itemElem.getAttribute('data-date'));
                break;
            case 'date-asc':
                sortBy = (itemElem) => parseInt(itemElem.getAttribute('data-date'));
                break;
            case 'name-asc':
                sortBy = (itemElem) => itemElem.getAttribute('data-name');
                break;
            case 'name-desc':
                sortBy = (itemElem) => -itemElem.getAttribute('data-name');
                break;
        }

        iso.arrange({
            sortBy: sortBy
        });
    });

    // Update layout after images are loaded
    imagesLoaded(portfolioContainer, function() {
        iso.layout();
    });

    // Add hover effect
    portfolioItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.classList.add('hover');
        });

        item.addEventListener('mouseleave', function() {
            this.classList.remove('hover');
        });
    });

    // Filter by URL parameter if present
    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get('filter');
    if (filterParam) {
        const targetButton = document.querySelector(`[data-filter="${filterParam}"]`);
        if (targetButton) {
            targetButton.click();
        }
    }
}); 