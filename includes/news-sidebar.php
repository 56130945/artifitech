<?php
// Sample data for popular posts
$popular_posts = [
    [
        'id' => 1,
        'title' => 'AI Integration in Education',
        'image' => '../img/news/ai-education-thumb.jpg',
        'date' => '15 Nov 2023'
    ],
    [
        'id' => 2,
        'title' => 'New Features in EduManager',
        'image' => '../img/news/edumanager-thumb.jpg',
        'date' => '10 Nov 2023'
    ]
];

// Sample data for categories
$categories = [
    ['name' => 'Product Updates', 'count' => 5],
    ['name' => 'Education Tech', 'count' => 8],
    ['name' => 'Company News', 'count' => 3],
    ['name' => 'Case Studies', 'count' => 4]
];
?>

<!-- Search Widget -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h4 class="text-primary mb-4">Search News</h4>
        <form action="news.php" method="get">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search news...">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Categories Widget -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h4 class="text-primary mb-4">Categories</h4>
        <div class="d-flex flex-column">
            <?php foreach ($categories as $category): ?>
            <a href="news.php?category=<?php echo urlencode($category['name']); ?>" class="h6 text-dark text-decoration-none py-2 px-3 mb-2 bg-light rounded">
                <?php echo $category['name']; ?>
                <span class="badge bg-primary float-end"><?php echo $category['count']; ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Popular Posts Widget -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h4 class="text-primary mb-4">Popular News</h4>
        <?php foreach ($popular_posts as $post): ?>
        <div class="d-flex mb-3 p-2 bg-light rounded">
            <img src="<?php echo $post['image']; ?>" class="flex-shrink-0 me-3 rounded" width="60" height="60" alt="<?php echo $post['title']; ?>">
            <div>
                <a href="news.php?id=<?php echo $post['id']; ?>" class="h6 text-dark text-decoration-none"><?php echo $post['title']; ?></a>
                <small class="d-block text-muted mt-1">
                    <i class="far fa-calendar-alt me-1"></i><?php echo $post['date']; ?>
                </small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
