-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2024 at 04:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ateclegrill`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Short Orders'),
(2, 'Value Meals'),
(3, 'Desserts'),
(4, 'All Time Favorites'),
(5, 'Additional');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `category`, `item_name`, `description`, `price`, `image_url`) VALUES
(1, 'Short Orders', 'Special BULALO', NULL, 240.00, 'specialbulalo.png'),
(2, 'Short Orders', 'Fried Chicken', NULL, 165.00, 'friedchicken.jpg'),
(3, 'Short Orders', 'Tinolang Isda', NULL, 125.00, 'tinolangisda.jpg'),
(4, 'Short Orders', 'Pinakbet', NULL, 145.00, 'pinakbet.jpg'),
(5, 'Short Orders', 'Kinilaw', NULL, 145.00, 'kinilaw.jpg'),
(6, 'Short Orders', 'Chopsuey', NULL, 155.00, 'chopsuey.jpg'),
(7, 'Short Orders', 'Sizzling Squid', NULL, 145.00, 'sizzlingsquid.jpg'),
(8, 'Short Orders', 'Calamares', NULL, 125.00, 'calamares.jpg'),
(9, 'Short Orders', 'Pansit Guisado', NULL, 165.00, 'pansit.jpg'),
(10, 'Short Orders', 'Sinuglaw', NULL, 168.00, 'sinuglaw.jpg'),
(11, 'Short Orders', 'Sizzling Sisig Tuna Sisig', NULL, 95.00, 'sizzlingtuna.png'),
(12, 'Short Orders', 'Sizzling Bulalo', NULL, 145.00, 'sizzlingbulalo.png'),
(13, 'Short Orders', 'Grilled Tuna Panga', NULL, 55.00, 'tunapanga.jpg'),
(14, 'Short Orders', 'Grilled Tuna Belly', NULL, 65.00, 'tunabelly.jpg'),
(15, 'Short Orders', 'Grilled Bangus', NULL, 145.00, 'grilledbangus.png'),
(31, 'Value Meals', 'CB1', 'RICE', 15.00, 'rice.jpg'),
(34, 'Value Meals', 'CB2', 'A POT OF RICE', 89.00, 'potrice.jpg'),
(37, 'Desserts', 'Balonolad', NULL, 50.00, 'balonolad.jpg'),
(38, 'Desserts', 'Avocado Shake', NULL, 50.00, 'avocado.jpg'),
(39, 'Desserts', 'Halo-Halo', NULL, 48.00, 'halohalo.png'),
(40, 'Desserts', 'Leche Flan', NULL, 45.00, 'lecheflan.jpg'),
(42, 'Bucket', '5+1 Bucket', 'BEEF BBQ - 20/stick', 350.00, NULL),
(46, 'Value Meals', 'CB3', 'BEEF TAPA with RICE', 75.00, 'beeftapa.jpg'),
(47, 'Value Meals', 'CB4', 'PORK BEST with RICE', 78.00, 'pork.jpg'),
(48, 'Value Meals', 'CB5', 'ROAST BEEF with RICE', 78.00, 'roastbeef.png'),
(49, 'Value Meals', 'CB6', 'CRISPY BANGUS with RICE', 88.00, 'crispybangus.jpg'),
(50, 'Bucket', '5+1 Bucket', 'PORK BBQ - 20/stick', 350.00, NULL),
(51, 'Bucket', '5+1 Bucket', 'ISAW - 10/stick', 300.00, NULL),
(52, 'Bucket', '5+1 Bucket', 'SISIG', 380.00, '5+1.png\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total_amount`, `created_at`) VALUES
(1, 0.00, '2024-07-26 15:14:13'),
(2, 921.00, '2024-07-26 15:25:15'),
(3, 223.00, '2024-07-26 15:29:07'),
(4, 460.00, '2024-07-26 15:59:52'),
(5, 280.00, '2024-07-26 17:16:45'),
(6, 575.00, '2024-07-26 17:21:29'),
(7, 890.00, '2024-07-26 17:21:59'),
(8, 860.00, '2024-07-27 12:32:09'),
(9, 685.00, '2024-07-27 12:46:23'),
(10, 1275.00, '2024-07-27 14:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`) VALUES
(1, 1, 42, 1),
(5, 1, 38, 1),
(7, 1, 37, 1),
(8, 1, 39, 1),
(9, 1, 40, 1),
(10, 1, 8, 1),
(12, 1, 6, 1),
(14, 1, 2, 1),
(16, 1, 15, 1),
(18, 1, 14, 1),
(20, 1, 13, 1),
(22, 1, 5, 1),
(24, 1, 9, 1),
(26, 1, 4, 1),
(28, 1, 10, 1),
(30, 1, 12, 1),
(32, 1, 11, 1),
(34, 1, 7, 1),
(36, 1, 1, 1),
(38, 1, 3, 1),
(40, 1, 31, 1),
(43, 1, 34, 1),
(47, 2, 2, 2),
(48, 2, 10, 1),
(49, 2, 31, 1),
(51, 3, 7, 1),
(54, 5, 8, 1),
(55, 5, 6, 1),
(56, 6, 8, 1),
(57, 6, 6, 1),
(58, 6, 2, 1),
(59, 6, 14, 2),
(60, 7, 8, 2),
(61, 7, 6, 2),
(62, 7, 2, 2),
(63, 8, 8, 2),
(64, 8, 6, 1),
(65, 8, 2, 1),
(66, 8, 15, 2),
(67, 9, 8, 3),
(68, 9, 6, 2),
(69, 10, 10, 2),
(70, 10, 3, 1),
(71, 10, 34, 1),
(72, 10, 46, 1),
(73, 10, 47, 2),
(74, 10, 38, 1),
(75, 10, 39, 3),
(76, 10, 51, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
