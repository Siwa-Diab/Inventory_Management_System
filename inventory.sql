-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2024 at 10:13 PM
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
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(111) NOT NULL,
  `supplier` int(111) NOT NULL,
  `product` int(111) NOT NULL,
  `quantity_ordered` int(111) NOT NULL,
  `quantity_received` int(111) NOT NULL,
  `quantity_remaining` int(111) NOT NULL,
  `status` varchar(20) NOT NULL,
  `batch` int(20) NOT NULL,
  `created_by` int(111) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `received_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `supplier`, `product`, `quantity_ordered`, `quantity_received`, `quantity_remaining`, `status`, `batch`, `created_by`, `created_at`, `updated_at`, `received_at`) VALUES
(14, 37, 58, 200, 200, 0, 'complete', 1704909760, 1, '2024-01-10 20:02:40', '2024-01-10 20:02:40', '2024-01-15 18:26:58'),
(17, 40, 65, 25, 25, 0, 'complete', 1704909828, 1, '2024-01-10 20:03:48', '2024-01-10 20:03:48', '2024-01-15 18:26:58'),
(18, 36, 56, 150, 47, 103, 'pending', 1704909844, 1, '2024-01-10 20:04:04', '2024-01-10 20:04:04', '2024-01-15 18:26:58'),
(26, 33, 50, 15, 0, 15, 'incomplete', 1705335828, 1, '2024-01-15 18:23:48', '2024-01-15 18:23:48', '2024-01-15 18:26:58'),
(27, 39, 63, 50, 0, 50, 'incomplete', 1705335841, 1, '2024-01-15 18:24:01', '2024-01-15 18:24:01', '2024-01-15 18:26:58'),
(28, 34, 51, 15, 0, 15, 'incomplete', 1705335855, 1, '2024-01-15 18:24:15', '2024-01-15 18:24:15', '2024-01-15 18:26:58'),
(29, 35, 55, 300, 0, 300, 'incomplete', 1705335866, 1, '2024-01-15 18:24:26', '2024-01-15 18:24:26', '2024-01-15 18:26:58'),
(30, 34, 52, 80, 40, 40, 'pending', 1705335878, 1, '2024-01-15 18:24:38', '2024-01-15 18:24:38', '2024-01-15 18:26:58'),
(31, 36, 57, 65, 15, 50, 'pending', 1705335903, 1, '2024-01-15 18:25:03', '2024-01-15 18:25:03', '2024-01-15 18:26:58'),
(32, 38, 61, 25, 5, 20, 'pending', 1705335917, 1, '2024-01-15 18:25:17', '2024-01-15 18:25:17', '2024-01-15 18:26:16'),
(33, 38, 62, 20, 20, 0, 'complete', 1705335924, 1, '2024-01-15 18:25:24', '2024-01-15 18:25:24', '2024-01-15 18:26:16'),
(34, 33, 49, 15, 0, 0, 'incomplete', 1705336048, 1, '2024-01-15 18:27:28', '2024-01-15 18:27:28', '2024-01-15 18:27:28'),
(35, 37, 59, 10, 0, 0, 'incomplete', 1705352682, 1, '2024-01-15 23:04:42', '2024-01-15 23:04:42', '2024-01-15 23:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(111) NOT NULL,
  `product_name` varchar(180) NOT NULL,
  `description` varchar(200) NOT NULL,
  `img` varchar(100) NOT NULL,
  `created_by` int(111) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `img`, `created_by`, `created_at`, `updated_at`) VALUES
(49, 'Tide Laundry Detergent', 'Used for cleaning clothes and fabrics ', 'tide.png', 1, '2024-01-10 18:47:57', '2024-01-10 18:47:57'),
(50, 'Pampers Diapers', 'Diapers for babies', 'pampers.png', 1, '2024-01-10 18:48:31', '2024-01-10 18:48:31'),
(51, 'Dove Beauty Bar', 'Used to soften skin and make it glow', 'dove.png', 1, '2024-01-10 18:49:15', '2024-01-10 18:49:15'),
(52, 'Lipton Tea', 'A delicious tea', 'lipton.png', 1, '2024-01-10 18:49:47', '2024-01-10 18:49:47'),
(53, 'Nestle Crunch Chocolate', 'kids prefer this type of crunchies ', 'nestleCrunch.png', 1, '2024-01-10 18:50:50', '2024-01-10 18:50:50'),
(54, 'Nescafe Instant Coffee', 'who doesnt know what nescafe is', 'nescafe.png', 1, '2024-01-10 18:51:30', '2024-01-10 18:51:30'),
(55, 'Nestlé Pure Life Water', 'water', 'nestle_Water.png', 1, '2024-01-10 18:51:56', '2024-01-10 18:51:56'),
(56, 'Coca-Cola', 'soda', 'coca_cola.png', 1, '2024-01-10 18:52:30', '2024-01-10 18:52:30'),
(57, 'Sprite', 'like 7up', 'sprite.png', 1, '2024-01-10 18:52:54', '2024-01-10 18:52:54'),
(58, 'pepsi', 'the most popular drink in the world', 'pepsi_bottle.png', 1, '2024-01-10 18:53:23', '2024-01-10 18:53:23'),
(59, 'Lays Potato Chips', 'chips and crisps , this one is the original one ', 'lays.png', 1, '2024-01-10 18:54:01', '2024-01-10 18:54:01'),
(61, 'Johnsons Baby Shampoo', 'Johnsons Baby Shampoo', 'johnson.png', 1, '2024-01-10 18:55:04', '2024-01-10 18:55:04'),
(62, 'Johnsons Baby oil', '    ', 'J_oil.png', 1, '2024-01-10 18:55:28', '2024-01-10 18:55:28'),
(63, 'Snickers Chocolate Bar', 'chocolate with peanuts in it ', 'snickers.png', 1, '2024-01-10 18:56:06', '2024-01-10 18:56:06'),
(65, 'Heinz Ketchup', 'ketchup', 'Ketchup.png', 1, '2024-01-10 18:57:31', '2024-01-10 18:57:31'),
(68, 'Nestle', 'sweetened condensed milk', 'nestle_condensed_milk.png', 1, '2024-01-10 20:04:38', '2024-01-15 23:03:49'),
(69, 'pringles', 'potato crisps (original taste)  ', 'pringles.png', 1, '2024-01-15 15:10:37', '2024-01-15 17:11:37'),
(71, 'maggi', 'Instant noodles,soups,and seasoning', 'Maggi.png', 1, '2024-01-15 17:36:23', '2024-01-15 17:36:23'),
(72, 'Nido', 'Powdered milk   ', 'Nido.png', 1, '2024-01-15 17:38:15', '2024-01-15 17:38:15'),
(73, 'kit kat', 'a delicious chocolate that has a slight crunch  ', 'kitkat.png', 1, '2024-01-15 17:39:37', '2024-01-15 17:39:37'),
(74, 'Nestea', 'Iced tea and tea-related beverages ', 'nestea.png', 1, '2024-01-15 17:40:47', '2024-01-15 17:40:47'),
(75, 'mountain due', 'an energy drink   ', 'mountain_due.png', 1, '2024-01-15 17:44:14', '2024-01-15 17:44:14'),
(76, 'Doritos', 'tortilla chips  ', 'Doritos.png', 1, '2024-01-15 17:45:33', '2024-01-15 17:45:33'),
(77, 'Cheetos', 'cheese flavored snacks   ', 'cheetos.png', 1, '2024-01-15 17:46:41', '2024-01-15 17:46:41'),
(78, 'Tropicana', 'fruit juices', 'tropicana.png', 1, '2024-01-15 17:47:51', '2024-01-15 17:47:51'),
(79, 'Johnsons baby lotion ', 'A popular product for moisturizing babys delicate skin', 'baby_lotion.png', 1, '2024-01-15 17:50:31', '2024-01-15 17:50:31'),
(80, 'johnsons baby powder', 'Talcum powder often used for diaper rash prevention', 'baby_powder.png', 1, '2024-01-15 17:52:32', '2024-01-15 17:52:32'),
(82, 'Clorox disinfecting wipes', 'wipes that are used to kill germs and bacteria ', 'clorox_disinfecting_wipes.png', 41, '2024-01-15 18:10:59', '2024-01-15 18:10:59'),
(83, 'Uncle Bens', 'Rice and Grain Products   ', 'Uncle_Ben.png', 41, '2024-01-15 18:14:14', '2024-01-15 18:14:14'),
(84, 'kraft Macaroni and cheese', 'mac and cheese', 'mac_cheese.png', 41, '2024-01-15 18:16:05', '2024-01-15 18:16:05'),
(85, 'philadelphia cheese', 'white cream cheese ', 'philadelphia.png', 41, '2024-01-15 18:19:04', '2024-01-15 18:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `productsuppliers`
--

CREATE TABLE `productsuppliers` (
  `id` int(111) NOT NULL,
  `supplier` int(111) NOT NULL,
  `product` int(111) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productsuppliers`
--

INSERT INTO `productsuppliers` (`id`, `supplier`, `product`, `updated_at`, `created_at`) VALUES
(39, 33, 49, '2024-01-10 18:47:57', '2024-01-10 18:47:57'),
(40, 33, 50, '2024-01-10 18:48:31', '2024-01-10 18:48:31'),
(41, 34, 51, '2024-01-10 18:49:15', '2024-01-10 18:49:15'),
(42, 34, 52, '2024-01-10 18:49:47', '2024-01-10 18:49:47'),
(43, 35, 53, '2024-01-10 18:50:50', '2024-01-10 18:50:50'),
(44, 35, 54, '2024-01-10 18:51:30', '2024-01-10 18:51:30'),
(45, 35, 55, '2024-01-10 18:51:56', '2024-01-10 18:51:56'),
(46, 36, 56, '2024-01-10 18:52:30', '2024-01-10 18:52:30'),
(47, 36, 57, '2024-01-10 18:52:54', '2024-01-10 18:52:54'),
(48, 37, 58, '2024-01-10 18:53:23', '2024-01-10 18:53:23'),
(49, 37, 59, '2024-01-10 18:54:01', '2024-01-10 18:54:01'),
(51, 38, 61, '2024-01-10 18:55:04', '2024-01-10 18:55:04'),
(52, 38, 62, '2024-01-10 18:55:28', '2024-01-10 18:55:28'),
(53, 39, 63, '2024-01-10 18:56:06', '2024-01-10 18:56:06'),
(55, 40, 65, '2024-01-10 18:57:31', '2024-01-10 18:57:31'),
(66, 41, 69, '2024-01-15 17:11:37', '2024-01-15 17:11:37'),
(68, 35, 71, '2024-01-15 17:36:23', '2024-01-15 17:36:23'),
(69, 35, 72, '2024-01-15 17:38:15', '2024-01-15 17:38:15'),
(70, 35, 73, '2024-01-15 17:39:38', '2024-01-15 17:39:38'),
(71, 35, 74, '2024-01-15 17:40:47', '2024-01-15 17:40:47'),
(72, 37, 75, '2024-01-15 17:44:14', '2024-01-15 17:44:14'),
(73, 37, 76, '2024-01-15 17:45:33', '2024-01-15 17:45:33'),
(74, 37, 77, '2024-01-15 17:46:41', '2024-01-15 17:46:41'),
(75, 37, 78, '2024-01-15 17:47:51', '2024-01-15 17:47:51'),
(76, 38, 79, '2024-01-15 17:50:31', '2024-01-15 17:50:31'),
(77, 38, 80, '2024-01-15 17:52:32', '2024-01-15 17:52:32'),
(79, 45, 82, '2024-01-15 18:10:59', '2024-01-15 18:10:59'),
(80, 39, 83, '2024-01-15 18:14:14', '2024-01-15 18:14:14'),
(81, 40, 84, '2024-01-15 18:16:05', '2024-01-15 18:16:05'),
(82, 40, 85, '2024-01-15 18:19:04', '2024-01-15 18:19:04'),
(83, 35, 68, '2024-01-15 23:03:49', '2024-01-15 23:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(111) NOT NULL,
  `supplier_name` varchar(180) NOT NULL,
  `supplier_location` varchar(180) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_by` int(111) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_location`, `email`, `created_by`, `created_at`, `updated_at`) VALUES
(33, 'Procter &Gamble(P&G)', 'Switzerland', 'procter_Gamble@gmail.com', 1, '2024-01-10 18:19:25', '2024-01-10 18:19:25'),
(34, 'Unilever', 'London', 'unliver@gmail.com', 1, '2024-01-10 18:20:03', '2024-01-10 18:20:03'),
(35, 'Nestle', 'SwitzerLand', 'nestleee@gmail.com', 1, '2024-01-10 18:20:37', '2024-01-10 18:20:37'),
(36, 'Coca-Cola Company', 'Emirates', 'cocacola@hotmail.com', 1, '2024-01-10 18:21:13', '2024-01-10 18:21:13'),
(37, 'PepsiCo', 'Mexico', 'pepsico@gmail.com', 1, '2024-01-10 18:21:35', '2024-01-10 18:21:35'),
(38, 'Johnson & Johnson ', 'Russia', 'johnson@gmail.com', 1, '2024-01-10 18:22:15', '2024-01-10 18:22:15'),
(39, 'Mars,Incorporated', 'Poland', 'mars@gmail.com', 1, '2024-01-10 18:22:51', '2024-01-10 18:22:51'),
(40, 'The Kraft Heinz Company', 'America', 'KraftHeinz@gmail.com', 1, '2024-01-10 18:23:29', '2024-01-10 18:23:29'),
(41, 'kelloggs', 'Kuwait', 'Kellogs@gmail.com', 1, '2024-01-10 18:24:50', '2024-01-10 18:24:50'),
(45, 'The Clorox Company', 'Sweden', 'clorox@gmail.com', 1, '2024-01-10 18:27:00', '2024-01-10 18:27:00');

--
-- Triggers `suppliers`
--
DELIMITER $$
CREATE TRIGGER `after_delete_supplier` AFTER DELETE ON `suppliers` FOR EACH ROW BEGIN 
   DECLARE supplier_id INT;
   SET supplier_id=OLD.id;
   
   DELETE FROM productsuppliers WHERE supplier = supplier_id;

DELETE FROM products WHERE id NOT IN (SELECT DISTINCT product FROM productsuppliers);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(111) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Siwa', 'Diab', 'sss', 'siwadiab2003@gmail.com', '2023-12-15 10:32:14', '2024-01-01 15:46:56', 0),
(35, 'Mohammad ', 'Dandash', '$2y$10$VD8hY4VmmLMHKpm3DGVQsORciciwqqWaBzvrdQIh1Mm', 'mohammadandash@gmail.com', '2024-01-10 20:10:44', '2024-01-15 15:15:06', 0),
(41, 'Bushra', 'Nasser', '$2y$10$ZH.QAaTJy8wx.cnzLDrm3.doDE.7S2ESXuMHv15ei//', 'bushra@gmail.com', '2024-01-15 18:06:24', '2024-01-15 18:06:24', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier` (`supplier`) USING BTREE,
  ADD KEY `product` (`product`,`created_by`) USING BTREE,
  ADD KEY `w5` (`created_by`) USING BTREE;

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Indexes for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `whatever` (`product`),
  ADD KEY `whatever1` (`supplier`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `w3` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `w4` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `w5` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD CONSTRAINT `whatever` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `whatever1` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `kk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
