<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'settings';
$title = "System Settings - Artifitech Admin";
$description = "Manage system settings and configurations";

// Initialize variables
$error = null;
$success = null;

// Get current settings
try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
    
    // Fetch all settings
    $stmt = $conn->query("SELECT * FROM admin_settings");
    $settings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
} catch (Exception $e) {
    error_log("Error in settings.php: " . $e->getMessage());
    $error = "An error occurred while fetching settings.";
}

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }
        
        // Start transaction
        $conn->beginTransaction();
        
        // Update general settings
        if (isset($_POST['general_settings'])) {
            $stmt = $conn->prepare("UPDATE admin_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
            
            // Site Name
            $stmt->execute([$_POST['site_name'], 'site_name']);
            
            // Items per page
            $stmt->execute([$_POST['items_per_page'], 'items_per_page']);
            
            // Maintenance mode
            $maintenance_mode = isset($_POST['maintenance_mode']) ? '1' : '0';
            $stmt->execute([$maintenance_mode, 'maintenance_mode']);
        }
        
        // Update email settings
        if (isset($_POST['email_settings'])) {
            $stmt = $conn->prepare("UPDATE admin_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
            
            // SMTP settings
            $stmt->execute([$_POST['smtp_host'], 'smtp_host']);
            $stmt->execute([$_POST['smtp_port'], 'smtp_port']);
            $stmt->execute([$_POST['smtp_user'], 'smtp_user']);
            if (!empty($_POST['smtp_password'])) {
                $stmt->execute([password_hash($_POST['smtp_password'], PASSWORD_DEFAULT), 'smtp_password']);
            }
        }
        
        // Update security settings
        if (isset($_POST['security_settings'])) {
            $stmt = $conn->prepare("UPDATE admin_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
            
            // Password policy
            $stmt->execute([$_POST['min_password_length'], 'min_password_length']);
            $password_complexity = isset($_POST['require_complex_password']) ? '1' : '0';
            $stmt->execute([$password_complexity, 'require_complex_password']);
            
            // Session timeout
            $stmt->execute([$_POST['session_timeout'], 'session_timeout']);
        }
        
        // Update file settings
        if (isset($_POST['file_settings'])) {
            $stmt = $conn->prepare("UPDATE admin_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
            
            // Allowed file types
            $allowed_types = implode(',', $_POST['allowed_file_types']);
            $stmt->execute([$allowed_types, 'allowed_file_types']);
            
            // Max file size
            $stmt->execute([$_POST['max_file_size'], 'max_file_size']);
        }
        
        // Commit transaction
        $conn->commit();
        
        $success = "Settings updated successfully.";
        
        // Refresh settings
        $stmt = $conn->query("SELECT * FROM admin_settings");
        $settings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Error updating settings: " . $e->getMessage());
        $error = "An error occurred while updating settings.";
    }
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

<!-- Settings Navigation -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <ul class="nav nav-pills nav-fill" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#general" type="button">
                            <i class="fas fa-cog me-2"></i>General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#email" type="button">
                            <i class="fas fa-envelope me-2"></i>Email
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#security" type="button">
                            <i class="fas fa-shield-alt me-2"></i>Security
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#files" type="button">
                            <i class="fas fa-file me-2"></i>Files
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#backup" type="button">
                            <i class="fas fa-database me-2"></i>Backup
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#api" type="button">
                            <i class="fas fa-plug me-2"></i>API
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Settings Content -->
<div class="tab-content" id="settingsTabContent">
    <!-- General Settings -->
    <div class="tab-pane fade show active" id="general" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">General Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="general_settings" value="1">
                    
                    <div class="col-md-6">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" 
                               value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>" required>
                        <small class="text-muted">The name of your site displayed in the admin panel</small>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Items per Page</label>
                        <input type="number" name="items_per_page" class="form-control" 
                               value="<?php echo htmlspecialchars($settings['items_per_page'] ?? '10'); ?>" required>
                        <small class="text-muted">Number of items to display in tables</small>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="maintenance_mode" class="form-check-input" 
                                   <?php echo ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : ''; ?>>
                            <label class="form-check-label">Maintenance Mode</label>
                        </div>
                        <small class="text-muted">Enable to show maintenance page to users</small>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save General Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Email Settings -->
    <div class="tab-pane fade" id="email" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Email Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="email_settings" value="1">
                    
                    <div class="col-md-6">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" name="smtp_host" class="form-control" 
                               value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">SMTP Port</label>
                        <input type="number" name="smtp_port" class="form-control" 
                               value="<?php echo htmlspecialchars($settings['smtp_port'] ?? '587'); ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">SMTP Username</label>
                        <input type="text" name="smtp_user" class="form-control" 
                               value="<?php echo htmlspecialchars($settings['smtp_user'] ?? ''); ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">SMTP Password</label>
                        <input type="password" name="smtp_password" class="form-control" 
                               placeholder="Leave blank to keep current password">
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Email Settings
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="testEmailSettings()">
                            <i class="fas fa-paper-plane me-1"></i> Test Email Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Security Settings -->
    <div class="tab-pane fade" id="security" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Security Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="security_settings" value="1">
                    
                    <div class="col-md-6">
                        <label class="form-label">Minimum Password Length</label>
                        <input type="number" name="min_password_length" class="form-control" 
                               value="<?php echo htmlspecialchars($settings['min_password_length'] ?? '8'); ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Session Timeout (minutes)</label>
                        <input type="number" name="session_timeout" class="form-control" 
                               value="<?php echo htmlspecialchars($settings['session_timeout'] ?? '30'); ?>">
                    </div>
                    
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="require_complex_password" class="form-check-input" 
                                   <?php echo ($settings['require_complex_password'] ?? '1') === '1' ? 'checked' : ''; ?>>
                            <label class="form-check-label">Require Complex Passwords</label>
                        </div>
                        <small class="text-muted">Require uppercase, lowercase, numbers, and special characters</small>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Security Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- File Settings -->
    <div class="tab-pane fade" id="files" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">File Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="file_settings" value="1">
                    
                    <div class="col-12">
                        <label class="form-label">Allowed File Types</label>
                        <div class="row g-3">
                            <?php
                            $allowed_types = explode(',', $settings['allowed_file_types'] ?? 'jpg,jpeg,png,pdf');
                            $file_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip'];
                            foreach ($file_types as $type):
                            ?>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input type="checkbox" name="allowed_file_types[]" value="<?php echo $type; ?>" 
                                           class="form-check-input" <?php echo in_array($type, $allowed_types) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">.<?php echo $type; ?></label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Maximum File Size (MB)</label>
                        <input type="number" name="max_file_size" class="form-control" 
                               value="<?php echo htmlspecialchars(($settings['max_file_size'] ?? 5242880) / 1048576); ?>">
                        <small class="text-muted">Maximum file size in megabytes</small>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save File Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Backup Settings -->
    <div class="tab-pane fade" id="backup" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Backup & Maintenance</h5>
                    <button type="button" class="btn btn-primary" onclick="createBackup()">
                        <i class="fas fa-download me-1"></i> Create Backup
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Backup File</th>
                                <th>Size</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-muted mb-0">No backups available</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- API Settings -->
    <div class="tab-pane fade" id="api" role="tabpanel">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">API Settings</h5>
                    <button type="button" class="btn btn-primary" onclick="generateApiKey()">
                        <i class="fas fa-key me-1"></i> Generate New API Key
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="api_settings" value="1">
                    
                    <div class="col-12">
                        <label class="form-label">API Key</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo $settings['api_key'] ?? 'No API key generated'; ?>" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyApiKey(this)">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="api_enabled" class="form-check-input" 
                                   <?php echo ($settings['api_enabled'] ?? '0') === '1' ? 'checked' : ''; ?>>
                            <label class="form-check-label">Enable API Access</label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save API Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Test email settings
function testEmailSettings() {
    // Implementation for testing email settings
}

// Create backup
function createBackup() {
    // Implementation for creating backup
}

// Generate API key
function generateApiKey() {
    // Implementation for generating API key
}

// Copy API key
function copyApiKey(button) {
    const input = button.previousElementSibling;
    input.select();
    document.execCommand('copy');
    
    // Show copied tooltip
    const tooltip = bootstrap.Tooltip.getInstance(button) || 
                   new bootstrap.Tooltip(button, {title: 'Copied!', trigger: 'manual'});
    tooltip.show();
    setTimeout(() => tooltip.hide(), 1000);
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

.nav-pills .nav-link {
    color: #6c757d;
    padding: 1rem;
    border-radius: 0;
}

.nav-pills .nav-link:hover {
    color: #4777F5;
}

.nav-pills .nav-link.active {
    background-color: transparent;
    color: #4777F5;
    border-bottom: 2px solid #4777F5;
}

.form-label {
    font-weight: 500;
    color: #2124B1;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 0.75rem 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #4777F5;
    box-shadow: 0 0 0 0.2rem rgba(71, 119, 245, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
}

.form-check-input:checked {
    background-color: #4777F5;
    border-color: #4777F5;
}

.table th {
    font-weight: 600;
    color: #2124B1;
}

.bg-primary, .btn-primary {
    background-color: #4777F5 !important;
}

.text-primary {
    color: #4777F5 !important;
}
</style>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 