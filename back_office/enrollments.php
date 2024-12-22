<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'enrollments';
$title = "Course Enrollments - Artifitech Admin";
$description = "Manage student enrollments and course progress";

// Initialize variables
$error = null;
$success = null;
$enrollments = [];
$enrollment_stats = [];
$total_pages = 1;

// Get enrollments with pagination
$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 20;
$offset = ($page_number - 1) * $items_per_page;

// Filter parameters
$filter_course = $_GET['course'] ?? '';
$filter_status = $_GET['status'] ?? '';
$filter_date_start = $_GET['date_start'] ?? '';
$filter_date_end = $_GET['date_end'] ?? '';
$search = $_GET['search'] ?? '';

// Handle enrollment actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }
        
        // Start transaction
        $conn->beginTransaction();
        
        if (isset($_POST['update_status'])) {
            $enrollment_id = (int)$_POST['enrollment_id'];
            $new_status = $_POST['status'];
            
            $stmt = $conn->prepare("
                UPDATE enrollments 
                SET status = ?, updated_at = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([$new_status, $enrollment_id]);
            
            if ($new_status === 'completed') {
                $stmt = $conn->prepare("
                    UPDATE enrollments 
                    SET completion_date = NOW() 
                    WHERE id = ?
                ");
                $stmt->execute([$enrollment_id]);
            }
            
            $success = "Enrollment status updated successfully.";
        }
        
        if (isset($_POST['update_progress'])) {
            $enrollment_id = (int)$_POST['enrollment_id'];
            $progress = (int)$_POST['progress'];
            
            $stmt = $conn->prepare("
                UPDATE enrollments 
                SET progress = ?, updated_at = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([$progress, $enrollment_id]);
            
            if ($progress === 100) {
                $stmt = $conn->prepare("
                    UPDATE enrollments 
                    SET status = 'completed', completion_date = NOW() 
                    WHERE id = ?
                ");
                $stmt->execute([$enrollment_id]);
            }
            
            $success = "Progress updated successfully.";
        }
        
        // Commit transaction
        $conn->commit();
        
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Error in enrollments.php: " . $e->getMessage());
        $error = "An error occurred while updating enrollment.";
    }
}

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Get enrollment statistics
    $stats_query = "
        SELECT 
            COUNT(*) as total_enrollments,
            COUNT(CASE WHEN status = 'active' THEN 1 END) as active_enrollments,
            COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_enrollments,
            COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_enrollments,
            AVG(progress) as avg_progress
        FROM enrollments
    ";
    $enrollment_stats = $conn->query($stats_query)->fetch(PDO::FETCH_ASSOC);
    
    // Get available courses for filter
    $courses_query = "SELECT id, title FROM courses ORDER BY title ASC";
    $courses = $conn->query($courses_query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Build the WHERE clause based on filters
    $where_conditions = [];
    $params = [];
    
    if ($filter_course) {
        $where_conditions[] = "e.course_id = ?";
        $params[] = $filter_course;
    }
    
    if ($filter_status) {
        $where_conditions[] = "e.status = ?";
        $params[] = $filter_status;
    }
    
    if ($filter_date_start) {
        $where_conditions[] = "DATE(e.start_date) >= ?";
        $params[] = $filter_date_start;
    }
    
    if ($filter_date_end) {
        $where_conditions[] = "DATE(e.start_date) <= ?";
        $params[] = $filter_date_end;
    }
    
    if ($search) {
        $where_conditions[] = "(c.first_name LIKE ? OR c.last_name LIKE ? OR c.email LIKE ? OR co.title LIKE ?)";
        $search_param = "%$search%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
    }
    
    $where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";
    
    // Get total enrollments count
    $count_query = "
        SELECT COUNT(*) 
        FROM enrollments e
        LEFT JOIN customers c ON e.customer_id = c.id
        LEFT JOIN courses co ON e.course_id = co.id
        $where_clause
    ";
    $stmt = $conn->prepare($count_query);
    $stmt->execute($params);
    $total_enrollments = $stmt->fetchColumn();
    $total_pages = ceil($total_enrollments / $items_per_page);
    
    // Get enrollments for current page
    $query = "
        SELECT 
            e.*,
            c.first_name,
            c.last_name,
            c.email,
            co.title as course_title,
            co.duration as course_duration
        FROM enrollments e
        LEFT JOIN customers c ON e.customer_id = c.id
        LEFT JOIN courses co ON e.course_id = co.id
        $where_clause
        ORDER BY e.start_date DESC
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $items_per_page;
    $params[] = $offset;
    
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log("Error in enrollments.php: " . $e->getMessage());
    $error = "An error occurred while fetching enrollments.";
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

<!-- Statistics Cards Start -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Total Enrollments</h6>
                    <div class="bg-primary rounded-circle p-2">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0"><?php echo number_format($enrollment_stats['total_enrollments'] ?? 0); ?></h3>
                <small class="text-muted">All time enrollments</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Active Students</h6>
                    <div class="bg-success rounded-circle p-2">
                        <i class="fas fa-user-graduate text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0"><?php echo number_format($enrollment_stats['active_enrollments'] ?? 0); ?></h3>
                <small class="text-muted">Currently enrolled</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Completion Rate</h6>
                    <div class="bg-info rounded-circle p-2">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0">
                    <?php 
                    $completion_rate = ($enrollment_stats['total_enrollments'] ?? 0) > 0 
                        ? (($enrollment_stats['completed_enrollments'] ?? 0) / $enrollment_stats['total_enrollments']) * 100 
                        : 0;
                    echo number_format($completion_rate, 1) . '%';
                    ?>
                </h3>
                <small class="text-muted">Average completion rate</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Average Progress</h6>
                    <div class="bg-warning rounded-circle p-2">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                </div>
                <h3 class="mb-0"><?php echo number_format($enrollment_stats['avg_progress'] ?? 0, 1); ?>%</h3>
                <small class="text-muted">Across all courses</small>
            </div>
        </div>
    </div>
</div>

<!-- Filters Start -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Filter Enrollments</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Course</label>
                <select name="course" class="form-select">
                    <option value="">All Courses</option>
                    <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['id']; ?>" <?php echo $filter_course == $course['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($course['title']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active" <?php echo $filter_status === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="completed" <?php echo $filter_status === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $filter_status === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    <option value="suspended" <?php echo $filter_status === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                </select>
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Date Range</label>
                <div class="input-group">
                    <input type="date" name="date_start" class="form-control" value="<?php echo $filter_date_start; ?>">
                    <input type="date" name="date_end" class="form-control" value="<?php echo $filter_date_end; ?>">
                </div>
            </div>
            
            <div class="col-md-2">
                <label class="form-label">Items per page</label>
                <select name="per_page" class="form-select">
                    <option value="20" <?php echo $items_per_page === 20 ? 'selected' : ''; ?>>20</option>
                    <option value="50" <?php echo $items_per_page === 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $items_per_page === 100 ? 'selected' : ''; ?>>100</option>
                </select>
            </div>
            
            <div class="col-md-10">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Search by student name, email, or course title" 
                       value="<?php echo htmlspecialchars($search); ?>">
            </div>
            
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Enrollments Table Start -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Course Enrollments</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Last Accessed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($enrollments)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">No enrollments found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($enrollments as $enrollment): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <?php 
                                    $names = explode(' ', $enrollment['first_name'] . ' ' . $enrollment['last_name']);
                                    $initials = '';
                                    foreach ($names as $name) {
                                        $initials .= strtoupper(substr($name, 0, 1));
                                    }
                                    echo $initials ?: 'S';
                                    ?>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        <?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?>
                                    </h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($enrollment['email']); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <h6 class="mb-0"><?php echo htmlspecialchars($enrollment['course_title']); ?></h6>
                                <small class="text-muted">Duration: <?php echo htmlspecialchars($enrollment['course_duration']); ?></small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $enrollment['progress']; ?>%"
                                         aria-valuenow="<?php echo $enrollment['progress']; ?>" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="ms-2"><?php echo $enrollment['progress']; ?>%</span>
                            </div>
                        </td>
                        <td>
                            <?php
                            $status_class = match($enrollment['status']) {
                                'active' => 'success',
                                'completed' => 'primary',
                                'cancelled' => 'danger',
                                'suspended' => 'warning',
                                default => 'secondary'
                            };
                            ?>
                            <span class="badge bg-<?php echo $status_class; ?>">
                                <?php echo ucfirst($enrollment['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($enrollment['start_date'])); ?></td>
                        <td>
                            <?php 
                            echo $enrollment['last_accessed'] 
                                ? date('M d, Y H:i', strtotime($enrollment['last_accessed']))
                                : 'Never';
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                    onclick="showEnrollmentDetails(<?php echo htmlspecialchars(json_encode($enrollment)); ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" 
                                    onclick="updateProgress(<?php echo $enrollment['id']; ?>, <?php echo $enrollment['progress']; ?>)">
                                <i class="fas fa-chart-line"></i>
                            </button>
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
                    <a class="page-link" href="?page=<?php echo $page_number - 1; ?>&course=<?php echo urlencode($filter_course); ?>&status=<?php echo urlencode($filter_status); ?>&date_start=<?php echo urlencode($filter_date_start); ?>&date_end=<?php echo urlencode($filter_date_end); ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $page_number === $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&course=<?php echo urlencode($filter_course); ?>&status=<?php echo urlencode($filter_status); ?>&date_start=<?php echo urlencode($filter_date_start); ?>&date_end=<?php echo urlencode($filter_date_end); ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
                
                <li class="page-item <?php echo $page_number >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page_number + 1; ?>&course=<?php echo urlencode($filter_course); ?>&status=<?php echo urlencode($filter_status); ?>&date_start=<?php echo urlencode($filter_date_start); ?>&date_end=<?php echo urlencode($filter_date_end); ?>&search=<?php echo urlencode($search); ?>">Next</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
        <!-- Pagination End -->
    </div>
</div>

<!-- Enrollment Details Modal -->
<div class="modal fade" id="enrollmentDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enrollment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody id="enrollmentDetailsContent">
                            <!-- Enrollment details will be inserted here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" class="me-auto">
                    <input type="hidden" name="update_status" value="1">
                    <input type="hidden" name="enrollment_id" id="statusEnrollmentId">
                    <div class="input-group">
                        <select name="status" class="form-select" id="statusSelect">
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="suspended">Suspended</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Progress Modal -->
<div class="modal fade" id="updateProgressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="progressForm">
                    <input type="hidden" name="update_progress" value="1">
                    <input type="hidden" name="enrollment_id" id="progressEnrollmentId">
                    <div class="mb-3">
                        <label class="form-label">Progress Percentage</label>
                        <input type="range" class="form-range" name="progress" id="progressRange" 
                               min="0" max="100" step="5">
                        <div class="text-center">
                            <span id="progressValue">0</span>%
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Progress</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Show enrollment details
function showEnrollmentDetails(enrollment) {
    const content = document.getElementById('enrollmentDetailsContent');
    const statusSelect = document.getElementById('statusSelect');
    const statusEnrollmentId = document.getElementById('statusEnrollmentId');
    
    content.innerHTML = `
        <tr>
            <th>Student Name</th>
            <td>${enrollment.first_name} ${enrollment.last_name}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>${enrollment.email}</td>
        </tr>
        <tr>
            <th>Course</th>
            <td>${enrollment.course_title}</td>
        </tr>
        <tr>
            <th>Progress</th>
            <td>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: ${enrollment.progress}%"
                         aria-valuenow="${enrollment.progress}" 
                         aria-valuemin="0" aria-valuemax="100">
                        ${enrollment.progress}%
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td><span class="badge bg-${getStatusClass(enrollment.status)}">${enrollment.status}</span></td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>${new Date(enrollment.start_date).toLocaleDateString()}</td>
        </tr>
        <tr>
            <th>Last Accessed</th>
            <td>${enrollment.last_accessed ? new Date(enrollment.last_accessed).toLocaleString() : 'Never'}</td>
        </tr>
        <tr>
            <th>Completion Date</th>
            <td>${enrollment.completion_date ? new Date(enrollment.completion_date).toLocaleDateString() : 'Not completed'}</td>
        </tr>
    `;
    
    // Set current status in select
    statusSelect.value = enrollment.status;
    statusEnrollmentId.value = enrollment.id;
    
    const modal = new bootstrap.Modal(document.getElementById('enrollmentDetailsModal'));
    modal.show();
}

// Update progress
function updateProgress(enrollmentId, currentProgress) {
    const progressRange = document.getElementById('progressRange');
    const progressValue = document.getElementById('progressValue');
    const progressEnrollmentId = document.getElementById('progressEnrollmentId');
    
    progressRange.value = currentProgress;
    progressValue.textContent = currentProgress;
    progressEnrollmentId.value = enrollmentId;
    
    progressRange.addEventListener('input', function() {
        progressValue.textContent = this.value;
    });
    
    const modal = new bootstrap.Modal(document.getElementById('updateProgressModal'));
    modal.show();
}

// Get status class for badge
function getStatusClass(status) {
    switch (status) {
        case 'active': return 'success';
        case 'completed': return 'primary';
        case 'cancelled': return 'danger';
        case 'suspended': return 'warning';
        default: return 'secondary';
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
});
</script>

<style>
.card {
    border-radius: 10px;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.table th {
    font-weight: 600;
    color: #06BBCC;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

.progress {
    height: 8px;
    border-radius: 4px;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 0.75rem 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #06BBCC;
    box-shadow: 0 0 0 0.2rem rgba(6, 187, 204, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
}

.btn-primary {
    background-color: #06BBCC !important;
    border-color: #06BBCC !important;
}

.btn-primary:hover {
    background-color: #058e9d !important;
    border-color: #058e9d !important;
}

.btn-outline-primary {
    color: #06BBCC !important;
    border-color: #06BBCC !important;
}

.btn-outline-primary:hover {
    background-color: #06BBCC !important;
    color: #fff !important;
}

.btn-outline-success:hover {
    background-color: #06BBCC !important;
    border-color: #06BBCC !important;
}

.modal-content {
    border-radius: 10px;
    border: none;
}

.modal-header {
    border-bottom: 1px solid #e0e0e0;
}

.table-responsive {
    border-radius: 8px;
}

.rounded-circle {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-primary {
    background-color: #06BBCC !important;
}

.text-primary {
    color: #06BBCC !important;
}

.progress-bar {
    background-color: #06BBCC !important;
}

.form-range::-webkit-slider-thumb {
    background: #06BBCC;
}

.form-range::-moz-range-thumb {
    background: #06BBCC;
}

.pagination .page-link {
    color: #06BBCC;
}

.pagination .active .page-link {
    background-color: #06BBCC;
    border-color: #06BBCC;
}

.bg-success {
    background-color: #06BBCC !important;
}

.bg-info {
    background-color: #06BBCC !important;
}

.bg-warning {
    background-color: #06BBCC !important;
}

.badge.bg-success {
    background-color: #06BBCC !important;
}

.badge.bg-primary {
    background-color: #058e9d !important;
}
</style>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 