-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: termProject
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `hotrecipe`
--

DROP TABLE IF EXISTS `hotrecipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotrecipe` (
  `hotRecipeID` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `recipeID` int(6) NOT NULL,
  `cookTemp` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `cookTime` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`hotRecipeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotrecipe`
--

LOCK TABLES `hotrecipe` WRITE;
/*!40000 ALTER TABLE `hotrecipe` DISABLE KEYS */;
INSERT INTO `hotrecipe` VALUES (1,1,'350 Degrees','30 Minutes'),(2,2,'350 Degrees','25 Minutes');
/*!40000 ALTER TABLE `hotrecipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredient` (
  `ingredientID` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `ingredientName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ingredientDescription` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ingredientID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredient`
--

LOCK TABLES `ingredient` WRITE;
/*!40000 ALTER TABLE `ingredient` DISABLE KEYS */;
INSERT INTO `ingredient` VALUES (1,'Milk','Delicious liquid!'),(2,'Eggs','Straight from the bird!'),(3,'Garlic Powder','A very versatile spice that uses garlic'),(4,'Jerkey Sticks','Beef jerky stick');
/*!40000 ALTER TABLE `ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientrecipe`
--

DROP TABLE IF EXISTS `ingredientrecipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientrecipe` (
  `recipeID` int(6) NOT NULL,
  `ingredientID` int(6) NOT NULL,
  `quantity` smallint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientrecipe`
--

LOCK TABLES `ingredientrecipe` WRITE;
/*!40000 ALTER TABLE `ingredientrecipe` DISABLE KEYS */;
INSERT INTO `ingredientrecipe` VALUES (1,1,1),(2,1,1),(3,1,1),(4,1,1),(1,2,1),(2,2,1),(3,2,1),(4,2,1),(1,3,1),(2,3,1),(3,3,1),(4,3,1),(1,4,1),(2,4,1),(3,4,1),(4,4,1);
/*!40000 ALTER TABLE `ingredientrecipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruction`
--

DROP TABLE IF EXISTS `instruction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instruction` (
  `instructionID` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `recipeID` int(6) NOT NULL,
  `stepNumber` smallint(3) NOT NULL,
  `instruction` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`instructionID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruction`
--

LOCK TABLES `instruction` WRITE;
/*!40000 ALTER TABLE `instruction` DISABLE KEYS */;
INSERT INTO `instruction` VALUES (1,1,1,'Make the enchilada hotdish'),(2,1,2,'Eat the enchilada hotdish!'),(3,2,1,'Make the Chicken enchiladas'),(4,2,2,'Eat the chicken enchiladas!'),(5,3,1,'Make the Penne Rosa'),(6,3,2,'Eat the Penne Rosa!'),(7,4,1,'Make the Crispy Waffles'),(8,4,2,'Eat the Crispy Waffles!');
/*!40000 ALTER TABLE `instruction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipe` (
  `recipeID` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `recipeName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `recipeDescription` text COLLATE utf8mb4_general_ci NOT NULL,
  `servingSize` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numServings` smallint(3) DEFAULT NULL,
  PRIMARY KEY (`recipeID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe`
--

LOCK TABLES `recipe` WRITE;
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
INSERT INTO `recipe` VALUES (1,'Enchilada Hotdish','Yummy hotdish!','1 peice',18),(2,'White Chicken Enchilada','Yummy enchiladas!','2 enchiladas',10),(3,'Penna Rosa','Lovely pasta','1 bowl',6),(4,'Crispy Waffles','My favorite recipe from my mother!','1 waffle',4);
/*!40000 ALTER TABLE `recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock` (
  `stockID` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `ingredientID` int(6) NOT NULL,
  `quantityInStock` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`stockID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES (1,1,'4 gallons'),(2,2,'2 cartons'),(3,3,'1 container'),(4,4,'1 bag');
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'termProject'
--
/*!50003 DROP PROCEDURE IF EXISTS `ingredientUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ingredientUpdate`(IN `thisIngredientName` VARCHAR(25), IN `thisIngredientDescription` VARCHAR(50), IN `thisIngredientID` INT)
    COMMENT 'Updates an ingredient''s information'
BEGIN UPDATE ingredient SET ingredientName = thisIngredientName, ingredientDescription = thisIngredientDescription WHERE ingredientID = thisIngredientID; END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `stockUpdate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `stockUpdate`(IN `thisIngredientQuantity` VARCHAR(25), IN `thisIngredientID` INT)
    COMMENT 'Updates the stock tables data'
BEGIN UPDATE stock SET quantityInStock = thisIngredientQuantity WHERE ingredientID = thisIngredientID; END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-03 13:13:04
