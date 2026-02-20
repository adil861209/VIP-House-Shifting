<?php
/**
 * Admin - Manage Blog Posts
 */
$admin_title = 'Manage Blog';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

// Handle Delete
if (isset($_GET['delete'])) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        setFlash('error', 'Security validation failed.');
        header('Location: blog.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    try {
        // Get image to delete
        $stmt = $pdo->prepare("SELECT image FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        if ($post && $post['image'] && file_exists(__DIR__ . '/../' . UPLOAD_BLOG . $post['image'])) {
            unlink(__DIR__ . '/../' . UPLOAD_BLOG . $post['image']);
        }
        $pdo->prepare("DELETE FROM blog_posts WHERE id = ?")->execute([$id]);
        setFlash('success', 'Blog post deleted successfully.');
        refreshCsrfToken();
    } catch (PDOException $e) {
        setFlash('error', 'Error deleting post.');
    }
    header('Location: blog.php');
    exit;
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_post'])) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        setFlash('error', 'Security validation failed.');
        header('Location: blog.php');
        exit;
    }
    
    $post_id = (int)($_POST['post_id'] ?? 0);
    $title = sanitize($_POST['title'] ?? '');
    $slug = slugify($_POST['slug'] ?? $title);
    $content = sanitizeHtml($_POST['content'] ?? ''); // Sanitize HTML — allow safe tags only
    
    if (empty($title) || empty($content)) {
        setFlash('error', 'Title and content are required.');
        header('Location: blog.php' . ($post_id ? '?edit=' . $post_id : '?add=1'));
        exit;
    }
    
    // Handle image upload with MIME validation
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $validation = validateFileUpload($_FILES['image']);
        
        if ($validation['valid']) {
            $image_name = uniqid('blog_') . '.' . $validation['ext'];
            $upload_path = __DIR__ . '/../' . UPLOAD_BLOG . $image_name;
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
        } else {
            setFlash('error', $validation['error']);
            header('Location: blog.php' . ($post_id ? '?edit=' . $post_id : '?add=1'));
            exit;
        }
    }
    
    try {
        if ($post_id > 0) {
            // Update
            if ($image_name) {
                // Delete old image
                $stmt = $pdo->prepare("SELECT image FROM blog_posts WHERE id = ?");
                $stmt->execute([$post_id]);
                $old = $stmt->fetch();
                if ($old && $old['image'] && file_exists(__DIR__ . '/../' . UPLOAD_BLOG . $old['image'])) {
                    unlink(__DIR__ . '/../' . UPLOAD_BLOG . $old['image']);
                }
                $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, content = ?, image = ? WHERE id = ?");
                $stmt->execute([$title, $slug, $content, $image_name, $post_id]);
            } else {
                $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, content = ? WHERE id = ?");
                $stmt->execute([$title, $slug, $content, $post_id]);
            }
            setFlash('success', 'Blog post updated successfully.');
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $content, $image_name]);
            setFlash('success', 'Blog post created successfully.');
        }
        refreshCsrfToken();
    } catch (PDOException $e) {
        error_log("Blog save error: " . $e->getMessage());
        setFlash('error', 'Error saving post. Slug may already exist.');
    }
    header('Location: blog.php');
    exit;
}

require_once 'includes/admin-header.php';

// Get editing post
$editing = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editing = $stmt->fetch();
}

$show_form = isset($_GET['add']) || $editing;

// Get all posts
try {
    $posts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
} catch (PDOException $e) {
    $posts = [];
}
?>

<?php displayFlash(); ?>

<?php if ($show_form): ?>
<!-- Add/Edit Form -->
<div class="admin-table-wrapper p-4 mb-4">
    <h5 class="mb-3"><?php echo $editing ? 'Edit Post' : 'Add New Post'; ?></h5>
    <form method="POST" enctype="multipart/form-data" class="admin-form">
        <?php csrfField(); ?>
        <input type="hidden" name="post_id" value="<?php echo $editing ? $editing['id'] : 0; ?>">
        
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" placeholder="Post title" required value="<?php echo $editing ? sanitize($editing['title']) : ''; ?>" id="blogTitle" oninput="document.getElementById('blogSlug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'')">
            </div>
            <div class="col-md-4">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" placeholder="auto-generated" id="blogSlug" value="<?php echo $editing ? sanitize($editing['slug']) : ''; ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Content * (HTML supported)</label>
                <textarea name="content" class="form-control" rows="12" placeholder="Write your blog post content here..." required><?php echo $editing ? $editing['content'] : ''; ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Featured Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <?php if ($editing && $editing['image']): ?>
                <small class="text-muted">Current: <?php echo sanitize($editing['image']); ?></small>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <button type="submit" name="save_post" class="btn btn-admin-primary">
                    <i class="bi bi-check-lg"></i> <?php echo $editing ? 'Update Post' : 'Publish Post'; ?>
                </button>
                <a href="blog.php" class="btn btn-admin-outline ms-2">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php endif; ?>

<!-- Posts List -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">All Blog Posts (<?php echo count($posts); ?>)</h5>
    <?php if (!$show_form): ?>
    <a href="?add=1" class="btn btn-admin-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Post</a>
    <?php endif; ?>
</div>

<div class="admin-table-wrapper">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $p): ?>
                <tr>
                    <td>
                        <?php if ($p['image']): ?>
                        <img src="<?php echo SITE_URL . '/' . UPLOAD_BLOG . sanitize($p['image']); ?>" alt="" style="width:60px; height:45px; object-fit:cover; border-radius:8px;">
                        <?php else: ?>
                        <div style="width:60px; height:45px; background:#f0f2f5; border-radius:8px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-image text-muted"></i></div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo sanitize($p['title']); ?></strong></td>
                    <td><code><?php echo sanitize($p['slug']); ?></code></td>
                    <td><small><?php echo date('M d, Y', strtotime($p['created_at'])); ?></small></td>
                    <td>
                        <a href="<?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $p['slug']; ?>" target="_blank" class="btn btn-admin-outline btn-sm"><i class="bi bi-eye"></i></a>
                        <a href="?edit=<?php echo $p['id']; ?>" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                        <a href="?delete=<?php echo $p['id']; ?>&csrf_token=<?php echo generateCsrfToken(); ?>" class="btn btn-admin-danger btn-sm" onclick="return confirm('Delete this post?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No blog posts yet. <a href="?add=1">Add your first post</a></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
