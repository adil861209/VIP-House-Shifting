    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row g-4">
                <!-- About Column -->
                <div class="col-lg-4 col-md-6">
                    <h4>VIP House Shifting</h4>
                    <p>Your trusted partner for professional moving services across UAE. We provide safe, fast, and reliable house shifting, villa moving, and office relocation services.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-white" style="font-size:1.2rem;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white" style="font-size:1.2rem;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white" style="font-size:1.2rem;"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-white" style="font-size:1.2rem;"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo SITE_URL; ?>/"><i class="bi bi-chevron-right"></i> Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/about.php"><i class="bi bi-chevron-right"></i> About Us</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php"><i class="bi bi-chevron-right"></i> Services</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/gallery.php"><i class="bi bi-chevron-right"></i> Gallery</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/blog.php"><i class="bi bi-chevron-right"></i> Blog</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact.php"><i class="bi bi-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <h4>Our Services</h4>
                    <ul class="footer-links">
                        <?php foreach ($SERVICES as $service): ?>
                        <li><a href="<?php echo SITE_URL; ?>/service-single.php?service=<?php echo $service['slug']; ?>"><i class="bi bi-chevron-right"></i> <?php echo $service['title']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <h4>Contact Us</h4>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <span><?php echo OFFICE_ADDRESS; ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <span><a href="tel:<?php echo PHONE; ?>" class="text-white"><?php echo WHATSAPP_DISPLAY; ?></a></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-whatsapp"></i>
                        <span><a href="https://wa.me/<?php echo WHATSAPP; ?>" class="text-white" target="_blank">WhatsApp Us</a></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <span><a href="mailto:<?php echo SITE_EMAIL; ?>" class="text-white"><?php echo SITE_EMAIL; ?></a></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-clock"></i>
                        <span><?php echo WORKING_HOURS; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/<?php echo WHATSAPP; ?>?text=Hello%2C%20I%20need%20a%20moving%20quote" class="whatsapp-float" target="_blank" title="Chat on WhatsApp" id="whatsappFloat">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Mobile Call Button -->
    <a href="tel:<?php echo PHONE; ?>" class="call-float" title="Call Now" id="callFloat">
        <i class="bi bi-telephone-fill"></i>
    </a>

    <!-- Back to Top -->
    <a href="#" class="back-to-top" id="backToTop" title="Back to Top">
        <i class="bi bi-chevron-up"></i>
    </a>

    <!-- Lightbox Modal -->
    <div class="modal fade lightbox-modal" id="lightboxModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    <img id="lightboxImage" src="" alt="Gallery Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Language Switcher JS (must load before Google Translate) -->
    <script src="<?php echo SITE_URL; ?>/assets/js/lang.js"></script>
    
    <!-- Google Translate -->
    <div id="google_translate_element" style="position:absolute;top:-9999px;left:-9999px;"></div>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <!-- Main JS -->
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
