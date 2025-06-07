-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mschat_soc
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

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
-- Current Database: `mschat_soc`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `mschat_soc` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mschat_soc`;

--
-- Table structure for table `alboms`
--

DROP TABLE IF EXISTS `alboms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alboms` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_user` int(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `date` int(12) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alboms`
--

LOCK TABLES `alboms` WRITE;
/*!40000 ALTER TABLE `alboms` DISABLE KEYS */;
INSERT INTO `alboms` VALUES (1,1,'Со страницы','Фотографии с моей страницы',1,'1371321196'),(2,3,'Со страницы','Фотографии с моей страницы',1,'1371322766'),(3,2,'Со страницы','Фотографии с моей страницы',1,'1371328793'),(4,7,'Со страницы','Фотографии с моей страницы',1,'1371396884'),(5,10,'Со страницы','Фотографии с моей страницы',1,'1371327027'),(6,11,'Со страницы','Фотографии с моей страницы',1,'1371671915'),(7,12,'Со страницы','Фотографии с моей страницы',1,'1377713274'),(8,6,'Со страницы','Фотографии с моей страницы',1,'1371329022'),(9,16,'Со страницы','Фотографии с моей страницы',1,'1371386930'),(10,20,'Со страницы','Фотографии с моей страницы',1,'1371409046'),(11,20,'ну вот=)','',1371399601,'1371399798'),(12,22,'Со страницы','Фотографии с моей страницы',1,'1371500168'),(13,23,'Со страницы','Фотографии с моей страницы',1,'1373796146'),(14,23,'Life','',1371573667,'1371573691'),(15,25,'Со страницы','Фотографии с моей страницы',1,'1371589782'),(16,29,'Со страницы','Фотографии с моей страницы',1,'1371677418'),(17,30,'Со страницы','Фотографии с моей страницы',1,'1371679061'),(18,30,'I am','happy',1371679272,'1371681300'),(19,31,'Со страницы','Фотографии с моей страницы',1,'1371682684'),(20,32,'Со страницы','Фотографии с моей страницы',1,'1371683384'),(21,32,'=)','',1371683398,'1371683509'),(22,34,'Со страницы','Фотографии с моей страницы',1,'1371683871'),(23,33,'Со страницы','Фотографии с моей страницы',1,'1371684195'),(24,38,'Со страницы','Фотографии с моей страницы',1,'1374779071'),(25,40,'Со страницы','Фотографии с моей страницы',1,'1375868667'),(26,41,'Со страницы','Фотографии с моей страницы',1,'1377104251'),(27,47,'Со страницы','Фотографии с моей страницы',1,'1377972858'),(28,51,'Со страницы','Фотографии с моей страницы',1,''),(29,53,'Со страницы','Фотографии с моей страницы',1,'1379334335'),(30,62,'Со страницы','Фотографии с моей страницы',1,'1380369421'),(31,63,'Со страницы','Фотографии с моей страницы',1,'1380369710'),(32,74,'Со страницы','Фотографии с моей страницы',1,'1380481342'),(33,83,'Со страницы','Фотографии с моей страницы',1,'1380481345'),(34,78,'Со страницы','Фотографии с моей страницы',1,'1380481349'),(35,89,'Со страницы','Фотографии с моей страницы',1,'1380481371'),(36,88,'Со страницы','Фотографии с моей страницы',1,'1380481400'),(37,75,'Со страницы','Фотографии с моей страницы',1,'1380481413'),(38,84,'Со страницы','Фотографии с моей страницы',1,'1380481439'),(39,87,'Со страницы','Фотографии с моей страницы',1,'1380481470'),(40,81,'Со страницы','Фотографии с моей страницы',1,'1380481484'),(41,71,'Со страницы','Фотографии с моей страницы',1,'1380481490'),(42,76,'Со страницы','Фотографии с моей страницы',1,'1380481511'),(43,85,'Со страницы','Фотографии с моей страницы',1,'1380481522'),(44,73,'Со страницы','Фотографии с моей страницы',1,'1380482686'),(45,72,'Со страницы','Фотографии с моей страницы',1,'1380482699'),(46,104,'Со страницы','Фотографии с моей страницы',1,'1380482759'),(47,95,'Со страницы','Фотографии с моей страницы',1,'1380482770'),(48,99,'Со страницы','Фотографии с моей страницы',1,'1380482801'),(49,93,'Со страницы','Фотографии с моей страницы',1,'1380482811'),(50,105,'Со страницы','Фотографии с моей страницы',1,'1380482845'),(51,141,'Со страницы','Фотографии с моей страницы',1,'1429339524'),(52,143,'Со страницы','Фотографии с моей страницы',1,'1429448704'),(53,143,'Альбом 1','свысывс',1429448753,''),(55,155,'Со страницы','Фотографии с моей страницы',1,'1429776589'),(56,157,'Со страницы','Фотографии с моей страницы',1,'1429904583'),(57,160,'111','111',1430762980,''),(58,164,'Со страницы','Фотографии с моей страницы',1,'1431872028'),(59,168,'Со страницы','Фотографии с моей страницы',1,'1432231951'),(60,174,'Со страницы','Фотографии с моей страницы',1,'1433244344'),(61,176,'Со страницы','Фотографии с моей страницы',1,'1433875308'),(62,144,'Со страницы','Фотографии с моей страницы',1,'1434801387'),(63,199,'Со страницы','Фотографии с моей страницы',1,'1450370825'),(64,199,'массаж для женщин','#массаж_для_женщин http://massage-v-moscow.ru  #массаж_женщине \nВызов массажиста для женщин на дом  по Телефону:  7 9253744007 #эротический_массаж_на_выезд #массаж #массаж_девушке',1450370961,'1450370971'),(65,177,'Со страницы','Фотографии с моей страницы',1,'1457174220'),(66,206,'Со страницы','Фотографии с моей страницы',1,'1458229579'),(67,212,'Со страницы','Фотографии с моей страницы',1,'1464285672'),(68,220,'Со страницы','Фотографии с моей страницы',1,'1468740359'),(69,230,'Со страницы','Фотографии с моей страницы',1,'1473448750'),(70,248,'Со страницы','Фотографии с моей страницы',1,'1494581583'),(71,250,'Со страницы','Фотографии с моей страницы',1,'1497284901'),(72,271,'пидоры','хаха',1523143110,''),(73,280,'Со страницы','Фотографии с моей страницы',1,'1528202954');
/*!40000 ALTER TABLE `alboms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ban`
--

DROP TABLE IF EXISTS `ban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ban` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `time` int(12) NOT NULL,
  `min` int(12) NOT NULL,
  `user` varchar(50) NOT NULL,
  `text` varchar(255) NOT NULL,
  `moder` varchar(50) NOT NULL,
  `type` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ban`
--

LOCK TABLES `ban` WRITE;
/*!40000 ALTER TABLE `ban` DISABLE KEYS */;
INSERT INTO `ban` VALUES (2,1379762851,525600,'rtfm','999999999','Skriptoff',1),(5,1464291058,525600,'romancu','99999999999999999','Skriptoff',1);
/*!40000 ALTER TABLE `ban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'street'),(2,'icq'),(10,'site'),(5,'skype'),(6,'hidden'),(7,'show_moder'),(8,'type_sp');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `kto` int(255) NOT NULL,
  `komu` int(255) NOT NULL,
  `text` text NOT NULL,
  `time` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (14,1,41,'5 марта)',1377104670),(26,143,143,'привет',1429448463),(4,23,23,'Тест',1371672724),(5,2,2,'Мне очень не нравятся высокомерные люди, которые ставят себя выше других. Так и хочется дать им рубль и сказать, узнаешь себе цену - вернешь сдачу...',1371677027),(6,30,30,'почему не 100%?(',1371682849),(8,34,32,'[plus]1',1371684484),(9,34,30,'Возьми у меня 8%',1371684596),(10,34,23,'Тесто',1371684627),(11,34,25,'Попка?)',1371684668),(12,34,20,'Красивая)',1371684699),(13,20,34,'спасибо))',1372150603),(37,212,212,'zdcscc',1464022222),(27,148,148,'Прикольно',1429522298),(28,160,160,'GHj',1430762947),(19,51,51,'Дело было вечером, делать было не чего',1379168887),(29,162,162,'Привет всем)',1430895886),(31,188,53,'xzdcxc',1440931872),(38,177,32,'good',1466271019),(47,271,47,'Выдра я хочу тебя выдрать',1523142889),(44,247,247,'111',1494499587),(46,248,248,'Тест )))',1494592704),(48,278,278,'\';!--&quot;&lt;fuck&gt;=[and]{()}',1528199719);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `land`
--

DROP TABLE IF EXISTS `land`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `land` (
  `mini` varchar(5) NOT NULL,
  `land` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `land`
--

LOCK TABLES `land` WRITE;
/*!40000 ALTER TABLE `land` DISABLE KEYS */;
INSERT INTO `land` VALUES ('ru','Россия'),('ua','Украина'),('by','Беларусь'),('az','Азербайджан'),('de','Германия'),('fr','Франция'),('kz','Казахстан'),('la','Латвия'),('md','Молдавия'),('tg','Таджикистан');
/*!40000 ALTER TABLE `land` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likesCom`
--

DROP TABLE IF EXISTS `likesCom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likesCom` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `kto` int(255) NOT NULL,
  `com` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likesCom`
--

LOCK TABLES `likesCom` WRITE;
/*!40000 ALTER TABLE `likesCom` DISABLE KEYS */;
INSERT INTO `likesCom` VALUES (1,1,3),(2,23,4),(3,34,6),(4,34,4),(5,34,3),(6,34,12),(7,1,5),(8,20,12),(11,1,14),(12,41,14),(13,1,17),(14,1,6),(15,143,26),(20,177,32),(18,177,35),(21,177,5),(22,245,38),(24,245,8),(28,247,44),(29,248,45),(30,248,46),(33,210,39),(34,271,47);
/*!40000 ALTER TABLE `likesCom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likesPhoto`
--

DROP TABLE IF EXISTS `likesPhoto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likesPhoto` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_photo` int(255) NOT NULL,
  `kto` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=267 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likesPhoto`
--

LOCK TABLES `likesPhoto` WRITE;
/*!40000 ALTER TABLE `likesPhoto` DISABLE KEYS */;
INSERT INTO `likesPhoto` VALUES (1,-1,1),(10,11,1),(3,3,1),(4,5,1),(5,4,1),(6,6,1),(7,6,10),(9,7,1),(11,10,1),(246,16,1),(13,17,1),(14,21,1),(15,22,1),(16,22,10),(17,16,10),(18,23,1),(25,29,1),(24,26,1),(23,24,1),(26,28,1),(27,27,1),(28,30,1),(29,31,1),(30,32,1),(31,35,28),(32,58,28),(33,57,28),(34,56,28),(35,54,28),(36,60,31),(37,52,31),(38,62,31),(39,58,31),(40,56,31),(41,35,30),(42,63,30),(43,56,30),(44,52,30),(45,60,30),(46,37,30),(47,65,1),(48,66,1),(49,56,34),(50,60,34),(51,54,34),(52,44,34),(53,31,34),(54,26,34),(55,16,34),(56,22,34),(57,70,34),(58,1,34),(59,6,34),(60,65,34),(61,66,34),(62,68,34),(63,73,1),(64,75,1),(65,77,1),(66,1,47),(67,80,1),(68,79,1),(69,78,1),(244,53,164),(245,115,176),(247,-1,177),(249,26,177),(251,123,1),(252,54,177),(253,-1,220),(254,59,220),(255,42,220),(256,43,220),(262,24,177),(258,23,177),(259,22,177),(260,21,177),(261,16,177),(263,-1,245),(266,6,245);
/*!40000 ALTER TABLE `likesPhoto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ls`
--

DROP TABLE IF EXISTS `ls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ls` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `pol` int(100) NOT NULL,
  `otp` int(100) NOT NULL,
  `text` text NOT NULL,
  `time` int(15) NOT NULL,
  `delpol` int(1) NOT NULL DEFAULT '0',
  `delotp` int(1) NOT NULL DEFAULT '0',
  `view` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mess`
--

DROP TABLE IF EXISTS `mess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mess` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` int(12) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `polychatel` varchar(255) NOT NULL,
  `privat` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=859 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `moderLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moderLog` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id2` int(255) NOT NULL,
  `date` int(12) NOT NULL,
  `moder` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=297 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photocomments`
--

DROP TABLE IF EXISTS `photocomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photocomments` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `kto` int(255) NOT NULL,
  `komu` int(255) NOT NULL,
  `text` text NOT NULL,
  `time` int(255) NOT NULL,
  `id_photo` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_user` int(255) NOT NULL,
  `albom` int(255) NOT NULL,
  `date` int(50) NOT NULL,
  `text` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `likes` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `img` varchar(100) NOT NULL,
  `cat` int(10) NOT NULL,
  `function` varchar(50) NOT NULL,
  `count` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `type` int(1) NOT NULL,
  `hidden` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop`
--

LOCK TABLES `shop` WRITE;
/*!40000 ALTER TABLE `shop` DISABLE KEYS */;
INSERT INTO `shop` VALUES (1,'Градиент текста','Уникальный цвет текста сообщений в чате состоящих из 2-х цветов (1 цвет плавно переходит в другой). Цвета Выбираются из Вашей палитры цветов. Действие 30 дней после покупки, при продлении (покупка до истечения срока) скидка 50%','4.jpg',1,'gradient',-1,30,2,0),(2,'Расширенная палитра цветов (21 цветов)','Палитра цветов расширится до 21 цветов. Применяется для цвета сообщений в чате, градиента, покраски ников и стилей где только применяются цвета.','1.jpg',1,'color21',-1,15,1,0),(3,'Расширенная палитра цветов (42 цвета)','Палитра цветов расширится до 42-х цветов. Применяется для цвета сообщений в чате, градиента, покраски ников и стилей где только применяются цвета.','2.jpg',1,'color42',-1,50,1,0),(4,'Жирный стиль','Тест сообщений в чате становится жирным. Применяется сразу после покупки. Срок действия неограничен','3.jpg',1,'b',60,10,2,0),(5,'Шрифт Georgia','Изменяет стандартный шрифт чата на \"Georgia\", срок не ограничен. Пример: <br><br><font face=\"Georgia\">Привет, как дела? 12345. I love you</font>','font.png',1,'font.Georgia',-1,3,3,0),(6,'Шрифт Franklin Gothic Medium','Изменяет стандартный шрифт чата на \"Franklin Gothic Medium\", срок не ограничен. Пример: <br><br><font face=\"Franklin Gothic Medium\">Привет, как дела? 12345. I love you</font>','font.png',1,'font.Franklin Gothic Medium',-1,8,3,0),(7,'Шрифт Lucida Console','Изменяет стандартный шрифт чата на \"Lucida Console\", срок не ограничен. Пример: <br><br><font face=\"Lucida Console\">Привет, как дела? 12345. I love you</font>','font.png',1,'font.Lucida Console',-1,10,3,0),(8,'Шрифт Comic Sans MS','Изменяет стандартный шрифт чата на \"Comic Sans MS\", срок не ограничен. Пример: <br><br><font face=\"Comic Sans MS\">Привет, как дела? 12345. I love you</font>','font.png',1,'font.Comic Sans MS',-1,15,3,0),(9,'Шрифт Century Gothic','Изменяет стандартный шрифт чата на \"Century Gothic\", срок не ограничен. Пример: <br><br><font face=\"Century Gothic\">Привет, как дела? 12345. I love you</font>','font.png',1,'font.Century Gothic',-1,15,3,0),(10,'Эффект текста 3D','Эффект объемного текста Ваших сообщений в чате. Покупается на 30 дней. Цвет текста выбирается любой из палитры цветов. \r\nПример <br><br>\r\n<span class=\"e3d\" style=\"color:white\">Привет, как дела? 12345. I love you</span>','e3d.jpg',1,'class.e3d',96,100,4,0),(11,'Эффект огня','Эффект огня Ваших сообщений в чате. Покупается на 30 дней. Цвет текста выбирается любой из палитры цветов. \r\nПример <br><br>\r\n<span class=\"fire\" style=\"color:red; font-weight:bold\">Привет, как дела? 12345. I love you</span>','fire.jpg',1,'class.fire',3,80,4,0),(12,'Эффект синего неона','Эффект синего неона Ваших сообщений в чате. Покупается на 30 дней. Цвет текста выбирается любой из палитры цветов.\r\nПример <br><br>\r\n<span class=\"neon_blue\" style=\"color:white; font-weight:bold\">Привет, как дела? 12345. I love you</span>','neon_blue.jpg',1,'class.neon_blue',7,50,4,0),(13,'Эффект розового неона','Эффект розового неона Ваших сообщений в чате. Покупается на 30 дней. Цвет текста выбирается любой из палитры цветов. \r\nПример <br><br>\r\n<span class=\"neon_pink\" style=\"color:#fff; font-weight:bold;\">Привет, как дела? 12345. I love you</span>','neon_pink.jpg',1,'class.neon_pink',9,50,4,0),(14,'Стандартная','Устанавливает стандартную обложку.','1',2,'obl.1',-1,0,1,0),(15,'Горное небо','Уникальная обложка.','2',2,'obl.2',-1,3,1,0),(16,'Красные лепестки','Уникальная обложка.','3',2,'obl.3',-1,5,1,0),(17,'Низкий водопад','Уникальная обложка.','4',2,'obl.4',-1,15,1,0),(18,'Река в горах','Уникальная обложка.','5',2,'obl.5',-1,8,1,0),(19,'Древесина','Уникальная обложка.','6',2,'obl.6',-1,15,1,0),(20,'Водная шахта','Уникальная обложка.','7',2,'obl.7',-1,7,1,0),(21,'Скала','Уникальная обложка.','8',2,'obl.8',-1,22,1,0),(22,'Закат в лесу','Уникальная обложка.','9',2,'obl.9',-1,38,1,0),(23,'Одуванчик','Уникальная обложка.','10',2,'obl.10',-1,6,1,0),(24,'Древесина','','1.jpg',2,'fon.1 jpg',231,10,2,0),(39,'Бурый кирпич','','8.jpg',2,'fon.8 jpg',-1,11,2,0),(38,'Ламинатная плитка','','7.jpg',2,'fon.7 jpg',-1,15,2,0),(37,'Мятое дерево','','6.jpg',2,'fon.6 jpg',-1,5,2,0),(36,'Доски','','5.jpg',2,'fon.5 jpg',-1,5,2,0),(35,'Ламинат','','4.jpg',2,'fon.4 jpg',-1,8,2,0),(34,'Затертые доски','','3.jpg',2,'fon.3 jpg',-1,10,2,0),(33,'Синий забор','','2.jpg',2,'fon.2 jpg',-1,20,2,0),(40,'Битый камень','','9.jpg',2,'fon.9 jpg',-1,12,2,0),(41,'Каменная плитка','','10.jpg',2,'fon.10 jpg',-1,12,2,0),(42,'Синие камни','','11.jpg',2,'fon.11 jpg',-1,13,2,0),(43,'Темный кирпич','','12.jpg',2,'fon.12 jpg',-1,9,2,0),(44,'Белый кирпич','','13.jpg',2,'fon.13 jpg',-1,18,2,0),(45,'Плитка','','14.jpg',2,'fon.14 jpg',-1,14,2,0),(46,'Темная плитка','','15.jpg',2,'fon.15 jpg',-1,25,2,0),(47,'Яркий кирпич','','16.jpg',2,'fon.16 jpg',-1,19,2,0),(48,'Темные камни','','17.jpg',2,'fon.17 jpg',-1,11,2,0),(49,'Вертушки','','18.jpg',2,'fon.18 jpg',-1,17,2,0),(50,'','','19.jpg',2,'fon.19 jpg',-1,16,2,0),(51,'','','20.jpg',2,'fon.20 jpg',-1,15,2,0),(52,'','','21.jpg',2,'fon.21 jpg',-1,12,2,0),(53,'','','22.jpg',2,'fon.22 jpg',-1,18,2,0),(54,'','','23.jpg',2,'fon.23 jpg',-1,9,2,0),(55,'','','24.jpg',2,'fon.24 jpg',-1,50,2,0),(56,'','','25.jpg',2,'fon.25 jpg',-1,16,2,0),(57,'','','26.jpg',2,'fon.26 jpg',-1,19,2,0),(58,'','','27.jpg',2,'fon.27 jpg',-1,10,2,0),(59,'','','28.jpg',2,'fon.28 jpg',-1,11,2,0),(60,'','','29.jpg',2,'fon.29 jpg',-1,11,2,0),(61,'','','30.jpg',2,'fon.30 jpg',-1,18,2,0),(62,'','','31.jpg',2,'fon.31 jpg',-1,6,2,0),(63,'','','32.jpg',2,'fon.32 jpg',-1,7,2,0),(64,'','','33.jpg',2,'fon.33 jpg',-1,9,2,0),(65,'','','34.jpg',2,'fon.34 jpg',-1,13,2,0),(66,'','','35.jpg',2,'fon.35 jpg',-1,6,2,0),(67,'','','36.jpg',2,'fon.36 jpg',-1,25,2,0),(68,'','','37.jpg',2,'fon.37 jpg',-1,3,2,0),(69,'','','38.jpg',2,'fon.38 jpg',-1,20,2,0),(70,'','','39.jpg',2,'fon.39 jpg',-1,16,2,0),(71,'','','40.jpg',2,'fon.40 jpg',-1,4,2,0),(72,'','','41.jpg',2,'fon.41 jpg',-1,20,2,0),(73,'Мери','','42.jpg',2,'fon.42 jpg',-1,1,2,0),(74,'Лава','','43.jpg',2,'fon.43 jpg',-1,1,2,0),(75,'Питон','','44.jpg',2,'fon.44 jpg',-1,1,2,0),(76,'Love','','45.jpg',2,'fon.45 jpg',-1,1,2,0),(77,'Инферно','','46.jpg',2,'fon.46 jpg',-1,1,2,0),(78,'Чемпион','','47.jpg',2,'fon.47 jpg',-1,5,2,0),(79,'Изумруд','','48.jpg',2,'fon.48 jpg',-1,3,2,0),(80,'Свинец','','49.jpg',2,'fon.49 jpg',-1,3,2,0),(81,'Хохлома','','50.jpg',2,'fon.50 jpg',-1,3,2,0),(82,'Смерть','','51.jpg',2,'fon.51 jpg',-1,3,2,0),(83,'Сафари','','52.jpg',2,'fon.52 jpg',-1,3,2,0),(84,'Тайга','','53.jpg',2,'fon.53 jpg',-1,3,2,0),(85,'Ягуар','','54.jpg',2,'fon.54 jpg',-1,3,2,0),(86,'Ржавчина','','55.jpg',2,'fon.55 jpg',-1,3,2,0),(87,'Электра','','56.jpg',2,'fon.56 jpg',-1,2,2,0),(88,'Ирбис','','57.jpg',2,'fon.57 jpg',-1,2,2,0),(89,'Искра','','58.jpg',2,'fon.58 jpg',-1,2,2,0),(90,'Дракон','','59.jpg',2,'fon.59 jpg',-1,2,2,0),(91,'Болотный','','60.jpg',2,'fon.60 jpg',-1,2,2,0),(92,'Морпех','','61.jpg',2,'fon.61 jpg',-1,2,2,0),(93,'Буря','','62.jpg',2,'fon.62 jpg',-1,2,2,0),(94,'Чужой','','63.jpg',2,'fon.63 jpg',-1,2,2,0),(95,'Прибой','','64.jpg',2,'fon.64 jpg',-1,2,2,0),(96,'Тундра','','65.jpg',2,'fon.65 jpg',-1,2,2,0),(97,'Роджер','','66.jpg',2,'fon.66 jpg',-1,2,2,0),(98,'Продиджи','','67.jpg',2,'fon.67 jpg',-1,2,2,0),(99,'Кедр','','68.jpg',2,'fon.68 jpg',-1,2,2,0),(100,'Песчаник','','69.jpg',2,'fon.69 jpg',-1,2,2,0),(101,'Шелест','','70.jpg',2,'fon.70 jpg',-1,2,2,0),(102,'Диджитал','','71.jpg',2,'fon.71 jpg',-1,2,2,0),(103,'Глина','','72.jpg',2,'fon.72 jpg',-1,2,2,0),(104,'Урбан','','73.jpg',2,'fon.73 jpg',-1,2,2,0),(105,'Алигатор','','75.jpg',2,'fon.75 jpg',-1,2,2,0),(106,'Грязь','','76.jpg',2,'fon.76 jpg',-1,2,2,0),(107,'Метель','','77.jpg',2,'fon.77 jpg',-1,2,2,0),(108,'Нефрит','','78.jpg',2,'fon.78 jpg',-1,2,2,0),(109,'Скала','','79.jpg',2,'fon.79 jpg',-1,2,2,0),(110,'Тина','','80.jpg',2,'fon.80 jpg',-1,2,2,0),(111,'Лесник','','81.jpg',2,'fon.81 jpg',-1,2,2,0),(112,'Камо','','82.jpg',2,'fon.82 jpg',-1,2,2,0),(113,'Флора','','83.jpg',2,'fon.83 jpg',-1,2,2,0),(114,'Пустыня','','84.jpg',2,'fon.84 jpg',-1,2,2,0),(115,'','','85.jpg',2,'fon.85 jpg',-1,2,2,0),(116,'Микро','','86.jpg',2,'fon.86 jpg',-1,2,2,0),(117,'Matrix','','87.jpg',2,'fon.87 jpg',-1,2,2,0),(118,'','','88.jpg',2,'fon.88 jpg',-1,2,2,0),(119,'','','89.jpg',2,'fon.89 jpg',-1,2,2,0),(120,'','','90.jpg',2,'fon.90 jpg',-1,0,2,0),(121,'','','91.jpg',2,'fon.91 jpg',-1,0,2,0),(122,'','','92.jpg',2,'fon.92 jpg',-1,0,2,0),(123,'','','93.jpg',2,'fon.93 jpg',-1,0,2,0),(124,'','','94.jpg',2,'fon.94 jpg',-1,0,2,0);
/*!40000 ALTER TABLE `shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `ban` int(1) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `activ` varchar(255) NOT NULL,
  `data_reg` int(100) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `online` int(1) NOT NULL,
  `onlinetime` int(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `sex` int(1) NOT NULL,
  `name` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `sp` int(1) NOT NULL,
  `admin` int(1) NOT NULL,
  `bday` varchar(255) NOT NULL,
  `land` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=614 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Dumping routines for database 'mschat_soc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-03  0:04:23
