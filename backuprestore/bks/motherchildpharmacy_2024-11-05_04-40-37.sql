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
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audittrail`
--

LOCK TABLES `audittrail` WRITE;
/*!40000 ALTER TABLE `audittrail` DISABLE KEYS */;
INSERT INTO `audittrail` VALUES (1,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jacksona, Role: Admin, Account Name: E002_sjacksona','2024-10-12 09:50:51','::1','1'),(2,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jackson, Role: Admin, Account Name: E002_sjackson','2024-10-12 09:51:35','::1','1'),(3,3,'Login','User logged in successfully.','2024-10-14 05:58:03','::1','1'),(4,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jacksona, Role: Admin, Account Name: E002_sjacksona','2024-10-14 05:59:41','::1','1'),(5,3,'Logout','User logged out successfully.','2024-10-14 06:01:33','::1','1'),(6,3,'Login','User logged in successfully.','2024-10-14 06:01:52','::1','1'),(7,3,'Password Reset','Password reset successfully for account: E002_sjacksona','2024-10-14 06:16:30','::1','1'),(8,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jackson, Role: Admin, Account Name: E002_sjackson','2024-10-14 06:19:02','::1','1'),(9,3,'Password Reset','Password reset successfully for account: E002_sjackson','2024-10-14 06:19:09','::1','1'),(10,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-14 06:24:04','::1','1'),(11,3,'Add User','Added user: Aileen Castro with account name E004_acastro.','2024-10-14 06:42:56','::1','1'),(12,3,'Add User','Added user: Aileen Castro with account name E004_acastro.','2024-10-14 06:44:48','::1','1'),(13,3,'View User Details','Viewed details for account: E004_acastro','2024-10-14 06:45:14','::1','1'),(14,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-14 06:45:37','::1','1'),(15,3,'Password Reset','Password reset successfully for account: E004_acastro','2024-10-14 06:45:44','::1','1'),(16,3,'Archive User','Archived user account: E004_acastro','2024-10-14 06:46:01','::1','1'),(17,3,'Unarchive User','Unarchived user with account name: E004_acastro.','2024-10-14 10:27:07','::1','1'),(18,3,'Change Password','User successfully changed their own password.','2024-10-14 10:38:26','::1','1'),(19,3,'Change Password','User failed to change their own password by entering the old password as the new password.','2024-10-14 10:44:53','::1',''),(20,3,'Change Password','User failed to change their own password by entering the old password as the new password.','2024-10-14 10:45:17','::1',''),(21,3,'Profile Update','User successfully updated their own profile (Picture: , Name: Lancelot Tiangco).','2024-10-14 10:51:32','::1','1'),(22,3,'Profile Update','User successfully updated their own profile (Name: Lance Tiangco).','2024-10-14 10:54:01','::1','1'),(23,3,'Add User','Added user: c test with account name E005_ctest.','2024-10-14 10:59:03','::1','1'),(24,3,'Logout','User logged out successfully.','2024-10-14 10:59:21','::1','1'),(25,5,'Login','User logged in successfully.','2024-10-14 10:59:31','::1','1'),(26,5,'Logout','User logged out successfully.','2024-10-14 10:59:49','::1','1'),(27,3,'Login','User logged in successfully.','2024-10-14 10:59:57','::1','1'),(28,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-01).','2024-10-14 11:19:13','::1','1'),(29,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-01).','2024-10-14 11:19:31','::1','1'),(30,3,'Logout','User logged out successfully.','2024-10-14 12:02:17','::1','1'),(31,3,'Login','User logged in successfully.','2024-10-15 01:41:19','::1','1'),(32,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-15 03:42:25','::1','1'),(33,3,'Logout','User logged out successfully.','2024-10-15 03:57:03','::1','1'),(34,3,'Login','User logged in successfully.','2024-10-15 03:59:42','::1','1'),(35,3,'Logout','User logged out successfully.','2024-10-15 04:00:13','::1','1'),(36,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-16 02:44:57','::1','1'),(37,3,'Create Order','Created purchase order (OrderID: 2).','2024-10-16 02:45:15','::1','1'),(38,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-02).','2024-10-16 02:45:18','::1','1'),(39,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-02).','2024-10-16 02:45:21','::1','1'),(40,3,'Logout','User logged out successfully.','2024-10-16 03:23:09','::1','1'),(41,3,'Auto Backup Failed','Automatic database backup failed.','2024-10-16 03:23:09','::1','1'),(42,3,'Login','User logged in successfully.','2024-10-16 03:26:54','::1','1'),(43,3,'Logout','User logged out successfully.','2024-10-16 03:27:16','::1','1'),(44,3,'Auto Backup Failed','Automatic database backup failed.','2024-10-16 03:27:16','::1','1'),(45,3,'Login','User logged in successfully.','2024-10-16 03:30:46','::1','1'),(46,3,'Logout','User logged out successfully.','2024-10-16 03:30:48','::1','1'),(47,3,'Backup Failed','Database backup failed.','2024-10-16 03:30:48','::1','1'),(48,3,'Login','User logged in successfully.','2024-10-16 03:34:52','::1','1'),(49,3,'Logout','User logged out successfully.','2024-10-16 03:34:58','::1','1'),(50,3,'Backup','Database backup created successfully.','2024-10-16 03:34:58','::1','1'),(51,3,'Login','User logged in successfully.','2024-10-16 03:39:27','::1','1'),(52,3,'Logout','User logged out successfully.','2024-10-16 03:40:00','::1','1'),(53,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 03:40:00','::1','1'),(54,3,'Login','User logged in successfully.','2024-10-16 03:42:06','::1','1'),(55,3,'Logout','User logged out successfully.','2024-10-16 03:44:11','::1','1'),(56,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 03:44:12','::1','1'),(57,3,'Login','User failed to login (Incorrect password).','2024-10-16 03:50:35','::1',''),(58,3,'Login','User logged in successfully.','2024-10-16 03:52:39','::1','1'),(59,3,'Logout','User logged out successfully.','2024-10-16 04:20:03','::1','1'),(60,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 04:20:03','::1','1'),(61,3,'Login','User logged in successfully.','2024-10-20 08:10:31','::1','1'),(62,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-20 08:37:45','::1','1'),(63,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-20 11:46:58','::1','1'),(64,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 11:43:05','::1','1'),(65,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-21 11:44:12','::1','1'),(66,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 12:30:40','::1','1'),(67,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-21 12:50:05','::1','1'),(68,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 14:30:21','::1','1'),(69,3,'Create Order','Created purchase order (OrderID: 3).','2024-10-21 14:31:00','::1','1'),(70,3,'Logout','User logged out successfully.','2024-10-21 14:48:41','::1','1'),(71,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-21 14:48:42','::1','1'),(72,3,'Login','User logged in successfully.','2024-10-27 08:13:41','::1','1'),(73,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 08:17:52','::1','1'),(74,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-27 09:26:03','::1','1'),(75,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 09:28:11','::1','1'),(76,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-27 10:52:37','::1','1'),(77,3,'Received Delivery','User successfully received delivery (Delivery ID: DE-01).','2024-10-27 10:52:56','::1','1'),(78,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 12:46:01','::1','1'),(79,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 12:48:03','::1','1'),(80,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-27 13:00:31','::1','1'),(81,3,'View User Details','Viewed details for account: E004_acastro','2024-10-27 13:02:14','::1','1'),(82,3,'View User Details','Viewed details for account: E004_acastro','2024-10-27 13:03:16','::1','1'),(83,3,'Logout','User logged out successfully.','2024-10-27 13:13:32','::1','1'),(84,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-27 13:13:32','::1','1'),(85,3,'Login','User logged in successfully.','2024-10-27 14:49:36','::1','1'),(86,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 14:53:25','::1','1'),(87,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 14:53:38','::1','1'),(88,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 14:53:51','::1','1'),(89,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 15:14:32','::1','1'),(90,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 15:15:10','::1','1'),(91,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 15:16:29','::1','1'),(92,3,'Create Order','Created purchase order (OrderID: 4).','2024-10-27 15:18:11','::1','1'),(93,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 16:08:51','::1','1'),(94,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-27 16:10:12','::1','1'),(95,3,'Logout','User logged out successfully.','2024-10-27 16:13:57','::1','1'),(96,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-27 16:13:57','::1','1'),(97,3,'Login','User logged in successfully.','2024-10-29 14:09:42','::1','1'),(98,3,'View User Details','Viewed details for account: E005_ctest','2024-10-29 14:09:58','::1','1'),(99,3,'Archive User','Archived user account: E005_ctest','2024-10-29 14:11:03','::1','1'),(100,3,'Unarchive User','Unarchived user with account name: E005_ctest.','2024-10-29 14:11:10','::1','1'),(101,3,'View User Details','Viewed details for account: E005_ctest','2024-10-29 14:11:13','::1','1'),(102,3,'Profile Update','User updated a profile with new data: Name: The, Last Name: Shrek, Role: Pharmacy Assistant, Account Name: E005_tshrek','2024-10-29 14:11:21','::1','1'),(103,3,'Archive User','Archived user account: E005_tshrek','2024-10-29 14:11:25','::1','1'),(104,3,'Add User','Added user: Cashier Ashiera with account name E006_cashiera.','2024-10-29 14:13:40','::1','1'),(105,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-29 14:18:30','::1','1'),(106,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-29 15:34:56','::1','1'),(107,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-29 16:08:59','::1','1'),(108,3,'Logout','User logged out successfully.','2024-10-29 17:11:01','::1','1'),(109,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-29 17:11:01','::1','1'),(110,6,'Login','User logged in successfully.','2024-10-29 17:12:49','::1','1'),(111,6,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:13:25','::1','1'),(112,6,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:19:02','::1','1'),(113,6,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:21:59','::1','1'),(114,6,'Logout','User logged out successfully.','2024-10-29 17:22:06','::1','1'),(115,6,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-29 17:22:06','::1','1'),(116,3,'Login','User logged in successfully.','2024-10-29 17:22:16','::1','1'),(117,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:23:10','::1','1'),(118,3,'Logout','User logged out successfully.','2024-10-29 17:33:27','::1','1'),(119,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-29 17:33:27','::1','1'),(120,3,'Login','User logged in successfully.','2024-10-30 09:44:43','::1','1'),(121,3,'Login','User logged in successfully.','2024-11-02 10:45:14','::1','1'),(122,3,'Login','User logged in successfully.','2024-11-02 12:24:00','::1','1'),(123,3,'View User Details','Viewed details for account: E006_cashiera','2024-11-02 15:18:29','::1','1'),(124,3,'Login','User logged in successfully.','2024-11-02 18:42:35','::1','1'),(125,3,'Login','User logged in successfully.','2024-11-02 18:55:42','::1','1'),(126,3,'Login','User logged in successfully.','2024-11-03 07:53:59','::1','1'),(127,3,'Login','User logged in successfully.','2024-11-03 13:11:36','::1','1'),(128,3,'Login','User logged in successfully.','2024-11-04 13:11:28','::1','1'),(129,3,'Add Product','User added a new product. (ItemID: 113).','2024-11-04 13:12:00','::1','1'),(130,3,'Product Update','User updated the details of a product. (ItemID: 113).','2024-11-04 13:12:12','::1','1'),(131,3,'Login','User logged in successfully.','2024-11-04 13:29:19','::1','1'),(132,3,'Add Product','User added a new product. (ItemID: 114).','2024-11-04 13:56:28','::1','1'),(133,3,'Add Product','User added a new product. (ItemID: 115).','2024-11-04 14:27:24','::1','1'),(134,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-04 14:48:12','::1','1'),(135,3,'Login','User logged in successfully.','2024-11-04 15:09:24','::1','1'),(136,3,'Login','User logged in successfully.','2024-11-04 15:44:16','::1','1'),(137,3,'Login','User logged in successfully.','2024-11-04 15:57:25','::1','1'),(138,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 15:57:48','::1','1'),(139,3,'Goods Issue','User manually adjusted the stock of a product. (ItemID: 1, Quantity: 10).','2024-11-04 16:00:11','::1','1'),(140,3,'Goods Issue','User manually adjusted the stock of a product. (ItemID: 1, Quantity: 10).','2024-11-04 16:24:28','::1','1'),(141,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 16:42:01','::1','1'),(142,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 16:51:50','::1','1'),(143,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 16:52:03','::1','1'),(144,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 16:55:41','::1','1'),(145,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 16:57:47','::1','1'),(146,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 16:59:39','::1','1'),(147,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 17:05:19','::1','1'),(148,3,'Add Product','User added a new product. (ItemID: 116).','2024-11-04 17:07:40','::1','1'),(149,3,'Product Update','User updated the details of a product. (ItemID: 111).','2024-11-04 17:08:33','::1','1'),(150,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-04 17:08:42','::1','1'),(151,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 17:09:01','::1','1'),(152,3,'Add Product','User added a new product. (ItemID: 117).','2024-11-04 17:09:47','::1','1'),(153,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 17:16:24','::1','1'),(154,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 17:16:31','::1','1'),(155,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 17:19:26','::1','1'),(156,3,'Product Update','User updated the details of a product. (ItemID: 4).','2024-11-04 18:29:43','::1','1'),(157,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-04 18:29:59','::1','1'),(158,3,'Product Update','User updated the details of a product. (ItemID: 5).','2024-11-04 18:30:17','::1','1'),(159,3,'Product Update','User updated the details of a product. (ItemID: 8).','2024-11-04 18:30:54','::1','1'),(160,3,'Product Update','User updated the details of a product. (ItemID: 10).','2024-11-04 18:31:14','::1','1'),(161,3,'Product Update','User updated the details of a product. (ItemID: 1).','2024-11-04 18:31:47','::1','1'),(162,3,'Add Product','User added a new product. (ItemID: 118).','2024-11-05 00:33:54','::1','1'),(163,3,'Goods Issue','User manually adjusted the stock of a product. (ItemID: 1, Quantity: 5).','2024-11-05 00:34:52','::1','1'),(164,3,'Logout','User logged out successfully.','2024-11-05 00:38:30','::1','1'),(165,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-05 00:38:30','::1','1'),(166,6,'Login','User logged in successfully.','2024-11-05 00:39:12','::1','1'),(167,6,'Logout','User logged out successfully.','2024-11-05 00:56:55','::1','1'),(168,6,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-05 00:56:56','::1','1'),(169,3,'Login','User logged in successfully.','2024-11-05 00:57:11','::1','1'),(170,3,'Add User','Added user: kort alv with account name E007_kalv.','2024-11-05 00:58:27','::1','1'),(171,3,'Logout','User logged out successfully.','2024-11-05 00:58:59','::1','1'),(172,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-05 00:59:00','::1','1'),(173,7,'Login','User logged in successfully.','2024-11-05 00:59:06','::1','1'),(174,7,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-05 01:00:19','::1','1'),(175,7,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-05 03:09:20','::1','1'),(176,7,'Create Order','Created purchase order (OrderID: 5).','2024-11-05 03:30:54','::1','1'),(177,7,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-05 03:40:37','::1','1');
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
  `DeliveryStatus` enum('Pending','Back Order','Completed','Returned') DEFAULT 'Pending',
  PRIMARY KEY (`DeliveryID`),
  KEY `FK_PurchaseOrderID` (`PurchaseOrderID`),
  KEY `FK_SupplierID` (`SupplierID`),
  KEY `FK_ReceivedBy` (`ReceivedBy`),
  CONSTRAINT `FK_PurchaseOrderID` FOREIGN KEY (`PurchaseOrderID`) REFERENCES `purchaseorders` (`PurchaseOrderID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_ReceivedBy` FOREIGN KEY (`ReceivedBy`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries`
--

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
INSERT INTO `deliveries` VALUES (1,2,1,'2024-10-27 18:52:56',3,50,'Back Order');
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
  `Bonus` int(11) NOT NULL DEFAULT 0,
  `QuantityRemaining` int(11) NOT NULL,
  `NetAmount` float NOT NULL DEFAULT 0,
  `isExpired` enum('0','1','','') NOT NULL DEFAULT '0',
  PRIMARY KEY (`ItemID`,`DeliveryID`,`LotNumber`),
  KEY `FK_DeliveryID` (`DeliveryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_items`
--

LOCK TABLES `delivery_items` WRITE;
/*!40000 ALTER TABLE `delivery_items` DISABLE KEYS */;
INSERT INTO `delivery_items` VALUES (1,1,'1H17359','2024-12-19',50,5,54,400,'0'),(2,2,'2H17360','2024-12-15',30,3,33,300,'0'),(3,3,'3H17361','2024-11-20',100,10,95,800,'0'),(4,4,'4H17362','2024-12-01',75,0,70,600,'0'),(5,5,'5H17363','2025-11-30',20,2,18,150,'0'),(6,6,'6H17364','2026-01-15',60,6,58,500,'0'),(7,7,'7H17365','2026-02-10',150,15,145,1200,'0'),(8,8,'8H17366','2025-10-25',40,4,36,320,'0'),(9,9,'9H17367','2026-03-05',10,1,9,80,'0'),(10,10,'10H17368','2025-12-31',80,8,72,640,'0');
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goodsissue`
--

LOCK TABLES `goodsissue` WRITE;
/*!40000 ALTER TABLE `goodsissue` DISABLE KEYS */;
INSERT INTO `goodsissue` VALUES (1,2,5,'Initial stock issuance','2024-10-30 16:03:34'),(2,3,10,'Restocking for seasonal sale','2024-10-30 16:03:37'),(3,4,3,'Damaged goods return','2024-10-30 16:03:41'),(40,2,50,'restock','2024-10-30 09:53:18'),(42,2,100,'refund','2024-11-02 23:56:50'),(43,2,30,'Added 30','2024-11-03 08:49:12'),(44,2,10,'expired medicine','2024-11-03 09:00:48'),(45,1,10,'damage goods','2024-11-04 08:00:11'),(46,1,10,'st','2024-11-04 08:24:28'),(47,1,5,'added','2024-11-04 16:34:52');
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
  `InStock` int(10) NOT NULL DEFAULT 0,
  `Ordered` int(10) NOT NULL DEFAULT 0,
  `ReorderLevel` int(11) NOT NULL DEFAULT 0,
  `PricePerUnit` decimal(10,2) DEFAULT NULL,
  `Discount` int(11) NOT NULL DEFAULT 0,
  `VAT_exempted` tinyint(4) NOT NULL DEFAULT 0,
  `SupplierID` int(11) DEFAULT NULL,
  `Notes` text DEFAULT NULL,
  `Status` enum('Active','Inactive','Archived') NOT NULL DEFAULT 'Active',
  `ProductIcon` varchar(255) DEFAULT NULL,
  `ProductCode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ItemID`),
  KEY `ForeignKey_SupplierID` (`SupplierID`),
  CONSTRAINT `ForeignKey_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,'Cephalexin','Ascend Capsule','Medicine','100','g',45,100,50,52.88,0,0,1,NULL,'Active','products-icon/cephalexin.jpg','342043143581'),(2,'Paracetamol','Biogesic Tablet','Medicine','100','',29,200,50,4.81,0,0,1,'','Active','products-icon/biogesic.png','4807788561688'),(3,'Phenylephrine Hydrochloride, Chlorphenamine Maleat...','Neozep Forte Tablet','Medicine','500','Milligrams',39,50,25,6.70,1,0,2,'','Active','products-icon/neozep.png','NeozepForte500mg'),(4,'Ibuprofen','Advil Liquigel Capsule','Medicine','200','Milligrams',42,50,25,9.47,0,0,1,'','Active','products-icon/Advil.png','912203812376'),(5,'Hyoscine-N-Butylbromide, Paracetamol','Buscopan Venus Tablet','Medicine','500','Milligrams',30,50,25,42.52,1,0,2,'','Active','products-icon/buscopanVenus.png','5012816018334'),(6,'Loperamide','Diatabs Capsule','Medicine','2','Milligrams',1,50,25,8.84,0,0,1,'','Active','products-icon/Diatabs.png','DiatabsLoperamide2mg'),(7,'Loperamide','Imodium Capsule','Medicine','2','Milligrams',30,50,25,20.36,0,0,NULL,'','Active','products-icon/Imodium.png','686919114252'),(8,'Aluminum Hydroxide, Magnesium Hydroxide, Simeticone','Kremil-S Tablet','Medicine','30','Milligrams',35,100,50,9.68,0,0,NULL,'','Active','products-icon/kremilS.png','801883381176'),(10,'Bisacodyl','Dulcolax Supp Adult','Medicine','10','Mg',5,30,15,67.99,0,0,NULL,'','Active','products-icon/dulcolax.png','5012917077049'),(11,'Ibuprofen','Medicol Advance Capsule','Medicine','200','Grams',4,50,25,7.28,0,0,NULL,'','Active','products-icon/medicol.png','MedicolAdvance200mg'),(12,'Phenylephrine','Neozep','Milk','150','pc',20,100,30,47.00,1,0,NULL,'','Active','../resources/img/default_Icon.png','ParacetamolBiogesic100mg'),(13,'nestle','Bearbrand','Milk','150','Mg',5,100,30,200.00,0,1,NULL,'','Active','../resources/img/default_Icon.png','ParacetamolBiogesic100mg'),(14,'Biogesic','Paracetamol','Vitamin','100','g',1,100,30,200.00,0,0,NULL,'','Active','../resources/img/default_Icon.png','ParacetamolBiogesic100mg'),(118,'Antibacterial Cream','STI College','Medicine','500','g',0,0,0,99.99,1,1,NULL,'','Active','../resources/img/default_Icon.png','4806517042085');
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
  `Status` enum('Back Order','Pending','Received','Cancelled') DEFAULT 'Pending',
  PRIMARY KEY (`PurchaseOrderID`),
  KEY `PO_ForeignKey_AccountID` (`AccountID`),
  KEY `PO_ForeignKey_SupplierID` (`SupplierID`),
  CONSTRAINT `PO_ForeignKey_AccountID` FOREIGN KEY (`AccountID`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `PO_ForeignKey_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchaseorders`
--

LOCK TABLES `purchaseorders` WRITE;
/*!40000 ALTER TABLE `purchaseorders` DISABLE KEYS */;
INSERT INTO `purchaseorders` VALUES (1,'2024-10-10 10:09:03',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":100},\"2\":{\"itemID\":\"5\",\"qty\":200}}',300,0,NULL,'Cancelled'),(2,'2024-10-16 10:45:15',1,3,'{\"1\":{\"itemID\":\"2\",\"qty\":100}}',100,50,NULL,'Back Order'),(3,'2024-10-21 22:31:00',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":100},\"2\":{\"itemID\":\"5\",\"qty\":50}}',150,0,NULL,'Cancelled'),(4,'2024-10-27 23:18:11',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":20}}',20,0,NULL,'Pending'),(5,'2024-11-05 11:30:54',1,7,'{\"1\":{\"itemID\":\"2\",\"qty\":100}}',100,0,NULL,'Pending');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'2024-09-29 01:34:29',3,'{\n	\"1\":{\n		\"itemID\":\"2\",\n		\"qty\":5\n	},\n	\"2\":{\n		\"itemID\":\"3\",\n		\"qty\":3\n	}\n}',8,1900.00,228.00,0.00,2128.00,2500.00,372.00,'Cash','Sales',NULL),(2,'2024-11-05 02:37:34',3,'{\"1\":{\"itemID\":5,\"qty\":5},\"2\":{\"itemID\":7,\"qty\":5},\"3\":{\"itemID\":8,\"qty\":10},\"4\":{\"itemID\":10,\"qty\":5}}',25,751.15,90.14,0.00,841.29,1000.00,158.71,'Cash','Sales',0.00),(3,'2024-11-05 02:43:22',3,'{\"1\":{\"itemID\":\"4\",\"qty\":5},\"2\":{\"itemID\":1,\"qty\":3},\"3\":{\"itemID\":10,\"qty\":5},\"4\":{\"itemID\":7,\"qty\":4}}',17,627.38,75.29,0.00,702.67,650.00,-52.67,'Cash','Sales',0.00),(4,'2024-11-05 02:45:07',3,'{\"1\":{\"itemID\":\"2\",\"qty\":10},\"2\":{\"itemID\":\"11\",\"qty\":8},\"3\":{\"itemID\":\"8\",\"qty\":5},\"4\":{\"itemID\":\"7\",\"qty\":5}}',28,256.54,30.78,0.00,287.32,300.00,12.68,'Cash','Sales',0.00),(5,'2024-11-05 02:45:42',3,'{\"1\":{\"itemID\":\"5\",\"qty\":5}}',5,212.60,25.51,0.00,238.11,1000.00,761.89,'Cash','Sales',0.00),(6,'2024-11-05 02:47:03',3,'{\"1\":{\"itemID\":\"11\",\"qty\":3}}',3,21.84,2.62,0.00,24.46,30.00,5.54,'Cash','Sales',0.00),(7,'2024-11-05 02:47:40',3,'{\"1\":{\"itemID\":\"3\",\"qty\":20}}',20,134.00,16.08,0.00,150.08,140.00,-10.08,'Cash','Sales',0.00),(8,'2024-11-05 02:49:49',3,'{\"1\":{\"itemID\":\"1\",\"qty\":4},\"2\":{\"itemID\":\"10\",\"qty\":10},\"3\":{\"itemID\":\"7\",\"qty\":3}}',17,952.50,114.30,0.00,1066.80,1000.00,-66.80,'Cash','Sales',0.00),(9,'2024-11-05 02:50:07',3,'{\"1\":{\"itemID\":\"7\",\"qty\":3}}',3,61.08,7.33,0.00,68.41,70.00,1.59,'Cash','Sales',0.00),(10,'2024-11-05 02:51:35',3,'{\"1\":{\"itemID\":\"1\",\"qty\":3},\"2\":{\"itemID\":\"2\",\"qty\":10},\"3\":{\"itemID\":\"3\",\"qty\":10},\"4\":{\"itemID\":\"4\",\"qty\":3}}',26,302.15,36.26,0.00,338.41,350.00,11.59,'Cash','Sales',0.00);
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
INSERT INTO `suppliers` VALUES (1,'Metro Drug Inc. (MDI)','Agent MDI','(02) 8539 4342','mdi@metrodrug.com.ph','Active',NULL),(2,'Zuellig Pharma Corporation','Agent K','+63 (2) 908 2222','zpspeakup@zuelligpharma.com','Active',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Sayra','Jackson','Admin','E002_sjackson','jackson-e002','Chichi.jpg','2024-09-22 21:27:48','Active','0','on','on','on','on','on','on','on'),(3,'Lance','Tiangco','Admin','E003_ltiangco','lancetiangco26!!','dubu2.jpg','2024-09-01 23:42:57','Active','0','on','on','on','on','on','on','on'),(4,'Aileen','Castro','Admin','E004_acastro','castro-e004','owner.png','2024-10-14 14:44:48','Active','0','on','on','on','on','on','on','on'),(5,'The','Shrek','Pharmacy Assistant','E005_tshrek','test-e005','Shrek.png','2024-10-14 18:59:03','Inactive','0','off','on','off','on','on','off','off'),(6,'Cashier','Ashiera','Pharmacy Assistant','E006_cashiera','ashiera-e006','cashier.png','2024-10-29 22:13:40','Active','0','off','on','off','on','on','off','off'),(7,'kort','alv','Admin','kort','medo','profile_icon.png','2024-11-05 08:58:27','Active','1','on','on','on','on','on','on','on');
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

-- Dump completed on 2024-11-05 11:40:37
