<?php
require_once 'includes/config.php';

// Set page-specific variables
$page = 'news';
$title = "Artifitech News - Latest Updates and Announcements";
$description = "Stay updated with the latest news, features, and developments in educational technology from Artifitech.";

// Get the article ID from URL if present
$article_id = isset($_GET['id']) ? $_GET['id'] : null;

// Start output buffering
ob_start();
?>

<!-- Header -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Latest News</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">News</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- News Content -->
<div class="container">
    <div class="row g-5">
        <!-- Main Content -->
        <div class="col-lg-8">
            <?php if ($article_id): ?>
                <?php include 'includes/news-single.php'; ?>
            <?php else: ?>
                <?php include 'includes/news-list.php'; ?>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <?php include 'includes/news-sidebar.php'; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'includes/template.php';
?>
