-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 07:15:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fondo_solidario_jaec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accidentes`
--

CREATE TABLE `accidentes` (
  `id_accidente` int(11) NOT NULL,
  `numero_expediente` varchar(20) DEFAULT NULL,
  `id_escuela` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  `fecha_accidente` date NOT NULL,
  `hora_accidente` time DEFAULT NULL,
  `lugar_accidente` varchar(200) DEFAULT NULL,
  `descripcion_accidente` text DEFAULT NULL,
  `tipo_lesion` varchar(200) DEFAULT NULL,
  `protocolo_activado` tinyint(1) DEFAULT 0,
  `llamada_emergencia` tinyint(1) DEFAULT 0,
  `hora_llamada` time DEFAULT NULL,
  `servicio_emergencia` varchar(100) DEFAULT NULL,
  `id_estado_accidente` int(11) DEFAULT NULL,
  `fecha_carga` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Disparadores `accidentes`
--
DELIMITER $$
CREATE TRIGGER `tr_generar_numero_expediente` BEFORE INSERT ON `accidentes` FOR EACH ROW BEGIN
    IF NEW.numero_expediente IS NULL THEN
        CALL sp_generar_numero_expediente(NEW.id_escuela, NEW.numero_expediente);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accidente_alumnos`
--

CREATE TABLE `accidente_alumnos` (
  `id` int(11) NOT NULL,
  `id_accidente` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumno` int(11) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `cuil` varchar(15) DEFAULT NULL,
  `sala_grado_curso` varchar(50) DEFAULT NULL,
  `nombre_padre_madre` varchar(200) DEFAULT NULL,
  `telefono_contacto` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `id_seccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `id_escuela`, `nombre`, `apellido`, `dni`, `cuil`, `sala_grado_curso`, `nombre_padre_madre`, `telefono_contacto`, `fecha_nacimiento`, `activo`, `id_seccion`) VALUES
(1, 1, 'Juan', 'Perez', '12345678', '20-12345678-1', '5to Grado', 'Maria Lopez', '987-654321', '2010-05-15', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_salidas`
--

CREATE TABLE `alumnos_salidas` (
  `id_alumno_salida` int(11) NOT NULL,
  `id_salida` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `autorizado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_adjuntos`
--

CREATE TABLE `archivos_adjuntos` (
  `id_archivo` int(11) NOT NULL,
  `tipo_entidad` varchar(50) NOT NULL,
  `id_entidad` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` varchar(10) DEFAULT NULL,
  `tamaño` int(11) DEFAULT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  `fecha_carga` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_sistema`
--

CREATE TABLE `auditoria_sistema` (
  `id_auditoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_hora` datetime DEFAULT current_timestamp(),
  `accion` varchar(100) NOT NULL,
  `tabla_afectada` varchar(50) DEFAULT NULL,
  `id_registro` int(11) DEFAULT NULL,
  `datos_anteriores` text DEFAULT NULL,
  `datos_nuevos` text DEFAULT NULL,
  `ip_usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `auditoria_sistema`
--

INSERT INTO `auditoria_sistema` (`id_auditoria`, `id_usuario`, `fecha_hora`, `accion`, `tabla_afectada`, `id_registro`, `datos_anteriores`, `datos_nuevos`, `ip_usuario`) VALUES
(28, 1, '2025-05-31 23:47:48', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_acceso\":\"2025-05-31 23:47:48\"}', '127.0.0.1'),
(29, 1, '2025-05-31 23:47:58', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_salida\":\"2025-05-31 23:47:58\"}', NULL, '127.0.0.1'),
(30, 2, '2025-05-31 23:48:07', 'LOGIN', 'usuarios', 2, NULL, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_acceso\":\"2025-05-31 23:48:07\"}', '127.0.0.1'),
(31, 2, '2025-05-31 23:54:53', 'LOGOUT', 'usuarios', 2, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_salida\":\"2025-05-31 23:54:53\"}', NULL, '127.0.0.1'),
(32, 1, '2025-05-31 23:55:07', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_acceso\":\"2025-05-31 23:55:07\"}', '127.0.0.1'),
(33, 1, '2025-05-31 23:58:21', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_salida\":\"2025-05-31 23:58:21\"}', NULL, '127.0.0.1'),
(34, 1, '2025-05-31 23:58:30', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_acceso\":\"2025-05-31 23:58:30\"}', '127.0.0.1'),
(35, 1, '2025-06-01 00:36:56', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_salida\":\"2025-06-01 00:36:56\"}', NULL, '127.0.0.1'),
(36, 2, '2025-06-01 00:37:06', 'LOGIN', 'usuarios', 2, NULL, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_acceso\":\"2025-06-01 00:37:06\"}', '127.0.0.1'),
(37, 2, '2025-06-01 00:38:17', 'LOGOUT', 'usuarios', 2, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_salida\":\"2025-06-01 00:38:17\"}', NULL, '127.0.0.1'),
(38, 1, '2025-06-01 00:38:22', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_acceso\":\"2025-06-01 00:38:22\"}', '127.0.0.1'),
(39, 1, '2025-06-01 00:41:16', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_salida\":\"2025-06-01 00:41:16\"}', NULL, '127.0.0.1'),
(40, 2, '2025-06-01 00:41:21', 'LOGIN', 'usuarios', 2, NULL, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_acceso\":\"2025-06-01 00:41:21\"}', '127.0.0.1'),
(41, 2, '2025-06-01 00:43:33', 'LOGOUT', 'usuarios', 2, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_salida\":\"2025-06-01 00:43:33\"}', NULL, '127.0.0.1'),
(42, 3, '2025-06-01 00:43:40', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":\"Usuario General\",\"fecha_acceso\":\"2025-06-01 00:43:40\"}', '127.0.0.1'),
(43, 3, '2025-06-01 00:43:56', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":\"Usuario General\",\"fecha_salida\":\"2025-06-01 00:43:56\"}', NULL, '127.0.0.1'),
(44, 1, '2025-06-01 00:48:38', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_acceso\":\"2025-06-01 00:48:38\"}', '127.0.0.1'),
(45, 1, '2025-06-01 00:53:44', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":\"Administrador\",\"fecha_salida\":\"2025-06-01 00:53:44\"}', NULL, '127.0.0.1'),
(46, 2, '2025-06-01 00:53:51', 'LOGIN', 'usuarios', 2, NULL, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_acceso\":\"2025-06-01 00:53:51\"}', '127.0.0.1'),
(47, 2, '2025-06-01 00:56:20', 'LOGOUT', 'usuarios', 2, '{\"email\":\"medico@prueba.com\",\"nombre\":\"Medico Auditor\",\"rol\":\"Auditor\",\"fecha_salida\":\"2025-06-01 00:56:20\"}', NULL, '127.0.0.1'),
(48, 3, '2025-06-01 00:57:39', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":\"Usuario General\",\"fecha_acceso\":\"2025-06-01 00:57:39\"}', '127.0.0.1'),
(49, 3, '2025-06-01 01:03:29', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 01:03:29\"}', NULL, '127.0.0.1'),
(50, 1, '2025-06-01 01:03:38', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 01:03:38\"}', '127.0.0.1'),
(51, 1, '2025-06-01 01:04:55', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 01:04:55\"}', NULL, '127.0.0.1'),
(52, 1, '2025-06-01 01:05:04', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 01:05:04\"}', '127.0.0.1'),
(53, 1, '2025-06-01 01:16:18', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 01:16:18\"}', NULL, '127.0.0.1'),
(54, 3, '2025-06-01 01:16:30', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 01:16:30\"}', '127.0.0.1'),
(55, 3, '2025-06-01 01:19:32', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 01:19:32\"}', NULL, '127.0.0.1'),
(56, 1, '2025-06-01 01:19:43', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 01:19:43\"}', '127.0.0.1'),
(57, 1, '2025-06-01 01:27:06', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 01:27:06\"}', NULL, '127.0.0.1'),
(58, 1, '2025-06-01 01:28:02', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 01:28:02\"}', '127.0.0.1'),
(59, 1, '2025-06-01 01:31:15', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 01:31:15\"}', NULL, '127.0.0.1'),
(60, 1, '2025-06-01 01:32:16', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 01:32:16\"}', '127.0.0.1'),
(61, 1, '2025-06-01 01:34:15', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 01:34:15\"}', NULL, '127.0.0.1'),
(62, 1, '2025-06-01 01:34:27', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 01:34:27\"}', '127.0.0.1'),
(63, 1, '2025-06-01 03:49:21', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 03:49:21\"}', NULL, '127.0.0.1'),
(64, 1, '2025-06-01 03:49:31', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 03:49:31\"}', '127.0.0.1'),
(65, 1, '2025-06-01 05:04:37', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 05:04:37\"}', NULL, '127.0.0.1'),
(66, 1, '2025-06-01 05:04:41', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 05:04:41\"}', '127.0.0.1'),
(67, 1, '2025-06-01 06:23:15', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 06:23:15\"}', NULL, '127.0.0.1'),
(68, 1, '2025-06-01 06:23:22', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 06:23:22\"}', '127.0.0.1'),
(69, 1, '2025-06-01 03:25:41', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 03:25:41\"}', NULL, '127.0.0.1'),
(70, 1, '2025-06-01 03:25:49', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 03:25:49\"}', '127.0.0.1'),
(71, 1, '2025-06-01 03:27:53', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 03:27:53\"}', NULL, '127.0.0.1'),
(72, 1, '2025-06-01 03:28:00', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 03:28:00\"}', '127.0.0.1'),
(73, 1, '2025-06-01 04:17:02', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 04:17:02\"}', NULL, '127.0.0.1'),
(74, 3, '2025-06-01 04:17:11', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 04:17:11\"}', '127.0.0.1'),
(75, 3, '2025-06-01 04:37:29', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 04:37:29\"}', NULL, '127.0.0.1'),
(76, 1, '2025-06-01 04:37:39', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 04:37:39\"}', '127.0.0.1'),
(77, 1, '2025-06-01 04:39:16', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 04:39:16\"}', NULL, '127.0.0.1'),
(78, 3, '2025-06-01 04:39:21', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 04:39:21\"}', '127.0.0.1'),
(79, 3, '2025-06-01 05:16:47', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 05:16:47\"}', NULL, '127.0.0.1'),
(80, 3, '2025-06-01 05:17:02', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 05:17:02\"}', '127.0.0.1'),
(81, 3, '2025-06-01 05:25:23', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 05:25:23\"}', NULL, '127.0.0.1'),
(82, 3, '2025-06-01 05:25:30', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 05:25:30\"}', '127.0.0.1'),
(83, 3, '2025-06-01 06:04:00', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 06:04:00\"}', '127.0.0.1'),
(84, 3, '2025-06-01 06:08:04', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 06:08:04\"}', NULL, '127.0.0.1'),
(85, 3, '2025-06-01 06:08:10', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 06:08:10\"}', '127.0.0.1'),
(86, 3, '2025-06-01 06:08:48', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 06:08:48\"}', NULL, '127.0.0.1'),
(87, 1, '2025-06-01 06:09:13', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 06:09:13\"}', '127.0.0.1'),
(88, 1, '2025-06-01 06:13:49', 'LOGOUT', 'usuarios', 1, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_salida\":\"2025-06-01 06:13:49\"}', NULL, '127.0.0.1'),
(89, 3, '2025-06-01 06:13:56', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 06:13:56\"}', '127.0.0.1'),
(90, 3, '2025-06-01 06:37:35', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 06:37:35\"}', NULL, '127.0.0.1'),
(91, 3, '2025-06-01 06:38:06', 'LOGIN', 'usuarios', 3, NULL, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 06:38:06\"}', '127.0.0.1'),
(92, 3, '2025-06-01 06:38:37', 'LOGOUT', 'usuarios', 3, '{\"email\":\"user@prueba.com\",\"nombre\":\"Usuario Escuela1\",\"rol\":null,\"fecha_salida\":\"2025-06-01 06:38:37\"}', NULL, '127.0.0.1'),
(93, 1, '2025-06-01 06:40:03', 'LOGIN', 'usuarios', 1, NULL, '{\"email\":\"admin@prueba.com\",\"nombre\":\"Admin Sistema\",\"rol\":null,\"fecha_acceso\":\"2025-06-01 06:40:03\"}', '127.0.0.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios_svo`
--

CREATE TABLE `beneficiarios_svo` (
  `id_beneficiario` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_escuela` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL CHECK (`porcentaje` >= 0 and `porcentaje` <= 100),
  `fecha_alta` date DEFAULT curdate(),
  `activo` tinyint(1) DEFAULT 1,
  `id_parentesco` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estados_accidentes`
--

CREATE TABLE `cat_estados_accidentes` (
  `id_estado_accidente` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_estados_accidentes`
--

INSERT INTO `cat_estados_accidentes` (`id_estado_accidente`, `nombre_estado`, `descripcion`) VALUES
(1, 'Abierto', 'El accidente ha sido registrado y está activo.'),
(2, 'En Investigación', 'El accidente está siendo investigado.'),
(3, 'Cerrado', 'El accidente ha sido resuelto y cerrado.'),
(4, 'Pendiente Documentación', 'Se requiere más documentación para el accidente.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estados_reintegros`
--

CREATE TABLE `cat_estados_reintegros` (
  `id_estado_reintegro` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_estados_reintegros`
--

INSERT INTO `cat_estados_reintegros` (`id_estado_reintegro`, `nombre_estado`, `descripcion`) VALUES
(1, 'En proceso', 'La solicitud de reintegro ha sido recibida y está siendo procesada.'),
(2, 'Requiere Información', 'Se necesita información adicional para procesar el reintegro.'),
(3, 'Autorizado', 'El reintegro ha sido aprobado por el médico auditor.'),
(4, 'Rechazado', 'El reintegro ha sido rechazado.'),
(5, 'Pagado', 'El reintegro ha sido pagado.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estados_solicitudes`
--

CREATE TABLE `cat_estados_solicitudes` (
  `id_estado_solicitud` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_estados_solicitudes`
--

INSERT INTO `cat_estados_solicitudes` (`id_estado_solicitud`, `nombre_estado`, `descripcion`) VALUES
(1, 'Pendiente', 'La solicitud de información está esperando respuesta.'),
(2, 'Respondida', 'La solicitud de información ha sido respondida.'),
(3, 'Cerrada', 'La solicitud de información ha sido cerrada.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_parentescos`
--

CREATE TABLE `cat_parentescos` (
  `id_parentesco` int(11) NOT NULL,
  `nombre_parentesco` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_parentescos`
--

INSERT INTO `cat_parentescos` (`id_parentesco`, `nombre_parentesco`) VALUES
(1, 'Cónyuge'),
(5, 'Hermano/a'),
(2, 'Hijo/a'),
(4, 'Madre'),
(6, 'Otro'),
(3, 'Padre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_secciones_alumnos`
--

CREATE TABLE `cat_secciones_alumnos` (
  `id_seccion` int(11) NOT NULL,
  `nombre_seccion` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_secciones_alumnos`
--

INSERT INTO `cat_secciones_alumnos` (`id_seccion`, `nombre_seccion`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'U');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipos_documentos`
--

CREATE TABLE `cat_tipos_documentos` (
  `id_tipo_documento` int(11) NOT NULL,
  `nombre_tipo_documento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_tipos_documentos`
--

INSERT INTO `cat_tipos_documentos` (`id_tipo_documento`, `nombre_tipo_documento`) VALUES
(4, 'Certificado de Habilitación'),
(5, 'Otro'),
(2, 'Plan de Evacuación'),
(3, 'Protocolo COVID-19'),
(1, 'Reglamento Interno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipos_gastos`
--

CREATE TABLE `cat_tipos_gastos` (
  `id_tipo_gasto` int(11) NOT NULL,
  `nombre_tipo_gasto` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_tipos_gastos`
--

INSERT INTO `cat_tipos_gastos` (`id_tipo_gasto`, `nombre_tipo_gasto`, `descripcion`) VALUES
(1, 'Consulta Médica', 'Gastos por consulta con un profesional médico.'),
(2, 'Medicamentos', 'Gastos por compra de medicamentos recetados.'),
(3, 'Estudios Médicos', 'Gastos por estudios y análisis clínicos.'),
(4, 'Material Ortopédico', 'Gastos por material ortopédico o de curación.'),
(5, 'Traslados', 'Gastos por traslados en ambulancia o similar.'),
(6, 'Otros', 'Otros gastos médicos relacionados.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipos_prestadores`
--

CREATE TABLE `cat_tipos_prestadores` (
  `id_tipo_prestador` int(11) NOT NULL,
  `nombre_tipo_prestador` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cat_tipos_prestadores`
--

INSERT INTO `cat_tipos_prestadores` (`id_tipo_prestador`, `nombre_tipo_prestador`, `descripcion`) VALUES
(1, 'Clínica', 'Clínica médica general o especializada.'),
(2, 'Hospital', 'Hospital público o privado.'),
(3, 'Consultorio Médico', 'Consultorio particular de un médico.'),
(4, 'Laboratorio de Análisis', 'Laboratorio para estudios clínicos.'),
(5, 'Centro de Diagnóstico', 'Centro especializado en diagnósticos por imágenes.'),
(6, 'Farmacia', 'Establecimiento de venta de medicamentos.'),
(7, 'Servicio de Emergencias', 'Servicio de atención médica de urgencia.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `derivaciones`
--

CREATE TABLE `derivaciones` (
  `id_derivacion` int(11) NOT NULL,
  `id_accidente` int(11) NOT NULL,
  `id_prestador` int(11) NOT NULL,
  `fecha_derivacion` date NOT NULL,
  `hora_derivacion` time DEFAULT NULL,
  `medico_deriva` varchar(200) DEFAULT NULL,
  `diagnostico_inicial` varchar(500) DEFAULT NULL,
  `acompañante` varchar(200) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `sello_escuela` varchar(255) DEFAULT NULL,
  `firma_autorizada` varchar(200) DEFAULT NULL,
  `impresa` tinyint(1) DEFAULT 0,
  `fecha_impresion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_institucionales`
--

CREATE TABLE `documentos_institucionales` (
  `id_documento` int(11) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  `nombre_documento` varchar(200) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `fecha_documento` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  `fecha_carga` datetime DEFAULT current_timestamp(),
  `id_tipo_documento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `cuil` varchar(15) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_egreso` date DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id_escuela` int(11) NOT NULL,
  `codigo_escuela` varchar(20) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aporte_por_alumno` decimal(10,2) DEFAULT 0.00,
  `fecha_alta` date DEFAULT curdate(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id_escuela`, `codigo_escuela`, `nombre`, `direccion`, `telefono`, `email`, `aporte_por_alumno`, `fecha_alta`, `activo`) VALUES
(1, 'ESC001', 'Escuela Primaria N° 1', 'Av. Principal 123', '123-456789', 'escuela1@jaec.edu.ar', 50.00, '2025-05-29', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fallecimientos`
--

CREATE TABLE `fallecimientos` (
  `id_fallecimiento` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_fallecimiento` date NOT NULL,
  `causa` varchar(500) DEFAULT NULL,
  `lugar_fallecimiento` varchar(300) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  `fecha_carga` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario_destino` int(11) NOT NULL,
  `tipo_notificacion` varchar(50) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `id_entidad_referencia` int(11) DEFAULT NULL,
  `tipo_entidad` varchar(50) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `leida` tinyint(1) DEFAULT 0,
  `fecha_lectura` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasantias`
--

CREATE TABLE `pasantias` (
  `id_pasantia` int(11) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `empresa` varchar(200) NOT NULL,
  `direccion_empresa` varchar(300) DEFAULT NULL,
  `tutor_empresa` varchar(200) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `horario` varchar(100) DEFAULT NULL,
  `descripcion_tareas` text DEFAULT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  `fecha_carga` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestadores`
--

CREATE TABLE `prestadores` (
  `id_prestador` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `es_sistema_emergencias` tinyint(1) DEFAULT 0,
  `direccion` varchar(300) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `especialidades` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `id_tipo_prestador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `prestadores`
--

INSERT INTO `prestadores` (`id_prestador`, `nombre`, `es_sistema_emergencias`, `direccion`, `telefono`, `email`, `especialidades`, `activo`, `id_tipo_prestador`) VALUES
(1, 'Clínica del Sol', 0, 'Calle Falsa 123', '111-222333', 'info@clinicasol.com', 'Pediatría, Traumatología', 1, 1),
(2, 'Emergencias JAEC', 1, 'Av. Siempreviva 742', '0800-EMER-JAEC', 'emergencias@jaec.com.ar', 'Atención Primaria de Urgencias', 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reintegros`
--

CREATE TABLE `reintegros` (
  `id_reintegro` int(11) NOT NULL,
  `id_accidente` int(11) NOT NULL,
  `id_usuario_solicita` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `id_tipo_gasto` int(11) DEFAULT NULL,
  `descripcion_gasto` varchar(500) DEFAULT NULL,
  `monto_solicitado` decimal(10,2) NOT NULL,
  `id_estado_reintegro` int(11) DEFAULT NULL,
  `requiere_mas_info` tinyint(1) DEFAULT 0,
  `id_medico_auditor` int(11) DEFAULT NULL,
  `fecha_auditoria` datetime DEFAULT NULL,
  `observaciones_auditor` text DEFAULT NULL,
  `monto_autorizado` decimal(10,2) DEFAULT NULL,
  `fecha_autorizacion` datetime DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `numero_transferencia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Disparadores `reintegros`
--
DELIMITER $$
CREATE TRIGGER `tr_notificar_nuevo_reintegro` AFTER INSERT ON `reintegros` FOR EACH ROW BEGIN
    DECLARE v_titulo VARCHAR(200);
    DECLARE v_mensaje TEXT;
    DECLARE v_numero_expediente VARCHAR(20);
    DECLARE v_nombre_estado_reintegro VARCHAR(50);
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_id_auditor INT;
    
    -- Cursor para obtener todos los médicos auditores
    DECLARE cur_auditores CURSOR FOR
        SELECT u.id_usuario 
        FROM usuarios u
        JOIN roles ro ON u.id_rol = ro.id_rol
        WHERE ro.nombre_rol = 'Médico Auditor' AND u.activo = TRUE;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    -- Obtener número de expediente
    SELECT numero_expediente INTO v_numero_expediente
    FROM accidentes
    WHERE id_accidente = NEW.id_accidente;

    -- Obtener nombre del estado del reintegro
    SELECT cer.nombre_estado INTO v_nombre_estado_reintegro
    FROM cat_estados_reintegros cer
    WHERE cer.id_estado_reintegro = NEW.id_estado_reintegro;
    
    SET v_titulo = CONCAT('Nuevo reintegro (', v_nombre_estado_reintegro, ') - Exp: ', v_numero_expediente);
    SET v_mensaje = CONCAT('Se ha registrado/actualizado un reintegro por $', FORMAT(NEW.monto_solicitado, 2, 'es_AR'), 
                          ' para el expediente ', v_numero_expediente, '. Estado: ', v_nombre_estado_reintegro);
    
    -- Notificar a todos los médicos auditores
    OPEN cur_auditores;
    
    read_loop: LOOP
        FETCH cur_auditores INTO v_id_auditor;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        CALL sp_crear_notificacion(
            v_id_auditor,
            'NUEVO_REINTEGRO',
            v_titulo,
            v_mensaje,
            NEW.id_reintegro,
            'reintegro'
        );
    END LOOP;
    
    CLOSE cur_auditores;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion`, `activo`) VALUES
(1, 'Usuario General', 'Personal de escuela con acceso básico al sistema', 1),
(2, 'Administrador', 'Personal JAEC con acceso completo al sistema', 1),
(3, 'Médico Auditor', 'Profesional médico que evalúa los reintegros', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas_educativas`
--

CREATE TABLE `salidas_educativas` (
  `id_salida` int(11) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  `id_usuario_carga` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `hora_regreso` time DEFAULT NULL,
  `destino` varchar(300) DEFAULT NULL,
  `proposito` varchar(500) DEFAULT NULL,
  `grado_curso` varchar(50) DEFAULT NULL,
  `cantidad_alumnos` int(11) DEFAULT NULL,
  `docentes_acompañantes` varchar(500) DEFAULT NULL,
  `transporte` varchar(200) DEFAULT NULL,
  `fecha_carga` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_info_auditor`
--

CREATE TABLE `solicitudes_info_auditor` (
  `id_solicitud` int(11) NOT NULL,
  `id_reintegro` int(11) NOT NULL,
  `id_auditor` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `descripcion_solicitud` text DEFAULT NULL,
  `documentos_requeridos` varchar(500) DEFAULT NULL,
  `id_estado_solicitud` int(11) DEFAULT NULL,
  `id_usuario_responde` int(11) DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL,
  `observaciones_respuesta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_escuela` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `email_verificado` tinyint(1) DEFAULT 0,
  `token_verificacion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email`, `password`, `nombre`, `apellido`, `id_rol`, `id_escuela`, `fecha_registro`, `email_verificado`, `token_verificacion`, `activo`) VALUES
(1, 'admin@prueba.com', '$2y$12$rZIsmEUEWy13vFkqNbBLHOWn8n8DSFy6vgQfVM08I83FmGeQYYLOi', 'Admin', 'Sistema', 2, NULL, '2025-05-29 15:09:35', 1, NULL, 1),
(2, 'medico@prueba.com', '$2y$12$rZIsmEUEWy13vFkqNbBLHOWn8n8DSFy6vgQfVM08I83FmGeQYYLOi', 'Medico', 'Auditor', 3, NULL, '2025-05-29 15:09:35', 1, NULL, 1),
(3, 'user@prueba.com', '$2y$12$rZIsmEUEWy13vFkqNbBLHOWn8n8DSFy6vgQfVM08I83FmGeQYYLOi', 'Usuario', 'Escuela1', 1, 1, '2025-05-29 15:09:35', 1, NULL, 1),
(4, 'test@prueba.com', '$2y$12$rZIsmEUEWy13vFkqNbBLHOWn8n8DSFy6vgQfVM08I83FmGeQYYLOi', 'Usuario', 'Prueba', 1, 1, '2025-05-31 14:38:35', 1, NULL, 1);

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `tr_auditoria_usuarios_update` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    INSERT INTO auditoria_sistema (
        id_usuario,
        accion,
        tabla_afectada,
        id_registro,
        datos_anteriores,
        datos_nuevos
    ) VALUES (
        NEW.id_usuario,
        'UPDATE',
        'usuarios',
        NEW.id_usuario,
        CONCAT('email:', OLD.email, '|nombre:', OLD.nombre, '|apellido:', OLD.apellido, '|activo:', OLD.activo),
        CONCAT('email:', NEW.email, '|nombre:', NEW.nombre, '|apellido:', NEW.apellido, '|activo:', NEW.activo)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_accidentes_completos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_accidentes_completos` (
`id_accidente` int(11)
,`numero_expediente` varchar(20)
,`fecha_accidente` date
,`hora_accidente` time
,`lugar_accidente` varchar(200)
,`descripcion_accidente` text
,`tipo_lesion` varchar(200)
,`protocolo_activado` tinyint(1)
,`llamada_emergencia` tinyint(1)
,`estado_accidente` varchar(50)
,`alumno_nombre` varchar(100)
,`alumno_apellido` varchar(100)
,`alumno_dni` varchar(10)
,`escuela_nombre` varchar(200)
,`usuario_nombre` varchar(100)
,`usuario_apellido` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_reintegros_completos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_reintegros_completos` (
`id_reintegro` int(11)
,`fecha_solicitud` datetime
,`tipo_gasto` varchar(100)
,`descripcion_gasto` varchar(500)
,`monto_solicitado` decimal(10,2)
,`estado_reintegro` varchar(50)
,`monto_autorizado` decimal(10,2)
,`fecha_pago` date
,`numero_transferencia` varchar(50)
,`numero_expediente` varchar(20)
,`fecha_accidente` date
,`alumno_nombre` varchar(100)
,`alumno_apellido` varchar(100)
,`escuela_nombre` varchar(200)
,`solicitante_nombre` varchar(100)
,`solicitante_apellido` varchar(100)
,`auditor_nombre` varchar(100)
,`auditor_apellido` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_accidentes_completos`
--
DROP TABLE IF EXISTS `v_accidentes_completos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_accidentes_completos`  AS SELECT `a`.`id_accidente` AS `id_accidente`, `a`.`numero_expediente` AS `numero_expediente`, `a`.`fecha_accidente` AS `fecha_accidente`, `a`.`hora_accidente` AS `hora_accidente`, `a`.`lugar_accidente` AS `lugar_accidente`, `a`.`descripcion_accidente` AS `descripcion_accidente`, `a`.`tipo_lesion` AS `tipo_lesion`, `a`.`protocolo_activado` AS `protocolo_activado`, `a`.`llamada_emergencia` AS `llamada_emergencia`, `cea`.`nombre_estado` AS `estado_accidente`, `al`.`nombre` AS `alumno_nombre`, `al`.`apellido` AS `alumno_apellido`, `al`.`dni` AS `alumno_dni`, `e`.`nombre` AS `escuela_nombre`, `u`.`nombre` AS `usuario_nombre`, `u`.`apellido` AS `usuario_apellido` FROM ((((`accidentes` `a` join `alumnos` `al` on(`a`.`id_alumno` = `al`.`id_alumno`)) join `escuelas` `e` on(`a`.`id_escuela` = `e`.`id_escuela`)) join `usuarios` `u` on(`a`.`id_usuario_carga` = `u`.`id_usuario`)) left join `cat_estados_accidentes` `cea` on(`a`.`id_estado_accidente` = `cea`.`id_estado_accidente`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_reintegros_completos`
--
DROP TABLE IF EXISTS `v_reintegros_completos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reintegros_completos`  AS SELECT `r`.`id_reintegro` AS `id_reintegro`, `r`.`fecha_solicitud` AS `fecha_solicitud`, `ctg`.`nombre_tipo_gasto` AS `tipo_gasto`, `r`.`descripcion_gasto` AS `descripcion_gasto`, `r`.`monto_solicitado` AS `monto_solicitado`, `cer`.`nombre_estado` AS `estado_reintegro`, `r`.`monto_autorizado` AS `monto_autorizado`, `r`.`fecha_pago` AS `fecha_pago`, `r`.`numero_transferencia` AS `numero_transferencia`, `a`.`numero_expediente` AS `numero_expediente`, `a`.`fecha_accidente` AS `fecha_accidente`, `al`.`nombre` AS `alumno_nombre`, `al`.`apellido` AS `alumno_apellido`, `e`.`nombre` AS `escuela_nombre`, `us`.`nombre` AS `solicitante_nombre`, `us`.`apellido` AS `solicitante_apellido`, `ua`.`nombre` AS `auditor_nombre`, `ua`.`apellido` AS `auditor_apellido` FROM (((((((`reintegros` `r` join `accidentes` `a` on(`r`.`id_accidente` = `a`.`id_accidente`)) join `alumnos` `al` on(`a`.`id_alumno` = `al`.`id_alumno`)) join `escuelas` `e` on(`a`.`id_escuela` = `e`.`id_escuela`)) join `usuarios` `us` on(`r`.`id_usuario_solicita` = `us`.`id_usuario`)) left join `usuarios` `ua` on(`r`.`id_medico_auditor` = `ua`.`id_usuario`)) left join `cat_estados_reintegros` `cer` on(`r`.`id_estado_reintegro` = `cer`.`id_estado_reintegro`)) left join `cat_tipos_gastos` `ctg` on(`r`.`id_tipo_gasto` = `ctg`.`id_tipo_gasto`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accidentes`
--
ALTER TABLE `accidentes`
  ADD PRIMARY KEY (`id_accidente`),
  ADD UNIQUE KEY `numero_expediente` (`numero_expediente`),
  ADD UNIQUE KEY `uk_numero_expediente` (`numero_expediente`),
  ADD KEY `idx_escuela` (`id_escuela`),
  ADD KEY `idx_alumno` (`id_alumno`),
  ADD KEY `idx_fecha` (`fecha_accidente`),
  ADD KEY `idx_estado_accidente` (`id_estado_accidente`),
  ADD KEY `id_usuario_carga` (`id_usuario_carga`),
  ADD KEY `idx_accidentes_fecha_escuela` (`fecha_accidente`,`id_escuela`);

--
-- Indices de la tabla `accidente_alumnos`
--
ALTER TABLE `accidente_alumnos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_accidente_alumno` (`id_accidente`,`id_alumno`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumno`),
  ADD UNIQUE KEY `uk_dni` (`dni`),
  ADD UNIQUE KEY `uk_cuil` (`cuil`),
  ADD KEY `idx_escuela` (`id_escuela`),
  ADD KEY `idx_nombre_apellido` (`nombre`,`apellido`),
  ADD KEY `idx_activo` (`activo`),
  ADD KEY `fk_alumnos_seccion` (`id_seccion`);

--
-- Indices de la tabla `alumnos_salidas`
--
ALTER TABLE `alumnos_salidas`
  ADD PRIMARY KEY (`id_alumno_salida`),
  ADD UNIQUE KEY `uk_salida_alumno` (`id_salida`,`id_alumno`),
  ADD KEY `idx_salida` (`id_salida`),
  ADD KEY `idx_alumno` (`id_alumno`);

--
-- Indices de la tabla `archivos_adjuntos`
--
ALTER TABLE `archivos_adjuntos`
  ADD PRIMARY KEY (`id_archivo`),
  ADD KEY `idx_entidad` (`tipo_entidad`,`id_entidad`),
  ADD KEY `idx_usuario_carga` (`id_usuario_carga`),
  ADD KEY `idx_fecha_carga` (`fecha_carga`);

--
-- Indices de la tabla `auditoria_sistema`
--
ALTER TABLE `auditoria_sistema`
  ADD PRIMARY KEY (`id_auditoria`),
  ADD KEY `idx_usuario` (`id_usuario`),
  ADD KEY `idx_fecha_hora` (`fecha_hora`),
  ADD KEY `idx_tabla` (`tabla_afectada`),
  ADD KEY `idx_accion` (`accion`);

--
-- Indices de la tabla `beneficiarios_svo`
--
ALTER TABLE `beneficiarios_svo`
  ADD PRIMARY KEY (`id_beneficiario`),
  ADD KEY `idx_empleado` (`id_empleado`),
  ADD KEY `idx_activo` (`activo`),
  ADD KEY `fk_beneficiarios_parentesco` (`id_parentesco`),
  ADD KEY `fk_beneficiario_escuela` (`id_escuela`);

--
-- Indices de la tabla `cat_estados_accidentes`
--
ALTER TABLE `cat_estados_accidentes`
  ADD PRIMARY KEY (`id_estado_accidente`),
  ADD UNIQUE KEY `uk_nombre_estado_acc` (`nombre_estado`);

--
-- Indices de la tabla `cat_estados_reintegros`
--
ALTER TABLE `cat_estados_reintegros`
  ADD PRIMARY KEY (`id_estado_reintegro`),
  ADD UNIQUE KEY `uk_nombre_estado_reint` (`nombre_estado`);

--
-- Indices de la tabla `cat_estados_solicitudes`
--
ALTER TABLE `cat_estados_solicitudes`
  ADD PRIMARY KEY (`id_estado_solicitud`),
  ADD UNIQUE KEY `uk_nombre_estado_sol` (`nombre_estado`);

--
-- Indices de la tabla `cat_parentescos`
--
ALTER TABLE `cat_parentescos`
  ADD PRIMARY KEY (`id_parentesco`),
  ADD UNIQUE KEY `uk_nombre_parentesco` (`nombre_parentesco`);

--
-- Indices de la tabla `cat_secciones_alumnos`
--
ALTER TABLE `cat_secciones_alumnos`
  ADD PRIMARY KEY (`id_seccion`),
  ADD UNIQUE KEY `uk_nombre_seccion` (`nombre_seccion`);

--
-- Indices de la tabla `cat_tipos_documentos`
--
ALTER TABLE `cat_tipos_documentos`
  ADD PRIMARY KEY (`id_tipo_documento`),
  ADD UNIQUE KEY `uk_nombre_tipo_doc` (`nombre_tipo_documento`);

--
-- Indices de la tabla `cat_tipos_gastos`
--
ALTER TABLE `cat_tipos_gastos`
  ADD PRIMARY KEY (`id_tipo_gasto`),
  ADD UNIQUE KEY `uk_nombre_tipo_gasto` (`nombre_tipo_gasto`);

--
-- Indices de la tabla `cat_tipos_prestadores`
--
ALTER TABLE `cat_tipos_prestadores`
  ADD PRIMARY KEY (`id_tipo_prestador`),
  ADD UNIQUE KEY `uk_nombre_tipo_prestador` (`nombre_tipo_prestador`);

--
-- Indices de la tabla `derivaciones`
--
ALTER TABLE `derivaciones`
  ADD PRIMARY KEY (`id_derivacion`),
  ADD KEY `idx_accidente` (`id_accidente`),
  ADD KEY `idx_prestador` (`id_prestador`),
  ADD KEY `idx_fecha` (`fecha_derivacion`),
  ADD KEY `idx_derivaciones_fecha_prestador` (`fecha_derivacion`,`id_prestador`);

--
-- Indices de la tabla `documentos_institucionales`
--
ALTER TABLE `documentos_institucionales`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `idx_escuela` (`id_escuela`),
  ADD KEY `idx_fecha_vencimiento` (`fecha_vencimiento`),
  ADD KEY `id_usuario_carga` (`id_usuario_carga`),
  ADD KEY `fk_documentos_tipo` (`id_tipo_documento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `uk_dni` (`dni`),
  ADD UNIQUE KEY `uk_cuil` (`cuil`),
  ADD KEY `idx_escuela` (`id_escuela`),
  ADD KEY `idx_nombre_apellido` (`nombre`,`apellido`),
  ADD KEY `idx_activo` (`activo`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id_escuela`),
  ADD UNIQUE KEY `uk_codigo_escuela` (`codigo_escuela`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_activo` (`activo`);

--
-- Indices de la tabla `fallecimientos`
--
ALTER TABLE `fallecimientos`
  ADD PRIMARY KEY (`id_fallecimiento`),
  ADD UNIQUE KEY `uk_empleado` (`id_empleado`),
  ADD KEY `idx_fecha_fallecimiento` (`fecha_fallecimiento`),
  ADD KEY `id_usuario_carga` (`id_usuario_carga`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `idx_usuario_destino` (`id_usuario_destino`),
  ADD KEY `idx_tipo` (`tipo_notificacion`),
  ADD KEY `idx_leida` (`leida`),
  ADD KEY `idx_fecha_creacion` (`fecha_creacion`);

--
-- Indices de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  ADD PRIMARY KEY (`id_pasantia`),
  ADD KEY `idx_escuela` (`id_escuela`),
  ADD KEY `idx_alumno` (`id_alumno`),
  ADD KEY `idx_fechas` (`fecha_inicio`,`fecha_fin`),
  ADD KEY `id_usuario_carga` (`id_usuario_carga`);

--
-- Indices de la tabla `prestadores`
--
ALTER TABLE `prestadores`
  ADD PRIMARY KEY (`id_prestador`),
  ADD KEY `idx_nombre` (`nombre`),
  ADD KEY `idx_emergencias` (`es_sistema_emergencias`),
  ADD KEY `idx_activo` (`activo`),
  ADD KEY `fk_prestadores_tipo` (`id_tipo_prestador`);

--
-- Indices de la tabla `reintegros`
--
ALTER TABLE `reintegros`
  ADD PRIMARY KEY (`id_reintegro`),
  ADD KEY `idx_accidente` (`id_accidente`),
  ADD KEY `idx_estado_reintegro` (`id_estado_reintegro`),
  ADD KEY `idx_tipo_gasto` (`id_tipo_gasto`),
  ADD KEY `idx_fecha_solicitud` (`fecha_solicitud`),
  ADD KEY `idx_medico_auditor` (`id_medico_auditor`),
  ADD KEY `id_usuario_solicita` (`id_usuario_solicita`),
  ADD KEY `idx_reintegros_estado_fecha` (`id_estado_reintegro`,`fecha_solicitud`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `uk_nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `salidas_educativas`
--
ALTER TABLE `salidas_educativas`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `idx_escuela` (`id_escuela`),
  ADD KEY `idx_fecha_salida` (`fecha_salida`),
  ADD KEY `id_usuario_carga` (`id_usuario_carga`);

--
-- Indices de la tabla `solicitudes_info_auditor`
--
ALTER TABLE `solicitudes_info_auditor`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `idx_reintegro` (`id_reintegro`),
  ADD KEY `idx_auditor` (`id_auditor`),
  ADD KEY `idx_estado_solicitud` (`id_estado_solicitud`),
  ADD KEY `idx_fecha_solicitud` (`fecha_solicitud`),
  ADD KEY `id_usuario_responde` (`id_usuario_responde`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uk_email` (`email`),
  ADD KEY `idx_rol` (`id_rol`),
  ADD KEY `idx_escuela` (`id_escuela`),
  ADD KEY `idx_activo` (`activo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accidentes`
--
ALTER TABLE `accidentes`
  MODIFY `id_accidente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `accidente_alumnos`
--
ALTER TABLE `accidente_alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `alumnos_salidas`
--
ALTER TABLE `alumnos_salidas`
  MODIFY `id_alumno_salida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `archivos_adjuntos`
--
ALTER TABLE `archivos_adjuntos`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `auditoria_sistema`
--
ALTER TABLE `auditoria_sistema`
  MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `beneficiarios_svo`
--
ALTER TABLE `beneficiarios_svo`
  MODIFY `id_beneficiario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_estados_accidentes`
--
ALTER TABLE `cat_estados_accidentes`
  MODIFY `id_estado_accidente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cat_estados_reintegros`
--
ALTER TABLE `cat_estados_reintegros`
  MODIFY `id_estado_reintegro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cat_estados_solicitudes`
--
ALTER TABLE `cat_estados_solicitudes`
  MODIFY `id_estado_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_parentescos`
--
ALTER TABLE `cat_parentescos`
  MODIFY `id_parentesco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cat_secciones_alumnos`
--
ALTER TABLE `cat_secciones_alumnos`
  MODIFY `id_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cat_tipos_documentos`
--
ALTER TABLE `cat_tipos_documentos`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cat_tipos_gastos`
--
ALTER TABLE `cat_tipos_gastos`
  MODIFY `id_tipo_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cat_tipos_prestadores`
--
ALTER TABLE `cat_tipos_prestadores`
  MODIFY `id_tipo_prestador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `derivaciones`
--
ALTER TABLE `derivaciones`
  MODIFY `id_derivacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos_institucionales`
--
ALTER TABLE `documentos_institucionales`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id_escuela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fallecimientos`
--
ALTER TABLE `fallecimientos`
  MODIFY `id_fallecimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  MODIFY `id_pasantia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestadores`
--
ALTER TABLE `prestadores`
  MODIFY `id_prestador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reintegros`
--
ALTER TABLE `reintegros`
  MODIFY `id_reintegro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `salidas_educativas`
--
ALTER TABLE `salidas_educativas`
  MODIFY `id_salida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes_info_auditor`
--
ALTER TABLE `solicitudes_info_auditor`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accidentes`
--
ALTER TABLE `accidentes`
  ADD CONSTRAINT `accidentes_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  ADD CONSTRAINT `accidentes_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  ADD CONSTRAINT `accidentes_ibfk_3` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_accidentes_estado` FOREIGN KEY (`id_estado_accidente`) REFERENCES `cat_estados_accidentes` (`id_estado_accidente`);

--
-- Filtros para la tabla `accidente_alumnos`
--
ALTER TABLE `accidente_alumnos`
  ADD CONSTRAINT `accidente_alumnos_ibfk_1` FOREIGN KEY (`id_accidente`) REFERENCES `accidentes` (`id_accidente`) ON DELETE CASCADE,
  ADD CONSTRAINT `accidente_alumnos_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE;

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  ADD CONSTRAINT `fk_alumnos_seccion` FOREIGN KEY (`id_seccion`) REFERENCES `cat_secciones_alumnos` (`id_seccion`);

--
-- Filtros para la tabla `alumnos_salidas`
--
ALTER TABLE `alumnos_salidas`
  ADD CONSTRAINT `alumnos_salidas_ibfk_1` FOREIGN KEY (`id_salida`) REFERENCES `salidas_educativas` (`id_salida`) ON DELETE CASCADE,
  ADD CONSTRAINT `alumnos_salidas_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`);

--
-- Filtros para la tabla `archivos_adjuntos`
--
ALTER TABLE `archivos_adjuntos`
  ADD CONSTRAINT `archivos_adjuntos_ibfk_1` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `auditoria_sistema`
--
ALTER TABLE `auditoria_sistema`
  ADD CONSTRAINT `auditoria_sistema_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `beneficiarios_svo`
--
ALTER TABLE `beneficiarios_svo`
  ADD CONSTRAINT `beneficiarios_svo_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `fk_beneficiario_escuela` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  ADD CONSTRAINT `fk_beneficiarios_parentesco` FOREIGN KEY (`id_parentesco`) REFERENCES `cat_parentescos` (`id_parentesco`);

--
-- Filtros para la tabla `derivaciones`
--
ALTER TABLE `derivaciones`
  ADD CONSTRAINT `derivaciones_ibfk_1` FOREIGN KEY (`id_accidente`) REFERENCES `accidentes` (`id_accidente`),
  ADD CONSTRAINT `derivaciones_ibfk_2` FOREIGN KEY (`id_prestador`) REFERENCES `prestadores` (`id_prestador`);

--
-- Filtros para la tabla `documentos_institucionales`
--
ALTER TABLE `documentos_institucionales`
  ADD CONSTRAINT `documentos_institucionales_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  ADD CONSTRAINT `documentos_institucionales_ibfk_2` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_documentos_tipo` FOREIGN KEY (`id_tipo_documento`) REFERENCES `cat_tipos_documentos` (`id_tipo_documento`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`);

--
-- Filtros para la tabla `fallecimientos`
--
ALTER TABLE `fallecimientos`
  ADD CONSTRAINT `fallecimientos_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `fallecimientos_ibfk_2` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario_destino`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `pasantias`
--
ALTER TABLE `pasantias`
  ADD CONSTRAINT `pasantias_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  ADD CONSTRAINT `pasantias_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  ADD CONSTRAINT `pasantias_ibfk_3` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `prestadores`
--
ALTER TABLE `prestadores`
  ADD CONSTRAINT `fk_prestadores_tipo` FOREIGN KEY (`id_tipo_prestador`) REFERENCES `cat_tipos_prestadores` (`id_tipo_prestador`);

--
-- Filtros para la tabla `reintegros`
--
ALTER TABLE `reintegros`
  ADD CONSTRAINT `fk_reintegros_estado` FOREIGN KEY (`id_estado_reintegro`) REFERENCES `cat_estados_reintegros` (`id_estado_reintegro`),
  ADD CONSTRAINT `fk_reintegros_tipo_gasto` FOREIGN KEY (`id_tipo_gasto`) REFERENCES `cat_tipos_gastos` (`id_tipo_gasto`),
  ADD CONSTRAINT `reintegros_ibfk_1` FOREIGN KEY (`id_accidente`) REFERENCES `accidentes` (`id_accidente`),
  ADD CONSTRAINT `reintegros_ibfk_2` FOREIGN KEY (`id_usuario_solicita`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reintegros_ibfk_3` FOREIGN KEY (`id_medico_auditor`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `salidas_educativas`
--
ALTER TABLE `salidas_educativas`
  ADD CONSTRAINT `salidas_educativas_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  ADD CONSTRAINT `salidas_educativas_ibfk_2` FOREIGN KEY (`id_usuario_carga`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `solicitudes_info_auditor`
--
ALTER TABLE `solicitudes_info_auditor`
  ADD CONSTRAINT `fk_solicitudes_estado` FOREIGN KEY (`id_estado_solicitud`) REFERENCES `cat_estados_solicitudes` (`id_estado_solicitud`),
  ADD CONSTRAINT `solicitudes_info_auditor_ibfk_1` FOREIGN KEY (`id_reintegro`) REFERENCES `reintegros` (`id_reintegro`),
  ADD CONSTRAINT `solicitudes_info_auditor_ibfk_2` FOREIGN KEY (`id_auditor`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `solicitudes_info_auditor_ibfk_3` FOREIGN KEY (`id_usuario_responde`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
