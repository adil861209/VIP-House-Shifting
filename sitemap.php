<?php
/**
 * Dynamic XML Sitemap
 */
require_once 'includes/config.php';
require_once 'includes/db.php';

header('Content-Type: application/xml; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url><loc><?php echo SITE_URL; ?>/</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
    <url><loc><?php echo SITE_URL; ?>/about.php</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc><?php echo SITE_URL; ?>/services.php</loc><changefreq>monthly</changefreq><priority>0.9</priority></url>
    <url><loc><?php echo SITE_URL; ?>/quote.php</loc><changefreq>monthly</changefreq><priority>0.9</priority></url>
    <url><loc><?php echo SITE_URL; ?>/contact.php</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc><?php echo SITE_URL; ?>/gallery.php</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>
    <url><loc><?php echo SITE_URL; ?>/blog.php</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    
    <!-- Service Pages -->
    <?php foreach ($SERVICES as $service): ?>
    <url><loc><?php echo SITE_URL; ?>/service-single.php?service=<?php echo $service['slug']; ?></loc><changefreq>monthly</changefreq><priority>0.9</priority></url>
    <?php endforeach; ?>
    
    <!-- Blog Posts -->
    <?php
    try {
        $posts = $pdo->query("SELECT slug, created_at FROM blog_posts ORDER BY created_at DESC")->fetchAll();
        foreach ($posts as $post):
    ?>
    <url>
        <loc><?php echo SITE_URL; ?>/blog-single.php?slug=<?php echo $post['slug']; ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime($post['created_at'])); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; } catch (PDOException $e) {} ?>
</urlset>
