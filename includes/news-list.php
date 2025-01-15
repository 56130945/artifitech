<?php
// Get all news articles
$articles = [
    [
        'id' => 1,
        'title' => 'AI Integration in Education',
        'excerpt' => 'Discover how our AI solutions are revolutionizing the education sector...',
        'image' => '../img/news/ai-education.jpg',
        'date' => '15 Nov 2023',
        'author' => 'John Smith',
        'comments' => 5
    ],
    [
        'id' => 2,
        'title' => 'New Features in EduManager',
        'excerpt' => 'Explore the latest features added to our flagship LMS platform...',
        'image' => '../img/news/edumanager-update.jpg',
        'date' => '10 Nov 2023',
        'author' => 'Sarah Johnson',
        'comments' => 3
    ]
];

// Display articles
foreach ($articles as $article): ?>
    <div class="card mb-4 border-0 shadow-sm">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?php echo $article['image']; ?>" class="img-fluid rounded-start" alt="<?php echo $article['title']; ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <span class="badge bg-primary mb-2">
                        <i class="far fa-calendar-alt me-2"></i><?php echo $article['date']; ?>
                    </span>
                    <h2 class="card-title h4 mb-3">
                        <a href="news.php?id=<?php echo $article['id']; ?>" class="text-dark text-decoration-none hover-primary">
                            <?php echo $article['title']; ?>
                        </a>
                    </h2>
                    <p class="card-text"><?php echo $article['excerpt']; ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="text-muted small"><?php echo $article['author']; ?></span>
                        </div>
                        <a href="news.php?id=<?php echo $article['id']; ?>" class="btn btn-primary btn-sm">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
