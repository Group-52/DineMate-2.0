-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2022 at 08:34 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinemate`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Drinks'),
(2, 'Spices'),
(3, 'Grains'),
(4, 'Vegetables'),
(5, 'Fruits');

-- --------------------------------------------------------

--
-- Table structure for table `current_stocks`
--

CREATE TABLE `current_stocks` (
  `purchase_id` int(11) NOT NULL,
  `amount_remaining` double NOT NULL,
  `last_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `current_stocks`
--

INSERT INTO `current_stocks` (`purchase_id`, `amount_remaining`, `last_updated`) VALUES
(1, 20, '2022-11-02');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `netPrice` double NOT NULL,
  `sellingPrice` double NOT NULL,
  `description` text NOT NULL,
  `prepTime` int(11) NOT NULL,
  `image_url` text DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`dish_id`, `name`, `netPrice`, `sellingPrice`, `description`, `prepTime`, `image_url`, `last_modified`) VALUES
(17, 'Pizza', 900, 1000, 'Baked Dough', 60, 'uploads/dishes/Pizza2022_11_08_10_37_43.jpg', '2022-12-04 07:34:18'),
(20, 'Egg Biriyani', 400, 500, 'Indian Rice', 30, 'uploads/dishes/EggBiriyani2022_11_08_10_47_15.jpg', '2022-12-04 07:34:18'),
(29, 'Salad', 300, 600, 'Healthy', 20, '../public/assets/images/dishes/Salad09_25_04.jpg', '2022-12-04 07:34:18'),
(30, 'Mushroom', 43, 43, 'Good', 59, '../public/assets/images/dishes/Mushroom10_01_10.jpg', '2022-12-04 07:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `salary` double NOT NULL,
  `contactNo` varchar(20) NOT NULL,
  `NIC` varchar(20) NOT NULL,
  `dateEmployed` date NOT NULL,
  `role` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `fname`, `lname`, `username`, `salary`, `contactNo`, `NIC`, `dateEmployed`, `role`, `email`, `password`, `last_modified`) VALUES
(1, 'Janet', 'Pym', 'jp', 100000, '0724573075', '1234567890', '2012-11-09', 1, 'jp@xmail.com', 'janet', '2022-12-01 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_users`
--

CREATE TABLE `guest_users` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `dish_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `brand` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `unit` int(50) NOT NULL,
  `category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `brand`, `description`, `unit`, `category`) VALUES
(2, 'Dhal', 'SMAK', 'always keep at hand', 1, 3),
(3, 'Carrots', NULL, 'orange long cone', 1, 4),
(4, 'Brinjals', NULL, ';)', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE `menuitems` (
  `menu_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`menu_id`, `dish_id`) VALUES
(1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `imageurl` text DEFAULT NULL,
  `allday` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `name`, `description`, `startTime`, `endTime`, `imageurl`, `allday`) VALUES
(1, 'Indian', 'Good, spicy, flavoured foods', NULL, NULL, 'x', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `registered_customer` tinyint(1) NOT NULL DEFAULT 0,
  `request` text DEFAULT NULL,
  `timePlaced` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` text NOT NULL,
  `status` text NOT NULL,
  `scheduledTime` time DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_promotions`
--

CREATE TABLE `order_promotions` (
  `order_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promo_id` int(11) NOT NULL,
  `caption` text DEFAULT NULL,
  `type` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_buy1get1free`
--

CREATE TABLE `promo_buy1get1free` (
  `promo_id` int(11) NOT NULL,
  `dish1_id` int(11) NOT NULL,
  `dish2_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_discounts`
--

CREATE TABLE `promo_discounts` (
  `promo_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `discount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_spendingbonus`
--

CREATE TABLE `promo_spendingbonus` (
  `promo_id` int(11) NOT NULL,
  `spent_amount` double NOT NULL,
  `bonus_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `Quantity` double NOT NULL,
  `vendor` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `cost` double NOT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `final_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `item`, `Quantity`, `vendor`, `purchase_date`, `expiry_date`, `cost`, `discount`, `final_price`) VALUES
(1, 2, 20, 1, '2022-11-09', '2023-03-03', 7000, 0.1, 6300);

-- --------------------------------------------------------

--
-- Table structure for table `reg_users`
--

CREATE TABLE `reg_users` (
  `user_id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `contactNo` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `registered_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reg_users`
--

INSERT INTO `reg_users` (`user_id`, `fname`, `lname`, `contactNo`, `email`, `password`, `registered_date`, `last_modified`) VALUES
(1, 'Clint', 'Barton', '555', 'cb@xmail.com', '$2y$10$tHdvolbPMWUhtVzFTe/U9upVSyxcJ.RxDA15aBbqmIBaGmr4XalKa', '2022-11-19 11:07:40', '2022-12-01 18:30:00'),
(2, 'Bruce', 'Wayne', '1234', 'bw@xmail.com', '$2y$10$n2MLfG2NVoAyw5kM7WHrPePkaM9oVODNU8FYymBh68MZkt2YrlbdW', '2022-12-03 20:37:41', '2022-12-03 20:37:41'),
(3, 'Thor', 'Odinson', '1234', 'to@xmail.com', '$2y$10$W5tNA5WjXlBjS6bE7tB7CehMFlmkE2mFsh1jZ5v75Tzc3fK1voi8G', '2022-12-04 07:32:30', '2022-12-04 07:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'Chef'),
(2, 'General Manager'),
(3, 'Cashier'),
(4, 'Inventory Manager');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(50) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `name`) VALUES
(1, 'kg'),
(2, 'grams'),
(3, 'ml'),
(4, 'litres'),
(5, 'packets'),
(6, 'bottles');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `contactNo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `name`, `address`, `company`, `contactNo`) VALUES
(1, 'Lana', 'Madrid, Spain', 'Rhoedes Inc.', '0724573075');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `current_stocks`
--
ALTER TABLE `current_stocks`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`customer_id`,`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `guest_users`
--
ALTER TABLE `guest_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`dish_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `unit` (`unit`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`dish_id`);

--
-- Indexes for table `order_promotions`
--
ALTER TABLE `order_promotions`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `promo_buy1get1free`
--
ALTER TABLE `promo_buy1get1free`
  ADD KEY `promo_id` (`promo_id`),
  ADD KEY `dish1_id` (`dish1_id`),
  ADD KEY `dish2_id` (`dish2_id`);

--
-- Indexes for table `promo_discounts`
--
ALTER TABLE `promo_discounts`
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `promo_spendingbonus`
--
ALTER TABLE `promo_spendingbonus`
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `vendor` (`vendor`),
  ADD KEY `item` (`item`);

--
-- Indexes for table `reg_users`
--
ALTER TABLE `reg_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guest_users`
--
ALTER TABLE `guest_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reg_users`
--
ALTER TABLE `reg_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `current_stocks`
--
ALTER TABLE `current_stocks`
  ADD CONSTRAINT `current_stocks_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ingredients_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `units` (`unit_id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`),
  ADD CONSTRAINT `menuitems_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `guest_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `reg_users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `order_promotions`
--
ALTER TABLE `order_promotions`
  ADD CONSTRAINT `order_promotions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_promotions_ibfk_2` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`);

--
-- Constraints for table `promo_buy1get1free`
--
ALTER TABLE `promo_buy1get1free`
  ADD CONSTRAINT `promo_buy1get1free_ibfk_1` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`),
  ADD CONSTRAINT `promo_buy1get1free_ibfk_2` FOREIGN KEY (`dish1_id`) REFERENCES `dishes` (`dish_id`),
  ADD CONSTRAINT `promo_buy1get1free_ibfk_3` FOREIGN KEY (`dish2_id`) REFERENCES `dishes` (`dish_id`);

--
-- Constraints for table `promo_discounts`
--
ALTER TABLE `promo_discounts`
  ADD CONSTRAINT `promo_discounts_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`),
  ADD CONSTRAINT `promo_discounts_ibfk_2` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`);

--
-- Constraints for table `promo_spendingbonus`
--
ALTER TABLE `promo_spendingbonus`
  ADD CONSTRAINT `promo_spendingbonus_ibfk_1` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`vendor`) REFERENCES `vendors` (`vendor_id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
