-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: fondo_solidario_jaec
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.22.04.1

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
-- Table structure for table `accidente_alumnos`
--

DROP TABLE IF EXISTS `accidente_alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accidente_alumnos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_accidente` int NOT NULL,
  `id_alumno` int NOT NULL,
  `grado_seccion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_accidente_alumno` (`id_accidente`,`id_alumno`),
  KEY `id_alumno` (`id_alumno`),
  CONSTRAINT `accidente_alumnos_ibfk_1` FOREIGN KEY (`id_accidente`) REFERENCES `accidentes` (`id_accidente`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `accidente_alumnos_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accidente_alumnos`
--

LOCK TABLES `accidente_alumnos` WRITE;
/*!40000 ALTER TABLE `accidente_alumnos` DISABLE KEYS */;
INSERT INTO `accidente_alumnos` VALUES (1,1,1,NULL,'2026-03-27 01:04:03',NULL),(2,1,2,NULL,'2026-03-27 01:04:03',NULL),(3,2,3,NULL,'2026-03-27 01:04:03',NULL),(4,2,4,NULL,'2026-03-27 01:04:03',NULL);
/*!40000 ALTER TABLE `accidente_alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accidentes`
--

DROP TABLE IF EXISTS `accidentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accidentes` (
  `id_accidente` int NOT NULL AUTO_INCREMENT,
  `numero_expediente` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_escuela` int NOT NULL,
  `id_usuario_carga` int NOT NULL,
  `fecha_accidente` date NOT NULL,
  `hora_accidente` time DEFAULT NULL,
  `lugar_accidente` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_accidente` text COLLATE utf8mb4_unicode_ci,
  `tipo_lesion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protocolo_activado` tinyint(1) DEFAULT '0',
  `llamada_emergencia` tinyint(1) DEFAULT '0',
  `hora_llamada` time DEFAULT NULL,
  `servicio_emergencia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_estado_accidente` int DEFAULT NULL,
  `fecha_carga` datetime DEFAULT NULL,
  PRIMARY KEY (`id_accidente`),
  UNIQUE KEY `uk_numero_expediente` (`numero_expediente`),
  UNIQUE KEY `numero_expediente` (`numero_expediente`),
  KEY `idx_accidentes_fecha_escuela` (`fecha_accidente`,`id_escuela`),
  KEY `idx_escuela` (`id_escuela`),
  KEY `id_usuario_carga` (`id_usuario_carga`),
  KEY `idx_fecha` (`fecha_accidente`),
  KEY `idx_estado_accidente` (`id_estado_accidente`),
  CONSTRAINT `accidentes_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `accidentes_ibfk_3` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_accidentes_estado` FOREIGN KEY (`id_estado_accidente`) REFERENCES `cat_estados_accidentes` (`id_estado_accidente`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accidentes`
--

LOCK TABLES `accidentes` WRITE;
/*!40000 ALTER TABLE `accidentes` DISABLE KEYS */;
INSERT INTO `accidentes` VALUES (1,NULL,1,3,'2026-03-16','10:30:00','Patio de juegos','Caída durante el recreo.','Raspadura en rodilla',1,1,'10:35:00','Emergencias JAEC',1,'2026-03-26 22:04:03'),(2,NULL,2,4,'2026-03-21','14:15:00','Gimnasio','Golpe con una pelota en clase de educación física.','Contusión en el brazo',1,1,'14:20:00','Emergencias JAEC',1,'2026-03-26 22:04:03');
/*!40000 ALTER TABLE `accidentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id_alumno` int NOT NULL AUTO_INCREMENT,
  `id_escuela` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuil` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sala_grado_curso` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familiar1` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parentesco1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familiar2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parentesco2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familiar3` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parentesco3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto3` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `obra_social` text COLLATE utf8mb4_unicode_ci,
  `deportes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_alumno`),
  UNIQUE KEY `uk_dni` (`dni`),
  UNIQUE KEY `uk_cuil` (`cuil`),
  KEY `idx_nombre_apellido` (`nombre`,`apellido`),
  KEY `idx_escuela` (`id_escuela`),
  KEY `idx_activo` (`activo`),
  CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (1,1,'Juan','Perez','12345678','20-12345678-1','5to Grado A','Maria Lopez','Madre','111-111111','Pedro Lopez','Padre','111-111112','Ana Lopez','Tía','111-111113','2010-05-15',1,NULL,NULL),(2,1,'Ana','Gomez','23456789','27-23456789-5','5to Grado A','Carlos Gomez','Padre','222-222222','Laura Gomez','Madre','222-222223','Roberto Gomez','Abuelo','222-222224','2010-08-20',1,NULL,NULL),(3,2,'Luis','Martinez','34567890','20-34567890-3','6to Grado B','Laura Torres','Madre','333-333333','Miguel Martinez','Padre','333-333334','Carmen Torres','Abuela','333-333335','2009-03-10',1,NULL,NULL),(4,2,'Sofia','Rodriguez','45678901','27-45678901-9','6to Grado B','Roberto Rodriguez','Padre','444-444444','Maria Rodriguez','Madre','444-444445','Luis Rodriguez','Tío','444-444446','2009-11-25',1,NULL,NULL);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos_legacy`
--

DROP TABLE IF EXISTS `alumnos_legacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos_legacy` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dni` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `domicilio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_familiar_responsable` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obra_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deporte_que_practica` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_legacy`
--

LOCK TABLES `alumnos_legacy` WRITE;
/*!40000 ALTER TABLE `alumnos_legacy` DISABLE KEYS */;
INSERT INTO `alumnos_legacy` VALUES (1,'2024-10-16 05:47:42','2024-10-16 05:47:42',16663245,'Jose Eduardo Quintero','1984-09-29','Carretera Vieja Los Teques','+584241783191','No Posee',NULL,NULL),(2,'2024-10-21 19:05:55','2024-10-21 19:08:25',28115912,'JULIETA JUSTICIA',NULL,'ITALIA 2139',NULL,NULL,NULL,NULL),(3,'2024-11-08 17:09:53','2024-11-08 17:09:53',12345679,'Alumno','1984-09-29',NULL,'1234567890','Ninguna','Ninguno','Apellido'),(4,'2024-11-08 17:17:23','2024-11-08 17:17:23',987654321,'Nuevo','2010-01-01',NULL,'1234694987','ninguna','ninguna','Alumno'),(5,'2024-12-13 17:23:42','2024-12-13 17:23:42',41234567,'Jorge Mario','2019-03-13',NULL,'341564789','Ninguna','Futbol','Bergoglio');
/*!40000 ALTER TABLE `alumnos_legacy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos_salidas`
--

DROP TABLE IF EXISTS `alumnos_salidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos_salidas` (
  `id_alumno_salida` int NOT NULL AUTO_INCREMENT,
  `id_salida` int NOT NULL,
  `id_alumno` int NOT NULL,
  `autorizado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_alumno_salida`),
  UNIQUE KEY `uk_salida_alumno` (`id_salida`,`id_alumno`),
  KEY `idx_salida` (`id_salida`),
  KEY `idx_alumno` (`id_alumno`),
  CONSTRAINT `alumnos_salidas_ibfk_1` FOREIGN KEY (`id_salida`) REFERENCES `salidas_educativas` (`id_salida`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `alumnos_salidas_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_salidas`
--

LOCK TABLES `alumnos_salidas` WRITE;
/*!40000 ALTER TABLE `alumnos_salidas` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos_salidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archivos`
--

DROP TABLE IF EXISTS `archivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `denuncias_id` int DEFAULT NULL,
  `etickets_id` int DEFAULT NULL,
  `salidas_id` int DEFAULT NULL,
  `ausentismo_id` int DEFAULT NULL,
  `carpeta_id` int DEFAULT NULL,
  `auditoria_id` int DEFAULT NULL,
  `ficha_id` int DEFAULT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivos`
--

LOCK TABLES `archivos` WRITE;
/*!40000 ALTER TABLE `archivos` DISABLE KEYS */;
INSERT INTO `archivos` VALUES (1,'2024-10-11 05:44:19','2024-10-11 05:44:19',NULL,NULL,NULL,NULL,NULL,NULL,1,'fileuploads/Wlr1od8fs4iJDMtPatX7Y1eX0uTUVnLxjqjsW9vX.jpg'),(2,'2024-10-11 05:48:13','2024-10-11 05:48:13',NULL,NULL,NULL,NULL,NULL,NULL,2,'fileuploads/4eMQM1FzhWtr5u7mnGlzzS5LKQZY4R1fGS0WBCiz.jpg'),(3,'2024-10-11 15:54:53','2024-10-11 15:54:53',NULL,NULL,NULL,NULL,NULL,NULL,3,'fileuploads/WesnIwdNh33LwLNDEy5MRweGdNI0sYuG0K5VgoNb.pdf'),(4,'2024-10-16 05:56:10','2024-10-16 05:56:10',NULL,NULL,NULL,NULL,NULL,NULL,4,'fileuploads/csls8VbXgkegsV3T49En5mQlzwiVT33OFrRSAUSU.pdf'),(5,'2024-10-16 06:35:02','2024-10-16 06:35:02',NULL,NULL,2,NULL,NULL,NULL,NULL,'fileuploads/0L5w0dZMT6cQoFtYydZ4x8u6jUpcybGorSaeAyG4.pdf'),(6,'2024-10-16 06:35:02','2024-10-16 06:35:02',NULL,NULL,2,NULL,NULL,NULL,NULL,'fileuploads/Xib0wf0DpyS2MEB11cBa8y4LukyKJGFA3fsnq3ib.pdf'),(7,'2024-10-16 06:35:02','2024-10-16 06:35:02',NULL,NULL,2,NULL,NULL,NULL,NULL,'fileuploads/cn7KNbxYrhPmkeHG7g27DFAFTqx9QpIjqIbXdf7D.pdf'),(8,'2024-10-16 06:50:47','2024-10-16 06:50:47',NULL,1,NULL,NULL,NULL,NULL,NULL,'fileuploads/6dRxU11z8IWH2BEljRGn52tUQRdM8x873R5QkC9W.jpg'),(9,'2024-10-18 02:00:54','2024-10-18 02:00:54',NULL,NULL,NULL,2,NULL,NULL,NULL,'fileuploads/sburqq8RTozvXAkeZvS9ufIt9Lchmb2Bsn9RPM4N.jpg'),(10,'2024-10-18 02:02:08','2024-10-18 02:02:08',NULL,NULL,NULL,3,NULL,NULL,NULL,'fileuploads/zwJ8Zyz0zPVjeTedSaVpfRwz8Oe8G3TeHBbqCux6.jpg'),(11,'2024-10-18 02:17:48','2024-10-18 02:17:48',NULL,NULL,NULL,NULL,1,NULL,NULL,'fileuploads/AYHygsVUzcxF7r0kNAkPOPWmmVtlLOVM6Cq3qWBQ.jpg');
/*!40000 ALTER TABLE `archivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archivos_adjuntos`
--

DROP TABLE IF EXISTS `archivos_adjuntos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivos_adjuntos` (
  `id_archivo` int NOT NULL AUTO_INCREMENT,
  `tipo_entidad` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_entidad` int NOT NULL,
  `nombre_archivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_archivo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tamano` int DEFAULT NULL,
  `ruta_archivo` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_usuario_carga` int NOT NULL,
  `fecha_carga` datetime DEFAULT NULL,
  PRIMARY KEY (`id_archivo`),
  KEY `idx_entidad` (`tipo_entidad`,`id_entidad`),
  KEY `idx_usuario_carga` (`id_usuario_carga`),
  KEY `idx_fecha_carga` (`fecha_carga`),
  CONSTRAINT `archivos_adjuntos_ibfk_1` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivos_adjuntos`
--

LOCK TABLES `archivos_adjuntos` WRITE;
/*!40000 ALTER TABLE `archivos_adjuntos` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivos_adjuntos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditoria_sistema`
--

DROP TABLE IF EXISTS `auditoria_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria_sistema` (
  `id_auditoria` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `accion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabla_afectada` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_registro` int DEFAULT NULL,
  `datos_anteriores` text COLLATE utf8mb4_unicode_ci,
  `datos_nuevos` text COLLATE utf8mb4_unicode_ci,
  `ip_usuario` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_auditoria`),
  KEY `idx_usuario` (`id_usuario`),
  KEY `idx_fecha_hora` (`fecha_hora`),
  KEY `idx_accion` (`accion`),
  KEY `idx_tabla` (`tabla_afectada`),
  CONSTRAINT `auditoria_sistema_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria_sistema`
--

LOCK TABLES `auditoria_sistema` WRITE;
/*!40000 ALTER TABLE `auditoria_sistema` DISABLE KEYS */;
/*!40000 ALTER TABLE `auditoria_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditorias`
--

DROP TABLE IF EXISTS `auditorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditorias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `denuncia_id` int DEFAULT NULL,
  `carpeta_id` int DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('En Proceso','Completada','Anulada','Interrumpida') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditorias`
--

LOCK TABLES `auditorias` WRITE;
/*!40000 ALTER TABLE `auditorias` DISABLE KEYS */;
INSERT INTO `auditorias` VALUES (1,'2024-10-18 03:27:06','2025-05-31 04:30:40',NULL,NULL,'Memek','En Proceso'),(2,'2024-10-21 19:46:38','2024-10-21 19:46:38',2,NULL,NULL,NULL);
/*!40000 ALTER TABLE `auditorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ausentismo`
--

DROP TABLE IF EXISTS `ausentismo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ausentismo` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `colegios_id` int DEFAULT NULL,
  `personal_id` int DEFAULT NULL,
  `fecha_control` date NOT NULL,
  `requiere_medico` tinyint(1) NOT NULL,
  `junta_medica` tinyint(1) NOT NULL,
  `diagnostico_observaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ausentismo`
--

LOCK TABLES `ausentismo` WRITE;
/*!40000 ALTER TABLE `ausentismo` DISABLE KEYS */;
INSERT INTO `ausentismo` VALUES (1,'2024-10-18 01:52:58','2024-10-18 01:52:58',1,1,'2024-10-17',1,1,'dedsdfsdfgds'),(2,'2024-10-18 02:00:54','2024-10-18 02:00:54',1,1,'2024-10-17',1,1,'dedsdfsdfgds'),(3,'2024-10-18 02:02:08','2024-10-18 02:02:08',4,2,'2024-10-30',1,1,'fvffaSFDsdfasdf');
/*!40000 ALTER TABLE `ausentismo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beneficiarios_svo`
--

DROP TABLE IF EXISTS `beneficiarios_svo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beneficiarios_svo` (
  `id_beneficiario` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `id_escuela` int DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `id_parentesco` int DEFAULT NULL,
  PRIMARY KEY (`id_beneficiario`),
  KEY `idx_empleado` (`id_empleado`),
  KEY `fk_beneficiario_escuela` (`id_escuela`),
  KEY `idx_activo` (`activo`),
  KEY `fk_beneficiarios_parentesco` (`id_parentesco`),
  CONSTRAINT `beneficiarios_svo_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_beneficiario_escuela` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_beneficiarios_parentesco` FOREIGN KEY (`id_parentesco`) REFERENCES `cat_parentescos` (`id_parentesco`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficiarios_svo`
--

LOCK TABLES `beneficiarios_svo` WRITE;
/*!40000 ALTER TABLE `beneficiarios_svo` DISABLE KEYS */;
/*!40000 ALTER TABLE `beneficiarios_svo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carpetas`
--

DROP TABLE IF EXISTS `carpetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carpetas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `colegio_id` int DEFAULT NULL,
  `personal_id` int DEFAULT NULL,
  `tipo_solicitud` enum('Primera vez','Renovación') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aporte` tinyint(1) DEFAULT NULL,
  `art` tinyint(1) DEFAULT NULL,
  `seguimiento_denuncia` enum('Para Seguimiento Institucional','Para Junta Médica') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_inicio_licencia` date DEFAULT NULL,
  `proxima_junta_medica` date DEFAULT NULL,
  `hora_proxima_junta_medica` time DEFAULT NULL,
  `especialidad` enum('Clínica Médica','Ginecología','Oftalmología','Oncología','Otorrinolaringología','Psiquiatría','Traumatología') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnostico_presuntivo` text COLLATE utf8mb4_unicode_ci,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `estado_solicitud` enum('Abierta/En trámite','Cerrada/Finalizada') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carpetas`
--

LOCK TABLES `carpetas` WRITE;
/*!40000 ALTER TABLE `carpetas` DISABLE KEYS */;
INSERT INTO `carpetas` VALUES (1,'2024-10-18 02:17:48','2024-10-18 02:17:48',2,1,'Primera vez',1,0,'Para Seguimiento Institucional','2024-10-31','2024-10-24','10:20:00','Ginecología','werwer','werwer','Abierta/En trámite');
/*!40000 ALTER TABLE `carpetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_estados_accidentes`
--

DROP TABLE IF EXISTS `cat_estados_accidentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_estados_accidentes` (
  `id_estado_accidente` int NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_estado_accidente`),
  UNIQUE KEY `uk_nombre_estado_acc` (`nombre_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_estados_accidentes`
--

LOCK TABLES `cat_estados_accidentes` WRITE;
/*!40000 ALTER TABLE `cat_estados_accidentes` DISABLE KEYS */;
INSERT INTO `cat_estados_accidentes` VALUES (1,'Abierto','El accidente ha sido registrado y está activo.'),(2,'En Investigación','El accidente está siendo investigado.'),(3,'Cerrado','El accidente ha sido resuelto y cerrado.'),(4,'Pendiente Documentación','Se requiere más documentación para el accidente.');
/*!40000 ALTER TABLE `cat_estados_accidentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_estados_reintegros`
--

DROP TABLE IF EXISTS `cat_estados_reintegros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_estados_reintegros` (
  `id_estado_reintegro` int NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_estado_reintegro`),
  UNIQUE KEY `uk_nombre_estado_reint` (`nombre_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_estados_reintegros`
--

LOCK TABLES `cat_estados_reintegros` WRITE;
/*!40000 ALTER TABLE `cat_estados_reintegros` DISABLE KEYS */;
INSERT INTO `cat_estados_reintegros` VALUES (1,'En proceso','La solicitud de reintegro ha sido recibida y está siendo procesada.'),(2,'Requiere Información','Se necesita información adicional para procesar el reintegro.'),(3,'Autorizado','El reintegro ha sido aprobado por el médico auditor.'),(4,'Rechazado','El reintegro ha sido rechazado.'),(5,'Pagado','El reintegro ha sido pagado.');
/*!40000 ALTER TABLE `cat_estados_reintegros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_estados_solicitudes`
--

DROP TABLE IF EXISTS `cat_estados_solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_estados_solicitudes` (
  `id_estado_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_estado_solicitud`),
  UNIQUE KEY `uk_nombre_estado_sol` (`nombre_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_estados_solicitudes`
--

LOCK TABLES `cat_estados_solicitudes` WRITE;
/*!40000 ALTER TABLE `cat_estados_solicitudes` DISABLE KEYS */;
INSERT INTO `cat_estados_solicitudes` VALUES (1,'Pendiente','La solicitud de información está esperando respuesta.'),(2,'Respondida','La solicitud de información ha sido respondida.'),(3,'Cerrada','La solicitud de información ha sido cerrada.');
/*!40000 ALTER TABLE `cat_estados_solicitudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_parentescos`
--

DROP TABLE IF EXISTS `cat_parentescos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_parentescos` (
  `id_parentesco` int NOT NULL AUTO_INCREMENT,
  `nombre_parentesco` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_parentesco`),
  UNIQUE KEY `uk_nombre_parentesco` (`nombre_parentesco`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_parentescos`
--

LOCK TABLES `cat_parentescos` WRITE;
/*!40000 ALTER TABLE `cat_parentescos` DISABLE KEYS */;
INSERT INTO `cat_parentescos` VALUES (1,'Cónyuge'),(5,'Hermano/a'),(2,'Hijo/a'),(4,'Madre'),(6,'Otro'),(3,'Padre');
/*!40000 ALTER TABLE `cat_parentescos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_tipos_documentos`
--

DROP TABLE IF EXISTS `cat_tipos_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_tipos_documentos` (
  `id_tipo_documento` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_documento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_tipo_documento`),
  UNIQUE KEY `uk_nombre_tipo_doc` (`nombre_tipo_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_tipos_documentos`
--

LOCK TABLES `cat_tipos_documentos` WRITE;
/*!40000 ALTER TABLE `cat_tipos_documentos` DISABLE KEYS */;
INSERT INTO `cat_tipos_documentos` VALUES (4,'Certificado de Habilitación'),(5,'Otro'),(2,'Plan de Evacuación'),(3,'Protocolo COVID-19'),(1,'Reglamento Interno');
/*!40000 ALTER TABLE `cat_tipos_documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_tipos_gastos`
--

DROP TABLE IF EXISTS `cat_tipos_gastos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_tipos_gastos` (
  `id_tipo_gasto` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_gasto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo_gasto`),
  UNIQUE KEY `uk_nombre_tipo_gasto` (`nombre_tipo_gasto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_tipos_gastos`
--

LOCK TABLES `cat_tipos_gastos` WRITE;
/*!40000 ALTER TABLE `cat_tipos_gastos` DISABLE KEYS */;
INSERT INTO `cat_tipos_gastos` VALUES (1,'Consulta Médica','Gastos por consulta con un profesional médico.'),(2,'Medicamentos','Gastos por compra de medicamentos recetados.'),(3,'Estudios Médicos','Gastos por estudios y análisis clínicos.'),(4,'Material Ortopédico','Gastos por material ortopédico o de curación.'),(5,'Traslados','Gastos por traslados en ambulancia o similar.'),(6,'Otros','Otros gastos médicos relacionados.');
/*!40000 ALTER TABLE `cat_tipos_gastos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_tipos_prestadores`
--

DROP TABLE IF EXISTS `cat_tipos_prestadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_tipos_prestadores` (
  `id_tipo_prestador` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_prestador` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_tipo_prestador`),
  UNIQUE KEY `uk_nombre_tipo_prestador` (`nombre_tipo_prestador`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_tipos_prestadores`
--

LOCK TABLES `cat_tipos_prestadores` WRITE;
/*!40000 ALTER TABLE `cat_tipos_prestadores` DISABLE KEYS */;
INSERT INTO `cat_tipos_prestadores` VALUES (1,'Clínica','Clínica médica general o especializada.'),(2,'Hospital','Hospital público o privado.'),(3,'Consultorio Médico','Consultorio particular de un médico.'),(4,'Laboratorio de Análisis','Laboratorio para estudios clínicos.'),(5,'Centro de Diagnóstico','Centro especializado en diagnósticos por imágenes.'),(6,'Farmacia','Establecimiento de venta de medicamentos.'),(7,'Servicio de Emergencias','Servicio de atención médica de urgencia.');
/*!40000 ALTER TABLE `cat_tipos_prestadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colegios`
--

DROP TABLE IF EXISTS `colegios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colegios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `institucion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `representante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_representante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_representante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colegios`
--

LOCK TABLES `colegios` WRITE;
/*!40000 ALTER TABLE `colegios` DISABLE KEYS */;
INSERT INTO `colegios` VALUES (1,'0000-00-00 00:00:00','0000-00-00 00:00:00','CENTRO EDUCACIONAL SAN JORGE','Av Maipú 66, Centro, CÓRDOBA','30-54696871-1','CENTRO ORTODOXO','Adriana Moselli','adrianamoselli@hotmail.com','3515454644','Columna4'),(2,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO AMPARO DE MARÍA','Caseros 730, Centro, CÓRDOBA','30-67760112-0','INSTITUTO AMPARO DE MARIA','Rodolfo Tuzzi','rvtuzzi@gmail.com','3517019573',''),(3,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SAN JOSÉ','Independencia 302, Centro, CÓRDOBA','30-67762156-3','COLEGIO SAN JOSE',' Andrés Rojo','rlandresrojo@gmail.com','3516791213',''),(4,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO CATÓLICO SUPERIOR','Av. Velez Sarsfield 539, Nueva Córdoba, CÓRDOBA','30-67761078-2','INSTITUTO CATOLICO SUPERIOR','Graciela Pesci/ Pedro Saravia','graciela_pesci_7@hotmail.com','3515145823',''),(5,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO NUESTRA SEÑORA DE NIEVA','Ayacucho 442, Güemes, CÓRDOBA','30-67760778-1','INSTITUTO NUESTRA SEÑORA DE NIEVA','Adriana Siebenhaar','adrianasiebenhaar242@gmail.com','3516229929',''),(6,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO SAGRADO CORAZÓN','Roma 1153, Pueyrredón, CÓRDOBA','30-67760907-5','INSTITUTO SAGRADO CORAZON','Gloria del Valle Piuca 22388040  (Silvia Gragera - Contadora)','silviagragera@hotmail.com / ficgloria@gmail.com','3515374034cr / 3515 15-8375rl',''),(7,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO SAN RAMÓN NONATO','Av. Patria 282, Altos de General Paz, CÓRDOBA','30-68227175-9','COLEGIO SAN RAMON NONATO','Ramiro Calderón','Cr.Rcalderon@gmail.com','3513980423',''),(8,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO PARROQUIAL SAN FRANCISCO DE ASÍS','Jose Guardado 187, Las Flores, CÓRDOBA','30-67760914-8','COLEGIO PARROQUIAL SAN FRANCISCO DE ASIS Y PIO XIII','Silvia Neumann',' silvianeumann.rl@sanfranciscoasis.edu.ar ','3512192989',''),(9,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO NUESTRA SEÑORA DEL TRABAJO','Av. De Mayo 350, Villa El Libertador, CÓRDOBA','30-68099617-9','INSTITUTO NUESTRA SEÑORA DEL TRABAJO','Fernando Dutari','ferdutari@yahoo.com.ar','3513400834',''),(10,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL CRISTO REDENTOR','Gobernador Justiniano Posse 864, Jardín, CÓRDOBA','30-67761016-2','ESCUELA PARROQUIAL CRISTO REDENTOR','Pablo Ruibal','pruibal@escuelacristoredentor.edu.ar','3512244869',''),(11,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL SAN JOSÉ ARTESANO','Huiliches 1021, Los Olmos, CÓRDOBA','30-64321949-9','INSTITUTO SAN JOSE ARTESANO','Ernesto Giordano','ealgiordano@yahoo.com.ar','3516200491 - 4611369/9529',''),(12,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SAN JOSE OBRERO','Progreso y Pasaje 17, Villa El Libertador, CÓRDOBA','30-71471244-2','INSTITUTO SAN JOSE OBRERO','Marta Aventuroso','mgaventuroso@hotmail.com','3515207496',''),(13,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO PADRE JUAN BURÓN','Aviador Mira 2658, Villa Adela, CÓRDOBA','30-71471118-7','INSTITUTO PADRE JUAN BURON','Haydeé Rojo','haydeenrojo@gmail.com','3516526095',''),(14,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL JUAN PABLO II','Calle Pública S/N - Ampliación 1º de Mayo, CÓRDOBA','30-71048404-6','INSTITUTO PARROQUIAL JUAN PABLO II','María Celeste Castillo dni 27653530','juanpabloiirl@gmail.com','3515316994',''),(15,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO NUESTRA SEÑORA DE LORETO','Gomez Carrillo 2559, Los Naranjos, CÓRDOBA','30-61208821-3','COLEGIO E INSTITUTO NUESTRA SEÑORA DE LORETO','Mercedes Arinci','bas_arinci@yahoo.com.ar','3516340081',''),(16,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL SANTO CRISTO','Domingo Funes 1180, Observatorio, CÓRDOBA','30-67760761-7','INSTITUTO PARROQUIAL SANTO CRISTO','Alejandra Bertolina','alebertolina@hotmail.com','3515587589',''),(17,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL NUESTRA SEÑORA DE FÁTIMA','Av. Varela Ortiz 2600, Matienzo, CÓRDOBA','30-67760747-1','INSTITUTO PARROQUIAL NUESTRA SEÑORA DE FATIMA','José Luis Soria','soriaj@hotmail.com','3514913078',''),(18,'0000-00-00 00:00:00','0000-00-00 00:00:00','CENTRO EDUCATIVO FRANCISCANO SAN BUENAVENTURA','Av Don Bosco 5001, Las Palmas, CÓRDOBA','30-67760952-0','COLEGIO SAN BUENAVENTURA','Laura Castillo','laura_marcelacastillo@yahoo.com','3516191944',''),(19,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL SAN JOSÉ','Velez Sud 252, Alto Alberdi, CÓRDOBA','30-67761054-5','INSTITUTO PARROQUIAL SAN JOSE','Ramón Horacio Arrambide Aliaga dni24991510','ramonarrambide@gmail.com ','3513759988',''),(20,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO NUESTRA SEÑORA DE ITATI','Ángel Roffo 1950, Villa Paez, CÓRDOBA','33-71046293-9','ESCUELA PARROQUIAL NUESTRA SEÑORA DE ITATI','Hno. Balderrama','jcbalderrama@yahoo.com.ar','3513914393',''),(21,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SAN JERÓNIMO','La Rioja 2046, Alto Alberdi, CÓRDOBA','30-61412125-0','INSTITUTO SAN JERONIMO','Hno. Balderrama','solecaminos77@yahoo.com.ar','3513914393',''),(22,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SAN JERÓNIMO','Colón 2202, Alto Alberdi, CÓRDOBA','30-61412125-1','INSTITUTO SAN JERONIMO','Hno. Balderrama','solecaminos77@yahoo.com.ar','3513914393',''),(23,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SAN JERÓNIMO','La Rioja 2115,  Alto Alberdi, CÓRDOBA','30-61412125-2','INSTITUTO SAN JERONIMO','Hno. Balderrama','solecaminos77@yahoo.com.ar','3513914393',''),(24,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SAN JERÓNIMO','La Rioja 2054, Alto Alberdi, CÓRDOBA','30-61412125-3','INSTITUTO SAN JERONIMO','Hno. Balderrama','solecaminos77@yahoo.com.ar','3513914393',''),(25,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO NUESTRA SEÑORA DEL VALLE','Ávila y Zárate 2051, Villa Los Ángeles, CÓRDOBA','30-67868205-1','INSTITUTO NUESTRA SEÑORA DEL VALLE','Gonzalo Delgado','gonzalorafaeldelgado@gmail.com','3516619520',''),(26,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO CEFERINO NAMUNCURÁ - NIVEL PRIMARIO','Ciudad del Barco 3315, La France, CÓRDOBA','30-67869703-2','COLEGIO PARROQUIAL CEFERINO NAMUNCURA','Luis Rodríguez','luisrod65@hotmail.com','3518035266',''),(27,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO CEFERINO NAMUNCURÁ - NIVEL SECUNDARIO','Ciudad del Barco 3316, La France, CÓRDOBA','30-67869703-3','COLEGIO PARROQUIAL CEFERINO NAMUNCURA','Luis Rodríguez','luisrod65@hotmail.com','3518035266',''),(28,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SANTA INÉS','Ciudad del Barco 3317, La France, CÓRDOBA','30-68232409-7','NUESTRA SEÑORA Y SANTA INES','Luis Rodríguez','luisrod65@hotmail.com','3518035266',''),(29,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO MONSEÑOR FERMÍN LAFITTE','Francisco Valle 2443, Los Paraisos, CÓRDOBA','30-67868021-0','ESCUELA PARROQUIAL MONSEÑOR FERMIN LAFITTE','Andrea Bustamante','sabustamante@hotmail.com','3513731949',''),(30,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL NUESTRA SEÑORA DEL CARMEN','Argensola 670, Alta Córdoba, CÓRDOBA','30-67868717-7','INSTITUTO PARROQUIAL NUESTRA SEÑORA DEL CARMEN','Martín Sanmartino','martinsan7@hotmail.com','3516791213',''),(31,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO SAN ROQUE','Mariano Usondivara 2080, Villa Corina, CÓRDOBA','30-67869901-9','INSTITUTO PRIVADO PARROQUIAL SAN ROQUE','Martín Sanmartino','martinsan7@hotmail.com ','3516643231',''),(32,'0000-00-00 00:00:00','0000-00-00 00:00:00','CENTRO EDUCATIVO PARROQUIAL SAN PABLO APOSTOL','Asturias 1935, Colón, CÓRDOBA','30-67760754-4','INSTITUTO PARROQUIAL SAN PABLO APOSTOL','Luis Rodríguez','luisrodr65@hotmail.com ','3518035266',''),(33,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO NUESTRA SEÑORA DEL SAGRADO CORAZÓN','Revolucion de Mayo 1476, Crisol, CÓRDOBA','30-67760853-2','ASOCIACION DE RELIGIOSAS FRANCISCANAS MISIONERAS DE LA INMAC','Hna. Mirtha','mirtafmic@hotmail.com','3513218977',''),(34,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL BERNARDO A. D\'ELÍA','Asunción sn, Quinta del Niño Dios, CARLOS PAZ','30-67868854-8','INSTITUTO PARROQUIAL BERNARDO D ELIA','Luciano Freytes','lfreytesvarela@epalmero.com.ar','3515125820',''),(35,'0000-00-00 00:00:00','0000-00-00 00:00:00','CENTRO PARROQUIAL MARGARITA A. DE PAZ','Asunción sn, Quinta del Niño Dios, CARLOS PAZ','30-67868847-5','ESCUELA PARROQUIAL MARGARITA A DE PAZ','Luciano Freytes','lfreytesvarela@epalmero.com.ar','3515125820',''),(36,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO INDUSTRIAL PARROQUIAL CRISTO OBRERO','Florencio Sánchez 394- Las Malvinas, CARLOS PAZ','30-67868373-2','INSTITUTO INDUSTRIAL CRISTO OBRERO','Guillermo Buitrago','ga_buitrago@yahoo.com','3515474272',''),(37,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO REMEDIOS ESCALADA DE SAN MARTIN','Estrada y Antártida, CARLOS PAZ','30-67867998-0','INSTITUTO PARROQUIAL REMEDIOS ESCALADA DE SAN MARTIN','Guillermo Buitrago y Mirtha Veras','replegal@iresm.edu.ar ','3515474272/3541332640',''),(38,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SAN CARLOS','Intendente Bogacki 499, MALAGUEÑO','30-67760624-6','INSTITUTO SAN CARLOS','Maria Fernanda Bernahola','mbernahola@hotmail.com','4981638/3515160950',''),(39,'0000-00-00 00:00:00','0000-00-00 00:00:00','ESCUELA PARROQUIAL SAN VICENTE DE PAUL','Ema Cevallos 446 esq Prudencio Bustos, ALTA GRACIA','30-54527719-7','SAN VICENTE DE PAUL','María Elizabeth Alvarez DNI 16710925','mariaelizabetalvarez@yahoo.com ','3547594064',''),(40,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL SAN JUAN DIEGO','Av Int Angel Llanos 320, STA ROSA CALAMUCHITA','30-66865832-2','INSTITUTO PARROQUIAL SAN JUAN DIEGO','Hector Rosales','hectorguillermorosales@gmail.com','3513537846',''),(41,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL EL OBRAJE','Nieto 17, ALTA GRACIA','30-53792563-5','INSTITUTO DE ENSEÑANZA PRIVADO EL OBRAJE','Ana Demmel','anademmel@gmail.com','3513451200',''),(42,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL PIO XII','Padre Buteler 229, DESPEÑADEROS','30-67760464-2','INSTITUTO PIO XII','Sivia Molina 16292202/Nelson Daniel Martin 21906928','abogadodanielmartin@gmail.com','3513684722 Silvia',''),(43,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO CONTARDO FERRINI','Contardo Ferrini 96, RIO PRIMERO','30-67761092-8','INSTITUTO CONTARDO FERRINI','Juan Pablo Machado','juanpablomachado9@hotmail.com','3512291678',''),(44,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO JOSÉ MANUEL ESTRADA','Rivadavia 941, OBISPO TREJO','30-67761450-8','INSTITUTO JOSE MANUEL ESTRADA','Yamil Wehbe ','yamilwehbe@hotmail.com ','3516225909',''),(45,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO EL SALVADOR','Belgrano 301, STA ROSA DE RIO PRIMERO','30-67760471-5','INSTITUTO EL SALVADOR','Delfina Teresa Giordanengo','delfinagiordanengo@hotmail.com','3574458396',''),(46,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL MONTE CRISTO','Av Roque S Peña 380. MONTE CRISTO','30-67761061-8','INSTITUTO PARROQUIAL MONTE CRISTO','Julieta Justicia',' rl@ipmc.edu.ar','3513404781',''),(47,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO NUESTRA SEÑORA DEL PILAR','Buenos Aires y Ruta prov 13, PILAR','30-68973825-3','INSTITUTO CATOLICO DE ENSEÑANZA NUESTRA SEÑORA DEL PILAR','Alicia Geric','alicia.geric@gmail.com','3518048374',''),(48,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO PARROQUIAL SAN LUIS GONZAGA','Uruguay esq Mejico, RIO SEGUNDO','33-67761009-9','INSTITUTO PRIVADO PARROQUIAL SAN LUIS GONZAGA','Susana Abele','abelesusana@gmail.com','3572403173',''),(49,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO PARROQUIAL DEL ESPIRITU SANTO','Belgrano 171, ONCATIVO','30-67761023-5','ESCUELA PARROQUIAL DEL ESPIRITU SANTO','Noris del Carmen Severini dni 16781732','severininoris@hotmail.com','3572401187',''),(50,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL NUESTRA SEÑORA DEL ROSARIO DEL MILAGRO','Pedro Oñate sn, JESUS MARIA','30-53853941-0','INSTITUTO PRIVADO NTRA SRA DEL ROSARIO DEL MILAGRO','Fernando Gabriel Castro DNI 33,380,833','castrofer11@gmail.com','3513508601',''),(51,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SANTA CLARA DE ASIS','Juan XXIII 498, SALSIPUEDES','30-71171253-0','INSTITUTO PRIVADO SANTA CLARA DE ASIS','María Alicia Vargas DNI 23.134.496','mariaaliciavargas860@gmail.com','3517062409',''),(52,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL NUESTRA SEÑORA DE LOURDES','Sarmiento 21,  UNQUILLO','30-67867875-5','INSTITUTO PARROQUIAL NUESTRA SEÑORA DE LOURDES','Carlos Ramacciotti dni 12820973','cramacciotti07@gmail.com','3516656742',''),(53,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO PARROQUIAL PIO XII','Ob Bustos 816, COSQUIN','30-67868014-8','INSTITUTO PRIVADO NUESTRA SEÑORA DEL CALVARIO','Walter Daniel Gómez DNI 16180367','walterg1723@gmail.com ','3517323273',''),(54,'0000-00-00 00:00:00','0000-00-00 00:00:00','COLEGIO INMACULADO CORAZÓN DE MARÍA','Santa Fe sn, MALAGUEÑO','30-67760884-2','COLEGIO INMACULADO CORAZON DE MARIA','Guillermo Emanuel Travaglia DNI: 33.797.230','guilletravaglia@gmail.com','3515574093',''),(55,'0000-00-00 00:00:00','0000-00-00 00:00:00','FUNDACIÓN EFETA - INSTITUTO PADRE DOMINGO VIERA','San Juan 650, Villa Oviedo, ALTA GRACIA','30-70917533-1','FUNDACION EFFETA','María Inés Carignani (dni 6199191)','carignani.mene@gmail.com','3547-522172',''),(56,'0000-00-00 00:00:00','0000-00-00 00:00:00','FUNDACIÓN SANTO DOMINGO- ACADEMIA SANTO DOMINGO','Ituzaingó 159, Centro, CÓRDOBA','30-70825917-5','A S D SOCIEDAD DE RESPONSABILIDAD LIMITADA','Antonio Pablo Huais','ahuais@issd.edu.ar','(Secretario Docente) 3513796500',''),(57,'0000-00-00 00:00:00','0000-00-00 00:00:00','FUNDACIÓN SANTO DOMINGO - INSTITUTO SUPERIOR SANTO DOMINGO','Alvear 270, Centro, CÓRDOBA','30-70825917-5','A S D SOCIEDAD DE RESPONSABILIDAD LIMITADA','Antonio Pablo Huais','ahuais@issd.edu.ar','(Secretario Docente) 3513796501',''),(58,'0000-00-00 00:00:00','0000-00-00 00:00:00','FUNDACIÓN SANTO DOMINGO- CENTRO EDUCATIVO \"SANTO DOMINGO\" - INICIAL, PRIMARIO Y SECUNDARIO','Alvear 270, Centro, CÓRDOBA','30-70825917-5','FUNDACIÓN SANTO DOMINGO','Antonio Pablo Huais','ahuais@issd.edu.ar','(Secretario Docente) 3513796502',''),(59,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO DE EDUCACIÓN ESPECIAL A.Re.N.A','Pje. Félix Aguilar 1231, Observatorio, CÓRDOBA.','30-60966531-5','A.R.E.N.A. ( ASOCIACION DE REHABILITACION DEL NIÑO AISLADO )','María Esther Davico','institutoespecialarena@hotmail.com','',''),(60,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO DR. DALMACIO VÉLEZ SARSFIELD','Alejandro Aguado 571, General Bustos, CÓRDOBA','30-68755924-6','FUNDACION DALMACIO VELEZ SARSFIELD','Rubén Omar Di fiore dni 12.877.570','rubendifiore57@gmail.com','3513947850',''),(61,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO DE EDUCACIÓN ESPECIAL El Sol','José Colombres 938, San Martín, CÓRDOBA','30-61633513-4','CENTRO DE EDUCACION PREESCOLAR ESPECIAL PRIVADO EL SOL S R L','Raquel Emilia Bulla','info@instespecialelsol.edu.ar ','3515906967',''),(62,'0000-00-00 00:00:00','0000-00-00 00:00:00','INSTITUTO SUPERIOR NUEVA FORMACIÓN','Ituzaingó 658, Nueva Córdoba, CÓRDOBA','30-70908590-1','FUNDACION EQUIPOS EDUCATIVOS','Gabriel Morello','info@nuevaformacion.edu.ar','3516374867','');
/*!40000 ALTER TABLE `colegios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denuncias`
--

DROP TABLE IF EXISTS `denuncias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `denuncias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `colegios_id` int NOT NULL,
  `alumnos_id` int NOT NULL,
  `gravedad_accidente` enum('Leve','Medio','Grave') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_accidente` date DEFAULT NULL,
  `hora_accidente` time DEFAULT NULL,
  `horario` enum('Programado','Contra turno','Excepcional') COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalles_actividad` text COLLATE utf8mb4_unicode_ci,
  `actividad` enum('Habitual','Programada','Extra Programada','Otras') COLLATE utf8mb4_unicode_ci NOT NULL,
  `circunstancias_accidente` text COLLATE utf8mb4_unicode_ci,
  `lugar` enum('En la Institución','Fuera de la Institución') COLLATE utf8mb4_unicode_ci NOT NULL,
  `espacio_fisico` enum('Aula - D','Baños - D','Declaradas Anexas - F','Entradas / Salidas - D','Otras Dependencias - D','Pasillos / Escaleras - D','Patio - D','Propiedad de la misma comunidad - F','Propiedad de terceros - F','Propiedad del Arzobispo - F','Salon/Gimnasio - D') COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_responsable` text COLLATE utf8mb4_unicode_ci,
  `testigos` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denuncias`
--

LOCK TABLES `denuncias` WRITE;
/*!40000 ALTER TABLE `denuncias` DISABLE KEYS */;
INSERT INTO `denuncias` VALUES (1,'2024-10-16 05:49:33','2024-10-16 05:49:33',1,1,'Leve','2024-10-15','21:48:00','Programado','Prueba','Habitual','Ninguna','En la Institución','Propiedad de la misma comunidad - F','Ninguno','Ninguno'),(2,'2024-10-21 19:18:08','2024-10-21 19:18:08',46,2,'Leve','2024-10-15','11:21:00','Programado','ED FÍSICA','Habitual','EN LA HORA DE ED FÍSICA','En la Institución','Aula - D','NICOLAS','LORENA');
/*!40000 ALTER TABLE `denuncias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `derivaciones`
--

DROP TABLE IF EXISTS `derivaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `derivaciones` (
  `id_derivacion` int NOT NULL AUTO_INCREMENT,
  `id_accidente` int NOT NULL,
  `id_alumno` int NOT NULL,
  `id_prestador` int NOT NULL,
  `fecha_derivacion` date NOT NULL,
  `hora_derivacion` time DEFAULT NULL,
  `medico_deriva` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnostico_inicial` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acompanante` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `sello_escuela` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firma_autorizada` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `impresa` tinyint(1) DEFAULT '0',
  `fecha_impresion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_derivacion`),
  KEY `idx_derivaciones_fecha_prestador` (`fecha_derivacion`,`id_prestador`),
  KEY `idx_accidente` (`id_accidente`),
  KEY `idx_alumno` (`id_alumno`),
  KEY `idx_prestador` (`id_prestador`),
  KEY `idx_fecha` (`fecha_derivacion`),
  CONSTRAINT `derivaciones_ibfk_1` FOREIGN KEY (`id_accidente`) REFERENCES `accidentes` (`id_accidente`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `derivaciones_ibfk_2` FOREIGN KEY (`id_prestador`) REFERENCES `prestadores` (`id_prestador`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `derivaciones_ibfk_3` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `derivaciones`
--

LOCK TABLES `derivaciones` WRITE;
/*!40000 ALTER TABLE `derivaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `derivaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `derivaciones_legacy`
--

DROP TABLE IF EXISTS `derivaciones_legacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `derivaciones_legacy` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `denuncia_id` int NOT NULL,
  `derivacion` enum('RED P.M. del FSCR','Particular Autorizada por los Padres') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `red` enum('Sin Información','CONCI CARPINELLA','HOSPITAL PRIVADO','REINA FABIOLA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `particular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnostico` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `derivaciones_legacy`
--

LOCK TABLES `derivaciones_legacy` WRITE;
/*!40000 ALTER TABLE `derivaciones_legacy` DISABLE KEYS */;
INSERT INTO `derivaciones_legacy` VALUES (1,'2024-10-18 02:26:18','2025-06-01 12:33:45',1,'RED P.M. del FSCR','HOSPITAL PRIVADO','asas','asas'),(2,'2024-10-21 19:19:59','2024-10-21 19:19:59',1,NULL,NULL,NULL,NULL),(3,'2024-10-21 19:36:33','2024-10-21 19:36:33',2,NULL,NULL,NULL,NULL),(4,'2024-10-21 19:37:12','2024-10-21 19:37:12',2,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `derivaciones_legacy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documento_escuelas`
--

DROP TABLE IF EXISTS `documento_escuelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documento_escuelas` (
  `id_documento_escuela` int NOT NULL AUTO_INCREMENT,
  `id_documento` int NOT NULL,
  `id_escuela` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_documento_escuela`),
  UNIQUE KEY `uk_documento_escuela` (`id_documento`,`id_escuela`),
  KEY `idx_documento` (`id_documento`),
  KEY `idx_escuela` (`id_escuela`),
  CONSTRAINT `documento_escuelas_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `documentos_institucionales` (`id_documento`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `documento_escuelas_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_escuelas`
--

LOCK TABLES `documento_escuelas` WRITE;
/*!40000 ALTER TABLE `documento_escuelas` DISABLE KEYS */;
/*!40000 ALTER TABLE `documento_escuelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_institucionales`
--

DROP TABLE IF EXISTS `documentos_institucionales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_institucionales` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `id_escuela` int DEFAULT NULL,
  `nombre_documento` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_documento` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `id_usuario_carga` int NOT NULL,
  `fecha_carga` datetime DEFAULT NULL,
  `id_tipo_documento` int DEFAULT NULL,
  `archivo_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_documento`),
  KEY `idx_escuela` (`id_escuela`),
  KEY `idx_fecha_vencimiento` (`fecha_vencimiento`),
  KEY `id_usuario_carga` (`id_usuario_carga`),
  KEY `fk_documentos_tipo` (`id_tipo_documento`),
  CONSTRAINT `documentos_institucionales_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `documentos_institucionales_ibfk_2` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_documentos_tipo` FOREIGN KEY (`id_tipo_documento`) REFERENCES `cat_tipos_documentos` (`id_tipo_documento`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_institucionales`
--

LOCK TABLES `documentos_institucionales` WRITE;
/*!40000 ALTER TABLE `documentos_institucionales` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_institucionales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `id_escuela` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuil` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_egreso` date DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `uk_escuela_dni` (`id_escuela`,`dni`),
  KEY `idx_nombre_apellido` (`nombre`,`apellido`),
  KEY `idx_escuela` (`id_escuela`),
  KEY `idx_activo` (`activo`),
  CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escuelas`
--

DROP TABLE IF EXISTS `escuelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escuelas` (
  `id_escuela` int NOT NULL AUTO_INCREMENT,
  `codigo_escuela` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aporte_por_alumno` decimal(10,2) DEFAULT '0.00',
  `fecha_alta` date DEFAULT NULL,
  `cantidad_empleados` int DEFAULT '0',
  `cantidad_alumnos` int DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_escuela`),
  UNIQUE KEY `uk_codigo_escuela` (`codigo_escuela`),
  KEY `idx_nombre` (`nombre`),
  KEY `idx_activo` (`activo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escuelas`
--

LOCK TABLES `escuelas` WRITE;
/*!40000 ALTER TABLE `escuelas` DISABLE KEYS */;
INSERT INTO `escuelas` VALUES (1,'ESC001','Escuela Primaria N° 1','Av. Principal 123','123-456789','escuela1@jaec.edu.ar',50.00,'2025-05-29',0,0,1),(2,'ESC002','Instituto Belgrano','Calle Secundaria 456','987-654321','escuela2@jaec.edu.ar',65.00,'2025-05-29',0,0,1);
/*!40000 ALTER TABLE `escuelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eticket`
--

DROP TABLE IF EXISTS `eticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eticket` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `colegios_id` int NOT NULL,
  `tipo_eticket` enum('Novedad','Reclamo','Reunión fuera de institución','Visita a la institución') COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_eticket` enum('Abierto','Cerrado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eticket`
--

LOCK TABLES `eticket` WRITE;
/*!40000 ALTER TABLE `eticket` DISABLE KEYS */;
INSERT INTO `eticket` VALUES (1,'2024-10-16 06:50:47','2024-10-16 18:38:13',6,'Novedad','Cerrado','Prueba de ticket','asfasdf');
/*!40000 ALTER TABLE `eticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fallecimientos`
--

DROP TABLE IF EXISTS `fallecimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fallecimientos` (
  `id_fallecimiento` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `fecha_fallecimiento` date NOT NULL,
  `causa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lugar_fallecimiento` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `id_usuario_carga` int NOT NULL,
  `fecha_carga` datetime DEFAULT NULL,
  PRIMARY KEY (`id_fallecimiento`),
  UNIQUE KEY `uk_empleado` (`id_empleado`),
  KEY `idx_fecha_fallecimiento` (`fecha_fallecimiento`),
  KEY `id_usuario_carga` (`id_usuario_carga`),
  CONSTRAINT `fallecimientos_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fallecimientos_ibfk_2` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fallecimientos`
--

LOCK TABLES `fallecimientos` WRITE;
/*!40000 ALTER TABLE `fallecimientos` DISABLE KEYS */;
/*!40000 ALTER TABLE `fallecimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fichas`
--

DROP TABLE IF EXISTS `fichas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fichas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `colegios_id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annio` enum('2016','2017','2018','2019','2020','2021','2022','2023','2024','2025') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` enum('Inicial','Primario','Secundario','Superior') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fichas`
--

LOCK TABLES `fichas` WRITE;
/*!40000 ALTER TABLE `fichas` DISABLE KEYS */;
INSERT INTO `fichas` VALUES (2,'2024-10-11 05:48:13','2024-10-11 05:48:13',4,'Prueba de Ficha','2017','Inicial'),(3,'2024-10-11 15:54:53','2024-10-11 15:54:53',6,'Prueba 3','2017','Secundario'),(4,'2024-10-16 05:56:09','2024-10-16 05:56:09',2,'Prueba de Ficha','2016','Primario');
/*!40000 ALTER TABLE `fichas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fichas_institucionales`
--

DROP TABLE IF EXISTS `fichas_institucionales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fichas_institucionales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `colegios_id` int NOT NULL,
  `annio` enum('2016','2017','2018','2019','2020','2021','2022','2023','2024','2025') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` enum('Inicial','Primario','Secundario','Superior') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fichas_institucionales`
--

LOCK TABLES `fichas_institucionales` WRITE;
/*!40000 ALTER TABLE `fichas_institucionales` DISABLE KEYS */;
/*!40000 ALTER TABLE `fichas_institucionales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_reintegros`
--

DROP TABLE IF EXISTS `historial_reintegros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_reintegros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_reintegro` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `accion` enum('aceptar','rechazar','solicitar_informacion','mensaje','respuesta_escuela') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_historial_reintegro_fecha` (`id_reintegro`,`fecha_hora`),
  KEY `idx_historial_reintegro` (`id_reintegro`),
  KEY `idx_historial_usuario` (`id_usuario`),
  KEY `idx_historial_accion` (`accion`),
  CONSTRAINT `historial_reintegros_id_reintegro_foreign` FOREIGN KEY (`id_reintegro`) REFERENCES `reintegros` (`id_reintegro`) ON DELETE CASCADE,
  CONSTRAINT `historial_reintegros_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_reintegros`
--

LOCK TABLES `historial_reintegros` WRITE;
/*!40000 ALTER TABLE `historial_reintegros` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_reintegros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (7,'2014_10_12_000000_create_users_table',1),(8,'2014_10_12_100000_create_password_reset_tokens_table',1),(9,'2014_10_12_100000_create_password_resets_table',1),(10,'2019_08_19_000000_create_failed_jobs_table',1),(11,'2019_12_14_000001_create_personal_access_tokens_table',1),(12,'2024_09_18_225828_create_colegios_table',1),(13,'2024_10_08_171507_create_alumnos_table',2),(15,'2024_10_10_174216_create_archivos_table',2),(16,'2024_10_10_174423_create_eticket_table',2),(18,'2024_10_10_184224_create_ausentismo_table',2),(20,'2024_10_10_184923_create_personal_table',2),(26,'2024_10_10_125006_create_denuncias_table',4),(27,'2024_10_10_183259_create_salidas_table',5),(33,'2024_10_10_191835_create_fichas_table',6),(34,'2024_10_10_234022_create_fichas_institucionales_table',6),(35,'2024_10_16_151020_create_derivaciones_table',7),(36,'2024_10_16_151755_create_auditorias_table',7),(40,'2024_10_16_155629_create_carpetas_table',8),(41,'2025_06_09_112652_create_accidente_alumnos_table',9),(42,'2025_06_09_112652_create_accidentes_table',9),(43,'2025_06_09_112652_create_alumnos_salidas_table',9),(44,'2025_06_09_112652_create_alumnos_table',9),(45,'2025_06_09_112652_create_archivos_adjuntos_table',9),(46,'2025_06_09_112652_create_auditoria_sistema_table',9),(47,'2025_06_09_112652_create_beneficiarios_svo_table',9),(48,'2025_06_09_112652_create_cat_estados_accidentes_table',9),(49,'2025_06_09_112652_create_cat_estados_reintegros_table',9),(50,'2025_06_09_112652_create_cat_estados_solicitudes_table',9),(51,'2025_06_09_112652_create_cat_parentescos_table',9),(52,'2025_06_09_112652_create_cat_tipos_documentos_table',9),(53,'2025_06_09_112652_create_cat_tipos_gastos_table',9),(54,'2025_06_09_112652_create_cat_tipos_prestadores_table',9),(55,'2025_06_09_112652_create_derivaciones_table',9),(56,'2025_06_09_112652_create_documentos_institucionales_table',9),(57,'2025_06_09_112652_create_empleados_table',9),(58,'2025_06_09_112652_create_escuelas_table',9),(59,'2025_06_09_112652_create_fallecimientos_table',9),(60,'2025_06_09_112652_create_notificaciones_table',9),(61,'2025_06_09_112652_create_pasantias_table',9),(62,'2025_06_09_112652_create_prestadores_table',9),(63,'2025_06_09_112652_create_reintegros_table',9),(64,'2025_06_09_112652_create_roles_table',9),(65,'2025_06_09_112652_create_salidas_educativas_table',9),(66,'2025_06_09_112652_create_solicitudes_info_auditor_table',9),(67,'2025_06_09_112652_create_usuarios_table',9),(68,'2025_06_09_112653_create_v_accidentes_completos_view',9),(69,'2025_06_09_112653_create_v_reintegros_completos_view',9),(70,'2025_06_09_112655_add_foreign_keys_to_accidente_alumnos_table',9),(71,'2025_06_09_112655_add_foreign_keys_to_accidentes_table',9),(72,'2025_06_09_112655_add_foreign_keys_to_alumnos_salidas_table',9),(73,'2025_06_09_112655_add_foreign_keys_to_alumnos_table',9),(74,'2025_06_09_112655_add_foreign_keys_to_archivos_adjuntos_table',9),(75,'2025_06_09_112655_add_foreign_keys_to_auditoria_sistema_table',9),(76,'2025_06_09_112655_add_foreign_keys_to_beneficiarios_svo_table',9),(77,'2025_06_09_112655_add_foreign_keys_to_derivaciones_table',9),(78,'2025_06_09_112655_add_foreign_keys_to_documentos_institucionales_table',9),(79,'2025_06_09_112655_add_foreign_keys_to_empleados_table',9),(80,'2025_06_09_112655_add_foreign_keys_to_fallecimientos_table',9),(81,'2025_06_09_112655_add_foreign_keys_to_notificaciones_table',9),(82,'2025_06_09_112655_add_foreign_keys_to_pasantias_table',9),(83,'2025_06_09_112655_add_foreign_keys_to_prestadores_table',9),(84,'2025_06_09_112655_add_foreign_keys_to_reintegros_table',9),(85,'2025_06_09_112655_add_foreign_keys_to_salidas_educativas_table',9),(86,'2025_06_09_112655_add_foreign_keys_to_solicitudes_info_auditor_table',9),(87,'2025_06_09_112655_add_foreign_keys_to_usuarios_table',9),(88,'2025_06_09_112657_create_historial_reintegros_table',9),(89,'2025_07_15_074744_add_obra_social_deportes_to_alumnos_table',9),(90,'2025_09_11_063541_create_documento_escuelas_table',9),(91,'2025_09_11_072651_make_id_escuela_nullable_in_documentos_institucionales_table',9),(92,'2026_03_13_124307_add_fecha_hasta_to_salidas_educativas_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `id_notificacion` int NOT NULL AUTO_INCREMENT,
  `id_usuario_destino` int NOT NULL,
  `tipo_notificacion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci,
  `id_entidad_referencia` int DEFAULT NULL,
  `tipo_entidad` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `leida` tinyint(1) DEFAULT '0',
  `fecha_lectura` datetime DEFAULT NULL,
  PRIMARY KEY (`id_notificacion`),
  KEY `idx_usuario_destino` (`id_usuario_destino`),
  KEY `idx_tipo` (`tipo_notificacion`),
  KEY `idx_fecha_creacion` (`fecha_creacion`),
  KEY `idx_leida` (`leida`),
  CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario_destino`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pasantias`
--

DROP TABLE IF EXISTS `pasantias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasantias` (
  `id_pasantia` int NOT NULL AUTO_INCREMENT,
  `id_escuela` int NOT NULL,
  `id_alumno` int NOT NULL,
  `empresa` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion_empresa` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tutor_empresa` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `horario` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_tareas` text COLLATE utf8mb4_unicode_ci,
  `id_usuario_carga` int NOT NULL,
  `fecha_carga` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pasantia`),
  KEY `idx_fechas` (`fecha_inicio`,`fecha_fin`),
  KEY `idx_escuela` (`id_escuela`),
  KEY `idx_alumno` (`id_alumno`),
  KEY `id_usuario_carga` (`id_usuario_carga`),
  CONSTRAINT `pasantias_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pasantias_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pasantias_ibfk_3` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pasantias`
--

LOCK TABLES `pasantias` WRITE;
/*!40000 ALTER TABLE `pasantias` DISABLE KEYS */;
/*!40000 ALTER TABLE `pasantias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `colegios_id` int NOT NULL,
  `nombre_apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` enum('DNI','LE','LC') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo` enum('Femenino','Masculino') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `cuil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legajo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domicilio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barrio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `remuneracion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uso_licencia` tinyint(1) NOT NULL,
  `tareas_pasivas` tinyint(1) NOT NULL,
  `tareas_actuales` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (1,'2024-10-18 07:40:04','2024-10-18 07:40:04',1,'Jose Eduardo Quintero','DNI','16663245','Masculino','1984-09-29','123456','IT','123456','Direccion','Barriomk','LOcal','1201','0+584241783191','2024-10-17','1000',1,1,'pruebas');
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestadores`
--

DROP TABLE IF EXISTS `prestadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestadores` (
  `id_prestador` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `es_sistema_emergencias` tinyint(1) DEFAULT '0',
  `direccion` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `especialidades` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  `id_tipo_prestador` int DEFAULT NULL,
  PRIMARY KEY (`id_prestador`),
  KEY `idx_nombre` (`nombre`),
  KEY `idx_emergencias` (`es_sistema_emergencias`),
  KEY `idx_activo` (`activo`),
  KEY `fk_prestadores_tipo` (`id_tipo_prestador`),
  CONSTRAINT `fk_prestadores_tipo` FOREIGN KEY (`id_tipo_prestador`) REFERENCES `cat_tipos_prestadores` (`id_tipo_prestador`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestadores`
--

LOCK TABLES `prestadores` WRITE;
/*!40000 ALTER TABLE `prestadores` DISABLE KEYS */;
INSERT INTO `prestadores` VALUES (1,'Clínica del Sol',0,'Calle Falsa 123','111-222333','info@clinicasol.com','Pediatría, Traumatología',1,1),(2,'Emergencias JAEC',1,'Av. Siempreviva 742','0800-EMER-JAEC','emergencias@jaec.com.ar','Atención Primaria de Urgencias',1,7);
/*!40000 ALTER TABLE `prestadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reintegro_tipos_gastos`
--

DROP TABLE IF EXISTS `reintegro_tipos_gastos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reintegro_tipos_gastos` (
  `id_reintegro` int NOT NULL,
  `id_tipo_gasto` int NOT NULL,
  PRIMARY KEY (`id_reintegro`,`id_tipo_gasto`),
  KEY `reintegro_tipos_gastos_id_reintegro_index` (`id_reintegro`),
  KEY `reintegro_tipos_gastos_id_tipo_gasto_index` (`id_tipo_gasto`),
  CONSTRAINT `reintegro_tipos_gastos_id_reintegro_foreign` FOREIGN KEY (`id_reintegro`) REFERENCES `reintegros` (`id_reintegro`) ON DELETE CASCADE,
  CONSTRAINT `reintegro_tipos_gastos_id_tipo_gasto_foreign` FOREIGN KEY (`id_tipo_gasto`) REFERENCES `cat_tipos_gastos` (`id_tipo_gasto`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reintegro_tipos_gastos`
--

LOCK TABLES `reintegro_tipos_gastos` WRITE;
/*!40000 ALTER TABLE `reintegro_tipos_gastos` DISABLE KEYS */;
/*!40000 ALTER TABLE `reintegro_tipos_gastos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reintegros`
--

DROP TABLE IF EXISTS `reintegros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reintegros` (
  `id_reintegro` int NOT NULL AUTO_INCREMENT,
  `id_accidente` int NOT NULL,
  `id_alumno` int NOT NULL,
  `id_usuario_solicita` int NOT NULL,
  `fecha_solicitud` datetime DEFAULT NULL,
  `id_tipo_gasto` int DEFAULT NULL,
  `descripcion_gasto` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monto_solicitado` decimal(10,2) NOT NULL,
  `id_estado_reintegro` int DEFAULT NULL,
  `requiere_mas_info` tinyint(1) DEFAULT '0',
  `id_medico_auditor` int DEFAULT NULL,
  `fecha_auditoria` datetime DEFAULT NULL,
  `observaciones_auditor` text COLLATE utf8mb4_unicode_ci,
  `monto_autorizado` decimal(10,2) DEFAULT NULL,
  `fecha_autorizacion` datetime DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `numero_transferencia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_reintegro`),
  KEY `idx_reintegros_estado_fecha` (`id_estado_reintegro`,`fecha_solicitud`),
  KEY `idx_accidente` (`id_accidente`),
  KEY `idx_alumno` (`id_alumno`),
  KEY `id_usuario_solicita` (`id_usuario_solicita`),
  KEY `idx_fecha_solicitud` (`fecha_solicitud`),
  KEY `idx_tipo_gasto` (`id_tipo_gasto`),
  KEY `idx_estado_reintegro` (`id_estado_reintegro`),
  KEY `idx_medico_auditor` (`id_medico_auditor`),
  CONSTRAINT `fk_reintegros_estado` FOREIGN KEY (`id_estado_reintegro`) REFERENCES `cat_estados_reintegros` (`id_estado_reintegro`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_reintegros_tipo_gasto` FOREIGN KEY (`id_tipo_gasto`) REFERENCES `cat_tipos_gastos` (`id_tipo_gasto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `reintegros_ibfk_1` FOREIGN KEY (`id_accidente`) REFERENCES `accidentes` (`id_accidente`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `reintegros_ibfk_2` FOREIGN KEY (`id_usuario_solicita`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `reintegros_ibfk_3` FOREIGN KEY (`id_medico_auditor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `reintegros_ibfk_6` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reintegros`
--

LOCK TABLES `reintegros` WRITE;
/*!40000 ALTER TABLE `reintegros` DISABLE KEYS */;
/*!40000 ALTER TABLE `reintegros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `uk_nombre_rol` (`nombre_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Usuario General','Personal de escuela con acceso básico al sistema',1),(2,'Administrador','Personal JAEC con acceso completo al sistema',1),(3,'Médico Auditor','Profesional médico que evalúa los reintegros',1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salidas`
--

DROP TABLE IF EXISTS `salidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salidas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_salida` enum('Educativa','Pasantía','Practicas Profesionales') COLLATE utf8mb4_unicode_ci NOT NULL,
  `colegios_id` int NOT NULL,
  `lugar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_desde` date NOT NULL,
  `fecha_hasta` date NOT NULL,
  `destinatarios` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_alumnos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsable` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otros_docentes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `otros_responsables` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_transporte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsable_vehiculo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehiculo_transporte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `autorización` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seguro_registro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poliza_rcv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salidas`
--

LOCK TABLES `salidas` WRITE;
/*!40000 ALTER TABLE `salidas` DISABLE KEYS */;
INSERT INTO `salidas` VALUES (1,'2024-10-16 06:26:50','2024-10-16 06:26:50','Educativa',2,'fgvfb','fgsdfg','2024-10-15','2024-10-22','fdgsdf','gsdfg','sdfgs','dfgsdfg','sdfg','kjbkl','b','vlkjhv','lhv','sdfasd','kjh','ñkbg','kju','lñ'),(2,'2024-10-16 06:35:02','2024-10-16 06:35:02','Pasantía',1,'KHJBH','jhughoiug','2024-10-15','2024-10-18','yg','fhkhfk','k','hjkkjufljkhfl','ljhfg','ljhflkjuhfl','ljhgljhgljh','gkjhgkjhfgkjhf','kjhfkjhfkljhfk','jhfkjfhkjhfkjh','fkjhfkjhfkjfhk','kkjhfkjhfkjhfk','jhfkjfhkjhfkj','hfkjhfkjfhkj');
/*!40000 ALTER TABLE `salidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salidas_educativas`
--

DROP TABLE IF EXISTS `salidas_educativas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salidas_educativas` (
  `id_salida` int NOT NULL AUTO_INCREMENT,
  `id_escuela` int NOT NULL,
  `id_usuario_carga` int NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_hasta` date DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `hora_regreso` time DEFAULT NULL,
  `destino` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proposito` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grado_curso` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_alumnos` int DEFAULT NULL,
  `docentes_acompanantes` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transporte` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_carga` datetime DEFAULT NULL,
  PRIMARY KEY (`id_salida`),
  KEY `idx_escuela` (`id_escuela`),
  KEY `id_usuario_carga` (`id_usuario_carga`),
  KEY `idx_fecha_salida` (`fecha_salida`),
  CONSTRAINT `salidas_educativas_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `salidas_educativas_ibfk_2` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salidas_educativas`
--

LOCK TABLES `salidas_educativas` WRITE;
/*!40000 ALTER TABLE `salidas_educativas` DISABLE KEYS */;
/*!40000 ALTER TABLE `salidas_educativas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes_info_auditor`
--

DROP TABLE IF EXISTS `solicitudes_info_auditor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes_info_auditor` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `id_reintegro` int NOT NULL,
  `id_auditor` int NOT NULL,
  `fecha_solicitud` datetime DEFAULT NULL,
  `descripcion_solicitud` text COLLATE utf8mb4_unicode_ci,
  `documentos_requeridos` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_estado_solicitud` int DEFAULT NULL,
  `id_usuario_responde` int DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL,
  `observaciones_respuesta` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_solicitud`),
  KEY `idx_reintegro` (`id_reintegro`),
  KEY `idx_auditor` (`id_auditor`),
  KEY `idx_fecha_solicitud` (`fecha_solicitud`),
  KEY `idx_estado_solicitud` (`id_estado_solicitud`),
  KEY `id_usuario_responde` (`id_usuario_responde`),
  CONSTRAINT `fk_solicitudes_estado` FOREIGN KEY (`id_estado_solicitud`) REFERENCES `cat_estados_solicitudes` (`id_estado_solicitud`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `solicitudes_info_auditor_ibfk_1` FOREIGN KEY (`id_reintegro`) REFERENCES `reintegros` (`id_reintegro`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `solicitudes_info_auditor_ibfk_2` FOREIGN KEY (`id_auditor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `solicitudes_info_auditor_ibfk_3` FOREIGN KEY (`id_usuario_responde`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes_info_auditor`
--

LOCK TABLES `solicitudes_info_auditor` WRITE;
/*!40000 ALTER TABLE `solicitudes_info_auditor` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudes_info_auditor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Junta','demo@demo.com',NULL,'$2y$12$rF/hZGjcICPjg6KC/tRR8eM5XeGC69Gf/JuVCaojRwfHThtzPqe3.','yOqP907bKFplT95e8YxkDQKzXLYTvrDgTcKR7GWQKBKzlHjHmKkGr8dmW8JZ','2024-09-19 16:27:21','2024-09-19 16:27:21'),(2,'Edu','ed@ed.com',NULL,'$2y$12$ZWWN.jTKBVRY63iBXSGX/./chgnlrcALcHj4PkC7u23aVAxJVc1j6',NULL,'2024-12-12 06:44:19','2024-12-12 06:44:19'),(3,'Lorena','lorena@jaeccba.org',NULL,'$2y$12$62rMUfFxnEFX4TbpY0CjEeZVAoT7luKj.s2yE/r2qkQJ42mh6Kr7a',NULL,'2024-12-13 17:13:39','2024-12-13 17:13:39'),(4,'whois kamley','ipaybocok@gmail.com',NULL,'$2y$12$oancugvBWxBJtuUcF5EBvurPU8dMs3RH/v.oLSJjBQEoy.e/ozLpG',NULL,'2025-05-31 04:27:10','2025-05-31 04:27:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_rol` int NOT NULL,
  `id_escuela` int DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `email_verificado` tinyint(1) DEFAULT '0',
  `token_verificacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `uk_email` (`email`),
  KEY `idx_rol` (`id_rol`),
  KEY `idx_escuela` (`id_escuela`),
  KEY `idx_activo` (`activo`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin@prueba.com','$2y$12$Hlnl2pdpfGajKCIviNJyeeiZOAYAprBoET1f16sgBsLS3IdUZrhFm','Admin','Sistema',2,NULL,'2026-03-26 22:04:02',1,NULL,1),(2,'medico@prueba.com','$2y$12$9C/DutmL1EqhxLFifnnbkecNr1.jKWybyi7WDzM57r50VPB.dR7aa','Medico','Auditor',3,NULL,'2026-03-26 22:04:03',1,NULL,1),(3,'user@prueba.com','$2y$12$X4JpklbOirk.vml9yz0ypuv2suA/r67eSXlXKXoLAr4vAA4gk5PIW','Usuario','Escuela1',1,1,'2026-03-26 22:04:03',1,NULL,1),(4,'user2@prueba.com','$2y$12$oS/ldJCD0ZKw.qFECou3z.iHBimCtsPTdSTec9sksvupXLJ/kXNcu','Usuario2','Escuela2',1,2,'2026-03-26 22:04:03',1,NULL,1),(5,'fcastro@jaeccba.org','$2y$12$O8Rq7Ezzc3BlhL314eHVyO.hXk4R35pyYBQxxlOIxrxlzoYleAETu','F','Castro',2,NULL,'2026-03-26 22:04:10',1,NULL,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-27  1:04:18
