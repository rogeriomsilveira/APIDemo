SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- -----------------------------------------------------------------------

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `customers` (`id`, `name`, `email`) VALUES
(1, 'Aaron Sanderson', 'asanderson@rocketmail.com'),
(2, 'John Kripke', 'jkripke@yahoo.com'),
(3, 'Rachel Weiss-Miller', 'rwmiller@gmail.com'),
(4, 'Sandra Donahue', 'sandra_donahue@rocketmail.com');

-- -----------------------------------------------------------------------

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `products` (`id`, `category_id`, `name`, `price`) VALUES
(1, 1, 'Classic T Shirt', 29.99),
(2, 1, 'Fleece Jacket', 140.73),
(3, 1, 'Slim Fit Jeans', 89.99),
(4, 2, 'Collagen Cream', 27.95),
(5, 2, 'Vitamin B12 Drops', 22),
(6, 2, 'Face Moisturizer', 12.95),
(7, 3, 'Pill Box Organizer', 3.45),
(8, 3, 'Calcium Magnesium Vitamin D', 19.99),
(9, 3, 'Eyedrop Bottle Dispenser', 4.99),
(10, 4, 'Noise Cancelling Earbuds', 45.30),
(11, 4, 'Wireless Charging Pad', 89.99),
(12, 4, 'Performance Hair Clippers', 44.73);

-- -----------------------------------------------------------------------

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(32) NOT NULL,
  UNIQUE (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Clothing'),
(2, 'Beauty'),
(3, 'Health'),
(4, 'Electronics');

-- -----------------------------------------------------------------------

CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `carts` (`id`, `customer_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 4),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 2, 5, 1),
(5, 2, 6, 1),
(6, 3, 8, 1),
(7, 4, 10, 1);

ALTER TABLE `products`
  ADD CONSTRAINT `fk_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

ALTER TABLE `carts`
  ADD CONSTRAINT `fk_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

-- -----------------------------------------------------------------------

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
