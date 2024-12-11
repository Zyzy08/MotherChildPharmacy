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
) ENGINE=InnoDB AUTO_INCREMENT=321 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audittrail`
--

LOCK TABLES `audittrail` WRITE;
/*!40000 ALTER TABLE `audittrail` DISABLE KEYS */;
INSERT INTO `audittrail` VALUES (1,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jacksona, Role: Admin, Account Name: E002_sjacksona','2024-10-12 09:50:51','::1','1'),(2,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jackson, Role: Admin, Account Name: E002_sjackson','2024-10-12 09:51:35','::1','1'),(3,3,'Login','User logged in successfully.','2024-10-14 05:58:03','::1','1'),(4,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jacksona, Role: Admin, Account Name: E002_sjacksona','2024-10-14 05:59:41','::1','1'),(5,3,'Logout','User logged out successfully.','2024-10-14 06:01:33','::1','1'),(6,3,'Login','User logged in successfully.','2024-10-14 06:01:52','::1','1'),(7,3,'Password Reset','Password reset successfully for account: E002_sjacksona','2024-10-14 06:16:30','::1','1'),(8,3,'Profile Update','User updated a profile with new data: Name: Sayra, Last Name: Jackson, Role: Admin, Account Name: E002_sjackson','2024-10-14 06:19:02','::1','1'),(9,3,'Password Reset','Password reset successfully for account: E002_sjackson','2024-10-14 06:19:09','::1','1'),(10,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-14 06:24:04','::1','1'),(11,3,'Add User','Added user: Aileen Castro with account name E004_acastro.','2024-10-14 06:42:56','::1','1'),(12,3,'Add User','Added user: Aileen Castro with account name E004_acastro.','2024-10-14 06:44:48','::1','1'),(13,3,'View User Details','Viewed details for account: E004_acastro','2024-10-14 06:45:14','::1','1'),(14,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-14 06:45:37','::1','1'),(15,3,'Password Reset','Password reset successfully for account: E004_acastro','2024-10-14 06:45:44','::1','1'),(16,3,'Archive User','Archived user account: E004_acastro','2024-10-14 06:46:01','::1','1'),(17,3,'Unarchive User','Unarchived user with account name: E004_acastro.','2024-10-14 10:27:07','::1','1'),(18,3,'Change Password','User successfully changed their own password.','2024-10-14 10:38:26','::1','1'),(19,3,'Change Password','User failed to change their own password by entering the old password as the new password.','2024-10-14 10:44:53','::1',''),(20,3,'Change Password','User failed to change their own password by entering the old password as the new password.','2024-10-14 10:45:17','::1',''),(21,3,'Profile Update','User successfully updated their own profile (Picture: , Name: Lancelot Tiangco).','2024-10-14 10:51:32','::1','1'),(22,3,'Profile Update','User successfully updated their own profile (Name: Lance Tiangco).','2024-10-14 10:54:01','::1','1'),(23,3,'Add User','Added user: c test with account name E005_ctest.','2024-10-14 10:59:03','::1','1'),(24,3,'Logout','User logged out successfully.','2024-10-14 10:59:21','::1','1'),(25,5,'Login','User logged in successfully.','2024-10-14 10:59:31','::1','1'),(26,5,'Logout','User logged out successfully.','2024-10-14 10:59:49','::1','1'),(27,3,'Login','User logged in successfully.','2024-10-14 10:59:57','::1','1'),(28,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-01).','2024-10-14 11:19:13','::1','1'),(29,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-01).','2024-10-14 11:19:31','::1','1'),(30,3,'Logout','User logged out successfully.','2024-10-14 12:02:17','::1','1'),(31,3,'Login','User logged in successfully.','2024-10-15 01:41:19','::1','1'),(32,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-15 03:42:25','::1','1'),(33,3,'Logout','User logged out successfully.','2024-10-15 03:57:03','::1','1'),(34,3,'Login','User logged in successfully.','2024-10-15 03:59:42','::1','1'),(35,3,'Logout','User logged out successfully.','2024-10-15 04:00:13','::1','1'),(36,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-16 02:44:57','::1','1'),(37,3,'Create Order','Created purchase order (OrderID: 2).','2024-10-16 02:45:15','::1','1'),(38,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-02).','2024-10-16 02:45:18','::1','1'),(39,3,'View Order','User viewed a purchase order\'s details (OrderID: PO-02).','2024-10-16 02:45:21','::1','1'),(40,3,'Logout','User logged out successfully.','2024-10-16 03:23:09','::1','1'),(41,3,'Auto Backup Failed','Automatic database backup failed.','2024-10-16 03:23:09','::1','1'),(42,3,'Login','User logged in successfully.','2024-10-16 03:26:54','::1','1'),(43,3,'Logout','User logged out successfully.','2024-10-16 03:27:16','::1','1'),(44,3,'Auto Backup Failed','Automatic database backup failed.','2024-10-16 03:27:16','::1','1'),(45,3,'Login','User logged in successfully.','2024-10-16 03:30:46','::1','1'),(46,3,'Logout','User logged out successfully.','2024-10-16 03:30:48','::1','1'),(47,3,'Backup Failed','Database backup failed.','2024-10-16 03:30:48','::1','1'),(48,3,'Login','User logged in successfully.','2024-10-16 03:34:52','::1','1'),(49,3,'Logout','User logged out successfully.','2024-10-16 03:34:58','::1','1'),(50,3,'Backup','Database backup created successfully.','2024-10-16 03:34:58','::1','1'),(51,3,'Login','User logged in successfully.','2024-10-16 03:39:27','::1','1'),(52,3,'Logout','User logged out successfully.','2024-10-16 03:40:00','::1','1'),(53,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 03:40:00','::1','1'),(54,3,'Login','User logged in successfully.','2024-10-16 03:42:06','::1','1'),(55,3,'Logout','User logged out successfully.','2024-10-16 03:44:11','::1','1'),(56,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 03:44:12','::1','1'),(57,3,'Login','User failed to login (Incorrect password).','2024-10-16 03:50:35','::1',''),(58,3,'Login','User logged in successfully.','2024-10-16 03:52:39','::1','1'),(59,3,'Logout','User logged out successfully.','2024-10-16 04:20:03','::1','1'),(60,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-16 04:20:03','::1','1'),(61,3,'Login','User logged in successfully.','2024-10-20 08:10:31','::1','1'),(62,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-20 08:37:45','::1','1'),(63,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-20 11:46:58','::1','1'),(64,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 11:43:05','::1','1'),(65,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-21 11:44:12','::1','1'),(66,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 12:30:40','::1','1'),(67,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-21 12:50:05','::1','1'),(68,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-21 14:30:21','::1','1'),(69,3,'Create Order','Created purchase order (OrderID: 3).','2024-10-21 14:31:00','::1','1'),(70,3,'Logout','User logged out successfully.','2024-10-21 14:48:41','::1','1'),(71,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-21 14:48:42','::1','1'),(72,3,'Login','User logged in successfully.','2024-10-27 08:13:41','::1','1'),(73,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 08:17:52','::1','1'),(74,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-27 09:26:03','::1','1'),(75,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 09:28:11','::1','1'),(76,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-27 10:52:37','::1','1'),(77,3,'Received Delivery','User successfully received delivery (Delivery ID: DE-01).','2024-10-27 10:52:56','::1','1'),(78,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 12:46:01','::1','1'),(79,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 12:48:03','::1','1'),(80,3,'View User Details','Viewed details for account: E002_sjackson','2024-10-27 13:00:31','::1','1'),(81,3,'View User Details','Viewed details for account: E004_acastro','2024-10-27 13:02:14','::1','1'),(82,3,'View User Details','Viewed details for account: E004_acastro','2024-10-27 13:03:16','::1','1'),(83,3,'Logout','User logged out successfully.','2024-10-27 13:13:32','::1','1'),(84,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-27 13:13:32','::1','1'),(85,3,'Login','User logged in successfully.','2024-10-27 14:49:36','::1','1'),(86,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 14:53:25','::1','1'),(87,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 14:53:38','::1','1'),(88,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 14:53:51','::1','1'),(89,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 15:14:32','::1','1'),(90,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-27 15:15:10','::1','1'),(91,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 15:16:29','::1','1'),(92,3,'Create Order','Created purchase order (OrderID: 4).','2024-10-27 15:18:11','::1','1'),(93,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-27 16:08:51','::1','1'),(94,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-27 16:10:12','::1','1'),(95,3,'Logout','User logged out successfully.','2024-10-27 16:13:57','::1','1'),(96,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-27 16:13:57','::1','1'),(97,3,'Login','User logged in successfully.','2024-10-29 14:09:42','::1','1'),(98,3,'View User Details','Viewed details for account: E005_ctest','2024-10-29 14:09:58','::1','1'),(99,3,'Archive User','Archived user account: E005_ctest','2024-10-29 14:11:03','::1','1'),(100,3,'Unarchive User','Unarchived user with account name: E005_ctest.','2024-10-29 14:11:10','::1','1'),(101,3,'View User Details','Viewed details for account: E005_ctest','2024-10-29 14:11:13','::1','1'),(102,3,'Profile Update','User updated a profile with new data: Name: The, Last Name: Shrek, Role: Pharmacy Assistant, Account Name: E005_tshrek','2024-10-29 14:11:21','::1','1'),(103,3,'Archive User','Archived user account: E005_tshrek','2024-10-29 14:11:25','::1','1'),(104,3,'Add User','Added user: Cashier Ashiera with account name E006_cashiera.','2024-10-29 14:13:40','::1','1'),(105,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-29 14:18:30','::1','1'),(106,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-29 15:34:56','::1','1'),(107,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-10-29 16:08:59','::1','1'),(108,3,'Logout','User logged out successfully.','2024-10-29 17:11:01','::1','1'),(109,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-29 17:11:01','::1','1'),(110,6,'Login','User logged in successfully.','2024-10-29 17:12:49','::1','1'),(111,6,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:13:25','::1','1'),(112,6,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:19:02','::1','1'),(113,6,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:21:59','::1','1'),(114,6,'Logout','User logged out successfully.','2024-10-29 17:22:06','::1','1'),(115,6,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-29 17:22:06','::1','1'),(116,3,'Login','User logged in successfully.','2024-10-29 17:22:16','::1','1'),(117,3,'View Invoice','User viewed a transaction\'s details (Invoice ID: IN-01).','2024-10-29 17:23:10','::1','1'),(118,3,'Logout','User logged out successfully.','2024-10-29 17:33:27','::1','1'),(119,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-29 17:33:27','::1','1'),(120,3,'Login','User logged in successfully.','2024-10-31 01:29:32','::1','1'),(121,3,'Goods Issue','User manually adjusted the stock of a product. (ItemID: 2, Quantity: 4).','2024-10-31 01:43:51','::1','1'),(122,3,'Archive Product','User archived a product. (ItemID: 11).','2024-10-31 02:59:27','::1','1'),(123,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-10-31 03:10:52','::1','1'),(124,3,'Archive Supplier','User archived a supplier. (SupplierID: 2).','2024-10-31 03:11:00','::1','1'),(125,3,'Unarchive Supplier','User unarchived a supplier. (SupplierID: 2).','2024-10-31 03:11:05','::1','1'),(126,3,'Logout','User logged out successfully.','2024-10-31 03:47:56','::1','1'),(127,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-10-31 03:47:56','::1','1'),(128,3,'Login','User logged in successfully.','2024-11-03 09:59:35','::1','1'),(129,3,'Logout','User logged out successfully.','2024-11-03 16:27:16','::1','1'),(130,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-03 16:27:16','::1','1'),(131,3,'Login','User logged in successfully.','2024-11-04 17:57:22','::1','1'),(132,3,'Logout','User logged out successfully.','2024-11-04 19:06:11','::1','1'),(133,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-04 19:06:12','::1','1'),(134,3,'Login','User logged in successfully.','2024-11-05 07:07:48','::1','1'),(135,3,'Logout','User logged out successfully.','2024-11-05 07:09:33','::1','1'),(136,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-05 07:09:33','::1','1'),(137,3,'Login','User logged in successfully.','2024-11-05 12:57:58','::1','1'),(138,3,'Logout','User logged out successfully.','2024-11-05 12:58:21','::1','1'),(139,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-05 12:58:21','::1','1'),(140,3,'Login','User logged in successfully.','2024-11-05 13:03:01','::1','1'),(141,3,'Logout','User logged out successfully.','2024-11-05 13:04:56','::1','1'),(142,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-05 13:04:57','::1','1'),(143,3,'Login','User logged in successfully.','2024-11-05 13:18:44','::1','1'),(144,3,'Create Order','Created purchase order (OrderID: 5).','2024-11-05 13:30:15','::1','1'),(145,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-05 13:45:01','::1','1'),(146,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-05 13:45:30','::1','1'),(147,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-05 13:45:37','::1','1'),(148,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-05 13:49:19','::1','1'),(149,3,'Received Delivery','User successfully received delivery (Delivery ID: DE-02).','2024-11-05 14:24:45','::1','1'),(150,3,'Archive Product','User archived a product. (ItemID: 6).','2024-11-05 14:45:54','::1','1'),(151,3,'Archive Product','User archived a product. (ItemID: 5).','2024-11-05 14:46:02','::1','1'),(152,3,'Unarchive Product','User unarchived a product. (ItemID: 5).','2024-11-05 14:46:07','::1','1'),(153,3,'Archive Product','User archived a product. (ItemID: 7).','2024-11-05 14:46:13','::1','1'),(154,3,'Archive Product','User archived a product. (ItemID: 8).','2024-11-05 14:46:19','::1','1'),(155,3,'Product Update','User updated the details of a product. (ItemID: 10).','2024-11-05 14:53:25','::1','1'),(156,3,'Product Update','User updated the details of a product. (ItemID: 10).','2024-11-05 14:53:33','::1','1'),(157,3,'Archive Product','User archived a product. (ItemID: 10).','2024-11-05 14:54:02','::1','1'),(158,3,'Add Product','User added a new product. (ItemID: 12).','2024-11-05 14:58:27','::1','1'),(159,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-05 15:20:25','::1','1'),(160,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-05 15:20:25','::1','1'),(161,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-05 15:20:32','::1','1'),(162,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-05 15:20:32','::1','1'),(163,3,'Logout','User logged out successfully.','2024-11-05 15:55:54','::1','1'),(164,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-05 15:55:55','::1','1'),(165,3,'Login','User logged in successfully.','2024-11-06 06:33:20','::1','1'),(166,3,'Create Order','Created purchase order (OrderID: 6).','2024-11-06 06:34:59','::1','1'),(167,3,'Received Delivery','User successfully received delivery (Delivery ID: DE-03).','2024-11-06 06:35:22','::1','1'),(168,3,'Create Order','Created purchase order (OrderID: 7).','2024-11-06 07:54:45','::1','1'),(169,3,'Received Delivery','User successfully received delivery (Delivery ID: DE-04).','2024-11-06 07:55:46','::1','1'),(170,3,'Logout','User logged out successfully.','2024-11-06 07:56:08','::1','1'),(171,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-06 07:56:08','::1','1'),(172,3,'Login','User logged in successfully.','2024-11-06 17:41:11','::1','1'),(173,3,'Archive Product','User archived a product. (ItemID: 12).','2024-11-06 18:53:40','::1','1'),(174,3,'Unarchive Product','User unarchived a product. (ItemID: 6).','2024-11-06 18:53:48','::1','1'),(175,3,'Unarchive Product','User unarchived a product. (ItemID: 7).','2024-11-06 18:55:43','::1','1'),(176,3,'Product Update','User updated the details of a product. (ItemID: 4).','2024-11-06 18:56:35','::1','1'),(177,3,'Product Update','User updated the details of a product. (ItemID: 5).','2024-11-06 18:59:24','::1','1'),(178,3,'Product Update','User updated the details of a product. (ItemID: 6).','2024-11-06 19:01:21','::1','1'),(179,3,'Product Update','User updated the details of a product. (ItemID: 7).','2024-11-06 19:02:30','::1','1'),(180,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-06 19:04:24','::1','1'),(181,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-06 19:42:10','::1','1'),(182,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-06 19:51:22','::1','1'),(183,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:36:35','::1','1'),(184,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:36:36','::1','1'),(185,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:36:48','::1','1'),(186,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:36:48','::1','1'),(187,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:37:02','::1','1'),(188,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:37:02','::1','1'),(189,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:37:21','::1','1'),(190,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-06 20:37:21','::1','1'),(191,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-06 21:21:01','::1','1'),(192,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-06 21:45:56','::1','1'),(193,3,'Logout','User logged out successfully.','2024-11-06 22:42:16','::1','1'),(194,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-06 22:42:16','::1','1'),(195,3,'Login','User logged in successfully.','2024-11-07 05:56:23','::1','1'),(196,3,'Logout','User logged out successfully.','2024-11-07 05:59:08','::1','1'),(197,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-07 05:59:08','::1','1'),(198,3,'Login','User failed to login (Incorrect password).','2024-11-07 13:00:33','::1',''),(199,3,'Login','User logged in successfully.','2024-11-07 13:00:40','::1','1'),(200,3,'Login','User logged in successfully.','2024-11-07 15:32:28','::1','1'),(201,3,'Archive Supplier','User archived a supplier. (SupplierID: 2).','2024-11-07 15:35:46','::1','1'),(202,3,'Unarchive Supplier','User unarchived a supplier. (SupplierID: 2).','2024-11-07 15:35:54','::1','1'),(203,3,'Archive Supplier','User archived a supplier. (SupplierID: 2).','2024-11-07 15:36:48','::1','1'),(204,3,'Unarchive Supplier','User unarchived a supplier. (SupplierID: 2).','2024-11-07 15:41:37','::1','1'),(205,3,'Archive Supplier','User archived a supplier. (SupplierID: 2).','2024-11-07 15:41:43','::1','1'),(206,3,'Unarchive Supplier','User unarchived a supplier. (SupplierID: 2).','2024-11-07 15:42:32','::1','1'),(207,3,'Archive Supplier','User archived a supplier. (SupplierID: 2).','2024-11-07 15:43:47','::1','1'),(208,3,'Unarchive Supplier','User unarchived a supplier. (SupplierID: 2).','2024-11-07 15:43:52','::1','1'),(209,3,'Archive Supplier','User archived a supplier. (SupplierID: 2).','2024-11-07 15:44:19','::1','1'),(210,3,'Unarchive Supplier','User unarchived a supplier. (SupplierID: 2).','2024-11-07 15:44:42','::1','1'),(211,3,'Unarchive Product','User unarchived a product. (ItemID: 12).','2024-11-07 15:47:11','::1','1'),(212,3,'Archive Product','User archived a product. (ItemID: 12).','2024-11-07 15:47:28','::1','1'),(213,3,'Logout','User logged out successfully.','2024-11-07 15:55:52','::1','1'),(214,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-07 15:55:52','::1','1'),(215,3,'Login','User logged in successfully.','2024-11-07 15:56:06','::1','1'),(216,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-07 16:02:47','::1','1'),(217,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-07 16:05:49','::1','1'),(218,3,'View User Details','Viewed details for account: E004_acastro','2024-11-07 16:06:10','::1','1'),(219,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-07 16:58:38','::1','1'),(220,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-07 17:19:17','::1','1'),(221,3,'Logout','User logged out successfully.','2024-11-07 17:19:48','::1','1'),(222,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-07 17:19:49','::1','1'),(223,6,'Login','User failed to login (Incorrect password).','2024-11-08 17:39:06','::1',''),(224,6,'Login','User logged in successfully.','2024-11-08 17:39:19','::1','1'),(225,6,'Logout','User logged out successfully.','2024-11-08 17:39:57','::1','1'),(226,6,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-08 17:39:57','::1','1'),(227,3,'Login','User logged in successfully.','2024-11-08 17:40:05','::1','1'),(228,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-08 18:10:53','::1','1'),(229,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-08 18:10:54','::1','1'),(230,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-08 18:10:57','::1','1'),(231,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-08 18:10:59','::1','1'),(232,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-08 18:11:02','::1','1'),(233,3,'Login','User logged in successfully.','2024-11-09 08:04:23','::1','1'),(234,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-09 09:32:39','::1','1'),(235,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-09 09:50:40','::1','1'),(236,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-09 13:04:24','::1','1'),(237,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-09 17:36:08','::1','1'),(238,3,'Update Supplier','User updated a supplier (SupplierID: 1).','2024-11-09 18:22:29','::1','1'),(239,3,'Update Supplier','User updated a supplier (SupplierID: 1).','2024-11-09 18:22:29','::1','1'),(240,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-09 18:22:58','::1','1'),(241,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-09 18:22:58','::1','1'),(242,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-09 18:32:39','::1','1'),(243,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-09 18:32:39','::1','1'),(244,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-09 18:33:02','::1','1'),(245,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-09 18:33:03','::1','1'),(246,3,'Process Sales','User successfully processed a transaction (Invoice ID: IN-06).','2024-11-09 18:45:09','::1','1'),(247,3,'View User Details','Viewed details for account: E006_cashiera','2024-11-09 18:48:58','::1','1'),(248,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-09 18:54:28','::1','1'),(249,3,'View User Details','Viewed details for account: E002_sjackson','2024-11-09 18:54:31','::1','1'),(250,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-09 19:00:13','::1','1'),(251,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-10 03:19:03','::1','1'),(252,3,'Logout','User logged out successfully.','2024-11-10 03:19:48','::1','1'),(253,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-10 10:28:58','::1','1'),(254,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-10 10:30:37','::1','1'),(255,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-10 11:08:15','::1','1'),(256,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-10 11:08:39','::1','1'),(257,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-10 12:35:41','::1','1'),(258,3,'Logout','User logged out successfully.','2024-11-10 12:39:45','::1','1'),(259,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-10 12:39:45','::1','1'),(260,3,'Login','User logged in successfully.','2024-11-10 12:39:53','::1','1'),(261,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-10 12:40:02','::1','1'),(262,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-10 13:46:52','::1','1'),(263,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-10 13:47:32','::1','1'),(264,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-10 13:51:39','::1','1'),(265,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-10 21:56:01','::1','1'),(266,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-10 21:56:30','::1','1'),(267,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-10 21:57:11','::1','1'),(268,3,'Logout','User logged out successfully.','2024-11-10 21:57:28','::1','1'),(269,3,'Automatic Backup','As the user was the last to log off, automatic database backup creation was executed successfully.','2024-11-10 21:57:28','::1','1'),(270,3,'Login','User logged in successfully.','2024-11-13 16:41:41','::1','1'),(271,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-13 16:48:45','::1','1'),(272,3,'Database Restore','Database \'motherchildpharmacy\' restored by user.','2024-11-13 19:35:06','::1','1'),(273,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-13 19:55:26','::1','1'),(274,3,'Process Sales','User successfully processed a transaction (Invoice ID: IN-07).','2024-11-13 19:55:38','::1','1'),(275,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-13 20:40:35','::1','1'),(276,3,'Product Update','User updated the details of a product. (ItemID: 2).','2024-11-13 20:41:03','::1','1'),(277,3,'Update Supplier','User updated a supplier (SupplierID: 1).','2024-11-13 20:44:56','::1','1'),(278,3,'Update Supplier','User updated a supplier (SupplierID: 1).','2024-11-13 20:44:56','::1','1'),(279,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-13 20:45:01','::1','1'),(280,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-13 20:45:01','::1','1'),(281,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-13 21:10:55','::1','1'),(282,3,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-11-13 21:56:08','::1','1'),(283,2,'Login','User logged in successfully.','2024-11-14 15:33:46','::1','1'),(284,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-08).','2024-11-14 16:48:00','::1','1'),(285,2,'Process Return','User successfully processed a return (Invoice ID: IN-08).','2024-11-14 17:13:59','::1','1'),(286,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-09).','2024-11-14 17:14:29','::1','1'),(287,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-010).','2024-11-14 17:15:45','::1','1'),(288,2,'Process Return/Exchange','User successfully processed a transaction (Invoice ID: IN-011).','2024-11-14 17:17:46','::1','1'),(289,2,'Login','User logged in successfully.','2024-11-16 14:54:48','::1','1'),(290,2,'Process Return/Exchange','User successfully processed a transaction (Invoice ID: IN-012).','2024-11-16 15:33:03','::1','1'),(291,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-013).','2024-11-16 15:35:01','::1','1'),(292,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-014).','2024-11-16 15:36:09','::1','1'),(293,2,'Process Return/Exchange','User successfully processed a transaction (Invoice ID: IN-015).','2024-11-16 15:37:42','::1','1'),(294,2,'Process Return','User successfully processed a return (Invoice ID: IN-013).','2024-11-16 15:39:29','::1','1'),(295,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-016).','2024-11-16 15:40:52','::1','1'),(296,2,'Process Return','User successfully processed a return (Invoice ID: IN-03).','2024-11-16 15:53:19','::1','1'),(297,2,'Process Return','User successfully processed a return (Invoice ID: IN-04).','2024-11-16 16:30:08','::1','1'),(298,2,'Login','User logged in successfully.','2024-11-25 15:03:42','::1','1'),(299,3,'Login','User logged in successfully.','2024-11-26 01:58:56','::1','1'),(300,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-26 02:07:45','::1','1'),(301,3,'Update Supplier','User updated a supplier (SupplierID: 2).','2024-11-26 02:07:45','::1','1'),(302,3,'Process Sales','User successfully processed a transaction (Invoice ID: IN-017).','2024-11-26 02:08:43','::1','1'),(303,3,'Create Order','Created purchase order (OrderID: 8).','2024-11-26 02:14:16','::1','1'),(304,3,'Create Order','Created purchase order (OrderID: 9).','2024-11-26 02:14:30','::1','1'),(305,3,'Received Delivery','User successfully received delivery (Delivery ID: DE-05).','2024-11-26 02:21:54','::1','1'),(306,3,'Received Delivery','User successfully received delivery (Delivery ID: DE-06).','2024-11-26 02:22:49','::1','1'),(307,3,'Process Sales','User successfully processed a transaction (Invoice ID: IN-018).','2024-11-26 02:25:26','::1','1'),(308,3,'Goods Issue','User manually adjusted the stock of a product. (ItemID: 2, Quantity: 70).','2024-11-26 02:58:53','::1','1'),(309,3,'Goods Issue','User manually adjusted the stock of a product. (ItemID: 2, Quantity: 70).','2024-11-26 02:59:32','::1','1'),(310,3,'Goods Issue','User manually adjusted the stock of a product. (ItemID: 2, Quantity: 10).','2024-11-26 03:00:47','::1','1'),(311,3,'Logout','User logged out successfully.','2024-11-26 16:11:58','::1','1'),(312,2,'Login','User logged in successfully.','2024-11-26 16:12:08','::1','1'),(313,2,'Login','User logged in successfully.','2024-11-26 16:35:50','::1','1'),(314,2,'Login','User logged in successfully.','2024-11-27 05:40:55','::1','1'),(315,2,'Login','User logged in successfully.','2024-11-27 14:46:23','::1','1'),(316,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-019).','2024-11-27 18:39:45','::1','1'),(317,2,'Login','User logged in successfully.','2024-11-29 03:31:19','::1','1'),(318,2,'Process Sales','User successfully processed a transaction (Invoice ID: IN-020).','2024-11-29 03:39:50','::1','1'),(319,2,'Login','User logged in successfully.','2024-12-11 12:05:29','::1','1'),(320,2,'Database Backup','Backup initiated for database \'motherchildpharmacy\' by user.','2024-12-11 12:05:48','::1','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries`
--

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
INSERT INTO `deliveries` VALUES (1,2,1,'2024-10-27 18:52:56',3,50,'Back Order'),(2,5,1,'2024-11-05 22:24:45',3,100,'Completed'),(3,6,1,'2024-11-06 14:35:22',3,90,'Completed'),(4,7,2,'2024-11-06 15:55:46',3,30,'Completed'),(5,9,2,'2024-11-26 10:21:54',3,80,'Back Order'),(6,8,1,'2024-11-26 10:22:49',3,80,'Back Order');
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
  UNIQUE KEY `LotNumber` (`LotNumber`),
  KEY `FK_DeliveryID` (`DeliveryID`),
  CONSTRAINT `FK_DeliveryID` FOREIGN KEY (`DeliveryID`) REFERENCES `deliveries` (`DeliveryID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_items`
--

LOCK TABLES `delivery_items` WRITE;
/*!40000 ALTER TABLE `delivery_items` DISABLE KEYS */;
INSERT INTO `delivery_items` VALUES (2,1,'1H17359','2025-03-28',50,5,0,400,'0'),(2,2,'GG','2026-11-05',100,0,5,900,'0'),(2,3,'123GG','2025-11-06',90,5,0,1000,'0'),(2,5,'1H1H1','2027-11-26',80,0,70,160,'0'),(2,6,'2G32D','2027-11-26',80,0,80,400,'0'),(3,4,'NFP11127','2027-11-11',30,5,5,210,'0');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goodsissue`
--

LOCK TABLES `goodsissue` WRITE;
/*!40000 ALTER TABLE `goodsissue` DISABLE KEYS */;
INSERT INTO `goodsissue` VALUES (1,2,4,'Add 4','2024-10-30 17:43:51'),(2,2,70,'remove 10','2024-11-25 18:58:52'),(3,2,70,'added 70','2024-11-25 18:59:32'),(4,2,10,'remove 10','2024-11-25 19:00:47');
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
  `ExcessStock` int(10) NOT NULL DEFAULT 0,
  `Markup` decimal(10,2) NOT NULL DEFAULT 0.05,
  PRIMARY KEY (`ItemID`),
  KEY `ForeignKey_SupplierID` (`SupplierID`),
  CONSTRAINT `ForeignKey_SupplierID` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (2,'Biogesic','Paracetamol','Medicine','500','Mg',146,90,106,5.25,1,0,1,'','Active','products-icon/biogesic.png','',0,0.05),(3,'Phenylephrine','Neozep Forte','Medicine','500','Mg',2,20,10,7.35,1,0,2,'','Active','products-icon/neozep.png','NeozepForte500mg',0,0.05),(4,'Ibuprofen','Advil','Medicine','200','Mg',0,0,0,9.00,1,0,1,'','Active','products-icon/Advil.png','AdvilIbuprofen200mg',0,0.05),(5,'Hyoscine Paracetamol','Buscopan Venus','Medicine','500','Mg',0,0,0,40.00,1,0,2,'','Active','products-icon/buscopanVenus.png','BuscopanVenus500Mg',0,0.05),(6,'Loperamide','Diatabs','Medicine','2','Mg',0,0,0,7.50,1,0,NULL,'','Active','products-icon/Diatabs.png','DiatabsLoperamide2mg',0,0.05),(7,'Loperamide','Imodium','Medicine','2','Mg',0,0,0,19.00,1,0,NULL,'','Active','products-icon/Imodium.png','ImodiumLoperamide2mg',0,0.05),(8,'Aluminum Hydroxide Magnesium Hydroxide Simeticone','Kremil-S','Medicine','441','Mg',0,0,0,9.70,1,0,NULL,'','Archived','products-icon/kremilS.png','KremilS30mg',0,0.05),(10,'Bisacodyl','Dulcolax','Medicine','5','Mg',0,0,0,25.70,1,0,NULL,'','Archived','products-icon/dulcolax.png','Dulcolax5mg',0,0.05),(11,'Ibuprofen','Medicol Advance','Medicine','200','Mg',0,0,0,6.75,1,0,NULL,'','Archived','products-icon/medicol.png','MedicolAdvance200mg',0,0.05),(12,'Product','Sample','Medicine','500','Mg',0,0,0,5.50,1,1,NULL,'','Archived','../resources/img/default_Icon.png','ALGN5829921',0,0.05);
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_inventory_update
AFTER UPDATE ON inventory
FOR EACH ROW
BEGIN
    DECLARE discrepancy INT;
    -- Calculate the discrepancy
    SET discrepancy = NEW.InStock - OLD.InStock;
    
    -- If there is a discrepancy, log it
    IF discrepancy != 0 THEN
        INSERT INTO StockAudit (ItemID, RecordedStock, PhysicalStock, Discrepancy, Remarks)
        VALUES (NEW.ItemID, OLD.InStock, NEW.InStock, discrepancy, 'Discrepancy logged after inventory update');
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `product_suppliers`
--

DROP TABLE IF EXISTS `product_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_suppliers` (
  `ItemID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  PRIMARY KEY (`ItemID`,`SupplierID`),
  KEY `SupplierID` (`SupplierID`),
  CONSTRAINT `product_suppliers_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `inventory` (`ItemID`) ON DELETE CASCADE,
  CONSTRAINT `product_suppliers_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `suppliers` (`SupplierID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_suppliers`
--

LOCK TABLES `product_suppliers` WRITE;
/*!40000 ALTER TABLE `product_suppliers` DISABLE KEYS */;
INSERT INTO `product_suppliers` VALUES (2,1),(2,2),(3,1),(4,2),(5,2);
/*!40000 ALTER TABLE `product_suppliers` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchaseorders`
--

LOCK TABLES `purchaseorders` WRITE;
/*!40000 ALTER TABLE `purchaseorders` DISABLE KEYS */;
INSERT INTO `purchaseorders` VALUES (1,'2024-10-10 10:09:03',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":100},\"2\":{\"itemID\":\"5\",\"qty\":200}}',300,0,NULL,'Cancelled'),(2,'2024-10-16 10:45:15',1,3,'{\"1\":{\"itemID\":\"2\",\"qty\":100}}',100,50,NULL,'Back Order'),(3,'2024-10-21 22:31:00',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":100},\"2\":{\"itemID\":\"5\",\"qty\":50}}',150,0,NULL,'Cancelled'),(4,'2024-10-27 23:18:11',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":20}}',20,0,NULL,'Pending'),(5,'2024-11-05 21:30:15',1,3,'{\"1\":{\"itemID\":\"2\",\"qty\":100}}',100,100,NULL,'Received'),(6,'2024-11-06 14:34:59',1,3,'{\"1\":{\"itemID\":\"2\",\"qty\":90}}',90,90,NULL,'Received'),(7,'2024-11-06 15:54:45',2,3,'{\"1\":{\"itemID\":\"3\",\"qty\":30}}',30,30,NULL,'Received'),(8,'2024-11-26 10:14:16',1,3,'{\"1\":{\"itemID\":\"2\",\"qty\":100}}',100,80,NULL,'Back Order'),(9,'2024-11-26 10:14:30',2,3,'{\"1\":{\"itemID\":\"2\",\"qty\":100}}',100,80,NULL,'Back Order');
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
  `vatable_sales` decimal(10,2) NOT NULL,
  `vat_exempt_sales` decimal(10,2) NOT NULL,
  `Discount` decimal(10,2) DEFAULT 0.00,
  `NetAmount` decimal(10,2) GENERATED ALWAYS AS (`Subtotal` - `Discount` - `RefundAmount`) STORED,
  `AmountPaid` decimal(10,2) DEFAULT 0.00,
  `AmountChange` decimal(10,2) GENERATED ALWAYS AS (`AmountPaid` - `NetAmount`) STORED,
  `PaymentMethod` enum('Cash','GCash') NOT NULL,
  `Status` enum('Sales','Returned','Return/Exchange','ReturnedForExchange') NOT NULL,
  `RefundAmount` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`InvoiceID`),
  KEY `ForeignKey_AccountID` (`AccountID`),
  CONSTRAINT `ForeignKey_AccountID` FOREIGN KEY (`AccountID`) REFERENCES `users` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'2024-09-29 01:34:29',3,'{\r\n	\"1\":{\r\n		\"itemID\":\"2\",\r\n		\"qty\":5,\r\n		\"price\":\"9.00\"\r\n	},\r\n	\"2\":{\r\n		\"itemID\":\"3\",\r\n		\"qty\":3,\r\n		\"price\":\"7.35\"\r\n	}\r\n}',8,67.05,7.18,0.00,0.00,0.00,67.05,70.00,2.95,'Cash','Sales',0.00),(2,'2024-10-05 23:06:36',3,'{\"1\":{\"itemID\":\"2\",\"qty\":9,\"price\":\"9.45\"}}\r\n',9,85.05,9.11,0.00,0.00,0.00,85.05,100.00,14.95,'Cash','Sales',0.00),(3,'2024-11-09 01:49:59',3,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"9.00\"}}\r\n',1,9.00,1.08,0.00,0.00,0.00,9.00,11.00,2.00,'Cash','Returned',0.00),(4,'2024-11-09 17:28:12',3,'{\"1\":{\"itemID\":\"3\",\"qty\":1,\"price\":\"7.35\"}}\r\n',1,7.35,0.88,0.00,0.00,0.00,7.35,8.00,0.65,'Cash','Returned',0.00),(5,'2024-11-09 20:12:43',3,'{\"1\":{\"itemID\":\"2\",\"qty\":2,\"price\":\"9.00\"}, \"2\":{\"itemID\":\"3\",\"qty\":1,\"price\":\"7.35\"}}\r\n',3,25.35,2.72,0.00,0.00,7.24,18.11,19.00,0.89,'Cash','ReturnedForExchange',0.00),(6,'2024-11-10 02:45:09',3,'{\"1\":{\"itemID\":\"3\",\"qty\":25,\"price\":\"7.35\"}}',25,183.75,19.69,0.00,0.00,0.00,183.75,184.00,0.25,'Cash','Sales',0.00),(7,'2024-11-14 03:55:38',3,'{\"1\":{\"itemID\":\"2\",\"qty\":5,\"price\":\"75.00\"}}',5,375.00,40.18,334.82,0.00,0.00,375.00,400.00,25.00,'Cash','Sales',0.00),(8,'2024-11-15 00:48:00',2,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"9.45\"}}',1,9.45,1.01,8.44,0.00,0.00,9.45,10.00,0.55,'Cash','Returned',0.00),(9,'2024-11-15 01:14:29',2,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"9.45\"}}',1,9.45,1.01,8.44,0.00,0.00,9.45,11.00,1.55,'Cash','ReturnedForExchange',0.00),(10,'2024-11-15 01:15:45',2,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"9.45\"},\"2\":{\"itemID\":\"3\",\"qty\":1,\"price\":\"7.35\"}}',2,16.80,1.80,15.00,0.00,0.00,16.80,20.00,3.20,'Cash','Sales',0.00),(11,'2024-11-15 01:17:46',2,'{\"1\":{\"itemID\":\"3\",\"qty\":2}}',2,14.70,1.58,0.00,0.00,0.00,5.25,6.00,0.75,'Cash','Return/Exchange',9.45),(12,'2024-11-16 23:33:03',2,'{\"1\":{\"itemID\":\"2\",\"qty\":4}}',4,37.80,4.05,0.00,0.00,0.00,19.69,20.00,0.31,'Cash','Return/Exchange',18.11),(13,'2024-11-16 23:35:01',2,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"9.45\"}}',1,9.45,0.00,0.00,6.75,2.70,6.75,10.00,3.25,'Cash','Returned',0.00),(14,'2024-11-16 23:36:09',2,'{\"1\":{\"itemID\":\"3\",\"qty\":1,\"price\":\"7.35\"}}',1,7.35,0.79,6.56,0.00,0.00,7.35,8.00,0.65,'Cash','ReturnedForExchange',0.00),(15,'2024-11-16 23:37:42',2,'{\"1\":{\"itemID\":\"3\",\"qty\":2}}',2,14.70,1.58,0.00,0.00,0.00,7.35,8.00,0.65,'Cash','Return/Exchange',7.35),(16,'2024-11-16 23:40:52',2,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"9.45\"}}',1,9.45,1.01,8.44,0.00,0.00,9.45,10.00,0.55,'Cash','Sales',0.00),(17,'2024-11-26 10:08:43',3,'{\"1\":{\"itemID\":\"2\",\"qty\":229,\"price\":\"9.45\"}}',229,2164.05,231.86,1932.19,0.00,0.00,2164.05,2200.00,35.95,'Cash','Sales',0.00),(18,'2024-11-26 10:25:26',3,'{\"1\":{\"itemID\":\"2\",\"qty\":2,\"price\":\"5.25\"}}',2,10.50,1.13,9.37,0.00,0.00,10.50,11.00,0.50,'Cash','Sales',0.00),(19,'2024-11-28 02:39:45',2,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"5.25\"}}',1,5.25,0.56,4.69,0.00,0.00,5.25,6.00,0.75,'Cash','Sales',0.00),(20,'2024-11-29 11:39:50',2,'{\"1\":{\"itemID\":\"2\",\"qty\":1,\"price\":\"5.25\"}}',1,5.25,0.56,4.69,0.00,0.00,5.25,6.00,0.75,'Cash','Sales',0.00);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seniorlog`
--

DROP TABLE IF EXISTS `seniorlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seniorlog` (
  `seniorID` varchar(999) NOT NULL,
  `idType` varchar(999) NOT NULL,
  `fullName` varchar(999) NOT NULL,
  `InvoiceID` int(11) NOT NULL,
  KEY `AT_ForeignKey_InvoiceID` (`InvoiceID`),
  CONSTRAINT `AT_ForeignKey_InvoiceID` FOREIGN KEY (`InvoiceID`) REFERENCES `sales` (`InvoiceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seniorlog`
--

LOCK TABLES `seniorlog` WRITE;
/*!40000 ALTER TABLE `seniorlog` DISABLE KEYS */;
INSERT INTO `seniorlog` VALUES ('12345','senior','asdafsfdf',13);
/*!40000 ALTER TABLE `seniorlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stockaudit`
--

DROP TABLE IF EXISTS `stockaudit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stockaudit` (
  `AuditID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemID` int(11) NOT NULL,
  `RecordedStock` int(11) NOT NULL,
  `PhysicalStock` int(11) NOT NULL,
  `Discrepancy` int(11) NOT NULL,
  `AuditDate` datetime DEFAULT current_timestamp(),
  `Auditor` varchar(255) DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  PRIMARY KEY (`AuditID`),
  KEY `ItemID` (`ItemID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stockaudit`
--

LOCK TABLES `stockaudit` WRITE;
/*!40000 ALTER TABLE `stockaudit` DISABLE KEYS */;
INSERT INTO `stockaudit` VALUES (2,101,50,45,-5,'2024-11-28 20:08:14','John Doe','Stock audit identified missing items'),(3,2,147,146,-1,'2024-11-29 11:39:50',NULL,'Discrepancy logged after inventory update');
/*!40000 ALTER TABLE `stockaudit` ENABLE KEYS */;
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
  `Email` varchar(255) NOT NULL DEFAULT '''N/A''',
  `Status` enum('Active','Inactive','Archived') DEFAULT 'Active',
  `Notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`SupplierID`),
  UNIQUE KEY `SupplierName` (`SupplierName`),
  UNIQUE KEY `Phone` (`Phone`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Metro Drug Inc. (MDI)','Agent MDI','09171239183','mdi@metrodrug.com.ph','Active',NULL),(2,'Zuellig Pharma Corporation','Agent K','09221262941','zpspeakup@zuelligpharma.com','Active',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Sayra','Jackson','Admin','E002_sjackson','jackson-e002','Chichi.jpg','2024-09-22 21:27:48','Active','1','on','on','on','on','on','on','on'),(3,'Lance','Tiangco','Admin','E003_ltiangco','lancetiangco26!!','dubu2.jpg','2024-09-01 23:42:57','Active','0','on','on','on','on','on','on','on'),(4,'Aileen','Castro','Admin','E004_acastro','castro-e004','owner.png','2024-10-14 14:44:48','Active','0','on','on','on','on','on','on','on'),(5,'The','Shrek','Pharmacy Assistant','E005_tshrek','test-e005','Shrek.png','2024-10-14 18:59:03','Inactive','0','off','on','off','on','on','off','off'),(6,'Cashier','Ashiera','Pharmacy Assistant','E006_cashiera','ashiera-e006','cashier.png','2024-10-29 22:13:40','Active','0','off','on','off','on','on','off','off');
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

-- Dump completed on 2024-12-11 20:05:49
