// Make functions globally available
window.openSearchModal = openSearchModal;
window.closeSearchModal = closeSearchModal;
window.showProductDetails = showProductDetails;
window.closeProductDetailsModal = closeProductDetailsModal;

// Sample product data - Replace with your actual products
const products = [
    {
        id: 1,
        name: "Web Development Services",
        category: "Development",
        price: "From $999",
        description: "Custom web development solutions tailored to your business needs. We create responsive, modern websites that drive results.",
        image: "img/service-1.jpg",
        features: [
            "Responsive Design",
            "SEO Optimization",
            "Modern Technologies",
            "Custom Solutions"
        ]
    },
    {
        id: 2,
        name: "Mobile App Development",
        category: "Development",
        price: "From $1499",
        description: "Native and cross-platform mobile applications that deliver exceptional user experiences across all devices.",
        image: "img/service-2.jpg",
        features: [
            "iOS & Android",
            "Cross-platform",
            "User-friendly Interface",
            "Performance Optimized"
        ]
    },
    {
        id: 3,
        name: "UI/UX Design Services",
        category: "Design",
        price: "From $799",
        description: "Creative and intuitive user interface designs that enhance user experience and drive engagement.",
        image: "img/service-3.jpg",
        features: [
            "User Research",
            "Wireframing",
            "Prototyping",
            "Visual Design"
        ]
    },
    {
        id: 4,
        name: "Digital Marketing",
        category: "Marketing",
        price: "From $599",
        description: "Comprehensive digital marketing strategies to boost your online presence and drive growth.",
        image: "img/service-4.jpg",
        features: [
            "SEO Services",
            "Social Media Marketing",
            "Content Strategy",
            "Analytics & Reporting"
        ]
    },
    {
        id: 5,
        name: "Cloud Solutions",
        category: "Infrastructure",
        price: "From $1299",
        description: "Scalable cloud infrastructure solutions to modernize your business operations and improve efficiency.",
        image: "img/service-5.jpg",
        features: [
            "Cloud Migration",
            "AWS/Azure Services",
            "24/7 Support",
            "Security Solutions"
        ]
    }
];

// Function to open search modal
function openSearchModal() {
    console.log('Opening search modal...');
    const modal = document.getElementById('searchModal');
    if (!modal) {
        console.error('Search modal not found');
        return;
    }
    
    renderProducts();
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

// Function to close search modal
function closeSearchModal() {
    const modal = document.getElementById('searchModal');
    if (!modal) return;
    
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

// Function to render products
function renderProducts() {
    console.log('Rendering products...');
    const productGrid = document.getElementById('productGrid');
    if (!productGrid) {
        console.error('Product grid not found');
        return;
    }

    productGrid.innerHTML = products.map(product => `
        <div class="product-card" data-product-id="${product.id}">
            <img src="${product.image}" alt="${product.name}" class="product-image">
            <div class="product-details">
                <div class="product-category">${product.category}</div>
                <h3 class="product-title">${product.name}</h3>
                <p class="product-description">${product.description}</p>
                <div class="product-price">
                    <span>${product.price}</span>
                    <button class="product-button">View Details</button>
                </div>
            </div>
        </div>
    `).join('');

    // Add click event listeners to product cards
    const productCards = productGrid.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', function() {
            const productId = parseInt(this.dataset.productId);
            showProductDetails(productId);
        });
    });
}

// Function to show product details
function showProductDetails(productId) {
    const product = products.find(p => p.id === productId);
    const modal = document.getElementById('productDetailsModal');
    const detailsBody = document.getElementById('productDetailsBody');
    
    if (!product || !modal || !detailsBody) return;
    
    detailsBody.innerHTML = `
        <div class="product-details-image">
            <img src="${product.image}" alt="${product.name}">
        </div>
        <div class="product-details-info">
            <div class="product-details-category">${product.category}</div>
            <h2 class="product-details-title">${product.name}</h2>
            <p class="product-details-description">${product.description}</p>
            <div class="product-details-price">${product.price}</div>
            <div class="product-details-features">
                <h4>Key Features:</h4>
                ${product.features.map(feature => `
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>${feature}</span>
                    </div>
                `).join('')}
            </div>
            <button class="product-button" style="margin-top: 20px;">Get Started</button>
        </div>
    `;
    
    modal.classList.add('show');
}

// Function to close product details modal
function closeProductDetailsModal() {
    const modal = document.getElementById('productDetailsModal');
    if (!modal) return;
    
    modal.classList.remove('show');
}

// Initialize modals when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing search modal...');
    
    // Create and append search modal HTML
    document.body.insertAdjacentHTML('beforeend', `
        <div class="search-modal" id="searchModal">
            <div class="search-modal-content">
                <div class="search-modal-header">
                    <h3 class="search-modal-title">Our Products & Services</h3>
                    <button class="search-modal-close" id="closeSearchBtn">&times;</button>
                </div>
                <div class="search-modal-body">
                    <div class="product-grid" id="productGrid"></div>
                </div>
            </div>
        </div>

        <div class="product-details-modal" id="productDetailsModal">
            <div class="product-details-content">
                <div class="product-details-header">
                    <h3 class="search-modal-title">Product Details</h3>
                    <button class="search-modal-close" id="closeDetailsBtn">&times;</button>
                </div>
                <div class="product-details-body" id="productDetailsBody">
                </div>
            </div>
        </div>
    `);

    // Add event listeners
    const searchButton = document.querySelector('.btn-search');
    const closeSearchBtn = document.getElementById('closeSearchBtn');
    const closeDetailsBtn = document.getElementById('closeDetailsBtn');
    const searchModal = document.getElementById('searchModal');
    const productDetailsModal = document.getElementById('productDetailsModal');

    console.log('Search button found:', !!searchButton);

    if (searchButton) {
        searchButton.addEventListener('click', function() {
            console.log('Search button clicked');
            openSearchModal();
        });
    }

    if (closeSearchBtn) {
        closeSearchBtn.addEventListener('click', closeSearchModal);
    }

    if (closeDetailsBtn) {
        closeDetailsBtn.addEventListener('click', closeProductDetailsModal);
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === searchModal) {
            closeSearchModal();
        }
        if (event.target === productDetailsModal) {
            closeProductDetailsModal();
        }
    });
}); 