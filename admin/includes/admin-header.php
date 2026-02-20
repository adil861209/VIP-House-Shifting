<?php
/**
 * Admin Header - Sidebar & Topbar
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Protect admin routes
requireLogin();

$admin_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo isset($admin_title) ? $admin_title : 'Dashboard'; ?> | <?php echo SITE_NAME; ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="admin-body">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-truck"></i></div>
            <h4>VIP <span>Admin</span></h4>
        </div>
        <ul class="sidebar-nav">
            <li><a href="dashboard.php" class="<?php echo $admin_page === 'dashboard' ? 'active' : ''; ?>"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
            <li><a href="quotes.php" class="<?php echo $admin_page === 'quotes' ? 'active' : ''; ?>"><i class="bi bi-envelope-paper"></i> Quotes</a></li>
            <li><a href="blog.php" class="<?php echo $admin_page === 'blog' ? 'active' : ''; ?>"><i class="bi bi-journal-text"></i> Blog Posts</a></li>
            <li><a href="gallery.php" class="<?php echo $admin_page === 'gallery' ? 'active' : ''; ?>"><i class="bi bi-images"></i> Gallery</a></li>
            <li style="margin-top:20px; border-top:1px solid rgba(255,255,255,0.08); padding-top:15px;">
                <a href="<?php echo SITE_URL; ?>/" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Website</a>
            </li>
            <li><a href="login.php?logout=1&csrf_token=<?php echo generateCsrfToken(); ?>" style="color:rgba(231,76,60,0.8);"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Topbar -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn d-lg-none" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5><?php echo isset($admin_title) ? $admin_title : 'Dashboard'; ?></h5>
            </div>
            <div class="admin-user">
                <span>Welcome, <strong><?php echo sanitize($_SESSION['admin_username'] ?? 'Admin'); ?></strong></span>
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)); ?></div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="admin-content">
