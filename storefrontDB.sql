-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: storefront
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `entity_cart`
--

DROP TABLE IF EXISTS `entity_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(128) NOT NULL,
  `item_id` varchar(128) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_cart`
--

LOCK TABLES `entity_cart` WRITE;
/*!40000 ALTER TABLE `entity_cart` DISABLE KEYS */;
INSERT INTO `entity_cart` VALUES (40,'2','1',5),(42,'2','2',3),(43,'2','2',3),(55,'1','1',5);
/*!40000 ALTER TABLE `entity_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_item`
--

DROP TABLE IF EXISTS `entity_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_item`
--

LOCK TABLES `entity_item` WRITE;
/*!40000 ALTER TABLE `entity_item` DISABLE KEYS */;
INSERT INTO `entity_item` VALUES (1,'Apple',3,42),(2,'Orange',4,100),(3,'Test',30,21);
/*!40000 ALTER TABLE `entity_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_users`
--

DROP TABLE IF EXISTS `entity_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `usersname` varchar(128) NOT NULL,
  `userspwd` varchar(128) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `adminStat` int(11) NOT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_users`
--

LOCK TABLES `entity_users` WRITE;
/*!40000 ALTER TABLE `entity_users` DISABLE KEYS */;
INSERT INTO `entity_users` VALUES (1,'kimo','123',0,0),(2,'paul','123',0,0),(3,'admin','admin',0,1);
/*!40000 ALTER TABLE `entity_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-11 13:33:20
