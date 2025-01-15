<?php
// In a real application, you would fetch this from a database
$article = [
    'title' => 'AI Integration in Education',
    'date' => '15 Nov 2023',
    'author' => 'Dr. Sarah Johnson',
    'category' => 'Technology',
    'image' => 'img/index/news-1.jpg.png',
    'content' => '<p class="lead">Artificial Intelligence is revolutionizing the education sector, and Artifitech is at the forefront of this transformation.</p>
        
        <p>Our AI-powered solutions are helping educational institutions streamline their operations and improve learning outcomes. Through machine learning algorithms and data analytics, we are able to provide personalized learning experiences for students while giving educators powerful tools to track and enhance student performance.</p>

        <h4>Key Benefits of AI in Education:</h4>
        <ul>
            <li>Personalized Learning Paths</li>
            <li>Automated Administrative Tasks</li>
            <li>Real-time Performance Analytics</li>
            <li>Intelligent Content Recommendations</li>
            <li>Predictive Student Success Metrics</li>
        </ul>',
    'tags' => ['AI', 'Education', 'Technology', 'Innovation']
];
?>

<article class="blog-post bg-white p-4 rounded shadow-sm">
    <!-- Article Header -->
    <header class="mb-4">
        <h1 class="display-5 mb-3 text-primary"><?php echo $article['title']; ?></h1>
        <div class="meta text-muted mb-4">
            <span class="me-3"><i class="far fa-user me-2"></i><?php echo $article['author']; ?></span>
            <span class="me-3"><i class="far fa-calendar-alt me-2"></i><?php echo $article['date']; ?></span>
            <span><i class="far fa-folder me-2"></i><?php echo $article['category']; ?></span>
        </div>
    </header>

    <!-- Featured Image -->
    <div class="position-relative mb-4">
        <img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>" class="img-fluid rounded w-100">
        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
            <div class="container">
                <div class="category">
                    <span class="badge bg-primary"><?php echo $article['category']; ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="content mb-5">
        <?php echo $article['content']; ?>
    </div>

    <!-- Tags -->
    <div class="tags mb-5">
        <?php foreach ($article['tags'] as $tag): ?>
            <a href="#" class="btn btn-light btn-sm me-2 mb-2 rounded-pill">#<?php echo $tag; ?></a>
        <?php endforeach; ?>
    </div>

    <!-- Share Buttons -->
    <div class="share-buttons mb-5 bg-light p-4 rounded">
        <h5 class="mb-3 text-primary">Share this article</h5>
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-primary" onclick="shareArticle('twitter')">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-primary" onclick="shareArticle('facebook')">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="btn btn-primary" onclick="shareArticle('linkedin')">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="btn btn-primary" onclick="shareArticle('whatsapp')">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>

    <!-- Comments Section -->
    <section class="comments-section bg-light p-4 rounded">
        <h3 class="mb-4 text-primary">Comments</h3>
        
        <!-- Comment Form -->
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body">
                <h5 class="card-title mb-4">Leave a Comment</h5>
                <form id="commentForm">
                    <div class="mb-3">
                        <textarea class="form-control" rows="4" placeholder="Your comment..."></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
            </div>
        </div>

        <!-- Comments List -->
        <div class="comments-list">
            <!-- Sample Comment -->
            <div class="comment bg-white p-4 rounded shadow-sm mb-4">
                <div class="d-flex">
                    <img src="img/user-avatar.jpg" class="rounded-circle me-3" width="50" height="50" alt="User Avatar">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">John Doe</h6>
                        <p class="text-muted small mb-2">2 days ago</p>
                        <p class="mb-2">This is a great article! The AI integration features look promising for our institution.</p>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-link text-primary p-0 me-3">Reply</button>
                            <button class="btn btn-sm btn-link text-primary p-0">
                                <i class="far fa-heart me-1"></i>Like
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>
