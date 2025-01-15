document.addEventListener('DOMContentLoaded', function() {
    // Search data structure
    const searchData = {
        pages: [
            {
                title: 'Home',
                url: 'index.php',
                content: 'Educational Technology Solutions Provider AI Solutions IoT Solutions Cloud Computing',
                category: 'Main',
                keywords: ['education', 'technology', 'AI', 'IoT', 'cloud']
            },
            {
                title: 'About Us',
                url: 'about.php',
                content: 'Learn about Artifitech and our mission to transform education through technology',
                category: 'Company',
                keywords: ['company', 'mission', 'vision', 'team']
            },
            {
                title: 'Academy',
                url: 'academy.php',
                content: 'Professional development and certification programs',
                category: 'Education',
                keywords: ['training', 'certification', 'courses', 'learning']
            },
            {
                title: 'Contact',
                url: 'contact.php',
                content: 'Get in touch with us for your educational technology needs',
                category: 'Contact',
                keywords: ['contact', 'support', 'help', 'inquiry']
            }
        ],
        products: [
            {
                title: 'EduManager LMS',
                content: 'Comprehensive learning management system for modern education',
                category: 'Product',
                url: 'service.php#edumanager',
                keywords: ['LMS', 'education', 'management', 'learning']
            },
            {
                title: 'AI Tutor',
                content: 'Artificial Intelligence powered tutoring system',
                category: 'Product',
                url: 'service.php#ai-tutor',
                keywords: ['AI', 'tutor', 'learning', 'personalized']
            },
            {
                title: 'Smart Campus',
                content: 'IoT-based campus management solution',
                category: 'Product',
                url: 'service.php#smart-campus',
                keywords: ['IoT', 'campus', 'management', 'smart']
            }
        ]
    };

    // Get search elements
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.querySelector('.search-button');
    const searchWrapper = document.querySelector('.search-wrapper');

    // Create results container
    const searchResults = document.createElement('div');
    searchResults.className = 'search-results';
    document.body.appendChild(searchResults);

    // Create backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'search-backdrop';
    document.body.appendChild(backdrop);

    // Create results content wrapper
    const resultsContent = document.createElement('div');
    resultsContent.className = 'search-results-content';
    searchResults.appendChild(resultsContent);

    function showSearchModal() {
        backdrop.classList.add('show');
        searchResults.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function hideSearchModal() {
        backdrop.classList.remove('show');
        searchResults.classList.remove('show');
        document.body.style.overflow = '';
        searchInput.blur();
    }

    function performSearch(query) {
        if (!query.trim()) {
            hideSearchModal();
            return;
        }

        const results = [];
        const searchItems = [...searchData.pages, ...searchData.products];
        
        searchItems.forEach(item => {
            const searchString = `${item.title} ${item.content} ${item.keywords.join(' ')}`.toLowerCase();
            const queryWords = query.toLowerCase().split(' ');
            
            const matchesAllWords = queryWords.every(word => searchString.includes(word));
            
            if (matchesAllWords) {
                const score = calculateRelevanceScore(item, query);
                results.push({ ...item, score });
            }
        });

        results.sort((a, b) => b.score - a.score);
        
        displayResults(results, query);
        showSearchModal();
    }

    function calculateRelevanceScore(item, query) {
        const queryWords = query.toLowerCase().split(' ');
        let score = 0;

        queryWords.forEach(word => {
            if (item.title.toLowerCase().includes(word)) score += 10;
            if (item.keywords.some(k => k.toLowerCase().includes(word))) score += 5;
            if (item.content.toLowerCase().includes(word)) score += 3;
        });

        return score;
    }

    function displayResults(results, query) {
        if (results.length === 0) {
            resultsContent.innerHTML = '<div class="no-results">No results found</div>';
        } else {
            const resultsHtml = results.map(result => `
                <a href="${result.url}" class="search-result-item">
                    <div class="result-category">${result.category}</div>
                    <h4 class="result-title">${highlightText(result.title, query)}</h4>
                    <p class="result-content">${highlightText(truncateText(result.content, 100), query)}</p>
                    <div class="result-keywords">
                        ${result.keywords.map(keyword => 
                            `<span class="keyword-tag">${highlightText(keyword, query)}</span>`
                        ).join('')}
                    </div>
                </a>
            `).join('');

            resultsContent.innerHTML = resultsHtml;
        }
    }

    function highlightText(text, query) {
        const words = query.toLowerCase().split(' ');
        let highlightedText = text;
        
        words.forEach(word => {
            const regex = new RegExp(`(${word})`, 'gi');
            highlightedText = highlightedText.replace(regex, '<mark>$1</mark>');
        });
        
        return highlightedText;
    }

    function truncateText(text, maxLength) {
        if (text.length <= maxLength) return text;
        return text.substr(0, maxLength) + '...';
    }

    // Event Listeners
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        performSearch(query);
    });

    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            performSearch(query);
        } else if (e.key === 'Escape') {
            hideSearchModal();
        }
    });

    // Close modal when clicking backdrop
    backdrop.addEventListener('click', hideSearchModal);

    // Close modal when pressing Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSearchModal();
        }
    });

    // Prevent modal close when clicking inside results
    searchResults.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});