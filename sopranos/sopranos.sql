-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 24, 2021 at 02:04 PM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sopranos-2021`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `pizzaID` int(11) NOT NULL,
  `sizeID` int(11) NOT NULL,
  `pizzaPrice` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `pizzaID`, `sizeID`, `pizzaPrice`) VALUES
(1, 1, 1, '9.00'),
(2, 1, 2, '10.00'),
(3, 1, 3, '12.00'),
(4, 2, 1, '9.00'),
(5, 2, 2, '10.00'),
(6, 2, 3, '13.00'),
(7, 4, 1, '8.00'),
(8, 4, 2, '9.00'),
(9, 4, 3, '12.00'),
(10, 3, 1, '9.00'),
(11, 3, 2, '10.00'),
(12, 3, 3, '12.00');

-- --------------------------------------------------------

--
-- Table structure for table `pizza`
--

CREATE TABLE `pizza` (
  `id` int(11) NOT NULL,
  `pizzaName` varchar(20) NOT NULL,
  `ingredients` varchar(140) NOT NULL,
  `description` varchar(140) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pizza`
--

INSERT INTO `pizza` (`id`, `pizzaName`, `ingredients`, `description`) VALUES
(1, 'Quattro Formaggi', 'Mozzarella, Gorgonzola, Fontin, Parmigiano', 'Een heerlijke pizza met vier verschillende kazen'),
(2, 'Tonno', 'Tonijn, kappertjes, cherrietomaten', 'Voor de visliefhebber'),
(3, 'Vegetariana', 'Paprika, rode ui, rucola, champignons', 'Voor de planeetliefhebber. '),
(4, 'Salami', 'Salami, Peper ', 'Voor de vleesliefhebber.');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
(1, 'Small'),
(2, 'Medium'),
(3, 'Calzone');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_pizza` (`pizzaID`),
  ADD KEY `fk_items_sizes` (`sizeID`);

--
-- Indexes for table `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pizza`
--
ALTER TABLE `pizza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_items_pizza` FOREIGN KEY (`pizzaID`) REFERENCES `pizza` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_items_sizes` FOREIGN KEY (`sizeID`) REFERENCES `sizes` (`id`);
