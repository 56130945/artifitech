<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'settings';
$title = "System Settings - Artifitech Admin";
$description = "Configure system settings and preferences";

// Initialize variables
$settings = [];
$error = null;
$success = null;

try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Handle settings update
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST['settings'] as $key => $value) {
            $stmt = $conn->prepare("
                UPDATE admin_settings 
                SET setting_value = ?, 
                    updated_by = ?, 
                    updated_at = NOW() 
                WHERE setting_key = ?
            ");
            $stmt->execute([$value, $_SESSION['user_id'], $key]);
        }
        $success = "Settings updated successfully";
    }

    // Get current settings
    $stmt = $conn->query("
        SELECT 
            s.*, 
            CONCAT(a.first_name, ' ', a.last_name) as updated_by_name
        FROM admin_settings s
        LEFT JOIN administrators a ON s.updated_by = a.id
        ORDER BY s.id ASC
    ");
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    error_log("Error in settings.php: " . $e->getMessage());
    $error = "An error occurred while managing settings.";
}

// Start output buffering
ob_start();
?>

<!-- Page Header Start -->
<div class="page-header wow fadeIn" data-wow-delay="0.1s">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="display-6 text-white mb-0">System Settings</h1>
            <p class="text-white-50 mb-0">Configure system settings and preferences</p>
        </div>
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

<!-- Settings Form Start -->
<div class="card border-0 shadow-sm wow fadeInUp" data-wow-delay="0.1s">
    <div class="card-body">
        <form method="POST" id="settingsForm">
            <?php foreach ($settings as $setting): ?>
            <div class="mb-4">
                <label class="form-label fw-bold">
                    <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $setting['setting_key']))); ?>
                </label>
                
                <?php if ($setting['setting_key'] === 'maintenance_mode'): ?>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="settings[maintenance_mode]" 
                               value="1" <?php echo $setting['setting_value'] == '1' ? 'checked' : ''; ?>>
                        <label class="form-check-label">Enable Maintenance Mode</label>
                    </div>
                <?php elseif ($setting['setting_key'] === 'allowed_file_types'): ?>
                    <input type="text" class="form-control" name="settings[allowed_file_types]"
                           value="<?php echo htmlspecialchars($setting['setting_value']); ?>"
                           placeholder="e.g., jpg,jpeg,png,pdf">
                <?php else: ?>
                    <input type="text" class="form-control" 
                           name="settings[<?php echo htmlspecialchars($setting['setting_key']); ?>]"
                           value="<?php echo htmlspecialchars($setting['setting_value']); ?>">
                <?php endif; ?>
                
                <div class="mt-2">
                    <small class="text-muted">
                        <?php echo htmlspecialchars($setting['setting_description']); ?>
                    </small>
                </div>
                <?php if ($setting['updated_by']): ?>
                <div class="mt-1">
                    <small class="text-muted">
                        Last updated by <?php echo htmlspecialchars($setting['updated_by_name']); ?> 
                        on <?php echo date('M d, Y H:i', strtotime($setting['updated_at'])); ?>
                    </small>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-light me-md-2">Reset Changes</button>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.form-label {
    color: #2124B1;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    border-color: #4777F5;
    box-shadow: 0 0 0 0.2rem rgba(71, 119, 245, 0.25);
}

.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
    margin-top: 0.25em;
}

.form-switch .form-check-input:checked {
    background-color: #4777F5;
    border-color: #4777F5;
}

.btn-primary {
    background-color: #4777F5;
    border-color: #4777F5;
}

.btn-primary:hover {
    background-color: #2124B1;
    border-color: #2124B1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store initial form values
    const initialFormData = new FormData(document.getElementById('settingsForm'));
    
    // Handle form reset
    document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to reset all changes?')) {
            for (let pair of initialFormData.entries()) {
                const input = document.querySelector(`[name="${pair[0]}"]`);
                if (input) {
                    if (input.type === 'checkbox') {
                        input.checked = pair[1] === '1';
                    } else {
                        input.value = pair[1];
                    }
                }
            }
        }
    });
    
    // Handle form submit
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        const maintenanceMode = document.querySelector('input[name="settings[maintenance_mode]"]');
        if (maintenanceMode && maintenanceMode.checked) {
            if (!confirm('Enabling maintenance mode will make the site inaccessible to users. Are you sure?')) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 