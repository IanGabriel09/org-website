-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 11:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `org_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `username`, `password`) VALUES
('UUID001', 'TCS_Admin1', '$2y$10$c7.tFXxwXi6xA4s3dry0A.YSbnC2e1p0JYCeHH.kZx9xnBprxaZWG');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_products`
--

CREATE TABLE `affiliate_products` (
  `id` int(11) NOT NULL,
  `fk_company_id` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `affiliate_products`
--

INSERT INTO `affiliate_products` (`id`, `fk_company_id`, `product_name`, `product_description`, `product_image`) VALUES
(33, 'ENV-55902150', 'Sample Product 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'c1abc4f5-0a5a-468a-88a1-    b5e134ee.png'),
(34, 'ENV-55902150', 'Sample Product 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '8421312d-68a3-4feb-a563-    fbf61e60.png'),
(35, 'ENV-55902150', 'Sample Product 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '5c81416e-e67f-41a0-8936-    c6aa715c.png'),
(36, 'ENV-55902150', 'Sample Product 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '702a6f25-fc9d-4b34-9606-    3856b8a9.png'),
(37, 'ENV-55902150', 'Sample Product 5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'be97d675-fded-4e31-b0e0-    ef2e780e.png'),
(38, 'ENV-55902150', 'Sample Product 6', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'ff4eda83-5491-4461-bbea-    80c9b16f.png'),
(46, 'ENV-68421266', 'Sample Product 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', 'e287ba0a-d9ae-47bd-948e-     175e48f.png'),
(47, 'ENV-68421266', 'Sample Product 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '65eb43a8-fced-4cc5-a22c-    b43d40b9.png'),
(48, 'ENV-68421266', 'Sample Product 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '0a3d97d7-aac6-4743-bdc5-    66dc4513.png'),
(49, 'ENV-68421266', 'Sample Product 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '4778968b-1413-4081-af16-    7280332f.png'),
(50, 'ENV-68421266', 'Sample Product 5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', 'b1c328b1-f7f6-44a2-add4-    6e1630fd.png'),
(51, 'ENV-68421266', 'Sample Product 6', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', 'e02fd9cd-d1fb-4c47-8447-    35ac247d.png');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_table`
--

CREATE TABLE `affiliate_table` (
  `company_id` varchar(50) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `business_type` varchar(255) NOT NULL,
  `company_description` longtext DEFAULT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `web_link` longtext NOT NULL,
  `company_img` longtext DEFAULT NULL,
  `date_uploaded` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `affiliate_table`
--

INSERT INTO `affiliate_table` (`company_id`, `company_name`, `business_type`, `company_description`, `contact`, `email`, `web_link`, `company_img`, `date_uploaded`) VALUES
('ENV-55902150', 'D2 Racing &ATK PHILIPPINES ', '機車改裝部品零件', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '09479979219', 'Harry1726121@gmail.com', 'https://www.facebook.com/D2RacingPH/videos/', '15111ea5-03d0-4c80-8fe7-    b0f9f5a1.jpg', '2025-03-17 01:22:57.906710'),
('ENV-68421266', 'Sample Company', 'Sample', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '+123-456', 'sampleuser@example.com', 'https://example.com/', NULL, '2025-03-17 00:38:12.000000'),
('ENV-83505590', 'Hocheng Philippines Corporation ', '衛浴設備', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '+63 917-8153-901', 'paul760313@gmail.com', 'https://www.hcg.com.ph/about', '52eb0d71-e4d9-4960-8d85-    7e3f90a6.jpg', '2025-03-17 01:22:59.832191');

-- --------------------------------------------------------

--
-- Table structure for table `blog_featured`
--

CREATE TABLE `blog_featured` (
  `blog_num` int(32) NOT NULL,
  `featured_order` tinyint(1) NOT NULL
) ;

--
-- Dumping data for table `blog_featured`
--

INSERT INTO `blog_featured` (`blog_num`, `featured_order`) VALUES
(11, 1),
(12, 2),
(13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `blog_table`
--

CREATE TABLE `blog_table` (
  `blog_num` int(32) NOT NULL,
  `blog_id` varchar(255) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_content` longtext NOT NULL,
  `blog_img` longtext NOT NULL,
  `upload_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_table`
--

INSERT INTO `blog_table` (`blog_num`, `blog_id`, `blog_title`, `blog_content`, `blog_img`, `upload_date`) VALUES
(11, 'blog-001', 'Blog Title 11', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(12, 'blog-002', 'Blog Title 12', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(13, 'blog-003', 'Blog Title 13', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(14, 'blog-004', 'Blog Title 14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(15, 'blog-005', 'Blog Title 15', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(16, 'blog-006', 'Blog Title 16', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(17, 'blog-007', 'Blog Title 17', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(18, 'blog-008', 'Blog Title 18', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552'),
(19, 'blog-009', 'Blog Title 19', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tincidunt urna ac nunc pharetra, non tincidunt eros ultricies. Sed bibendum ante sed lorem lacinia, vel tincidunt elit congue. Vivamus et dolor vulputate, pharetra lorem non, iaculis libero. Integer ultricies, velit id pharetra auctor, velit arcu gravida ipsum, ac facilisis purus ante eu lectus. Curabitur sit amet lectus vel nulla dignissim fringilla in nec lectus. Donec vel justo at arcu tincidunt cursus.', 'blogImg.png', '2025-03-08 01:50:46.976552');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` varchar(20) NOT NULL,
  `date_uploaded` timestamp(6) NULL DEFAULT NULL,
  `event_name` varchar(250) NOT NULL,
  `event_pic` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `date_uploaded`, `event_name`, `event_pic`) VALUES
('ENV-35272053', '2025-02-13 03:29:22.000000', 'event1', '../../../assets/img/eventAlbums/cf9e0d1f-e5e7-4762-8106-    36670422.jpg'),
('ENV-38887159', '2025-02-13 03:30:00.000000', 'event3', '../../../assets/img/eventAlbums/a333be46-a31d-4b12-abdc-    b4fb0a70.jpg'),
('ENV-43448080', '2025-02-13 03:29:43.000000', 'event2', '../../../assets/img/eventAlbums/42b7a1d8-2af7-4b40-bfeb-    375f53c5.jpg'),
('ENV-53483300', '2025-02-13 03:30:00.000000', 'event3', '../../../assets/img/eventAlbums/8c10251e-3f2c-46fa-9045-    3490268f.jpg'),
('ENV-72839426', '2025-02-13 03:29:43.000000', 'event2', '../../../assets/img/eventAlbums/f966997c-c5df-45ec-adc5-    68e700a1.jpg'),
('ENV-83373149', '2025-03-08 00:55:30.000000', 'event4', '../../../assets/img/eventAlbums/4c2d960f-f5d3-45ac-a9ac-    ade1c87b.webp');

-- --------------------------------------------------------

--
-- Table structure for table `excel_table`
--

CREATE TABLE `excel_table` (
  `id` varchar(20) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_description` longtext NOT NULL,
  `excel_file` varchar(255) DEFAULT NULL,
  `date_created` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `excel_table`
--

INSERT INTO `excel_table` (`id`, `period_start`, `period_end`, `company_name`, `company_description`, `excel_file`, `date_created`) VALUES
('UUID281830', '2024-01-01', '2025-01-01', 'Sample Company', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '../../../assets/excel/Book1.xlsx', '2025-03-17 06:12:43.000000'),
('UUID685741', '2024-01-01', '2025-01-01', 'Sample Company 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '../../../assets/excel/Book2.xlsx', '2025-03-17 07:25:55.000000');

-- --------------------------------------------------------

--
-- Table structure for table `news_table`
--

CREATE TABLE `news_table` (
  `news_id` varchar(20) NOT NULL,
  `news_name` varchar(255) DEFAULT NULL,
  `expected_date` date DEFAULT NULL,
  `news_description` longtext DEFAULT NULL,
  `news_img` longtext DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news_table`
--

INSERT INTO `news_table` (`news_id`, `news_name`, `expected_date`, `news_description`, `news_img`, `created_at`) VALUES
('ENV-45094996', 'Sample News 3', '2025-03-14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '../../../assets/img/newsImg/87d3f90d-c132-49c6-8f13-    da029d35.webp', '2025-02-13 03:17:46.000000'),
('ENV-45284166', 'Sample News 4', '2025-03-16', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '../../../assets/img/newsImg/73fc021f-1b4f-4da5-86af-    a4aff2d8.webp', '2025-02-13 03:18:07.000000'),
('ENV-80866805', 'Sample News 6', '2025-02-13', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '../../../assets/img/newsImg/3dac13c4-9ae7-4f90-9aca-    1441b3f2.webp', '2025-02-13 05:23:40.000000'),
('ENV-88197909', 'Sample News', '2025-02-20', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '../../../assets/img/newsImg/d433d0ba-be31-4c34-82e4-    5032ade1.webp', '2025-02-13 03:17:05.000000'),
('ENV-98700804', 'Sample News 5', '2025-04-10', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '../../../assets/img/newsImg/419311b8-e58b-47b0-bd11-    ea09d737.webp', '2025-02-13 03:18:20.000000');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `tk_id` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `recovery_token` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`tk_id`, `user_id`, `name`, `email`, `password`, `status`, `recovery_token`) VALUES
(NULL, 'UUID223181', 'Ian Gabriel Delos Reyes Durian', 'iangabrieldurian@gmail.com', '$2y$10$se2U6CZDFRL8fffyYsG/oezJgCHa0ON7lliGPVYYv7R9X9Po/3IYS', NULL, NULL),
(NULL, 'UUID811632', 'Akali', 'akalikayn0900@gmail.com', '$2y$10$30ySvm23dqqWYFkZS1OjBOSu9Y4VWb0ruF7X4k6q.ubmvpG9/jSpe', NULL, NULL),
(NULL, 'UUID840090', 'user1', 'sampleuser@example.com', '$2y$10$MLrF4yONvpu8JJ5B0iQgRuLSe4XLBmcopp61AG9CuVutaMBCuRUQS', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `affiliate_products`
--
ALTER TABLE `affiliate_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_id` (`fk_company_id`);

--
-- Indexes for table `affiliate_table`
--
ALTER TABLE `affiliate_table`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `blog_featured`
--
ALTER TABLE `blog_featured`
  ADD PRIMARY KEY (`blog_num`),
  ADD UNIQUE KEY `featured_order` (`featured_order`),
  ADD UNIQUE KEY `featured_order_2` (`featured_order`);

--
-- Indexes for table `blog_table`
--
ALTER TABLE `blog_table`
  ADD PRIMARY KEY (`blog_num`),
  ADD UNIQUE KEY `blog_id` (`blog_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `excel_table`
--
ALTER TABLE `excel_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_table`
--
ALTER TABLE `news_table`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_products`
--
ALTER TABLE `affiliate_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `blog_table`
--
ALTER TABLE `blog_table`
  MODIFY `blog_num` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affiliate_products`
--
ALTER TABLE `affiliate_products`
  ADD CONSTRAINT `affiliate_products_ibfk_1` FOREIGN KEY (`fk_company_id`) REFERENCES `affiliate_table` (`company_id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_featured`
--
ALTER TABLE `blog_featured`
  ADD CONSTRAINT `fk_blog_num` FOREIGN KEY (`blog_num`) REFERENCES `blog_table` (`blog_num`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
