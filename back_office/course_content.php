<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'courses';
$title = "Manage Course Content - Artifitech Admin";
$description = "Manage course lessons and content";

// Initialize variables
$error = null;
$success = null;
$course = null;
$content_items = [];

// Get course ID from URL
$course_id = $_GET['id'] ?? null;
if (!$course_id) {
    header('Location: courses.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'add_content':
                $query = "
                    INSERT INTO course_content (
                        course_id, title, type, content, 
                        duration, order_number, status
                    ) VALUES (
                        ?, ?, ?, ?, 
                        ?, ?, ?
                    )
                ";
                
                $stmt = $conn->prepare($query);
                if ($stmt->execute([
                    $course_id,
                    $_POST['title'],
                    $_POST['type'],
                    $_POST['content'],
                    $_POST['duration'],
                    $_POST['order_number'],
                    $_POST['status']
                ])) {
                    $success = "Content item added successfully";
                } else {
                    throw new Exception("Failed to add content item");
                }
                break;
                
            case 'update_content':
                $query = "
                    UPDATE course_content SET
                        title = ?,
                        type = ?,
                        content = ?,
                        duration = ?,
                        order_number = ?,
                        status = ?,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = ? AND course_id = ?
                ";
                
                $stmt = $conn->prepare($query);
                if ($stmt->execute([
                    $_POST['title'],
                    $_POST['type'],
                    $_POST['content'],
                    $_POST['duration'],
                    $_POST['order_number'],
                    $_POST['status'],
                    $_POST['content_id'],
                    $course_id
                ])) {
                    $success = "Content item updated successfully";
                } else {
                    throw new Exception("Failed to update content item");
                }
                break;
                
            case 'delete_content':
                $query = "DELETE FROM course_content WHERE id = ? AND course_id = ?";
                $stmt = $conn->prepare($query);
                if ($stmt->execute([$_POST['content_id'], $course_id])) {
                    $success = "Content item deleted successfully";
                } else {
                    throw new Exception("Failed to delete content item");
                }
                break;
                
            case 'reorder_content':
                $orders = json_decode($_POST['orders'], true);
                if (!$orders) {
                    throw new Exception("Invalid order data");
                }
                
                $query = "UPDATE course_content SET order_number = ? WHERE id = ? AND course_id = ?";
                $stmt = $conn->prepare($query);
                
                foreach ($orders as $item) {
                    $stmt->execute([$item['order'], $item['id'], $course_id]);
                }
                
                $success = "Content order updated successfully";
                break;
        }
        
    } catch (Exception $e) {
        error_log("Error in course content management: " . $e->getMessage());
        $error = $e->getMessage();
    }
}

// Get course data
try {
    $conn = getDBConnection();
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Get course details
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    if ($stmt->execute([$course_id])) {
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$course) {
            header('Location: courses.php');
            exit;
        }
    }
    
    // Get course content items
    $stmt = $conn->prepare("
        SELECT * FROM course_content 
        WHERE course_id = ? 
        ORDER BY order_number ASC, created_at ASC
    ");
    if ($stmt->execute([$course_id])) {
        $content_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
} catch (Exception $e) {
    error_log("Error fetching course data: " . $e->getMessage());
    $error = "Failed to fetch course data";
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

<!-- Course Content Management Start -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="card-title mb-1">Course Content</h5>
                <p class="text-muted mb-0"><?php echo htmlspecialchars($course['title']); ?></p>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContentModal">
                    <i class="fas fa-plus me-2"></i>Add Content
                </button>
                <a href="course_edit.php?id=<?php echo $course_id; ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-edit me-2"></i>Edit Course
                </a>
            </div>
        </div>
        
        <!-- Content List -->
        <div class="content-list" id="sortableContent">
            <?php if (empty($content_items)): ?>
            <div class="text-center py-5">
                <p class="text-muted mb-0">No content items found. Click "Add Content" to get started.</p>
            </div>
            <?php else: ?>
            <?php foreach ($content_items as $item): ?>
            <div class="card mb-3 content-item" data-id="<?php echo $item['id']; ?>">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="drag-handle">
                                <i class="fas fa-grip-vertical text-muted"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="mb-1"><?php echo htmlspecialchars($item['title']); ?></h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-<?php echo $item['type'] === 'lesson' ? 'primary' : ($item['type'] === 'quiz' ? 'success' : 'warning'); ?> me-2">
                                    <?php echo ucfirst($item['type']); ?>
                                </span>
                                <?php if ($item['duration']): ?>
                                <small class="text-muted me-2">
                                    <i class="far fa-clock me-1"></i><?php echo htmlspecialchars($item['duration']); ?>
                                </small>
                                <?php endif; ?>
                                <span class="badge bg-<?php echo $item['status'] === 'published' ? 'success' : 'warning'; ?>">
                                    <?php echo ucfirst($item['status']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-content" 
                                        data-bs-toggle="modal" data-bs-target="#editContentModal"
                                        data-content='<?php echo htmlspecialchars(json_encode($item)); ?>'>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this content item?');">
                                    <input type="hidden" name="action" value="delete_content">
                                    <input type="hidden" name="content_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Content Modal -->
<div class="modal fade" id="addContentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="add_content">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                            <div class="invalid-feedback">Please enter a title.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="lesson">Lesson</option>
                                <option value="quiz">Quiz</option>
                                <option value="assignment">Assignment</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>
                        <div class="col-12">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g., 45 minutes">
                        </div>
                        <div class="col-md-4">
                            <label for="order_number" class="form-label">Order</label>
                            <input type="number" class="form-control" id="order_number" name="order_number" 
                                   value="<?php echo count($content_items) + 1; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Content</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Content Modal -->
<div class="modal fade" id="editContentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="update_content">
                <input type="hidden" name="content_id" id="edit_content_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                            <div class="invalid-feedback">Please enter a title.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_type" name="type" required>
                                <option value="lesson">Lesson</option>
                                <option value="quiz">Quiz</option>
                                <option value="assignment">Assignment</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>
                        <div class="col-12">
                            <label for="edit_content" class="form-label">Content</label>
                            <textarea class="form-control" id="edit_content" name="content" rows="5"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="edit_duration" name="duration" placeholder="e.g., 45 minutes">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_order_number" class="form-label">Order</label>
                            <input type="number" class="form-control" id="edit_order_number" name="order_number">
                        </div>
                        <div class="col-md-4">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
// Form validation
(function () {
    'use strict'
    
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();

// Initialize drag and drop sorting
const sortable = new Sortable(document.getElementById('sortableContent'), {
    animation: 150,
    handle: '.drag-handle',
    onEnd: function() {
        const items = document.querySelectorAll('.content-item');
        const orders = Array.from(items).map((item, index) => ({
            id: item.dataset.id,
            order: index + 1
        }));
        
        // Update order in database
        const form = document.createElement('form');
        form.method = 'POST';
        
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'reorder_content';
        
        const ordersInput = document.createElement('input');
        ordersInput.type = 'hidden';
        ordersInput.name = 'orders';
        ordersInput.value = JSON.stringify(orders);
        
        form.appendChild(actionInput);
        form.appendChild(ordersInput);
        document.body.appendChild(form);
        form.submit();
    }
});

// Handle edit content modal
document.querySelectorAll('.edit-content').forEach(button => {
    button.addEventListener('click', function() {
        const content = JSON.parse(this.dataset.content);
        document.getElementById('edit_content_id').value = content.id;
        document.getElementById('edit_title').value = content.title;
        document.getElementById('edit_type').value = content.type;
        document.getElementById('edit_content').value = content.content;
        document.getElementById('edit_duration').value = content.duration;
        document.getElementById('edit_order_number').value = content.order_number;
        document.getElementById('edit_status').value = content.status;
    });
});
</script>

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.content-item {
    cursor: move;
    transition: all 0.3s ease;
}

.content-item:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.drag-handle {
    cursor: move;
    padding: 0.5rem;
}

.form-label {
    font-weight: 500;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}
</style>
</rewritten_file> 