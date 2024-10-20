-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 07:18 AM
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
-- Database: `motherchildpharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `goodsissue`
--

CREATE TABLE `goodsissue` (
  `IssueID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Reason` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goodsreturn`
--

CREATE TABLE `goodsreturn` (
  `goodsReturnID` int(11) NOT NULL,
  `originalInvoiceID` int(11) NOT NULL,
  `newInvoiceID` int(11) NOT NULL,
  `returnDetails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`returnDetails`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `ItemID` int(11) NOT NULL,
  `GenericName` varchar(255) DEFAULT NULL,
  `BrandName` varchar(255) DEFAULT NULL,
  `ItemType` varchar(50) DEFAULT NULL,
  `Mass` varchar(50) DEFAULT NULL,
  `UnitOfMeasure` varchar(20) DEFAULT NULL,
  `InStock` int(10) DEFAULT NULL,
  `Ordered` int(10) NOT NULL,
  `ReorderLevel` int(11) DEFAULT NULL,
  `PricePerUnit` decimal(10,2) DEFAULT NULL,
  `Discount` varchar(3) DEFAULT NULL CHECK (`Discount` in ('Yes','No')),
  `SupplierID` int(11) DEFAULT NULL,
  `Notes` text DEFAULT NULL,
  `Status` enum('Active','Inactive','Archived') NOT NULL DEFAULT 'Active',
  `ProductIcon` varchar(255) DEFAULT NULL,
  `ProductCode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`ItemID`, `GenericName`, `BrandName`, `ItemType`, `Mass`, `UnitOfMeasure`, `InStock`, `Ordered`, `ReorderLevel`, `PricePerUnit`, `Discount`, `SupplierID`, `Notes`, `Status`, `ProductIcon`, `ProductCode`) VALUES
(1, 'Cephalexin', 'Ascend Capsule', 'Medicine', '100', 'Milligrams', 50, 100, NULL, 52.75, 'Yes', 1, '', 'Active', 'products-icon/cephalexin.jpg', '342043143581'),
(2, 'Paracetamol', 'Biogesic Tablet', 'Medicine', '100', 'Milligrams', 5, 100, NULL, 4.81, 'Yes', 1, '', 'Active', 'products-icon/biogesic.png', '4807788519184'),
(3, 'Phenylephrine', 'Neozep Forte Tablet', 'Medicine', '500', 'Milligrams', 0, 0, NULL, 6.70, NULL, 2, '', 'Active', 'products-icon/neozep.png', 'NeozepForte500mg'),
(4, 'Ibuprofen', 'Advil Liquigel Capsule', 'Medicine', '200', 'Milligrams', 50, 0, NULL, 9.47, NULL, 1, '', 'Active', 'products-icon/Advil.png', '5012816018334'),
(5, 'Hyoscine Paracetamol', 'Buscopan Venus Tablet', 'Medicine', '500', 'Milligrams', 10, 0, NULL, 42.52, NULL, 2, '', 'Active', 'products-icon/buscopanVenus.png', '5012816018334'),
(6, 'Loperamide', 'Diatabs Capsule', 'Medicine', '2', 'Milligrams', 0, 0, NULL, 8.84, NULL, NULL, '', 'Active', 'products-icon/Diatabs.png', 'DiatabsLoperamide2mg'),
(7, 'Loperamide', 'Imodium Capsule', 'Medicine', '2', 'Milligrams', 50, 0, NULL, 20.36, NULL, NULL, '', 'Active', 'products-icon/Imodium.png', '686919114252'),
(8, 'Aluminum Hydroxide Magnesium Hydroxide Simeticone', 'Kremil-S Tablet', 'Medicine', '30', 'Milligrams', 50, 0, NULL, 9.68, NULL, NULL, '', 'Active', 'products-icon/kremilS.png', '801883381176'),
(10, 'Bisacodyl', 'Dulcolax Supp Adult', 'Medicine', '10', 'Milligrams', 50, 0, NULL, 67.99, NULL, NULL, '', 'Active', 'products-icon/dulcolax.png', ''),
(11, 'Ibuprofen', 'Medicol Advance Capsule', 'Medicine', '200', 'Grams', 0, 0, NULL, 7.28, NULL, NULL, '', 'Active', 'products-icon/medicol.png', 'MedicolAdvance200mg'),
(12, 'Dark Chocolate', 'Goya', 'Milk', '30', 'Grams', 50, 0, NULL, 35.00, 'Yes', NULL, '', 'Active', 'products-icon/Goya.png', '4806517042085'),
(13, 'Antibacterial Cream', 'Miaojia Zudaifu', 'Skincare', '15', 'Grams', 15, 0, NULL, 46.00, 'Yes', NULL, '', 'Active', 'products-icon/miaojia_zudaifu.png', '6972804743237'),
(14, 'Multivitamins', 'Enervon Tablet', 'Vitamins', '500', 'Milligrams', 50, 0, NULL, 245.10, 'Yes', NULL, '', 'Active', 'products-icon/Enervon.jpg', '656124805511'),
(15, 'Baby Powder', 'Johnson\'s', 'Cosmetics', '25', 'Grams', 20, 0, NULL, 15.00, 'Yes', NULL, '', 'Active', 'products-icon/Baby powder.jpg', '381371172672'),
(16, 'Adhesive Bandage', 'Band-Aid', 'Skincare', '50', 'Pieces', 50, 0, NULL, 125.00, 'Yes', NULL, '', 'Active', 'products-icon/bandaid.jpg', '381370058496'),
(17, 'Salbutamol Sulfate', 'Aero-Vent', 'Medicine', '1', 'Milligrams', 50, 0, NULL, 15.00, 'Yes', NULL, '', 'Active', 'products-icon/Aero.png', '9785511311548'),
(18, 'Powdered Milk', 'Nestlé Bear Brand Swak Pack', 'Milk', '33', 'Grams', 0, 0, NULL, 11.50, 'Yes', NULL, '', 'Active', 'products-icon/bearbrand.png', 'swakpack33g'),
(19, 'Powdered Milk', 'Nestlé Nido 3+', 'Milk', '2', 'Kilograms', 25, 0, NULL, 1245.00, 'Yes', NULL, '', 'Active', 'products-icon/Nido3+.png', '028000610302'),
(20, 'Powdered Milk', 'Nestlé Nido 5+', 'Milk', '2', 'Kilograms', 0, 0, NULL, 1229.50, 'Yes', NULL, '', 'Active', 'products-icon/Nido.png', 'nido5+2kg');

-- --------------------------------------------------------

--
-- Table structure for table `productlot`
--

CREATE TABLE `productlot` (
  `LotNumber` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ExpirationDate` date NOT NULL,
  `isExpired` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorders`
--

CREATE TABLE `purchaseorders` (
  `PurchaseOrderID` int(11) NOT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `SupplierID` int(11) NOT NULL,
  `AccountID` int(10) UNSIGNED NOT NULL,
  `OrderDetails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`OrderDetails`)),
  `TotalItems` int(11) NOT NULL,
  `NetAmount` decimal(10,2) DEFAULT NULL,
  `Status` enum('Pending','Received','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseorders`
--

INSERT INTO `purchaseorders` (`PurchaseOrderID`, `OrderDate`, `SupplierID`, `AccountID`, `OrderDetails`, `TotalItems`, `NetAmount`, `Status`) VALUES
(1, '2024-10-10 10:09:03', 2, 3, '{\"1\":{\"itemID\":\"3\",\"qty\":100},\"2\":{\"itemID\":\"5\",\"qty\":200}}', 300, NULL, 'Cancelled'),
(2, '2024-10-16 10:45:15', 1, 3, '{\"1\":{\"itemID\":\"2\",\"qty\":100}}', 100, NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `InvoiceID` int(11) NOT NULL,
  `SaleDate` datetime DEFAULT current_timestamp(),
  `AccountID` int(10) UNSIGNED DEFAULT NULL,
  `SalesDetails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`SalesDetails`)),
  `TotalItems` int(11) NOT NULL,
  `Subtotal` decimal(10,2) DEFAULT 0.00,
  `Tax` decimal(10,2) DEFAULT 0.00,
  `Discount` decimal(10,2) DEFAULT 0.00,
  `NetAmount` decimal(10,2) GENERATED ALWAYS AS (`Subtotal` - `Discount` + `Tax`) STORED,
  `AmountPaid` decimal(10,2) DEFAULT 0.00,
  `AmountChange` decimal(10,2) GENERATED ALWAYS AS (`AmountPaid` - `NetAmount`) STORED,
  `PaymentMethod` enum('Cash','GCash') NOT NULL,
  `Status` enum('Sales','Return','Return/Exchange') NOT NULL,
  `RefundAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`InvoiceID`, `SaleDate`, `AccountID`, `SalesDetails`, `TotalItems`, `Subtotal`, `Tax`, `Discount`, `AmountPaid`, `PaymentMethod`, `Status`, `RefundAmount`) VALUES
(1, '2024-09-29 01:34:29', 3, '{\r\n	\"1\":{\r\n		\"itemID\":\"2\",\r\n		\"qty\":5\r\n	},\r\n	\"2\":{\r\n		\"itemID\":\"3\",\r\n		\"qty\":3\r\n	}\r\n}', 8, 1900.00, 228.00, 0.00, 2500.00, 'Cash', 'Sales', NULL),
(2, '2024-10-20 13:17:27', 2, '{\"1\":{\"qty\":1}}', 1, 9.47, 1.14, 0.00, 11.00, 'Cash', 'Sales', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(255) NOT NULL,
  `AgentName` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Status` enum('Active','Inactive','Archived') DEFAULT 'Active',
  `Notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`SupplierID`, `SupplierName`, `AgentName`, `Phone`, `Email`, `Status`, `Notes`) VALUES
(1, 'Metro Drug Inc. (MDI)', 'Agent MDI', '(02) 8539 4342', 'mdi@metrodrug.com.ph', 'Active', ''),
(2, 'Zuellig Pharma Corporation', 'Agent K', '+63 (2) 908 2222', 'zpspeakup@zuelligpharma.com', 'Active', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `goodsissue`
--
ALTER TABLE `goodsissue`
  ADD PRIMARY KEY (`IssueID`),
  ADD KEY `GI_ForeignKey_ItemID` (`ItemID`);

--
-- Indexes for table `goodsreturn`
--
ALTER TABLE `goodsreturn`
  ADD KEY `GR_ForeignKey_InvoiceID` (`originalInvoiceID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `ForeignKey_SupplierID` (`SupplierID`);

--
-- Indexes for table `productlot`
--
ALTER TABLE `productlot`
  ADD PRIMARY KEY (`LotNumber`),
  ADD KEY `PL_ForeignKey_ItemID` (`ItemID`);

--
-- Indexes for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  ADD PRIMARY KEY (`PurchaseOrderID`),
  ADD KEY `PO_ForeignKey_AccountID` (`AccountID`),
  ADD KEY `PO_ForeignKey_SupplierID` (`SupplierID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`InvoiceID`),
  ADD KEY `ForeignKey_AccountID` (`AccountID`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`SupplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `goodsissue`
--
ALTER TABLE `goodsissue`
  MODIFY `IssueID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  MODIFY `PurchaseOrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `InvoiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `goodsissue`
--
ALTER TABLE `goodsissue`
  ADD CONSTRAINT `GI_ForeignKey_ItemID` FOREIGN KEY (`ItemID`) REFERENCES `inventory` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `goodsreturn`
--
ALTER TABLE `goodsreturn`
  ADD CONSTRAINT `GR_ForeignKey_InvoiceID` FOREIGN KEY (`originalInvoiceID`) REFERENCES `sales` (`InvoiceID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `ForeignKey_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `productlot`
--
ALTER TABLE `productlot`
  ADD CONSTRAINT `PL_ForeignKey_ItemID` FOREIGN KEY (`ItemID`) REFERENCES `inventory` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  ADD CONSTRAINT `PO_ForeignKey_AccountID` FOREIGN KEY (`AccountID`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `PO_ForeignKey_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `ForeignKey_AccountID` FOREIGN KEY (`AccountID`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
