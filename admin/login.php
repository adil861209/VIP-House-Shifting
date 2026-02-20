<?php
/**
 * Admin Login
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Handle logout (requires CSRF token)
if (isset($_GET['logout'])) {
    if (!verifyCsrfToken()) {
        header('Location: dashboard.php');
        exit;
    }
    session_destroy();
    header('Location: login.php');
    exit;
}

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        $error = 'Security validation failed. Please try again.';
    } elseif (!checkLoginRateLimit()) {
        $remaining = $_SESSION['login_lockout_until'] - time();
        $error = 'Too many failed attempts. Please wait ' . ceil($remaining / 60) . ' minutes.';
    } else {
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = 'Please enter both username and password.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    // Regenerate session ID to prevent session fixation
                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    resetLoginAttempts();
                    refreshCsrfToken();
                    header('Location: dashboard.php');
                    exit;
                } else {
                    recordFailedLogin();
                    $error = 'Invalid username or password.';
                }
            } catch (PDOException $e) {
                error_log("Login error: " . $e->getMessage());
                $error = 'An error occurred. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?php echo SITE_NAME; ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="admin-login-page">
        <div class="login-card">
            <div class="login-brand">
                <div style="width:60px;height:60px;background:linear-gradient(135deg,#1a3a6b,#2a5298);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">
                    <i class="bi bi-truck" style="color:#c9a84c;font-size:1.6rem;"></i>
                </div>
                <h2>VIP <span>Admin Panel</span></h2>
                <p>Sign in to manage your website</p>
            </div>
            
            <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" class="admin-form">
                <?php csrfField(); ?>
                <div class="mb-3">
                    <label class="form-label" style="font-weight:600; font-size:0.85rem;">Username</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border:2px solid #e0e5ec; border-right:0; border-radius:10px 0 0 10px; background:#f8f9fc;"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control" style="border:2px solid #e0e5ec; border-left:0; border-radius:0 10px 10px 0; padding:12px;" placeholder="Enter username" required autofocus value="<?php echo isset($username) ? sanitize($username) : ''; ?>">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label" style="font-weight:600; font-size:0.85rem;">Password</label>
                    <div class="input-group">
                        <span class="input-group-text" style="border:2px solid #e0e5ec; border-right:0; border-radius:10px 0 0 10px; background:#f8f9fc;"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" style="border:2px solid #e0e5ec; border-left:0; border-radius:0 10px 10px 0; padding:12px;" placeholder="Enter password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-admin-primary w-100" style="padding:14px;">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="<?php echo SITE_URL; ?>/" style="color:#636e72; font-size:0.85rem;"><i class="bi bi-arrow-left"></i> Back to Website</a>
            </div>
        </div>
    </div>
</body>
</html>
