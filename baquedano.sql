-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2018 a las 01:04:34
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `baquedano`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_fotorevinmueble`
--

CREATE TABLE `adm_fotorevinmueble` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_inmueble` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_fotorevpersona`
--

CREATE TABLE `adm_fotorevpersona` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_persona` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_revisioninmueble`
--

CREATE TABLE `adm_revisioninmueble` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_inmueble` int(10) UNSIGNED NOT NULL,
  `tipo_revision` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalle_revision` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` int(11) DEFAULT NULL,
  `id_modificador` int(11) DEFAULT NULL,
  `fecha_gestion` date DEFAULT NULL,
  `hora_gestion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adm_revisionpersona`
--

CREATE TABLE `adm_revisionpersona` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_persona` int(10) UNSIGNED NOT NULL,
  `tipo_revision` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalle_revision` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` int(11) DEFAULT NULL,
  `id_modificador` int(11) DEFAULT NULL,
  `fecha_gestion` date DEFAULT NULL,
  `hora_gestion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arrendatariocitas`
--

CREATE TABLE `arrendatariocitas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_c` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_c` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_c` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_arrendatario` int(10) UNSIGNED NOT NULL,
  `detalle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arrendatarioimgs`
--

CREATE TABLE `arrendatarioimgs` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_arrendatario` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arrendatarios`
--

CREATE TABLE `arrendatarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_arrendatario` int(10) UNSIGNED DEFAULT NULL,
  `id_creador` int(10) UNSIGNED DEFAULT NULL,
  `id_modificador` int(10) UNSIGNED DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `borradores`
--

CREATE TABLE `borradores` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_notaria` int(10) UNSIGNED NOT NULL,
  `id_servicios` int(10) UNSIGNED NOT NULL,
  `id_comisiones` int(10) UNSIGNED NOT NULL,
  `id_flexibilidad` int(10) UNSIGNED NOT NULL,
  `id_publicacion` int(10) UNSIGNED NOT NULL,
  `fecha_gestion` date DEFAULT NULL,
  `detalle_revision` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_creador` int(10) UNSIGNED NOT NULL,
  `id_modificador` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `borradorespdf`
--

CREATE TABLE `borradorespdf` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_borrador` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cap_corredores`
--

CREATE TABLE `cap_corredores` (
  `id` int(10) UNSIGNED NOT NULL,
  `informacion_publicacion` text COLLATE utf8mb4_unicode_ci,
  `fecha_publicacion` date DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `observaciones` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_corredor` int(10) UNSIGNED DEFAULT NULL,
  `id_propietario` int(10) UNSIGNED DEFAULT NULL,
  `id_inmueble` int(10) UNSIGNED DEFAULT NULL,
  `id_creador` int(10) UNSIGNED DEFAULT NULL,
  `id_modificador` int(10) UNSIGNED DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cap_gestion`
--

CREATE TABLE `cap_gestion` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_captacion_gestion` int(10) UNSIGNED NOT NULL,
  `tipo_contacto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalle_contacto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador_gestion` int(11) DEFAULT NULL,
  `id_modificador_gestion` int(11) DEFAULT NULL,
  `fecha_gestion` date DEFAULT NULL,
  `hora_gestion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cap_gestioncorredor`
--

CREATE TABLE `cap_gestioncorredor` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_capcorredor_gestion` int(10) UNSIGNED NOT NULL,
  `tipo_contacto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalle_contacto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador_gestion` int(11) DEFAULT NULL,
  `id_modificador_gestion` int(11) DEFAULT NULL,
  `fecha_gestion` date DEFAULT NULL,
  `hora_gestion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cap_imagecorredor`
--

CREATE TABLE `cap_imagecorredor` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_capcorredor` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cap_imagenes`
--

CREATE TABLE `cap_imagenes` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_captacion` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cap_import`
--

CREATE TABLE `cap_import` (
  `id` int(10) UNSIGNED NOT NULL,
  `CAPTADOR` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Fecha_publicacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Nro` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Dpto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Comuna` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Dorm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bano` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Esta` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Pisc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Precio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GASTOS_COMUNES` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CONDICION` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_propietario` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TELEFONO` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `portal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FECHA_ENVIO_CLIENTE` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `OBSERVACIONES` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LINK` text COLLATE utf8mb4_unicode_ci,
  `Codigo_Publicacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_creador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `ob_estado` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cap_publicaciones`
--

CREATE TABLE `cap_publicaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `portal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_publicacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informacion_publicacion` text COLLATE utf8mb4_unicode_ci,
  `fecha_publicacion` date DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `observaciones` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_propietario` int(10) UNSIGNED DEFAULT NULL,
  `id_inmueble` int(10) UNSIGNED DEFAULT NULL,
  `id_creador` int(10) UNSIGNED DEFAULT NULL,
  `id_modificador` int(10) UNSIGNED DEFAULT NULL,
  `id_estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrador', 'Administrador del Sistema', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(2, 'Contact Center', 'Captación', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(3, 'Captación Central', 'Captación Central', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(4, 'Captación Externa', 'Captación Externa', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(5, 'Administración', 'Administración', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comisiones`
--

CREATE TABLE `comisiones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comision` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunas`
--

CREATE TABLE `comunas` (
  `comuna_id` int(10) UNSIGNED NOT NULL,
  `comuna_nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comunas`
--

INSERT INTO `comunas` (`comuna_id`, `comuna_nombre`, `provincia_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Arica', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(2, 'Camarones', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(3, 'General Lagos', 2, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(4, 'Putre', 2, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(5, 'Alto Hospicio', 3, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(6, 'Iquique', 3, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(7, 'Camiña', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(8, 'Colchane', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(9, 'Huara', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(10, 'Pica', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(11, 'Pozo Almonte', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(12, 'Antofagasta', 5, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(13, 'Mejillones', 5, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(14, 'Sierra Gorda', 5, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(15, 'Taltal', 5, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(16, 'Calama', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(17, 'Ollague', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(18, 'San Pedro de Atacama', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(19, 'María Elena', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(20, 'Tocopilla', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(21, 'Chañaral', 8, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(22, 'Diego de Almagro', 8, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(23, 'Caldera', 9, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(24, 'Copiapó', 9, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(25, 'Tierra Amarilla', 9, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(26, 'Alto del Carmen', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(27, 'Freirina', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(28, 'Huasco', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(29, 'Vallenar', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(30, 'Canela', 11, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(31, 'Illapel', 11, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(32, 'Los Vilos', 11, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(33, 'Salamanca', 11, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(34, 'Andacollo', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(35, 'Coquimbo', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(36, 'La Higuera', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(37, 'La Serena', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(38, 'Paihuaco', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(39, 'Vicuña', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(40, 'Combarbalá', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(41, 'Monte Patria', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(42, 'Ovalle', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(43, 'Punitaqui', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(44, 'Río Hurtado', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(45, 'Isla de Pascua', 14, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(46, 'Calle Larga', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(47, 'Los Andes', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(48, 'Rinconada', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(49, 'San Esteban', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(50, 'La Ligua', 16, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(51, 'Papudo', 16, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(52, 'Petorca', 16, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(53, 'Zapallar', 16, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(54, 'Hijuelas', 17, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(55, 'La Calera', 17, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(56, 'La Cruz', 17, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(57, 'Limache', 17, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(58, 'Nogales', 17, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(59, 'Olmué', 17, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(60, 'Quillota', 17, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(61, 'Algarrobo', 18, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(62, 'Cartagena', 18, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(63, 'El Quisco', 18, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(64, 'El Tabo', 18, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(65, 'San Antonio', 18, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(66, 'Santo Domingo', 18, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(67, 'Catemu', 19, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(68, 'Llaillay', 19, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(69, 'Panquehue', 19, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(70, 'Putaendo', 19, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(71, 'San Felipe', 19, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(72, 'Santa María', 19, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(73, 'Casablanca', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(74, 'Concón', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(75, 'Juan Fernández', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(76, 'Puchuncaví', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(77, 'Quilpué', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(78, 'Quintero', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(79, 'Valparaíso', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(80, 'Villa Alemana', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(81, 'Viña del Mar', 20, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(82, 'Colina', 21, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(83, 'Lampa', 21, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(84, 'Tiltil', 21, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(85, 'Pirque', 22, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(86, 'Puente Alto', 22, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(87, 'San José de Maipo', 22, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(88, 'Buin', 23, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(89, 'Calera de Tango', 23, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(90, 'Paine', 23, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(91, 'San Bernardo', 23, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(92, 'Alhué', 24, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(93, 'Curacaví', 24, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(94, 'María Pinto', 24, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(95, 'Melipilla', 24, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(96, 'San Pedro', 24, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(97, 'Cerrillos', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(98, 'Cerro Navia', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(99, 'Conchalí', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(100, 'El Bosque', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(101, 'Estación Central', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(102, 'Huechuraba', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(103, 'Independencia', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(104, 'La Cisterna', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(105, 'La Granja', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(106, 'La Florida', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(107, 'La Pintana', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(108, 'La Reina', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(109, 'Las Condes', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(110, 'Lo Barnechea', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(111, 'Lo Espejo', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(112, 'Lo Prado', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(113, 'Macul', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(114, 'Maipú', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(115, 'Ñuñoa', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(116, 'Pedro Aguirre Cerda', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(117, 'Peñalolén', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(118, 'Providencia', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(119, 'Pudahuel', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(120, 'Quilicura', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(121, 'Quinta Normal', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(122, 'Recoleta', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(123, 'Renca', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(124, 'San Miguel', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(125, 'San Joaquín', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(126, 'San Ramón', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(127, 'Santiago', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(128, 'Vitacura', 25, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(129, 'El Monte', 26, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(130, 'Isla de Maipo', 26, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(131, 'Padre Hurtado', 26, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(132, 'Peñaflor', 26, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(133, 'Talagante', 26, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(134, 'Codegua', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(135, 'Coínco', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(136, 'Coltauco', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(137, 'Doñihue', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(138, 'Graneros', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(139, 'Las Cabras', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(140, 'Machalí', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(141, 'Malloa', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(142, 'Mostazal', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(143, 'Olivar', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(144, 'Peumo', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(145, 'Pichidegua', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(146, 'Quinta de Tilcoco', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(147, 'Rancagua', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(148, 'Rengo', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(149, 'Requínoa', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(150, 'San Vicente de Tagua Tagua', 27, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(151, 'La Estrella', 28, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(152, 'Litueche', 28, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(153, 'Marchihue', 28, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(154, 'Navidad', 28, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(155, 'Peredones', 28, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(156, 'Pichilemu', 28, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(157, 'Chépica', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(158, 'Chimbarongo', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(159, 'Lolol', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(160, 'Nancagua', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(161, 'Palmilla', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(162, 'Peralillo', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(163, 'Placilla', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(164, 'Pumanque', 29, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(165, 'San Fernando', 29, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(166, 'Santa Cruz', 29, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(167, 'Cauquenes', 30, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(168, 'Chanco', 30, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(169, 'Pelluhue', 30, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(170, 'Curicó', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(171, 'Hualañé', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(172, 'Licantén', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(173, 'Molina', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(174, 'Rauco', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(175, 'Romeral', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(176, 'Sagrada Familia', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(177, 'Teno', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(178, 'Vichuquén', 31, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(179, 'Colbún', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(180, 'Linares', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(181, 'Longaví', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(182, 'Parral', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(183, 'Retiro', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(184, 'San Javier', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(185, 'Villa Alegre', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(186, 'Yerbas Buenas', 32, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(187, 'Constitución', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(188, 'Curepto', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(189, 'Empedrado', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(190, 'Maule', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(191, 'Pelarco', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(192, 'Pencahue', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(193, 'Río Claro', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(194, 'San Clemente', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(195, 'San Rafael', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(196, 'Talca', 33, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(197, 'Arauco', 34, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(198, 'Cañete', 34, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(199, 'Contulmo', 34, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(200, 'Curanilahue', 34, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(201, 'Lebu', 34, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(202, 'Los Álamos', 34, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(203, 'Tirúa', 34, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(204, 'Alto Biobío', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(205, 'Antuco', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(206, 'Cabrero', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(207, 'Laja', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(208, 'Los Ángeles', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(209, 'Mulchén', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(210, 'Nacimiento', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(211, 'Negrete', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(212, 'Quilaco', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(213, 'Quilleco', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(214, 'San Rosendo', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(215, 'Santa Bárbara', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(216, 'Tucapel', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(217, 'Yumbel', 35, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(218, 'Chiguayante', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(219, 'Concepción', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(220, 'Coronel', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(221, 'Florida', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(222, 'Hualpén', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(223, 'Hualqui', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(224, 'Lota', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(225, 'Penco', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(226, 'San Pedro de La Paz', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(227, 'Santa Juana', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(228, 'Talcahuano', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(229, 'Tomé', 36, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(230, 'Bulnes', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(231, 'Chillán', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(232, 'Chillán Viejo', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(233, 'Cobquecura', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(234, 'Coelemu', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(235, 'Coihueco', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(236, 'El Carmen', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(237, 'Ninhue', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(238, 'Ñiquen', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(239, 'Pemuco', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(240, 'Pinto', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(241, 'Portezuelo', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(242, 'Quillón', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(243, 'Quirihue', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(244, 'Ránquil', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(245, 'San Carlos', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(246, 'San Fabián', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(247, 'San Ignacio', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(248, 'San Nicolás', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(249, 'Treguaco', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(250, 'Yungay', 37, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(251, 'Carahue', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(252, 'Cholchol', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(253, 'Cunco', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(254, 'Curarrehue', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(255, 'Freire', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(256, 'Galvarino', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(257, 'Gorbea', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(258, 'Lautaro', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(259, 'Loncoche', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(260, 'Melipeuco', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(261, 'Nueva Imperial', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(262, 'Padre Las Casas', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(263, 'Perquenco', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(264, 'Pitrufquén', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(265, 'Pucón', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(266, 'Saavedra', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(267, 'Temuco', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(268, 'Teodoro Schmidt', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(269, 'Toltén', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(270, 'Vilcún', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(271, 'Villarrica', 38, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(272, 'Angol', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(273, 'Collipulli', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(274, 'Curacautín', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(275, 'Ercilla', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(276, 'Lonquimay', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(277, 'Los Sauces', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(278, 'Lumaco', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(279, 'Purén', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(280, 'Renaico', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(281, 'Traiguén', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(282, 'Victoria', 39, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(283, 'Corral', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(284, 'Lanco', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(285, 'Los Lagos', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(286, 'Máfil', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(287, 'Mariquina', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(288, 'Paillaco', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(289, 'Panguipulli', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(290, 'Valdivia', 40, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(291, 'Futrono', 41, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(292, 'La Unión', 41, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(293, 'Lago Ranco', 41, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(294, 'Río Bueno', 41, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(295, 'Ancud', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(296, 'Castro', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(297, 'Chonchi', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(298, 'Curaco de Vélez', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(299, 'Dalcahue', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(300, 'Puqueldón', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(301, 'Queilén', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(302, 'Quemchi', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(303, 'Quellón', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(304, 'Quinchao', 42, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(305, 'Calbuco', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(306, 'Cochamó', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(307, 'Fresia', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(308, 'Frutillar', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(309, 'Llanquihue', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(310, 'Los Muermos', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(311, 'Maullín', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(312, 'Puerto Montt', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(313, 'Puerto Varas', 43, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(314, 'Osorno', 44, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(315, 'Puero Octay', 44, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(316, 'Purranque', 44, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(317, 'Puyehue', 44, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(318, 'Río Negro', 44, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(319, 'San Juan de la Costa', 44, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(320, 'San Pablo', 44, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(321, 'Chaitén', 45, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(322, 'Futaleufú', 45, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(323, 'Hualaihué', 45, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(324, 'Palena', 45, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(325, 'Aisén', 46, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(326, 'Cisnes', 46, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(327, 'Guaitecas', 46, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(328, 'Cochrane', 47, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(329, 'O\'higgins', 47, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(330, 'Tortel', 47, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(331, 'Coihaique', 48, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(332, 'Lago Verde', 48, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(333, 'Chile Chico', 49, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(334, 'Río Ibáñez', 49, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(335, 'Antártica', 50, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(336, 'Cabo de Hornos', 50, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(337, 'Laguna Blanca', 51, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(338, 'Punta Arenas', 51, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(339, 'Río Verde', 51, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(340, 'San Gregorio', 51, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(341, 'Porvenir', 52, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(342, 'Primavera', 52, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(343, 'Timaukel', 52, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(344, 'Natales', 53, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(345, 'Torres del Paine', 53, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicions`
--

CREATE TABLE `condicions` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flexibilidads`
--

CREATE TABLE `flexibilidads` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formasdepagos`
--

CREATE TABLE `formasdepagos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pie` int(11) NOT NULL,
  `cuotas` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmuebles`
--

CREATE TABLE `inmuebles` (
  `id` int(10) UNSIGNED NOT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `departamento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dormitorio` int(11) DEFAULT NULL,
  `rol` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bano` int(11) DEFAULT NULL,
  `estacionamiento` int(11) DEFAULT NULL,
  `referencia` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bodega` int(11) DEFAULT NULL,
  `nro_bodega` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piscina` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `gastosComunes` int(11) DEFAULT NULL,
  `id_comuna` int(11) NOT NULL,
  `id_region` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(121, '2012_05_19_003554_create_cargos_table', 1),
(122, '2013_05_20_224557_create_personas_table', 1),
(123, '2014_10_12_000000_create_users_table', 1),
(124, '2014_10_12_100000_create_password_resets_table', 1),
(125, '2015_01_20_084450_create_roles_table', 1),
(126, '2015_01_20_084525_create_role_user_table', 1),
(127, '2015_01_24_080208_create_permissions_table', 1),
(128, '2015_01_24_080433_create_permission_role_table', 1),
(129, '2015_12_04_003040_add_special_role_column', 1),
(130, '2017_10_17_170735_create_permission_user_table', 1),
(131, '2018_05_15_163807_create_notarias_table', 1),
(132, '2018_05_16_013516_create_condicions_table', 1),
(133, '2018_05_16_205139_create_inmuebles_table', 1),
(134, '2018_05_21_180938_create_servicios_table', 1),
(135, '2018_05_21_190309_create_multas_table', 1),
(136, '2018_05_21_212551_regions', 1),
(137, '2018_05_21_212606_provincias', 1),
(138, '2018_05_21_212619_comunas', 1),
(139, '2018_05_24_164206_cap_publicacion', 1),
(140, '2018_05_26_114046_create_formasDePagos_table', 1),
(141, '2018_05_26_124820_create_comisiones_table', 1),
(142, '2018_05_26_140017_create_flexibilidads_table', 1),
(143, '2018_05_27_124638_create_personaInmuebles_table', 1),
(144, '2018_05_29_173604_CaptacionImg', 1),
(145, '2018_05_30_022118_Portales', 1),
(146, '2018_05_30_140028_create_correos_table', 1),
(147, '2018_05_31_103305_CaptacionGestion', 1),
(148, '2018_06_03_101833_CaptacionImport', 1),
(149, '2018_06_10_2100308_create_Arrendatario', 1),
(150, '2018_06_10_210309_create_ArrendatarioImg', 1),
(151, '2018_06_10_210342_create_ArrendatarioCita', 1),
(152, '2018_06_10_221625_CaptacionCorredor', 1),
(153, '2018_06_10_221915_CaptacionImageCorredor', 1),
(154, '2018_06_10_221934_CaptacionGestionCorredor', 1),
(155, '2018_06_12_215216_RevisionInmueble', 1),
(156, '2018_06_12_215233_RevisionPersona', 1),
(157, '2018_06_12_215612_FotoRevisionPersona', 1),
(158, '2018_06_12_215628_FotoRevisionInmueble', 1),
(159, '2018_06_13_225342_create_borradores_table', 1),
(160, '2018_06_17_004355_create_borradorespdf_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multas`
--

CREATE TABLE `multas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_multa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notarias`
--

CREATE TABLE `notarias` (
  `id` int(10) UNSIGNED NOT NULL,
  `razonsocial` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_comuna` int(11) NOT NULL,
  `id_region` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombreNotario` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'contactcenter', 'contactcenter.index', 'Acceso a captación Contact Center', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(2, 'Listado de captación', 'captacion.index', 'Despliega captacion', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(3, 'Ver detalle de captación', 'captacion.show', 'Despliega el detalle del captacion ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(4, 'Crea captación', 'captacion.create', 'Crear captacion del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(5, 'Edición de captación', 'captacion.edit', 'Editar captacion del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(6, 'Desactiva captación', 'captacion.destroy', 'Desactiva captacion del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(7, 'Listado de Usuarios', 'users.index', 'Despliega los usuarios del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(8, 'Ver detalle de Usuarios', 'users.show', 'Despliega el detalle del usuario', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(9, 'Crear Usuarios', 'users.create', 'Crear los usuarios del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(10, 'Edición de Usuarios', 'users.edit', 'Editar los usuarios del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(11, 'Desactivar Usuarios', 'users.destroy', 'Desactivar usuarios del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(12, 'Listado de Roles', 'roles.index', 'Despliega los Roles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(13, 'Ver detalle de Roles', 'roles.show', 'Despliega el detalle del rol', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(14, 'Crear Roles', 'roles.create', 'Crear los Roles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(15, 'Edición de Roles', 'roles.edit', 'Editar los Roles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(16, 'Desactivar Roles', 'roles.destroy', 'Desactivar Roles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(17, 'Listado de Notarias', 'notarias.index', 'Despliega las Notarias del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(18, 'Ver detalle de Notarias', 'notarias.show', 'Despliega el detalle de la Notaria', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(19, 'Crea Notarias', 'notarias.create', 'Crear las Notarias del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(20, 'Edición d Notarias', 'notarias.edit', 'Editar las Notarias del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(21, 'Desactiva Notarias', 'notarias.destroy', 'Desactiva Notarias del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(22, 'Listado de Condiciones', 'condicion.index', 'Despliega lo Condiciones del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(23, 'Ver detalle de Condiciones', 'condicion.show', 'Despliega el detalle de la Notaria', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(24, 'Crea Condiciones', 'condicion.create', 'Crear las Condiciones del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(25, 'Edición d Condiciones', 'condicion.edit', 'Editar las Condiciones del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(26, 'Desactiva Condiciones', 'condicion.destroy', 'Desactiva Condiciones del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(27, 'Listado de Inmuebles', 'inmueble.index', 'Despliega los Inmuebles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(28, 'Ver detalle de Inmuebles', 'inmueble.show', 'Despliega el detalle del inmueble', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(29, 'Crea Inmuebles', 'inmueble.create', 'Crear las Inmuebles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(30, 'Edición d Inmuebles', 'inmueble.edit', 'Editar las Inmuebles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(31, 'Desactiva Inmuebles', 'inmueble.destroy', 'Desactiva Inmuebles del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(32, 'Listado de Cargos', 'cargo.index', 'Despliega los cargos del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(33, 'Ver detalle de Cargos', 'cargo.show', 'Despliega el detalle del cargo', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(34, 'Crea Cargos', 'cargo.create', 'Crear las Cargos del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(35, 'Edición de Cargos', 'cargo.edit', 'Editar las Cargos del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(36, 'Desactiva Cargos', 'cargo.destroy', 'Desactiva Cargos del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(37, 'Listado de Personas', 'persona.index', 'Despliega personas del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(38, 'Ver detalle de Personas', 'persona.show', 'Despliega el detalle de la Notaria', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(39, 'Crea Personas', 'persona.create', 'Crear las Personas del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(40, 'Edición de Personas', 'persona.edit', 'Editar las Personas del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(41, 'Desactiva Personas', 'persona.destroy', 'Desactiva Personas del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(42, 'Listado de Multa', 'multa.index', 'Despliega multa del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(43, 'Ver detalle de Multa', 'multa.show', 'Despliega el detalle de la multa', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(44, 'Crea Multa', 'multa.create', 'Crear las Multa del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(45, 'Edición de Multa', 'multa.edit', 'Editar las Multa del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(46, 'Desactiva Multa', 'multa.destroy', 'Desactiva Multa del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(47, 'Listado de Servicio', 'servicio.index', 'Despliega servicios', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(48, 'Ver detalle de Servicio', 'servicio.show', 'Despliega el detalle del servicio ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(49, 'Crea Servicio', 'servicio.create', 'Crear Servicio del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(50, 'Edición de Servicio', 'servicio.edit', 'Editar Servicio del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(51, 'Desactiva Servicio', 'servicio.destroy', 'Desactiva Servicio del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(52, 'Listado de forma de pago', 'formasDePago.index', 'Despliega forma de pago', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(53, 'Ver detalle de forma de pago', 'formasDePago.show', 'Despliega el detalle del forma de pago ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(54, 'Crea forma de pago', 'formasDePago.create', 'Crear forma de pago del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(55, 'Edición de forma de pago', 'formasDePago.edit', 'Editar forma de pago del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(56, 'Desactiva forma de pago', 'formasDePago.destroy', 'Desactiva forma de pago del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(57, 'Listado de comision', 'comision.index', 'Despliega forma de pago', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(58, 'Ver detalle de comision', 'comision.show', 'Despliega el detalle de comision ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(59, 'Crea comision', 'comision.create', 'Crear comision del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(60, 'Edición de comision', 'comision.edit', 'Editar comision del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(61, 'Desactiva  comision', 'comision.destroy', 'Desactiva comision del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(62, 'Listado de flexibilidad', 'flexibilidad.index', 'Despliega forma de pago', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(63, 'Ver detalle de flexibilidad', 'flexibilidad.show', 'Despliega el detalle de flexibilidad ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(64, 'Crea flexibilidad', 'flexibilidad.create', 'Crear flexibilidad del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(65, 'Edición de flexibilidad', 'flexibilidad.edit', 'Editar flexibilidad del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(66, 'Desactiva  flexibilidad', 'flexibilidad.destroy', 'Desactiva flexibilidad del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(67, 'Listado de personaInmueble', 'personaInmueble.index', 'Despliega forma de pago', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(68, 'Ver detalle de personaInmueble', 'personaInmueble.show', 'Despliega el detalle de personaInmueble ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(69, 'Crea personaInmueble', 'personaInmueble.create', 'Crear personaInmueble del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(70, 'Edición de personaInmueble', 'personaInmueble.edit', 'Editar personaInmueble del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(71, 'Desactiva  personaInmueble', 'personaInmueble.destroy', 'Desactiva personaInmueble del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(72, 'Listado de Correo', 'correo.index', 'Despliega Correo', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(73, 'Ver detalle de Correo', 'correo.show', 'Despliega el detalle de Correo ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(74, 'Crea Correo', 'correo.create', 'Crear Correo del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(75, 'Edición de Correo', 'correo.edit', 'Editar Correo del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(76, 'Desactiva  correo', 'correo.destroy', 'Desactiva correo del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(77, 'Listado de primeraGestion', 'primeraGestion.index', 'Despliega primeraGestion', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(78, 'Ver detalle de primeraGestion', 'primeraGestion.show', 'Despliega el detalle de primeraGestion ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(79, 'Crea primeraGestion', 'primeraGestion.create', 'Crear primeraGestion del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(80, 'Edición de primeraGestion', 'primeraGestion.edit', 'Editar primeraGestion del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(81, 'Desactiva  primeraGestion', 'primeraGestion.destroy', 'Desactiva primeraGestion del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(82, 'Listado de Portales', 'portal.index', 'Despliega Portales', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(83, 'Ver detalle de Portales', 'portal.show', 'Despliega el detalle de Portales ', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(84, 'Crea Portales', 'portal.create', 'Crear Portales del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(85, 'Edición de Portales', 'portal.edit', 'Editar Portales del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(86, 'Desactiva  Portales', 'portal.destroy', 'Desactiva Portales del sistema', '2018-06-17 23:04:22', '2018-06-17 23:04:22'),
(87, 'Listado de revisiones comerciales', 'revisioncomercial.index', 'Despliega revisiones comerciales', '2018-06-17 23:04:23', '2018-06-17 23:04:23'),
(88, 'Ver detalle de revisión comercial', 'revisioncomercial.show', 'Despliega el detalle de Portales ', '2018-06-17 23:04:23', '2018-06-17 23:04:23'),
(89, 'Crea revisión comercial', 'revisioncomercial.create', 'Crear revisión comercial del sistema', '2018-06-17 23:04:23', '2018-06-17 23:04:23'),
(90, 'Edición de revisión comercial', 'revisioncomercial.edit', 'Editar revisión comercial del sistema', '2018-06-17 23:04:23', '2018-06-17 23:04:23'),
(91, 'Desactiva  revisión comercial', 'revisioncomercial.destroy', 'Desactiva revisión comercial del sistema', '2018-06-17 23:04:23', '2018-06-17 23:04:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 3, 2, NULL, NULL),
(4, 4, 2, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 6, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_user`
--

CREATE TABLE `permission_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personainmuebles`
--

CREATE TABLE `personainmuebles` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_persona` int(10) UNSIGNED NOT NULL,
  `id_inmueble` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(10) UNSIGNED NOT NULL,
  `rut` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido_paterno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido_materno` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profesion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_civil` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_comuna` int(11) DEFAULT NULL,
  `id_region` int(11) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL,
  `tipo_cargo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `rut`, `nombre`, `apellido_paterno`, `apellido_materno`, `direccion`, `numero`, `profesion`, `estado_civil`, `departamento`, `telefono`, `email`, `id_estado`, `id_comuna`, `id_region`, `id_provincia`, `tipo_cargo`, `cargo_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '11111111-1', 'Administrador', 'del', 'Sistema', 'Av Apoquindo', '1111', NULL, NULL, '1111', '229023010', 'admin@ibaquedano.cl', 1, 86, 7, 22, 'Empleado', 1, NULL, '2018-06-17 23:04:24', '2018-06-17 23:04:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `portales`
--

CREATE TABLE `portales` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `portales`
--

INSERT INTO `portales` (`id`, `nombre`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'www.portalinmobiliario.com', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(2, 'www.elrastro.cl', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(3, 'www.propiedades.emol.com', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(4, 'www.yapo.cl', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(5, 'www.mercadolibre.cl', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(6, 'emol propiedades', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(7, 'www.economicos.cl', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(8, 'www.goplaceit.com', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(9, 'chilepropiedades.cl', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL),
(10, 'www.planetapropiedades.com', 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `provincia_id` int(10) UNSIGNED NOT NULL,
  `provincia_nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`provincia_id`, `provincia_nombre`, `region_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Arica', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(2, 'Parinacota', 1, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(3, 'Iquique', 2, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(4, 'El Tamarugal', 2, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(5, 'Antofagasta', 3, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(6, 'El Loa', 3, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(7, 'Tocopilla', 3, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(8, 'Chañaral', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(9, 'Copiapó', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(10, 'Huasco', 4, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(11, 'Choapa', 5, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(12, 'Elqui', 5, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(13, 'Limarí', 5, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(14, 'Isla de Pascua', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(15, 'Los Andes', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(16, 'Petorca', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(17, 'Quillota', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(18, 'San Antonio', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(19, 'San Felipe de Aconcagua', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(20, 'Valparaiso', 6, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(21, 'Chacabuco', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(22, 'Cordillera', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(23, 'Maipo', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(24, 'Melipilla', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(25, 'Santiago', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(26, 'Talagante', 7, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(27, 'Cachapoal', 8, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(28, 'Cardenal Caro', 8, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(29, 'Colchagua', 8, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(30, 'Cauquenes', 9, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(31, 'Curicó', 9, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(32, 'Linares', 9, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(33, 'Talca', 9, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(34, 'Arauco', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(35, 'Bio Bío', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(36, 'Concepción', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(37, 'Ñuble', 10, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(38, 'Cautín', 11, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(39, 'Malleco', 11, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(40, 'Valdivia', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(41, 'Ranco', 12, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(42, 'Chiloé', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(43, 'Llanquihue', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(44, 'Osorno', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(45, 'Palena', 13, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(46, 'Aisén', 14, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(47, 'Capitán Prat', 14, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(48, 'Coihaique', 14, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(49, 'General Carrera', 14, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(50, 'Antártica Chilena', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(51, 'Magallanes', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(52, 'Tierra del Fuego', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(53, 'Última Esperanza', 15, '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regions`
--

CREATE TABLE `regions` (
  `region_id` int(10) UNSIGNED NOT NULL,
  `region_nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_ordinal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `regions`
--

INSERT INTO `regions` (`region_id`, `region_nombre`, `region_ordinal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Arica y Parinacota', 'XV', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(2, 'Tarapacá', 'I', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(3, 'Antofagasta', 'II', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(4, 'Atacama', 'III', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(5, 'Coquimbo', 'IV', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(6, 'Valparaiso', 'V', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(7, 'Metropolitana de Santiago', 'RM', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(8, 'Libertador General Bernardo OHiggins', 'VI', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(9, 'Maule', 'VII', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(10, 'Biobío', 'VIII', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(11, 'La Araucanía', 'IX', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(12, 'Los Ríos', 'XIV', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(13, 'Los Lagos', 'X', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(14, 'Aisén del General Carlos Ibáñez del Campo', 'XI', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL),
(15, 'Magallanes y de la Antártica Chilena', 'XII', '2018-06-17 23:04:23', '2018-06-17 23:04:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `special` enum('all-access','no-access') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`, `special`) VALUES
(1, 'Admin', 'admin', NULL, '2018-06-17 23:04:24', '2018-06-17 23:04:24', 'all-access'),
(2, 'Contact Center', 'Contact Center', NULL, '2018-06-17 23:04:24', '2018-06-17 23:04:24', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-06-17 23:04:24', '2018-06-17 23:04:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_persona` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `id_persona`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador del Sistema', 'admin@ibaquedano.cl', '$2y$10$wps3ycLb.6XepgAgCHSbyeNP8MUrzSFAJG3hXJwq9kkVdfSFZLHX.', 1, NULL, '2018-06-17 23:04:24', '2018-06-17 23:04:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adm_fotorevinmueble`
--
ALTER TABLE `adm_fotorevinmueble`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adm_fotorevinmueble_id_inmueble_foreign` (`id_inmueble`);

--
-- Indices de la tabla `adm_fotorevpersona`
--
ALTER TABLE `adm_fotorevpersona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adm_fotorevpersona_id_persona_foreign` (`id_persona`);

--
-- Indices de la tabla `adm_revisioninmueble`
--
ALTER TABLE `adm_revisioninmueble`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adm_revisioninmueble_id_inmueble_foreign` (`id_inmueble`);

--
-- Indices de la tabla `adm_revisionpersona`
--
ALTER TABLE `adm_revisionpersona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adm_revisionpersona_id_persona_foreign` (`id_persona`);

--
-- Indices de la tabla `arrendatariocitas`
--
ALTER TABLE `arrendatariocitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arrendatariocitas_id_arrendatario_foreign` (`id_arrendatario`);

--
-- Indices de la tabla `arrendatarioimgs`
--
ALTER TABLE `arrendatarioimgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arrendatarioimgs_id_arrendatario_foreign` (`id_arrendatario`);

--
-- Indices de la tabla `arrendatarios`
--
ALTER TABLE `arrendatarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arrendatarios_id_arrendatario_foreign` (`id_arrendatario`),
  ADD KEY `arrendatarios_id_creador_foreign` (`id_creador`),
  ADD KEY `arrendatarios_id_modificador_foreign` (`id_modificador`);

--
-- Indices de la tabla `borradores`
--
ALTER TABLE `borradores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borradores_id_notaria_foreign` (`id_notaria`),
  ADD KEY `borradores_id_servicios_foreign` (`id_servicios`),
  ADD KEY `borradores_id_comisiones_foreign` (`id_comisiones`),
  ADD KEY `borradores_id_flexibilidad_foreign` (`id_flexibilidad`),
  ADD KEY `borradores_id_publicacion_foreign` (`id_publicacion`),
  ADD KEY `borradores_id_creador_foreign` (`id_creador`),
  ADD KEY `borradores_id_modificador_foreign` (`id_modificador`);

--
-- Indices de la tabla `borradorespdf`
--
ALTER TABLE `borradorespdf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borradorespdf_id_borrador_foreign` (`id_borrador`);

--
-- Indices de la tabla `cap_corredores`
--
ALTER TABLE `cap_corredores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cap_corredores_id_corredor_foreign` (`id_corredor`),
  ADD KEY `cap_corredores_id_propietario_foreign` (`id_propietario`),
  ADD KEY `cap_corredores_id_inmueble_foreign` (`id_inmueble`),
  ADD KEY `cap_corredores_id_creador_foreign` (`id_creador`),
  ADD KEY `cap_corredores_id_modificador_foreign` (`id_modificador`);

--
-- Indices de la tabla `cap_gestion`
--
ALTER TABLE `cap_gestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cap_gestion_id_captacion_gestion_foreign` (`id_captacion_gestion`);

--
-- Indices de la tabla `cap_gestioncorredor`
--
ALTER TABLE `cap_gestioncorredor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cap_gestioncorredor_id_capcorredor_gestion_foreign` (`id_capcorredor_gestion`);

--
-- Indices de la tabla `cap_imagecorredor`
--
ALTER TABLE `cap_imagecorredor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cap_imagecorredor_id_capcorredor_foreign` (`id_capcorredor`);

--
-- Indices de la tabla `cap_imagenes`
--
ALTER TABLE `cap_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cap_imagenes_id_captacion_foreign` (`id_captacion`);

--
-- Indices de la tabla `cap_import`
--
ALTER TABLE `cap_import`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cap_publicaciones`
--
ALTER TABLE `cap_publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cap_publicaciones_id_propietario_foreign` (`id_propietario`),
  ADD KEY `cap_publicaciones_id_inmueble_foreign` (`id_inmueble`),
  ADD KEY `cap_publicaciones_id_creador_foreign` (`id_creador`),
  ADD KEY `cap_publicaciones_id_modificador_foreign` (`id_modificador`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comisiones`
--
ALTER TABLE `comisiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comunas`
--
ALTER TABLE `comunas`
  ADD PRIMARY KEY (`comuna_id`);

--
-- Indices de la tabla `condicions`
--
ALTER TABLE `condicions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `flexibilidads`
--
ALTER TABLE `flexibilidads`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `formasdepagos`
--
ALTER TABLE `formasdepagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inmuebles`
--
ALTER TABLE `inmuebles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `multas`
--
ALTER TABLE `multas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notarias`
--
ALTER TABLE `notarias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indices de la tabla `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_user_permission_id_index` (`permission_id`),
  ADD KEY `permission_user_user_id_index` (`user_id`);

--
-- Indices de la tabla `personainmuebles`
--
ALTER TABLE `personainmuebles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personainmuebles_id_persona_foreign` (`id_persona`),
  ADD KEY `personainmuebles_id_inmueble_foreign` (`id_inmueble`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personas_cargo_id_foreign` (`cargo_id`);

--
-- Indices de la tabla `portales`
--
ALTER TABLE `portales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`provincia_id`);

--
-- Indices de la tabla `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_index` (`role_id`),
  ADD KEY `role_user_user_id_index` (`user_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_persona_foreign` (`id_persona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adm_fotorevinmueble`
--
ALTER TABLE `adm_fotorevinmueble`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `adm_fotorevpersona`
--
ALTER TABLE `adm_fotorevpersona`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `adm_revisioninmueble`
--
ALTER TABLE `adm_revisioninmueble`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `adm_revisionpersona`
--
ALTER TABLE `adm_revisionpersona`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `arrendatariocitas`
--
ALTER TABLE `arrendatariocitas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `arrendatarioimgs`
--
ALTER TABLE `arrendatarioimgs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `arrendatarios`
--
ALTER TABLE `arrendatarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `borradores`
--
ALTER TABLE `borradores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `borradorespdf`
--
ALTER TABLE `borradorespdf`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cap_corredores`
--
ALTER TABLE `cap_corredores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cap_gestion`
--
ALTER TABLE `cap_gestion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cap_gestioncorredor`
--
ALTER TABLE `cap_gestioncorredor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cap_imagecorredor`
--
ALTER TABLE `cap_imagecorredor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cap_imagenes`
--
ALTER TABLE `cap_imagenes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cap_import`
--
ALTER TABLE `cap_import`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cap_publicaciones`
--
ALTER TABLE `cap_publicaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comisiones`
--
ALTER TABLE `comisiones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comunas`
--
ALTER TABLE `comunas`
  MODIFY `comuna_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;

--
-- AUTO_INCREMENT de la tabla `condicions`
--
ALTER TABLE `condicions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `flexibilidads`
--
ALTER TABLE `flexibilidads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formasdepagos`
--
ALTER TABLE `formasdepagos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inmuebles`
--
ALTER TABLE `inmuebles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `multas`
--
ALTER TABLE `multas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notarias`
--
ALTER TABLE `notarias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permission_user`
--
ALTER TABLE `permission_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personainmuebles`
--
ALTER TABLE `personainmuebles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `portales`
--
ALTER TABLE `portales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `provincia_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adm_fotorevinmueble`
--
ALTER TABLE `adm_fotorevinmueble`
  ADD CONSTRAINT `adm_fotorevinmueble_id_inmueble_foreign` FOREIGN KEY (`id_inmueble`) REFERENCES `inmuebles` (`id`);

--
-- Filtros para la tabla `adm_fotorevpersona`
--
ALTER TABLE `adm_fotorevpersona`
  ADD CONSTRAINT `adm_fotorevpersona_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `adm_revisioninmueble`
--
ALTER TABLE `adm_revisioninmueble`
  ADD CONSTRAINT `adm_revisioninmueble_id_inmueble_foreign` FOREIGN KEY (`id_inmueble`) REFERENCES `inmuebles` (`id`);

--
-- Filtros para la tabla `adm_revisionpersona`
--
ALTER TABLE `adm_revisionpersona`
  ADD CONSTRAINT `adm_revisionpersona_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `arrendatariocitas`
--
ALTER TABLE `arrendatariocitas`
  ADD CONSTRAINT `arrendatariocitas_id_arrendatario_foreign` FOREIGN KEY (`id_arrendatario`) REFERENCES `arrendatarios` (`id`);

--
-- Filtros para la tabla `arrendatarioimgs`
--
ALTER TABLE `arrendatarioimgs`
  ADD CONSTRAINT `arrendatarioimgs_id_arrendatario_foreign` FOREIGN KEY (`id_arrendatario`) REFERENCES `arrendatarios` (`id`);

--
-- Filtros para la tabla `arrendatarios`
--
ALTER TABLE `arrendatarios`
  ADD CONSTRAINT `arrendatarios_id_arrendatario_foreign` FOREIGN KEY (`id_arrendatario`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `arrendatarios_id_creador_foreign` FOREIGN KEY (`id_creador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `arrendatarios_id_modificador_foreign` FOREIGN KEY (`id_modificador`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `borradores`
--
ALTER TABLE `borradores`
  ADD CONSTRAINT `borradores_id_comisiones_foreign` FOREIGN KEY (`id_comisiones`) REFERENCES `comisiones` (`id`),
  ADD CONSTRAINT `borradores_id_creador_foreign` FOREIGN KEY (`id_creador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `borradores_id_flexibilidad_foreign` FOREIGN KEY (`id_flexibilidad`) REFERENCES `flexibilidads` (`id`),
  ADD CONSTRAINT `borradores_id_modificador_foreign` FOREIGN KEY (`id_modificador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `borradores_id_notaria_foreign` FOREIGN KEY (`id_notaria`) REFERENCES `notarias` (`id`),
  ADD CONSTRAINT `borradores_id_publicacion_foreign` FOREIGN KEY (`id_publicacion`) REFERENCES `cap_publicaciones` (`id`),
  ADD CONSTRAINT `borradores_id_servicios_foreign` FOREIGN KEY (`id_servicios`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `borradorespdf`
--
ALTER TABLE `borradorespdf`
  ADD CONSTRAINT `borradorespdf_id_borrador_foreign` FOREIGN KEY (`id_borrador`) REFERENCES `borradores` (`id`);

--
-- Filtros para la tabla `cap_corredores`
--
ALTER TABLE `cap_corredores`
  ADD CONSTRAINT `cap_corredores_id_corredor_foreign` FOREIGN KEY (`id_corredor`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `cap_corredores_id_creador_foreign` FOREIGN KEY (`id_creador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `cap_corredores_id_inmueble_foreign` FOREIGN KEY (`id_inmueble`) REFERENCES `inmuebles` (`id`),
  ADD CONSTRAINT `cap_corredores_id_modificador_foreign` FOREIGN KEY (`id_modificador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `cap_corredores_id_propietario_foreign` FOREIGN KEY (`id_propietario`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `cap_gestion`
--
ALTER TABLE `cap_gestion`
  ADD CONSTRAINT `cap_gestion_id_captacion_gestion_foreign` FOREIGN KEY (`id_captacion_gestion`) REFERENCES `cap_publicaciones` (`id`);

--
-- Filtros para la tabla `cap_gestioncorredor`
--
ALTER TABLE `cap_gestioncorredor`
  ADD CONSTRAINT `cap_gestioncorredor_id_capcorredor_gestion_foreign` FOREIGN KEY (`id_capcorredor_gestion`) REFERENCES `cap_corredores` (`id`);

--
-- Filtros para la tabla `cap_imagecorredor`
--
ALTER TABLE `cap_imagecorredor`
  ADD CONSTRAINT `cap_imagecorredor_id_capcorredor_foreign` FOREIGN KEY (`id_capcorredor`) REFERENCES `cap_corredores` (`id`);

--
-- Filtros para la tabla `cap_imagenes`
--
ALTER TABLE `cap_imagenes`
  ADD CONSTRAINT `cap_imagenes_id_captacion_foreign` FOREIGN KEY (`id_captacion`) REFERENCES `cap_publicaciones` (`id`);

--
-- Filtros para la tabla `cap_publicaciones`
--
ALTER TABLE `cap_publicaciones`
  ADD CONSTRAINT `cap_publicaciones_id_creador_foreign` FOREIGN KEY (`id_creador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `cap_publicaciones_id_inmueble_foreign` FOREIGN KEY (`id_inmueble`) REFERENCES `inmuebles` (`id`),
  ADD CONSTRAINT `cap_publicaciones_id_modificador_foreign` FOREIGN KEY (`id_modificador`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `cap_publicaciones_id_propietario_foreign` FOREIGN KEY (`id_propietario`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personainmuebles`
--
ALTER TABLE `personainmuebles`
  ADD CONSTRAINT `personainmuebles_id_inmueble_foreign` FOREIGN KEY (`id_inmueble`) REFERENCES `inmuebles` (`id`),
  ADD CONSTRAINT `personainmuebles_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_cargo_id_foreign` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`);

--
-- Filtros para la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
