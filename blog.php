<?php
$page_title = 'Blog';
$page_description = 'Read our latest articles about moving tips, packing guides, and relocation advice for UAE residents. Expert insights from VIP House Shifting.';
require_once 'includes/header.php';
require_once 'includes/db.php';

// Pagination
$per_page = 6;
$page_num = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page_num - 1) * $per_page;

try {
    // Total posts
    $total = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
    $total_pages = ceil($total / $per_page);
    
    // Get posts
    $stmt = $pdo->prepare("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bindValue(1, $per_page, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();
} catch (PDOException $e) {
    $posts = [];
    $total_pages = 0;
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Our Blog</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item active">Blog</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Blog Listing -->
<section class="section-padding">
    <div class="container">
        <?php if (count($posts) > 0): ?>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
            <div class="col-md-6 col-lg-4">
                <div class="blog-card">
                    <div class="blog-img">
                        <?php if (!empty($post['image'])): ?>
                        <img src="<?php echo SITE_URL . '/' . UPLOAD_BLOG . sanitize($post['image']); ?>" alt="<?php echo sanitize($post['title']); ?>" loading="lazy">
                        <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=600&h=400&fit=crop" alt="<?php echo sanitize($post['title']); ?>" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <div class="blog-body">
                        <div class="blog-date"><i class="bi bi-calendar3"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?></div>
                        <h3><a href="blog-single.php?slug=<?php echo sanitize($post['slug']); ?>"><?php echo sanitize($post['title']); ?></a></h3>
                        <p><?php echo truncate(strip_tags($post['content']), 120); ?></p>
                        <a href="blog-single.php?slug=<?php echo sanitize($post['slug']); ?>" class="card-link">
                            Read More <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav class="mt-5">
            <ul class="pagination pagination-vip justify-content-center">
                <?php if ($page_num > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page_num - 1; ?>"><i class="bi bi-chevron-left"></i></a></li>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $i === $page_num ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
                
                <?php if ($page_num < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page_num + 1; ?>"><i class="bi bi-chevron-right"></i></a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-journal-text text-muted" style="font-size:3rem;"></i>
            <h4 class="mt-3 text-muted">Blog Coming Soon</h4>
            <p class="text-muted">We're working on helpful articles about moving tips and guides. Stay tuned!</p>
            <a href="<?php echo SITE_URL; ?>/" class="btn btn-vip-primary btn-sm-vip mt-2"><i class="bi bi-house"></i> Back to Home</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
