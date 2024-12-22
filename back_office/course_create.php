<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once 'includes/admin_auth_check.php';

// Set page-specific variables
$page = 'courses';
$title = "Create New Course - Artifitech Admin";
$description = "Create a new course";

// Initialize variables
$error = null;
$success = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        // Get form data
        $title = $_POST['title'] ?? '';
        $name = $_POST['name'] ?? '';
        $short_description = $_POST['short_description'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $price = $_POST['price'] ?? 0;
        $duration = $_POST['duration'] ?? '';
        $status = $_POST['status'] ?? 'draft';

        // Handle thumbnail upload
        $thumbnail = null;
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/courses/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($file_extension, $allowed_extensions)) {
                throw new Exception("Invalid file type. Only JPG, JPEG, PNG, and WEBP files are allowed.");
            }

            $filename = uniqid() . '.' . $file_extension;
            $thumbnail = 'uploads/courses/' . $filename;

            if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../' . $thumbnail)) {
                throw new Exception("Failed to upload thumbnail");
            }
        }

        // Insert course into database
        $query = "
            INSERT INTO courses (
                title, name, short_description, description, 
                category, price, thumbnail, duration, status
            ) VALUES (
                ?, ?, ?, ?, 
                ?, ?, ?, ?, ?
            )
        ";

        $stmt = $conn->prepare($query);
        if ($stmt->execute([
            $title, $name, $short_description, $description,
            $category, $price, $thumbnail, $duration, $status
        ])) {
            $course_id = $conn->lastInsertId();
            header("Location: course_edit.php?id=$course_id&success=created");
            exit;
        } else {
            throw new Exception("Failed to create course");
        }

    } catch (Exception $e) {
        error_log("Error in course creation: " . $e->getMessage());
        $error = $e->getMessage();
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

<!-- Course Creation Form Start -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-4">Create New Course</h5>
        
        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row g-4">
                <!-- Basic Information -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-3">Basic Information</h6>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Course Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <div class="invalid-feedback">Please enter a course title.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">URL Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="form-text">This will be used in the course URL. Use lowercase letters, numbers, and hyphens only.</div>
                                <div class="invalid-feedback">Please enter a URL name.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="short_description" name="short_description" rows="2" required></textarea>
                                <div class="invalid-feedback">Please enter a short description.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Full Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Course Settings -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-3">Course Settings</h6>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Management">Management</option>
                                    <option value="Education">Education</option>
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label">Price (R) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                                <div class="invalid-feedback">Please enter a valid price.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g., 6 weeks">
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-3">Course Thumbnail</h6>
                            
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Upload Thumbnail</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                <div class="form-text">Recommended size: 1280x720 pixels (16:9 ratio)</div>
                            </div>
                            
                            <div id="thumbnail-preview" class="mt-3 d-none">
                                <img src="" alt="Thumbnail Preview" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Create Course</button>
                <a href="courses.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

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

// Auto-generate URL name from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const urlName = title.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('name').value = urlName;
});

// Thumbnail preview
document.getElementById('thumbnail').addEventListener('change', function() {
    const preview = document.getElementById('thumbnail-preview');
    const previewImg = preview.querySelector('img');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(this.files[0]);
    } else {
        preview.classList.add('d-none');
    }
});
</script>

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.form-label {
    font-weight: 500;
}

.card-subtitle {
    color: #6c757d;
    font-weight: 600;
}

#thumbnail-preview img {
    max-height: 200px;
    width: auto;
    object-fit: cover;
}
</style> 