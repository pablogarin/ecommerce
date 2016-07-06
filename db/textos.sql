-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: preciada
-- ------------------------------------------------------
-- Server version	5.5.49-0+deb8u1

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
-- Table structure for table `texto`
--

DROP TABLE IF EXISTS `texto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `texto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `cuerpo` text NOT NULL,
  `llave` varchar(120) DEFAULT NULL,
  `idioma` char(2) DEFAULT 'ES',
  `activo` int(11) DEFAULT '1',
  `idTipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `texto`
--

LOCK TABLES `texto` WRITE;
/*!40000 ALTER TABLE `texto` DISABLE KEYS */;
INSERT INTO `texto` VALUES (1,'Contacto','<p><strong>Direcci&oacute;n</strong>: Bartolo Soto 8080, San Miguel, Santiago, RM.</p>\r\n\r\n<p><strong>Fono</strong>: +56 9 9414 9917</p>\r\n\r\n<p><strong>Horario</strong>: 8AM a 6PM</p>\r\n\r\n<p><strong>E-Mail</strong>: pablo.garin@hotmail.com</p>\r\n','contacto','ES',1,NULL),(2,'¿Quiénes Somos?','<p>&ldquo;Encontrar y flecharse con ese objeto especial y &uacute;nico, un tesoro para quedarse con el&hellip;&rdquo; Bajo esta primicia nace Preciada, un bazar online de&nbsp;decoraci&oacute;n&nbsp;fundado con el deseo de descubrir bellos objetos antiguos, nuevos, reciclados y hechos a mano, cl&aacute;sicos y de aire vintage.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Podr&aacute;s encontrar solo piezas &uacute;nicas o bien, muy pocas unidades de objetos como vasos, fuentes, enlozados,&nbsp;pocillos, juegos de platos y tazas, arte, floreros, marcos, y tantos otros, que han sido cuidadosamente elegidos para convertirse en un preciado y &uacute;nico tesoro para preservarlo en el tiempo.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Este es el emprendimiento, que con mi hermana Soledad dese&aacute;bamos hace tiempo concretar. Naci&oacute; de la nada, r&aacute;pido, mirando lo que ten&iacute;amos alrededor y a la vez, viendo que ten&iacute;amos lo m&aacute;s importante, las ganas. Es reflejo de nuestros gustos y anhelos, una clara muestra de las cosas a las que nos gusta poner mucha fuerza y atenci&oacute;n.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Preciada ya esta aqu&iacute;. Solo esperamos que la marcha y la experiencia nos vaya haciendo cada vez mejores, perseverantes y con buenas ideas para perpetuar esto, lo que nos gusta hacer.</p>\r\n','quienesSomos',NULL,1,NULL),(3,'¿Cómo Comprar?','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n','comoComprar',NULL,1,NULL);
/*!40000 ALTER TABLE `texto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-06 10:29:21
