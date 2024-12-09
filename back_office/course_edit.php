<?php
require_once '../includes/config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Set page variables
$page = 'courses';
$title = 'Edit Course - Artifitech Admin';

$course_id = $_GET['id'] ?? null;
if (!$course_id) {
    header('Location: courses.php');
    exit;
}

// Handle course update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        
        // Basic course info update
        $stmt = $conn->prepare("
            UPDATE courses 
            SET title = ?, category = ?, price = ?, short_description = ?, 
                description = ?, status = ?, updated_at = NOW()
            WHERE id = ?
        ");
        
        $stmt->execute([
            $_POST['title'],
            $_POST['category'],
            $_POST['price'],
            $_POST['short_description'],
            $_POST['description'],
            $_POST['status'],
            $course_id
        ]);

        // Handle thumbnail update if new file is uploaded
        if (!empty($_FILES['thumbnail']['name'])) {
            $upload_dir = '../uploads/courses/';
            $file_ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            $file_name = 'course_' . $course_id . '_' . time() . '.' . $file_ext;
            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
                $stmt = $conn->prepare("UPDATE courses SET thumbnail = ? WHERE id = ?");
                $stmt->execute(['/uploads/courses/' . $file_name, $course_id]);
            }
        }

        $_SESSION['success_message'] = "Course updated successfully!";
        header('Location: courses.php');
        exit;
        
    } catch (PDOException $e) {
        error_log("Error updating course: " . $e->getMessage());
        $error = "An error occurred while updating the course.";
    }
}

// Get course data
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$course) {
        header('Location: courses.php');
        exit;
    }
    
} catch (PDOException $e) {
    error_log("Error fetching course: " . $e->getMessage());
    $error = "An error occurred while fetching the course.";
}

// Start output buffering
ob_start();
?>

<!-- Include TinyMCE -->
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500
    });
</script>

<!-- Page Header Start -->
<div class="bg-light rounded p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0">Edit Course</h4>
        <a href="courses.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Courses
        </a>
    </div>
    <p class="text-muted mb-0">Edit course details and content</p>
</div>

<!-- Course Edit Form Start -->
<div class="bg-light rounded p-4">
    <form action="course_edit.php?id=<?php echo $course_id; ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Course Title</label>
                            <input type="text" class="form-control" name="title" 
                                   value="<?php echo htmlspecialchars($course['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea class="form-control" name="short_description" rows="3" 
                                      required><?php echo htmlspecialchars($course['short_description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea id="description" name="description"><?php echo htmlspecialchars($course['description']); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Course Content -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Course Content</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                            <i class="fas fa-plus me-1"></i>Add Section
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="course-sections">
                            <!-- Course sections will be loaded dynamically -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Course Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Course Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <option value="programming" <?php echo $course['category'] === 'programming' ? 'selected' : ''; ?>>Programming</option>
                                <option value="design" <?php echo $course['category'] === 'design' ? 'selected' : ''; ?>>Design</option>
                                <option value="business" <?php echo $course['category'] === 'business' ? 'selected' : ''; ?>>Business</option>
                                <option value="marketing" <?php echo $course['category'] === 'marketing' ? 'selected' : ''; ?>>Marketing</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" class="form-control" name="price" step="0.01" 
                                   value="<?php echo $course['price']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="draft" <?php echo $course['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo $course['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Course Thumbnail -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Course Thumbnail</h5>
                    </div>
                    <div class="card-body">
                        <div class="current-thumbnail mb-3">
                            <img src="<?php echo htmlspecialchars($course['thumbnail']); ?>" 
                                 alt="Current Thumbnail" 
                                 class="img-fluid rounded">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Update Thumbnail</label>
                            <input type="file" class="form-control" name="thumbnail" accept="image/*">
                            <small class="text-muted">Leave empty to keep current thumbnail</small>
                        </div>
                    </div>
                </div>

                <!-- Save Changes -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Course Edit Form End -->

<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Course Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addSectionForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="section_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="section_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.course-sections {
    min-height: 200px;
}

.current-thumbnail img {
    max-height: 200px;
    width: 100%;
    object-fit: cover;
}
</style>

<script>
// Course sections management
document.getElementById('addSectionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Add section logic here
    $('#addSectionModal').modal('hide');
});
</script>

<?php
$content = ob_get_clean();
include 'admin_template.php';
?> 