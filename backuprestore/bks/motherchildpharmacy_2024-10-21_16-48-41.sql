-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: motherchildpharmacy
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audittrail`
--

DROP TABLE IF EXISTS `audittrail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audittrail` (
  `auditID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountID` int(100) unsigned NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) NOT NULL,
  `Status` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`auditID`),
  KEY `AT_ForeignKey_ItemID` (`AccountID`),
  CONSTRAINT `AT_ForeignKey_ItemID` FOREIGN KEY (`AccountID`) REFERENCES `users` (`AccountID`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audittrail`
--

LOCK TABLES `audittrail` WRITE;
/*!40000 ALTER TABLE `audittrail` DISABLE KEYS */;
INSERT INTO `audittrail` VALUES (1,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jacksona, Role: Admin, Account Name: E002_sjacksona','2024-10-12 09:50:51','::1','1'),(2,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jackson, Role: Admin, Account Name: E002_sjackson','2024-10-12 09:51:35','::1','1'),(3,3,'Login','User logged in successfully.','2024-10-14 05:58:03','::1','1'),(4,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jacksona, Role: Admin, Account Name: E002_sjacksona','2024-10-14 05:59:41','::1','1'),(5,3,'Logout','User logged out successfully.','2024-10-14 06:01:33','::1','1'),(6,3,'Login','User logged in successfully.','2024-10-14 06:01:52','::1','1'),(7,3,'Password Reset','Password reset successfully for account: E002_sjacksona','2024-10-14 06:16:30','::1','1'),(8,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jackson, Role: Admin, Account Name: E002_sjackson','2024-10-14 06:19:02','::1','1'),(9,3,'Password Reset','Password reset successfully for account: E002_sjackson','2024-10-14 06:19:09','::1','1'),(10,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-14 06:24:04','::1','1'),(11,3,'Add User','Added user: Aileen Castro with account name E004_acastro.','2024-10-14 06:42:56','::1','1'),(12,3,'Add User','Added user: Aileen Castro with account name E004_acastro.','2024-10-14 06:44:48','::1','1'),(13,3,'View User Details','Viewed details for account: E004_acastro','2024-10-14 06:45:14','::1','1'),(14,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-14 06:45:37','::1','1'),(15,3,'Password Reset','Password reset successfully for account: E004_acastro','2024-10-14 06:45:44','::1','1'),(16,3,'Archive User','Archived user account: E004_acastro','2024-10-14 06:46:01','::1','1'),(17,3,'Unarchive User','Unarchived user with account name: E004_acastro.','2024-10-14 10:27:07','::1','1'),(18,3,'Change Password','User successfully changed their own password.','2024-10-14 10:38:26','::1','1'),(19,3,'Change Password','User failed to change their own password by entering the old password as the new password.','2024-10-14 10:44:53','::1',''),(20,3,'Change Password','User failed to change their own password by entering the old password as the new password.','2024-10-14 10:45:17','::1',''),(21,3,'Profile Update','User successfully updated their own profile (Picture: , Name: Lancelot Tiangco).','2024-10-14 10:51:32','::1','1'),(22,3,'Profile Update','User successfully updated their own profile (Name: Lance Tiangco).','2024-10-14 10:54:01','::1','1'),(23,3,'Add User','Added user: c test with account name E005_ctest.','2024-10-14 10:59:03','::1','1'),(24,3,'Logout','User logged out successfully.','2024-10-14 10:59:21','::1','1'),(25,5,'Login','User logged in successfully.','2024-10-14 10:59:31','::1','1'),(26,5,'Logout','User logged out successfully.','2024-10-14 10:59:49','::1','1'),(27,3,'Login','User logged in successfully.','2024-10-14 10:59:57','::1','1'),(28,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-01).','2024-10-14 11:19:13','::1','1'),(29,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-01).','2024-10-14 11:19:31','::1','1'),(30,3,'Logout','User logged out successfully.','2024-10-14 12:02:17','::1','1'),(31,3,'Login','User logged in successfully.','2024-10-15 01:41:19','::1','1'),(32,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-15 03:42:25','::1','1'),(33,3,'Logout','User logged out successfully.','2024-10-15 03:57:03','::1','1'),(34,3,'Login','User logged in successfully.','2024-10-15 03:59:42','::1','1'),(35,3,'Logout','User logged out successfully.','2024-10-15 04:00:13','::1','1'),(36,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-16 02:44:57','::1','1'),(37,3,'Create Order','Created purchase order (OrderID: 2).','2024-10-16 02:45:15','::1','1'),(38,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-02).','2024-10-16 02:45:18','::1','1'),(39,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-02).','2024-10-16 02:45:21','::1','1'),(40,3,'Logout','User logged out successfully.','2024-10-16 03:23:09','::1','1'),(41,3,'Auto Backup Failed','Automatic database backup failed.','2024-10-16 03:23:09','::1','1'),(42,3,'Login','User logged in successfully.','2024-10-16 03:26:54','::1','1'),(43,3,'Logout','User logged out successfully.','2024-10-16 03:27:16','::1','1'),(44,3,'Auto Backup Failed','Automatic database backup failed.','2024-10-16 03:27:16','::1','1'),(45,3,'Login','User logged in successfully.','2024-10-16 03:30:46','::1','1'),(46,3,'Logout','User logged out successfully.','2024-10-16 03:30:48','::1','1'),(47,3,'Backup Failed','Database backup failed.','2024-10-16 03:30:48','::1','1'),(48,3,'Login','User logged in successfully.','2024-10-16 03:34:52','::1','1'),(49,3,'Logout','User logged out successfully.','2024-10-16 03:34:58','::1','1'),(50,3,'Backup','Database backup created successfully.','2024-10-16 03:34:58','::1','1'),(51,3,'Login','User logged in successfully.','2024-10-16 03:39:27','::1','1'),(52,3,'Logout','User logged out successfully.','2024-10-16 03:40:00','::1','1'),(53,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 03:40:00','::1','1'),(54,3,'Login','User logged in successfully.','2024-10-16 03:42:06','::1','1'),(55,3,'Logout','User logged out successfully.','2024-10-16 03:44:11','::1','1'),(56,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 03:44:12','::1','1'),(57,3,'Login','User failed to login (Incorrect password).','2024-10-16 03:50:35','::1',''),(58,3,'Login','User logged in successfully.','2024-10-16 03:52:39','::1','1'),(59,3,'Logout','User logged out successfully.','2024-10-16 04:20:03','::1','1'),(60,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 04:20:03','::1','1'),(61,3,'Login','User logged in successfully.','2024-10-20 08:10:31','::1','1'),(62,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-20 08:37:45','::1','1'),(63,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-20 11:46:58','::1','1'),(64,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 11:43:05','::1','1'),(65,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-21 11:44:12','::1','1'),(66,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 12:30:40','::1','1'),(67,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-21 12:50:05','::1','1'),(68,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 14:30:21','::1','1'),(69,3,'Create Order','Created purchase order (OrderID: 3).','2024-10-21 14:31:00','::1','1'),(70,3,'Logout','User logged out successfully.','2024-10-21 14:48:41','::1','1');
/*!40000 ALTER TABLE `audittrail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deliveries` (
  `DeliveryID` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseOrderID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `DeliveryDate` datetime DEFAULT current_timestamp(),
  `ReceivedBy` int(10) unsigned NOT NULL,
  `TotalDeliveredItems` int(11) NOT NULL,
  `DeliveryStatus` enum('Pending','Partial','Completed','Returned') DEFAULT 'Pending',
  PRIMARY KEY (`DeliveryID`),
  KEY `FK_PurchaseOrderID` (`PurchaseOrderID`),
  KEY `FK_SupplierID` (`SupplierID`),
  KEY `FK_ReceivedBy` (`ReceivedBy`),
  CONSTRAINT `FK_PurchaseOrderID` FOREIGN KEY (`PurchaseOrderID`) REFERENCES `purchaseorders` (`PurchaseOrderID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_ReceivedBy` FOREIGN KEY (`ReceivedBy`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries`
--

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_items`
--

DROP TABLE IF EXISTS `delivery_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_items` (
  `ItemID` int(11) NOT NULL,
  `DeliveryID` int(11) NOT NULL,
  `LotNumber` varchar(50) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `QuantityDelivered` int(11) NOT NULL,
  `NetAmount` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ItemID`,`DeliveryID`,`LotNumber`),
  KEY `FK_DeliveryID` (`DeliveryID`),
  CONSTRAINT `FK_DeliveryID` FOREIGN KEY (`DeliveryID`) REFERENCES `deliveries` (`DeliveryID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_items`
--

LOCK TABLES `delivery_items` WRITE;
/*!40000 ALTER TABLE `delivery_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goodsissue`
--

DROP TABLE IF EXISTS `goodsissue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goodsissue` (
  `IssueID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Reason` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IssueID`),
  KEY `GI_ForeignKey_ItemID` (`ItemID`),
  CONSTRAINT `GI_ForeignKey_ItemID` FOREIGN KEY (`ItemID`) REFERENCES `inventory` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goodsissue`
--

LOCK TABLES `goodsissue` WRITE;
/*!40000 ALTER TABLE `goodsissue` DISABLE KEYS */;
/*!40000 ALTER TABLE `goodsissue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goodsreturn`
--

DROP TABLE IF EXISTS `goodsreturn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goodsreturn` (
  `goodsReturnID` int(11) NOT NULL,
  `originalInvoiceID` int(11) NOT NULL,
  `newInvoiceID` int(11) NOT NULL,
  `returnDetails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`returnDetails`)),
  KEY `GR_ForeignKey_InvoiceID` (`originalInvoiceID`),
  CONSTRAINT `GR_ForeignKey_InvoiceID` FOREIGN KEY (`originalInvoiceID`) REFERENCES `sales` (`InvoiceID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goodsreturn`
--

LOCK TABLES `goodsreturn` WRITE;
/*!40000 ALTER TABLE `goodsreturn` DISABLE KEYS */;
/*!40000 ALTER TABLE `goodsreturn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `ItemID` int(11) NOT NULL AUTO_INCREMENT,
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
  `ProductCode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ItemID`),
  KEY `ForeignKey_SupplierID` (`SupplierID`),
  CONSTRAINT `ForeignKey_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (2,'Biogesic','Paracetamol','Medicine','100','Milligrams',5,100,NULL,200.00,NULL,1,'','Active','products-icon/biogesic.png','ParacetamolBiogesic100mg'),(3,'Phenylephrine','Neozep Forte','Medicine','500','Milligrams',3,100,NULL,300.00,NULL,2,'','Active','products-icon/neozep.png','NeozepForte500mg'),(4,'Ibuprofen','Advil','Medicine','200','Milligrams',0,0,NULL,299.00,NULL,1,'','Active','products-icon/Advil.png','AdvilIbuprofen200mg'),(5,'Hyoscine Paracetamol','Buscopan Venus','Medicine','500','Milligrams',0,50,NULL,499.00,NULL,2,'','Active','products-icon/buscopanVenus.png','BuscopanVenus500Mg'),(6,'Loperamide','Diatabs','Medicine','2','Milligrams',0,0,NULL,149.00,NULL,NULL,'','','products-icon/Diatabs.png','DiatabsLoperamide2mg'),(7,'Loperamide','Imodium','Medicine','2','Milligrams',0,0,NULL,149.00,NULL,NULL,'','','products-icon/Imodium.png','ImodiumLoperamide2mg'),(8,'Aluminum Hydroxide Magnesium Hydroxide Simeticone','Kremil-S','Medicine','30','Milligrams',0,0,NULL,499.00,NULL,NULL,'','','products-icon/kremilS.png','KremilS30mg'),(10,'Bisacodyl','Dulcolax','Medicine','5','Milligrams',0,0,NULL,149.00,NULL,NULL,'','','products-icon/dulcolax.png','Dulcolax5mg'),(11,'Ibuprofen','Medicol Advance','Medicine','200','Milligrams',0,0,NULL,200.00,NULL,NULL,'','','products-icon/medicol.png','MedicolAdvance200mg');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productlot`
--

DROP TABLE IF EXISTS `productlot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productlot` (
  `LotNumber` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ExpirationDate` date NOT NULL,
  `isExpired` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`LotNumber`),
  KEY `PL_ForeignKey_ItemID` (`ItemID`),
  CONSTRAINT `PL_ForeignKey_ItemID` FOREIGN KEY (`ItemID`) REFERENCES `inventory` (`ItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productlot`
--

LOCK TABLES `productlot` WRITE;
/*!40000 ALTER TABLE `productlot` DISABLE KEYS */;
/*!40000 ALTER TABLE `productlot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchaseorders`
--

DROP TABLE IF EXISTS `purchaseorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchaseorders` (
  `PurchaseOrderID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `SupplierID` int(11) NOT NULL,
  `AccountID` int(10) unsigned NOT NULL,
  `OrderDetails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`OrderDetails`)),
  `TotalItems` int(11) NOT NULL,
  `ReceivedItems` int(11) NOT NULL DEFAULT 0,
  `NetAmount` decimal(10,2) DEFAULT NULL,
  `Status` enum('Partially Received','Pending','Received','Cancelled') DEFAULT 'Pending',
  PRIMARY KEY (`PurchaseOrderID`),
  KEY `PO_ForeignKey_AccountID` (`AccountID`),
  KEY `PO_ForeignKey_SupplierID` (`SupplierID`),
  CONSTRAINT `PO_ForeignKey_AccountID` FOREIGN KEY (`AccountID`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `PO_ForeignKey_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchaseorders`
--

LOCK TABLES `purchaseorders` WRITE;
/*!40000 ALTER TABLE `purchaseorders` DISABLE KEYS */;
INSERT INTO `purchaseorders` VALUES (1,'2024-10-10 10:09:03',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":100},\"2\":{\"itemID\":\"5\",\"qty\":200}}',300,0,NULL,'Cancelled'),(2,'2024-10-16 10:45:15',1,3,'{\"1\":{\"itemID\":\"2\",\"qty\":100}}',100,0,NULL,'Pending'),(3,'2024-10-21 22:31:00',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":100},\"2\":{\"itemID\":\"5\",\"qty\":50}}',150,0,NULL,'Pending');
/*!40000 ALTER TABLE `purchaseorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `InvoiceID` int(11) NOT NULL AUTO_INCREMENT,
  `SaleDate` datetime DEFAULT current_timestamp(),
  `AccountID` int(10) unsigned DEFAULT NULL,
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
  `RefundAmount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`InvoiceID`),
  KEY `ForeignKey_AccountID` (`AccountID`),
  CONSTRAINT `ForeignKey_AccountID` FOREIGN KEY (`AccountID`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'2024-09-29 01:34:29',3,'{\r\n	\"1\":{\r\n		\"itemID\":\"2\",\r\n		\"qty\":5\r\n	},\r\n	\"2\":{\r\n		\"itemID\":\"3\",\r\n		\"qty\":3\r\n	}\r\n}',8,1900.00,228.00,0.00,2128.00,2500.00,372.00,'Cash','Sales',NULL);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `SupplierID` int(11) NOT NULL AUTO_INCREMENT,
  `SupplierName` varchar(255) NOT NULL,
  `AgentName` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Status` enum('Active','Inactive','Archived') DEFAULT 'Active',
  `Notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`SupplierID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Metro Drug Inc. (MDI)','Agent MDI','(02) 8539 4342','mdi@metrodrug.com.ph','Active',''),(2,'Zuellig Pharma Corporation','Agent K','+63 (2) 908 2222','zpspeakup@zuelligpharma.com','Active',NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `AccountID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeName` varchar(255) NOT NULL,
  `employeeLName` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `accountName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` text NOT NULL DEFAULT 'profile_icon.png',
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `connected` enum('1','0') NOT NULL DEFAULT '0',
  `SuppliersPerms` enum('on','off') NOT NULL DEFAULT 'off',
  `TransactionsPerms` enum('on','off') NOT NULL DEFAULT 'off',
  `InventoryPerms` enum('on','off') NOT NULL DEFAULT 'off',
  `POSPerms` enum('on','off') NOT NULL DEFAULT 'off',
  `REPerms` enum('on','off') NOT NULL DEFAULT 'off',
  `POPerms` enum('on','off') NOT NULL DEFAULT 'off',
  `UsersPerms` enum('on','off') NOT NULL DEFAULT 'off',
  PRIMARY KEY (`AccountID`),
  UNIQUE KEY `accountName` (`accountName`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Sayra','Jackson','Admin','E002_sjackson','jackson-e002','Chichi.jpg','2024-09-22 21:27:48','Active','0','on','on','on','on','on','on','on'),(3,'Lance','Tiangco','Admin','E003_ltiangco','lancetiangco26!!','dubu2.jpg','2024-09-01 23:42:57','Active','0','on','on','on','on','on','on','on'),(4,'Aileen','Castro','Admin','E004_acastro','castro-e004','owner.png','2024-10-14 14:44:48','Active','0','on','on','on','on','on','on','on'),(5,'c','test','Pharmacy Assistant','E005_ctest','test-e005','Shrek.png','2024-10-14 18:59:03','Active','0','off','on','off','on','on','off','off');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-21 22:48:42
