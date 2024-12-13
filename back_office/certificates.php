<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'certificates';
$title = "Certificate Management - Artifitech Admin";
$description = "Manage course completion certificates";

// Initialize variables
$certificates = [];
$error = null;
$success = null;
$total_pages = 1;

// Get certificates list with pagination
$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page_number - 1) * $items_per_page;

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Get total certificates count
    $stmt = $conn->query("
        SELECT COUNT(*) 
        FROM course_certificates cc
        JOIN customers c ON cc.user_id = c.id
        JOIN courses co ON cc.course_id = co.id
    ");
    
    if ($stmt) {
        $total_certificates = $stmt->fetchColumn();
        $total_pages = ceil($total_certificates / $items_per_page);
    }
    
    // Get certificates for current page
    $stmt = $conn->prepare("
        SELECT 
            cc.*,
            c.first_name,
            c.last_name,
            c.email,
            co.name as course_name,
            co.code as course_code
        FROM course_certificates cc
        JOIN customers c ON cc.user_id = c.id
        JOIN courses co ON cc.course_id = co.id
        ORDER BY cc.issued_date DESC
        LIMIT ? OFFSET ?
    ");
    
    if ($stmt->execute([$items_per_page, $offset])) {
        $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
} catch (Exception $e) {
    error_log("Error in certificates.php: " . $e->getMessage());
    $error = "An error occurred while fetching certificates.";
}

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="page-header wow fadeIn" data-wow-delay="0.1s">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="display-6 text-white mb-0">Certificate Management</h1>
            <p class="text-white-50 mb-0">View and manage course completion certificates</p>
        </div>
        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#generateCertificateModal">
            <i class="fas fa-plus me-2"></i>Generate Certificate
        </button>
    </div>
</div>

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

<!-- Certificates Table Start -->
<div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.1s">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Certificate ID</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Issue Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($certificates)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted mb-0">No certificates found</p>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($certificates as $cert): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cert['certificate_number'] ?? 'N/A'); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <?php 
                                        $first = $cert['first_name'] ? substr($cert['first_name'], 0, 1) : '';
                                        $last = $cert['last_name'] ? substr($cert['last_name'], 0, 1) : '';
                                        echo strtoupper($first . $last); 
                                    ?>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        <?php 
                                            $fullName = trim(($cert['first_name'] ?? '') . ' ' . ($cert['last_name'] ?? ''));
                                            echo htmlspecialchars($fullName ?: 'N/A'); 
                                        ?>
                                    </h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($cert['email'] ?? ''); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <h6 class="mb-0"><?php echo htmlspecialchars($cert['course_name'] ?? 'N/A'); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($cert['course_code'] ?? ''); ?></small>
                            </div>
                        </td>
                        <td><?php echo $cert['issued_date'] ? date('M d, Y', strtotime($cert['issued_date'])) : 'N/A'; ?></td>
                        <td>
                            <?php if ($cert['is_valid'] == 1): ?>
                                <span class="badge bg-success">Valid</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Revoked</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="view-certificate.php?id=<?php echo $cert['id']; ?>" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="View Certificate">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="download-certificate.php?id=<?php echo $cert['id']; ?>" 
                                   class="btn btn-sm btn-outline-success" 
                                   title="Download Certificate">
                                    <i class="fas fa-download"></i>
                                </a>
                                <?php if ($cert['is_valid'] == 1): ?>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to revoke this certificate?');">
                                    <input type="hidden" name="certificate_id" value="<?php echo $cert['id']; ?>">
                                    <input type="hidden" name="action" value="revoke">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Revoke Certificate">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                <?php else: ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="certificate_id" value="<?php echo $cert['id']; ?>">
                                    <input type="hidden" name="action" value="reinstate">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Reinstate Certificate">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
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