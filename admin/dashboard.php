<?php
/**
 * Admin Dashboard
 */
$admin_title = 'Dashboard';
require_once __DIR__ . '/../includes/db.php';
require_once 'includes/admin-header.php';

// Get stats
try {
    $total_quotes = $pdo->query("SELECT COUNT(*) FROM quotes")->fetchColumn();
    $new_quotes = $pdo->query("SELECT COUNT(*) FROM quotes WHERE status = 'New'")->fetchColumn();
    $total_posts = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
    $total_gallery = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
    
    // Recent quotes
    $recent_quotes = $pdo->query("SELECT * FROM quotes ORDER BY created_at DESC LIMIT 5")->fetchAll();
} catch (PDOException $e) {
    $total_quotes = $new_quotes = $total_posts = $total_gallery = 0;
    $recent_quotes = [];
}
?>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-envelope-paper"></i></div>
            <h3><?php echo $total_quotes; ?></h3>
            <p>Total Quotes</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon gold"><i class="bi bi-bell"></i></div>
            <h3><?php echo $new_quotes; ?></h3>
            <p>New Quotes</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-journal-text"></i></div>
            <h3><?php echo $total_posts; ?></h3>
            <p>Blog Posts</p>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-images"></i></div>
            <h3><?php echo $total_gallery; ?></h3>
            <p>Gallery Images</p>
        </div>
    </div>
</div>

<!-- Recent Quotes -->
<div class="admin-table-wrapper">
    <div class="table-header">
        <h5><i class="bi bi-clock-history"></i> Recent Quote Requests</h5>
        <a href="quotes.php" class="btn btn-admin-outline btn-sm">View All <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>From → To</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($recent_quotes) > 0): ?>
                <?php foreach ($recent_quotes as $q): ?>
                <tr>
                    <td><strong><?php echo sanitize($q['name']); ?></strong></td>
                    <td><a href="tel:<?php echo $q['phone']; ?>"><?php echo sanitize($q['phone']); ?></a></td>
                    <td><?php echo sanitize($q['moving_from']); ?> → <?php echo sanitize($q['moving_to']); ?></td>
                    <td><?php echo sanitize($q['property_type']); ?></td>
                    <td><?php echo timeAgo($q['created_at']); ?></td>
                    <td>
                        <span class="badge-status <?php echo strtolower($q['status']); ?>">
                            <?php echo sanitize($q['status']); ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No quote requests yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
