<?php
$page_title = 'Professional Movers in UAE';
$page_description = 'VIP House Shifting - Professional movers in UAE offering safe, fast & reliable house shifting, villa moving, office relocation and packing services across Dubai, Sharjah, Abu Dhabi, Ajman & Al Ain.';
$page_keywords = 'movers in dubai, house shifting uae, villa movers sharjah, cheap movers abu dhabi, professional movers uae';
require_once 'includes/header.php';
require_once 'includes/db.php';
?>

<!-- Hero Section -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="bi bi-patch-check-fill"></i> #1 Trusted Movers in UAE
                    </div>
                    <div class="hero-badge hero-badge-ar" dir="rtl">
                        <i class="bi bi-patch-check-fill"></i> الناقلون الأكثر ثقة في الإمارات
                    </div>
                    <h1>Professional <span class="highlight">Movers in UAE</span> – Safe, Fast & Reliable</h1>
                    <p class="hero-subtitle-ar" dir="rtl">نقل احترافي وآمن وسريع وموثوق في جميع أنحاء الإمارات – فلل، شقق ومكاتب</p>
                    <p class="hero-subtitle">Villa, Apartment & Office Shifting Across Dubai, Sharjah, Abu Dhabi, Ajman & Al Ain. Get your free moving quote today!</p>
                    <div class="hero-buttons">
                        <a href="tel:<?php echo PHONE; ?>" class="btn btn-vip-accent">
                            <i class="bi bi-telephone-fill"></i> Call Now – اتصل الآن
                        </a>
                        <a href="quote.php" class="btn btn-vip-outline">
                            <i class="bi bi-envelope-paper"></i> Get Free Quote – عرض سعر مجاني
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <img src="assets/images/hero-truck.png" alt="VIP House Shifting Truck" class="img-fluid" style="max-height:400px; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
            </div>
        </div>
    </div>
</section>

<!-- Trust Badges -->
<section class="trust-badges">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <div class="badge-icon"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <h4>Licensed</h4>
                        <p>& Insured</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <div class="badge-icon"><i class="bi bi-clock-history"></i></div>
                    <div>
                        <h4>24/7</h4>
                        <p>Service Available</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <div class="badge-icon"><i class="bi bi-award"></i></div>
                    <div>
                        <h4 class="counter" data-target="10">0</h4>
                        <p>Years Experience</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <div class="badge-icon"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <h4><span class="counter" data-target="1000">0</span>+</h4>
                        <p>Moves Completed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section-padding" id="services">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">What We Offer</span>
            <h2>Our Professional Services</h2>
            <p>We provide comprehensive moving solutions tailored to your needs across all UAE emirates.</p>
            <div class="underline-accent"></div>
        </div>
        
        <div class="row g-4">
            <?php foreach ($SERVICES as $svc): ?>
            <div class="col-md-6 col-lg-4">
                <div class="service-card">
                    <div class="card-img-wrapper">
                        <img src="assets/images/<?php echo $svc['image']; ?>" alt="<?php echo $svc['title']; ?>" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=600&h=400&fit=crop'">
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

<!-- Why Choose Us -->
<section class="section-padding bg-off-white" id="why-us">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">Why Choose Us</span>
            <h2>The VIP Difference</h2>
            <p>Experience the highest standard of moving services in the UAE.</p>
            <div class="underline-accent"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-people-fill"></i></div>
                    <h4>Professional Team</h4>
                    <p>Trained and experienced movers who handle your belongings with utmost care.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-clipboard-check"></i></div>
                    <h4>Free Survey & Quote</h4>
                    <p>We provide a free on-site survey and transparent pricing with no hidden charges.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-cash-coin"></i></div>
                    <h4>Affordable Prices</h4>
                    <p>Competitive rates without compromising on the quality of our moving services.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-shield-lock"></i></div>
                    <h4>Damage-Free Guarantee</h4>
                    <p>Your items are fully insured. We guarantee safe delivery of all your belongings.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-gear-wide-connected"></i></div>
                    <h4>Modern Equipment</h4>
                    <p>We use the latest moving equipment and vehicles for efficient relocation.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-clock"></i></div>
                    <h4>On-Time Delivery</h4>
                    <p>Punctual and reliable service. We respect your time and schedule.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="section-padding" id="reviews">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">Testimonials</span>
            <h2>What Our Clients Say</h2>
            <p>Read reviews from our satisfied customers across the UAE.</p>
            <div class="underline-accent"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="review-card">
                    <i class="bi bi-quote quote-icon"></i>
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="review-text">"Excellent service! They moved our entire villa in just one day. Very professional team and everything arrived safely. Highly recommended!"</p>
                    <div class="review-author">
                        <div class="author-avatar">AK</div>
                        <div>
                            <h5>Ahmed Khalil</h5>
                            <span>Villa Moving – Dubai</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="review-card">
                    <i class="bi bi-quote quote-icon"></i>
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="review-text">"Best movers in Sharjah! Their packing was incredible — not a single item was damaged. The price was very fair and the team was friendly."</p>
                    <div class="review-author">
                        <div class="author-avatar">SM</div>
                        <div>
                            <h5>Sara Mohammed</h5>
                            <span>House Shifting – Sharjah</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="review-card">
                    <i class="bi bi-quote quote-icon"></i>
                    <div class="review-stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                    </div>
                    <p class="review-text">"We used VIP House Shifting for our office relocation. They were punctual, efficient, and the transition was seamless. Great job!"</p>
                    <div class="review-author">
                        <div class="author-avatar">RJ</div>
                        <div>
                            <h5>Rashid Jameel</h5>
                            <span>Office Relocation – Abu Dhabi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Areas We Serve -->
<section class="section-padding bg-off-white" id="areas">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">Coverage</span>
            <h2>Areas We Serve</h2>
            <p>Professional moving services available across all major UAE cities.</p>
            <div class="underline-accent"></div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <?php
            $area_icons = ['bi-buildings', 'bi-building', 'bi-bank2', 'bi-house-heart', 'bi-geo-alt-fill'];
            $area_descriptions = [
                'All areas including Marina, Downtown, JBR, Silicon Oasis & more',
                'Including Al Nahda, Al Majaz, Muwaileh, Al Qasimia & more',
                'Al Reem Island, Khalidiyah, Yas Island, Saadiyat & more',
                'Al Rashidiya, Al Jurf, City Center areas & more',
                'Zakher, Al Mutawaa, Asharej, Al Jimi & more'
            ];
            foreach ($SERVICE_AREAS as $i => $area): ?>
            <div class="col-6 col-md-4 col-lg">
                <div class="area-card">
                    <div class="area-icon"><i class="bi <?php echo $area_icons[$i]; ?>"></i></div>
                    <h4><?php echo $area; ?></h4>
                    <p><?php echo $area_descriptions[$i]; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="cta-banner">
    <div class="container text-center position-relative" style="z-index:2;">
        <h2>Ready to Move? Get Your Free Quote Today!</h2>
        <p>Contact us now for a hassle-free moving experience across UAE.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="quote.php" class="btn btn-vip-accent">
                <i class="bi bi-envelope-paper"></i> Get Free Quote
            </a>
            <a href="https://wa.me/<?php echo WHATSAPP; ?>?text=Hello%2C%20I%20need%20a%20moving%20quote" class="btn btn-vip-outline" target="_blank">
                <i class="bi bi-whatsapp"></i> WhatsApp Us
            </a>
            <a href="tel:<?php echo PHONE; ?>" class="btn btn-vip-outline">
                <i class="bi bi-telephone"></i> Call Now
            </a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
