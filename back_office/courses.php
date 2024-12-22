<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'courses';
$title = "Course Management - Artifitech Admin";
$description = "Manage courses and their content";

// Initialize variables
$courses = [];
$error = null;
$success = null;
$total_pages = 1;

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Handle course actions (if any)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $courseId = $_POST['course_id'] ?? '';

    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        switch ($action) {
            case 'delete':
                $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
                $stmt->execute([$courseId]);
                $success = "Course deleted successfully";
                break;
            case 'publish':
                $stmt = $conn->prepare("UPDATE courses SET status = 'published' WHERE id = ?");
                $stmt->execute([$courseId]);
                $success = "Course published successfully";
                break;
            case 'unpublish':
                $stmt = $conn->prepare("UPDATE courses SET status = 'draft' WHERE id = ?");
                $stmt->execute([$courseId]);
                $success = "Course unpublished successfully";
                break;
        }
    } catch (Exception $e) {
        error_log("Error in course action: " . $e->getMessage());
        $error = "An error occurred while processing your request";
    }
}

// Get courses list with pagination
$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page_number - 1) * $items_per_page;

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Get total courses count
    $stmt = $conn->query("SELECT COUNT(*) FROM courses");
    if ($stmt) {
        $total_courses = $stmt->fetchColumn();
        $total_pages = ceil($total_courses / $items_per_page);
    }
    
    // Get courses for current page with enrollment count
    $query = "
        SELECT c.*, COUNT(e.id) as enrollment_count 
        FROM courses c 
        LEFT JOIN enrollments e ON c.id = e.course_id 
        GROUP BY c.id 
        ORDER BY c.created_at DESC 
        LIMIT ? OFFSET ?
    ";
    
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$items_per_page, $offset])) {
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
} catch (Exception $e) {
    error_log("Error in courses.php: " . $e->getMessage());
    $error = "An error occurred while fetching courses.";
}

// Start output buffering
ob_start();
?>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($error); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($success); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Courses Table Start -->
<div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.1s">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Enrollments</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted mb-0">No courses found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($courses as $course): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($course['thumbnail'])): ?>
                                <img src="<?php echo htmlspecialchars($course['thumbnail']); ?>" 
                                     alt="Course Thumbnail" 
                                     class="rounded me-3"
                                     style="width: 48px; height: 36px; object-fit: cover;">
                                <?php else: ?>
                                <div class="bg-light rounded me-3" style="width: 48px; height: 36px;"></div>
                                <?php endif; ?>
                                <div>
                                    <h6 class="mb-0"><?php echo htmlspecialchars($course['title']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars(substr($course['short_description'], 0, 50)) . '...'; ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                <?php echo ucfirst(htmlspecialchars($course['category'])); ?>
                            </span>
                        </td>
                        <td>$<?php echo number_format($course['price'], 2); ?></td>
                        <td>
                            <span class="badge bg-info">
                                <?php echo number_format($course['enrollment_count']); ?> students
                            </span>
                        </td>
                        <td>
                            <?php if ($course['status'] === 'published'): ?>
                                <span class="badge bg-success">Published</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="course_edit.php?id=<?php echo $course['id']; ?>" 
                                   class="btn btn-sm btn-outline-primary"
                                   title="Edit Course">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($course['status'] === 'published'): ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <input type="hidden" name="action" value="unpublish">
                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Unpublish Course">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </form>
                                <?php else: ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <input type="hidden" name="action" value="publish">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Publish Course">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Course">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Start -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $page_number <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page_number - 1; ?>">Previous</a>
                </li>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $page_number === $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
                
                <li class="page-item <?php echo $page_number >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page_number + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
        <!-- Pagination End -->
    </div>
</div>

<style>
.bg-primary-gradient {
    background: linear-gradient(45deg, #2124B1, #4777F5);
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.btn-group .btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

.table th {
    font-weight: 600;
    font-family: 'Exo 2', sans-serif;
    color: #2124B1;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}
</style>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 