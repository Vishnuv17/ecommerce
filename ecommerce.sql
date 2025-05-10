-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 05:03 PM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `email`, `password_hash`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(2, 'Vishnuv17@gmail.com', '$2y$10$HDzRcJlVxOD2HI3sJsJ3D.IPPE8fYIdA4jsYD8bvwLoZUdjvevdq6', 'Vishnu', '17', '2025-05-09 22:35:33', '2025-05-09 22:35:33'),
(3, 'loozer17@gmail.com', '$2y$10$y23F6m96AND4k9JqIz37O.ayUjyx.1nWUxu3yJXDviuAzJPUdZgMa', 'loozer', 'vishnu', '2025-05-09 23:16:35', '2025-05-09 23:16:35'),
(4, 'sakthi@gmail.com', '$2y$10$/1pgLLmNEDe9jiYXAjBXh.YYwnjxalefhRh5PNe6Ielxz9yg0OlHm', 'sakthi', 'rio', '2025-05-09 23:34:18', '2025-05-09 23:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_status` varchar(50) DEFAULT 'Processing',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_status`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 2, 'Processing', 285000.00, '2025-05-09 23:04:56', '2025-05-09 23:04:56'),
(2, 2, 'Processing', 285000.00, '2025-05-09 19:37:34', '2025-05-09 19:37:34'),
(3, 2, 'Processing', 19000.00, '2025-05-09 19:41:48', '2025-05-09 19:41:48'),
(4, 4, 'Processing', 0.00, '2025-05-09 20:04:43', '2025-05-09 20:04:43'),
(5, 4, 'Processing', 0.00, '2025-05-09 20:41:25', '2025-05-09 20:41:25'),
(6, 2, 'Pending', 1023499.00, '2025-05-10 16:48:33', '2025-05-10 20:18:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(2, 1, 6, 19000.00),
(2, 2, 9, 19000.00),
(3, 2, 1, 19000.00),
(4, 2, 1, 19000.00),
(5, 7, 1, 4500.00),
(6, 1, 1, 19000.00),
(6, 3, 1, 999999.00),
(6, 7, 1, 4500.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock_quantity`, `created_at`, `updated_at`) VALUES
(1, 'Realme 7 Pro', 'realme 7 Pro is driven by powerful Snapdragon 720G. This processor applies advanced 8nm production process to make it stand out in performance and efficiency. 2.3GHz high-frequency Kryo 465 CPU comes with powerful Adreno 618 GPU, delivering a gaming experience with smoothness and high image quality.', 19000.00, 20, '2025-05-09 20:44:37', '2025-05-09 20:44:37'),
(2, 'Realme 7', 'realme 7 Pro is driven by powerful Snapdragon 720G. This processor applies advanced 8nm production process to make it stand out in performance and efficiency. 2.3GHz high-frequency Kryo 465 CPU comes with powerful Adreno 618 GPU, delivering a gaming experience with smoothness and high image quality.', 19000.00, 20, '2025-05-09 20:46:27', '2025-05-09 20:46:27'),
(3, 'Lenovo Gaming Laptop', 'Gaming laptops can do more than run games. That powerful hardware also means you\'ll be able to run intensive non-gaming programs, too. From graphic design and video editing to STEM field research, plenty of occupations necessitate the use of software that require serious GPU and CPU power.', 999999.00, 45, '2025-05-09 23:45:20', '2025-05-09 23:45:20'),
(7, 'Zebronics Zeb-max Atom Gaming Keyboard', 'To use a Zebronics keyboard, typically you\'ll need to either connect it via Bluetooth or a wireless receiver. If it\'s a Bluetooth keyboard, you\'ll need to enable Bluetooth on your device, enter pairing mode on the keyboard (often by pressing a specific function key combination), and then select the keyboard from your device\'s Bluetooth list. If it\'s a wireless keyboard using a receiver, you\'ll plug the receiver into your device and the keyboard should connect automatically. Some Zebronics keyboards also offer a wired connection via USB. ', 4500.00, 20, '2025-05-09 23:54:42', '2025-05-09 23:54:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
