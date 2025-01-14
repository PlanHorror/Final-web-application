-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 07:10 AM
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
-- Database: `22110173`
--

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `race_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `race_id`, `url`, `description`) VALUES
(1, 6, '../media/race_image/image_1race_6_42KM.png', 'Embark on a picturesque journey around the stunning West Lake of Hanoi. This 5-kilometer route starts at Ngũ Xã Street, tracing along serene lakeside paths, shaded boulevards, and iconic cultural landmarks. As you make your way through the route, you\'ll enjoy refreshing breezes, scenic water views, and the vibrant energy of the city.'),
(2, 6, '../media/race_image/image_2race_6_coffe.jpg', 'Recharge your energy at the cozy coffee spots along the race route near West Lake. Enjoy a quick sip of rich Vietnamese coffee while soaking in the scenic beauty, keeping your spirits high for the next stretch of the marathon!'),
(3, 6, '../media/race_image/image_3race_6_run.jpg', 'Capture the determination and energy of every runner as they push through the race with unwavering focus. Each stride tells a story of dedication, resilience, and the joy of chasing the finish line!'),
(4, 6, '../media/race_image/image_4race_6_run1.jpg', 'The quiet raceway stretches ahead, surrounded by natural beauty and urban landmarks, capturing a moment of stillness before the excitement of the marathon begins. This tranquil path is a testament to endurance and the journey that lies ahead for every runner.'),
(5, 6, '../media/race_image/image_5race_6_HT.jpg', 'A serene freshwater lake surrounded by lush greenery, with calm, reflective waters. Traditional wooden boats drift along the surface, while the skyline of Hanoi rises in the distance, blending modern buildings with ancient pagodas. The vibrant sky at sunrise or sunset casts a golden glow over the peaceful scene.'),
(6, 6, '../media/race_image/image_6race_6_HT1.jpg', 'West Lake viewed from above'),
(43, 10, '../media/race_image/image_1race_10_runner2.png', 'The athlete climbs the hill in the sunrise, showing determination and strength.'),
(44, 10, '../media/race_image/image_2race_10_runner3.jpg', 'The marathon takes place early in the morning, with illustrations of the route and landscape.'),
(45, 10, '../media/race_image/image_3race_10_run.jpg', 'A silhouette of runners on a hill at sunrise, highlighting their determination against the backdrop of a glowing sky.'),
(55, 12, '../media/race_image/image_1race_12_test.jpg', 'Some image'),
(56, 12, '../media/race_image/image_2race_12_1563dfb2-240b-4a2d-9363-87fc2cd52d4b.png', 'Tsuchisan Alast'),
(57, 12, '../media/race_image/image_3race_12_Ray Tracer 4K WALLPAPER.jpg', 'Ray Tracer');

-- --------------------------------------------------------

--
-- Table structure for table `race`
--

CREATE TABLE `race` (
  `id` int(11) NOT NULL,
  `race_name` varchar(100) NOT NULL,
  `entry_prefix` varchar(50) NOT NULL,
  `race_start` datetime NOT NULL,
  `status` int(20) NOT NULL DEFAULT 0,
  `create_by_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `race`
--

INSERT INTO `race` (`id`, `race_name`, `entry_prefix`, `race_start`, `status`, `create_by_id`, `create_at`) VALUES
(1, 'Hanoi Marathon 2024', '#HNM2024', '2024-12-06 10:17:00', 1, 20, '2024-12-05 10:17:13'),
(6, 'Winter Marathon 2024', '#WTM2024', '2024-12-16 07:00:00', 1, 20, '2024-12-05 12:36:15'),
(10, 'Sunrise Marathon', '#SM2024', '2024-12-08 07:00:00', 1, 20, '2024-12-07 11:32:16'),
(12, 'Something Marathon 2024', '#SMTT2024', '2024-12-20 07:01:00', 1, 20, '2024-12-17 13:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `register_form`
--

CREATE TABLE `register_form` (
  `race_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entry_number` varchar(20) NOT NULL,
  `hotel_name` varchar(50) DEFAULT NULL,
  `time_record` bigint(11) DEFAULT NULL,
  `standings` int(11) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register_form`
--

INSERT INTO `register_form` (`race_id`, `user_id`, `entry_number`, `hotel_name`, `time_record`, `standings`, `create_at`) VALUES
(1, 16, '#HNM2024_2', NULL, 35999, 1, '2024-12-07 11:12:37'),
(1, 22, '#HNM2024_1', NULL, 46554, 3, '2024-12-07 11:12:19'),
(1, 24, '#HNM2024_3', NULL, 39600, 2, '2024-12-07 16:16:51'),
(1, 25, '#HNM2024_4', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 26, '#HNM2024_5', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 27, '#HNM2024_6', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 28, '#HNM2024_7', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 29, '#HNM2024_8', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 30, '#HNM2024_9', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 31, '#HNM2024_10', 'Hanoi Hotel', 0, 0, '2024-12-07 16:16:51'),
(1, 32, '#HNM2024_11', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 33, '#HNM2024_12', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 34, '#HNM2024_13', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 35, '#HNM2024_14', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 36, '#HNM2024_15', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 37, '#HNM2024_16', NULL, 93599, 4, '2024-12-07 16:16:51'),
(1, 38, '#HNM2024_17', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 39, '#HNM2024_18', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 40, '#HNM2024_19', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 41, '#HNM2024_20', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 42, '#HNM2024_21', NULL, 0, 0, '2024-12-07 16:16:51'),
(1, 43, '#HNM2024_22', 'Hanoi Hotel', 0, 0, '2024-12-07 16:16:51'),
(6, 37, '#WTM2024_2', NULL, 3600, 1, '2024-12-15 20:55:47'),
(6, 225, '#WTM2024_1', 'Hanoi Hotel', 0, 0, '2024-12-07 16:25:12'),
(12, 16, '#SMTT2024_1', 'No Hotel', 300, 1, '2024-12-17 13:51:10'),
(12, 226, '#SMTT2024_2', 'No Hotel', NULL, NULL, '2024-12-17 14:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `best_record` bigint(20) DEFAULT NULL,
  `passport_no` varchar(20) DEFAULT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nationality`, `gender`, `age`, `best_record`, `passport_no`, `address`, `phone_number`, `email`, `password`, `admin`, `create_at`) VALUES
(16, 'Jonh', 'Algeria', 'Male', 19, 300, NULL, 'Hanoi', '12345678910', 'a@gmail.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-03 18:36:19'),
(18, 'Jonh', 'Angola', 'Other', 20, NULL, NULL, 'Hanoi', '12345678911', 'b@gmail.com', '$2y$10$LaXQK8T0v/pA7ZCgQIM8hOoUHxOJgOCbPlZ3WCjiXE5OkdIMmPJ6C', 0, '2024-12-03 23:48:42'),
(20, 'Admin', 'Viet Nam', 'Male', 22, NULL, '2211aa', 'Hanoi', '12345678913', 'admin@gmail.com', '$2y$10$uzSE9MQ/9GAJ3YOEgBSZPeeu7TieHjmqsHfhiVcgg.dIejJk2O3i2', 1, '2024-12-04 12:02:13'),
(22, 'Kang', 'China', 'Male', 22, 46554, NULL, 'HongKong', '01234567891', 'd@gmail.com', '$2y$10$sAbW5frnpPudYJ1FIsw0K.OagnyEieIx8uHLB6gpR1prN.vtrpbrK', 0, '2024-12-07 08:15:13'),
(24, 'Alayne Bate', 'Poland', 'Female', 78, 39600, NULL, '13 Hooker Place', '7958840059', 'abate0@nhs.uk', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:12:49'),
(25, 'Obediah Cheyenne', 'China', 'Male', 54, NULL, NULL, '12 Carioca Point', '2957208417', 'ocheyenne1@miibeian.gov.cn', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(26, 'Martina Haberjam', 'Kenya', 'Female', 22, NULL, NULL, '285 Express Street', '6527537227', 'mhaberjam2@privacy.gov.au', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(27, 'Vanna Colum', 'Malaysia', 'Female', 22, NULL, NULL, '2 Pierstorff Center', '8306526115', 'vcolum3@miibeian.gov.cn', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(28, 'Quincy Tyas', 'Ukraine', 'Male', 18, NULL, NULL, '7008 Eastlawn Center', '4586833997', 'qtyas4@cbsnews.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(29, 'Zelig Ruste', 'Indonesia', 'Male', 20, NULL, NULL, '47447 Glacier Hill Court', '6176835005', 'zruste5@dagondesign.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(30, 'Nil Quipp', 'Brazil', 'Male', 26, NULL, NULL, '58777 Spaight Drive', '4214824271', 'nquipp6@google.es', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(31, 'Eda Ciobutaru', 'Indonesia', 'Female', 56, NULL, NULL, '3106 Corscot Lane', '7253087847', 'eciobutaru7@storify.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(32, 'Cesaro Coopland', 'Ghana', 'Male', 34, NULL, NULL, '9 Forest Parkway', '5103700217', 'ccoopland8@posterous.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(33, 'Flss Basden', 'Palestinian Territor', 'Female', 75, NULL, NULL, '214 Annamark Place', '1205822935', 'fbasden9@nbcnews.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(34, 'Phoebe Delieu', 'Mexico', 'Female', 47, NULL, NULL, '7 Stoughton Way', '5608786323', 'pdelieua@bbb.org', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(35, 'Clementius Pitkethly', 'Czech Republic', 'Male', 38, NULL, NULL, '108 Loomis Junction', '7208317114', 'cpitkethlyb@bravesites.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(36, 'Onfroi Josephi', 'Indonesia', 'Male', 72, NULL, NULL, '3131 Almo Court', '5125349716', 'ojosephic@sitemeter.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(37, 'Jo Ygoe', 'Vietnam', 'Female', 51, 3600, NULL, '19 Marquette Drive', '2756438309', 'jygoed@desdev.cn', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(38, 'Georgi Mottershead', 'China', 'Male', 30, NULL, NULL, '24963 Lien Plaza', '2053353434', 'gmottersheade@about.me', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(39, 'Dennison Whates', 'Portugal', 'Male', 38, NULL, NULL, '8791 Pierstorff Crossing', '8612549670', 'dwhatesf@wunderground.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(40, 'Carny MacKibbon', 'Estonia', 'Male', 22, NULL, NULL, '406 Golf Course Parkway', '2459476045', 'cmackibbong@dmoz.org', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(41, 'Melisande Wicklen', 'Yemen', 'Female', 31, NULL, NULL, '3718 Service Avenue', '5652002646', 'mwicklenh@princeton.edu', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(42, 'Filide Kenway', 'Colombia', 'Female', 63, NULL, NULL, '260 High Crossing Point', '2036233707', 'fkenwayi@usatoday.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(43, 'Archibald Maun', 'Portugal', 'Male', 69, NULL, NULL, '31 Del Sol Pass', '8795642082', 'amaunj@sakura.ne.jp', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(44, 'Natalie Halbert', 'Myanmar', 'Female', 54, NULL, NULL, '85 Lake View Road', '1749384893', 'nhalbertk@paginegialle.it', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(45, 'Bond Ingolotti', 'China', 'Male', 34, NULL, NULL, '4 Texas Center', '9911277547', 'bingolottil@latimes.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(46, 'Drew McSkeagan', 'Indonesia', 'Male', 43, NULL, NULL, '679 Superior Point', '7075512314', 'dmcskeaganm@unc.edu', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(47, 'Nathanil Scneider', 'China', 'Male', 27, NULL, NULL, '68128 Northport Pass', '9673897109', 'nscneidern@sphinn.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(48, 'Damaris Beverstock', 'Morocco', 'Female', 34, NULL, NULL, '6776 Kennedy Lane', '7438545037', 'dbeverstocko@liveinternet.ru', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(49, 'Wilow Pilsworth', 'France', 'Female', 64, NULL, NULL, '9102 Schurz Point', '8992614655', 'wpilsworthp@whitehouse.gov', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(50, 'Edee Agett', 'Indonesia', 'Female', 24, NULL, NULL, '038 John Wall Place', '3688298224', 'eagettq@google.pl', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(51, 'Harlen Yetton', 'Ukraine', 'Male', 69, NULL, NULL, '439 Hooker Circle', '1746126477', 'hyettonr@icio.us', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(52, 'Sascha Rae', 'China', 'Male', 32, NULL, NULL, '81257 Lerdahl Terrace', '2362356243', 'sraes@google.es', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(53, 'Siobhan Brandon', 'Dominican Republic', 'Female', 46, NULL, NULL, '37126 Mendota Hill', '8854463469', 'sbrandont@homestead.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(54, 'Johannah McKenney', 'China', 'Female', 26, NULL, NULL, '6362 Golf Street', '1116470978', 'jmckenneyu@constantcontact.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(55, 'Kristin Svanini', 'Philippines', 'Female', 39, NULL, NULL, '1 Pawling Parkway', '6551492733', 'ksvaniniv@oracle.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(56, 'Oralia McConnell', 'China', 'Female', 42, NULL, NULL, '03569 Lawn Park', '2955613496', 'omcconnellw@wikia.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(57, 'Dirk Shakespear', 'Portugal', 'Male', 35, NULL, NULL, '541 Monica Parkway', '4034204641', 'dshakespearx@desdev.cn', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(58, 'Cully Bellocht', 'Indonesia', 'Male', 49, NULL, NULL, '1964 Darwin Place', '9681209696', 'cbellochty@sbwire.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(59, 'Boris Ellerbeck', 'United States', 'Male', 46, NULL, NULL, '413 Michigan Pass', '6361335587', 'bellerbeckz@infoseek.co.jp', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(60, 'Free Pletts', 'Norway', 'Male', 38, NULL, NULL, '489 Longview Drive', '4825367713', 'fpletts10@bigcartel.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(61, 'Herbie Turgoose', 'Indonesia', 'Male', 49, NULL, NULL, '97 Judy Drive', '1496254836', 'hturgoose11@timesonline.co.uk', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(62, 'Keenan Ambrosch', 'Bosnia and Herzegovi', 'Male', 56, NULL, NULL, '010 Debs Park', '5838028668', 'kambrosch12@examiner.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(63, 'Kristofer Strippling', 'Poland', 'Male', 19, NULL, NULL, '8 Talisman Circle', '7227963582', 'kstrippling13@vimeo.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(64, 'Donal Seyler', 'Portugal', 'Male', 37, NULL, NULL, '9 Heath Street', '7066949325', 'dseyler14@google.de', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(65, 'Marna Routham', 'United States', 'Female', 70, NULL, NULL, '4702 Menomonie Drive', '4198216797', 'mroutham15@cam.ac.uk', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(66, 'Goddard Fitzsymonds', 'China', 'Male', 66, NULL, NULL, '1917 Redwing Park', '1321344514', 'gfitzsymonds16@ycombinator.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(67, 'Berke Ingall', 'Russia', 'Male', 80, NULL, NULL, '5298 Eagle Crest Center', '6836580374', 'bingall17@un.org', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(68, 'Tucker Achrameev', 'China', 'Male', 59, NULL, NULL, '1 Scofield Place', '2953962190', 'tachrameev18@deviantart.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(69, 'Shoshanna Moar', 'Philippines', 'Female', 21, NULL, NULL, '61598 Alpine Street', '1322672019', 'smoar19@blogspot.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(70, 'Kelcy Pietruszewicz', 'United States', 'Female', 60, NULL, NULL, '42 Little Fleur Center', '3303136330', 'kpietruszewicz1a@elegantthemes.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(71, 'Edward McLewd', 'China', 'Male', 75, NULL, NULL, '1 Steensland Junction', '1144449934', 'emclewd1b@ifeng.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(72, 'Sherman De Lascy', 'Portugal', 'Male', 27, NULL, NULL, '14 Fair Oaks Lane', '8602017700', 'sde1c@technorati.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(73, 'Forrester Jelkes', 'Philippines', 'Male', 63, NULL, NULL, '87 Dovetail Point', '9494100117', 'fjelkes1d@etsy.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(74, 'Gill Woolvett', 'Russia', 'Male', 56, NULL, NULL, '839 Mallard Park', '2181399595', 'gwoolvett1e@scientificamerican.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:15:59'),
(75, 'Creigh Denidge', 'Russia', 'Male', 19, NULL, NULL, '5990 Lake View Hill', '2461202534', 'cdenidge1f@walmart.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(76, 'Wilone McKelvie', 'Brazil', 'Female', 72, NULL, NULL, '330 Gale Alley', '2966409050', 'wmckelvie1g@princeton.edu', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(77, 'Phip Smallridge', 'China', 'Male', 20, NULL, NULL, '11 Kings Hill', '1079622842', 'psmallridge1h@geocities.jp', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(78, 'Nedi Fitchen', 'Indonesia', 'Female', 27, NULL, NULL, '0873 Barnett Place', '9887036924', 'nfitchen1i@webnode.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(79, 'Philippe Bromet', 'Ireland', 'Female', 35, NULL, NULL, '78 Starling Junction', '8778308947', 'pbromet1j@hugedomains.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(80, 'Claus Du Barry', 'Ethiopia', 'Male', 20, NULL, NULL, '78 Pierstorff Avenue', '8519380017', 'cdu1k@smh.com.au', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(81, 'Sidonia Buick', 'Japan', 'Female', 75, NULL, NULL, '1 Leroy Court', '4019175105', 'sbuick1l@tripod.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(82, 'Hermia Gee', 'Indonesia', 'Female', 49, NULL, NULL, '46552 Algoma Circle', '8288916461', 'hgee1m@wordpress.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(83, 'Aggy Barlace', 'Philippines', 'Female', 69, NULL, NULL, '1143 Dwight Parkway', '5778205930', 'abarlace1n@cyberchimps.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(84, 'Vincents Albers', 'China', 'Male', 61, NULL, NULL, '0 Hoard Pass', '6356144930', 'valbers1o@netlog.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(85, 'Darcie Reis', 'China', 'Female', 44, NULL, NULL, '5 Green Park', '6833638376', 'dreis1p@springer.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(86, 'Tremayne Essex', 'Russia', 'Male', 64, NULL, NULL, '9 Paget Parkway', '6901070090', 'tessex1q@bandcamp.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(87, 'Karole Haet', 'Philippines', 'Female', 18, NULL, NULL, '23 Manufacturers Drive', '7244899071', 'khaet1r@networksolutions.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(88, 'Rick Fosken', 'Argentina', 'Male', 69, NULL, NULL, '97357 Anniversary Plaza', '6594062258', 'rfosken1s@oakley.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(89, 'Adi Drennan', 'China', 'Female', 75, NULL, NULL, '8393 Fieldstone Road', '1959787222', 'adrennan1t@goo.gl', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(90, 'Toiboid Esseby', 'China', 'Male', 49, NULL, NULL, '91 Mandrake Road', '2104951457', 'tesseby1u@google.com.hk', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(91, 'Marlena Jilliss', 'Mexico', 'Female', 67, NULL, NULL, '8 Ridge Oak Lane', '4815432653', 'mjilliss1v@histats.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(92, 'Valida Nawton', 'Finland', 'Female', 39, NULL, NULL, '12782 Kipling Point', '8564808308', 'vnawton1w@yelp.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(93, 'Brandon Hefford', 'Ireland', 'Male', 33, NULL, NULL, '484 Ridgeway Pass', '3077217143', 'bhefford1x@engadget.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(94, 'Rosalind Rawstorne', 'Czech Republic', 'Female', 39, NULL, NULL, '3 Transport Hill', '2253938360', 'rrawstorne1y@tumblr.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(95, 'Mariana Crampin', 'Philippines', 'Female', 44, NULL, NULL, '22655 International Point', '8499918056', 'mcrampin1z@smh.com.au', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(96, 'Daune Blackstone', 'Indonesia', 'Female', 21, NULL, NULL, '6651 Eggendart Pass', '5156980337', 'dblackstone20@myspace.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(97, 'Kinny Hamblyn', 'Canada', 'Male', 53, NULL, NULL, '6 2nd Trail', '4437510289', 'khamblyn21@theglobeandmail.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(98, 'Ninnette Quogan', 'Guatemala', 'Female', 71, NULL, NULL, '3940 Fordem Court', '2272582965', 'nquogan22@slideshare.net', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(99, 'Noach Farady', 'Russia', 'Male', 69, NULL, NULL, '98442 Elka Plaza', '9515329404', 'nfarady23@aol.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(100, 'Audie McKeveney', 'Sweden', 'Female', 49, NULL, NULL, '85259 Granby Junction', '8126052351', 'amckeveney24@fastcompany.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(101, 'Rustie Pendrey', 'Russia', 'Male', 41, NULL, NULL, '3 Scofield Place', '4864910371', 'rpendrey25@discuz.net', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(102, 'Kerianne Fairnington', 'Cambodia', 'Female', 47, NULL, NULL, '1017 Hagan Plaza', '6007959763', 'kfairnington26@zimbio.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(103, 'Cyril Girling', 'Philippines', 'Male', 69, NULL, NULL, '1 Mifflin Plaza', '1876954134', 'cgirling27@ask.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(104, 'Devinne Cranefield', 'Argentina', 'Female', 69, NULL, NULL, '44 Karstens Parkway', '1757136937', 'dcranefield28@alexa.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(105, 'Johnny Hargreves', 'Poland', 'Male', 80, NULL, NULL, '4 Bluejay Trail', '1634955058', 'jhargreves29@i2i.jp', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(106, 'Roch Cavozzi', 'South Korea', 'Female', 38, NULL, NULL, '1 8th Road', '8669410360', 'rcavozzi2a@icq.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(107, 'Charlot Sirmon', 'Colombia', 'Female', 78, NULL, NULL, '81 Marquette Lane', '3405339413', 'csirmon2b@php.net', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(108, 'Gunar Lornsen', 'China', 'Male', 44, NULL, NULL, '52 Vidon Drive', '5031983138', 'glornsen2c@dropbox.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(109, 'Cordie Knibb', 'Lebanon', 'Male', 37, NULL, NULL, '4135 Chive Lane', '3814758659', 'cknibb2d@shop-pro.jp', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(110, 'Tomas Harkins', 'China', 'Male', 54, NULL, NULL, '88929 Summit Alley', '8441266779', 'tharkins2e@soundcloud.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(111, 'Angus Halahan', 'Russia', 'Male', 51, NULL, NULL, '8248 Ronald Regan Drive', '7588754368', 'ahalahan2f@amazon.co.jp', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(112, 'Marnie Futty', 'Mexico', 'Female', 53, NULL, NULL, '9551 Mayer Park', '2404093425', 'mfutty2g@baidu.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(113, 'Howie Menhci', 'Iran', 'Male', 78, NULL, NULL, '772 Bay Center', '1258305867', 'hmenhci2h@newyorker.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(114, 'Northrop Warmington', 'Vietnam', 'Male', 57, NULL, NULL, '172 Florence Center', '5595282047', 'nwarmington2i@photobucket.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(115, 'Paige Peteri', 'Thailand', 'Male', 23, NULL, NULL, '49153 Cordelia Way', '2568540037', 'ppeteri2j@over-blog.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(116, 'Michel Lamacraft', 'China', 'Female', 75, NULL, NULL, '38 Northwestern Pass', '7508835617', 'mlamacraft2k@bravesites.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(117, 'Susanetta Allcott', 'Poland', 'Female', 32, NULL, NULL, '0507 Gerald Court', '9264471396', 'sallcott2l@nymag.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(118, 'Lesli Brisland', 'China', 'Female', 29, NULL, NULL, '30 North Parkway', '4221692337', 'lbrisland2m@globo.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(119, 'Frederique Bodimeade', 'Nigeria', 'Female', 77, NULL, NULL, '1 Clarendon Plaza', '7128501963', 'fbodimeade2n@usa.gov', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(120, 'Patten Chell', 'Philippines', 'Male', 65, NULL, NULL, '625 Homewood Circle', '1043344642', 'pchell2o@simplemachines.org', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(121, 'Alard Reast', 'Philippines', 'Male', 39, NULL, NULL, '133 Warrior Place', '1702469361', 'areast2p@ycombinator.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(122, 'William Celiz', 'China', 'Male', 20, NULL, NULL, '489 Del Sol Trail', '7552512157', 'wceliz2q@domainmarket.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(123, 'Dalli Frediani', 'Russia', 'Male', 49, NULL, NULL, '58 Leroy Center', '4789869092', 'dfrediani2r@comsenz.com', '$2y$10$CpuN5VXuelVWWTBKikxz6eY7bP8CWT8vCuk1eb.MFoGKdH8QUs4EK', 0, '2024-12-07 14:22:19'),
(225, 'tuan', 'Algeria', 'Male', 26, NULL, NULL, 'Hanoi', '0124565164', 'mtaa@gmail.com', '$2y$10$X2SUkhx7RmQ0B/kDGtlHAeSEpuE5nv.7/vZFXKPbADa1Z.UYd2/pq', 0, '2024-12-07 16:24:23'),
(226, 'Kang', 'Algeria', 'Other', 55, NULL, NULL, 'Hanoi', '12345678000', 'c1@gmail.com', '$2y$10$o6Li7onR8VYvMdfuUJzPZeiKBcs3YQRBJjCsowW1997l7d9G4hjLu', 0, '2024-12-17 14:40:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Gallery_Race` (`race_id`);

--
-- Indexes for table `race`
--
ALTER TABLE `race`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Race_User` (`create_by_id`);

--
-- Indexes for table `register_form`
--
ALTER TABLE `register_form`
  ADD PRIMARY KEY (`race_id`,`user_id`),
  ADD KEY `FK_Register_User` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `race`
--
ALTER TABLE `race`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `FK_Gallery_Race` FOREIGN KEY (`race_id`) REFERENCES `race` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `race`
--
ALTER TABLE `race`
  ADD CONSTRAINT `FK_Race_User` FOREIGN KEY (`create_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `register_form`
--
ALTER TABLE `register_form`
  ADD CONSTRAINT `FK_Register_Race` FOREIGN KEY (`race_id`) REFERENCES `race` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Register_User` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
