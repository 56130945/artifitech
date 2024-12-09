<?php
require_once '../includes/config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Set page variables
$page = 'dashboard';
$title = 'Dashboard - Artifitech Admin';

// Initialize variables
$total_users = 0;
$total_courses = 0;
$total_enrollments = 0;
$total_revenue = 0;
$recent_enrollments = [];
$popular_courses = [];
$monthly_revenue = [];
$error = null;

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Get total users count
    $stmt = $conn->query("SELECT COUNT(*) FROM users");
    if ($stmt) {
        $total_users = $stmt->fetchColumn();
    }
    
    // Get total courses count
    $stmt = $conn->query("SELECT COUNT(*) FROM courses");
    if ($stmt) {
        $total_courses = $stmt->fetchColumn();
    }
    
    // Get total enrollments count
    $stmt = $conn->query("SELECT COUNT(*) FROM enrollments");
    if ($stmt) {
        $total_enrollments = $stmt->fetchColumn();
    }
    
    // Get total revenue
    $stmt = $conn->query("
        SELECT COALESCE(SUM(c.price), 0) as total_revenue 
        FROM enrollments e 
        JOIN courses c ON e.course_id = c.id 
        WHERE e.status = 'approved'
    ");
    if ($stmt) {
        $total_revenue = $stmt->fetchColumn();
    }
    
    // Get recent enrollments
    $stmt = $conn->query("
        SELECT e.*, u.first_name, u.last_name, u.email, c.title as course_title, c.price
        FROM enrollments e
        JOIN users u ON e.user_id = u.id
        JOIN courses c ON e.course_id = c.id
        ORDER BY e.created_at DESC
        LIMIT 5
    ");
    if ($stmt) {
        $recent_enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get popular courses
    $stmt = $conn->query("
        SELECT c.*, COUNT(e.id) as enrollment_count
        FROM courses c
        LEFT JOIN enrollments e ON c.id = e.course_id
        GROUP BY c.id
        ORDER BY enrollment_count DESC
        LIMIT 5
    ");
    if ($stmt) {
        $popular_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get monthly revenue data for chart
    $stmt = $conn->query("
        SELECT DATE_FORMAT(e.created_at, '%Y-%m') as month,
               COALESCE(SUM(c.price), 0) as revenue
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        WHERE e.status = 'approved'
        AND e.created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY month
        ORDER BY month ASC
    ");
    if ($stmt) {
        $monthly_revenue = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
} catch (Exception $e) {
    error_log("Error in dashboard.php: " . $e->getMessage());
    $error = "An error occurred while fetching dashboard data.";
}

// Start output buffering
ob_start();
?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Page Header Start -->
<div class="page-header wow fadeIn" data-wow-delay="0.1s">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="display-6 text-white mb-0">Dashboard Overview</h1>
            <p class="text-white-50 mb-0">Monitor your platform's performance and metrics</p>
        </div>
        <button class="btn btn-light" onclick="window.print()">
            <i class="fas fa-print me-2"></i>Print Report
        </button>
    </div>
</div>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($error); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Stats Cards Start -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
        <div class="stat-card">
            <div class="stat-icon bg-primary-gradient text-white">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h3 class="mb-2"><?php echo number_format($total_users); ?></h3>
                <p class="text-muted mb-0">Total Users</p>
            </div>
            <div class="mt-3">
                <a href="users.php" class="btn btn-link text-primary p-0">
                    View Details <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
        <div class="stat-card">
            <div class="stat-icon bg-success-gradient text-white">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <h3 class="mb-2"><?php echo number_format($total_courses); ?></h3>
                <p class="text-muted mb-0">Total Courses</p>
            </div>
            <div class="mt-3">
                <a href="courses.php" class="btn btn-link text-success p-0">
                    View Details <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
        <div class="stat-card">
            <div class="stat-icon bg-info-gradient text-white">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <h3 class="mb-2"><?php echo number_format($total_enrollments); ?></h3>
                <p class="text-muted mb-0">Total Enrollments</p>
            </div>
            <div class="mt-3">
                <a href="enrollments.php" class="btn btn-link text-info p-0">
                    View Details <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 wow fadeInUp" data-wow-delay="0.4s">
        <div class="stat-card">
            <div class="stat-icon bg-warning-gradient text-white">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <h3 class="mb-2">$<?php echo number_format($total_revenue, 2); ?></h3>
                <p class="text-muted mb-0">Total Revenue</p>
            </div>
            <div class="mt-3">
                <a href="reports.php" class="btn btn-link text-warning p-0">
                    View Details <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Stats Cards End -->

<!-- Charts Start -->
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.1s">
            <div class="card-body">
                <h5 class="card-title">Revenue Overview</h5>
                <div class="mt-4" style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.2s">
            <div class="card-body">
                <h5 class="card-title">Popular Courses</h5>
                <div class="mt-4" style="height: 300px;">
                    <canvas id="coursesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Charts End -->

<!-- Recent Activity Start -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.1s">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title mb-0">Recent Enrollments</h5>
                    <a href="enrollments.php" class="btn btn-link p-0">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_enrollments)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-muted mb-0">No recent enrollments found</p>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($recent_enrollments as $enrollment): ?>
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
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.2s">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title mb-0">Popular Courses</h5>
                    <a href="courses.php" class="btn btn-link p-0">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Enrollments</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($popular_courses)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-muted mb-0">No courses found</p>
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($popular_courses as $course): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($course['thumbnail'])): ?>
                                        <img src="<?php echo htmlspecialchars($course['thumbnail']); ?>" 
                                             alt="Course Thumbnail" 
                                             class="rounded me-3"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                        <div class="bg-light rounded me-3" style="width: 40px; height: 40px;"></div>
                                        <?php endif; ?>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($course['title']); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?php echo number_format($course['enrollment_count']); ?> students
                                    </span>
                                </td>
                                <td>$<?php echo number_format($course['price'], 2); ?></td>
                                <td>
                                    <?php if ($course['status'] === 'published'): ?>
                                        <span class="badge bg-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Draft</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Recent Activity End -->

<style>
.bg-primary-gradient {
    background: linear-gradient(45deg, #2124B1, #4777F5);
}

.bg-success-gradient {
    background: linear-gradient(45deg, #28a745, #34ce57);
}

.bg-info-gradient {
    background: linear-gradient(45deg, #17a2b8, #1fc8e3);
}

.bg-warning-gradient {
    background: linear-gradient(45deg, #ffc107, #ffdb4a);
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-title {
    color: #2124B1;
    font-family: 'Exo 2', sans-serif;
    font-weight: 600;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

@media print {
    .wow {
        opacity: 1 !important;
        visibility: visible !important;
    }
}
</style>

<script>
// Revenue Chart
const revenueData = <?php echo json_encode(array_map(function($item) {
    return [
        'month' => date('M Y', strtotime($item['month'] . '-01')),
        'revenue' => floatval($item['revenue'])
    ];
}, $monthly_revenue)); ?>;

if (document.getElementById('revenueChart')) {
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueData.map(item => item.month),
            datasets: [{
                label: 'Monthly Revenue',
                data: revenueData.map(item => item.revenue),
                borderColor: '#2124B1',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(33, 36, 177, 0.1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

// Popular Courses Chart
const coursesData = <?php echo json_encode(array_map(function($course) {
    return [
        'title' => $course['title'],
        'count' => intval($course['enrollment_count'])
    ];
}, $popular_courses)); ?>;

if (document.getElementById('coursesChart')) {
    const coursesCtx = document.getElementById('coursesChart').getContext('2d');
    new Chart(coursesCtx, {
        type: 'doughnut',
        data: {
            labels: coursesData.map(item => item.title),
            datasets: [{
                data: coursesData.map(item => item.count),
                backgroundColor: [
                    '#2124B1',
                    '#28a745',
                    '#ffc107',
                    '#17a2b8',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                }
            }
        }
    });
}
</script>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 