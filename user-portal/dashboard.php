<?php
require_once '../includes/config.php';
require_once '../includes/auth_check.php';

// Set page-specific variables
$page = 'user-dashboard';
$title = "User Dashboard - Artifitech";
$description = "Manage your Artifitech courses and subscriptions";

// Initialize variables
$activeCourses = [];
$activeSubscriptions = [];
$availableCourses = [];
$availableProducts = [];
$error = null;

// Check if user is logged in and is a customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: ../login.php');
    exit;
}

// Get user's current subscriptions and courses
try {
    $conn = getDBConnection();
    
    // Get user's active courses
    $stmt = $conn->prepare("
        SELECT c.* FROM courses c
        JOIN user_courses uc ON c.id = uc.course_id
        WHERE uc.user_id = ? AND uc.status = 'active'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $activeCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get user's subscriptions
    $stmt = $conn->prepare("
        SELECT s.*, p.name as product_name, p.description as product_description 
        FROM subscriptions s
        JOIN products p ON s.product_id = p.id
        WHERE s.user_id = ? AND s.status = 'active'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $activeSubscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get available courses
    $stmt = $conn->prepare("
        SELECT * FROM courses 
        WHERE status = 'active' 
        AND id NOT IN (
            SELECT course_id FROM user_courses 
            WHERE user_id = ?
        )
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $availableCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get available products
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE status = 'active'
        AND id NOT IN (
            SELECT product_id FROM subscriptions 
            WHERE user_id = ? AND status = 'active'
        )
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $availableProducts = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

} catch (PDOException $e) {
    error_log("Error in user dashboard: " . $e->getMessage());
    $error = "An error occurred while loading your dashboard. Our team has been notified.";
}

// Start output buffering
ob_start();
?>

<!-- Dashboard Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Dashboard Header End -->

<?php if ($error): ?>
<div class="container-xxl py-2">
    <div class="container">
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Quick Stats Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                        <h5 class="mb-3">Active Courses</h5>
                        <h1 class="display-6"><?php echo count($activeCourses); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                        <h5 class="mb-3">Active Subscriptions</h5>
                        <h1 class="display-6"><?php echo count($activeSubscriptions); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                        <h5 class="mb-3">Available Courses</h5>
                        <h1 class="display-6"><?php echo count($availableCourses); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-award text-primary mb-4"></i>
                        <h5 class="mb-3">Available Products</h5>
                        <h1 class="display-6"><?php echo count($availableProducts); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick Stats End -->

<!-- Active Courses & Subscriptions Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Active Courses -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <h2 class="mb-4">Your Active Courses</h2>
                    <?php if (!empty($activeCourses)): ?>
                        <div class="row g-4">
                            <?php foreach ($activeCourses as $course): ?>
                                <div class="col-12">
                                    <div class="course-item bg-white rounded overflow-hidden">
                                        <div class="position-relative overflow-hidden">
                                            <img class="img-fluid" src="<?php echo htmlspecialchars($course['image_url']); ?>" alt="<?php echo htmlspecialchars($course['name']); ?>">
                                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                                <a href="course.php?id=<?php echo $course['id']; ?>" class="btn btn-primary px-3">Continue Learning</a>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h5 class="mb-3"><?php echo htmlspecialchars($course['name']); ?></h5>
                                            <p class="mb-0"><?php echo htmlspecialchars($course['description']); ?></p>
                                            <div class="progress mt-3">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $course['progress']; ?>%"
                                                     aria-valuenow="<?php echo $course['progress']; ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <?php echo $course['progress']; ?>%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <p class="mb-3">You haven't enrolled in any courses yet.</p>
                            <a href="#available-courses" class="btn btn-primary">Browse Courses</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Active Subscriptions -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-light rounded h-100 p-5">
                    <h2 class="mb-4">Your Active Subscriptions</h2>
                    <?php if (!empty($activeSubscriptions)): ?>
                        <div class="row g-4">
                            <?php foreach ($activeSubscriptions as $subscription): ?>
                                <div class="col-12">
                                    <div class="subscription-item bg-white rounded p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0"><?php echo htmlspecialchars($subscription['product_name']); ?></h5>
                                            <span class="badge bg-primary">Active</span>
                                        </div>
                                        <p class="text-muted mb-3"><?php echo htmlspecialchars($subscription['product_description']); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Renewal Date: <?php echo date('d M Y', strtotime($subscription['renewal_date'])); ?></small>
                                            <a href="subscription.php?id=<?php echo $subscription['id']; ?>" class="btn btn-sm btn-outline-primary">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                            <p class="mb-3">You don't have any active subscriptions.</p>
                            <a href="#available-products" class="btn btn-primary">Browse Products</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Active Courses & Subscriptions End -->

<!-- Available Courses Start -->
<div id="available-courses" class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Academy</h6>
            <h1 class="mb-5">Available Courses</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($availableCourses as $course): ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="<?php echo htmlspecialchars($course['image_url']); ?>" alt="<?php echo htmlspecialchars($course['name']); ?>">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="course-details.php?id=<?php echo $course['id']; ?>" class="btn btn-primary px-3 mx-2">Read More</a>
                                <a href="enroll.php?course_id=<?php echo $course['id']; ?>" class="btn btn-primary px-3 mx-2">Enroll Now</a>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="text-primary"><i class="fa fa-clock me-2"></i><?php echo $course['duration']; ?></small>
                                <small class="text-primary"><i class="fa fa-user me-2"></i><?php echo $course['students_count']; ?> Students</small>
                            </div>
                            <h5 class="mb-3"><?php echo htmlspecialchars($course['name']); ?></h5>
                            <p class="mb-4"><?php echo htmlspecialchars($course['short_description']); ?></p>
                            <div class="d-flex justify-content-between">
                                <div class="price-tag">
                                    <h5 class="mb-0">R<?php echo number_format($course['price'], 2); ?></h5>
                                </div>
                                <div class="rating">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small>(<?php echo $course['ratings_count']; ?>)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Available Courses End -->

<!-- Available Products Start -->
<div id="available-products" class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Flagship Products</h6>
            <h1 class="mb-5">Available Products</h1>
        </div>
        <div class="row g-4">
            <?php foreach ($availableProducts as $product): ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="product-item bg-light rounded">
                        <div class="text-center p-4">
                            <div class="icon mb-3">
                                <img src="<?php echo htmlspecialchars($product['icon_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                            </div>
                            <h5 class="mb-3"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                            <div class="pricing mb-4">
                                <h4 class="text-primary">R<?php echo number_format($product['monthly_price'], 2); ?>/month</h4>
                                <small class="text-muted">or R<?php echo number_format($product['yearly_price'] / 12, 2); ?>/month billed annually</small>
                            </div>
                            <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn btn-primary px-4 mx-2">Learn More</a>
                            <a href="subscribe.php?product_id=<?php echo $product['id']; ?>" class="btn btn-outline-primary px-4 mx-2">Subscribe</a>
                        </div>
                        <div class="features p-4 border-top">
                            <h6 class="mb-3">Key Features:</h6>
                            <?php 
                            $features = json_decode($product['features'], true);
                            foreach ($features as $feature): 
                            ?>
                                <div class="d-flex mb-2">
                                    <i class="fas fa-check text-primary me-2 mt-1"></i>
                                    <span><?php echo htmlspecialchars($feature); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Available Products End -->

<?php
$content = ob_get_clean();
include '../includes/template.php';
?> 