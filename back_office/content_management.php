<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'content';
$title = "Content Management - Artifitech Admin";
$description = "Manage website content and settings";

// Initialize variables
$success = null;
$error = null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'update_homepage':
                // Update homepage content
                $stmt = $conn->prepare("
                    UPDATE site_content 
                    SET 
                        hero_title = ?,
                        hero_subtitle = ?,
                        featured_courses_title = ?,
                        about_section_title = ?,
                        about_section_content = ?,
                        meta_description = ?,
                        meta_keywords = ?
                    WHERE id = 1
                ");
                $stmt->execute([
                    $_POST['hero_title'],
                    $_POST['hero_subtitle'],
                    $_POST['featured_courses_title'],
                    $_POST['about_title'],
                    $_POST['about_content'],
                    $_POST['meta_description'],
                    $_POST['meta_keywords']
                ]);
                $success = "Homepage content updated successfully";
                break;
                
            case 'update_contact':
                // Update contact information
                $stmt = $conn->prepare("
                    UPDATE site_settings 
                    SET 
                        contact_email = ?,
                        contact_phone = ?,
                        contact_address = ?,
                        business_hours = ?,
                        support_email = ?,
                        sales_email = ?
                    WHERE id = 1
                ");
                $stmt->execute([
                    $_POST['contact_email'],
                    $_POST['contact_phone'],
                    $_POST['contact_address'],
                    $_POST['business_hours'],
                    $_POST['support_email'],
                    $_POST['sales_email']
                ]);
                $success = "Contact information updated successfully";
                break;

            case 'update_social':
                // Update social media links
                $stmt = $conn->prepare("
                    UPDATE site_settings 
                    SET 
                        social_facebook = ?,
                        social_twitter = ?,
                        social_instagram = ?,
                        social_linkedin = ?,
                        social_youtube = ?,
                        whatsapp_number = ?
                    WHERE id = 1
                ");
                $stmt->execute([
                    $_POST['facebook_url'],
                    $_POST['twitter_url'],
                    $_POST['instagram_url'],
                    $_POST['linkedin_url'],
                    $_POST['youtube_url'],
                    $_POST['whatsapp_number']
                ]);
                $success = "Social media links updated successfully";
                break;

            case 'update_seo':
                // Update SEO settings
                $stmt = $conn->prepare("
                    UPDATE site_settings 
                    SET 
                        google_analytics_id = ?,
                        google_tag_manager = ?,
                        facebook_pixel = ?,
                        default_meta_description = ?,
                        default_meta_keywords = ?
                    WHERE id = 1
                ");
                $stmt->execute([
                    $_POST['google_analytics_id'],
                    $_POST['google_tag_manager'],
                    $_POST['facebook_pixel'],
                    $_POST['default_meta_description'],
                    $_POST['default_meta_keywords']
                ]);
                $success = "SEO settings updated successfully";
                break;

            case 'add_page':
                // Add new custom page
                $stmt = $conn->prepare("
                    INSERT INTO pages (
                        title,
                        slug,
                        content,
                        meta_description,
                        meta_keywords,
                        status,
                        created_at
                    ) VALUES (?, ?, ?, ?, ?, ?, NOW())
                ");
                $stmt->execute([
                    $_POST['page_title'],
                    $_POST['page_slug'],
                    $_POST['page_content'],
                    $_POST['page_meta_description'],
                    $_POST['page_meta_keywords'],
                    $_POST['page_status']
                ]);
                $success = "New page created successfully";
                break;
        }
    } catch (Exception $e) {
        error_log("Error in content management: " . $e->getMessage());
        $error = "An error occurred while updating the content";
    }
}

// Get current content
try {
    $conn = getDBConnection();
    
    // Get homepage content
    $stmt = $conn->query("SELECT * FROM site_content WHERE id = 1");
    $homepage_content = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get site settings
    $stmt = $conn->query("SELECT * FROM site_settings WHERE id = 1");
    $site_settings = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get custom pages
    $stmt = $conn->query("SELECT * FROM pages ORDER BY created_at DESC");
    $custom_pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log("Error fetching content: " . $e->getMessage());
    $error = "An error occurred while loading the content";
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

<!-- Content Management Header -->
<div class="content-header mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="h3 mb-0">Content Management</h1>
            <p class="text-muted mb-0">Manage your website content and settings</p>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPageModal">
                <i class="fas fa-plus me-2"></i>Add New Page
            </button>
        </div>
    </div>
</div>

<!-- Content Management Tabs -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#homepage">
                    <i class="fas fa-home me-2"></i>Homepage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#pages">
                    <i class="fas fa-file-alt me-2"></i>Pages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#contact">
                    <i class="fas fa-address-book me-2"></i>Contact Info
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#social">
                    <i class="fas fa-share-alt me-2"></i>Social Media
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#seo">
                    <i class="fas fa-search me-2"></i>SEO Settings
                </a>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <!-- Homepage Content -->
            <div class="tab-pane fade show active" id="homepage">
                <form method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="update_homepage">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Hero Section</h5>
                            <div class="mb-3">
                                <label class="form-label">Hero Title</label>
                                <input type="text" class="form-control" name="hero_title" 
                                       value="<?php echo htmlspecialchars($homepage_content['hero_title'] ?? ''); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Hero Subtitle</label>
                                <textarea class="form-control" name="hero_subtitle" rows="2" required><?php 
                                    echo htmlspecialchars($homepage_content['hero_subtitle'] ?? ''); 
                                ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3">Featured Section</h5>
                            <div class="mb-3">
                                <label class="form-label">Featured Courses Title</label>
                                <input type="text" class="form-control" name="featured_courses_title" 
                                       value="<?php echo htmlspecialchars($homepage_content['featured_courses_title'] ?? ''); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">About Section</h5>
                            <div class="mb-3">
                                <label class="form-label">About Section Title</label>
                                <input type="text" class="form-control" name="about_title" 
                                       value="<?php echo htmlspecialchars($homepage_content['about_section_title'] ?? ''); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">About Section Content</label>
                                <textarea class="form-control rich-editor" name="about_content" rows="4" required><?php 
                                    echo htmlspecialchars($homepage_content['about_section_content'] ?? ''); 
                                ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">SEO Settings</h5>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="2"><?php 
                                    echo htmlspecialchars($homepage_content['meta_description'] ?? ''); 
                                ?></textarea>
                                <small class="text-muted">Recommended length: 150-160 characters</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" 
                                       value="<?php echo htmlspecialchars($homepage_content['meta_keywords'] ?? ''); ?>">
                                <small class="text-muted">Separate keywords with commas</small>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </form>
            </div>

            <!-- Pages Tab -->
            <div class="tab-pane fade" id="pages">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($custom_pages as $page): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($page['title']); ?></td>
                                <td><code><?php echo htmlspecialchars($page['slug']); ?></code></td>
                                <td>
                                    <span class="badge bg-<?php echo $page['status'] === 'published' ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($page['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($page['created_at'])); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="editPage(<?php echo $page['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="deletePage(<?php echo $page['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="tab-pane fade" id="contact">
                <form method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="update_contact">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Primary Contact</h5>
                            <div class="mb-3">
                                <label class="form-label">Main Email</label>
                                <input type="email" class="form-control" name="contact_email" 
                                       value="<?php echo htmlspecialchars($site_settings['contact_email'] ?? ''); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="contact_phone" 
                                       value="<?php echo htmlspecialchars($site_settings['contact_phone'] ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3">Department Emails</h5>
                            <div class="mb-3">
                                <label class="form-label">Support Email</label>
                                <input type="email" class="form-control" name="support_email" 
                                       value="<?php echo htmlspecialchars($site_settings['support_email'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Sales Email</label>
                                <input type="email" class="form-control" name="sales_email" 
                                       value="<?php echo htmlspecialchars($site_settings['sales_email'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Location & Hours</h5>
                            <div class="mb-3">
                                <label class="form-label">Physical Address</label>
                                <textarea class="form-control" name="contact_address" rows="3" required><?php 
                                    echo htmlspecialchars($site_settings['contact_address'] ?? ''); 
                                ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Business Hours</label>
                                <input type="text" class="form-control" name="business_hours" 
                                       value="<?php echo htmlspecialchars($site_settings['business_hours'] ?? ''); ?>"
                                       placeholder="e.g., Mon-Fri: 9:00 AM - 5:00 PM">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </form>
            </div>

            <!-- Social Media -->
            <div class="tab-pane fade" id="social">
                <form method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="update_social">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Social Media Links</h5>
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-facebook text-primary me-2"></i>Facebook URL
                                </label>
                                <input type="url" class="form-control" name="facebook_url" 
                                       value="<?php echo htmlspecialchars($site_settings['social_facebook'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-twitter text-info me-2"></i>Twitter URL
                                </label>
                                <input type="url" class="form-control" name="twitter_url" 
                                       value="<?php echo htmlspecialchars($site_settings['social_twitter'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-instagram text-danger me-2"></i>Instagram URL
                                </label>
                                <input type="url" class="form-control" name="instagram_url" 
                                       value="<?php echo htmlspecialchars($site_settings['social_instagram'] ?? ''); ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3">Additional Social Links</h5>
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-linkedin text-primary me-2"></i>LinkedIn URL
                                </label>
                                <input type="url" class="form-control" name="linkedin_url" 
                                       value="<?php echo htmlspecialchars($site_settings['social_linkedin'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-youtube text-danger me-2"></i>YouTube URL
                                </label>
                                <input type="url" class="form-control" name="youtube_url" 
                                       value="<?php echo htmlspecialchars($site_settings['social_youtube'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fab fa-whatsapp text-success me-2"></i>WhatsApp Number
                                </label>
                                <input type="text" class="form-control" name="whatsapp_number" 
                                       value="<?php echo htmlspecialchars($site_settings['whatsapp_number'] ?? ''); ?>"
                                       placeholder="e.g., +27123456789">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </form>
            </div>

            <!-- SEO Settings -->
            <div class="tab-pane fade" id="seo">
                <form method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="update_seo">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Tracking Codes</h5>
                            <div class="mb-3">
                                <label class="form-label">Google Analytics ID</label>
                                <input type="text" class="form-control" name="google_analytics_id" 
                                       value="<?php echo htmlspecialchars($site_settings['google_analytics_id'] ?? ''); ?>"
                                       placeholder="e.g., UA-XXXXXXXXX-X">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Google Tag Manager</label>
                                <input type="text" class="form-control" name="google_tag_manager" 
                                       value="<?php echo htmlspecialchars($site_settings['google_tag_manager'] ?? ''); ?>"
                                       placeholder="e.g., GTM-XXXXXX">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Facebook Pixel ID</label>
                                <input type="text" class="form-control" name="facebook_pixel" 
                                       value="<?php echo htmlspecialchars($site_settings['facebook_pixel'] ?? ''); ?>"
                                       placeholder="e.g., XXXXXXXXXXXXXXXXXX">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3">Default Meta Tags</h5>
                            <div class="mb-3">
                                <label class="form-label">Default Meta Description</label>
                                <textarea class="form-control" name="default_meta_description" rows="3"><?php 
                                    echo htmlspecialchars($site_settings['default_meta_description'] ?? ''); 
                                ?></textarea>
                                <small class="text-muted">Used when page-specific description is not set</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Default Meta Keywords</label>
                                <input type="text" class="form-control" name="default_meta_keywords" 
                                       value="<?php echo htmlspecialchars($site_settings['default_meta_keywords'] ?? ''); ?>">
                                <small class="text-muted">Separate keywords with commas</small>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Page Modal -->
<div class="modal fade" id="addPageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Page</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="add_page">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Page Title</label>
                        <input type="text" class="form-control" name="page_title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">URL Slug</label>
                        <input type="text" class="form-control" name="page_slug" required>
                        <small class="text-muted">This will be the URL of your page (e.g., about-us)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Page Content</label>
                        <textarea class="form-control rich-editor" name="page_content" rows="10" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" name="page_meta_description" rows="2"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" name="page_meta_keywords">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="page_status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Page</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.nav-tabs .nav-link {
    color: #2124B1;
    font-weight: 500;
    padding: 0.75rem 1.25rem;
}

.nav-tabs .nav-link.active {
    color: #4777F5;
    font-weight: 600;
    border-bottom: 2px solid #4777F5;
}

.form-label {
    font-weight: 500;
    color: #2124B1;
    margin-bottom: 0.5rem;
}

.card {
    border-radius: 0.5rem;
}

.content-header {
    padding: 1.5rem 0;
}

.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.badge {
    padding: 0.5em 0.75em;
}

.btn-group {
    box-shadow: none;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.rich-editor {
    min-height: 200px;
}
</style>

<script>
// Initialize rich text editor
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.rich-editor',
            height: 400,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                     alignleft aligncenter alignright alignjustify | \
                     bullist numlist outdent indent | removeformat | help'
        });
    }
});

// Form validation
(function() {
    'use strict';
    
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();

// Page management functions
function editPage(pageId) {
    // Implement page editing functionality
    console.log('Editing page:', pageId);
}

function deletePage(pageId) {
    if (confirm('Are you sure you want to delete this page? This action cannot be undone.')) {
        // Implement page deletion functionality
        console.log('Deleting page:', pageId);
    }
}

// Auto-generate slug from title
document.querySelector('input[name="page_title"]')?.addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
    document.querySelector('input[name="page_slug"]').value = slug;
});
</script>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 