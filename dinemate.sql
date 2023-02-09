-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2023 at 05:21 AM
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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Drinks'),
(2, 'Spices'),
(3, 'Grains'),
(4, 'Vegetables'),
(5, 'Fruits'),
(6, 'Bakery'),
(7, 'Dairy');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(255) NOT NULL,
  `net_price` float NOT NULL,
  `selling_price` float NOT NULL,
  `description` varchar(500) NOT NULL,
  `prep_time` int(11) NOT NULL,
  `image_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`dish_id`, `dish_name`, `net_price`, `selling_price`, `description`, `prep_time`, `image_url`) VALUES
(33, 'Pizza', 800, 1000, 'Cheesy tasty', 60, 'Pizza06_24_40.jpg'),
(34, 'Salad', 300, 800, 'Healthy', 15, 'Salad06_25_11.jpg'),
(35, 'Donuts', 200, 400, 'Round and glazed', 40, 'Donuts06_25_41.jpg'),
(36, 'Cookies', 100, 300, 'Biscuits for christmas', 60, 'Cookies07_26_12.jpg'),
(37, 'Chillie Parata', 300, 600, 'Spicy good', 40, 'ChillieParata07_26_41.jpg'),
(38, 'Naan', 200, 300, 'Bread but softer', 30, 'Naan07_27_22.jpg'),
(39, 'Pilau', 300, 400, 'Kinda like rice', 30, 'Pilau07_27_42.jpg'),
(40, 'samosa', 400, 500, 'Stuffed with good stuff', 30, 'samosa07_28_14.jpg'),
(41, 'garlic bread', 300, 400, 'Tastes better than plain bread', 20, 'garlicbread07_28_59.jpg'),
(42, 'Pancakes', 200, 300, 'Better with syrup', 30, 'Pancakes07_29_44.jpg'),
(43, 'waffles', 400, 800, 'Traditional breakfast stuff', 20, 'waffles07_30_15.jpg'),
(46, 'Hot butter mushrooms', 800, 1000, 'Great', 40, 'Hotbuttermushrooms06_32_14.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `salary` float NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `NIC` varchar(20) NOT NULL,
  `date_employed` date NOT NULL,
  `role` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(512) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `first_name`, `last_name`, `username`, `salary`, `contact_no`, `NIC`, `date_employed`, `role`, `email`, `password`, `last_login`) VALUES
(1, 'Janet', 'Pym', 'jp', 100000, '0724573075', '1234567890', '2012-11-09', 1, 'jp@xmail.com', 'janet', '2022-12-01 18:30:00'),
(2, 'ron', 'weasley', 'rw@xmail.com', 0, '3', '', '0000-00-00', 2, 'rw@xmail.com', '$2y$10$SNBMsJ6bqPV/61kRqwbH2eETa7pYDObU9r0bfPQWCkvAQ4xEOQcBC', '2022-12-16 04:47:16'),
(3, 'hermione', 'granger', 'hg@xmail.com', 0, '1', '', '0000-00-00', 2, 'hg@xmail.com', '$2y$10$XZiLEyvBtcEQhr6LydKwXO4wXg5UjoSQxQ.Z8v26JuFU5WchxXUNW', '2022-12-16 05:33:41'),
(4, 'Nipun', 'Weerasiri', 'nipun', 0, '', '', '0000-00-00', 4, 'nipun@email.com', '$2y$10$Mza4PDo2jJyWnhPTBY.tH.XO65n4keDIpEu0iHH1q43gdNSy/Hd1K', '2022-12-16 09:48:17'),
(5, 'hf', 'uhauf', 'hu@gmail.com', 0, '3243', '', '0000-00-00', 2, 'hu@gmail.com', '$2y$10$Qi8iSg3weRpDOz.1H2fEAOk2eM6ncwVaLr.SxxubfuHhkhfN.Pa8C', '2022-12-16 09:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `reg_customer_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `time_placed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `reg_customer_id`, `guest_id`, `order_id`, `rating`, `description`, `time_placed`) VALUES
(1, 2, NULL, 1, 3, 'Good stuff', '2023-02-02 12:15:46'),
(13, 1, NULL, 1, 5, 'Great experience', '2023-02-05 11:49:48'),
(14, 2, NULL, 2, 4, 'Satisfied with the service', '2023-02-05 11:49:48'),
(15, 3, NULL, 3, 3, 'Could have been better', '2023-02-05 11:49:48'),
(16, 6, NULL, 4, 4, 'Fast and efficient', '2023-02-05 11:49:48'),
(17, 1, NULL, 5, 5, 'Excellent service', '2023-02-05 11:49:48'),
(18, 2, NULL, 6, 4, 'No complaints', '2023-02-05 11:49:48'),
(19, 3, NULL, 7, 2, 'Not impressed', '2023-02-05 11:49:48'),
(20, 6, NULL, 8, 5, 'Would definitely recommend', '2023-02-05 11:49:48'),
(21, 1, NULL, 5, 4, 'Good job', '2023-02-05 11:49:48'),
(22, 2, NULL, 7, 5, 'Outstanding service', '2023-02-05 11:49:48'),
(23, 3, NULL, 4, 4, 'Very satisfied', '2023-02-05 11:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `general_info`
--

CREATE TABLE `general_info` (
  `restaurant_name` varchar(100) NOT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `introduction` varchar(500) DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_users`
--

CREATE TABLE `guest_users` (
  `guest_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `dish_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`dish_id`, `item_id`, `quantity`, `unit`) VALUES
(33, 3, 0.036, 8),
(33, 10, 0.109, 6),
(34, 7, 0.006, 3),
(35, 2, 8767, 2),
(35, 10, 7, 3),
(36, 3, 0.017, 1),
(36, 7, 535, 2),
(37, 3, 0.008, 1),
(37, 7, 87, 1),
(37, 10, 0.008, 1),
(38, 7, 6, 9),
(38, 9, 5, 9),
(39, 10, 78, 1),
(40, 3, 876, 1),
(40, 7, 78, 5),
(40, 9, 76, 1),
(41, 3, 98, 8),
(42, 3, 0.005, 3),
(42, 7, 0.004, 8),
(46, 16, 0.009, 10),
(46, 17, 0.004, 7);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `amount_remaining` float NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `max_stock_level` float DEFAULT NULL,
  `buffer_stock_level` float DEFAULT NULL,
  `reorder_level` float DEFAULT NULL,
  `lead_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `amount_remaining`, `last_updated`, `max_stock_level`, `buffer_stock_level`, `reorder_level`, `lead_time`) VALUES
(2, 43, '2023-02-05 11:54:49', 115, 97, 44, 20),
(3, 0, '2023-02-05 11:54:49', 149, 70, 64, 15),
(7, 45, '2023-02-05 11:54:49', 109, 91, 89, 18),
(9, 10, '2023-02-05 11:54:49', 159, 72, 58, 10),
(10, 10, '2023-02-05 11:54:49', 183, 51, 67, 19),
(11, 430, '2023-02-05 11:52:20', 176, 53, 26, 11),
(12, 45, '2023-02-05 11:52:20', 173, 55, 43, 11),
(13, 59, '2023-02-05 11:52:20', 195, 62, 54, 13),
(14, 94, '2023-02-05 11:52:20', 168, 61, 28, 18),
(15, 27, '2023-02-05 11:52:20', 195, 60, 32, 11),
(16, 90, '2023-02-05 11:52:20', 129, 51, 41, 12),
(17, 20, '2023-02-05 11:52:20', 134, 52, 39, 10),
(18, 40, '2023-02-05 11:52:20', 143, 55, 35, 16),
(19, 0, '2023-02-05 11:52:20', 165, 67, 82, 18);

-- --------------------------------------------------------

--
-- Table structure for table `inventory2`
--

CREATE TABLE `inventory2` (
  `pid` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `amount_remaining` float DEFAULT NULL,
  `special_notes` varchar(500) DEFAULT NULL,
  `expiry_risk` smallint(6) DEFAULT 0,
  `last_used` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory2`
--

INSERT INTO `inventory2` (`pid`, `item_id`, `amount_remaining`, `special_notes`, `expiry_risk`, `last_used`) VALUES
(71, 15, 7, 'Jesus made this ', 1, '2023-02-06 12:29:07'),
(72, 13, 6, 'Frozen Milk', 0, '2023-02-06 12:29:11'),
(73, 14, 44, NULL, 1, '2023-02-06 11:15:20'),
(74, 15, 10, NULL, 0, '2023-02-05 11:52:20'),
(75, 16, 50, NULL, 0, '2023-02-05 11:52:20'),
(77, 18, 40, NULL, 0, '2023-02-05 11:52:20'),
(79, 13, 43, NULL, 0, '2023-02-05 11:52:20'),
(80, 11, 430, NULL, 0, '2023-02-05 11:52:20'),
(81, 12, 45, 'Die', 0, '2023-02-05 11:56:52'),
(82, 13, 10, NULL, 0, '2023-02-05 11:52:20'),
(83, 14, 50, NULL, 0, '2023-02-05 11:52:20'),
(84, 15, 10, NULL, 0, '2023-02-05 11:52:20'),
(85, 16, 40, NULL, 0, '2023-02-05 11:52:20'),
(86, 17, 20, NULL, 0, '2023-02-05 11:52:20'),
(92, 2, 43, NULL, 0, '2023-02-05 11:54:49'),
(89, 7, 45, NULL, 0, '2023-02-05 11:56:52'),
(90, 9, 10, NULL, 0, '2023-02-05 11:54:49'),
(91, 10, 10, NULL, 0, '2023-02-05 11:54:49');

--
-- Triggers `inventory2`
--
DELIMITER $$
CREATE TRIGGER `update_amount_remaining` AFTER UPDATE ON `inventory2` FOR EACH ROW BEGIN
    IF NEW.amount_remaining < OLD.amount_remaining THEN
        UPDATE inventory SET amount_remaining = amount_remaining - (OLD.amount_remaining - NEW.amount_remaining) WHERE item_id = NEW.item_id;
    ELSE
		UPDATE inventory SET amount_remaining = amount_remaining + (NEW.amount_remaining - OLD.amount_remaining) WHERE item_id = NEW.item_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_last_used` BEFORE UPDATE ON `inventory2` FOR EACH ROW BEGIN
    IF NEW.amount_remaining <> OLD.amount_remaining THEN
        SET NEW.last_used = NOW();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(256) NOT NULL,
  `description` text DEFAULT NULL,
  `unit` int(50) NOT NULL,
  `category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `description`, `unit`, `category`) VALUES
(2, 'Dhal', 'always keep at hand', 1, 3),
(3, 'Carrots', 'orange long cone', 1, 4),
(7, 'Banana', 'Long and Yellow', 1, 5),
(9, 'Sugar', 'Sweetest', 1, 2),
(10, 'Salt', 'Can\'t live without', 1, 2),
(11, 'Milk', 'From a cow', 4, 7),
(12, 'Bread', 'A staple food', 1, 6),
(13, 'Cheese', 'A dairy product', 1, 7),
(14, 'Lemon', 'A citrus fruit', 1, 5),
(15, 'Wine', 'A alcoholic drink', 4, 1),
(16, 'Rice', 'Long grain Basmati Rice', 1, 3),
(17, 'Tomatoes', 'Red and juicy', 1, 4),
(18, 'Lemon', 'Citrus fruit', 5, 4),
(19, 'Coffee', 'Arabica coffee beans', 1, 1),
(20, 'Tea', 'Black tea leaves', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `description` varchar(200) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `image_url` varchar(200) DEFAULT NULL,
  `all_day` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `description`, `start_time`, `end_time`, `image_url`, `all_day`) VALUES
(1, 'Indian', 'Savory Indian food', NULL, NULL, 'indianmenu.jpg', 1),
(3, 'European', 'Non spicy food', NULL, NULL, 'euromenu.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_dishes`
--

CREATE TABLE `menu_dishes` (
  `menu_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menu_dishes`
--

INSERT INTO `menu_dishes` (`menu_id`, `dish_id`) VALUES
(3, 33),
(3, 42),
(3, 36),
(3, 43),
(1, 38),
(1, 39),
(1, 37),
(1, 40),
(3, 33),
(3, 42),
(3, 36),
(3, 43),
(1, 38),
(1, 39),
(1, 37),
(1, 40);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `reg_customer_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `request` varchar(500) DEFAULT NULL,
  `time_placed` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `scheduled_time` time DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `reg_customer_id`, `guest_id`, `request`, `time_placed`, `type`, `status`, `scheduled_time`, `table_id`) VALUES
(1, 2, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu faucibus tellus, a viverra risus. Aliquam non velit id dolor vulputate consequat a nec felis. Phasellus nec dolor at ante aliquam lacinia. Vestibulum egestas rhoncus est, dapibus pellentesque dolor placerat a. Suspendisse eget metus sit amet massa elementum mollis. Phasellus sagittis faucibus lacinia. Maecenas in vestibulum mauris, ac tempor sapien', '2022-12-16 09:35:02', 'dine-in', 'completed', NULL, 5),
(2, 2, NULL, 'Chill', '2023-02-02 12:14:34', 'takeaway', 'accepted', NULL, NULL),
(3, 2, NULL, 'Need lots of food', '2023-02-03 11:47:28', 'bulk', 'rejected', '13:16:38', NULL),
(4, 6, NULL, 'Need the food to be ready by 1 PM', '2023-02-03 07:30:00', 'takeaway', 'completed', NULL, NULL),
(5, 1, NULL, 'No dairy products', '2023-02-03 08:30:00', 'dine-in', 'completed', '15:00:00', 2),
(6, 1, NULL, 'Need the food to be extra hot', '2023-02-03 04:30:00', 'takeaway', 'accepted', NULL, NULL),
(7, 2, NULL, 'Allergic to nuts', '2023-02-03 05:30:00', 'dine-in', 'pending', '12:00:00', 1),
(8, 3, NULL, 'Need separate containers for sauces', '2023-02-03 06:30:00', 'bulk', 'rejected', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_dishes`
--

CREATE TABLE `order_dishes` (
  `order_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_dishes`
--

INSERT INTO `order_dishes` (`order_id`, `dish_id`, `quantity`) VALUES
(1, 33, 3),
(1, 35, 1),
(1, 40, 12),
(1, 41, 2),
(2, 34, 5),
(2, 42, 7),
(3, 35, 2),
(3, 43, 5),
(4, 36, 7),
(5, 37, 4),
(6, 38, 8),
(7, 39, 6),
(8, 40, 9);

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
  `caption` varchar(500) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promo_id`, `caption`, `type`, `status`, `image_url`) VALUES
(1, 'This is my discount promotion 1', 'discounts', 1, NULL),
(2, 'This is my spending bonus promotion 2', 'spending_bonus', 1, NULL),
(3, 'This is my buy1get1 free promotion 3', 'free_dish', 1, NULL);

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

--
-- Dumping data for table `promo_discounts`
--

INSERT INTO `promo_discounts` (`promo_id`, `dish_id`, `discount`) VALUES
(1, 38, 3);

-- --------------------------------------------------------

--
-- Table structure for table `promo_spending_bonus`
--

CREATE TABLE `promo_spending_bonus` (
  `promo_id` int(11) NOT NULL,
  `spent_amount` float NOT NULL,
  `bonus_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `vendor` int(11) DEFAULT NULL,
  `brand` varchar(256) DEFAULT NULL,
  `purchase_date` date DEFAULT current_timestamp(),
  `expiry_date` date DEFAULT NULL,
  `cost` float NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `tax` float NOT NULL DEFAULT 0,
  `final_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `item`, `quantity`, `vendor`, `brand`, `purchase_date`, `expiry_date`, `cost`, `discount`, `tax`, `final_price`) VALUES
(71, 15, 43, 7, NULL, '2023-02-01', '2023-09-14', 423, 0, 0, 423),
(72, 13, 430, 10, NULL, '2023-02-01', '2023-07-16', 4230, 0, 0, 4230),
(73, 14, 45630, 12, NULL, '2023-02-01', '2023-06-25', 42330, 0, 0, 43230),
(74, 15, 10, 10, NULL, '2023-02-01', '2023-09-13', 1000, 0, 0, 1000),
(75, 16, 50, 7, NULL, '2023-02-01', '2023-12-17', 5000, 0, 0, 5000),
(76, 17, 10, 12, NULL, '2023-02-01', '2023-08-10', 1000, 0, 0, 1000),
(77, 18, 40, 10, NULL, '2023-02-01', '2024-01-20', 430, 0, 0, 430),
(78, 19, 20, 13, NULL, '2023-02-01', '2023-05-09', 2000, 0, 0, 2000),
(79, 13, 43, 4, NULL, '2023-02-01', '2023-07-04', 423, 0, 0, 423),
(80, 11, 430, 7, NULL, '2023-02-01', '2023-05-18', 4230, 0, 0, 4230),
(81, 12, 45630, 9, NULL, '2023-02-01', '2023-04-07', 42330, 0, 0, 43230),
(82, 13, 10, 7, NULL, '2023-02-01', '2023-02-07', 1000, 0, 0, 1000),
(83, 14, 50, 4, NULL, '2023-02-01', '2023-08-16', 5000, 0, 0, 5000),
(84, 15, 10, 9, NULL, '2023-02-01', '2023-09-15', 1000, 0, 0, 1000),
(85, 16, 40, 7, NULL, '2023-02-01', '2023-07-27', 430, 0, 0, 430),
(86, 17, 20, 10, NULL, '2023-02-01', '2023-08-19', 2000, 0, 0, 2000),
(87, 18, 0.19, 13, 'XD', '2023-02-09', '2023-05-12', 43, 4, 4, 43),
(88, 3, 430, 10, NULL, '2023-02-01', '2023-10-20', 4230, 0, 0, 4230),
(89, 7, 45630, 12, NULL, '2023-02-01', '2023-10-31', 42330, 0, 0, 43230),
(90, 9, 10, 10, NULL, '2023-02-01', '2023-08-30', 1000, 0, 0, 1000),
(91, 10, 10, 10, NULL, '2023-02-01', '2023-09-20', 1000, 0, 0, 1000),
(92, 2, 43, 7, NULL, '2023-02-01', '2023-07-08', 423, 0, 0, 423);

--
-- Triggers `purchases`
--
DELIMITER $$
CREATE TRIGGER `update_inventory` BEFORE INSERT ON `purchases` FOR EACH ROW BEGIN
    IF EXISTS (SELECT 1 FROM inventory WHERE item_id = NEW.item) THEN
        UPDATE inventory SET amount_remaining = amount_remaining + NEW.quantity WHERE item_id = NEW.item;
    ELSE
        INSERT INTO inventory (item_id, amount_remaining) VALUES (NEW.item, NEW.quantity);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_inventory2` AFTER INSERT ON `purchases` FOR EACH ROW BEGIN
INSERT into inventory2 (pid, amount_remaining,item_id) VALUES (NEW.purchase_id, NEW.quantity, NEW.item);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reg_users`
--

CREATE TABLE `reg_users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(512) NOT NULL,
  `registered_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reg_users`
--

INSERT INTO `reg_users` (`user_id`, `first_name`, `last_name`, `contact_no`, `email`, `password`, `registered_date`, `last_login`) VALUES
(1, 'Clint', 'Barton', '555', 'cb@xmail.com', '$2y$10$tHdvolbPMWUhtVzFTe/U9upVSyxcJ.RxDA15aBbqmIBaGmr4XalKa', '2022-11-19 11:07:40', '2022-12-01 18:30:00'),
(2, 'Bruce', 'Wayne', '1234', 'bw@xmail.com', '$2y$10$n2MLfG2NVoAyw5kM7WHrPePkaM9oVODNU8FYymBh68MZkt2YrlbdW', '2022-12-03 20:37:41', '2022-12-03 20:37:41'),
(3, 'Thor', 'Odinson', '1234', 'to@xmail.com', '$2y$10$W5tNA5WjXlBjS6bE7tB7CehMFlmkE2mFsh1jZ5v75Tzc3fK1voi8G', '2022-12-04 07:32:30', '2022-12-04 07:32:30'),
(6, 'Andrew', 'Tate', '1', 'at@xmail.com', '$2y$10$gqM/6DlLpjgtbUqLwL9lzetNEIGT6w6KV44aG4miDNhIl5WMRGHAu', '2022-12-15 05:39:19', '2022-12-15 05:39:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
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
  `unit_name` varchar(20) NOT NULL,
  `abbreviation` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `abbreviation`, `type`) VALUES
(1, 'kilograms', 'kg', 'mass'),
(2, 'grams', 'g', 'mass'),
(3, 'mililiters', 'ml', 'volume'),
(4, 'litres', 'l', 'volume'),
(5, 'packets', 'pkts', 'discrete'),
(6, 'bottles', 'btls', 'discrete'),
(7, 'ounces', 'oz', 'mass'),
(8, 'pounds', 'lb', 'mass'),
(9, 'cups', 'cups', 'volume'),
(10, 'pieces', 'pcs', 'discrete'),
(11, 'meters', 'm', 'length'),
(12, 'teaspoons', 'tsp', 'volume');

-- --------------------------------------------------------

--
-- Table structure for table `unit_conversion`
--

CREATE TABLE `unit_conversion` (
  `u1` int(11) DEFAULT NULL,
  `u2` int(11) DEFAULT NULL,
  `conversion_factor` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_conversion`
--

INSERT INTO `unit_conversion` (`u1`, `u2`, `conversion_factor`) VALUES
(1, 2, 1000),
(4, 3, 1000),
(7, 2, 28.3495),
(8, 2, 453.592),
(2, 7, 0.0353),
(2, 7, 0.0353),
(2, 8, 0.0022),
(3, 9, 0.2366),
(4, 9, 4.2268),
(7, 8, 16),
(5, 6, 6),
(7, 1, 0.0283495),
(8, 1, 0.453592),
(9, 3, 236.588),
(9, 4, 0.2366);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `contact_no` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `vendor_name`, `address`, `company`, `contact_no`, `email`) VALUES
(1, 'Lana', 'Madrid, Spain', 'Rhoedes Inc.', '0724573075', NULL),
(4, 'Scarlett Johansson', '1234 Main St', 'Marvel Studios', '555-555-5555', 'scarlettjohansson@marvel.com'),
(5, 'Brie Larson', '5678 Elm St', 'Marvel Studios', '555-555-5556', 'brielarson@marvel.com'),
(7, 'Gwyneth Paltrow', '121314 Pine Blvd', 'Marvel Studios', '555-555-5558', 'gwynethpaltrow@marvel.com'),
(8, 'Tessa Thompson', '151617 Cedar Rd', 'Marvel Studios', '555-555-5559', 'tessathompson@marvel.com'),
(9, 'Zehra Modi', '181910 Maple Ln', 'Bharatiya Janata Party', '555-555-5560', 'zehratiya@bjp.com'),
(10, 'Priyanka Gandhi', '212223 Rosewood Ave', 'Indian National Congress', '555-555-5561', 'priyankagandhi@inc.com'),
(11, 'Nirmala Sitharaman', '242526 Cedar Ln', 'Bharatiya Janata Party', '555-555-5562', 'nirmalasitharaman@bjp.com'),
(12, 'Sonia Gandhi', '272829 Elmwood St', 'Indian National Congress', '555-555-5563', 'soniagandhi@inc.com'),
(13, 'Smriti Irani', '303132 Oakwood Dr', 'Bharatiya Janata Party', '555-555-5564', 'smritiirani@bjp.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`user_id`,`dish_id`),
  ADD KEY `dish_id` (`dish_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

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
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `reg_customer_id` (`reg_customer_id`),
  ADD KEY `guest_id` (`guest_id`);

--
-- Indexes for table `guest_users`
--
ALTER TABLE `guest_users`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`dish_id`,`item_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `unit` (`unit`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD UNIQUE KEY `item_id_2` (`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `inventory2`
--
ALTER TABLE `inventory2`
  ADD UNIQUE KEY `pid` (`pid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `unit` (`unit`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `menu_dishes`
--
ALTER TABLE `menu_dishes`
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`reg_customer_id`);

--
-- Indexes for table `order_dishes`
--
ALTER TABLE `order_dishes`
  ADD PRIMARY KEY (`order_id`,`dish_id`),
  ADD KEY `dish_id` (`dish_id`);

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
  ADD UNIQUE KEY `promo_id_2` (`promo_id`),
  ADD KEY `promo_id` (`promo_id`),
  ADD KEY `dish1_id` (`dish1_id`),
  ADD KEY `dish2_id` (`dish2_id`);

--
-- Indexes for table `promo_discounts`
--
ALTER TABLE `promo_discounts`
  ADD UNIQUE KEY `promo_id_2` (`promo_id`),
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `promo_spending_bonus`
--
ALTER TABLE `promo_spending_bonus`
  ADD UNIQUE KEY `promo_id_2` (`promo_id`),
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
-- Indexes for table `unit_conversion`
--
ALTER TABLE `unit_conversion`
  ADD KEY `u1` (`u1`),
  ADD KEY `u2` (`u2`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `guest_users`
--
ALTER TABLE `guest_users`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `reg_users`
--
ALTER TABLE `reg_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `reg_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`reg_customer_id`) REFERENCES `reg_users` (`user_id`),
  ADD CONSTRAINT `feedback_ibfk_3` FOREIGN KEY (`guest_id`) REFERENCES `guest_users` (`guest_id`);

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredients_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredients_ibfk_3` FOREIGN KEY (`unit`) REFERENCES `units` (`unit_id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `inventory2`
--
ALTER TABLE `inventory2`
  ADD CONSTRAINT `inventory2_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `purchases` (`purchase_id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `units` (`unit_id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `menu_dishes`
--
ALTER TABLE `menu_dishes`
  ADD CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menuitems_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`);

--
-- Constraints for table `order_dishes`
--
ALTER TABLE `order_dishes`
  ADD CONSTRAINT `order_dishes_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_dishes_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`);

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
-- Constraints for table `promo_spending_bonus`
--
ALTER TABLE `promo_spending_bonus`
  ADD CONSTRAINT `promo_spendingbonus_ibfk_1` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`vendor`) REFERENCES `vendors` (`vendor_id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `unit_conversion`
--
ALTER TABLE `unit_conversion`
  ADD CONSTRAINT `unit_conversion_ibfk_1` FOREIGN KEY (`u1`) REFERENCES `units` (`unit_id`),
  ADD CONSTRAINT `unit_conversion_ibfk_2` FOREIGN KEY (`u2`) REFERENCES `units` (`unit_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
