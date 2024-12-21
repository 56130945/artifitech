<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth_check.php';

// Set page-specific variables
$page = 'profile';
$title = "My Profile - Artifitech";

// Initialize variables with default values
$user = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'country' => '',
    'city' => '',
    'created_at' => date('Y-m-d H:i:s'),
    'email_verified' => false,
    'two_factor_enabled' => false,
    'email_notifications' => false,
    'marketing_emails' => false,
    'password_changed_at' => null
];
$error = null;
$success = null;

// Get user data
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("
        SELECT *
        FROM users
        WHERE id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Merge fetched data with defaults
    if ($userData) {
        $user = array_merge($user, $userData);
    }
} catch (PDOException $e) {
    error_log("Error fetching user data: " . $e->getMessage());
    $error = "An error occurred while loading your profile. Our team has been notified.";
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        try {
            $stmt = $conn->prepare("
                UPDATE users 
                SET name = ?, email = ?, phone = ?, country = ?, city = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $_POST['name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['country'],
                $_POST['city'],
                $_SESSION['user_id']
            ]);
            $success = "Profile updated successfully!";
            
            // Refresh user data
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($userData) {
                $user = array_merge($user, $userData);
            }
        } catch (PDOException $e) {
            error_log("Error updating profile: " . $e->getMessage());
            $error = "An error occurred while updating your profile.";
        }
    }
}

ob_start();
?>

<div class="content-wrapper">
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Profile Overview -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="../img/user.jpg" alt="Profile Picture" 
                         class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="my-3"><?php echo htmlspecialchars($user['name']); ?></h5>
                    <p class="text-muted mb-4">
                        <?php 
                        $location = array_filter([$user['city'], $user['country']]);
                        echo $location ? htmlspecialchars(implode(', ', $location)) : 'Location not set';
                        ?>
                    </p>
                    <div class="d-flex justify-content-center mb-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                            <i class="fas fa-camera me-2"></i>Change Photo
                        </button>
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">Account Status</h6>
                    <div class="mb-3">
                        <span class="badge bg-success mb-2">Active</span>
                        <p class="text-muted mb-0">Member since <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-2">Email Verification</h6>
                        <?php if ($user['email_verified']): ?>
                            <span class="badge bg-success">Verified</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Pending</span>
                            <a href="verify-email.php" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-envelope me-2"></i>Verify Now
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" 
                                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" 
                                       value="<?php echo htmlspecialchars($user['phone']); ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" 
                                       value="<?php echo htmlspecialchars($user['country']); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" 
                                       value="<?php echo htmlspecialchars($user['city']); ?>">
                            </div>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Security Settings</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">Password</h6>
                                <p class="text-muted mb-0">Last changed <?php echo date('M d, Y', strtotime($user['password_changed_at'] ?? $user['created_at'])); ?></p>
                            </div>
                            <a href="change-password.php" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i>Change Password
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Two-Factor Authentication</h6>
                                <p class="text-muted mb-0">Add an extra layer of security to your account</p>
                            </div>
                            <?php if ($user['two_factor_enabled']): ?>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#disable2FAModal">
                                    <i class="fas fa-shield-alt me-2"></i>Disable 2FA
                                </button>
                            <?php else: ?>
                                <a href="setup-2fa.php" class="btn btn-primary">
                                    <i class="fas fa-shield-alt me-2"></i>Enable 2FA
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Active Sessions</h6>
                                <p class="text-muted mb-0">Manage your active login sessions</p>
                            </div>
                            <a href="active-sessions.php" class="btn btn-primary">
                                <i class="fas fa-desktop me-2"></i>View Sessions
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Preferences -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Notification Preferences</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="update-notifications.php">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" 
                                       name="email_notifications" <?php echo $user['email_notifications'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="emailNotifications">Email Notifications</label>
                            </div>
                            <small class="text-muted">Receive updates about your courses, subscriptions, and account activity</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="marketingEmails" 
                                       name="marketing_emails" <?php echo $user['marketing_emails'] ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="marketingEmails">Marketing Emails</label>
                            </div>
                            <small class="text-muted">Receive updates about new courses, features, and special offers</small>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-bell me-2"></i>Update Preferences
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Photo Modal -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="upload-photo.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Choose Photo</label>
                        <input type="file" class="form-control" name="photo" accept="image/*" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Disable 2FA Modal -->
<div class="modal fade" id="disable2FAModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Disable Two-Factor Authentication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to disable two-factor authentication? This will make your account less secure.</p>
                <form action="disable-2fa.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Enter your password to confirm</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Disable 2FA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../includes/user_portal_template.php';
?> 