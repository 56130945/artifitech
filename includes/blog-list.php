<?php
// In a real application, you would fetch this from a database
$articles = [
    [
        'id' => 1,
        'title' => 'AI Integration in Education',
        'date' => '15 Nov 2023',
        'author' => 'Dr. Sarah Johnson',
        'category' => 'Technology',
        'image' => 'img/index/news-1.jpg.png',
        'excerpt' => 'Discover how our AI solutions are revolutionizing the education sector with personalized learning paths and automated administrative tasks.',
        'comments_count' => 5
    ],
    [
        'id' => 2,
        'title' => 'New Features in EduManager',
        'date' => '10 Nov 2023',
        'author' => 'Prof. Michael Chen',
        'category' => 'Product Update',
        'image' => 'img/index/news-1.jpg.png',
        'excerpt' => 'Explore the latest features added to our flagship LMS platform, including interactive virtual classrooms and advanced analytics.',
        'comments_count' => 3
    ]
];
?>

<!-- Blog Posts -->
<div class="blog-posts">
    <?php foreach ($articles as $article): ?>
    <div class="card border-0 shadow-sm hover-shadow mb-4 overflow-hidden">
        <div class="position-relative">
            <img src="<?php echo $article['image']; ?>" class="card-img-top" alt="<?php echo $article['title']; ?>">
            <div class="position-absolute top-0 start-0 p-3">
                <span class="badge bg-primary"><?php echo $article['category']; ?></span>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="d-flex justify-content-between mb-3">
                <span class="text-primary">
                    <i class="far fa-calendar-alt me-2"></i><?php echo $article['date']; ?>
                </span>
                <span class="text-muted">
                    <i class="far fa-comment me-2"></i><?php echo $article['comments_count']; ?> Comments
                </span>
            </div>
            <h2 class="card-title h4 mb-3">
                <a href="blog.php?id=<?php echo $article['id']; ?>" class="text-dark text-decoration-none hover-primary">
                    <?php echo $article['title']; ?>
                </a>
            </h2>
            <p class="card-text text-muted"><?php echo $article['excerpt']; ?></p>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="author d-flex align-items-center">
                    <div class="author-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                        <i class="far fa-user"></i>
                    </div>
                    <span class="text-muted small"><?php echo $article['author']; ?></span>
                </div>
                <a href="blog.php?id=<?php echo $article['id']; ?>" class="btn btn-primary btn-sm">
                    Read More <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Pagination -->
    <nav aria-label="Blog navigation" class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
