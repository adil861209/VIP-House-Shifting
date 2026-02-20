-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql106.infinityfree.com
-- Generation Time: Feb 18, 2026 at 08:16 PM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41179338_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `content`, `image`, `created_at`) VALUES
(1, 'Best Movers in Dubai – How to Choose the Right Moving Company', 'best-movers-in-dubai-how-to-choose-the-right-moving-company', '<h1>Best Movers in Dubai – How to Choose the Right Moving Company</h1>\r\n\r\n<p>Moving to a new home or office in Dubai can be exciting, but choosing the wrong moving company can turn it into a stressful experience. With so many movers in Dubai, how do you know which one is reliable, affordable, and professional?</p>\r\n\r\n<p>In this guide, we will help you choose the best movers in Dubai so your move is safe, fast, and completely hassle-free.</p>\r\n\r\n<h2>1. Check License and Insurance</h2>\r\n<p>Always choose a moving company that is licensed and insured. This protects your furniture and personal belongings in case of damage during packing, loading, or transportation.</p>\r\n\r\n<h2>2. Look for Experience</h2>\r\n<p>Experience matters in the moving industry. A company with years of experience understands:</p>\r\n<ul>\r\n<li>How to pack fragile items safely</li>\r\n<li>How to move large furniture through elevators and stairs</li>\r\n<li>How to transport items without damage</li>\r\n</ul>\r\n\r\n<p>Professional movers also use modern equipment and trained staff.</p>\r\n\r\n<h2>3. Ask About Packing Materials</h2>\r\n<p>High-quality packing materials make a huge difference. Good movers use:</p>\r\n<ul>\r\n<li>Bubble wrap for fragile items</li>\r\n<li>Thick carton boxes</li>\r\n<li>Stretch wrapping for sofas and beds</li>\r\n<li>Protective covers for appliances</li>\r\n</ul>\r\n\r\n<p>This ensures your furniture arrives in perfect condition.</p>\r\n\r\n<h2>4. Read Customer Reviews</h2>\r\n<p>Before hiring movers in Dubai, check their:</p>\r\n<ul>\r\n<li>Google reviews</li>\r\n<li>WhatsApp testimonials</li>\r\n<li>Before and after moving photos</li>\r\n</ul>\r\n\r\n<p>Positive reviews show that the company is trustworthy and professional.</p>\r\n\r\n<h2>5. Get a Free Quote</h2>\r\n<p>Reliable movers always provide a free survey and quotation. Avoid companies that give very low prices without inspection, as this may lead to hidden charges later.</p>\r\n\r\n<h2>6. Check Services Offered</h2>\r\n<p>The best moving companies offer complete solutions:</p>\r\n<ul>\r\n<li>House shifting</li>\r\n<li>Villa moving</li>\r\n<li>Office relocation</li>\r\n<li>Packing and unpacking</li>\r\n<li>Furniture dismantling and assembly</li>\r\n</ul>\r\n\r\n<h2>Why Choose VIP HOUSE SHIFTING?</h2>\r\n<p>At <strong>VIP HOUSE SHIFTING</strong>, we provide professional moving services across Dubai, Sharjah, Abu Dhabi, Ajman, and Al Ain.</p>\r\n\r\n<ul>\r\n<li>✔️ Professional and trained team</li>\r\n<li>✔️ Affordable prices</li>\r\n<li>✔️ Damage-free guarantee</li>\r\n<li>✔️ Modern equipment</li>\r\n<li>✔️ Free quote</li>\r\n</ul>\r\n\r\n<h2>Final Thoughts</h2>\r\n<p>Choosing the right movers in Dubai saves you time, money, and stress. Always check experience, reviews, packing quality, and pricing before making a decision.</p>\r\n\r\n<p>If you are planning a move, contact <strong>VIP HOUSE SHIFTING</strong> today for a safe and reliable moving experience.</p>\r\n\r\n<p><a href=\"/vip-house-shifting/quote.php\" class=\"btn btn-primary\">Get Your Free Quote Now</a></p>', 'blog_69944bf5e6295.jpeg', '2026-02-17 11:07:33'),
(2, 'How Much Does Moving Cost in UAE? Complete Price Guide', 'how-much-does-moving-cost-in-uae-complete-price-guide', '<h1>How Much Does Moving Cost in UAE? Complete Price Guide</h1>\r\n\r\n<p>One of the most common questions people ask is: <strong>“How much does house shifting cost in UAE?”</strong></p>\r\n\r\n<p>The cost of moving depends on several factors such as apartment size, distance, packing requirements, and furniture volume.</p>\r\n\r\n<h2>Average Moving Costs in UAE</h2>\r\n\r\n<h3>Studio Apartment</h3>\r\n<ul>\r\n<li>AED 500 – AED 900</li>\r\n</ul>\r\n\r\n<h3>1 Bedroom Apartment</h3>\r\n<ul>\r\n<li>AED 800 – AED 1,200</li>\r\n</ul>\r\n\r\n<h3>2 Bedroom Apartment</h3>\r\n<ul>\r\n<li>AED 1,200 – AED 1,800</li>\r\n</ul>\r\n\r\n<h3>3 Bedroom Villa</h3>\r\n<ul>\r\n<li>AED 2,500 – AED 4,000</li>\r\n</ul>\r\n\r\n<p>These prices may change depending on packing, dismantling, and distance.</p>\r\n\r\n<h2>Factors That Affect Moving Price</h2>\r\n\r\n<h3>1. Size of the Move</h3>\r\n<p>More furniture means more packing materials, more labor, and a bigger truck.</p>\r\n\r\n<h3>2. Packing Services</h3>\r\n<p>If you choose professional packing with bubble wrap and cartons, the cost will be slightly higher but your items will be safer.</p>\r\n\r\n<h3>3. Dismantling & Assembly</h3>\r\n<p>Items like:</p>\r\n<ul>\r\n<li>Beds</li>\r\n<li>Wardrobes</li>\r\n<li>IKEA furniture</li>\r\n<li>Curtains</li>\r\n</ul>\r\n<p>require extra time and tools.</p>\r\n\r\n<h3>4. Distance Between Locations</h3>\r\n<p>Moving within Dubai costs less than moving from Dubai to Abu Dhabi or Al Ain.</p>\r\n\r\n<h2>How to Save Money on Moving</h2>\r\n<ul>\r\n<li>Book your move in advance</li>\r\n<li>Declutter unwanted items</li>\r\n<li>Choose weekday moving</li>\r\n<li>Get a free survey for accurate pricing</li>\r\n</ul>\r\n\r\n<h2>Why Choose VIP HOUSE SHIFTING?</h2>\r\n<p>We offer affordable and transparent pricing with no hidden charges.</p>\r\n\r\n<ul>\r\n<li>✔️ Free inspection and quote</li>\r\n<li>✔️ Professional packing</li>\r\n<li>✔️ Safe transportation</li>\r\n<li>✔️ On-time delivery</li>\r\n</ul>\r\n\r\n<h2>Get a Free Moving Quote Today</h2>\r\n<p>If you want to know the exact cost of your move, contact <strong>VIP HOUSE SHIFTING</strong> today. Our team will provide a fast and accurate quotation based on your requirements.</p>\r\n\r\n<p><a href=\"/vip-house-shifting/quote.php\" class=\"btn btn-success\">Request Your Free Quote</a></p>', 'blog_69944c22e4f06.jpeg', '2026-02-17 11:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` enum('Packing','Moving','Trucks','Team','Before/After') DEFAULT 'Moving',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image`, `category`, `uploaded_at`) VALUES
(1, 'gallery_6994498d3e961.jpg', 'Packing', '2026-02-17 10:57:17'),
(2, 'gallery_699449a2dea9d.jpg', 'Moving', '2026-02-17 10:57:38'),
(3, 'gallery_699449b06cd23.jpg', 'Packing', '2026-02-17 10:57:52'),
(4, 'gallery_699449b921668.jpg', 'Moving', '2026-02-17 10:58:01'),
(5, 'gallery_699449c008342.png', 'Trucks', '2026-02-17 10:58:08'),
(6, 'gallery_699449c7768be.jpg', 'Team', '2026-02-17 10:58:15'),
(7, 'gallery_699449d0e1c0e.jpg', 'Packing', '2026-02-17 10:58:24'),
(8, 'gallery_699449da29770.jpg', 'Trucks', '2026-02-17 10:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `moving_from` varchar(255) NOT NULL,
  `moving_to` varchar(255) NOT NULL,
  `property_type` enum('Apartment','Villa','Office','Other') DEFAULT 'Apartment',
  `moving_date` date DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('New','Contacted','Closed') DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `name`, `phone`, `email`, `moving_from`, `moving_to`, `property_type`, `moving_date`, `message`, `status`, `created_at`) VALUES
(1, 'Muhammad Adil', '03156527846', 'adil861209@gmail.com', 'Dubai', 'AJMAN', 'Office', '2026-02-20', 'asdasdasdjahsdjkashldashljkd', 'New', '2026-02-17 05:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$s1S9mLWqc5eShKn6EcG3X.FuR5QxtRReVjnIq3W11RQC6btfi6S/C', '2026-02-16 17:34:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
