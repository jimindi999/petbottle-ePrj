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
  `pro_doc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_ibfk_1_idx` (`cat_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (7,5,'test',6.66,152,'abcdef','http://petbottle.com/resources/products/61ZwYE3dgrL._SL1001_.jpg',''),(11,4,'test 4',123456,100,'test','http://petbottle.com/resources/products/1990081_contigo_cortland_24oz_monaco_34_1_1561826235.png',''),(12,5,'test 1',1.5,150,'test bottle','http://petbottle.com/resources/products/249955-20123-keitaro-urashima_1561797659.jpg',''),(18,5,'new',194,56,'abc','http://petbottle.com/resources/products/2f28e5a0-fd3b-4d9a-aeff-1906d9cf1ac8_200x200_1561800006.png',NULL),(19,5,'test new',50,150,'abcdef','http://petbottle.com/resources/products/Free_Sample_By_Wix_1561801134.jpeg','http://petbottle.com/resources/doc/PETBot_1561801134.doc'),(20,5,'new bottle',50.5,500,'abc','http://petbottle.com/resources/products/81C84qUrqIL._SL1500__1561804156.jpg','http://petbottle.com/resources/doc/musicworld_1561804156.doc'),(26,9,'Advent Natural 3pk Baby Bottle 9oz',150,175,'Baby bottle 9oz','http://petbottle.com/resources/products/GUEST_867a07aa-aa1f-469b-972a-b95e5b8a0ecc_1561816335.jpeg','http://petbottle.com/resources/doc/Advent Natural 3pk Baby Bottle 9oz_1561816335.docx'),(27,9,'MAM Baby Bottles for Breastfed Babies, MAM Baby Bottles Anti Colic, White, 9 Ounces, 2-Count',198,165,'MAM Baby Bottles for Breastfed Babies, MAM Baby Bottles Anti Colic, White, 9 Ounces, 2-Count','http://petbottle.com/resources/products/71+TeZBBDiL._SL1500__1561816415.jpg','http://petbottle.com/resources/doc/MAM Baby Bottles for Breastfed Babies, MAM Baby Bottles Anti Colic, White, 9 Ounces, 2-Count_1561816415.docx'),(28,11,'Amber Color PET Bottle',49.99,95,'Amber Color PET Bottle','http://petbottle.com/resources/products/15ml-amber-bottle_1500x_1561822441.png','http://petbottle.com/resources/doc/Amber Color PET Bottle_1561822441.docx'),(29,7,'new test product',50.65,15,'test','http://petbottle.com/resources/products/1_1561824205.jpg','http://petbottle.com/resources/doc/PETBot_1561824205.doc'),(30,8,'Petmate Plastic Mason Jar Pet Food Storage',99.99,154,'Petmate Plastic Mason Jar Pet Food Storage','http://petbottle.com/resources/products/2312374-left-1_1561826788.jpeg','http://petbottle.com/resources/doc/Petmate Plastic Mason Jar Pet Food Storage_1561826554.docx');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'kurokeita','kuro.keita94@gmail.com','$2y$10$Fkju/aHjWmUFha6lXGg/puuVx9D3Uy5aelYFIJ2Szz7QtMXlg7I46','Kuro','Keita','1994-09-17','Male','CEO','Admin'),(2,'test1','test@gmail.com','$2y$10$3QA2zYcT8yvnxLWbTagr2u9uQaCmKVTOFhZNJ5dznBS9emr0efIqG','Mr','Test','2000-08-12','Female','Marketing','Normal'),(3,'mrbean','bean@gmail.com','$2y$10$IbZzELEqFSPmw8eNM3T9duYl1IA735rmZc5TNCfX6NpG9JqIXp.oa','Mr','Bean','1990-09-15','Male','Inventory','Normal'),(4,'trangdinh','trangdinh@gmail.com','$2y$10$vvl9sUFnCNuYs8Y1evKe5Ot1gzYOq.K6Q8dABmY9f4VxZPlp6f5VW','Trang','Dinh','1994-04-29','Female','Manager','Moderator'),(7,'samcarter','samcarter@gmail.com','$2y$10$KuTWmXab/wGkj2Q8pnfml.jKK.tAd/aVTy/uHDmfvAQ0/MudxN9mm','Samantha','Carter','1987-01-10','Female','Marketing','Normal'),(8,'manager','manager@gmail.com','$2y$10$k.Q.sll6PasYN.WvyoPs1er93thKUHDPYnpILIY8UKNedfJ1LRgku','Mr','Manager','1996-10-10','Male','Marketing','Moderator'),(11,'administrator','admin@gmail.com','$2y$10$WGPlwF7lD8LDLpWyWNwOZeE1/9.Y5IxOiQNBzLG.QneTwGlBk7PAG','Mr','Admin','1999-09-19','Male','Manager','Admin'),(15,'teddybear','teddy@gmail.com','$2y$10$OoxKqXP/GU3qrB49E6veuuVedxx/lRPAIZm8Ja6KfbV0Ft2HnzNp6','Teddy','Bear','1999-01-01','Male','Inventory','Normal'),(18,'bot_male','bot_male@gmail.com','$2y$10$pVTa6oJA7KaBo84fcRjwWOZKbe66t.J09SS56MaKp8Zv5Tl2bdpae','Mr','Bot','1998-10-10','Male','Inventory','Normal'),(19,'tester','tester@gmail.com','$2y$10$ZNrTIS6HhtYG1ERdyIb7XelFmuF8j.YiBEqY5bvl70T22Obg505N6','Mr','Tester','1992-01-01','Male','Inventory','Normal'),(20,'new_admin','new_admin@gmail.com','$2y$10$p4FCQYOCUY.neXQvFp/JWuUQl2yuuDM2MDI8V0qY4KPRd.CoTDHdq','New','Admin','1999-01-01','Female','Manager','Moderator'),(21,'bot_female','bot_female@gmail.com','$2y$10$AGzEnjfoWPOFkM.SljFRruoV6FdtyrMjn0F0ckP9pln3BzF7PoZc.','Ms','Bot','1995-01-01','Female','Marketing','Normal'),(22,'minhlnh','minhlnh@gmail.com','$2y$10$.EnsbwJPqy3pyZ5AKfVsRurJnG4iNaoHuNlNp0T8gebgCNPzS3F2y','Minh','Le Nguyen Hoang','1994-09-17','Male','Manager','Moderator'),(23,'new_user','new_user@gmail.com','$2y$10$S9oI.3z5e/MGAb92pKBvI.dXaRtIvhaeAwAYznSKuG4xE2aJEuEz.','New','User','1998-01-01','Male','Inventory','Normal'),(24,'new_user_test','new_user_test@gmail.com','$2y$10$nHRTP3S3boslVN5YZH1Pp.ANPNw6drbqCpBTrsvLUsIxh5xLYQOua','New','User','1998-01-01','Male','Inventory','Normal');
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

-- Dump completed on 2019-06-30  9:38:30