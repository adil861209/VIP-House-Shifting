<?php
$page_title = 'Gallery';
$page_description = 'View our gallery of professional moving services. See our team in action - packing, moving, trucks, and before/after photos of relocations across UAE.';
require_once 'includes/header.php';
require_once 'includes/db.php';

// Get gallery images
$category_filter = isset($_GET['category']) ? sanitize($_GET['category']) : 'all';
try {
    if ($category_filter !== 'all') {
        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$category_filter]);
    } else {
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
    }
    $images = $stmt->fetchAll();
} catch (PDOException $e) {
    $images = [];
}

$categories = ['all' => 'All', 'Packing' => 'Packing', 'Moving' => 'Moving', 'Trucks' => 'Trucks', 'Team' => 'Team', 'Before/After' => 'Before/After'];
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Our Gallery</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item active">Gallery</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Gallery Section -->
<section class="section-padding">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">Our Work</span>
            <h2>See Us in Action</h2>
            <p>Browse through photos of our professional moving services across UAE.</p>
            <div class="underline-accent"></div>
        </div>
        
        <!-- Filter Buttons -->
        <div class="gallery-filter">
            <?php foreach ($categories as $key => $label): ?>
            <button class="filter-btn <?php echo $category_filter === $key ? 'active' : ''; ?>" data-filter="<?php echo $key; ?>" onclick="window.location.href='gallery.php<?php echo $key !== 'all' ? '?category=' . urlencode($key) : ''; ?>'">
                <?php echo $label; ?>
            </button>
            <?php endforeach; ?>
        </div>
        
        <!-- Gallery Grid -->
        <?php if (count($images) > 0): ?>
        <div class="row g-3">
            <?php foreach ($images as $image): ?>
            <div class="col-6 col-md-4 col-lg-3 gallery-col" data-category="<?php echo sanitize($image['category']); ?>">
                <div class="gallery-item">
                    <img src="<?php echo SITE_URL . '/' . UPLOAD_GALLERY . sanitize($image['image']); ?>" alt="<?php echo sanitize($image['category']); ?> - VIP House Shifting" loading="lazy">
                    <div class="gallery-overlay">
                        <span><?php echo sanitize($image['category']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-images text-muted" style="font-size:3rem;"></i>
            <h4 class="mt-3 text-muted">Gallery Coming Soon</h4>
            <p class="text-muted">We're adding photos of our work. Check back soon!</p>
            <a href="contact.php" class="btn btn-vip-primary btn-sm-vip mt-2"><i class="bi bi-telephone"></i> Contact Us</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="cta-banner">
    <div class="container text-center position-relative" style="z-index:2;">
        <h2>Impressed? Let Us Handle Your Move!</h2>
        <p>Contact us for a free quote and experience our professional service firsthand.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="quote.php" class="btn btn-vip-accent"><i class="bi bi-envelope-paper"></i> Get Free Quote</a>
            <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-vip-outline" target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
