<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth_check.php';

// Set page-specific variables
$page = 'courses';
$title = "My Courses - Artifitech";

// Initialize variables
$activeCourses = [];
$completedCourses = [];
$inProgressCourses = [];
$error = null;

// Get user's courses
try {
    $conn = getDBConnection();
    
    // Get active courses
    $stmt = $conn->prepare("
        SELECT c.*, uc.progress, uc.last_accessed
        FROM courses c
        JOIN user_courses uc ON c.id = uc.course_id
        WHERE uc.user_id = ? AND uc.status = 'active'
        ORDER BY uc.last_accessed DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $activeCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get completed courses
    $stmt = $conn->prepare("
        SELECT c.*, uc.completion_date
        FROM courses c
        JOIN user_courses uc ON c.id = uc.course_id
        WHERE uc.user_id = ? AND uc.status = 'completed'
        ORDER BY uc.completion_date DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $completedCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get in-progress courses
    $stmt = $conn->prepare("
        SELECT c.*, uc.progress, uc.last_accessed
        FROM courses c
        JOIN user_courses uc ON c.id = uc.course_id
        WHERE uc.user_id = ? AND uc.status = 'in_progress'
        ORDER BY uc.last_accessed DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $inProgressCourses = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

} catch (PDOException $e) {
    error_log("Error fetching courses: " . $e->getMessage());
    $error = "An error occurred while loading your courses. Our team has been notified.";
}

ob_start();
?>

<div class="content-wrapper">
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="stats-value"><?php echo count($activeCourses); ?></div>
            <div class="stats-label">Active Courses</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stats-value"><?php echo count($completedCourses); ?></div>
            <div class="stats-label">Completed Courses</div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value"><?php echo count($inProgressCourses); ?></div>
            <div class="stats-label">In Progress</div>
        </div>

        <?php
        // Calculate total study hours
        $totalHours = 0;
        foreach (array_merge($activeCourses, $completedCourses, $inProgressCourses) as $course) {
            $totalHours += isset($course['duration_hours']) ? $course['duration_hours'] : 0;
        }
        ?>
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stats-value"><?php echo $totalHours; ?></div>
            <div class="stats-label">Total Study Hours</div>
        </div>
    </div>

    <!-- Active Courses -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">Active Courses</h5>
            <a href="../academy.php" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-2"></i>Explore Academy
            </a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Progress</th>
                        <th>Last Accessed</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($activeCourses)): ?>
                        <?php foreach ($activeCourses as $course): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="../img/courses/<?php echo strtolower(str_replace(' ', '-', $course['name'])); ?>.jpg" 
                                             class="me-3" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" 
                                             alt="<?php echo htmlspecialchars($course['name']); ?>">
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($course['name']); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($course['category'] ?? 'Course'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress" style="width: 100px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: <?php echo $course['progress'] ?? 0; ?>%"></div>
                                    </div>
                                    <small class="text-muted"><?php echo $course['progress'] ?? 0; ?>% Complete</small>
                                </td>
                                <td>
                                    <?php if ($course['last_accessed']): ?>
                                        <?php echo date('M d, Y', strtotime($course['last_accessed'])); ?>
                                        <br>
                                        <small class="text-muted"><?php echo date('h:i A', strtotime($course['last_accessed'])); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">Not started</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="course.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-play me-2"></i>Continue
                                        </a>
                                        <a href="course-details.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-primary ms-2">
                                            <i class="fas fa-info-circle me-2"></i>Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-book-open fa-2x text-muted mb-3"></i>
                                <p class="mb-0">You haven't enrolled in any courses yet.</p>
                                <a href="../academy.php" class="btn btn-sm btn-primary mt-3">
                                    Explore Academy
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Completed Courses -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">Completed Courses</h5>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Completion Date</th>
                        <th>Certificate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($completedCourses)): ?>
                        <?php foreach ($completedCourses as $course): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="../img/courses/<?php echo strtolower(str_replace(' ', '-', $course['name'])); ?>.jpg" 
                                             class="me-3" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" 
                                             alt="<?php echo htmlspecialchars($course['name']); ?>">
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($course['name']); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($course['category'] ?? 'Course'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo date('M d, Y', strtotime($course['completion_date'])); ?>
                                    <br>
                                    <small class="text-muted"><?php echo date('h:i A', strtotime($course['completion_date'])); ?></small>
                                </td>
                                <td>
                                    <a href="download-certificate.php?course_id=<?php echo $course['id']; ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="course.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-redo me-2"></i>Review
                                        </a>
                                        <a href="course-details.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-primary ms-2">
                                            <i class="fas fa-info-circle me-2"></i>Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-graduation-cap fa-2x text-muted mb-3"></i>
                                <p class="mb-0">You haven't completed any courses yet.</p>
                                <p class="text-muted">Keep learning and you'll get there!</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- In Progress Courses -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">In Progress</h5>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Progress</th>
                        <th>Last Accessed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($inProgressCourses)): ?>
                        <?php foreach ($inProgressCourses as $course): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="../img/courses/<?php echo strtolower(str_replace(' ', '-', $course['name'])); ?>.jpg" 
                                             class="me-3" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" 
                                             alt="<?php echo htmlspecialchars($course['name']); ?>">
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($course['name']); ?></h6>
                                            <small class="text-muted"><?php echo htmlspecialchars($course['category'] ?? 'Course'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress" style="width: 100px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: <?php echo $course['progress'] ?? 0; ?>%"></div>
                                    </div>
                                    <small class="text-muted"><?php echo $course['progress'] ?? 0; ?>% Complete</small>
                                </td>
                                <td>
                                    <?php if ($course['last_accessed']): ?>
                                        <?php echo date('M d, Y', strtotime($course['last_accessed'])); ?>
                                        <br>
                                        <small class="text-muted"><?php echo date('h:i A', strtotime($course['last_accessed'])); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">Not started</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="course.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-play me-2"></i>Continue
                                        </a>
                                        <a href="course-details.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-primary ms-2">
                                            <i class="fas fa-info-circle me-2"></i>Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-clock fa-2x text-muted mb-3"></i>
                                <p class="mb-0">No courses in progress.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../includes/user_portal_template.php';
?> 