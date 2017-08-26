-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: saiddb
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Current Database: `saiddb`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `saiddb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `saiddb`;

--
-- Table structure for table `adgroup`
--

DROP TABLE IF EXISTS `adgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adgroup` varchar(45) NOT NULL,
  `canview` enum('false','true') NOT NULL DEFAULT 'true',
  `candelete` enum('false','true') NOT NULL DEFAULT 'true',
  `candownload` enum('false','true') NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`),
  UNIQUE KEY `adgroup_UNIQUE` (`adgroup`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` char(32) DEFAULT NULL,
  `adgroup_id` int(5) unsigned NOT NULL,
  `mimetypeid` int(5) unsigned DEFAULT NULL,
  `filename` varchar(75) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `size` bigint(11) unsigned DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`adgroup_id`,`hash`) USING BTREE,
  KEY `hash_index` (`hash`) USING BTREE,
  KEY `mimetypeid` (`mimetypeid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `deleteddata`
--

DROP TABLE IF EXISTS `deleteddata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deleteddata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` char(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `adgroup_id` int(5) unsigned NOT NULL,
  `mimetypeid` int(10) unsigned DEFAULT NULL,
  `filename` varchar(75) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `size` bigint(11) unsigned DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `dated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `hash_index` (`hash`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mimetypedb`
--

DROP TABLE IF EXISTS `mimetypedb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mimetypedb` (
  `idmimetype` int(11) NOT NULL AUTO_INCREMENT,
  `mimetype` varchar(45) NOT NULL,
  PRIMARY KEY (`idmimetype`),
  UNIQUE KEY `mimetype_UNIQUE` (`mimetype`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-29  3:00:01
