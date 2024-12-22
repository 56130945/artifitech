<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

$response = ['success' => false, 'html' => '', 'message' => ''];

try {
    if (!isset($_GET['id'])) {
        throw new Exception('User ID is required');
    }

    $userId = $_GET['id'];
    $conn = getDBConnection();

    // Fetch user details
    $stmt = $conn->prepare("
        SELECT c.*, 
               COUNT(o.id) as total_orders,
               SUM(CASE WHEN o.status = 'completed' THEN 1 ELSE 0 END) as completed_orders,
               MAX(o.created_at) as last_order_date
        FROM customers c
        LEFT JOIN orders o ON c.id = o.customer_id
        WHERE c.id = ?
        GROUP BY c.id
    ");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('User not found');
    }

    // Start building the HTML response
    ob_start();
?>
    <form id="editUserForm" class="needs-validation" novalidate>
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
        
        <div class="row g-3">
            <!-- Basic Information -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" 
                                   value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" 
                                   value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Account Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Account Status</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="is_active" id="accountStatus" 
                                       <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="accountStatus">
                                    Account Active
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" 
                                   placeholder="Leave blank to keep current password">
                            <div class="form-text">Only fill this if you want to change the user's password</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="confirm_password" 
                                   placeholder="Confirm new password">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-1">Total Orders</h6>
                                    <h3 class="mb-0"><?php echo number_format($user['total_orders']); ?></h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-1">Completed Orders</h6>
                                    <h3 class="mb-0"><?php echo number_format($user['completed_orders']); ?></h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-1">Last Order</h6>
                                    <h3 class="mb-0">
                                        <?php 
                                        echo $user['last_order_date'] 
                                            ? date('M d, Y', strtotime($user['last_order_date']))
                                            : 'Never';
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>

    <script>
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate passwords match if either is filled
        const password = this.querySelector('[name="password"]').value;
        const confirmPassword = this.querySelector('[name="confirm_password"]').value;
        
        if (password || confirmPassword) {
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }
        }
        
        // Collect form data
        const formData = new FormData(this);
        formData.append('is_active', this.querySelector('[name="is_active"]').checked ? '1' : '0');
        
        // Submit form
        fetch('update_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to reflect changes
                window.location.reload();
            } else {
                alert(data.message || 'Error updating user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the user');
        });
    });
    </script>
<?php
    $response['html'] = ob_get_clean();
    $response['success'] = true;
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    $response['html'] = '<div class="alert alert-danger">' . htmlspecialchars($e->getMessage()) . '</div>';
}

header('Content-Type: application/json');
echo json_encode($response); 