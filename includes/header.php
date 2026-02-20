<?php
if (session_status() === PHP_SESSION_NONE) {
    // Hardened session configuration
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_secure', 1); // HTTPS enabled on production
    session_start();
}
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Permissions-Policy: camera=(), microphone=(), geolocation=()");

// Page-specific meta (set before including header)
$page_title = isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME . ' – ' . SITE_TAGLINE;
$page_description = isset($page_description) ? $page_description : 'Professional movers in UAE offering house shifting, villa moving, office relocation and packing services across Dubai, Sharjah, Abu Dhabi, Ajman & Al Ain.';
$page_keywords = isset($page_keywords) ? $page_keywords : 'movers in dubai, house shifting uae, villa movers sharjah, cheap movers abu dhabi, packing services';
$current_page = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo sanitize($page_title); ?></title>
    <meta name="description" content="<?php echo sanitize($page_description); ?>">
    <meta name="keywords" content="<?php echo sanitize($page_keywords); ?>">
    <meta name="author" content="VIP House Shifting">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo sanitize($page_title); ?>">
    <meta property="og:description" content="<?php echo sanitize($page_description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo SITE_URL; ?>/assets/images/favicon.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo SITE_URL; ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-vip fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo SITE_URL; ?>/">
                <div class="brand-icon"><i class="bi bi-truck"></i></div>
                VIP <span>House Shifting</span>
            </a>
            
            <!-- Language Toggle (always visible) -->
            <div class="lang-toggle-wrapper">
                <button type="button" id="langToggleBtn" class="btn btn-lang-toggle" onclick="toggleLanguage()" title="التبديل إلى العربية">
                    <img src="https://flagcdn.com/w40/sa.png" alt="SA" class="lang-flag-img" id="langFlagImg" width="20" height="15">
                    <span class="lang-text" id="langTextLabel">عربي</span>
                </button>
            </div>
            
            <!-- Hamburger button → triggers offcanvas -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Desktop nav (visible on lg+) -->
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarDesktop">
                <ul class="navbar-nav ms-auto me-3 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'index' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'about' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['services','service-single']) ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/services.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu">
                            <?php foreach ($SERVICES as $nav_svc): ?>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/service-single.php?service=<?php echo $nav_svc['slug']; ?>"><?php echo $nav_svc['title']; ?></a></li>
                            <?php endforeach; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/services.php">All Services</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'gallery' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/gallery.php">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'blog' || $current_page === 'blog-single' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/blog.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page === 'contact' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/contact.php">Contact</a>
                    </li>
                </ul>
                <a href="<?php echo SITE_URL; ?>/quote.php" class="btn btn-nav-cta">
                    <i class="bi bi-envelope-paper"></i> Get Free Quote
                </a>
            </div>
        </div>
    </nav>

    <!-- Off-canvas Mobile Menu (slides from right) -->
    <div class="offcanvas offcanvas-end offcanvas-mobile-menu" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileMenuLabel">
                <div class="brand-icon-sm"><i class="bi bi-truck"></i></div>
                VIP <span class="text-accent">House Shifting</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav mobile-nav-list">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'index' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'about' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/about.php">
                        <i class="bi bi-info-circle"></i> About
                    </a>
                </li>
                <li class="nav-item mobile-dropdown">
                    <a class="nav-link mobile-dropdown-toggle <?php echo in_array($current_page, ['services','service-single']) ? 'active' : ''; ?>" href="#" onclick="this.parentElement.classList.toggle('open'); return false;">
                        <i class="bi bi-grid"></i> Services <i class="bi bi-chevron-down mobile-chevron"></i>
                    </a>
                    <ul class="mobile-submenu">
                        <?php foreach ($SERVICES as $nav_svc): ?>
                        <li><a href="<?php echo SITE_URL; ?>/service-single.php?service=<?php echo $nav_svc['slug']; ?>"><?php echo $nav_svc['title']; ?></a></li>
                        <?php endforeach; ?>
                        <li class="submenu-divider"></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php"><strong>All Services</strong></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'gallery' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/gallery.php">
                        <i class="bi bi-images"></i> Gallery
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'blog' || $current_page === 'blog-single' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/blog.php">
                        <i class="bi bi-newspaper"></i> Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page === 'contact' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/contact.php">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                </li>
            </ul>
            
            <div class="mobile-menu-cta">
                <a href="<?php echo SITE_URL; ?>/quote.php" class="btn btn-nav-cta w-100">
                    <i class="bi bi-envelope-paper"></i> Get Free Quote
                </a>
                <a href="tel:<?php echo PHONE; ?>" class="btn btn-mobile-call w-100">
                    <i class="bi bi-telephone-fill"></i> Call Now
                </a>
            </div>
            
            <div class="mobile-menu-contact">
                <a href="https://wa.me/<?php echo WHATSAPP; ?>" target="_blank">
                    <i class="bi bi-whatsapp"></i> WhatsApp Us
                </a>
                <a href="mailto:<?php echo SITE_EMAIL; ?>">
                    <i class="bi bi-envelope"></i> <?php echo SITE_EMAIL; ?>
                </a>
            </div>
        </div>
    </div>
