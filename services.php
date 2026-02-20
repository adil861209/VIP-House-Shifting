<?php
$page_title = 'Our Services';
$page_description = 'Explore our professional moving services including house shifting, villa moving, office relocation, packing services, and furniture assembly across UAE.';
require_once 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Our Services</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Services Grid -->
<section class="section-padding">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">Our Expertise</span>
            <h2>Comprehensive Moving Solutions</h2>
            <p>From packing to unpacking, we handle every aspect of your move with expertise and care.</p>
            <div class="underline-accent"></div>
        </div>
        
        <div class="row g-4">
            <?php foreach ($SERVICES as $svc): ?>
            <div class="col-md-6 col-lg-4">
                <div class="service-card">
                    <div class="card-img-wrapper">
                        <img src="assets/images/<?php echo $svc['image']; ?>" alt="<?php echo $svc['title']; ?> in UAE" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=600&h=400&fit=crop'">
                        <div class="card-icon-overlay"><i class="bi <?php echo $svc['icon']; ?>"></i></div>
                    </div>
                    <div class="card-body">
                        <h3><?php echo $svc['title']; ?></h3>
                        <p><?php echo $svc['short']; ?></p>
                        <a href="service-single.php?service=<?php echo $svc['slug']; ?>" class="card-link notranslate">
                            Learn More <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Process -->
<section class="section-padding bg-off-white">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">How It Works</span>
            <h2>Our Moving Process</h2>
            <p>A simple, streamlined process to make your move hassle-free.</p>
            <div class="underline-accent"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h4>Get a Quote</h4>
                    <p>Contact us through phone, WhatsApp, or our quote form for a free estimate.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h4>Free Survey</h4>
                    <p>Our team visits your location to assess the scope and provide an accurate quote.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h4>Pack & Move</h4>
                    <p>Professional packing, loading, transport, and unloading on your scheduled date.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h4>Setup & Done</h4>
                    <p>We unpack, assemble furniture, and set up everything in your new space.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-banner">
    <div class="container text-center position-relative" style="z-index:2;">
        <h2>Need a Moving Service?</h2>
        <p>Get in touch with us today for a free, no-obligation quote.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="quote.php" class="btn btn-vip-accent"><i class="bi bi-envelope-paper"></i> Get Free Quote</a>
            <a href="https://wa.me/<?php echo WHATSAPP; ?>" class="btn btn-vip-outline" target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp Us</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
