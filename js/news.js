// Sample news data - In production, this would come from your backend
const newsArticles = {
    'ai-integration': {
        title: 'AI Integration in Education',
        date: '15 Nov 2023',
        category: 'Technology',
        image: 'img/index/news-1.jpg.png',
        content: `
            <p class="lead">Artificial Intelligence is revolutionizing the education sector, and Artifitech is at the forefront of this transformation.</p>
            
            <p>Our AI-powered solutions are helping educational institutions streamline their operations and improve learning outcomes. Through machine learning algorithms and data analytics, we're able to provide personalized learning experiences for students while giving educators powerful tools to track and enhance student performance.</p>

            <h4>Key Benefits of AI in Education:</h4>
            <ul>
                <li>Personalized Learning Paths</li>
                <li>Automated Administrative Tasks</li>
                <li>Real-time Performance Analytics</li>
                <li>Intelligent Content Recommendations</li>
                <li>Predictive Student Success Metrics</li>
            </ul>

            <p>The integration of AI in our EduManager platform has shown remarkable results, with institutions reporting:</p>
            <ul>
                <li>25% improvement in student engagement</li>
                <li>30% reduction in administrative workload</li>
                <li>40% better prediction of student performance</li>
            </ul>

            <blockquote class="bg-light p-4 my-4">
                <p class="mb-0">"The AI features in EduManager have transformed how we approach education. It's like having a digital assistant that understands each student's needs."</p>
                <footer class="mt-2">- Dr. Sarah Johnson, Education Director</footer>
            </blockquote>
        `,
        related: ['edumanager-features', 'cloud-computing']
    },
    'edumanager-features': {
        title: 'New Features in EduManager',
        date: '10 Nov 2023',
        category: 'Product Update',
        image: 'img/index/news-1.jpg.png',
        content: `
            <p class="lead">We're excited to announce the latest features added to our flagship LMS platform, EduManager.</p>
            
            <p>This update brings several highly-requested features that will enhance both the teaching and learning experience. Our development team has focused on creating tools that make education more interactive, engaging, and effective.</p>

            <h4>New Features Include:</h4>
            <ul>
                <li>Interactive Virtual Classrooms</li>
                <li>Advanced Analytics Dashboard</li>
                <li>Mobile Learning Apps</li>
                <li>Integrated Assessment Tools</li>
            </ul>
        `,
        related: ['ai-integration', 'cloud-computing']
    }
};

// Function to open news modal with content
function openNewsModal(articleId) {
    const article = newsArticles[articleId];
    if (!article) return;

    // Update modal content
    document.getElementById('modalNewsImage').src = article.image;
    document.getElementById('modalNewsDate').textContent = article.date;
    document.getElementById('modalNewsCategory').textContent = article.category;
    document.getElementById('modalNewsTitle').textContent = article.title;
    document.getElementById('modalNewsContent').innerHTML = article.content;

    // Load related articles
    const relatedArticlesContainer = document.getElementById('relatedArticles');
    relatedArticlesContainer.innerHTML = '';

    if (article.related) {
        article.related.forEach(relatedId => {
            const related = newsArticles[relatedId];
            if (related) {
                const articleHTML = `
                    <div class="col-md-6">
                        <div class="card h-100">
                            <img src="${related.image}" class="card-img-top" alt="${related.title}">
                            <div class="card-body">
                                <div class="small text-primary mb-1">${related.date}</div>
                                <h5 class="card-title">${related.title}</h5>
                                <a href="#" onclick="openNewsModal('${relatedId}'); return false;" class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                `;
                relatedArticlesContainer.innerHTML += articleHTML;
            }
        });
    }

    // Initialize and show modal using Bootstrap
    const newsModal = document.getElementById('newsModal');
    if (!newsModal.classList.contains('show')) {
        const bsModal = new bootstrap.Modal(newsModal);
        bsModal.show();
    }
}

// Social sharing functionality
function shareNews(platform) {
    const title = document.getElementById('modalNewsTitle').textContent;
    const url = window.location.href;
    
    const shareUrls = {
        twitter: `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`,
        facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
        linkedin: `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`,
        whatsapp: `https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + url)}`
    };

    window.open(shareUrls[platform], '_blank', 'width=600,height=400');
}

// Initialize modals when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Make sure Bootstrap is available
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap is not loaded. Please make sure you have included Bootstrap JS.');
        return;
    }
});
