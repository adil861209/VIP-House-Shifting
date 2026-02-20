<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get service slug
$slug = isset($_GET['service']) ? sanitize($_GET['service']) : '';
$service = getServiceBySlug($slug);

if (!$service) {
    header('Location: services.php');
    exit;
}

// SEO-rich content per service
$service_content = [
    'house-shifting' => [
        'meta_desc' => 'Professional house shifting services in Dubai, Sharjah, Abu Dhabi & across UAE. Safe, affordable & reliable movers. Get a free quote today!',
        'intro' => 'Moving to a new home is one of life\'s most significant events, and at VIP House Shifting, we understand the importance of making this transition as smooth as possible. Our professional house shifting services cover every aspect of your move, from careful packing of your belongings to safe transportation and organized setup at your new home.',
        'content' => '<p>Our house shifting service is designed for families and individuals moving within or across UAE cities. Whether you\'re relocating from a studio apartment in Dubai Marina to a spacious flat in Jumeirah, or moving between emirates, our expert team ensures a hassle-free experience.</p>
        <h3 class="mt-4 mb-3">What\'s Included in Our House Shifting Service?</h3>
        <ul class="mb-4">
            <li><strong>Pre-move Survey:</strong> Free assessment of your belongings to provide an accurate quote</li>
            <li><strong>Professional Packing:</strong> High-quality materials including bubble wrap, carton boxes, and furniture blankets</li>
            <li><strong>Careful Loading:</strong> Trained movers who handle every item with care</li>
            <li><strong>Safe Transportation:</strong> Modern, clean trucks equipped with padding and straps</li>
            <li><strong>Unloading & Unpacking:</strong> Organized placement of items in your new home</li>
            <li><strong>Furniture Assembly:</strong> Reassembly of beds, wardrobes, and other furniture</li>
        </ul>
        <p>We serve all residential areas across Dubai, Sharjah, Abu Dhabi, Ajman, and Al Ain. Our transparent pricing means no hidden charges — what we quote is what you pay. With insurance coverage on all moves, your belongings are protected throughout the entire journey.</p>',
        'faqs' => [
            ['q' => 'How much does house shifting cost in UAE?', 'a' => 'The cost depends on the size of your home, the distance of the move, and the amount of belongings. We offer competitive prices starting from AED 800 for studio apartments. Contact us for a free, accurate quote.'],
            ['q' => 'How far in advance should I book?', 'a' => 'We recommend booking at least 3-5 days in advance, especially during peak moving seasons (end of month, school holidays). However, we also accommodate last-minute moves when possible.'],
            ['q' => 'Do you provide packing materials?', 'a' => 'Yes! All packing materials including boxes, bubble wrap, tape, and furniture blankets are included in our service. We use premium materials to ensure maximum protection.'],
            ['q' => 'Is my furniture insured during the move?', 'a' => 'Yes, all moves include basic insurance coverage. We also offer extended insurance options for valuable items. Our careful handling ensures damage-free delivery.'],
        ]
    ],
    'villa-moving' => [
        'meta_desc' => 'Premium villa moving services in UAE. Professional movers for large homes and villas in Dubai, Sharjah & Abu Dhabi. Damage-free guarantee!',
        'intro' => 'Villa moving requires specialized expertise, equipment, and careful planning. At VIP House Shifting, we have extensive experience in relocating villas of all sizes across the UAE. Our dedicated villa moving team handles everything from grand pianos and chandeliers to outdoor furniture and garden equipment.',
        'content' => '<p>Villas present unique moving challenges — large furniture, multiple floors, fragile decor, and often extensive outdoor areas. Our villa moving service is specifically designed to address these challenges with precision and care.</p>
        <h3 class="mt-4 mb-3">Our Villa Moving Process</h3>
        <ul class="mb-4">
            <li><strong>Detailed Assessment:</strong> On-site survey of your villa to plan the perfect move</li>
            <li><strong>Custom Crating:</strong> Special wooden crates for delicate items like artworks and chandeliers</li>
            <li><strong>Furniture Disassembly:</strong> Expert dismantling of large furniture pieces</li>
            <li><strong>Climate-Controlled Transport:</strong> Available for sensitive items</li>
            <li><strong>Full Setup:</strong> Complete furniture reassembly and room arrangement</li>
            <li><strong>Post-Move Cleanup:</strong> We clean up all packing materials after setup</li>
        </ul>
        <p>We have successfully moved hundreds of villas in communities like Emirates Hills, Arabian Ranches, Palm Jumeirah, Jumeirah Golf Estates, Al Barsha, and many more across Dubai and other emirates.</p>',
        'faqs' => [
            ['q' => 'How long does it take to move a villa?', 'a' => 'A typical villa move takes 1-2 days depending on the size. Larger villas (5+ bedrooms) may take up to 3 days. We create a detailed timeline during the survey.'],
            ['q' => 'Can you move a piano or pool table?', 'a' => 'Absolutely! We have specialized equipment and trained staff for moving heavy and delicate items including pianos, pool tables, and large artwork.'],
            ['q' => 'Do you move garden and outdoor furniture?', 'a' => 'Yes, we handle all outdoor items including garden furniture, BBQ equipment, playground sets, and potted plants.'],
            ['q' => 'What about moving between emirates?', 'a' => 'We regularly handle inter-emirate villa moves. Whether it\'s Dubai to Abu Dhabi or Sharjah to Ajman, we have the logistics covered.'],
        ]
    ],
    'office-relocation' => [
        'meta_desc' => 'Expert office relocation services in UAE. Minimal downtime, IT equipment handling, and weekend moves available. Get your free office moving quote!',
        'intro' => 'Office relocation requires meticulous planning to minimize business disruption. VIP House Shifting specializes in corporate moves that keep your downtime to an absolute minimum. From startups in co-working spaces to large corporate offices, we handle every type of office move with professional efficiency.',
        'content' => '<p>We understand that time is money in business. Our office relocation service is designed to get your team back to work as quickly as possible, with everything in its place and ready to go.</p>
        <h3 class="mt-4 mb-3">Office Relocation Services Include</h3>
        <ul class="mb-4">
            <li><strong>IT Equipment Handling:</strong> Safe disconnection, packing, and reconnection of computers, servers, and networking equipment</li>
            <li><strong>Furniture Disassembly:</strong> Office desks, partitions, conference tables, and storage units</li>
            <li><strong>Document Management:</strong> Secure packing and labeling of files and documents</li>
            <li><strong>Weekend & After-Hours Moves:</strong> Available to eliminate workday disruption</li>
            <li><strong>Floor Planning:</strong> Setup according to your new office layout plan</li>
            <li><strong>Debris Removal:</strong> Complete cleanup of old and new office spaces</li>
        </ul>
        <p>We have helped businesses relocate in DIFC, Business Bay, Media City, Internet City, Knowledge Park, and free zones across Abu Dhabi, Sharjah, and Ajman.</p>',
        'faqs' => [
            ['q' => 'Can you move offices over a weekend?', 'a' => 'Yes! Weekend and after-hours moves are our specialty for office relocations. We can complete most office moves within a single weekend to ensure zero workday disruption.'],
            ['q' => 'How do you handle IT equipment?', 'a' => 'Our team includes trained IT movers who properly disconnect, label, pack, and reconnect all equipment. We use anti-static packaging for sensitive electronics.'],
            ['q' => 'Do you provide storage for office furniture?', 'a' => 'Yes, we offer short and long-term storage solutions for office furniture and equipment in our climate-controlled warehouses.'],
            ['q' => 'What\'s the typical office moving timeline?', 'a' => 'Small offices (up to 20 staff) can be moved in a day. Medium offices typically take 1-2 days, while large corporate moves may take 3-5 days depending on complexity.'],
        ]
    ],
    'packing-services' => [
        'meta_desc' => 'Professional packing services in UAE. Premium materials, expert packers for fragile items. Full & partial packing options available!',
        'intro' => 'Proper packing is the foundation of a successful move. Our professional packing service ensures every item — from your finest china to your largest furniture — is packed with the right materials and techniques to prevent damage during transit.',
        'content' => '<p>Many people underestimate the importance of proper packing. Using the wrong materials or techniques can lead to costly damage. Our trained packers know exactly how to protect each type of item for safe transport.</p>
        <h3 class="mt-4 mb-3">Packing Options We Offer</h3>
        <ul class="mb-4">
            <li><strong>Full Packing Service:</strong> We pack everything in your home from kitchen to bedroom</li>
            <li><strong>Partial Packing:</strong> We pack only fragile or difficult items, you handle the rest</li>
            <li><strong>Fragile Items Packing:</strong> Specialized packing for glassware, artwork, mirrors, and antiques</li>
            <li><strong>Wardrobe Service:</strong> Hanging wardrobe boxes to keep clothes wrinkle-free</li>
            <li><strong>Kitchen Packing:</strong> Dish boxes and cell kits for plates, glasses, and cookware</li>
            <li><strong>Unpacking Service:</strong> We unpack and organize at your new location</li>
        </ul>
        <p>We use only high-quality materials: double-walled carton boxes, acid-free tissue paper, premium bubble wrap, foam sheets, and custom wooden crates for extra protection.</p>',
        'faqs' => [
            ['q' => 'What packing materials do you use?', 'a' => 'We use premium double-walled boxes, bubble wrap, packing paper, foam sheets, stretch wrap, wardrobe boxes, dish cells, and custom wooden crates for valuable items.'],
            ['q' => 'Can I pack some items myself?', 'a' => 'Of course! We offer partial packing where we handle fragile and heavy items while you pack personal items. Our team can advise you on proper packing techniques.'],
            ['q' => 'How much does packing service cost?', 'a' => 'Packing costs depend on the volume of items and the level of service. Full packing for a 2-bedroom apartment typically ranges from AED 500-1,000. Contact us for an exact quote.'],
            ['q' => 'Do you provide packing materials only?', 'a' => 'Yes! We can deliver packing materials to your doorstep if you prefer to pack yourself. We offer boxes, tape, bubble wrap, and other supplies at competitive prices.'],
        ]
    ],
    'furniture-assembly' => [
        'meta_desc' => 'Expert furniture assembly & disassembly services in UAE. IKEA, custom furniture, and all brands. Professional technicians available!',
        'intro' => 'Whether you\'re moving or simply bought new furniture, our expert technicians handle the assembly and disassembly of all types of furniture with precision and care. From IKEA flat-packs to custom-made pieces, we ensure everything is put together correctly and securely.',
        'content' => '<p>Furniture assembly might seem straightforward, but improper assembly can damage your furniture and even create safety hazards. Our experienced technicians have assembled thousands of furniture pieces and handle every brand and type.</p>
        <h3 class="mt-4 mb-3">Our Furniture Services</h3>
        <ul class="mb-4">
            <li><strong>Disassembly for Moving:</strong> Careful dismantling with all hardware organized and labeled</li>
            <li><strong>Reassembly at New Location:</strong> Precise reassembly using original hardware</li>
            <li><strong>New Furniture Assembly:</strong> IKEA and all flat-pack furniture brands</li>
            <li><strong>Bed Frame Assembly:</strong> All types including king, queen, bunk, and sofa beds</li>
            <li><strong>Wardrobe Installation:</strong> Built-in and freestanding wardrobe assembly</li>
            <li><strong>Custom Furniture Fixing:</strong> Wall mounting, shelf installation, and TV bracket mounting</li>
        </ul>
        <p>We bring all necessary tools and hardware. Our technicians are experienced with all major furniture brands including IKEA, Home Centre, Pan Emirates, THE One, and custom-made furniture.</p>',
        'faqs' => [
            ['q' => 'Do you assemble IKEA furniture?', 'a' => 'Yes! IKEA furniture assembly is one of our most popular services. Our technicians are experienced with all IKEA product lines, from simple shelves to complex wardrobe systems.'],
            ['q' => 'What if a part is missing or broken?', 'a' => 'We carry common replacement hardware. If a specific part is needed, we\'ll identify it and help you source a replacement. Minor fixes are included in our service.'],
            ['q' => 'How long does furniture assembly take?', 'a' => 'Simple items like shelves take 20-30 minutes. Complex pieces like wardrobes can take 1-3 hours. We provide time estimates before starting.'],
            ['q' => 'Do you remove old furniture?', 'a' => 'Yes, we offer furniture disposal services. We can disassemble and remove old furniture from your home, including donation coordination when possible.'],
        ]
    ],
];

$content = isset($service_content[$slug]) ? $service_content[$slug] : null;
if (!$content) {
    header('Location: services.php');
    exit;
}

$page_title = $service['title'] . ' Services in UAE';
$page_description = $content['meta_desc'];
require_once 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><?php echo $service['title']; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/services.php">Services</a></li>
                <li class="breadcrumb-item active"><?php echo $service['title']; ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- Service Content -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <img src="assets/images/<?php echo $service['image']; ?>" alt="<?php echo $service['title']; ?>" class="img-fluid rounded-4 shadow mb-4" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1600518464441-9154a4dea21b?w=800&h=400&fit=crop'">
                
                <h2 class="mb-3"><?php echo $service['title']; ?> Services in UAE</h2>
                <p class="lead text-muted mb-4"><?php echo $content['intro']; ?></p>
                
                <?php echo $content['content']; ?>
                
                <!-- Process Steps -->
                <h3 class="mt-5 mb-4">How It Works</h3>
                <div class="row g-3 mb-5">
                    <div class="col-md-3 col-6">
                        <div class="process-step">
                            <div class="step-number">1</div>
                            <h4>Contact Us</h4>
                            <p>Call, WhatsApp, or fill our form</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="process-step">
                            <div class="step-number">2</div>
                            <h4>Free Survey</h4>
                            <p>On-site assessment</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="process-step">
                            <div class="step-number">3</div>
                            <h4>Service Day</h4>
                            <p>Professional execution</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="process-step">
                            <div class="step-number">4</div>
                            <h4>All Done!</h4>
                            <p>Satisfaction guaranteed</p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ -->
                <?php if (!empty($content['faqs'])): ?>
                <h3 class="mb-4">Frequently Asked Questions</h3>
                <div class="accordion faq-accordion" id="serviceFaq">
                    <?php foreach ($content['faqs'] as $i => $faq): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php echo $i > 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?php echo $i; ?>">
                                <?php echo $faq['q']; ?>
                            </button>
                        </h2>
                        <div id="faq<?php echo $i; ?>" class="accordion-collapse collapse <?php echo $i === 0 ? 'show' : ''; ?>" data-bs-parent="#serviceFaq">
                            <div class="accordion-body"><?php echo $faq['a']; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Quote -->
                <div class="quote-form-wrapper mb-4" style="position:sticky; top:100px;">
                    <h3><i class="bi bi-envelope-paper text-accent"></i> Quick Quote</h3>
                    <form action="quote.php" method="POST" class="needs-validation" novalidate>
                        <?php csrfField(); ?>
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control form-control-vip" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" name="phone" class="form-control form-control-vip" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="moving_from" class="form-control form-control-vip" placeholder="Moving From" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="moving_to" class="form-control form-control-vip" placeholder="Moving To" required>
                        </div>
                        <input type="hidden" name="property_type" value="<?php echo strpos($slug, 'villa') !== false ? 'Villa' : (strpos($slug, 'office') !== false ? 'Office' : 'Apartment'); ?>">
                        <button type="submit" name="submit_quote" class="btn btn-vip-accent w-100">
                            <i class="bi bi-send"></i> Get Free Quote
                        </button>
                    </form>
                </div>
                
                <!-- Other Services -->
                <div class="p-4 rounded-4" style="background:var(--off-white);">
                    <h4 class="mb-3" style="font-family:var(--font-body); font-size:1.1rem; font-weight:700;">Other Services</h4>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($SERVICES as $s): ?>
                        <?php if ($s['slug'] !== $slug): ?>
                        <li class="mb-2">
                            <a href="service-single.php?service=<?php echo $s['slug']; ?>" class="d-flex align-items-center gap-2" style="color:var(--text); font-weight:500;">
                                <i class="bi <?php echo $s['icon']; ?> text-accent"></i> <?php echo $s['title']; ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- WhatsApp CTA -->
                <div class="p-4 rounded-4 text-center mt-4" style="background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff;">
                    <h4 class="text-white mb-2" style="font-family:var(--font-body); font-size:1.1rem;">Need Help?</h4>
                    <p style="opacity:0.8; font-size:0.9rem;">Chat with us on WhatsApp for instant assistance.</p>
                    <a href="https://wa.me/<?php echo WHATSAPP; ?>?text=Hi%2C%20I%20need%20<?php echo urlencode($service['title']); ?>%20service" class="btn btn-vip-accent btn-sm-vip" target="_blank">
                        <i class="bi bi-whatsapp"></i> Chat Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="cta-banner">
    <div class="container text-center position-relative" style="z-index:2;">
        <h2>Ready to Book Your <?php echo $service['title']; ?>?</h2>
        <p>Contact us now for a free survey and no-obligation quote.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="quote.php" class="btn btn-vip-accent"><i class="bi bi-envelope-paper"></i> Get Free Quote</a>
            <a href="tel:<?php echo PHONE; ?>" class="btn btn-vip-outline"><i class="bi bi-telephone"></i> Call Now</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
