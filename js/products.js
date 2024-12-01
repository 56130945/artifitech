// Product Data
const productData = {
    edumanager: {
        name: "EduManager",
        overview: {
            title: "Next Generation Learning Management",
            description: "EduManager is a comprehensive learning management system designed specifically for South African educational institutions. Powered by AI and built for the future of education, it streamlines administrative tasks while enhancing the learning experience.",
            benefits: [
                { icon: "brain", title: "AI-Powered Learning", desc: "Personalized learning paths and recommendations" },
                { icon: "chart-line", title: "Analytics Dashboard", desc: "Real-time insights and performance tracking" },
                { icon: "users", title: "Collaborative Tools", desc: "Enhanced interaction between students and educators" },
                { icon: "shield-alt", title: "Enterprise Security", desc: "Advanced security and data protection" }
            ]
        },
        features: [
            { icon: "graduation-cap", title: "Smart Learning", desc: "AI-driven personalized learning paths" },
            { icon: "tasks", title: "Assignment Management", desc: "Automated grading and feedback" },
            { icon: "video", title: "Virtual Classrooms", desc: "Integrated video conferencing" },
            { icon: "chart-bar", title: "Analytics", desc: "Comprehensive reporting and insights" },
            { icon: "mobile-alt", title: "Mobile Learning", desc: "Learn anywhere, anytime" },
            { icon: "clock", title: "Time Management", desc: "Scheduling and calendar integration" }
        ],
        specs: [
            { label: "Deployment", value: "Cloud-based / On-premises" },
            { label: "Mobile Support", value: "iOS, Android, Web" },
            { label: "Integration", value: "REST API, LTI, SCORM" },
            { label: "Security", value: "ISO 27001, GDPR, POPIA Compliant" },
            { label: "Scalability", value: "Unlimited users and courses" },
            { label: "Updates", value: "Automatic weekly updates" }
        ],
        pricing: [
            {
                name: "Starter",
                price: "R499",
                period: "per user/month",
                features: [
                    "Up to 100 users",
                    "Basic LMS features",
                    "Email support",
                    "Mobile access",
                    "Basic reporting"
                ]
            },
            {
                name: "Professional",
                price: "R999",
                period: "per user/month",
                features: [
                    "Up to 1000 users",
                    "Advanced LMS features",
                    "24/7 support",
                    "API access",
                    "Advanced analytics"
                ]
            },
            {
                name: "Enterprise",
                price: "Custom",
                period: "contact us",
                features: [
                    "Unlimited users",
                    "Full feature set",
                    "Dedicated support",
                    "Custom integration",
                    "White labeling"
                ]
            }
        ]
    },
    ai: {
        name: "AI & IoT Solutions",
        overview: {
            title: "Intelligent Campus Management",
            description: "Transform your educational institution with cutting-edge AI and IoT solutions. Automate operations, enhance security, and create a smarter learning environment.",
            benefits: [
                { icon: "robot", title: "Smart Automation", desc: "Automated administrative tasks and workflows" },
                { icon: "network-wired", title: "IoT Integration", desc: "Connected devices and smart infrastructure" },
                { icon: "shield-alt", title: "Enhanced Security", desc: "AI-powered surveillance and access control" },
                { icon: "leaf", title: "Energy Efficiency", desc: "Smart resource management and optimization" }
            ]
        },
        features: [
            { icon: "brain", title: "AI Analytics", desc: "Predictive analytics and insights" },
            { icon: "camera", title: "Smart Surveillance", desc: "AI-powered security cameras" },
            { icon: "temperature-high", title: "Environmental Control", desc: "Smart HVAC management" },
            { icon: "door-open", title: "Access Control", desc: "Biometric and smart card access" },
            { icon: "lightbulb", title: "Smart Lighting", desc: "Automated lighting control" },
            { icon: "chart-pie", title: "Resource Management", desc: "Optimized resource allocation" }
        ],
        specs: [
            { label: "AI Models", value: "Deep Learning, Machine Learning" },
            { label: "IoT Protocols", value: "MQTT, CoAP, HTTP/2" },
            { label: "Connectivity", value: "Wi-Fi, LoRaWAN, 5G" },
            { label: "Processing", value: "Edge Computing, Cloud Processing" },
            { label: "Integration", value: "REST API, WebSocket" },
            { label: "Security", value: "End-to-end encryption" }
        ],
        pricing: [
            {
                name: "Basic",
                price: "R25,000",
                period: "per month",
                features: [
                    "Basic AI analytics",
                    "IoT sensor integration",
                    "Cloud dashboard",
                    "Email support",
                    "Monthly reports"
                ]
            },
            {
                name: "Advanced",
                price: "R50,000",
                period: "per month",
                features: [
                    "Advanced AI features",
                    "Full IoT integration",
                    "Real-time analytics",
                    "24/7 support",
                    "Custom reporting"
                ]
            },
            {
                name: "Enterprise",
                price: "Custom",
                period: "contact us",
                features: [
                    "Custom AI solutions",
                    "Full IoT ecosystem",
                    "Dedicated support",
                    "Custom integration",
                    "White labeling"
                ]
            }
        ]
    },
    xr: {
        name: "Extended Reality",
        overview: {
            title: "Immersive Learning Experience",
            description: "Revolutionary virtual and augmented reality solutions designed to transform traditional education into an immersive, interactive experience.",
            benefits: [
                { icon: "vr-cardboard", title: "Virtual Labs", desc: "Safe and cost-effective practical learning" },
                { icon: "cube", title: "3D Learning", desc: "Interactive 3D models and simulations" },
                { icon: "glasses", title: "AR Integration", desc: "Enhanced real-world learning" },
                { icon: "users", title: "Collaborative VR", desc: "Virtual group learning spaces" }
            ]
        },
        features: [
            { icon: "flask", title: "Virtual Labs", desc: "Simulated laboratory experiments" },
            { icon: "cube", title: "3D Models", desc: "Interactive learning objects" },
            { icon: "vr-cardboard", title: "VR Environments", desc: "Immersive learning spaces" },
            { icon: "glasses", title: "AR Overlay", desc: "Real-world augmentation" },
            { icon: "users", title: "Multi-user VR", desc: "Collaborative virtual spaces" },
            { icon: "mobile-alt", title: "Mobile AR", desc: "Portable AR experiences" }
        ],
        specs: [
            { label: "VR Support", value: "Oculus, HTC Vive, Windows MR" },
            { label: "AR Support", value: "iOS ARKit, Android ARCore" },
            { label: "3D Formats", value: "GLTF, FBX, OBJ, USD" },
            { label: "Platforms", value: "Windows, iOS, Android" },
            { label: "Multiplayer", value: "Up to 50 concurrent users" },
            { label: "Content Creation", value: "Built-in 3D tools" }
        ],
        pricing: [
            {
                name: "Starter",
                price: "R15,000",
                period: "per month",
                features: [
                    "Basic VR content",
                    "AR support",
                    "5 concurrent users",
                    "Email support",
                    "Standard content"
                ]
            },
            {
                name: "Professional",
                price: "R30,000",
                period: "per month",
                features: [
                    "Advanced VR/AR",
                    "20 concurrent users",
                    "Priority support",
                    "Custom content",
                    "Analytics"
                ]
            },
            {
                name: "Enterprise",
                price: "Custom",
                period: "contact us",
                features: [
                    "Full VR/AR suite",
                    "Unlimited users",
                    "24/7 support",
                    "Custom development",
                    "White labeling"
                ]
            }
        ]
    },
    cloud: {
        name: "Cloud Infrastructure",
        overview: {
            title: "Secure Cloud Solutions",
            description: "Enterprise-grade cloud infrastructure designed specifically for educational institutions, ensuring security, scalability, and reliability.",
            benefits: [
                { icon: "cloud", title: "Cloud Storage", desc: "Secure and scalable data storage" },
                { icon: "shield-alt", title: "Data Security", desc: "Advanced security protocols" },
                { icon: "sync", title: "Auto Scaling", desc: "Dynamic resource allocation" },
                { icon: "clock", title: "High Availability", desc: "99.9% uptime guarantee" }
            ]
        },
        features: [
            { icon: "database", title: "Data Storage", desc: "Scalable cloud storage" },
            { icon: "shield-alt", title: "Security", desc: "Enterprise-grade protection" },
            { icon: "sync", title: "Auto Scaling", desc: "Dynamic resource management" },
            { icon: "backup", title: "Backup", desc: "Automated backup solutions" },
            { icon: "network-wired", title: "CDN", desc: "Global content delivery" },
            { icon: "chart-line", title: "Monitoring", desc: "Real-time system monitoring" }
        ],
        specs: [
            { label: "Infrastructure", value: "Multi-cloud, Hybrid cloud" },
            { label: "Storage", value: "Block, Object, File storage" },
            { label: "Network", value: "Global CDN, Load balancing" },
            { label: "Security", value: "ISO 27001, POPIA compliant" },
            { label: "Backup", value: "Automated daily backups" },
            { label: "Support", value: "24/7 technical support" }
        ],
        pricing: [
            {
                name: "Basic",
                price: "R5,000",
                period: "per month",
                features: [
                    "100GB storage",
                    "Basic security",
                    "Daily backups",
                    "Email support",
                    "99.9% uptime"
                ]
            },
            {
                name: "Business",
                price: "R15,000",
                period: "per month",
                features: [
                    "1TB storage",
                    "Advanced security",
                    "Hourly backups",
                    "24/7 support",
                    "99.99% uptime"
                ]
            },
            {
                name: "Enterprise",
                price: "Custom",
                period: "contact us",
                features: [
                    "Custom storage",
                    "Custom security",
                    "Custom backup",
                    "Dedicated support",
                    "99.999% uptime"
                ]
            }
        ]
    }
};

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Product filtering
    const filterButtons = document.querySelectorAll('.product-nav-btn');
    const productItems = document.querySelectorAll('.product-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');

            const filter = button.getAttribute('data-filter');

            productItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = '';
                    // Add animation
                    item.classList.add('fadeIn');
                    setTimeout(() => item.classList.remove('fadeIn'), 500);
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Modal functionality
    const modal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
    const learnMoreButtons = document.querySelectorAll('.learn-more-btn');

    learnMoreButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-product');
            const product = productData[productId];

            // Update modal content based on product data
            updateModalContent(product);
            modal.show();
        });
    });
});

// Function to update modal content
function updateModalContent(product) {
    // Overview Tab
    const overviewContent = document.querySelector('#overview .product-content');
    overviewContent.innerHTML = `
        <h3>${product.overview.title}</h3>
        <p>${product.overview.description}</p>
        <div class="feature-list">
            ${product.overview.benefits.map(benefit => `
                <div class="feature-list-item">
                    <i class="fas fa-${benefit.icon}"></i>
                    <div>
                        <h5>${benefit.title}</h5>
                        <p>${benefit.desc}</p>
                    </div>
                </div>
            `).join('')}
        </div>
    `;

    // Features Tab
    const featuresContent = document.querySelector('#features .product-content');
    featuresContent.innerHTML = `
        <h3>Key Features</h3>
        <div class="feature-list">
            ${product.features.map(feature => `
                <div class="feature-list-item">
                    <i class="fas fa-${feature.icon}"></i>
                    <div>
                        <h5>${feature.title}</h5>
                        <p>${feature.desc}</p>
                    </div>
                </div>
            `).join('')}
        </div>
    `;

    // Tech Specs Tab
    const specsContent = document.querySelector('#specs .product-content');
    specsContent.innerHTML = `
        <h3>Technical Specifications</h3>
        <table class="specs-table">
            <tbody>
                ${product.specs.map(spec => `
                    <tr>
                        <td>${spec.label}</td>
                        <td>${spec.value}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;

    // Pricing Tab
    const pricingContent = document.querySelector('#pricing .product-content');
    pricingContent.innerHTML = `
        <h3>Pricing Plans</h3>
        <div class="pricing-grid">
            ${product.pricing.map(plan => `
                <div class="pricing-card">
                    <h4>${plan.name}</h4>
                    <div class="price">
                        ${plan.price}
                        <small>/${plan.period}</small>
                    </div>
                    <ul class="pricing-features list-unstyled">
                        ${plan.features.map(feature => `
                            <li><i class="fas fa-check"></i>${feature}</li>
                        `).join('')}
                    </ul>
                    <button class="btn btn-primary rounded-pill">Get Started</button>
                </div>
            `).join('')}
        </div>
    `;
} 