SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- -----------------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `demo_1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
CREATE DATABASE IF NOT EXISTS `demo_2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

GRANT ALL PRIVILEGES ON demo_1.* TO 'dbuser'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON demo_2.* TO 'dbuser'@'%' WITH GRANT OPTION;

-- -----------------------------------------------------------------------

USE `demo_1`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  UNIQUE (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`) VALUES
(1, 'mattroberts', 'Matthew Roberts', 'matthewroberts@rocketmail.com', '$2y$10$YGjUju1KPaf4AgFDcLU30.UtVySLarbQXOsU.B8gcQ.DrSmBoxrdO'),
(2, 'mthomas', 'Michelle Thomas', 'm_thomas@yahoo.com', '$2y$10$.xvXNN2df0CjBtDsFIIcleQlruqNKEy36rkC8ljZv82vO6Krz5Rz.'),
(3, 'flopez', 'Eric Lopez', 'ericflopez@gmail.com', '$2y$10$6//jmjiAwuNxAfKe4rdmyObYecLR.zqtV007gL.M4/QDBjBSr2E8G'),
(4, 'sarahsue', 'Sarah Bryant', 'sarah_sue@rocketmail.com', '$2y$10$87qXS4i7GIFBEaIxGwDHluPOUHAJJk/bOYCtkcrxcMSlt5vj5xBIK'),
(5, 'nbrown', 'Natalie Brown', 'nbrown@rocketmail.com', '$2y$10$Lq1AMaAVP5BGNtdRjncLw.C.EagIZ1u84skS9zCsogkm6i6VgE8J6'),
(6, 'aaross', 'Alexander Ross', 'alexander.andrew.ross@aol.com', '$2y$10$ranRNrp/ODOiqg7CUoT5P.jUbeSllFRdHI1Ot8UBLPeflAspmhahq'),
(7, 'jjhayes', 'Jose Hayes', 'jjhayes@yahoo.com', '$2y$10$jIqXlrUA.cXdB/QubNxNhOQ/fLnwE7WT4xuBeDoKXBWmLmmDUAND.'),
(8, 'rachelhughes', 'Rachel Hughes', 'rachel_hughes@outlook.com', '$2y$10$DgHbjt5wCclR25L3NZsjQ.In7Hn1AeWD8iNbu8gjFY0e90qXl4o.G'),
(9, 'hbailey', 'Hannah Bailey', 'h.bailey@aol.com', '$2y$10$X3l06oeB4C3SvzVmqFfkYOqNIwsW8KJlDw.MR1zw2vh2oRp6D.iLq'),
(10, 'mikegray', 'Michael Gray', 'm_gray@aol.com', '$2y$10$C4OA.Mub3YXcIO5r4LVPtecmTaijIrrqeLsCRCdPFWhwwAlWYlETe'),
(11, 'richpowell', 'Richard Powell', 'richard.powell@ymail.com', '$2y$10$DDINr.29vqmzSwvDE9jtdudDIZUzLFdFnliyj8wHWzm0zrgmUFKta'),
(12, 'aubrey', 'Aubrey Scott', 'aubrey.r.scott10@rocketmail.com', '$$2y$10$tn0E2TSKHBIlLXr49JLqde8DdYqBT2XTI7yCydsd1Up4fdV3XiTgq');

-- -----------------------------------------------------------------------

USE `demo_2`;

CREATE TABLE IF NOT EXISTS `locations` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` int(11) NOT NULL,
    `latitude` decimal(9,7) NOT NULL,
    `longitude` decimal(10,7) NOT NULL,
    `date_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `locations` (`user_id`, `latitude`, `longitude`,  `date_time`) VALUES 
(9, 42.259002, -94.176660, '2022-11-13 05:05:36'),
(1, 38.995145, -91.233600, '2015-04-02 18:34:54'),
(3, 37.695360, -77.997930, '2018-05-09 16:16:56'),
(4, 33.016928, -116.846046, '2013-03-18 03:59:33'),
(10, 59.665074, -151.449300, '2015-06-16 21:02:11'),
(7, 34.515939, -112.453990, '2020-07-31 01:17:31'),
(6, 32.026125, -84.393610, '2012-09-07 20:18:52'),
(4, 41.803384, -73.781470, '2021-07-03 22:03:53'),
(8, 37.800295, -112.935170, '2019-04-20 11:56:44'),
(6, 41.774575, -80.114500, '2021-02-15 00:18:09'),
(5, 40.500643, -90.315760, '2023-11-05 07:28:03'),
(1, 34.278935, -80.591420, '2012-03-05 06:43:23'),
(6, 37.096403, -80.608056, '2012-06-24 16:48:00'),
(9, 37.273854, -82.860110, '2016-05-20 04:30:32'),
(7, 38.682668, -81.188460, '2012-08-18 10:19:34'),
(3, 45.688676, -111.782920, '2022-10-22 05:02:14'),
(5, 34.048351, -118.294300, '2022-11-13 08:06:33'),
(3, 39.328957, -76.633610, '2012-12-04 18:25:04'),
(9, 37.954823, -121.307350, '2016-01-22 18:56:29'),
(10, 37.050156, -95.504561, '2014-10-14 00:29:10'),
(2, 39.302035, -102.443570, '2011-12-07 22:09:47'),
(1, 41.953624, -117.725010, '2012-06-15 13:45:08'),
(4, 35.993357, -77.967380, '2013-04-17 03:00:53'),
(10, 32.103546, -99.178740, '2018-02-14 09:59:16'),
(2, 43.063729, -90.822920, '2014-07-04 06:48:16'),
(3, 40.117413, -75.015400, '2012-06-01 07:02:59'),
(4, 37.951672, -122.073170, '2016-11-28 00:23:26'),
(1, 37.831684, -97.674620, '2014-07-26 04:16:51'),
(5, 29.945707, -91.986820, '2022-05-23 12:27:44'),
(10, 40.633747, -97.580410, '2021-01-29 03:15:19'),
(1, 38.028269, -84.471505, '2019-09-24 15:06:57'),
(10, 33.844371, -84.474050, '2014-03-30 07:41:42'),
(3, 17.993803, -66.265340, '2020-02-25 08:38:48'),
(10, 36.710692, -84.554160, '2020-02-16 18:22:18'),
(9, 35.808387, -78.839488, '2014-03-24 11:31:09'),
(7, 28.811078, -81.653642, '2020-05-09 12:07:55'),
(10, 43.688050, -73.067830, '2020-12-14 17:12:15'),
(5, 41.672687, -93.572173, '2017-02-13 04:15:16'),
(7, 42.469946, -70.941130, '2012-02-19 01:12:56'),
(7, 33.596823, -112.323640, '2010-02-05 18:26:11'),
(8, 38.097861, -75.393780, '2019-04-02 01:09:06'),
(10, 42.491388, -89.989790, '2023-03-30 07:30:30'),
(4, 36.104866, -78.458930, '2022-04-23 18:25:41'),
(10, 38.903318, -92.102153, '2019-03-26 06:59:47'),
(5, 48.269326, -100.824680, '2017-11-28 13:37:08'),
(7, 35.803640, -103.900510, '2020-10-21 21:56:09'),
(9, 38.754785, -76.324740, '2012-04-14 11:04:29'),
(3, 34.258203, -118.710724, '2020-03-05 16:56:57'),
(5, 43.529153, -96.366690, '2017-07-04 05:44:35');

-- -----------------------------------------------------------------------

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
