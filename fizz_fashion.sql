-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 03:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fizz_fashion`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `id` int(11) NOT NULL,
  `adminname` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`id`, `adminname`, `admin_email`, `admin_password`) VALUES
(1, 'Rahimul', 'rahimulislamimo3299@gmail.com', '$2y$10$TRDiGwrZplALpEngSxmFMOf42wcc.q9YtEp3zmtS8TTpPLBRYpBH.');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'Mens World'),
(2, 'Rise'),
(3, 'Zara'),
(4, 'Aarong'),
(5, 'Sailor'),
(6, 'Richman'),
(7, 'Cats-Eye'),
(8, 'Ecstasy'),
(9, 'Yellow'),
(13, 'Sara');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'Shirt'),
(2, 'T-Shirt'),
(3, 'Pant'),
(4, 'Jacket'),
(5, 'Hoodie'),
(6, 'Cap'),
(7, 'Joggers'),
(8, 'Socks'),
(9, 'Sneakers'),
(10, 'Shoes'),
(11, 'Sunglass'),
(15, 'Chips'),
(16, 'Belt');

-- --------------------------------------------------------

--
-- Table structure for table `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_pending`
--

INSERT INTO `orders_pending` (`order_id`, `user_id`, `invoice_number`, `product_id`, `quantity`, `order_status`) VALUES
(86, 16, 135198195, 18, 1, 'pending'),
(87, 16, 1534337467, 16, 1, 'pending'),
(88, 18, 1461997896, 5, 1, 'pending'),
(89, 18, 1157072661, 5, 1, 'pending'),
(90, 18, 1384161670, 1, 2, 'pending'),
(91, 18, 36656848, 2, 1, 'pending'),
(92, 18, 1788734180, 11, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(100) NOT NULL,
  `product_discription` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_image4` varchar(255) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_discription`, `product_keywords`, `category_id`, `brand_id`, `product_image1`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `date`, `status`) VALUES
(1, 'Sneakers', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Sneakers, Premium sneakers, Stylish sneakers, Mens sneakers', 9, 2, 'sneaker1.png', 'sneaker2.png', 'sneaker3.png', 'sneaker4.png', '2000', '2023-10-09 15:35:20', 'true'),
(2, 'Shoes', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Shoes, Premium shoes, Mens shoes, Leather shoes, Stylish shoes, Formal shoes, Casual shoes', 10, 2, 'shoes1.png', 'shoes2.png', 'shoes3.png', 'shoes4.png', '2500', '2023-09-14 17:36:38', 'true'),
(3, 'Sunglass', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Sunglass, Premium Sunglass, Mens Sunglass, Stylish Sunglass', 11, 8, 'glass1.png', 'glass2.png', 'glass3.png', 'glass4.png', '500', '2023-09-14 17:36:54', 'true'),
(5, 'Shirt', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Shirt, Premium Shirt, Mens Shirt, Stylish Shirt, Formal Shirt, Casual Shirt', 1, 1, 'shirt1.png', 'shirt2.png', 'shirt3.png', 'shirt4.png', '1500', '2023-09-14 17:37:33', 'true'),
(6, 'T-shirt', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'T-shirt, Premium T-shirt, Mens T-shirt, Stylish T-shirt', 2, 5, 'tshirt1.png', 'tshirt2.png', 'tshirt3.png', 'tshirt4.png', '500', '2023-09-14 17:37:45', 'true'),
(7, 'Pant', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Pant, Premium Pant, Mens Pant, Stylish Pant, Formal Pant, Casual Pant, Jeans Pant, Denim, Gebadine Pant', 3, 3, 'pant1.png', 'pant2.png', 'pant3.png', 'pant4.png', '2000', '2023-09-14 17:38:03', 'true'),
(8, 'Joggers', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Joggers, Premium Joggers, Mens Joggers, Stylish Joggers, Casual Joggers, Soft Joggers', 7, 5, 'joggers1.png', 'joggers2.png', 'joggers3.png', 'joggers4.png', '1200', '2023-09-14 17:38:44', 'true'),
(9, 'Jacket', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Jacket, Premium Jacket, Mens Jacket, Leather Jacket, Stylish Jacket, Casual Jacket', 4, 8, 'jacket1.png', 'jacket2.png', 'jacket3.png', 'jacket4.png', '3000', '2023-09-14 17:38:20', 'true'),
(10, 'Hoodie', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Hoodie, Premium Hoodie, Mens Hoodie, Stylish Hoodie, Casual Hoodie, Soft Hoodie', 5, 9, 'hoodie1.png', 'hoodie2.png', 'hoodie3.png', 'hoodie4.png', '1000', '2023-09-14 17:38:30', 'true'),
(11, 'Cap', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Cap, Premium Cap, Mens Cap, Stylish Cap', 6, 3, 'cap1.png', 'cap2.png', 'cap3.png', 'cap4.png', '500', '2023-09-14 17:39:17', 'true'),
(16, 'Socks', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Socks', 8, 6, 'socks1.png', 'socks2.png', 'socks3.png', 'socks4.png', '200', '2023-10-12 15:29:50', 'true'),
(18, 'Belt', 'Some quick example text to build on the card title and make up the bulk of the card\'s content.', 'Belt, Premium Belt, Mens Belt, Leather Belt, Stylish Belt, Formal Belt, Casual Belt', 16, 13, 'Belt2.png', 'Belt1.png', 'Belt4.png', 'Belt3.png', '1000', '2023-10-12 15:31:30', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_due` int(255) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `amount_due`, `invoice_number`, `total_products`, `order_date`, `order_status`) VALUES
(97, 18, 4000, 1384161670, 1, '2023-10-29 14:04:18', 'Complete'),
(98, 18, 2500, 36656848, 1, '2023-10-29 13:55:08', 'Complete'),
(99, 18, 500, 1788734180, 1, '2023-10-29 14:05:37', 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_payments`
--

INSERT INTO `user_payments` (`payment_id`, `order_id`, `invoice_number`, `amount`, `payment_mode`, `date`) VALUES
(32, 98, 36656848, 2500, 'Nogod', '2023-10-29 13:55:08'),
(33, 97, 1384161670, 4000, 'Stripe', '2023-10-29 14:04:18'),
(34, 99, 1788734180, 500, 'Stripe', '2023-10-29 14:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_mobile` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `user_password`, `user_ip`, `user_address`, `user_mobile`) VALUES
(16, 'Rahimul', 'rahimulislamimo3299@gmail.com', '$2y$10$Je61b9bsKxafPphMUMUHNOE2HxmFH.yawRUpDxR6uT1NMuWy2Na4S', '::2', 'Dhaka', 1787492460),
(17, 'Arafat', 'arafat@gmail.com', '$2y$10$9Zcg0uhpolXQkJZnJ9kTruwmS4VXg00z9itKOFELkGSCrf.v509Rm', '::3', 'Dhaka', 25353535),
(18, 'test', 'test@gmail.com', '$2y$10$wXStTDyvna1cKL4uGDvzQextBTFDzeEVElmTNwa9MFdzjh3BLPSje', '::1', 'Dhaka', 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
