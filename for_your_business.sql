-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 04 2025 г., 14:32
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `for_your_business`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `was` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `user_id`, `created_at`) VALUES
(1, 'City', 3, '2025-03-28 10:44:10'),
(2, 'Carefour', 5, '2025-03-28 10:44:31'),
(3, 'ZomPackmon', 0, '2025-03-28 11:41:13'),
(4, 'ZomPackmon', 0, '2025-03-28 11:42:14'),
(5, 'ZomPackmon', 7, '2025-03-28 12:56:27'),
(6, 'ZomPackmon2', 8, '2025-03-28 12:55:45'),
(7, 'ZomPackmon3', 9, '2025-03-28 12:55:32'),
(8, 'Zeldris 5', 10, '2025-03-28 12:55:18'),
(9, 'Coco Cola', 11, '2025-03-28 12:55:06'),
(10, 'Snickers', 12, '2025-03-28 12:54:55'),
(11, 'Bounty', 13, '2025-03-28 12:54:40'),
(12, 'MilkyWay', 14, '2025-03-28 12:54:20'),
(13, 'Twix', 15, '2025-03-28 12:52:47'),
(14, 'Pele', 16, '2025-03-28 13:19:20');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product_expirations`
--

CREATE TABLE `product_expirations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `expiration_date` date NOT NULL,
  `added_by_user` bigint(20) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tariffs`
--

CREATE TABLE `tariffs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan` enum('silver','bronze','gold','platinum') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_months` int(4) NOT NULL,
  `role` enum('director','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tariff_history`
--

CREATE TABLE `tariff_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `tariff_plan` enum('silver','bronze','gold','platinum') NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `active` int(2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verify_email` int(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `role` enum('director','employee') NOT NULL,
  `director_id` bigint(20) DEFAULT NULL,
  `tariff_plan` enum('silver','bronze','gold','platinum') DEFAULT NULL,
  `tariff_expires_at` date DEFAULT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `verify_email`, `password`, `phone`, `role`, `director_id`, `tariff_plan`, `tariff_expires_at`, `company_id`, `active`, `created_at`) VALUES
(1, 'name', 'surname', 'mikael.vue@gmail.com', 0, 'mgev3336', '37443874699', 'director', 0, '', '0000-00-00', 0, 0, '2025-03-20 09:22:49'),
(2, 'Anna', 'Annaian', 'Anna@mail.ru', 1, 'anna1236a', '+37443874691', 'employee', NULL, 'silver', '0000-00-00', NULL, 1, '2025-03-28 09:54:00'),
(3, 'Boris', 'Borisian', 'Boris@mail.ru', 1, 'boris1339b', '+37443874692', 'director', NULL, 'gold', '0000-00-00', 1, 1, '2025-03-28 10:06:20'),
(4, 'Dziuna', 'Dziunian', 'Dziuna@mail.ru', 0, 'du0683du', '+37448374699', 'employee', 3, NULL, NULL, 1, 0, '2025-03-28 10:08:09'),
(5, 'Teilor', 'Teilorian', 'teilor@mail.ru', 1, 'tiel483u', '+37443874697', 'director', NULL, NULL, NULL, 2, 1, '2025-03-28 10:10:24'),
(6, 'Mikael', 'Mikaelian', 'Mikael@gmail.com', 1, 'mik333ku', '+37443874699', 'employee', 3, NULL, NULL, 1, 1, '2025-03-28 10:11:42'),
(7, 'test1', 'test11', 'test1test11@mail.yahoo', 0, '$2y$10$bu3KkW6e0tiFp9aHXmywCe0V.0AZNiMWGyEj1Mfyep6MbTPb2lF76', '+37432858699', 'director', NULL, NULL, NULL, 5, 0, '2025-03-28 11:45:44'),
(8, 'test2', 'test22', 'test2test22@mail.yahoo', 0, '$2y$10$m95rgK5xReu6PwKVTrIiZ.Wllenx5fhEkT4IXTY05eYAqisAJ8bXK', '+37432858699', 'director', NULL, NULL, NULL, 6, 0, '2025-03-28 11:54:21'),
(9, 'test3', 'test33', 'test3test33@mail.yahoo', 0, '$2y$10$0fEErjZh/2Tj2LMmbs/Yjei/YdTBPrapK4CRXHGesKK34fZz72aSi', '+37482358699', 'director', NULL, NULL, NULL, 7, 0, '2025-03-28 12:13:50'),
(10, 'test5', 'test55', 'test5test55@mail.yahoo', 0, '$2y$10$HmyYhCHV8w5rmQd8mPfg4.lVD6Rx.DV/a6EP2dS5YCb0dd1YkGqkC', '+374938358699', 'director', NULL, NULL, NULL, 8, 0, '2025-03-28 12:22:45'),
(11, 'test6', 'test66', 'test6test66@mail.yahoo', 0, '$2y$10$JtIYWAGnye9Mxid6O8.QyukuR/luf/4E/9Lc4IzrANXSwdL1Cgkma', '+37432859899', 'director', NULL, NULL, NULL, 9, 0, '2025-03-28 12:35:19'),
(12, 'test7', 'test77', 'test7test77@mail.yahoo', 0, '$2y$10$kl6VMpXV9e5i6h3IS.yZi.RNTqGm/Jzd.4IbebGN/GC8VRqG0Ueza', '+37493000001', 'director', NULL, NULL, NULL, 10, 0, '2025-03-28 12:47:21'),
(13, 'test8', 'test88', 'test8test88@mail.yahoo', 0, '$2y$10$15lxkH5edaDYPDtdligMxemoqyuyGMUF7408ky4KrNL3zBGpiVxRa', '+37493000002', 'director', NULL, NULL, NULL, 11, 0, '2025-03-28 12:49:47'),
(14, 'test9', 'test99', 'test9test99@mail.yahoo', 0, '$2y$10$Sl/pOZR2inDsk0zE4CK3GOBgvqGzfQmD/QC3.jqhiXQxaAJTlVnMa', '+37493000003', 'director', NULL, NULL, NULL, 12, 0, '2025-03-28 12:51:23'),
(15, 'test10', 'test1010', 'test10test1010@mail.yahoo', 0, '$2y$10$76I2GcqSkyD6/kZBwmWIiuSpXDRZzBu9kdoeEwFzhZcWMfbLaTUa.', '+37493000004', 'director', NULL, NULL, NULL, 13, 0, '2025-03-28 12:52:47'),
(16, 'test20', 'test202', 'test20test202@mail.yahoo', 0, '$2y$10$Q/w7kKxLFV2Mnf4J4TpSTeNQC87WrlLn6TlGhZqeqwpZQ66jrnDjO', '+37493000005', 'director', NULL, NULL, NULL, 14, 0, '2025-03-28 13:19:20'),
(17, 'test21', 'test212', 'test20test212@mail.yahoo', 0, '$2y$10$Ym0X65391t.SiFFBvSXZTOspxMNnW3zdGdQY0uwqI/boePXF1f22K', '+37493000006', 'employee', 15, NULL, NULL, 13, 0, '2025-03-28 13:21:30'),
(18, 'test23', 'test232', 'test23test232@mail.yahoo', 0, '$2y$10$d5Pni7lBicTTYRIa6WXepe1KNyUaw8mLAI4o/aUonw.qL0Lu7M7X.', '+37493000006', 'employee', 13, NULL, NULL, 11, 0, '2025-03-28 13:24:59');

-- --------------------------------------------------------

--
-- Структура таблицы `users_info`
--

CREATE TABLE `users_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `post_index` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_expirations`
--
ALTER TABLE `product_expirations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tariff_history`
--
ALTER TABLE `tariff_history`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `product_expirations`
--
ALTER TABLE `product_expirations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tariff_history`
--
ALTER TABLE `tariff_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users_info`
--
ALTER TABLE `users_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
