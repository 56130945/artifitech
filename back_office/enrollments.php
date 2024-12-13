<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'enrollments';
$title = "Enrollment Management - Artifitech Admin";
$description = "Manage course enrollments and student access";

// Initialize variables
$enrollments = [];
$error = null;
$success = null;
$total_pages = 1;

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Handle enrollment actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $enrollment_id = $_POST['enrollment_id'] ?? '';

    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }
        
        switch ($action) {
            case 'approve':
                $stmt = $conn->prepare("UPDATE enrollments SET status = 'approved', updated_at = NOW() WHERE id = ?");
                $stmt->execute([$enrollment_id]);
                break;
            case 'reject':
                $stmt = $conn->prepare("UPDATE enrollments SET status = 'rejected', updated_at = NOW() WHERE id = ?");
                $stmt->execute([$enrollment_id]);
                break;
            case 'cancel':
                $stmt = $conn->prepare("UPDATE enrollments SET status = 'cancelled', updated_at = NOW() WHERE id = ?");
                $stmt->execute([$enrollment_id]);
                break;
        }
        
        $_SESSION['success_message'] = "Enrollment status updated successfully!";
        header('Location: enrollments.php');
        exit;
        
    } catch (Exception $e) {
        error_log("Error updating enrollment: " . $e->getMessage());
        $error = "An error occurred while updating the enrollment.";
    }
}

// Get filters
$status_filter = $_GET['status'] ?? 'all';
$course_filter = $_GET['course'] ?? 'all';
$search = $_GET['search'] ?? '';

// Get enrollments list with pagination
$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page_number - 1) * $items_per_page;

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Build query conditions
    $conditions = [];
    $params = [];
    
    if ($status_filter !== 'all') {
        $conditions[] = "e.status = ?";
        $params[] = $status_filter;
    }
    
    if ($course_filter !== 'all') {
        $conditions[] = "e.course_id = ?";
        $params[] = $course_filter;
    }
    
    if ($search) {
        $conditions[] = "(u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ? OR c.title LIKE ?)";
        $search_param = "%$search%";
        $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param]);
    }
    
    $where_clause = $conditions ? "WHERE " . implode(" AND ", $conditions) : "";
    
    // Get total enrollments count
    $count_query = "
        SELECT COUNT(*) 
        FROM enrollments e
        JOIN users u ON e.user_id = u.id
        JOIN courses c ON e.course_id = c.id
        $where_clause
    ";
    $stmt = $conn->prepare($count_query);
    $stmt->execute($params);
    $total_enrollments = $stmt->fetchColumn();
    $total_pages = ceil($total_enrollments / $items_per_page);
    
    // Get enrollments for current page
    $query = "
        SELECT e.*, 
               u.first_name, u.last_name, u.email,
               c.title as course_title, c.price
        FROM enrollments e
        JOIN users u ON e.user_id = u.id
        JOIN courses c ON e.course_id = c.id
        $where_clause
        ORDER BY e.created_at DESC
        LIMIT ? OFFSET ?
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->execute(array_merge($params, [$items_per_page, $offset]));
    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get courses for filter
    $stmt = $conn->query("SELECT id, title FROM courses ORDER BY title");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log("Error in enrollments.php: " . $e->getMessage());
    $error = "An error occurred while fetching enrollments.";
    $enrollments = [];
    $total_pages = 1;
}

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="page-header wow fadeIn" data-wow-delay="0.1s">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="display-6 text-white mb-0">Enrollment Management</h1>
            <p class="text-white-50 mb-0">Manage course enrollments and student access</p>
        </div>
        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exportModal">
            <i class="fas fa-download me-2"></i>Export Data
        </button>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($error); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php 
    echo htmlspecialchars($_SESSION['success_message']);
    unset($_SESSION['success_message']);
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Filters Start -->
<div class="card border-0 shadow-sm mb-4 wow fadeInUp" data-wow-delay="0.1s">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Status</option>
                    <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo $status_filter === 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo $status_filter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    <option value="cancelled" <?php echo $status_filter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Course</label>
                <select class="form-select" name="course">
                    <option value="all">All Courses</option>
                    <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['id']; ?>" 
                            <?php echo $course_filter == $course['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($course['title']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" class="form-control" name="search" 
                       value="<?php echo htmlspecialchars($search); ?>" 
                       placeholder="Search by name, email or course...">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Enrollments Table Start -->
<div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.2s">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Enrolled On</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($enrollments)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted mb-0">No enrollments found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($enrollments as $enrollment): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <?php echo strtoupper(substr($enrollment['first_name'], 0, 1) . substr($enrollment['last_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($enrollment['email']); ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($enrollment['course_title']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($enrollment['created_at'])); ?></td>
                        <td>
                            <?php
                            $status_class = [
                                'pending' => 'bg-warning',
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                'cancelled' => 'bg-secondary'
                            ][$enrollment['status']] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?php echo $status_class; ?>">
                                <?php echo ucfirst($enrollment['status']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                $<?php echo number_format($enrollment['price'], 2); ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php if ($enrollment['status'] === 'pending'): ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="enrollment_id" value="<?php echo $enrollment['id']; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="enrollment_id" value="<?php echo $enrollment['id']; ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                <?php if ($enrollment['status'] === 'approved'): ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="enrollment_id" value="<?php echo $enrollment['id']; ?>">
                                    <input type="hidden" name="action" value="cancel">
                                    <button type="submit" class="btn btn-sm btn-warning" title="Cancel">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                <button type="button" class="btn btn-sm btn-info" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewDetailsModal<?php echo $enrollment['id']; ?>"
                                        title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
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
                    <a class="page-link" href="?page=<?php echo $page_number - 1; ?>&status=<?php echo $status_filter; ?>&course=<?php echo $course_filter; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $page_number === $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>&course=<?php echo $course_filter; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
                
                <li class="page-item <?php echo $page_number >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page_number + 1; ?>&status=<?php echo $status_filter; ?>&course=<?php echo $course_filter; ?>&search=<?php echo urlencode($search); ?>">Next</a>
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