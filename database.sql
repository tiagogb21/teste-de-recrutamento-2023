CREATE DATABASE  IF NOT EXISTS `recrutamento` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `recrutamento`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: recrutamento
-- ------------------------------------------------------
-- Server version	8.0.21

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
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank` (
  `bank_id` int NOT NULL AUTO_INCREMENT,
  `long_name` text,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank`
--

LOCK TABLES `bank` WRITE;
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
INSERT INTO `bank` VALUES (1,'Banco do Brasil','Banco do Brasil'),(2,'Santander','C6'),(3,'Itaú','Itaú'),(4,'Caixa','Caixa'),(5,'Bradesco','Bradesco'),(6,'NuBank','NuBank'),(7,'Inter','Inter'),(8,'C6','C6'),(9,'Itaú','Itaú'),(10,'Caixa','Caixa'),(11,'Bradesco','Bradesco'),(12,'NuBank','NuBank'),(13,'Inter','Inter'),(14,'C6','C6');
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_account`
--

DROP TABLE IF EXISTS `bank_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_account` (
  `bank_account_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `bank_id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`bank_account_id`),
  KEY `customer_id` (`customer_id`),
  KEY `bank_id` (`bank_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_account`
--

LOCK TABLES `bank_account` WRITE;
/*!40000 ALTER TABLE `bank_account` DISABLE KEYS */;
INSERT INTO `bank_account` VALUES (1,1,1,'BANCO SOL 002'),(2,1,2,'BANCO BAI 001');
/*!40000 ALTER TABLE `bank_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `password` text,
  `telephone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'jose','ndonge','josedomingos919@gmail.com','81e13e3ebae95b28a5ba2f3698d0a73a','944666640'),(2,'decolip','decolip','decolip@gmail.com','81e13e3ebae95b28a5ba2f3698d0a73a','999666640');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `history_type_id` int NOT NULL,
  `note` text,
  `status` int DEFAULT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `history_type_id` (`history_type_id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,1,1,1,'Produto Vendido',1,'2020-02-20 10:10:10'),(2,5,1,2,'Venda Cancelada',1,'2020-03-12 10:10:10'),(3,6,1,3,'Problema com o produto',1,'2020-01-23 10:10:10'),(4,7,1,4,'Transferência Bancária',1,'2020-02-02 10:10:10'),(5,8,1,7,'Ajuste Valor descontado sem querer',1,'2020-03-18 10:10:10');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_type`
--

DROP TABLE IF EXISTS `history_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_type` (
  `history_type_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `color` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`history_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_type`
--

LOCK TABLES `history_type` WRITE;
/*!40000 ALTER TABLE `history_type` DISABLE KEYS */;
INSERT INTO `history_type` VALUES (1,'PRODUCT_SOLD','Valor Líquido de Venda','#b9e8b9'),(2,'PRODUCT_SOLD_CANCELED','Venda Cancelada','#e8b9b9'),(3,'PRODUCT_SOLD_REFUNDED','Venda Reembolsada','#e8b9b9'),(4,'TRANSFER_TO_BANK_ACCOUNT_REQUEST','Solicitação de transferência para conta bancária','#e8e4b9'),(5,'TRANSFER_TO_BANK_ACCOUNT_CANCELED','Devolução de transferência para conta bancária','#e8b9b9'),(6,'TRANSFER_TO_BANK_ACCOUNT_COMPLETED','Transferência para conta bancária','#b9e8b9'),(7,'BALANCE_ADJUSTMENT','Ajuste de Saldo','#8df3f2'),(8,'BALANCE_ADJUSTMENT_CANCELED','Ajuste de Saldo Cancelado','#e8b9b9'),(9,'PRODUCT_SOLD_PARTIALLY_REFUNDED','Venda Parcialmente Reembolsada','#ffff'),(10,'USED_TO_BUY','Usado para compra','#ffff');
/*!40000 ALTER TABLE `history_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `total` double DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (3,1,660,1),(2,1,990,1),(1,1,1980,1);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_product` (
  `order_product_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  `price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`order_product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` VALUES (1,1,1,2,990,1980),(2,2,2,3,330,990),(3,3,3,1,660,660);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `quantity` int DEFAULT NULL,
  `image` text,
  `price` double DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Sandália Charlotte Olympia Bruce Vermelho','Sapato seminovo, em ótimo estado de conservação. Possui sola gasta e sinais de uso na palmilha. Não acompanha dustbag. Sola 37 Europa. Salto 16cm.',5,'https://dptafza4tn3d0.cloudfront.net/cache/catalog/CV15205/vestido-dolce-gabbana-margaridas-%20(2)-250x313.jpg',990,1),(2,'Sapato Tory Burch Peep Toe Preto','Produto seminovo, em ótimo estado de conservação, com alguns desfiadinhos na costura do salto e leve desgaste na sola.',6,'https://dptafza4tn3d0.cloudfront.net/cache/catalog/CV22311/sapato-tory-burch-peep-toe-preto-CV22311(1)-640x800.JPG',330,1),(3,'Conjunto Saia e Blusa Estampa Tory Burch','Produto Seminovo em ótimo estado.',8,'https://dptafza4tn3d0.cloudfront.net/cache/catalog/1519/conjunto-saia-e-blusa-estampa-tory-burch-640x800.jpg',660,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `transfer_id` int DEFAULT NULL,
  `value` double DEFAULT NULL,
  `status` int DEFAULT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (6,1,3,3,NULL,-660,1,'2020-03-20 10:10:10'),(5,1,2,2,NULL,-990,1,'2020-03-20 10:10:10'),(1,1,1,1,NULL,1980,1,'2020-03-20 10:10:10'),(7,1,NULL,NULL,4,500,1,'2020-03-20 10:10:10'),(8,1,NULL,NULL,5,200,1,'2020-03-20 10:10:10');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfer`
--

DROP TABLE IF EXISTS `transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfer` (
  `transfer_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `bank_account_id` int NOT NULL,
  `amount` double DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`transfer_id`),
  KEY `customer_id` (`customer_id`),
  KEY `bank_account_id` (`bank_account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfer`
--

LOCK TABLES `transfer` WRITE;
/*!40000 ALTER TABLE `transfer` DISABLE KEYS */;
INSERT INTO `transfer` VALUES (5,1,1,200,1),(4,1,1,500,1);
/*!40000 ALTER TABLE `transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'recrutamento'
--

--
-- Dumping routines for database 'recrutamento'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-22 18:16:30
