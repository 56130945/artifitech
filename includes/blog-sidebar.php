<?php
// Sample data - In a real application, this would come from a database
$categories = [
    ['name' => 'Technology', 'count' => 12],
    ['name' => 'Product Updates', 'count' => 8],
    ['name' => 'Education', 'count' => 15],
    ['name' => 'Company News', 'count' => 6]
];

$popular_posts = [
    [
        'title' => 'AI Integration in Education',
        'date' => '15 Nov 2023',
        'image' => 'img/index/news-1.jpg.png'
    ],
    [
        'title' => 'New Features in EduManager',
        'date' => '10 Nov 2023',
        'image' => 'img/index/news-1.jpg.png'
    ]
];

$tags = ['AI', 'Education', 'Technology', 'EduManager', 'Updates', 'Features', 'Learning', 'Innovation'];
?>

<!-- Search Widget -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h4 class="text-primary mb-4">Search</h4>
        <form action="blog.php" method="get">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search posts...">
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
        <ul class="list-unstyled categories-list mb-0">
            <?php foreach ($categories as $category): ?>
            <li class="d-flex justify-content-between align-items-center p-2 border-bottom">
                <a href="#" class="text-dark text-decoration-none hover-primary">
                    <i class="fas fa-folder me-2 text-primary"></i>
                    <?php echo $category['name']; ?>
                </a>
                <span class="badge bg-primary rounded-pill"><?php echo $category['count']; ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- Popular Posts Widget -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h4 class="text-primary mb-4">Popular Posts</h4>
        <?php foreach ($popular_posts as $post): ?>
        <div class="d-flex mb-3 p-2 bg-light rounded">
            <img src="<?php echo $post['image']; ?>" class="flex-shrink-0 me-3 rounded" width="60" height="60" alt="<?php echo $post['title']; ?>">
            <div>
                <h6 class="mb-1">
                    <a href="#" class="text-dark text-decoration-none hover-primary">
                        <?php echo $post['title']; ?>
                    </a>
                </h6>
                <small class="text-primary">
                    <i class="far fa-calendar-alt me-1"></i><?php echo $post['date']; ?>
                </small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Tags Widget -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="text-primary mb-4">Tags</h4>
        <div class="tags">
            <?php foreach ($tags as $tag): ?>
            <a href="#" class="btn btn-light btn-sm me-2 mb-2 rounded-pill hover-primary">
                <i class="fas fa-tag me-1"></i><?php echo $tag; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
.hover-primary:hover {
    color: var(--primary) !important;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.card {
    transition: all 0.3s ease;
}
</style>
