// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    // Search data structure
    const searchData = {
        pages: [
            {
                title: 'Home',
                url: 'index.html',
                content: 'Educational Technology Solutions Provider AI Solutions IoT Solutions Cloud Computing',
                category: 'Main'
            },
            {
                title: 'About Us',
                url: 'about.html',
                content: 'Learn about Artifitech and our mission to transform education through technology',
                category: 'Company'
            },
            {
                title: 'Services',
                url: 'service.html',
                content: 'EduManager LMS AI Tutor Smart Campus Virtual Labs Digital Library Educational software development AI tutoring systems IoT campus solutions',
                category: 'Services'
            },
            {
                title: 'Projects',
                url: 'project.html',
                content: 'View our portfolio of successful educational technology implementations',
                category: 'Portfolio'
            },
            {
                title: 'Contact',
                url: 'contact.html',
                content: 'Get in touch with us for your educational technology needs',
                category: 'Contact'
            }
        ],
        products: [
            {
                title: 'EduManager LMS',
                content: 'Comprehensive learning management system for modern education',
                category: 'Product',
                url: 'service.html#edumanager'
            },
            {
                title: 'AI Tutor',
                content: 'Artificial Intelligence powered tutoring system',
                category: 'Product',
                url: 'service.html#ai-tutor'
            },
            {
                title: 'Smart Campus',
                content: 'IoT-based campus management solution',
                category: 'Product',
                url: 'service.html#smart-campus'
            },
            {
                title: 'Virtual Labs',
                content: 'Interactive virtual laboratory simulations',
                category: 'Product',
                url: 'service.html#virtual-labs'
            },
            {
                title: 'Digital Library',
                content: 'Digital resource management system',
                category: 'Product',
                url: 'service.html#digital-library'
            }
        ]
    };

    // Get search elements
    const searchInput = document.querySelector('.search-input');
    const searchResults = document.querySelector('.search-results');
    const mobileSearchToggle = document.querySelector('.mobile-search-toggle');
    const searchWrapper = document.querySelector('.search-wrapper');

    if (!searchInput || !searchResults) return;

    // Search function
    function performSearch(query) {
        if (!query) {
            searchResults.classList.remove('show');
            return;
        }

        const results = [
            ...searchData.pages.filter(page => {
                const searchString = `${page.title} ${page.content} ${page.category}`.toLowerCase();
                return searchString.includes(query.toLowerCase());
            }),
            ...searchData.products.filter(product => {
                const searchString = `${product.title} ${product.content} ${product.category}`.toLowerCase();
                return searchString.includes(query.toLowerCase());
            })
        ];

        displayResults(results, query);
    }

    // Display results
    function displayResults(results, query) {
        if (results.length === 0) {
            searchResults.innerHTML = '<div class="no-results">No results found</div>';
        } else {
            searchResults.innerHTML = results.map(result => `
                <div class="search-result-item" onclick="window.location.href='${result.url}'">
                    <div class="search-result-title">${highlightText(result.title, query)}</div>
                    <div class="search-result-category">${result.category}</div>
                </div>
            `).join('');
        }
        searchResults.classList.add('show');
    }

    // Highlight matching text
    function highlightText(text, query) {
        if (!query) return text;
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<span class="search-highlight">$1</span>');
    }

    // Event listeners
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(this.value.trim());
        }, 300);
    });

    // Close search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchWrapper.contains(e.target)) {
            searchResults.classList.remove('show');
        }
    });

    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchResults.classList.remove('show');
            searchInput.blur();
        }
    });

    // Mobile search toggle
    if (mobileSearchToggle) {
        mobileSearchToggle.addEventListener('click', function() {
            searchWrapper.classList.toggle('show-mobile');
            searchInput.focus();
        });
    }
}); 