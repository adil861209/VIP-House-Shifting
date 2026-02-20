<?php
/**
 * VIP House Shifting - Helper Functions
 */

/**
 * Sanitize user input
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Check if admin is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Require admin login, redirect if not
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Redirect to a URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Generate URL-friendly slug
 */
function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

/**
 * Human-readable time difference
 */
function timeAgo($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->y > 0) return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    if ($diff->m > 0) return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    if ($diff->d > 0) return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    if ($diff->h > 0) return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    if ($diff->i > 0) return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    return 'Just now';
}

/**
 * Truncate text to a given length
 */
function truncate($text, $length = 150) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

/**
 * Get service data by slug
 */
function getServiceBySlug($slug) {
    global $SERVICES;
    foreach ($SERVICES as $service) {
        if ($service['slug'] === $slug) {
            return $service;
        }
    }
    return null;
}

/**
 * Get current page name from URL
 */
function getCurrentPage() {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page;
}

/**
 * Flash message system
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Display flash message HTML
 */
function displayFlash() {
    $flash = getFlash();
    if ($flash) {
        $type = $flash['type'] === 'error' ? 'danger' : $flash['type'];
        echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
        echo sanitize($flash['message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
    }
}

// ========================
// SECURITY FUNCTIONS
// ========================

/**
 * Generate a CSRF token and store in session
 */
function generateCsrfToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Output a hidden CSRF input field
 */
function csrfField() {
    echo '<input type="hidden" name="csrf_token" value="' . generateCsrfToken() . '">';
}

/**
 * Verify the submitted CSRF token
 */
function verifyCsrfToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = $_POST['csrf_token'] ?? ($_GET['csrf_token'] ?? '');
    if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

/**
 * Regenerate the CSRF token (call after successful verification)
 */
function refreshCsrfToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Sanitize HTML for blog content — allow only safe tags
 */
function sanitizeHtml($html) {
    $allowed_tags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><blockquote><pre><code><hr><table><thead><tbody><tr><th><td><span><div><figure><figcaption>';
    $clean = strip_tags($html, $allowed_tags);
    // Remove any event handlers (onclick, onerror, onload, etc.)
    $clean = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $clean);
    $clean = preg_replace('/\s+on\w+\s*=\s*[^\s>]*/i', '', $clean);
    // Remove javascript: URLs
    $clean = preg_replace('/href\s*=\s*["\']?\s*javascript\s*:/i', 'href="', $clean);
    $clean = preg_replace('/src\s*=\s*["\']?\s*javascript\s*:/i', 'src="', $clean);
    // Remove data: URLs from src (can be used for XSS)
    $clean = preg_replace('/src\s*=\s*["\']?\s*data\s*:/i', 'src="', $clean);
    return $clean;
}

/**
 * Validate an uploaded file — checks MIME type and extension
 * Returns ['valid' => bool, 'error' => string, 'ext' => string]
 */
function validateFileUpload($file, $allowed_extensions = ['jpg','jpeg','png','webp','gif'], $max_size = 5242880) {
    $result = ['valid' => false, 'error' => '', 'ext' => ''];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $result['error'] = 'File upload error.';
        return $result;
    }

    // Check file size
    if ($file['size'] > $max_size) {
        $result['error'] = 'File too large. Max: ' . ($max_size / 1024 / 1024) . 'MB.';
        return $result;
    }

    // Check extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_extensions)) {
        $result['error'] = 'Invalid file type. Allowed: ' . implode(', ', $allowed_extensions) . '.';
        return $result;
    }

    // Verify MIME type using finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed_mimes = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'webp' => 'image/webp',
    ];
    $expected_mime = $allowed_mimes[$ext] ?? null;
    if (!$expected_mime || $mime !== $expected_mime) {
        $result['error'] = 'File content does not match its extension. Possible malicious file.';
        return $result;
    }

    $result['valid'] = true;
    $result['ext'] = $ext;
    return $result;
}

/**
 * Check login rate limiting (session-based)
 * Returns true if login attempts are allowed, false if locked out
 */
function checkLoginRateLimit() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $max_attempts = 5;
    $lockout_time = 900; // 15 minutes

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_lockout_until'] = 0;
    }

    if ($_SESSION['login_lockout_until'] > time()) {
        return false; // Still locked out
    }

    // Reset if lockout has expired
    if ($_SESSION['login_lockout_until'] > 0 && $_SESSION['login_lockout_until'] <= time()) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_lockout_until'] = 0;
    }

    return $_SESSION['login_attempts'] < $max_attempts;
}

/**
 * Record a failed login attempt
 */
function recordFailedLogin() {
    $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
    if ($_SESSION['login_attempts'] >= 5) {
        $_SESSION['login_lockout_until'] = time() + 900; // Lock for 15 min
    }
}

/**
 * Reset login attempts on successful login
 */
function resetLoginAttempts() {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['login_lockout_until'] = 0;
}
