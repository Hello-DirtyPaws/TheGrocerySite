-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2020 at 06:24 PM
-- Server version: 5.7.30
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thoutas1_Grocery_Strore`
--
CREATE DATABASE IF NOT EXISTS `thoutas1_Grocery_Strore` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `thoutas1_Grocery_Strore`;

-- --------------------------------------------------------

--
-- Table structure for table `Cart`
--

DROP TABLE IF EXISTS `Cart`;
CREATE TABLE `Cart` (
  `User_ID` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `Cart`
--
DROP TRIGGER IF EXISTS `checkCartOnInsert`;
DELIMITER $$
CREATE TRIGGER `checkCartOnInsert` BEFORE INSERT ON `Cart` FOR EACH ROW BEGIN
    
    DECLARE availableQuantity integer;
    
    SET @availableQuantity = (SELECT count FROM Items WHERE ID = NEW.Item_ID);
    
    IF NEW.Quantity > @availableQuantity 
    THEN signal sqlstate '45000' set message_text = 'Quantity unavailable';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `checkCartOnUpdate`;
DELIMITER $$
CREATE TRIGGER `checkCartOnUpdate` BEFORE UPDATE ON `Cart` FOR EACH ROW BEGIN
    
    DECLARE availableQuantity integer;
    
    SET @availableQuantity = (SELECT count FROM Items WHERE ID = NEW.Item_ID);
    
    IF NEW.Quantity > @availableQuantity 
    THEN signal sqlstate '45000' set message_text = 'Quantity unavailable';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

DROP TABLE IF EXISTS `Category`;
CREATE TABLE `Category` (
  `Category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`Category`) VALUES
('Bakery'),
('Beverages'),
('Floral'),
('Fruits'),
('Pharmacy'),
('Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

DROP TABLE IF EXISTS `Items`;
CREATE TABLE `Items` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Category` varchar(11) NOT NULL,
  `Price` float NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Items`
--

INSERT INTO `Items` (`ID`, `Name`, `Category`, `Price`, `count`) VALUES
(1, 'Water', 'Beverages', 1.5, 100),
(2, 'Mango', 'Fruits', 2.5, 17),
(3, 'Apple', 'Fruits', 1.05, 40),
(4, 'Banana', 'Fruits', 0.99, 53),
(5, 'Strawberries', 'Fruits', 1.99, 2),
(6, 'Avocado', 'Fruits', 0.99, 45),
(7, 'Grapes', 'Fruits', 2.15, 60),
(8, 'Orange Juice', 'Beverages', 2.89, 38),
(9, 'Coke', 'Beverages', 2.15, 60),
(10, 'Gatorade', 'Beverages', 3.65, 40),
(11, 'Lipton Tea', 'Beverages', 3.45, 40),
(12, 'Hot Chocolate', 'Beverages', 2.67, 54),
(13, 'Chocolate cake', 'Bakery', 6.99, 13),
(14, 'Bread', 'Bakery', 1.2, 60),
(15, 'Cookies', 'Bakery', 3.4, 26),
(16, 'Muffin', 'Bakery', 1.05, 20),
(17, 'Brownies', 'Bakery', 2.09, 25),
(18, 'Pastry', 'Bakery', 2.87, 15),
(19, 'Tomato', 'Vegetables', 0.4, 25),
(20, 'Lettuce', 'Vegetables', 2.5, 10),
(21, 'Cucumber', 'Fruits', 3.08, 50),
(22, 'Brocolli', 'Vegetables', 2.09, 60),
(24, 'Hydrogen Peroxide', 'Pharmacy', 3.5, 25);

-- --------------------------------------------------------

--
-- Table structure for table `Items_Ordered`
--

DROP TABLE IF EXISTS `Items_Ordered`;
CREATE TABLE `Items_Ordered` (
  `Order_ID` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `Item_Name` varchar(255) NOT NULL,
  `Item_Price` float NOT NULL,
  `Item_Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Items_Ordered`
--

INSERT INTO `Items_Ordered` (`Order_ID`, `Item_ID`, `Item_Name`, `Item_Price`, `Item_Quantity`) VALUES
(8, 1, 'Water', 1.5, 6),
(8, 4, 'Banana', 0.99, 1),
(8, 5, 'Strawberries', 1.99, 1),
(8, 6, 'Avocado', 0.99, 1),
(8, 7, 'Grapes', 2.15, 1),
(10, 2, 'Mango', 2.5, 40),
(12, 2, 'Mango', 2.5, 35),
(19, 1, 'Water', 1.5, 10),
(20, 5, 'Strawberries', 1.99, 33),
(21, 5, 'Strawberries', 1.99, 33),
(26, 2, 'Mango', 2.5, 10),
(27, 1, 'Water', 1.5, 10),
(28, 1, 'Water', 1.5, 90),
(28, 2, 'Mango', 2.5, 5),
(29, 3, 'Apple', 1.05, 5),
(29, 21, 'Cucumber', 3.08, 25),
(30, 2, 'Mango', 2.5, 1),
(30, 4, 'Banana', 0.99, 1),
(31, 2, 'Mango', 2.5, 2),
(32, 24, 'Hydrogen Peroxide', 3.5, 25);

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
CREATE TABLE `Orders` (
  `Order_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Total` double NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`Order_ID`, `User_ID`, `Total`, `Date`) VALUES
(8, 4, 15.12, '2020-05-04 18:12:42'),
(10, 4, 100, '2020-05-04 19:07:43'),
(12, 4, 87.5, '2020-05-04 19:57:31'),
(19, 5, 15, '2020-05-04 22:49:24'),
(20, 5, 65.67, '2020-05-04 22:53:58'),
(21, 5, 65.67, '2020-05-04 22:56:27'),
(26, 4, 25, '2020-05-04 23:23:31'),
(27, 4, 15, '2020-05-05 17:10:33'),
(28, 4, 147.5, '2020-05-05 17:26:03'),
(29, 4, 82.25, '2020-05-05 17:46:07'),
(30, 4, 3.49, '2020-05-05 17:48:58'),
(31, 4, 5, '2020-05-05 17:53:53'),
(32, 4, 87.5, '2020-05-05 18:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `Name`, `Phone`, `Email`, `Password`, `Role`) VALUES
(1, 'Admin', '475-655-5394', 'admin@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Admin'),
(2, 'Manager1', '475-655-5396', 'manager1@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Manager'),
(4, 'Customer1', '475-655-5394', 'customer1@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(5, 'customer2', '475-655-5394', 'customer2@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(8, 'Customer3', '475-655-5394', 'customer3@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(9, 'customer4', '475-655-5394', 'customer4@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(11, 'customer5', '475-655-5394', 'customer5@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(14, 'customer6', '475-655-5394', 'customer6@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(15, 'customer7', '475-655-5394', 'customer7@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(27, 'Manager2', '789-495-7986', 'manager2@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Manager'),
(28, 'Employee3', '542-981-9021', 'employee3@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Employee'),
(30, 'Employee8', '475-655-5394', 'employee8gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Employee'),
(31, 'Manager87', '475-655-5394', 'manager87@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Manager'),
(35, 'Employee1', '475-655-7345', 'employee1@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Employee'),
(40, 'customer8', '475-655-5394', 'customer8@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Customer'),
(43, 'Manager5', '455-908-2390', 'manager5@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Manager'),
(44, 'Employee5', '890-765-2136', 'employee5@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`User_ID`,`Item_ID`),
  ADD KEY `Cart_ibfk_2` (`Item_ID`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`Category`);

--
-- Indexes for table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `Items_ibfk_1` (`Category`);

--
-- Indexes for table `Items_Ordered`
--
ALTER TABLE `Items_Ordered`
  ADD PRIMARY KEY (`Order_ID`,`Item_ID`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Items`
--
ALTER TABLE `Items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Cart`
--
ALTER TABLE `Cart`
  ADD CONSTRAINT `Cart_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Cart_ibfk_2` FOREIGN KEY (`Item_ID`) REFERENCES `Items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Items`
--
ALTER TABLE `Items`
  ADD CONSTRAINT `Items_ibfk_1` FOREIGN KEY (`Category`) REFERENCES `Category` (`Category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Items_Ordered`
--
ALTER TABLE `Items_Ordered`
  ADD CONSTRAINT `Items_Ordered_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `Orders` (`Order_ID`);

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
