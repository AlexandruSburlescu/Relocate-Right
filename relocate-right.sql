-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10 Dec 2017 la 19:04
-- Versiune server: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `relocate-right`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_url` varchar(100) NOT NULL,
  `main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `images`
--

INSERT INTO `images` (`image_id`, `image_url`, `main`) VALUES
(2, '/img/property1/outside1.jpg', 1),
(3, '/img/property1/inside1.jpg', 0),
(5, '/img/property1/inside2.jpg', 0),
(6, '/img/property1/inside3.jpg', 0),
(7, '/img/property2/outside1.jpg', 1),
(8, '/img/property2/inside1.jpg', 0),
(9, '/img/property2/inside2.jpg', 0),
(10, '/img/property2/inside3.jpg', 0),
(11, '/img/property3/outside1.jpg', 1),
(12, '/img/property3/inside1.jpg', 0),
(13, '/img/property3/inside2.jpg', 0),
(14, '/img/property3/inside3.jpg', 0),
(15, '/img/property4/outside1.jpg', 1),
(16, '/img/property4/inside1.jpg', 0),
(17, '/img/property4/inside2.jpg', 0),
(18, '/img/property4/inside3.jpg', 0),
(19, '/img/property5/outside1.jpg', 1),
(20, '/img/property5/inside1.jpg', 0),
(21, '/img/property5/inside2.jpg', 0),
(22, '/img/property5/inside3.jpg', 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `properties`
--

CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `description` varchar(350) NOT NULL,
  `rooms` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `properties`
--

INSERT INTO `properties` (`property_id`, `user_id`, `title`, `price`, `star`, `type`, `description`, `rooms`) VALUES
(1, 1, 'Two bedroom house', 350000, 0, 'buy', 'Two bedroom house with a cat', 2),
(3, 2, 'Three bedroom house', 1800, 0, 'rent', 'Three bedroom house with open floors and windows', 3),
(4, 1, 'Six bedroom house', 850000, 1, 'buy', 'Six bedroom house with an amazing view, awesome location', 6),
(5, 1, 'Two bedroom house', 1500, 0, 'rent', 'Two bedroom house with closed floors and small windows', 2),
(7, 1, 'Three bedroom house', 2100, 1, 'rent', 'Three bedroom house with good appliances, open plan floor and great living room', 3);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `property_image`
--

CREATE TABLE `property_image` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `property_image`
--

INSERT INTO `property_image` (`id`, `property_id`, `image_id`) VALUES
(1, 1, 2),
(3, 1, 3),
(4, 1, 5),
(5, 1, 6),
(6, 3, 7),
(7, 3, 8),
(8, 3, 9),
(9, 3, 10),
(10, 4, 11),
(11, 4, 12),
(12, 4, 13),
(13, 4, 14),
(14, 5, 15),
(15, 5, 16),
(16, 5, 17),
(17, 5, 18),
(18, 7, 19),
(19, 7, 20),
(20, 7, 21),
(21, 7, 22);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `lastlogin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `type`, `lastlogin`) VALUES
(1, 'Alexandru', 'Sburlescu', 'sburlescu.alexandru@yahoo.co.uk', '$2y$10$6QpsRRqKkmYAR4XEWjtO3e9fvqoTwWOgP74p5yrxjdlAfPHNVp2BO', 'admin', '2017-12-10'),
(9, 'alexandru', 'sburlescu', 'fremen.dune@gmail.com', '$2y$10$5vksgimW13yh5VOj.tfMH.en6M2ZzhoCy4erkghbswLJKceskrIle', '', '2017-12-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `id` (`property_id`);

--
-- Indexes for table `property_image`
--
ALTER TABLE `property_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `property_image`
--
ALTER TABLE `property_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrictii pentru tabele sterse
--

--
-- Restrictii pentru tabele `property_image`
--
ALTER TABLE `property_image`
  ADD CONSTRAINT `property_image_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_image_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
