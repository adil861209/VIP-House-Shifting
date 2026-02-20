<?php
$page_title = 'Contact Us';
$page_description = 'Contact VIP House Shifting for professional moving services in UAE. Call, WhatsApp, or visit us. Available 24/7 in Dubai, Sharjah, Abu Dhabi, Ajman & Al Ain.';
require_once 'includes/header.php';

$contact_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        // Silently reject — invalid token
    } else {
        // For contact form, we also store as a quote
        require_once 'includes/db.php';
        $name = sanitize($_POST['name'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $message = sanitize($_POST['message'] ?? '');
        
        if (!empty($name) && !empty($phone) && strlen($name) <= 100 && strlen($phone) <= 20) {
            try {
                $stmt = $pdo->prepare("INSERT INTO quotes (name, phone, email, moving_from, moving_to, property_type, message) VALUES (?, ?, ?, 'Contact Form', 'Contact Form', 'Other', ?)");
                $stmt->execute([$name, $phone, $email, $message]);
                $contact_success = true;
                refreshCsrfToken();
            } catch (PDOException $e) {
                error_log("Contact form error: " . $e->getMessage());
            }
        }
    }
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="section-padding">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                    <h4>Call Us</h4>
                    <p><a href="tel:<?php echo PHONE; ?>"><?php echo WHATSAPP_DISPLAY; ?></a></p>
                    <small class="text-muted">Available 24/7</small>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="info-icon"><i class="bi bi-whatsapp"></i></div>
                    <h4>WhatsApp</h4>
                    <p><a href="https://wa.me/<?php echo WHATSAPP; ?>" target="_blank"><?php echo WHATSAPP_DISPLAY; ?></a></p>
                    <small class="text-muted">Instant Response</small>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                    <h4>Email Us</h4>
                    <p><a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a></p>
                    <small class="text-muted">We reply within 1 hour</small>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                    <h4>Working Hours</h4>
                    <p><?php echo WORKING_HOURS; ?></p>
                    <small class="text-muted">Including holidays</small>
                </div>
            </div>
        </div>
        
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="quote-form-wrapper">
                    <h3><i class="bi bi-chat-dots text-accent"></i> Send Us a Message</h3>
                    
                    <?php if ($contact_success): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i> Thank you! Your message has been sent. We'll get back to you shortly.
                    </div>
                    <?php else: ?>
                    <form method="POST" class="needs-validation" novalidate>
                        <?php csrfField(); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-vip">Your Name *</label>
                                <input type="text" name="name" class="form-control form-control-vip" placeholder="Full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-vip">Phone *</label>
                                <input type="tel" name="phone" class="form-control form-control-vip" placeholder="05X XXX XXXX" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-vip">Email</label>
                                <input type="email" name="email" class="form-control form-control-vip" placeholder="your@email.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label-vip">Message *</label>
                                <textarea name="message" class="form-control form-control-vip" rows="5" placeholder="How can we help you?" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="contact_submit" class="btn btn-vip-primary w-100">
                                    <i class="bi bi-send"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Google Map -->
            <div class="col-lg-6">
                <h3 class="mb-3">Our Location</h3>
                <p class="text-muted mb-3"><i class="bi bi-geo-alt text-accent"></i> <?php echo OFFICE_ADDRESS; ?></p>
                <div class="rounded-4 overflow-hidden shadow" style="height:400px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d462565.5434529459!2d54.89787394326387!3d25.07575945498498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f43496ad9c645%3A0xbde66e5084295162!2sDubai%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2s!4v1702000000000!5m2!1sen!2s"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <!-- Areas -->
                <div class="mt-4">
                    <h5 style="font-family:var(--font-body); font-weight:700;">We Serve All UAE</h5>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <?php foreach ($SERVICE_AREAS as $area): ?>
                        <span class="badge rounded-pill" style="background:rgba(26,58,107,0.08); color:var(--primary); padding:8px 16px; font-weight:500;"><?php echo $area; ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
