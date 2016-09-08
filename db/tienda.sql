-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tienda
-- ------------------------------------------------------
-- Server version	5.5.47-0+deb7u1

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
-- Table structure for table `atributo`
--

DROP TABLE IF EXISTS `atributo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atributo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `descripcion` text,
  `idCategoria` int(11) NOT NULL,
  `esFiltro` int(11) DEFAULT '0',
  `esGrupo` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributo`
--

LOCK TABLES `atributo` WRITE;
/*!40000 ALTER TABLE `atributo` DISABLE KEYS */;
/*!40000 ALTER TABLE `atributo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atributo_producto`
--

DROP TABLE IF EXISTS `atributo_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atributo_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `idAtributo` int(11) NOT NULL,
  `valor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributo_producto`
--

LOCK TABLES `atributo_producto` WRITE;
/*!40000 ALTER TABLE `atributo_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `atributo_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `target` varchar(16) DEFAULT NULL,
  `tipo` varchar(120) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `orden` float DEFAULT NULL,
  `imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
INSERT INTO `banner` VALUES (4,'Primer Banner','/preciada-deco',NULL,NULL,NULL,'2016-08-15 21:21:04',NULL,'/assets/20160815212048beautiful-floral-vintage-by-marie-nichols-ft-chicdeco-copia.png'),(8,'Segundo Banner','/preciada-cocina',NULL,NULL,NULL,'2016-08-16 00:28:36',NULL,'/assets/20160816002824elle-lisa-cohen-frenchbydesign1.png'),(9,'Tercer Banner','',NULL,NULL,NULL,'2016-08-16 00:31:15',NULL,'/assets/20160816003108il-570xn-848492214-qwtf.jpg');
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `foto` varchar(255) NOT NULL,
  `cuerpo` text NOT NULL,
  `activo` int(11) DEFAULT '1',
  `autor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carro`
--

DROP TABLE IF EXISTS `carro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` int(11) DEFAULT NULL,
  `fechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total` float DEFAULT NULL,
  `despacho` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=324 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carro`
--

LOCK TABLES `carro` WRITE;
/*!40000 ALTER TABLE `carro` DISABLE KEYS */;
INSERT INTO `carro` VALUES (323,NULL,'2016-09-08 20:00:21',0,0);
/*!40000 ALTER TABLE `carro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `padre` int(11) NOT NULL DEFAULT '-1',
  `activa` int(11) DEFAULT '1',
  `foto` varchar(255) DEFAULT NULL,
  `banner` int(11) DEFAULT NULL,
  `orden` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (-1,'Home',-1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `fono` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `estado` varchar(120) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipo` varchar(120) DEFAULT NULL,
  `llave` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  UNIQUE KEY `llave` (`llave`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'Nombre del Sitio','Preciada',NULL,'2016-07-05 20:13:09','text','nombreSitio'),(2,'URL del Sitio','http://preciada.cl',NULL,'2016-09-08 14:05:37','text','urlSitio'),(3,'URL de Facebook','http://facebook.com',NULL,'2016-07-05 20:13:09','text','facebookURL'),(4,'URL de Twitter','http://twitter.com',NULL,'2016-07-05 20:13:09','text','twitterURL'),(5,'Correo Sitio','pablito.garin@gmail.com',NULL,'2016-07-05 20:13:09','text','cuentaCorreo'),(6,'Clave del Correo','G8r33x5434',NULL,'2016-08-10 16:43:55','password','claveCorreo'),(7,'Servidor de Correo Saliente','smtp.gmail.com',NULL,'2016-07-05 20:13:09','text','servidorCorreo'),(8,'Puerto para Correo','465',NULL,'2016-09-08 15:06:51','text','puertoCorreo'),(9,'Tipo de Seguridad del Correo','ssl',NULL,'2016-07-05 20:13:09','select[ssl,tls]','seguridadCorreo'),(10,'URL de Instragram','http://instagram.com',NULL,'2016-07-05 20:38:15','text','instagramURL'),(11,'Banco','Santander',NULL,'2016-08-29 14:14:04','text','datosBancoNombre'),(12,'Tipo Cuenta','Corriente',NULL,'2016-08-29 14:14:45','text','datosBancoTipo'),(13,'Número de cuenta','0-000-000-0',NULL,'2016-08-29 14:15:21','text','datosBancoNumero'),(14,'Titular Cuenta','Karen Contreras',NULL,'2016-08-29 14:29:38','text','datosBancoTitular'),(15,'RUT Titular','11.111.111-1',NULL,'2016-08-29 14:30:54','text','datosBancoRUTTitular');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(120) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(160) NOT NULL,
  `fono` varchar(16) NOT NULL,
  `mensaje` text,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `correo_venta`
--

DROP TABLE IF EXISTS `correo_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `correo_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asunto` varchar(120) NOT NULL,
  `cuerpo` text NOT NULL,
  `adjunto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `correo_venta`
--

LOCK TABLES `correo_venta` WRITE;
/*!40000 ALTER TABLE `correo_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `correo_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `costo_despacho`
--

DROP TABLE IF EXISTS `costo_despacho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `costo_despacho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idZona` int(11) NOT NULL,
  `costo` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `costo_despacho`
--

LOCK TABLES `costo_despacho` WRITE;
/*!40000 ALTER TABLE `costo_despacho` DISABLE KEYS */;
INSERT INTO `costo_despacho` VALUES (1,616,2000),(2,603,2000),(3,604,2000),(4,606,2000),(5,607,2000);
/*!40000 ALTER TABLE `costo_despacho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupon`
--

DROP TABLE IF EXISTS `cupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(120) NOT NULL,
  `codigo` varchar(120) NOT NULL,
  `fechaInicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaFin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activo` int(11) DEFAULT '1',
  `giftcard` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupon`
--

LOCK TABLES `cupon` WRITE;
/*!40000 ALTER TABLE `cupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupon_producto`
--

DROP TABLE IF EXISTS `cupon_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cupon_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCupon` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `descuento` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupon_producto`
--

LOCK TABLES `cupon_producto` WRITE;
/*!40000 ALTER TABLE `cupon_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupon_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupon_venta`
--

DROP TABLE IF EXISTS `cupon_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cupon_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCupon` int(11) DEFAULT NULL,
  `idVenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupon_venta`
--

LOCK TABLES `cupon_venta` WRITE;
/*!40000 ALTER TABLE `cupon_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `cupon_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destacado`
--

DROP TABLE IF EXISTS `destacado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destacado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(120) NOT NULL,
  `activo` int(11) DEFAULT '1',
  `fechaInicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaFin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mostrarHome` int(11) DEFAULT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destacado`
--

LOCK TABLES `destacado` WRITE;
/*!40000 ALTER TABLE `destacado` DISABLE KEYS */;
/*!40000 ALTER TABLE `destacado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `receptorNombre` varchar(255) NOT NULL,
  `receptorApellido` varchar(255) NOT NULL,
  `nombreEmpresa` varchar(255) DEFAULT NULL,
  `facturacion` int(11) DEFAULT '0',
  `principal` int(11) DEFAULT '0',
  `idCliente` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `fono` varchar(16) DEFAULT NULL,
  `cel` varchar(16) DEFAULT NULL,
  `idZona` int(11) NOT NULL,
  `cod_destinatario_SAP` text,
  `retiro` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elemento_slider_categoria`
--

DROP TABLE IF EXISTS `elemento_slider_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elemento_slider_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idSlider` int(11) NOT NULL,
  `idRecurso` int(11) NOT NULL,
  `orden` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elemento_slider_categoria`
--

LOCK TABLES `elemento_slider_categoria` WRITE;
/*!40000 ALTER TABLE `elemento_slider_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `elemento_slider_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `razonSocial` varchar(255) NOT NULL,
  `rut` varchar(16) NOT NULL,
  `giro` varchar(255) DEFAULT NULL,
  `fono` varchar(16) DEFAULT NULL,
  `faz` varchar(16) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `idCliente` int(11) NOT NULL,
  `idDireccion` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) NOT NULL,
  `correo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'Ingresada',NULL),(2,'Rechazada',NULL),(3,'Anulada',NULL),(4,'Aceptada',NULL),(5,'Pagada',NULL),(6,'En Preparacion para Envio',NULL),(7,'Despachada',NULL);
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVenta` int(11) DEFAULT NULL,
  `razon_social` text,
  `rut` text,
  `giro` text,
  `idZona` int(11) DEFAULT NULL,
  `fono` text,
  `correo` text,
  `direccion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galeria_texto`
--

DROP TABLE IF EXISTS `galeria_texto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galeria_texto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idTexto` int(11) NOT NULL,
  `idRecurso` int(11) NOT NULL,
  `orden` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeria_texto`
--

LOCK TABLES `galeria_texto` WRITE;
/*!40000 ALTER TABLE `galeria_texto` DISABLE KEYS */;
/*!40000 ALTER TABLE `galeria_texto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giftcard`
--

DROP TABLE IF EXISTS `giftcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giftcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `monto` float NOT NULL,
  `archivo` text,
  `estado` char(1) DEFAULT 'A',
  `fechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaUso` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idCliente` int(11) DEFAULT NULL,
  `idVenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giftcard`
--

LOCK TABLES `giftcard` WRITE;
/*!40000 ALTER TABLE `giftcard` DISABLE KEYS */;
/*!40000 ALTER TABLE `giftcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_venta`
--

DROP TABLE IF EXISTS `historial_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVenta` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `fechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_venta`
--

LOCK TABLES `historial_venta` WRITE;
/*!40000 ALTER TABLE `historial_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invitacion`
--

DROP TABLE IF EXISTS `invitacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invitacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `fono` varchar(16) DEFAULT NULL,
  `mensaje` text,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `referente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitacion`
--

LOCK TABLES `invitacion` WRITE;
/*!40000 ALTER TABLE `invitacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `invitacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `foto` int(11) DEFAULT NULL,
  `activo` int(11) DEFAULT '1',
  `orden` float DEFAULT NULL,
  `fotoProductos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta`
--

DROP TABLE IF EXISTS `oferta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oferta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `precio` float DEFAULT '0',
  `fechaInicio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechaFin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `orden` float DEFAULT NULL,
  `maxCantidad` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta`
--

LOCK TABLES `oferta` WRITE;
/*!40000 ALTER TABLE `oferta` DISABLE KEYS */;
/*!40000 ALTER TABLE `oferta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta_producto`
--

DROP TABLE IF EXISTS `oferta_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oferta_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `idOferta` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta_producto`
--

LOCK TABLES `oferta_producto` WRITE;
/*!40000 ALTER TABLE `oferta_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `oferta_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago_venta`
--

DROP TABLE IF EXISTS `pago_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_venta` (
  `TBK_ORDEN_COMPRA` text,
  `TBK_TIPO_TRANSACCION` text,
  `TBK_RESPUESTA` text,
  `TBK_MONTO` text,
  `TBK_CODIGO_AUTORIZACION` text,
  `TBK_FINAL_NUMERO_TARJETA` text,
  `TBK_FECHA_CONTABLE` text,
  `TBK_FECHA_TRANSACCION` text,
  `TBK_HORA_TRANSACCION` text,
  `TBK_ID_SESION` text,
  `TBK_ID_TRANSACCION` text,
  `TBK_TIPO_PAGO` text,
  `TBK_NUMERO_CUOTAS` text,
  `TBK_TASA_INTERES_MAX` text,
  `TBK_VCI` text,
  `TBK_MAC` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_venta`
--

LOCK TABLES `pago_venta` WRITE;
/*!40000 ALTER TABLE `pago_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `pago_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `precio_cliente`
--

DROP TABLE IF EXISTS `precio_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `precio_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `precio` float NOT NULL,
  `tipoCliente` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `precio_cliente`
--

LOCK TABLES `precio_cliente` WRITE;
/*!40000 ALTER TABLE `precio_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `precio_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  `resumen` varchar(128) NOT NULL,
  `descripcion` text,
  `SKU` varchar(120) NOT NULL,
  `color` text,
  `tags` text,
  `stock` int(11) DEFAULT '0',
  `marca` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `archivo` int(11) DEFAULT NULL,
  `precio` float DEFAULT '0',
  `precioReferencia` float DEFAULT '0',
  `iva` int(11) DEFAULT '1',
  `activo` int(11) DEFAULT '1',
  `disponible` int(11) DEFAULT '1',
  `pack` int(11) DEFAULT '0',
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `orden` float DEFAULT '0',
  `minimo` int(11) DEFAULT '1',
  `entrega` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `SKU` (`SKU`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_bkup`
--

DROP TABLE IF EXISTS `producto_bkup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_bkup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  `descripcion` text,
  `SKU` varchar(120) NOT NULL,
  `tags` text,
  `stock` int(11) DEFAULT '0',
  `marca` int(11) NOT NULL,
  `idViniard` int(11) DEFAULT NULL,
  `foto` int(11) DEFAULT NULL,
  `archivo` int(11) DEFAULT NULL,
  `precio` float DEFAULT '0',
  `precioReferencia` float DEFAULT '0',
  `iva` int(11) DEFAULT '1',
  `activo` int(11) DEFAULT '1',
  `disponible` int(11) DEFAULT '1',
  `pack` int(11) DEFAULT '0',
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `orden` float DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `SKU` (`SKU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_bkup`
--

LOCK TABLES `producto_bkup` WRITE;
/*!40000 ALTER TABLE `producto_bkup` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_bkup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_carro`
--

DROP TABLE IF EXISTS `producto_carro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_carro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCarro` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descuento` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5537 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_carro`
--

LOCK TABLES `producto_carro` WRITE;
/*!40000 ALTER TABLE `producto_carro` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_carro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_categoria`
--

DROP TABLE IF EXISTS `producto_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `orden` float DEFAULT NULL,
  `prioridad` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_categoria`
--

LOCK TABLES `producto_categoria` WRITE;
/*!40000 ALTER TABLE `producto_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_destacado`
--

DROP TABLE IF EXISTS `producto_destacado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_destacado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) NOT NULL,
  `idDestacado` int(11) NOT NULL,
  `orden` float DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_destacado`
--

LOCK TABLES `producto_destacado` WRITE;
/*!40000 ALTER TABLE `producto_destacado` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_destacado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurso`
--

DROP TABLE IF EXISTS `recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `mime` varchar(120) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `activo` int(11) DEFAULT '1',
  `utlimaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurso`
--

LOCK TABLES `recurso` WRITE;
/*!40000 ALTER TABLE `recurso` DISABLE KEYS */;
/*!40000 ALTER TABLE `recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_usuario`
--

DROP TABLE IF EXISTS `rol_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_usuario`
--

LOCK TABLES `rol_usuario` WRITE;
/*!40000 ALTER TABLE `rol_usuario` DISABLE KEYS */;
INSERT INTO `rol_usuario` VALUES (1,'ADMIN'),(2,'EDITOR'),(3,'BLOGGER');
/*!40000 ALTER TABLE `rol_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo`
--

DROP TABLE IF EXISTS `seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(120) NOT NULL,
  `title` varchar(120) NOT NULL,
  `descripcion` text,
  `keywords` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slider_categoria`
--

DROP TABLE IF EXISTS `slider_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slider_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoria` int(11) NOT NULL,
  `activo` int(11) DEFAULT '1',
  `orden` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slider_categoria`
--

LOCK TABLES `slider_categoria` WRITE;
/*!40000 ALTER TABLE `slider_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `slider_categoria` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `texto` VALUES (-1,'Home','<p><span style=\"font-size:28px\">&iexcl;Ven a </span></p>\r\n\r\n<p><span style=\"font-size:28px\">Conocernos!</span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style=\"font-size:20px\">Te invitamos a conocer nuestro bazar y sus productos. </span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style=\"font-size:16px\">Ac&aacute; podr&aacute;s encontrar lo que desees para tu casa, siempre con ese estilo vintage que nos encanta...</span></p>\r\n',NULL,'ES',1,NULL),(1,'Contacto','<p><strong>Direcci&oacute;n</strong>: Bartolo Soto 8080, San Miguel, Santiago, RM.</p>\r\n\r\n<p><strong>Fono</strong>: +56 9 9414 9917</p>\r\n\r\n<p><strong>Horario</strong>: 8AM a 6PM</p>\r\n\r\n<p><strong>E-Mail</strong>: pablo.garin@hotmail.com</p>\r\n','contacto','ES',1,NULL),(2,'¿Quiénes Somos?','<p>&ldquo;Encontrar y flecharse con ese objeto especial y &uacute;nico, un tesoro para quedarse con el&hellip;&rdquo; Bajo esta primicia nace Preciada, un bazar online de&nbsp;decoraci&oacute;n&nbsp;fundado con el deseo de descubrir bellos objetos antiguos, nuevos, reciclados y hechos a mano, cl&aacute;sicos y de aire vintage.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Podr&aacute;s encontrar solo piezas &uacute;nicas o bien, muy pocas unidades de objetos como vasos, fuentes, enlozados,&nbsp;pocillos, juegos de platos y tazas, arte, floreros, marcos, y tantos otros, que han sido cuidadosamente elegidos para convertirse en un preciado y &uacute;nico tesoro para preservarlo en el tiempo.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Este es el emprendimiento, que con mi hermana Soledad dese&aacute;bamos hace tiempo concretar. Naci&oacute; de la nada, r&aacute;pido, mirando lo que ten&iacute;amos alrededor y a la vez, viendo que ten&iacute;amos lo m&aacute;s importante, las ganas. Es reflejo de nuestros gustos y anhelos, una clara muestra de las cosas a las que nos gusta poner mucha fuerza y atenci&oacute;n.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Preciada ya esta aqu&iacute;. Solo esperamos que la marcha y la experiencia nos vaya haciendo cada vez mejores, perseverantes y con buenas ideas para perpetuar esto, lo que nos gusta hacer.</p>\r\n','quienesSomos',NULL,1,NULL),(3,'¿Cómo Comprar?','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n','comoComprar',NULL,1,NULL);
/*!40000 ALTER TABLE `texto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo`
--

DROP TABLE IF EXISTS `tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `activo` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo`
--

LOCK TABLES `tipo` WRITE;
/*!40000 ALTER TABLE `tipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_texto`
--

DROP TABLE IF EXISTS `tipo_texto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_texto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_texto`
--

LOCK TABLES `tipo_texto` WRITE;
/*!40000 ALTER TABLE `tipo_texto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_texto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activo` int(11) DEFAULT '1',
  `rol` int(11) NOT NULL,
  `creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','admin',1,1,'2016-07-05 02:37:58');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(120) NOT NULL,
  `esFactura` int(11) DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `costoDespacho` float DEFAULT '0',
  `total` float DEFAULT '0',
  `idCliente` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `idDireccion` int(11) DEFAULT NULL,
  `idEmpresa` int(11) DEFAULT NULL,
  `tipoTransaccionTBK` varchar(120) DEFAULT 'TR_NORMAL',
  `codigoAutorizacionTBK` varchar(120) DEFAULT NULL,
  `idCarro` int(11) NOT NULL,
  `descuento` float DEFAULT '0',
  `notificada` int(11) DEFAULT '0',
  `sync` int(11) DEFAULT '0',
  `cod_venta_SAP` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_detalle`
--

DROP TABLE IF EXISTS `venta_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVenta` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT '1',
  `precio` float NOT NULL,
  `descuento` float DEFAULT '0',
  `incluyeIVA` int(11) DEFAULT '1',
  `paraRegalo` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_detalle`
--

LOCK TABLES `venta_detalle` WRITE;
/*!40000 ALTER TABLE `venta_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zona`
--

DROP TABLE IF EXISTS `zona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `codigo` varchar(3) NOT NULL,
  `padre` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=667 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zona`
--

LOCK TABLES `zona` WRITE;
/*!40000 ALTER TABLE `zona` DISABLE KEYS */;
INSERT INTO `zona` VALUES (-1,'Mundo','N/A',-1),(1,'Australia','AU',-1),(2,'China','CN',-1),(3,'Japan','JP',-1),(4,'Thailand','TH',-1),(5,'India','IN',-1),(6,'Malaysia','MY',-1),(7,'Kore','KR',-1),(8,'Hong Kong','HK',-1),(9,'Taiwan','TW',-1),(10,'Philippines','PH',-1),(11,'Vietnam','VN',-1),(12,'France','FR',-1),(13,'Europe','EU',-1),(14,'Germany','DE',-1),(15,'Sweden','SE',-1),(16,'Italy','IT',-1),(17,'Greece','GR',-1),(18,'Spain','ES',-1),(19,'Austria','AT',-1),(20,'United Kingdom','GB',-1),(21,'Netherlands','NL',-1),(22,'Belgium','BE',-1),(23,'Switzerland','CH',-1),(24,'United Arab Emirates','AE',-1),(25,'Israel','IL',-1),(26,'Ukraine','UA',-1),(27,'Russian Federation','RU',-1),(28,'Kazakhstan','KZ',-1),(29,'Portugal','PT',-1),(30,'Saudi Arabia','SA',-1),(31,'Denmark','DK',-1),(32,'Ira','IR',-1),(33,'Norway','NO',-1),(34,'United States','US',-1),(35,'Mexico','MX',-1),(36,'Canada','CA',-1),(37,'Anonymous Proxy','A1',-1),(38,'Syrian Arab Republic','SY',-1),(39,'Cyprus','CY',-1),(40,'Czech Republic','CZ',-1),(41,'Iraq','IQ',-1),(42,'Turkey','TR',-1),(43,'Romania','RO',-1),(44,'Lebanon','LB',-1),(45,'Hungary','HU',-1),(46,'Georgia','GE',-1),(47,'Brazil','BR',-1),(48,'Azerbaijan','AZ',-1),(49,'Satellite Provider','A2',-1),(50,'Palestinian Territory','PS',-1),(51,'Lithuania','LT',-1),(52,'Oman','OM',-1),(53,'Slovakia','SK',-1),(54,'Serbia','RS',-1),(55,'Finland','FI',-1),(56,'Iceland','IS',-1),(57,'Bulgaria','BG',-1),(58,'Slovenia','SI',-1),(59,'Moldov','MD',-1),(60,'Macedonia','MK',-1),(61,'Liechtenstein','LI',-1),(62,'Jersey','JE',-1),(63,'Poland','PL',-1),(64,'Croatia','HR',-1),(65,'Bosnia and Herzegovina','BA',-1),(66,'Estonia','EE',-1),(67,'Latvia','LV',-1),(68,'Jordan','JO',-1),(69,'Kyrgyzstan','KG',-1),(70,'Reunion','RE',-1),(71,'Ireland','IE',-1),(72,'Libya','LY',-1),(73,'Luxembourg','LU',-1),(74,'Armenia','AM',-1),(75,'Virgin Island','VG',-1),(76,'Yemen','YE',-1),(77,'Belarus','BY',-1),(78,'Gibraltar','GI',-1),(79,'Martinique','MQ',-1),(80,'Panama','PA',-1),(81,'Dominican Republic','DO',-1),(82,'Guam','GU',-1),(83,'Puerto Rico','PR',-1),(84,'Virgin Island','VI',-1),(85,'Mongolia','MN',-1),(86,'New Zealand','NZ',-1),(87,'Singapore','SG',-1),(88,'Indonesia','ID',-1),(89,'Nepal','NP',-1),(90,'Papua New Guinea','PG',-1),(91,'Pakistan','PK',-1),(92,'Asia/Pacific Region','AP',-1),(93,'Bahamas','BS',-1),(94,'Saint Lucia','LC',-1),(95,'Argentina','AR',-1),(96,'Bangladesh','BD',-1),(97,'Tokelau','TK',-1),(98,'Cambodia','KH',-1),(99,'Macau','MO',-1),(100,'Maldives','MV',-1),(101,'Afghanistan','AF',-1),(102,'New Caledonia','NC',-1),(103,'Fiji','FJ',-1),(104,'Wallis and Futuna','WF',-1),(105,'Qatar','QA',-1),(106,'Albania','AL',-1),(107,'Belize','BZ',-1),(108,'Uzbekistan','UZ',-1),(109,'Kuwait','KW',-1),(110,'Montenegro','ME',-1),(111,'Peru','PE',-1),(112,'Bermuda','BM',-1),(113,'Curacao','CW',-1),(114,'Colombia','CO',-1),(115,'Venezuela','VE',-1),(116,'Chile','CL',-1),(117,'Ecuador','EC',-1),(118,'South Africa','ZA',-1),(119,'Isle of Man','IM',-1),(120,'Bolivia','BO',-1),(121,'Guernsey','GG',-1),(122,'Malta','MT',-1),(123,'Tajikistan','TJ',-1),(124,'Seychelles','SC',-1),(125,'Bahrain','BH',-1),(126,'Egypt','EG',-1),(127,'Zimbabwe','ZW',-1),(128,'Liberia','LR',-1),(129,'Kenya','KE',-1),(130,'Ghana','GH',-1),(131,'Nigeria','NG',-1),(132,'Tanzani','TZ',-1),(133,'Zambia','ZM',-1),(134,'Madagascar','MG',-1),(135,'Angola','AO',-1),(136,'Namibia','NA',-1),(137,'Cote D´Ivoire','CI',-1),(138,'Sudan','SD',-1),(139,'Cameroon','CM',-1),(140,'Malawi','MW',-1),(141,'Gabon','GA',-1),(142,'Mali','ML',-1),(143,'Benin','BJ',-1),(144,'Chad','TD',-1),(145,'Botswana','BW',-1),(146,'Cape Verde','CV',-1),(147,'Rwanda','RW',-1),(148,'Congo','CG',-1),(149,'Uganda','UG',-1),(150,'Mozambique','MZ',-1),(151,'Gambia','GM',-1),(152,'Lesotho','LS',-1),(153,'Mauritius','MU',-1),(154,'Morocco','MA',-1),(155,'Algeria','DZ',-1),(156,'Guinea','GN',-1),(157,'Cong','CD',-1),(158,'Swaziland','SZ',-1),(159,'Burkina Faso','BF',-1),(160,'Sierra Leone','SL',-1),(161,'Somalia','SO',-1),(162,'Niger','NE',-1),(163,'Central African Republic','CF',-1),(164,'Togo','TG',-1),(165,'Burundi','BI',-1),(166,'Equatorial Guinea','GQ',-1),(167,'South Sudan','SS',-1),(168,'Senegal','SN',-1),(169,'Mauritania','MR',-1),(170,'Djibouti','DJ',-1),(171,'Comoros','KM',-1),(172,'British Indian Ocean Territory','IO',-1),(173,'Tunisia','TN',-1),(174,'Greenland','GL',-1),(175,'Holy See (Vatican City State)','VA',-1),(176,'Costa Rica','CR',-1),(177,'Cayman Islands','KY',-1),(178,'Jamaica','JM',-1),(179,'Guatemala','GT',-1),(180,'Marshall Islands','MH',-1),(181,'Antarctica','AQ',-1),(182,'Barbados','BB',-1),(183,'Aruba','AW',-1),(184,'Monaco','MC',-1),(185,'Anguilla','AI',-1),(186,'Saint Kitts and Nevis','KN',-1),(187,'Grenada','GD',-1),(188,'Paraguay','PY',-1),(189,'Montserrat','MS',-1),(190,'Turks and Caicos Islands','TC',-1),(191,'Antigua and Barbuda','AG',-1),(192,'Tuvalu','TV',-1),(193,'French Polynesia','PF',-1),(194,'Solomon Islands','SB',-1),(195,'Vanuatu','VU',-1),(196,'Eritrea','ER',-1),(197,'Trinidad and Tobago','TT',-1),(198,'Andorra','AD',-1),(199,'Haiti','HT',-1),(200,'Saint Helena','SH',-1),(201,'Micronesi','FM',-1),(202,'El Salvador','SV',-1),(203,'Honduras','HN',-1),(204,'Uruguay','UY',-1),(205,'Sri Lanka','LK',-1),(206,'Western Sahara','EH',-1),(207,'Christmas Island','CX',-1),(208,'Samoa','WS',-1),(209,'Suriname','SR',-1),(210,'Cook Islands','CK',-1),(211,'Kiribati','KI',-1),(212,'Niue','NU',-1),(213,'Tonga','TO',-1),(214,'French Southern Territories','TF',-1),(215,'Mayotte','YT',-1),(216,'Norfolk Island','NF',-1),(217,'Brunei Darussalam','BN',-1),(218,'Turkmenistan','TM',-1),(219,'Pitcairn Islands','PN',-1),(220,'San Marino','SM',-1),(221,'Aland Islands','AX',-1),(222,'Faroe Islands','FO',-1),(223,'Svalbard and Jan Mayen','SJ',-1),(224,'Cocos (Keeling) Islands','CC',-1),(225,'Nauru','NR',-1),(226,'South Georgia and the South Sandwich Islands','GS',-1),(227,'United States Minor Outlying Islands','UM',-1),(228,'Guinea-Bissau','GW',-1),(229,'Palau','PW',-1),(230,'American Samoa','AS',-1),(231,'Bhutan','BT',-1),(232,'French Guiana','GF',-1),(233,'Guadeloupe','GP',-1),(234,'Saint Martin','MF',-1),(235,'Saint Vincent and the Grenadines','VC',-1),(236,'Saint Pierre and Miquelon','PM',-1),(237,'Saint Barthelemy','BL',-1),(238,'Dominica','DM',-1),(239,'Sao Tome and Principe','ST',-1),(240,'Kore','KP',-1),(241,'Falkland Islands (Malvinas)','FK',-1),(242,'Northern Mariana Islands','MP',-1),(243,'Timor-Leste','TL',-1),(244,'Bonair','BQ',-1),(245,'Myanmar','MM',-1),(246,'Nicaragua','NI',-1),(247,'Sint Maarten (Dutch part)','SX',-1),(248,'Guyana','GY',-1),(249,'Lao People´s Democratic Republic','LA',-1),(250,'Cuba','CU',-1),(251,'Ethiopia','ET',-1),(252,'Arica y Parinacota','',116),(253,'Tarapacá','',116),(254,'Antofagasta','',116),(255,'Atacama','',116),(256,'Coquimbo','',116),(257,'Valparaíso','',116),(258,'Región del Libertador Gral. Bernardo O’Higgins','',116),(259,'Región del Maule','',116),(260,'Región del Biobío','',116),(261,'Región de la Araucanía','',116),(262,'Región de Los Lagos','',116),(263,'Región Aisén del Gral. Carlos Ibáñez del Campo','',116),(264,'Región de Magallanes y de la Antártica Chilena','',116),(265,'Región Metropolitana de Santiago','',116),(266,'Región de Los Ríos','',116),(267,'Arica','',252),(268,'Parinacota','',252),(269,'Iquique','',253),(270,'Tamarugal','',253),(271,'Antofagasta','',254),(272,'El Loa','',254),(273,'Tocopilla','',254),(274,'Copiapó','',255),(275,'Chañaral','',255),(276,'Huasco','',255),(277,'Elqui','',256),(278,'Choapa','',256),(279,'Limarí','',256),(280,'Valparaíso','',257),(281,'Isla de Pascua','',257),(282,'Los Andes','',257),(283,'Petorca','',257),(284,'Quillota','',257),(285,'San Antonio','',257),(286,'San Felipe de Aconcagua','',257),(287,'Marga Marga','',257),(288,'Cachapoal','',258),(289,'Cardenal Caro','',258),(290,'Colchagua','',258),(291,'Talca','',259),(292,'Cauquenes','',259),(293,'Curicó','',259),(294,'Linares','',259),(295,'Concepción','',260),(296,'Arauco','',260),(297,'Biobío','',260),(298,'Ñuble','',260),(299,'Cautín','',261),(300,'Malleco','',261),(301,'Llanquihue','',262),(302,'Chiloé','',262),(303,'Osorno','',262),(304,'Palena','',262),(305,'Coihaique','',263),(306,'Aisén','',263),(307,'Capitán Prat','',263),(308,'General Carrera','',263),(309,'Magallanes','',264),(310,'Antártica Chilena','',264),(311,'Tierra del Fuego','',264),(312,'Última Esperanza','',264),(313,'Santiago','',265),(314,'Cordillera','',265),(315,'Chacabuco','',265),(316,'Maipo','',265),(317,'Melipilla','',265),(318,'Talagante','',265),(319,'Valdivia','',266),(320,'Ranco','',266),(321,'Arica','',267),(322,'Camarones','',267),(323,'Putre','',268),(324,'General Lagos','',268),(325,'Iquique','',269),(326,'Alto Hospicio','',269),(327,'Pozo Almonte','',270),(328,'Camiña','',270),(329,'Colchane','',270),(330,'Huara','',270),(331,'Pica','',270),(332,'Antofagasta','',271),(333,'Mejillones','',271),(334,'Sierra Gorda','',271),(335,'Taltal','',271),(336,'Calama','',272),(337,'Ollagüe','',272),(338,'San Pedro de Atacama','',272),(339,'Tocopilla','',273),(340,'María Elena','',273),(341,'Copiapó','',274),(342,'Caldera','',274),(343,'Tierra Amarilla','',274),(344,'Chañaral','',275),(345,'Diego de Almagro','',275),(346,'Vallenar','',276),(347,'Alto del Carmen','',276),(348,'Freirina','',276),(349,'Huasco','',276),(350,'La Serena','',277),(351,'Coquimbo','',277),(352,'Andacollo','',277),(353,'La Higuera','',277),(354,'Paiguano','',277),(355,'Vicuña','',277),(356,'Illapel','',278),(357,'Canela','',278),(358,'Los Vilos','',278),(359,'Salamanca','',278),(360,'Ovalle','',279),(361,'Combarbalá','',279),(362,'Monte Patria','',279),(363,'Punitaqui','',279),(364,'Río Hurtado','',279),(365,'Valparaíso','',280),(366,'Casablanca','',280),(367,'Concón','',280),(368,'Juan Fernández','',280),(369,'Puchuncaví','',280),(370,'Quintero','',280),(371,'Viña del Mar','',280),(372,'Isla de Pascua','',281),(373,'Los Andes','',282),(374,'Calle Larga','',282),(375,'Rinconada','',282),(376,'San Esteban','',282),(377,'La Ligua','',283),(378,'Cabildo','',283),(379,'Papudo','',283),(380,'Petorca','',283),(381,'Zapallar','',283),(382,'Quillota','',284),(383,'Calera','',284),(384,'Hijuelas','',284),(385,'La Cruz','',284),(386,'Nogales','',284),(387,'San Antonio','',285),(388,'Algarrobo','',285),(389,'Cartagena','',285),(390,'El Quisco','',285),(391,'El Tabo','',285),(392,'Santo Domingo','',285),(393,'San Felipe','',286),(394,'Catemu','',286),(395,'Llaillay','',286),(396,'Panquehue','',286),(397,'Putaendo','',286),(398,'Santa María','',286),(399,'Quilpué','',287),(400,'Limache','',287),(401,'Olmué','',287),(402,'Villa Alemana','',287),(403,'Rancagua','',288),(404,'Codegua','',288),(405,'Coinco','',288),(406,'Coltauco','',288),(407,'Doñihue','',288),(408,'Graneros','',288),(409,'Las Cabras','',288),(410,'Machalí','',288),(411,'Malloa','',288),(412,'Mostazal','',288),(413,'Olivar','',288),(414,'Peumo','',288),(415,'Pichidegua','',288),(416,'Quinta de Tilcoco','',288),(417,'Rengo','',288),(418,'Requínoa','',288),(419,'San Vicente','',288),(420,'Pichilemu','',289),(421,'La Estrella','',289),(422,'Litueche','',289),(423,'Marchihue','',289),(424,'Navidad','',289),(425,'Paredones','',289),(426,'San Fernando','',290),(427,'Chépica','',290),(428,'Chimbarongo','',290),(429,'Lolol','',290),(430,'Nancagua','',290),(431,'Palmilla','',290),(432,'Peralillo','',290),(433,'Placilla','',290),(434,'Pumanque','',290),(435,'Santa Cruz','',290),(436,'Talca','',291),(437,'Constitución','',291),(438,'Curepto','',291),(439,'Empedrado','',291),(440,'Maule','',291),(441,'Pelarco','',291),(442,'Pencahue','',291),(443,'Río Claro','',291),(444,'San Clemente','',291),(445,'San Rafael','',291),(446,'Cauquenes','',292),(447,'Chanco','',292),(448,'Pelluhue','',292),(449,'Curicó','',293),(450,'Hualañé','',293),(451,'Licantén','',293),(452,'Molina','',293),(453,'Rauco','',293),(454,'Romeral','',293),(455,'Sagrada Familia','',293),(456,'Teno','',293),(457,'Vichuquén','',293),(458,'Linares','',294),(459,'Colbún','',294),(460,'Longaví','',294),(461,'Parral','',294),(462,'Retiro','',294),(463,'San Javier','',294),(464,'Villa Alegre','',294),(465,'Yerbas Buenas','',294),(466,'Concepción','',295),(467,'Coronel','',295),(468,'Chiguayante','',295),(469,'Florida','',295),(470,'Hualqui','',295),(471,'Lota','',295),(472,'Penco','',295),(473,'San Pedro de la Paz','',295),(474,'Santa Juana','',295),(475,'Talcahuano','',295),(476,'Tomé','',295),(477,'Hualpén','',295),(478,'Lebu','',296),(479,'Arauco','',296),(480,'Cañete','',296),(481,'Contulmo','',296),(482,'Curanilahue','',296),(483,'Los Álamos','',296),(484,'Tirúa','',296),(485,'Los Ángeles','',297),(486,'Antuco','',297),(487,'Cabrero','',297),(488,'Laja','',297),(489,'Mulchén','',297),(490,'Nacimiento','',297),(491,'Negrete','',297),(492,'Quilaco','',297),(493,'Quilleco','',297),(494,'San Rosendo','',297),(495,'Santa Bárbara','',297),(496,'Tucapel','',297),(497,'Yumbel','',297),(498,'Alto Biobío','',297),(499,'Chillán','',298),(500,'Bulnes','',298),(501,'Cobquecura','',298),(502,'Coelemu','',298),(503,'Coihueco','',298),(504,'Chillán Viejo','',298),(505,'El Carmen','',298),(506,'Ninhue','',298),(507,'Ñiquén','',298),(508,'Pemuco','',298),(509,'Pinto','',298),(510,'Portezuelo','',298),(511,'Quillón','',298),(512,'Quirihue','',298),(513,'Ránquil','',298),(514,'San Carlos','',298),(515,'San Fabián','',298),(516,'San Ignacio','',298),(517,'San Nicolás','',298),(518,'Treguaco','',298),(519,'Yungay','',298),(520,'Temuco','',299),(521,'Carahue','',299),(522,'Cunco','',299),(523,'Curarrehue','',299),(524,'Freire','',299),(525,'Galvarino','',299),(526,'Gorbea','',299),(527,'Lautaro','',299),(528,'Loncoche','',299),(529,'Melipeuco','',299),(530,'Nueva Imperial','',299),(531,'Padre las Casas','',299),(532,'Perquenco','',299),(533,'Pitrufquén','',299),(534,'Pucón','',299),(535,'Saavedra','',299),(536,'Teodoro Schmidt','',299),(537,'Toltén','',299),(538,'Vilcún','',299),(539,'Villarrica','',299),(540,'Cholchol','',299),(541,'Angol','',300),(542,'Collipulli','',300),(543,'Curacautín','',300),(544,'Ercilla','',300),(545,'Lonquimay','',300),(546,'Los Sauces','',300),(547,'Lumaco','',300),(548,'Purén','',300),(549,'Renaico','',300),(550,'Traiguén','',300),(551,'Victoria','',300),(552,'Puerto Montt','',301),(553,'Calbuco','',301),(554,'Cochamó','',301),(555,'Fresia','',301),(556,'Frutillar','',301),(557,'Los Muermos','',301),(558,'Llanquihue','',301),(559,'Maullín','',301),(560,'Puerto Varas','',301),(561,'Castro','',302),(562,'Ancud','',302),(563,'Chonchi','',302),(564,'Curaco de Vélez','',302),(565,'Dalcahue','',302),(566,'Puqueldón','',302),(567,'Queilén','',302),(568,'Quellón','',302),(569,'Quemchi','',302),(570,'Quinchao','',302),(571,'Osorno','',303),(572,'Puerto Octay','',303),(573,'Purranque','',303),(574,'Puyehue','',303),(575,'Río Negro','',303),(576,'San Juan de la Costa','',303),(577,'San Pablo','',303),(578,'Chaitén','',304),(579,'Futaleufú','',304),(580,'Hualaihué','',304),(581,'Palena','',304),(582,'Coihaique','',305),(583,'Lago Verde','',305),(584,'Aisén','',306),(585,'Cisnes','',306),(586,'Guaitecas','',306),(587,'Cochrane','',307),(588,'O’Higgins','',307),(589,'Tortel','',307),(590,'Chile Chico','',308),(591,'Río Ibáñez','',308),(592,'Punta Arenas','',309),(593,'Laguna Blanca','',309),(594,'Río Verde','',309),(595,'San Gregorio','',309),(596,'Cabo de Hornos','',310),(597,'Antártica','',310),(598,'Porvenir','',311),(599,'Primavera','',311),(600,'Timaukel','',311),(601,'Natales','',312),(602,'Torres del Paine','',312),(603,'Santiago','',313),(604,'Cerrillos','',313),(605,'Cerro Navia','',313),(606,'Conchalí','',313),(607,'El Bosque','',313),(608,'Estación Central','',313),(609,'Huechuraba','',313),(610,'Independencia','',313),(611,'La Cisterna','',313),(612,'La Florida','',313),(613,'La Granja','',313),(614,'La Pintana','',313),(615,'La Reina','',313),(616,'Las Condes','',313),(617,'Lo Barnechea','',313),(618,'Lo Espejo','',313),(619,'Lo Prado','',313),(620,'Macul','',313),(621,'Maipú','',313),(622,'Ñuñoa','',313),(623,'Pedro Aguirre Cerda','',313),(624,'Peñalolén','',313),(625,'Providencia','',313),(626,'Pudahuel','',313),(627,'Quilicura','',313),(628,'Quinta Normal','',313),(629,'Recoleta','',313),(630,'Renca','',313),(631,'San Joaquín','',313),(632,'San Miguel','',313),(633,'San Ramón','',313),(634,'Vitacura','',313),(635,'Puente Alto','',314),(636,'Pirque','',314),(637,'San José de Maipo','',314),(638,'Colina','',315),(639,'Lampa','',315),(640,'Tiltil','',315),(641,'San Bernardo','',316),(642,'Buin','',316),(643,'Calera de Tango','',316),(644,'Paine','',316),(645,'Melipilla','',317),(646,'Alhué','',317),(647,'Curacaví','',317),(648,'María Pinto','',317),(649,'San Pedro','',317),(650,'Talagante','',318),(651,'El Monte','',318),(652,'Isla de Maipo','',318),(653,'Padre Hurtado','',318),(654,'Peñaflor','',318),(655,'Valdivia','',319),(656,'Corral','',319),(657,'Lanco','',319),(658,'Los Lagos','',319),(659,'Máfil','',319),(660,'Mariquina','',319),(661,'Paillaco','',319),(662,'Panguipulli','',319),(663,'La Unión','',320),(664,'Futrono','',320),(665,'Lago Ranco','',320),(666,'Río Bueno','',320);
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

-- Dump completed on 2016-09-08 20:05:28
