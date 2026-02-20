<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/db.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: blog.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ?");
    $stmt->execute([$slug]);
    $post = $stmt->fetch();
} catch (PDOException $e) {
    $post = null;
}

if (!$post) {
    header('Location: blog.php');
    exit;
}

$page_title = $post['title'];
$page_description = truncate(strip_tags($post['content']), 160);
require_once 'includes/header.php';

// Get recent posts for sidebar
try {
    $stmt = $pdo->prepare("SELECT id, title, slug, created_at, image FROM blog_posts WHERE slug != ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$slug]);
    $recent_posts = $stmt->fetchAll();
} catch (PDOException $e) {
    $recent_posts = [];
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php echo sanitize($post['title']); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/blog.php">Blog</a></li>
                <li class="breadcrumb-item active"><?php echo sanitize(truncate($post['title'], 40)); ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- Blog Content -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article>
                    <!-- Date -->
                    <div class="mb-3">
                        <span class="text-muted"><i class="bi bi-calendar3 text-accent"></i> <?php echo date('F d, Y', strtotime($post['created_at'])); ?></span>
                    </div>
                    
                    <!-- Featured Image -->
                    <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo SITE_URL . '/' . UPLOAD_BLOG . sanitize($post['image']); ?>" alt="<?php echo sanitize($post['title']); ?>" class="img-fluid rounded-4 shadow mb-4" loading="lazy">
                    <?php endif; ?>
                    
                    <!-- Content -->
                    <div class="blog-content" style="font-size:1.05rem; line-height:1.9; color:var(--text);">
                        <?php echo sanitizeHtml($post['content']); ?>
                    </div>
                    
                    <!-- Share -->
                    <div class="mt-5 pt-4" style="border-top:1px solid var(--light-gray);">
                        <h5 style="font-family:var(--font-body); font-weight:700;">Share This Article</h5>
                        <div class="d-flex gap-2 mt-2">
                            <a href="https://wa.me/?text=<?php echo urlencode($post['title'] . ' - ' . SITE_URL . '/blog-single.php?slug=' . $post['slug']); ?>" target="_blank" class="btn btn-sm" style="background:#25d366; color:#fff;"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/blog-single.php?slug=' . $post['slug']); ?>" target="_blank" class="btn btn-sm" style="background:#1877f2; color:#fff;"><i class="bi bi-facebook"></i> Facebook</a>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($post['title']); ?>&url=<?php echo urlencode(SITE_URL . '/blog-single.php?slug=' . $post['slug']); ?>" target="_blank" class="btn btn-sm" style="background:#1da1f2; color:#fff;"><i class="bi bi-twitter-x"></i> Twitter</a>
                        </div>
                    </div>
                </article>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- CTA -->
                <div class="p-4 rounded-4 mb-4" style="background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff;">
                    <h4 class="text-white mb-2" style="font-family:var(--font-body); font-size:1.1rem;">Need a Mover?</h4>
                    <p style="opacity:0.85; font-size:0.9rem;">Get a free moving quote today!</p>
                    <a href="quote.php" class="btn btn-vip-accent btn-sm-vip w-100"><i class="bi bi-envelope-paper"></i> Get Free Quote</a>
                </div>
                
                <!-- Recent Posts -->
                <?php if (count($recent_posts) > 0): ?>
                <div class="p-4 rounded-4" style="background:var(--off-white);">
                    <h4 class="mb-3" style="font-family:var(--font-body); font-size:1.1rem; font-weight:700;">Recent Posts</h4>
                    <?php foreach ($recent_posts as $rp): ?>
                    <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid var(--light-gray);">
                        <?php if (!empty($rp['image'])): ?>
                        <img src="<?php echo SITE_URL . '/' . UPLOAD_BLOG . sanitize($rp['image']); ?>" alt="" style="width:70px; height:70px; object-fit:cover; border-radius:10px;" loading="lazy">
                        <?php endif; ?>
                        <div>
                            <h6 class="mb-1" style="font-family:var(--font-body); font-size:0.9rem;"><a href="blog-single.php?slug=<?php echo sanitize($rp['slug']); ?>" style="color:var(--text);"><?php echo sanitize($rp['title']); ?></a></h6>
                            <small class="text-muted"><?php echo date('M d, Y', strtotime($rp['created_at'])); ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
