<?php
/**
 * VIP House Shifting - Site Configuration
 */

// Database (InfinityFree)
define('DB_HOST', 'sql106.infinityfree.com');
define('DB_NAME', 'if0_41179338_db1');
define('DB_USER', 'if0_41179338');
define('DB_PASS', 'JHYtuzTmuKX');

// Site Info
define('SITE_NAME', 'VIP House Shifting');
define('SITE_TAGLINE', 'Professional Movers in UAE');
define('SITE_URL', 'https://humayun.kesug.com');
define('SITE_EMAIL', 'info@viphouseshifting.ae');

// Contact
define('PHONE', '0558801137');
define('WHATSAPP', '971558801137');
define('WHATSAPP_DISPLAY', '055 880 1137');
define('OFFICE_ADDRESS', 'Dubai, United Arab Emirates');

// Services
$SERVICES = [
    [
        'slug' => 'house-shifting',
        'title' => 'House Shifting',
        'icon' => 'bi-house-door',
        'short' => 'Safe and reliable house moving services across all UAE emirates.',
        'image' => 'house-shifting.jpg'
    ],
    [
        'slug' => 'villa-moving',
        'title' => 'Villa Moving',
        'icon' => 'bi-building',
        'short' => 'Premium villa relocation with careful handling of all your belongings.',
        'image' => 'villa-moving.jpg'
    ],
    [
        'slug' => 'office-relocation',
        'title' => 'Office Relocation',
        'icon' => 'bi-briefcase',
        'short' => 'Minimize downtime with our efficient office moving solutions.',
        'image' => 'office-relocation.jpg'
    ],
    [
        'slug' => 'packing-services',
        'title' => 'Packing Services',
        'icon' => 'bi-box-seam',
        'short' => 'Professional packing using high-quality materials to protect your items.',
        'image' => 'packing-services.jpg'
    ],
    [
        'slug' => 'furniture-assembly',
        'title' => 'Furniture Assembly',
        'icon' => 'bi-tools',
        'short' => 'Expert disassembly and reassembly of all furniture types.',
        'image' => 'furniture-assembly.jpg'
    ]
];

// Service Areas
$SERVICE_AREAS = ['Dubai', 'Sharjah', 'Abu Dhabi', 'Ajman', 'Al Ain'];

// Working Hours
define('WORKING_HOURS', '24/7 Available');

// Upload paths
define('UPLOAD_BLOG', 'assets/uploads/blog/');
define('UPLOAD_GALLERY', 'assets/uploads/gallery/');
