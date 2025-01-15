<?php
// Get article data based on ID
$articles = [
    1 => [
        'title' => 'AI Integration in Education',
        'content' => '<p>Discover how our AI solutions are revolutionizing the education sector. Our cutting-edge technology is transforming the way students learn and educators teach.</p>
                     <p>Through advanced machine learning algorithms and natural language processing, we\'re creating personalized learning experiences that adapt to each student\'s needs and pace.</p>
                     <h3>Key Features:</h3>
                     <ul>
                         <li>Personalized Learning Paths</li>
                         <li>Real-time Performance Analytics</li>
                         <li>AI-powered Assessment Tools</li>
                         <li>Smart Content Recommendations</li>
                     </ul>',
        'image' => '../img/news/ai-education.jpg',
        'date' => '15 Nov 2023',
        'author' => 'John Smith',
        'comments' => 5
    ],
    2 => [
        'title' => 'New Features in EduManager',
        'content' => '<p>We\'re excited to announce the latest updates to our flagship LMS platform, EduManager. These new features are designed to enhance user experience and streamline educational workflows.</p>
                     <p>Based on user feedback and industry trends, we\'ve implemented several highly requested features that will make managing your educational institution even easier.</p>
                     <h3>New Features Include:</h3>
                     <ul>
                         <li>Advanced Analytics Dashboard</li>
                         <li>Integrated Video Conferencing</li>
                         <li>Automated Assessment Grading</li>
                         <li>Mobile-First Interface</li>
                     </ul>',
        'image' => '../img/news/edumanager-update.jpg',
        'date' => '10 Nov 2023',
        'author' => 'Sarah Johnson',
        'comments' => 3
    ]
];

$article = isset($articles[$article_id]) ? $articles[$article_id] : null;

if ($article): ?>
    <div class="news-single">
        <img src="<?php echo $article['image']; ?>" class="img-fluid rounded mb-4" alt="<?php echo $article['title']; ?>">
        <div class="mb-4">
            <span class="badge bg-primary">
                <i class="far fa-calendar-alt me-2"></i><?php echo $article['date']; ?>
            </span>
        </div>
        <h1 class="mb-4"><?php echo $article['title']; ?></h1>
        <div class="d-flex align-items-center mb-4">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <h6 class="mb-0"><?php echo $article['author']; ?></h6>
                <small class="text-muted">Author</small>
            </div>
        </div>
        <div class="content mb-5">
            <?php echo $article['content']; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        Article not found.
    </div>
<?php endif; ?>
