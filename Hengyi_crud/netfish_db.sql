-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 mrt 2022 om 13:29
-- Serverversie: 10.4.18-MariaDB
-- PHP-versie: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `netfish_db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `company`
--

INSERT INTO `company` (`id`, `name`) VALUES
(1, 'Sony'),
(2, 'Marvel'),
(3, 'WarnerBros'),
(4, 'Universal');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `favorite_movie`
--

CREATE TABLE `favorite_movie` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `url` varchar(200) NOT NULL,
  `year` year(4) NOT NULL,
  `description` text NOT NULL,
  `distributor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `movie`
--

INSERT INTO `movie` (`id`, `title`, `url`, `year`, `description`, `distributor`) VALUES
(1, 'Avengers Age of Ultron', 'avengersageofultron.mp4', 2015, 'aaou', 2),
(2, 'Monster Hunter', 'monsterhunter.mp4', 2012, 'mh', 1),
(3, 'The Suicide Squad', 'suicidesquad.mp4', 2019, 'tss', 2),
(4, 'Tenet', 'tenet.mp4', 2020, 't', 3),
(5, 'Dune', 'dune.mp4', 2021, 'd', 1),
(6, 'Aquaman', 'aquaman.mp4', 2020, 'DC comics', 4),
(14, 'test', 'test', 2002, 'sdf', 1),
(17, 'test2', 'test2', 2002, 'sdf2', 1),
(18, 'test22', 'test22', 2002, 'sdf22', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `description` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `is_admin`) VALUES
(8, 'hengyi', 'hengyi2002@hotmail.com', '$2y$10$M0QX1lf/NTA5fOVe.Yqmsesb7DvYgRSV.c9UCLN9t62EbknBYzQUe', 0),
(9, 'hengyi2002@hotmail.com', 'hengyi2002@hotmail.com', '$2y$10$GQu0cI8eyl1T8mDo341sbuyvEWHzHFtFkmBqbPSqqUR39jDwZM4Xa', 1),
(10, 'root', 'hengyi2002@hotmail.com', '$2y$10$WW4O256zNBZ1l8/22ak7aO4zxUHvweqgSYxrHoZ.I2EZnC6.cdHMC', 1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `favorite_movie`
--
ALTER TABLE `favorite_movie`
  ADD KEY `movie_fk` (`movie_id`),
  ADD KEY `user_fk` (`user_id`);

--
-- Indexen voor tabel `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_fk` (`distributor`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `favorite_movie`
--
ALTER TABLE `favorite_movie`
  ADD CONSTRAINT `movie_fk` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`),
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `company_fk` FOREIGN KEY (`distributor`) REFERENCES `company` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
