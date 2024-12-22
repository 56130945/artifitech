<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'users';
$title = "User Management - Artifitech Admin";
$description = "Manage users and their access levels";

// Initialize variables
$users = [];
$error = null;
$success = null;
$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? 'all';
$current_page = max(1, $_GET['page'] ?? 1);
$per_page = 10;
$total_users = 0;
$total_pages = 1;

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Handle user actions (if any)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $userId = $_POST['user_id'] ?? '';

        if (empty($userId)) {
            throw new Exception("User ID is required");
        }

        // Check if user exists
        $stmt = $conn->prepare("SELECT id, email, is_active FROM customers WHERE id = ?");
        $stmt->execute([$userId]);
        $targetUser = $stmt->fetch();

        if (!$targetUser) {
            throw new Exception("User not found");
        }

        switch ($action) {
            case 'delete':
                // Prevent self-deletion
                if ($userId == $_SESSION['user_id']) {
                    throw new Exception("You cannot delete your own account");
                }
                
                // Delete user
                $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
                $stmt->execute([$userId]);
                
                // Log the action
                error_log("Admin {$_SESSION['user_id']} deleted user {$userId}");
                $success = "User deleted successfully";
                break;

            case 'activate':
                if ($targetUser['is_active']) {
                    throw new Exception("User is already active");
                }
                
                $stmt = $conn->prepare("UPDATE customers SET is_active = 1 WHERE id = ?");
                $stmt->execute([$userId]);
                
                error_log("Admin {$_SESSION['user_id']} activated user {$userId}");
                $success = "User activated successfully";
                break;

            case 'deactivate':
                // Prevent self-deactivation
                if ($userId == $_SESSION['user_id']) {
                    throw new Exception("You cannot deactivate your own account");
                }
                
                if (!$targetUser['is_active']) {
                    throw new Exception("User is already inactive");
                }
                
                $stmt = $conn->prepare("UPDATE customers SET is_active = 0 WHERE id = ?");
                $stmt->execute([$userId]);
                
                error_log("Admin {$_SESSION['user_id']} deactivated user {$userId}");
                $success = "User deactivated successfully";
                break;

            case 'bulk_action':
                $selectedUsers = $_POST['selected_users'] ?? [];
                $bulkAction = $_POST['bulk_action'] ?? '';
                
                if (empty($selectedUsers)) {
                    throw new Exception("No users selected");
                }
                
                switch ($bulkAction) {
                    case 'activate':
                        $stmt = $conn->prepare("UPDATE customers SET is_active = 1 WHERE id IN (" . str_repeat('?,', count($selectedUsers)-1) . "?)");
                        $stmt->execute($selectedUsers);
                        $success = "Selected users activated successfully";
                        break;
                    case 'deactivate':
                        $stmt = $conn->prepare("UPDATE customers SET is_active = 0 WHERE id IN (" . str_repeat('?,', count($selectedUsers)-1) . "?) AND id != ?");
                        $params = array_merge($selectedUsers, [$_SESSION['user_id']]);
                        $stmt->execute($params);
                        $success = "Selected users deactivated successfully";
                        break;
                    case 'delete':
                        $stmt = $conn->prepare("DELETE FROM customers WHERE id IN (" . str_repeat('?,', count($selectedUsers)-1) . "?) AND id != ?");
                        $params = array_merge($selectedUsers, [$_SESSION['user_id']]);
                        $stmt->execute($params);
                        $success = "Selected users deleted successfully";
                        break;
                    default:
                        throw new Exception("Invalid bulk action");
                }
                break;

            default:
                throw new Exception("Invalid action");
        }
    }

    // Build search and filter conditions
    $conditions = [];
    $params = [];

    if ($search) {
        $conditions[] = "(first_name LIKE :search OR last_name LIKE :search OR email LIKE :search)";
        $params[':search'] = "%$search%";
    }

    switch ($filter) {
        case 'active':
            $conditions[] = "is_active = 1";
            break;
        case 'inactive':
            $conditions[] = "is_active = 0";
            break;
        case 'recent':
            $conditions[] = "created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            break;
    }

    $where_clause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

    // Calculate total users and pages
    $count_query = "SELECT COUNT(*) FROM customers $where_clause";
    $stmt = $conn->prepare($count_query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $total_users = $stmt->fetchColumn();
    $total_pages = ceil($total_users / $per_page);
    $current_page = min($current_page, max(1, $total_pages));
    $offset = ($current_page - 1) * $per_page;

    // Fetch users with pagination, search, and filter
    $query = "
        SELECT id, first_name, last_name, email, is_active, created_at,
               (SELECT COUNT(*) FROM orders WHERE customer_id = customers.id) as order_count
        FROM customers
        $where_clause
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get user statistics
    $stats = [
        'total' => $conn->query("SELECT COUNT(*) FROM customers")->fetchColumn(),
        'active' => $conn->query("SELECT COUNT(*) FROM customers WHERE is_active = 1")->fetchColumn(),
        'inactive' => $conn->query("SELECT COUNT(*) FROM customers WHERE is_active = 0")->fetchColumn(),
        'recent' => $conn->query("SELECT COUNT(*) FROM customers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn()
    ];

} catch (Exception $e) {
    error_log("Error in users.php: " . $e->getMessage());
    $error = $e->getMessage();
}

// Start output buffering
ob_start();
?>

<!-- Users Management Start -->
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>User Management</h2>
            <p class="text-muted">Manage customer accounts and access levels</p>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus me-2"></i>Add New User
            </button>
        </div>
    </div>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($success); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- User Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <span class="avatar-title bg-primary-subtle rounded">
                                    <i class="fas fa-users text-primary"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Total Users</h6>
                            <p class="mb-0"><?php echo number_format($stats['total']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <span class="avatar-title bg-success-subtle rounded">
                                    <i class="fas fa-user-check text-success"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Active Users</h6>
                            <p class="mb-0"><?php echo number_format($stats['active']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <span class="avatar-title bg-danger-subtle rounded">
                                    <i class="fas fa-user-times text-danger"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Inactive Users</h6>
                            <p class="mb-0"><?php echo number_format($stats['inactive']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <span class="avatar-title bg-info-subtle rounded">
                                    <i class="fas fa-user-clock text-info"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">New Users (30d)</h6>
                            <p class="mb-0"><?php echo number_format($stats['recent']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <form action="" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by name or email" 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <select name="filter" class="form-select" style="width: auto;">
                            <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>All Users</option>
                            <option value="active" <?php echo $filter === 'active' ? 'selected' : ''; ?>>Active Users</option>
                            <option value="inactive" <?php echo $filter === 'inactive' ? 'selected' : ''; ?>>Inactive Users</option>
                            <option value="recent" <?php echo $filter === 'recent' ? 'selected' : ''; ?>>Recent Users</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <?php if ($search || $filter !== 'all'): ?>
                            <a href="users.php" class="btn btn-secondary">Clear</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary" onclick="exportUsers('csv')">
                            <i class="fas fa-download me-2"></i>Export CSV
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="exportUsers('excel')">
                            <i class="fas fa-file-excel me-2"></i>Export Excel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="mb-3">
                <form id="bulkActionForm" method="POST" class="d-flex gap-2">
                    <input type="hidden" name="action" value="bulk_action">
                    <select name="bulk_action" class="form-select" style="width: auto;">
                        <option value="">Bulk Actions</option>
                        <option value="activate">Activate Selected</option>
                        <option value="deactivate">Deactivate Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="submit" class="btn btn-secondary" onclick="return confirmBulkAction()">
                        Apply
                    </button>
                </form>
            </div>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Orders</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <?php echo $search ? 'No users found matching your search.' : 'No users found.'; ?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input user-select" 
                                       name="selected_users[]" value="<?php echo $user['id']; ?>"
                                       <?php echo $user['id'] == $_SESSION['user_id'] ? 'disabled' : ''; ?>>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar avatar-xs">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <?php 
                                                    $initials = strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1));
                                                    echo $initials;
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="far fa-calendar me-2"></i>
                                    <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <?php echo number_format($user['order_count']); ?> orders
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $user['is_active'] ? 'success' : 'danger'; ?>">
                                    <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="viewUserDetails(<?php echo $user['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                        <?php if ($user['is_active']): ?>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                onclick="confirmAction('deactivate', <?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['email']); ?>')">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-success" 
                                                onclick="confirmAction('activate', <?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['email']); ?>')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmAction('delete', <?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['email']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php else: ?>
                                        <span class="badge bg-secondary ms-2">Current User</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <nav aria-label="User list pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $current_page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $filter !== 'all' ? '&filter=' . urlencode($filter) : ''; ?>">
                            Previous
                        </a>
                    </li>
                    
                    <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                    <li class="page-item <?php echo $i === $current_page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $filter !== 'all' ? '&filter=' . urlencode($filter) : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $current_page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?><?php echo $filter !== 'all' ? '&filter=' . urlencode($filter) : ''; ?>">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="add_user.php" method="POST" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Account Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="userDetailsContent">
                    Loading...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Confirmation Modal -->
<div class="modal fade" id="confirmActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="confirmationMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmActionBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for actions -->
<form id="actionForm" method="POST" style="display: none;">
    <input type="hidden" name="action" id="actionType">
    <input type="hidden" name="user_id" id="userId">
</form>

<style>
.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.avatar-xs {
    width: 30px;
    height: 30px;
    font-size: 12px;
}

.avatar-sm {
    width: 36px;
    height: 36px;
    font-size: 14px;
}

.bg-primary-subtle {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

.bg-success-subtle {
    background-color: rgba(var(--bs-success-rgb), 0.1) !important;
}

.bg-danger-subtle {
    background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
}

.bg-info-subtle {
    background-color: rgba(var(--bs-info-rgb), 0.1) !important;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}
</style>

<script>
let actionModal;
let userDetailsModal;
let pendingAction = null;

document.addEventListener('DOMContentLoaded', function() {
    actionModal = new bootstrap.Modal(document.getElementById('confirmActionModal'));
    userDetailsModal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    
    // Handle select all checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.user-select:not(:disabled)').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
});

function confirmAction(action, userId, userEmail) {
    const messages = {
        delete: `Are you sure you want to delete the user "${userEmail}"? This action cannot be undone.`,
        activate: `Are you sure you want to activate the user "${userEmail}"?`,
        deactivate: `Are you sure you want to deactivate the user "${userEmail}"?`
    };

    document.getElementById('confirmationMessage').textContent = messages[action];
    document.getElementById('confirmActionBtn').className = `btn btn-${action === 'delete' ? 'danger' : 'warning'}`;
    
    pendingAction = { action, userId };
    actionModal.show();
}

function confirmBulkAction() {
    const action = document.querySelector('select[name="bulk_action"]').value;
    const selectedUsers = document.querySelectorAll('.user-select:checked');
    
    if (!action) {
        alert('Please select an action');
        return false;
    }
    
    if (selectedUsers.length === 0) {
        alert('Please select at least one user');
        return false;
    }
    
    return confirm(`Are you sure you want to ${action} ${selectedUsers.length} selected users?`);
}

document.getElementById('confirmActionBtn').addEventListener('click', function() {
    if (pendingAction) {
        const form = document.getElementById('actionForm');
        document.getElementById('actionType').value = pendingAction.action;
        document.getElementById('userId').value = pendingAction.userId;
        form.submit();
    }
});

function viewUserDetails(userId) {
    userDetailsModal.show();
    const content = document.getElementById('userDetailsContent');
    content.innerHTML = 'Loading...';
    
    // Fetch user details
    fetch(`get_user_details.php?id=${userId}`)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        })
        .catch(error => {
            content.innerHTML = `<div class="alert alert-danger">Error loading user details: ${error.message}</div>`;
        });
}

function exportUsers(format) {
    const searchParams = new URLSearchParams(window.location.search);
    const search = searchParams.get('search') || '';
    const filter = searchParams.get('filter') || 'all';
    
    window.location.href = `export_users.php?format=${format}&search=${search}&filter=${filter}`;
}
</script>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 