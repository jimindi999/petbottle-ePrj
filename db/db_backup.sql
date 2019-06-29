-- MySQL dump 10.13  Distrib 8.0.16, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: petbottle
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) DEFAULT NULL,
  `cat_img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (4,'Water Bottle','http://petbottle.com/resources/cat/water_bottle.jpg'),(5,'Decoration Bottle','http://petbottle.com/resources/cat/decoration_bottle.jpg'),(6,'Water Jar','http://petbottle.com/resources/cat/water-jar.jpg'),(7,'Plant Jar','http://petbottle.com/resources/cat/plant-jar.jpg'),(8,'Food and Spice Jar','http://petbottle.com/resources/cat/food-spice-jar.jpg'),(9,'Baby Bottle','http://petbottle.com/resources/cat/baby-bottle.jpg'),(10,'Cosmetic Jar','http://petbottle.com/resources/cat/cosmetic-jar.jpeg'),(11,'Essential Oil Bottle','http://petbottle.com/resources/cat/essential-oil-bottle.jpg');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `pro_name` varchar(255) DEFAULT NULL,
  `pro_price` float DEFAULT NULL,
  `pro_quantity` int(11) DEFAULT NULL,
  `pro_desc` longtext,
  `pro_img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_ibfk_1_idx` (`cat_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (7,5,'test',6.66,NULL,'abcdef','http://petbottle.com/resources/products/61ZwYE3dgrL._SL1001_.jpg'),(8,5,'abc',142.35,100000,'abcdef','http://petbottle.com/resources/products/download (1)_1561710590.jpeg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `admin_level` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'kurokeita','kuro.keita94@gmail.com','$2y$10$QZJwa.0hJUOszzf8sX4Byu57cpQMFayISDB4fzVIhdzkppWtjAzri','Kuro','Keita','1994-09-17','Male','CEO','Admin'),(2,'test1','test@gmail.com','$2y$10$BCQdMN6nGuaCsma.40f/VuPIsq.ZF15534RbdXRMyb1J1Ni0E0NbS','Mr','Test','2000-08-12','Female','Marketing','Normal'),(3,'mrbean','bean@gmail.com','$2y$10$IbZzELEqFSPmw8eNM3T9duYl1IA735rmZc5TNCfX6NpG9JqIXp.oa','Mr','Bean','1990-09-15','Male','Inventory','Normal'),(4,'trangdinh','trangdinh@gmail.com','$2y$10$vvl9sUFnCNuYs8Y1evKe5Ot1gzYOq.K6Q8dABmY9f4VxZPlp6f5VW','Trang','Dinh','1994-04-29','Female','Manager','Moderator'),(7,'samcarter','samcarter@gmail.com','$2y$10$KuTWmXab/wGkj2Q8pnfml.jKK.tAd/aVTy/uHDmfvAQ0/MudxN9mm','Samantha','Carter','1987-01-10','Female','Marketing','Normal'),(8,'manager','manager@gmail.com','$2y$10$k.Q.sll6PasYN.WvyoPs1er93thKUHDPYnpILIY8UKNedfJ1LRgku','Mr','Manager','1996-10-10','Male','Marketing','Moderator'),(9,'minhlnh','minhlnh@gmail.com','$2y$10$8bRJpXs9HDDeVHiYWI7pze35AmWtg3c9DZyUEk4bF8/odnjHz9FZ.','Minh','Le Nguyen Hoang','1994-09-17','Male','Manager','Moderator'),(11,'administrator','admin@gmail.com','$2y$10$WGPlwF7lD8LDLpWyWNwOZeE1/9.Y5IxOiQNBzLG.QneTwGlBk7PAG','Mr','Admin','1999-09-19','Male','Manager','Moderator'),(12,'bot_female','bot_female@gmail.com','$2y$10$Ud.BMP7Sa16S/fJK6Qv95uOQ2knI0VifGFO0J48o0q1pmbfTszATW','Ms','Bot','2001-01-01','Female','Inventory','Normal'),(13,'bot_male','bot_male@gmail.com','$2y$10$TnK.agBpTvx9Wa5PD/DDeO68eTtuJzkP7j96xoIiI8/6NfKbigOku','Mr','Bot','2000-01-01','Male','Inventory','Normal'),(14,'teddybear','teddy@gmail.com','$2y$10$v8AVIrBkXk7R/tK0sjO2v.TYjfZsBbfDVkf22iAHm4gggTaBfEHMy','Teddy','Bear','2000-01-01','Male','Inventory','Normal');
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

-- Dump completed on 2019-06-28 16:44:05
