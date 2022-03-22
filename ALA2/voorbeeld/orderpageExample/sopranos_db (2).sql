-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 13 jan 2022 om 11:48
-- Serverversie: 10.4.11-MariaDB
-- PHP-versie: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sopranos_db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ordered_products`
--

CREATE TABLE `ordered_products` (
  `id` int(11) NOT NULL,
  `specialisation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `ordered_products`
--

INSERT INTO `ordered_products` (`id`, `specialisation_id`, `product_id`, `order_id`, `product_price`) VALUES
(1, 2, 1, 12, 12.00),
(2, 1, 2, 12, 8.50),
(3, 1, 1, 12, 8.50),
(4, 2, 1, 14, 12.00),
(5, 3, 3, 14, 8.80),
(6, 3, 1, 15, 11.00),
(7, 1, 4, 15, 10.20),
(8, 1, 1, 16, 8.50),
(9, 2, 1, 17, 12.00),
(10, 2, 3, 17, 9.60),
(11, 3, 3, 17, 8.80),
(12, 1, 1, 18, 8.50),
(13, 2, 2, 18, 12.00),
(14, 2, 1, 19, 12.00),
(15, 2, 2, 19, 12.00),
(16, 1, 4, 19, 10.20),
(17, 3, 3, 19, 8.80);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `price` double(10,2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `customer_email`, `price`, `store_id`, `date`) VALUES
(1, 'janss', 151.50, 1, '2021-04-11 21:26:38'),
(2, 'rick@vanheerlen.nl', 80.00, 1, '2021-04-13 10:22:11'),
(3, 'rick@vanheerlen.nl', 80.00, 1, '2021-04-13 10:22:27'),
(4, 'iemand@holland.nl', 8.50, 2, '2021-04-13 10:31:45'),
(5, 'iemand@holland.nl', 8.50, 2, '2021-04-13 10:34:00'),
(6, 'ricky@gglmill.com', 8.50, 3, '2021-04-13 10:34:32'),
(7, 'ricky@gglmill.com', 8.50, 3, '2021-04-13 10:35:11'),
(8, '6007927@mborijnland.nl', 20.50, 1, '2021-04-13 10:35:28'),
(9, '6007927@mborijnland.nl', 20.50, 1, '2021-04-13 10:36:37'),
(10, 'sander.v.swieten@gmail.com', 8.50, 1, '2021-04-13 10:41:46'),
(11, 'sander.v.swieten@gmail.com', 8.50, 1, '2021-04-13 10:43:22'),
(12, 'rick@vanheerlen.nl', 20.50, 1, '2021-04-13 10:43:55'),
(13, 'janss', 29.00, 1, '2021-04-13 10:49:01'),
(14, 'ricky@gglmill.com', 20.80, 1, '2021-04-13 10:52:53'),
(15, 'rick@vanheerlen.nl', 21.20, 1, '2021-04-13 10:56:48'),
(16, 'sander.v.swieten@gmail.com', 8.50, 1, '2021-04-13 11:01:34'),
(17, 'rick@vanheerlen.nl', 30.40, 1, '2021-04-13 11:03:04'),
(18, 'hengyi@smh.nl', 20.50, 1, '2021-04-13 15:55:05'),
(19, 'rick@vanheerlen.nl', 43.00, 1, '2021-04-14 13:30:06');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` double(10,2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`) VALUES
(1, 'Tonno', 10.00, 'Voor de liefhebbers!'),
(2, 'Vegetariano', 10.00, 'Voor de liefhebbers van de wereld!'),
(3, 'Quattro Formaggio', 8.00, 'Voor de mensen die van klassiek houden!'),
(4, 'Sopranos Deluxe', 12.00, 'Om te genieten van de beste smaken en kwaliteit!');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `specialisations`
--

CREATE TABLE `specialisations` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price_multiplier` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `specialisations`
--

INSERT INTO `specialisations` (`id`, `name`, `price_multiplier`) VALUES
(1, 'Medium (25cm)', 0.85),
(2, 'Large (35cm)', 1.20),
(3, 'Calzone', 1.10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `locationName` varchar(150) NOT NULL,
  `postalCode` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `stores`
--

INSERT INTO `stores` (`id`, `locationName`, `postalCode`, `email`) VALUES
(1, 'Rotterdam', '3099RD', 'rotterdam@sopranos.nl'),
(2, 'Amsterdam', '1021AM', 'amsterdamn@sopranos.nl'),
(3, 'Utrecht', '2774UT', 'utrecht@sopranos.nl');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_fk` (`order_id`),
  ADD KEY `product_fk` (`product_id`),
  ADD KEY `specialisation_fk` (`specialisation_id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_fk` (`store_id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `specialisations`
--
ALTER TABLE `specialisations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `specialisations`
--
ALTER TABLE `specialisations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD CONSTRAINT `order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `specialisation_fk` FOREIGN KEY (`specialisation_id`) REFERENCES `specialisations` (`id`);

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `store_fk` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
