<?php
/**
 * Admin - Manage Gallery
 */
$admin_title = 'Manage Gallery';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

// Handle Delete
if (isset($_GET['delete'])) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        setFlash('error', 'Security validation failed.');
        header('Location: gallery.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("SELECT image FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $img = $stmt->fetch();
        if ($img && file_exists(__DIR__ . '/../' . UPLOAD_GALLERY . $img['image'])) {
            unlink(__DIR__ . '/../' . UPLOAD_GALLERY . $img['image']);
        }
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        setFlash('success', 'Image deleted successfully.');
        refreshCsrfToken();
    } catch (PDOException $e) {
        setFlash('error', 'Error deleting image.');
    }
    header('Location: gallery.php');
    exit;
}

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_image'])) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        setFlash('error', 'Security validation failed.');
        header('Location: gallery.php');
        exit;
    }
    
    $category = sanitize($_POST['category'] ?? 'Moving');
    
    if (isset($_FILES['images'])) {
        $uploaded = 0;
        $errors = 0;
        
        $files = $_FILES['images'];
        $file_count = count($files['name']);
        
        for ($i = 0; $i < $file_count; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                // Build a single-file array for validateFileUpload
                $single_file = [
                    'name' => $files['name'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i],
                ];
                $validation = validateFileUpload($single_file);
                
                if ($validation['valid']) {
                    $image_name = uniqid('gallery_') . '.' . $validation['ext'];
                    $upload_path = __DIR__ . '/../' . UPLOAD_GALLERY . $image_name;
                    
                    if (move_uploaded_file($files['tmp_name'][$i], $upload_path)) {
                        try {
                            $stmt = $pdo->prepare("INSERT INTO gallery (image, category) VALUES (?, ?)");
                            $stmt->execute([$image_name, $category]);
                            $uploaded++;
                        } catch (PDOException $e) {
                            $errors++;
                        }
                    } else {
                        $errors++;
                    }
                } else {
                    $errors++;
                }
            }
        }
        
        if ($uploaded > 0) {
            setFlash('success', "$uploaded image(s) uploaded successfully." . ($errors > 0 ? " $errors failed." : ''));
            refreshCsrfToken();
        } else {
            setFlash('error', 'No images were uploaded. Check file type and size.');
        }
    }
    header('Location: gallery.php');
    exit;
}

require_once 'includes/admin-header.php';

// Get gallery images
$cat_filter = isset($_GET['category']) ? sanitize($_GET['category']) : 'all';
try {
    if ($cat_filter !== 'all') {
        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$cat_filter]);
    } else {
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
    }
    $images = $stmt->fetchAll();
} catch (PDOException $e) {
    $images = [];
}
?>

<?php displayFlash(); ?>

<!-- Upload Form -->
<div class="admin-table-wrapper p-4 mb-4">
    <h5 class="mb-3"><i class="bi bi-cloud-upload"></i> Upload Images</h5>
    <form method="POST" enctype="multipart/form-data" class="admin-form">
        <?php csrfField(); ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Select Images (multiple allowed)</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                <small class="text-muted">Max 5MB per image. Allowed: JPG, PNG, WebP, GIF</small>
            </div>
            <div class="col-md-4">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="Moving">Moving</option>
                    <option value="Packing">Packing</option>
                    <option value="Trucks">Trucks</option>
                    <option value="Team">Team</option>
                    <option value="Before/After">Before/After</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" name="upload_image" class="btn btn-admin-primary w-100">
                    <i class="bi bi-upload"></i> Upload
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Filter -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="d-flex gap-2 flex-wrap">
        <a href="gallery.php" class="btn <?php echo $cat_filter === 'all' ? 'btn-admin-primary' : 'btn-admin-outline'; ?> btn-sm">All</a>
        <?php foreach (['Packing', 'Moving', 'Trucks', 'Team', 'Before/After'] as $cat): ?>
        <a href="?category=<?php echo urlencode($cat); ?>" class="btn <?php echo $cat_filter === $cat ? 'btn-admin-primary' : 'btn-admin-outline'; ?> btn-sm"><?php echo $cat; ?></a>
        <?php endforeach; ?>
    </div>
    <span class="text-muted"><?php echo count($images); ?> image(s)</span>
</div>

<!-- Gallery Grid -->
<?php if (count($images) > 0): ?>
<div class="row g-3">
    <?php foreach ($images as $img): ?>
    <div class="col-6 col-md-4 col-lg-3">
        <div class="position-relative rounded-3 overflow-hidden" style="border:1px solid #e0e5ec;">
            <img src="<?php echo SITE_URL . '/' . UPLOAD_GALLERY . sanitize($img['image']); ?>" alt="<?php echo sanitize($img['category']); ?>" style="width:100%; height:180px; object-fit:cover;">
            <div class="p-2 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge rounded-pill" style="background:rgba(26,58,107,0.08); color:#1a3a6b; font-size:0.75rem;"><?php echo sanitize($img['category']); ?></span>
                    <a href="?delete=<?php echo $img['id']; ?>&csrf_token=<?php echo generateCsrfToken(); ?>" class="text-danger" style="font-size:0.9rem;" onclick="return confirm('Delete this image?')"><i class="bi bi-trash"></i></a>
                </div>
                <small class="text-muted d-block mt-1"><?php echo date('M d, Y', strtotime($img['uploaded_at'])); ?></small>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center py-5">
    <i class="bi bi-images text-muted" style="font-size:3rem;"></i>
    <h5 class="mt-3 text-muted">No images uploaded yet</h5>
    <p class="text-muted">Use the form above to upload gallery images.</p>
</div>
<?php endif; ?>

<?php require_once 'includes/admin-footer.php'; ?>
