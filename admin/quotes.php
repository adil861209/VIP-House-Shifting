<?php
/**
 * Admin - Manage Quotes
 */
$admin_title = 'Manage Quotes';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        setFlash('error', 'Security validation failed.');
        header('Location: quotes.php');
        exit;
    }
    
    $quote_id = (int)$_POST['quote_id'];
    $new_status = sanitize($_POST['status']);
    
    if (in_array($new_status, ['New', 'Contacted', 'Closed'])) {
        try {
            $stmt = $pdo->prepare("UPDATE quotes SET status = ? WHERE id = ?");
            $stmt->execute([$new_status, $quote_id]);
            setFlash('success', 'Quote status updated successfully.');
            refreshCsrfToken();
        } catch (PDOException $e) {
            setFlash('error', 'Error updating status.');
        }
    }
    header('Location: quotes.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        setFlash('error', 'Security validation failed.');
        header('Location: quotes.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    try {
        $pdo->prepare("DELETE FROM quotes WHERE id = ?")->execute([$id]);
        setFlash('success', 'Quote deleted successfully.');
        refreshCsrfToken();
    } catch (PDOException $e) {
        setFlash('error', 'Error deleting quote.');
    }
    header('Location: quotes.php');
    exit;
}

require_once 'includes/admin-header.php';

// Filter
$status_filter = isset($_GET['status']) ? sanitize($_GET['status']) : 'all';

try {
    if ($status_filter !== 'all' && in_array($status_filter, ['New', 'Contacted', 'Closed'])) {
        $stmt = $pdo->prepare("SELECT * FROM quotes WHERE status = ? ORDER BY created_at DESC");
        $stmt->execute([$status_filter]);
    } else {
        $stmt = $pdo->query("SELECT * FROM quotes ORDER BY created_at DESC");
    }
    $quotes = $stmt->fetchAll();
} catch (PDOException $e) {
    $quotes = [];
}
?>

<?php displayFlash(); ?>

<!-- Filters -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="d-flex gap-2 flex-wrap">
        <a href="quotes.php" class="btn <?php echo $status_filter === 'all' ? 'btn-admin-primary' : 'btn-admin-outline'; ?> btn-sm">All (<?php echo count($quotes); ?>)</a>
        <a href="?status=New" class="btn <?php echo $status_filter === 'New' ? 'btn-admin-primary' : 'btn-admin-outline'; ?> btn-sm">New</a>
        <a href="?status=Contacted" class="btn <?php echo $status_filter === 'Contacted' ? 'btn-admin-primary' : 'btn-admin-outline'; ?> btn-sm">Contacted</a>
        <a href="?status=Closed" class="btn <?php echo $status_filter === 'Closed' ? 'btn-admin-primary' : 'btn-admin-outline'; ?> btn-sm">Closed</a>
    </div>
</div>

<!-- Quotes Table -->
<div class="admin-table-wrapper">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>From → To</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($quotes) > 0): ?>
                <?php foreach ($quotes as $q): ?>
                <tr>
                    <td><?php echo $q['id']; ?></td>
                    <td><strong><?php echo sanitize($q['name']); ?></strong></td>
                    <td><a href="tel:<?php echo $q['phone']; ?>"><?php echo sanitize($q['phone']); ?></a></td>
                    <td><?php echo sanitize($q['email'] ?: '-'); ?></td>
                    <td><?php echo sanitize($q['moving_from']); ?> → <?php echo sanitize($q['moving_to']); ?></td>
                    <td><?php echo sanitize($q['property_type']); ?></td>
                    <td>
                        <small><?php echo date('M d, Y', strtotime($q['created_at'])); ?></small><br>
                        <?php if ($q['moving_date']): ?>
                        <small class="text-accent"><i class="bi bi-calendar3"></i> <?php echo date('M d, Y', strtotime($q['moving_date'])); ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" class="d-inline">
                            <?php csrfField(); ?>
                            <input type="hidden" name="quote_id" value="<?php echo $q['id']; ?>">
                            <select name="status" class="form-select form-select-sm" style="width:130px; border-radius:50px; font-size:0.8rem;" onchange="this.form.submit()">
                                <option value="New" <?php echo $q['status'] === 'New' ? 'selected' : ''; ?>>🟢 New</option>
                                <option value="Contacted" <?php echo $q['status'] === 'Contacted' ? 'selected' : ''; ?>>🟡 Contacted</option>
                                <option value="Closed" <?php echo $q['status'] === 'Closed' ? 'selected' : ''; ?>>⚫ Closed</option>
                            </select>
                            <input type="hidden" name="update_status" value="1">
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-admin-outline btn-sm" data-bs-toggle="modal" data-bs-target="#quoteModal<?php echo $q['id']; ?>">
                            <i class="bi bi-eye"></i>
                        </button>
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $q['phone']); ?>" target="_blank" class="btn btn-sm" style="background:#25d366; color:#fff;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="?delete=<?php echo $q['id']; ?>&csrf_token=<?php echo generateCsrfToken(); ?>" class="btn btn-admin-danger btn-sm" onclick="return confirm('Delete this quote?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>

                <!-- View Modal -->
                <div class="modal fade" id="quoteModal<?php echo $q['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius:16px;">
                            <div class="modal-header">
                                <h5 class="modal-title">Quote #<?php echo $q['id']; ?> - <?php echo sanitize($q['name']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-borderless">
                                    <tr><td class="fw-bold">Name:</td><td><?php echo sanitize($q['name']); ?></td></tr>
                                    <tr><td class="fw-bold">Phone:</td><td><a href="tel:<?php echo $q['phone']; ?>"><?php echo sanitize($q['phone']); ?></a></td></tr>
                                    <tr><td class="fw-bold">Email:</td><td><?php echo sanitize($q['email'] ?: '-'); ?></td></tr>
                                    <tr><td class="fw-bold">From:</td><td><?php echo sanitize($q['moving_from']); ?></td></tr>
                                    <tr><td class="fw-bold">To:</td><td><?php echo sanitize($q['moving_to']); ?></td></tr>
                                    <tr><td class="fw-bold">Type:</td><td><?php echo sanitize($q['property_type']); ?></td></tr>
                                    <tr><td class="fw-bold">Moving Date:</td><td><?php echo $q['moving_date'] ? date('M d, Y', strtotime($q['moving_date'])) : '-'; ?></td></tr>
                                    <tr><td class="fw-bold">Message:</td><td><?php echo sanitize($q['message'] ?: 'No message provided'); ?></td></tr>
                                    <tr><td class="fw-bold">Status:</td><td><span class="badge-status <?php echo strtolower($q['status']); ?>"><?php echo $q['status']; ?></span></td></tr>
                                    <tr><td class="fw-bold">Submitted:</td><td><?php echo date('M d, Y h:i A', strtotime($q['created_at'])); ?></td></tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <a href="tel:<?php echo $q['phone']; ?>" class="btn btn-admin-primary btn-sm"><i class="bi bi-telephone"></i> Call</a>
                                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $q['phone']); ?>" target="_blank" class="btn btn-sm" style="background:#25d366; color:#fff;"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                                <button type="button" class="btn btn-admin-outline btn-sm" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">No quotes found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/admin-footer.php'; ?>
