<?php
$page_title = 'Get a Free Quote';
$page_description = 'Request a free moving quote from VIP House Shifting. Fill out our quick form and get an affordable estimate for house shifting, villa moving, or office relocation in UAE.';
require_once 'includes/header.php';
require_once 'includes/db.php';

$success = false;
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quote'])) {
    // Verify CSRF token
    if (!verifyCsrfToken()) {
        $error = 'Security validation failed. Please try again.';
    } else {
        $name = sanitize($_POST['name'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $moving_from = sanitize($_POST['moving_from'] ?? '');
        $moving_to = sanitize($_POST['moving_to'] ?? '');
        $property_type = sanitize($_POST['property_type'] ?? 'Apartment');
        $moving_date = sanitize($_POST['moving_date'] ?? '');
        $message = sanitize($_POST['message'] ?? '');
        
        // Validation
        if (empty($name) || empty($phone) || empty($moving_from) || empty($moving_to)) {
            $error = 'Please fill in all required fields.';
        } elseif (strlen($name) > 100 || strlen($phone) > 20 || strlen($email) > 100) {
            $error = 'Input too long. Please check your entries.';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO quotes (name, phone, email, moving_from, moving_to, property_type, moving_date, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $phone, $email, $moving_from, $moving_to, $property_type, $moving_date ?: null, $message]);
                $success = true;
                refreshCsrfToken();
            } catch (PDOException $e) {
                error_log("Quote submission error: " . $e->getMessage());
                $error = 'There was an error submitting your quote. Please try again or contact us directly.';
            }
        }
    }
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Get a Free Quote</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item active">Get a Quote</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Quote Form Section -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-7">
                <div class="quote-form-wrapper">
                    <h3><i class="bi bi-envelope-paper text-accent"></i> Request Your Free Moving Quote</h3>
                    <p class="text-muted mb-4">Fill out the form below and our team will get back to you within 1 hour with a detailed quote.</p>
                    
                    <?php if ($success): ?>
                    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                        <div>
                            <strong>Thank you!</strong> Your quote request has been submitted successfully. We'll contact you within 1 hour.
                            <br><small>You can also reach us immediately via <a href="https://wa.me/<?php echo WHATSAPP; ?>" target="_blank" class="alert-link">WhatsApp</a> or call <a href="tel:<?php echo PHONE; ?>" class="alert-link"><?php echo WHATSAPP_DISPLAY; ?></a>.</small>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div><?php echo $error; ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!$success): ?>
                    <form method="POST" class="needs-validation" novalidate id="quoteForm">
                        <?php csrfField(); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-vip">Full Name *</label>
                                <input type="text" name="name" class="form-control form-control-vip" placeholder="Your full name" required value="<?php echo isset($name) ? $name : ''; ?>">
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-vip">Phone Number *</label>
                                <input type="tel" name="phone" class="form-control form-control-vip" placeholder="05X XXX XXXX" required value="<?php echo isset($phone) ? $phone : ''; ?>">
                                <div class="invalid-feedback">Please enter your phone number.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label-vip">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-vip" placeholder="your@email.com" value="<?php echo isset($email) ? $email : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-vip">Moving From *</label>
                                <input type="text" name="moving_from" class="form-control form-control-vip" placeholder="Current location/area" required value="<?php echo isset($moving_from) ? $moving_from : ''; ?>">
                                <div class="invalid-feedback">Please enter your current location.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-vip">Moving To *</label>
                                <input type="text" name="moving_to" class="form-control form-control-vip" placeholder="Destination location/area" required value="<?php echo isset($moving_to) ? $moving_to : ''; ?>">
                                <div class="invalid-feedback">Please enter your destination.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-vip">Property Type *</label>
                                <select name="property_type" class="form-select form-control-vip" required>
                                    <option value="Apartment" <?php echo isset($property_type) && $property_type === 'Apartment' ? 'selected' : ''; ?>>Apartment</option>
                                    <option value="Villa" <?php echo isset($property_type) && $property_type === 'Villa' ? 'selected' : ''; ?>>Villa</option>
                                    <option value="Office" <?php echo isset($property_type) && $property_type === 'Office' ? 'selected' : ''; ?>>Office</option>
                                    <option value="Other" <?php echo isset($property_type) && $property_type === 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-vip">Moving Date</label>
                                <input type="date" name="moving_date" class="form-control form-control-vip" value="<?php echo isset($moving_date) ? $moving_date : ''; ?>" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label-vip">Additional Message</label>
                                <textarea name="message" class="form-control form-control-vip" rows="4" placeholder="Any additional details about your move (number of rooms, special items, etc.)"><?php echo isset($message) ? $message : ''; ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="submit_quote" class="btn btn-vip-accent btn-lg w-100">
                                    <i class="bi bi-send"></i> Submit Quote Request
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-5">
                <!-- Direct Contact -->
                <div class="p-4 rounded-4 mb-4" style="background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff;">
                    <h4 class="text-white mb-3" style="font-family:var(--font-body); font-size:1.15rem;">Prefer to Talk?</h4>
                    <p style="opacity:0.85; font-size:0.95rem; margin-bottom:20px;">Get an instant quote through phone or WhatsApp. We respond within minutes!</p>
                    <div class="d-grid gap-2">
                        <a href="tel:<?php echo PHONE; ?>" class="btn btn-vip-accent">
                            <i class="bi bi-telephone-fill"></i> Call: <?php echo WHATSAPP_DISPLAY; ?>
                        </a>
                        <a href="https://wa.me/<?php echo WHATSAPP; ?>?text=Hi%2C%20I%20need%20a%20moving%20quote" class="btn btn-vip-outline" target="_blank">
                            <i class="bi bi-whatsapp"></i> WhatsApp Us
                        </a>
                    </div>
                </div>
                
                <!-- Why Choose Us -->
                <div class="p-4 rounded-4" style="background:var(--off-white);">
                    <h4 class="mb-3" style="font-family:var(--font-body); font-size:1.1rem; font-weight:700;">Why Get a Quote From Us?</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-check-circle-fill text-accent mt-1"></i>
                            <div>
                                <strong>Free & No Obligation</strong>
                                <p class="text-muted mb-0" style="font-size:0.85rem;">Get a quote with zero commitment. Compare and decide.</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-check-circle-fill text-accent mt-1"></i>
                            <div>
                                <strong>Response in 1 Hour</strong>
                                <p class="text-muted mb-0" style="font-size:0.85rem;">Our team reviews and responds to every quote request quickly.</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-check-circle-fill text-accent mt-1"></i>
                            <div>
                                <strong>Transparent Pricing</strong>
                                <p class="text-muted mb-0" style="font-size:0.85rem;">No hidden charges. The price we quote is what you pay.</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="bi bi-check-circle-fill text-accent mt-1"></i>
                            <div>
                                <strong>Best Price Guarantee</strong>
                                <p class="text-muted mb-0" style="font-size:0.85rem;">Competitive rates with premium service quality.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
