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
-- Dumping data for table `atributo`
--

LOCK TABLES `atributo` WRITE;
/*!40000 ALTER TABLE `atributo` DISABLE KEYS */;
/*!40000 ALTER TABLE `atributo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `atributo_producto`
--

LOCK TABLES `atributo_producto` WRITE;
/*!40000 ALTER TABLE `atributo_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `atributo_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `carro`
--

LOCK TABLES `carro` WRITE;
/*!40000 ALTER TABLE `carro` DISABLE KEYS */;
INSERT INTO `carro` VALUES (1,NULL,'2016-07-05 21:48:51',0,0),(2,NULL,'2016-07-06 13:18:43',0,0),(3,NULL,'2016-07-06 15:45:43',0,0);
/*!40000 ALTER TABLE `carro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (-1,'Raíz',-1,1,NULL,NULL,NULL),(1,'Prueba',-1,1,NULL,NULL,1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'nombreSitio','Nombre del Sitio','Preciada',NULL,'2016-07-05 21:48:51','text'),(2,'urlSitio','URL del Sitio','http://preciada.cl',NULL,'2016-07-06 13:13:24','text'),(3,'facebookURL','URL de Facebook','http://facebook.com',NULL,'2016-07-05 21:48:51','text'),(4,'twitterURL','URL de Twitter','http://twitter.com',NULL,'2016-07-05 21:48:51','text'),(5,'cuentaCorreo','Correo Sitio','pablito.garin@gmail.com',NULL,'2016-07-05 21:48:51','text'),(6,'claveCorreo','Clave del Correo','G8r33x5434',NULL,'2016-07-06 13:12:39','password'),(7,'servidorCorreo','Servidor de Correo Saliente','smtp.gmail.com',NULL,'2016-07-05 21:48:51','text'),(8,'puertoCorreo','Puerto para Correo','465',NULL,'2016-07-05 21:48:51','text'),(9,'seguridadCorreo','Tipo de Seguridad del Correo','ssl',NULL,'2016-07-05 21:48:51','select[ssl,tls]'),(10,'blogURL','URL del blog','http://wordpress.com',NULL,'2016-07-06 13:30:54','text'),(11,'instagramURL','URL Instagram','http://instagram.com',NULL,'2016-07-06 15:16:01','text');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `correo_venta`
--

LOCK TABLES `correo_venta` WRITE;
/*!40000 ALTER TABLE `correo_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `correo_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `costo_despacho`
--

LOCK TABLES `costo_despacho` WRITE;
/*!40000 ALTER TABLE `costo_despacho` DISABLE KEYS */;
/*!40000 ALTER TABLE `costo_despacho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cupon`
--

LOCK TABLES `cupon` WRITE;
/*!40000 ALTER TABLE `cupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cupon_producto`
--

LOCK TABLES `cupon_producto` WRITE;
/*!40000 ALTER TABLE `cupon_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupon_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cupon_venta`
--

LOCK TABLES `cupon_venta` WRITE;
/*!40000 ALTER TABLE `cupon_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupon_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `destacado`
--

LOCK TABLES `destacado` WRITE;
/*!40000 ALTER TABLE `destacado` DISABLE KEYS */;
/*!40000 ALTER TABLE `destacado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `elemento_slider_categoria`
--

LOCK TABLES `elemento_slider_categoria` WRITE;
/*!40000 ALTER TABLE `elemento_slider_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `elemento_slider_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `galeria_texto`
--

LOCK TABLES `galeria_texto` WRITE;
/*!40000 ALTER TABLE `galeria_texto` DISABLE KEYS */;
/*!40000 ALTER TABLE `galeria_texto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `giftcard`
--

LOCK TABLES `giftcard` WRITE;
/*!40000 ALTER TABLE `giftcard` DISABLE KEYS */;
/*!40000 ALTER TABLE `giftcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `historial_venta`
--

LOCK TABLES `historial_venta` WRITE;
/*!40000 ALTER TABLE `historial_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `invitacion`
--

LOCK TABLES `invitacion` WRITE;
/*!40000 ALTER TABLE `invitacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `invitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `oferta`
--

LOCK TABLES `oferta` WRITE;
/*!40000 ALTER TABLE `oferta` DISABLE KEYS */;
/*!40000 ALTER TABLE `oferta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `oferta_producto`
--

LOCK TABLES `oferta_producto` WRITE;
/*!40000 ALTER TABLE `oferta_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `oferta_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pago_venta`
--

LOCK TABLES `pago_venta` WRITE;
/*!40000 ALTER TABLE `pago_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `precio_cliente`
--

LOCK TABLES `precio_cliente` WRITE;
/*!40000 ALTER TABLE `precio_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `precio_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Producto Prueba',0,'<p>asdasdsad</p>\r\n','asd123',NULL,'prueba, manta, test',100,0,NULL,NULL,10000,12000,NULL,1,1,NULL,'2016-07-06 12:23:34',1,NULL,NULL);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `producto_bkup`
--

LOCK TABLES `producto_bkup` WRITE;
/*!40000 ALTER TABLE `producto_bkup` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_bkup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `producto_carro`
--

LOCK TABLES `producto_carro` WRITE;
/*!40000 ALTER TABLE `producto_carro` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_carro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `producto_categoria`
--

LOCK TABLES `producto_categoria` WRITE;
/*!40000 ALTER TABLE `producto_categoria` DISABLE KEYS */;
INSERT INTO `producto_categoria` VALUES (1,1,1,NULL,NULL);
/*!40000 ALTER TABLE `producto_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `producto_destacado`
--

LOCK TABLES `producto_destacado` WRITE;
/*!40000 ALTER TABLE `producto_destacado` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_destacado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `recurso`
--

LOCK TABLES `recurso` WRITE;
/*!40000 ALTER TABLE `recurso` DISABLE KEYS */;
/*!40000 ALTER TABLE `recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `rol_usuario`
--

LOCK TABLES `rol_usuario` WRITE;
/*!40000 ALTER TABLE `rol_usuario` DISABLE KEYS */;
INSERT INTO `rol_usuario` VALUES (1,'ADMIN'),(2,'EDITOR'),(3,'BLOGGER');
/*!40000 ALTER TABLE `rol_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `slider_categoria`
--

LOCK TABLES `slider_categoria` WRITE;
/*!40000 ALTER TABLE `slider_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `slider_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `texto`
--

LOCK TABLES `texto` WRITE;
/*!40000 ALTER TABLE `texto` DISABLE KEYS */;
INSERT INTO `texto` VALUES (1,'Contacto','<p><strong>Direcci&oacute;n</strong>: Bartolo Soto 8080, San Miguel, Santiago, RM.</p>\r\n\r\n<p><strong>Fono</strong>: +56 9 9414 9917</p>\r\n\r\n<p><strong>Horario</strong>: 8AM a 6PM</p>\r\n\r\n<p><strong>E-Mail</strong>: pablo.garin@hotmail.com</p>\r\n','contacto','ES',1,NULL),(2,'¿Quiénes Somos?','<p>&ldquo;Encontrar y flecharse con ese objeto especial y &uacute;nico, un tesoro para quedarse con el&hellip;&rdquo; Bajo esta primicia nace Preciada, un bazar online de&nbsp;decoraci&oacute;n&nbsp;fundado con el deseo de descubrir bellos objetos antiguos, nuevos, reciclados y hechos a mano, cl&aacute;sicos y de aire vintage.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Podr&aacute;s encontrar solo piezas &uacute;nicas o bien, muy pocas unidades de objetos como vasos, fuentes, enlozados,&nbsp;pocillos, juegos de platos y tazas, arte, floreros, marcos, y tantos otros, que han sido cuidadosamente elegidos para convertirse en un preciado y &uacute;nico tesoro para preservarlo en el tiempo.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Este es el emprendimiento, que con mi hermana Soledad dese&aacute;bamos hace tiempo concretar. Naci&oacute; de la nada, r&aacute;pido, mirando lo que ten&iacute;amos alrededor y a la vez, viendo que ten&iacute;amos lo m&aacute;s importante, las ganas. Es reflejo de nuestros gustos y anhelos, una clara muestra de las cosas a las que nos gusta poner mucha fuerza y atenci&oacute;n.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Preciada ya esta aqu&iacute;. Solo esperamos que la marcha y la experiencia nos vaya haciendo cada vez mejores, perseverantes y con buenas ideas para perpetuar esto, lo que nos gusta hacer.</p>\r\n','quienesSomos',NULL,1,NULL),(3,'¿Cómo Comprar?','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n','comoComprar',NULL,1,NULL);
/*!40000 ALTER TABLE `texto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo`
--

LOCK TABLES `tipo` WRITE;
/*!40000 ALTER TABLE `tipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo_texto`
--

LOCK TABLES `tipo_texto` WRITE;
/*!40000 ALTER TABLE `tipo_texto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_texto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','admin',1,1,'2016-07-05 21:48:51');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `venta_detalle`
--

LOCK TABLES `venta_detalle` WRITE;
/*!40000 ALTER TABLE `venta_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zona`
--

LOCK TABLES `zona` WRITE;
/*!40000 ALTER TABLE `zona` DISABLE KEYS */;
INSERT INTO `zona` VALUES (333,'Mejillones','',271),(334,'Sierra Gorda','',271),(335,'Taltal','',271),(336,'Calama','',272),(337,'Ollagüe','',272),(338,'San Pedro de Atacama','',272),(339,'Tocopilla','',273),(340,'María Elena','',273),(341,'Copiapó','',274),(342,'Caldera','',274),(343,'Tierra Amarilla','',274),(344,'Chañaral','',275),(345,'Diego de Almagro','',275),(346,'Vallenar','',276),(347,'Alto del Carmen','',276),(348,'Freirina','',276),(349,'Huasco','',276),(350,'La Serena','',277),(351,'Coquimbo','',277),(352,'Andacollo','',277),(353,'La Higuera','',277),(354,'Paiguano','',277),(355,'Vicuña','',277),(356,'Illapel','',278),(357,'Canela','',278),(358,'Los Vilos','',278),(359,'Salamanca','',278),(360,'Ovalle','',279),(361,'Combarbalá','',279),(362,'Monte Patria','',279),(363,'Punitaqui','',279),(364,'Río Hurtado','',279),(365,'Valparaíso','',280),(366,'Casablanca','',280),(367,'Concón','',280),(368,'Juan Fernández','',280),(369,'Puchuncaví','',280),(370,'Quintero','',280),(371,'Viña del Mar','',280),(372,'Isla de Pascua','',281),(373,'Los Andes','',282),(374,'Calle Larga','',282),(375,'Rinconada','',282),(376,'San Esteban','',282),(377,'La Ligua','',283),(378,'Cabildo','',283),(379,'Papudo','',283),(380,'Petorca','',283),(381,'Zapallar','',283),(382,'Quillota','',284),(383,'Calera','',284),(384,'Hijuelas','',284),(385,'La Cruz','',284),(386,'Nogales','',284),(387,'San Antonio','',285),(388,'Algarrobo','',285),(389,'Cartagena','',285),(390,'El Quisco','',285),(391,'El Tabo','',285),(392,'Santo Domingo','',285),(393,'San Felipe','',286),(394,'Catemu','',286),(395,'Llaillay','',286),(396,'Panquehue','',286),(397,'Putaendo','',286),(398,'Santa María','',286),(399,'Quilpué','',287),(400,'Limache','',287),(401,'Olmué','',287),(402,'Villa Alemana','',287),(403,'Rancagua','',288),(404,'Codegua','',288),(405,'Coinco','',288),(406,'Coltauco','',288),(407,'Doñihue','',288),(408,'Graneros','',288),(409,'Las Cabras','',288),(410,'Machalí','',288),(411,'Malloa','',288),(412,'Mostazal','',288),(413,'Olivar','',288),(414,'Peumo','',288),(415,'Pichidegua','',288),(416,'Quinta de Tilcoco','',288),(417,'Rengo','',288),(418,'Requínoa','',288),(419,'San Vicente','',288),(420,'Pichilemu','',289),(421,'La Estrella','',289),(422,'Litueche','',289),(423,'Marchihue','',289),(424,'Navidad','',289),(425,'Paredones','',289),(426,'San Fernando','',290),(427,'Chépica','',290),(428,'Chimbarongo','',290),(429,'Lolol','',290),(430,'Nancagua','',290),(431,'Palmilla','',290),(432,'Peralillo','',290),(433,'Placilla','',290),(434,'Pumanque','',290),(435,'Santa Cruz','',290),(436,'Talca','',291),(437,'Constitución','',291),(438,'Curepto','',291),(439,'Empedrado','',291),(440,'Maule','',291),(441,'Pelarco','',291),(442,'Pencahue','',291),(443,'Río Claro','',291),(444,'San Clemente','',291),(445,'San Rafael','',291),(446,'Cauquenes','',292),(447,'Chanco','',292),(448,'Pelluhue','',292),(449,'Curicó','',293),(450,'Hualañé','',293),(451,'Licantén','',293),(452,'Molina','',293),(453,'Rauco','',293),(454,'Romeral','',293),(455,'Sagrada Familia','',293),(456,'Teno','',293),(457,'Vichuquén','',293),(458,'Linares','',294),(459,'Colbún','',294),(460,'Longaví','',294),(461,'Parral','',294),(462,'Retiro','',294),(463,'San Javier','',294),(464,'Villa Alegre','',294),(465,'Yerbas Buenas','',294),(466,'Concepción','',295),(467,'Coronel','',295),(468,'Chiguayante','',295),(469,'Florida','',295),(470,'Hualqui','',295),(471,'Lota','',295),(472,'Penco','',295),(473,'San Pedro de la Paz','',295),(474,'Santa Juana','',295),(475,'Talcahuano','',295),(476,'Tomé','',295),(477,'Hualpén','',295),(478,'Lebu','',296),(479,'Arauco','',296),(480,'Cañete','',296),(481,'Contulmo','',296),(482,'Curanilahue','',296),(483,'Los Álamos','',296),(484,'Tirúa','',296),(485,'Los Ángeles','',297),(486,'Antuco','',297),(487,'Cabrero','',297),(488,'Laja','',297),(489,'Mulchén','',297),(490,'Nacimiento','',297),(491,'Negrete','',297),(492,'Quilaco','',297),(493,'Quilleco','',297),(494,'San Rosendo','',297),(495,'Santa Bárbara','',297),(496,'Tucapel','',297),(497,'Yumbel','',297),(498,'Alto Biobío','',297),(499,'Chillán','',298),(500,'Bulnes','',298),(501,'Cobquecura','',298),(502,'Coelemu','',298),(503,'Coihueco','',298),(504,'Chillán Viejo','',298),(505,'El Carmen','',298),(506,'Ninhue','',298),(507,'Ñiquén','',298),(508,'Pemuco','',298),(509,'Pinto','',298),(510,'Portezuelo','',298),(511,'Quillón','',298),(512,'Quirihue','',298),(513,'Ránquil','',298),(514,'San Carlos','',298),(515,'San Fabián','',298),(516,'San Ignacio','',298),(517,'San Nicolás','',298),(518,'Treguaco','',298),(519,'Yungay','',298),(520,'Temuco','',299),(521,'Carahue','',299),(522,'Cunco','',299),(523,'Curarrehue','',299),(524,'Freire','',299),(525,'Galvarino','',299),(526,'Gorbea','',299),(527,'Lautaro','',299),(528,'Loncoche','',299),(529,'Melipeuco','',299),(530,'Nueva Imperial','',299),(531,'Padre las Casas','',299),(532,'Perquenco','',299),(533,'Pitrufquén','',299),(534,'Pucón','',299),(535,'Saavedra','',299),(536,'Teodoro Schmidt','',299),(537,'Toltén','',299),(538,'Vilcún','',299),(539,'Villarrica','',299),(540,'Cholchol','',299),(541,'Angol','',300),(542,'Collipulli','',300),(543,'Curacautín','',300),(544,'Ercilla','',300),(545,'Lonquimay','',300),(546,'Los Sauces','',300),(547,'Lumaco','',300),(548,'Purén','',300),(549,'Renaico','',300),(550,'Traiguén','',300),(551,'Victoria','',300),(552,'Puerto Montt','',301),(553,'Calbuco','',301),(554,'Cochamó','',301),(555,'Fresia','',301),(556,'Frutillar','',301),(557,'Los Muermos','',301),(558,'Llanquihue','',301),(559,'Maullín','',301),(560,'Puerto Varas','',301),(561,'Castro','',302),(562,'Ancud','',302),(563,'Chonchi','',302),(564,'Curaco de Vélez','',302),(565,'Dalcahue','',302),(566,'Puqueldón','',302),(567,'Queilén','',302),(568,'Quellón','',302),(569,'Quemchi','',302),(570,'Quinchao','',302),(571,'Osorno','',303),(572,'Puerto Octay','',303),(573,'Purranque','',303),(574,'Puyehue','',303),(575,'Río Negro','',303),(576,'San Juan de la Costa','',303),(577,'San Pablo','',303),(578,'Chaitén','',304),(579,'Futaleufú','',304),(580,'Hualaihué','',304),(581,'Palena','',304),(582,'Coihaique','',305),(583,'Lago Verde','',305),(584,'Aisén','',306),(585,'Cisnes','',306),(586,'Guaitecas','',306),(587,'Cochrane','',307),(588,'O’Higgins','',307),(589,'Tortel','',307),(590,'Chile Chico','',308),(591,'Río Ibáñez','',308),(592,'Punta Arenas','',309),(593,'Laguna Blanca','',309),(594,'Río Verde','',309),(595,'San Gregorio','',309),(596,'Cabo de Hornos','',310),(597,'Antártica','',310),(598,'Porvenir','',311),(599,'Primavera','',311),(600,'Timaukel','',311),(601,'Natales','',312),(602,'Torres del Paine','',312),(603,'Santiago','',313),(604,'Cerrillos','',313),(605,'Cerro Navia','',313),(606,'Conchalí','',313),(607,'El Bosque','',313),(608,'Estación Central','',313),(609,'Huechuraba','',313),(610,'Independencia','',313),(611,'La Cisterna','',313),(612,'La Florida','',313),(613,'La Granja','',313),(614,'La Pintana','',313),(615,'La Reina','',313),(616,'Las Condes','',313),(617,'Lo Barnechea','',313),(618,'Lo Espejo','',313),(619,'Lo Prado','',313),(620,'Macul','',313),(621,'Maipú','',313),(622,'Ñuñoa','',313),(623,'Pedro Aguirre Cerda','',313),(624,'Peñalolén','',313),(625,'Providencia','',313),(626,'Pudahuel','',313),(627,'Quilicura','',313),(628,'Quinta Normal','',313),(629,'Recoleta','',313),(630,'Renca','',313),(631,'San Joaquín','',313),(632,'San Miguel','',313),(633,'San Ramón','',313),(634,'Vitacura','',313),(635,'Puente Alto','',314),(636,'Pirque','',314),(637,'San José de Maipo','',314),(638,'Colina','',315),(639,'Lampa','',315),(640,'Tiltil','',315),(641,'San Bernardo','',316),(642,'Buin','',316),(643,'Calera de Tango','',316),(644,'Paine','',316),(645,'Melipilla','',317),(646,'Alhué','',317),(647,'Curacaví','',317),(648,'María Pinto','',317),(649,'San Pedro','',317),(650,'Talagante','',318),(651,'El Monte','',318),(652,'Isla de Maipo','',318),(653,'Padre Hurtado','',318),(654,'Peñaflor','',318),(655,'Valdivia','',319),(656,'Corral','',319),(657,'Lanco','',319),(658,'Los Lagos','',319),(659,'Máfil','',319),(660,'Mariquina','',319),(661,'Paillaco','',319),(662,'Panguipulli','',319),(663,'La Unión','',320),(664,'Futrono','',320),(665,'Lago Ranco','',320),(666,'Río Bueno','',320);
/*!40000 ALTER TABLE `zona` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-06 10:40:11
