-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2021 a las 15:52:10
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facturacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catsatclavesprodserv`
--

CREATE TABLE `catsatclavesprodserv` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Emisor` int(11) NOT NULL,
  `ClaveProdServ` varchar(8) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `catsatclavesprodserv`
--

INSERT INTO `catsatclavesprodserv` (`Id`, `Estatus`, `Emisor`, `ClaveProdServ`, `Descripcion`) VALUES
(7, 0, 1, '10101500', 'Animales vivos de granja'),
(9, 0, 1, '10101502', 'Perros'),
(10, 0, 1, '50211502', 'Cigarrillos o cigarros'),
(11, 1, 1, '50201708', 'Bebida de café'),
(12, 1, 1, '50192100', 'Botanas'),
(13, 1, 1, '50202307', 'Bebida de chocolate o malta u otros'),
(14, 1, 1, '50181900', 'Pan, galletas y pastelitos dulces'),
(15, 1, 1, '50202201', 'Cerveza'),
(16, 0, 1, '10111301', 'Juguetes para mascotas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catsatformaspago`
--

CREATE TABLE `catsatformaspago` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Emisor` int(11) NOT NULL,
  `ClaveFormaPago` varchar(2) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `catsatformaspago`
--

INSERT INTO `catsatformaspago` (`Id`, `Estatus`, `Emisor`, `ClaveFormaPago`, `Descripcion`) VALUES
(1, 1, 1, '01', 'Efectivo'),
(2, 1, 1, '04', 'Tarjeta de crédito'),
(3, 0, 1, '03', 'Transferencia electrónica de fondos'),
(4, 0, 1, '06', 'Dinero electrónico'),
(6, 1, 1, '05', 'Monedero electrónico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catsatimpuestos`
--

CREATE TABLE `catsatimpuestos` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Emisor` int(11) NOT NULL,
  `ClaveImpuesto` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Retencion` int(11) NOT NULL,
  `Traslado` int(11) NOT NULL,
  `Factor` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Tasa_Cuota` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `catsatimpuestos`
--

INSERT INTO `catsatimpuestos` (`Id`, `Estatus`, `Emisor`, `ClaveImpuesto`, `Descripcion`, `Retencion`, `Traslado`, `Factor`, `Tasa_Cuota`) VALUES
(1, 1, 1, '002', 'IVA 16', 1, 1, 'Tasa', '0.16'),
(2, 1, 1, '003', 'IEPS 10', 1, 1, 'Tasa', '0.10'),
(10, 0, 1, '002', 'IVA al 8%', 1, 1, 'Tasa', '0.08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catsatmetodos`
--

CREATE TABLE `catsatmetodos` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Emisor` int(11) NOT NULL,
  `ClaveMetodo` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `catsatmetodos`
--

INSERT INTO `catsatmetodos` (`Id`, `Estatus`, `Emisor`, `ClaveMetodo`, `Descripcion`) VALUES
(1, 1, 1, 'PUE', 'Pago en una sola exhibición'),
(2, 1, 1, 'PPD', 'Pago en parcialidades o diferido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catsatmoneda`
--

CREATE TABLE `catsatmoneda` (
  `Id` int(11) NOT NULL,
  `Estatus` int(11) NOT NULL DEFAULT 1,
  `Emisor` int(11) NOT NULL,
  `ClaveMoneda` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `NoDecimales` int(11) NOT NULL,
  `Variacion` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `catsatmoneda`
--

INSERT INTO `catsatmoneda` (`Id`, `Estatus`, `Emisor`, `ClaveMoneda`, `Nombre`, `NoDecimales`, `Variacion`, `FechaInicio`, `FechaFin`) VALUES
(1, 1, 1, 'MXN', 'Peso Mexicano', 2, '500%', '2017-08-14', NULL),
(4, 1, 1, 'USD', 'Dolar americano', 2, '500%', '0000-00-00', '0000-00-00'),
(5, 0, 1, 'AED', 'Dirham de EAU', 2, '500%', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catsatunidades`
--

CREATE TABLE `catsatunidades` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Emisor` int(11) NOT NULL,
  `ClaveUnidad` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `NombreUnidad` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Simbolo` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `catsatunidades`
--

INSERT INTO `catsatunidades` (`Id`, `Estatus`, `Emisor`, `ClaveUnidad`, `NombreUnidad`, `Descripcion`, `Simbolo`) VALUES
(1, 1, 1, 'H87', 'Pieza', 'Unidad de conteo que define el número de piezas (pieza: un solo artículo, artículo o ejemplar).', ''),
(2, 1, 1, '26', 'Tonelada real', '', ''),
(3, 0, 1, '72', 'Vatio por libra', '', ''),
(4, 0, 1, 'DMK', 'Decímetro cuadrado ', 'Medida de longitud, de símbolo dm, que es igual a la décima parte de un metro.', 'dm²'),
(5, 1, 1, 'KGM', 'Kilogramo', 'Una unidad de masa igual a mil gramos.', 'kg'),
(8, 1, 1, 'A76', 'Galón', 'Es una unidad de volumen que se emplea en los países anglófonos (especialmente Estados Unidos) o con influencia de estos (como Liberia, Guatemala, Panamá, Honduras, Nicaragua, El Salvador, Colombia y parcialmente en México), para medir volúmenes de líquido', 'Gal'),
(9, 1, 1, '1X', 'Cuarto de milla', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catsatusocfdi`
--

CREATE TABLE `catsatusocfdi` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Emisor` int(11) NOT NULL,
  `ClaveUso` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Concepto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Fisica` int(1) NOT NULL,
  `Moral` int(1) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `catsatusocfdi`
--

INSERT INTO `catsatusocfdi` (`Id`, `Estatus`, `Emisor`, `ClaveUso`, `Concepto`, `Fisica`, `Moral`, `FechaInicio`, `FechaFin`) VALUES
(1, 1, 1, 'P01', 'Por definir', 1, 1, '2017-03-31', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cfdi`
--

CREATE TABLE `cfdi` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 0,
  `Emisor` int(11) NOT NULL,
  `ClienteId` int(11) NOT NULL,
  `Serie` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Folio` varchar(40) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Moneda` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `TipoCambio` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `TipoComprobante` varchar(1) COLLATE utf8mb4_spanish_ci NOT NULL,
  `CondicionesPago` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `NoCertificado` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `MetodoPago` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `FormaPago` varchar(2) COLLATE utf8mb4_spanish_ci NOT NULL,
  `UsoCFDI` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `DescUsoCFDI` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '-----',
  `LugarExpedicion` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Regimen` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Subtotal` float NOT NULL,
  `IVA` float NOT NULL DEFAULT 0,
  `IEPS` float NOT NULL DEFAULT 0,
  `RetIva` float NOT NULL DEFAULT 0,
  `TotalRetenido` float NOT NULL DEFAULT 0,
  `TotalTraslado` float NOT NULL DEFAULT 0,
  `Descuento` float NOT NULL,
  `Total` double NOT NULL,
  `UUID` varchar(36) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `FechaCertificado` date DEFAULT NULL,
  `HoraCertificado` time DEFAULT NULL,
  `EstatusSAT` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `PathXML` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `PathPDF` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Creado` datetime DEFAULT current_timestamp(),
  `Observaciones` text COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cfdi`
--

INSERT INTO `cfdi` (`Id`, `Estatus`, `Emisor`, `ClienteId`, `Serie`, `Folio`, `Fecha`, `Hora`, `Moneda`, `TipoCambio`, `TipoComprobante`, `CondicionesPago`, `NoCertificado`, `MetodoPago`, `FormaPago`, `UsoCFDI`, `DescUsoCFDI`, `LugarExpedicion`, `Regimen`, `Subtotal`, `IVA`, `IEPS`, `RetIva`, `TotalRetenido`, `TotalTraslado`, `Descuento`, `Total`, `UUID`, `FechaCertificado`, `HoraCertificado`, `EstatusSAT`, `PathXML`, `PathPDF`, `Creado`, `Observaciones`) VALUES
(38, 0, 1, 1, 'A', '10', '2021-05-05', '14:11:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 700, 112, 0, 0, 0, 112, 50, 762.01, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-21 19:03:14', 'Probando sin IEPS'),
(64, 3, 1, 1, 'A', '36', '2020-04-07', '19:46:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 0, 990, 'EE18EF80-9272-43D6-93FC-3BB9480E3A8C', '2021-05-07', '19:46:55', 'Cancelado', './comprobantes/AAA010101AAA/A/36/64.xml', './comprobantes/AAA010101AAA/A/36/64.pdf', '2021-05-21 19:03:14', 'Emisor: IQH8611177D9\r\nReceptor: DME0606212Z4\r\nUUID: EE18EF80-9272-43D6-93FC-3BB9480E3A8C\r\nTotal: 990.00\r\n-------------------------------------------\r\nRFC Para timbrar: EKU9003173C9\r\nRFC Cliente Original: XAXX010101000\r\nUUID: 3290cb1d-87ca-4664-8858-0e222a196ef7\r\nTotal: 16240\r\n'),
(65, 1, 1, 1, 'A', '37', '2021-04-07', '20:11:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 0, 16240, '16a63b53-e996-4653-b216-9b375ed60e68', '2021-05-07', '20:12:03', NULL, './comprobantes/AAA010101AAA/A/37/65.xml', './comprobantes/AAA010101AAA/A/37/65.pdf', '2021-05-21 19:03:14', ''),
(66, 1, 1, 1, 'A', '38', '2021-05-07', '20:32:00', 'MXN', '1.00', 'I', '1 Mes', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 0, 16240, 'f963f040-3d0f-4d2e-830c-885535993ec0', '2021-05-07', '20:33:09', NULL, './comprobantes/AAA010101AAA/A/38/66.xml', './comprobantes/AAA010101AAA/A/38/66.pdf', '2021-05-21 19:03:14', 'Probando Crear archivo PDF'),
(67, 1, 1, 1, 'A', '39', '2021-05-07', '20:39:00', 'MXN', '1.00', 'I', '1 Mes', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 0, 16240, '89501b35-8a91-4072-a763-331c0399767a', '2021-05-07', '20:40:00', NULL, './comprobantes/AAA010101AAA/A/39/67.xml', './comprobantes/AAA010101AAA/A/39/67.pdf', '2021-05-21 19:03:14', ''),
(68, 1, 1, 1, 'A', '40', '2021-05-18', '13:38:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '04', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 500, 15740, '8f67a599-906a-444e-86c4-986c03681b82', '2021-05-19', '16:36:49', NULL, './comprobantes/EKU9003173C9/A/40/68.xml', './comprobantes/EKU9003173C9/A/40/68.pdf', '2021-05-21 19:03:14', 'Nueva prueba...'),
(69, 0, 1, 1, 'A', '41', '2021-05-18', '13:38:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '04', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 500, 15740, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-21 19:03:14', 'Nueva prueba...'),
(70, 1, 1, 1, 'A', '42', '2021-05-18', '15:42:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, 'd24f945f-5de9-4fb3-815f-244db054433a', '2021-05-19', '16:43:49', NULL, './comprobantes/EKU9003173C9/A/42/70.xml', './comprobantes/EKU9003173C9/A/42/70.pdf', '2021-05-21 19:03:14', ''),
(71, 1, 1, 1, 'A', '43', '2021-05-19', '18:32:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 70, 11.2, 0, 0, 0, 11.2, 0, 81.2, '459fc220-f224-4fb6-8858-46ad56c73d5a', '2021-05-19', '18:35:24', NULL, './comprobantes/EKU9003173C9/A/43/71.xml', './comprobantes/EKU9003173C9/A/43/71.pdf', '2021-05-21 19:03:14', 'Probando...'),
(72, 3, 1, 1, 'A', '44', '2021-05-20', '01:38:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 70, 11.2, 0, 0, 0, 11.2, 10, 71.2, '70a6c203-cfda-471e-ba5c-99ca4e95e000', '2021-05-21', '01:39:08', NULL, './comprobantes/EKU9003173C9/A/44/72.xml', './comprobantes/EKU9003173C9/A/44/72.pdf', '2021-05-21 19:03:14', ''),
(73, 3, 1, 1, 'A', '45', '2021-05-21', '02:46:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 0, 16240, 'c11e6899-b499-48fe-94a2-c9b5787ae93b', '2021-05-21', '02:47:26', NULL, './comprobantes/EKU9003173C9/A/45/73.xml', './comprobantes/EKU9003173C9/A/45/73.pdf', '2021-05-21 19:03:14', ''),
(74, 3, 1, 1, 'A', '46', '2021-05-21', '02:50:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 70, 11.2, 0, 0, 0, 11.2, 0, 81.2, '9e9cfe0d-b2f9-4e71-a89d-a206992cf5fb', '2021-05-21', '02:51:12', NULL, './comprobantes/EKU9003173C9/A/46/74.xml', './comprobantes/EKU9003173C9/A/46/74.pdf', '2021-05-21 19:03:14', 'Probando Cancelaciones.'),
(75, 3, 1, 1, 'A', '47', '2021-05-21', '02:54:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 700, 112, 0, 0, 0, 112, 0, 812, 'a1151469-81a3-4df7-91d4-018ce840720e', '2021-05-21', '02:55:05', NULL, './comprobantes/EKU9003173C9/A/47/75.xml', './comprobantes/EKU9003173C9/A/47/75.pdf', '2021-05-21 19:03:14', 'Probando cancelación de CFDI.'),
(76, 0, 1, 1, 'A', '48', '2021-05-21', '03:36:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-21 19:03:14', 'Nuevo CFDI.'),
(77, 3, 1, 1, 'A', '49', '2021-05-21', '03:39:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 700, 112, 0, 0, 0, 112, 0, 812, 'a54cc440-844e-45e7-9be0-c1b5cf66074e', '2021-05-21', '03:40:53', NULL, './comprobantes/EKU9003173C9/A/49/77.xml', './comprobantes/EKU9003173C9/A/49/77.pdf', '2021-05-21 19:03:14', ''),
(78, 3, 1, 1, 'A', '50', '2021-05-21', '17:50:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-21 19:03:14', 'Probando Cancelaciones.'),
(79, 4, 1, 1, 'A', '51', '2021-05-21', '18:36:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '04', 'P01', '-----', '56260', '601', 42, 6.72, 0, 0, 0, 6.72, 0, 48.72, 'bde3b69c-1a31-44c4-8d9b-c738c362b3b9', '2021-05-21', '18:36:50', NULL, './comprobantes/EKU9003173C9/A/51/79.xml', './comprobantes/EKU9003173C9/A/51/79.pdf', '2021-05-21 19:03:14', 'Prueba cancelar CFDI Timbrado.'),
(80, 0, 1, 1, 'A', '52', '2021-05-21', '18:43:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-21 19:03:14', 'Comprobante de prueba, dejar en NUEVO.'),
(81, 4, 1, 1, 'A', '53', '2021-05-21', '19:04:00', 'MXN', '1.00', 'I', '', NULL, 'PPD', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, 'bc383571-d046-46ab-9622-16bd10139e6f', '2021-05-21', '19:26:17', NULL, './comprobantes/EKU9003173C9/A/53/81.xml', './comprobantes/EKU9003173C9/A/53/81.pdf', '2021-05-21 19:04:25', 'Probando FechaCreado.'),
(82, 0, 1, 1, 'A', '54', '2021-05-22', '01:48:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-22 01:48:24', ''),
(83, 0, 1, 1, 'A', '55', '2021-05-22', '14:13:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-22 14:13:51', 'Probando NoCertificado.'),
(84, 3, 1, 1, 'A', '56', '2021-05-22', '14:13:00', 'MXN', '', '', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 140, 22.4, 0, 0, 0, 22.4, 35, 127.4, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-22 14:28:40', 'Error en RFC. Este comprobante no sirve.'),
(85, 0, 1, 1, 'A', '57', '2021-05-22', '14:38:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 70, 11.2, 0, 0, 0, 11.2, 0, 81.2, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-22 14:39:11', 'Probando que se guarde correctamente.'),
(86, 0, 1, 1, 'A', '58', '2021-05-22', '14:49:00', 'MXN', '1.00', 'I', '', NULL, 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-22 14:50:01', 'Debe Guardar el NoCertificado.'),
(87, 1, 1, 1, 'A', '59', '2021-05-22', '14:51:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '04', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 150, 1474, 'd28e82bc-ec6b-40e8-a609-84bbc05a3c94', '2021-05-22', '14:52:39', NULL, './comprobantes/EKU9003173C9/A/59/87.xml', './comprobantes/EKU9003173C9/A/59/87.pdf', '2021-05-22 14:51:48', 'Ahora si debe Guardar el NoCertificado.'),
(88, 1, 1, 1, 'A', '60', '2021-05-25', '23:25:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '04', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 15, 1609, '48c37ba4-2da2-4d62-9b58-d172d174a69c', '2021-05-25', '23:26:07', NULL, './comprobantes/EKU9003173C9/A/60/88.xml', './comprobantes/EKU9003173C9/A/60/88.pdf', '2021-05-25 23:25:37', 'Prueba...'),
(89, 0, 1, 2, 'A', '61', '2021-05-27', '15:07:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'D10', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-27 15:07:47', 'Prueba con otro cliente.'),
(90, 0, 1, 1, 'A', '62', '2021-05-27', '15:15:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'G01', '-----', '56260', '601', 140, 22.4, 0, 0, 0, 22.4, 0, 162.4, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-27 15:15:23', 'Probando...'),
(91, 0, 1, 2, 'A', '63', '2021-05-28', '02:10:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 50, 1574, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-28 02:11:32', 'Prueba del día xD'),
(92, 1, 1, 1, 'A', '64', '2021-05-28', '02:14:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 50, 1574, '83cbcd1e-0765-468d-acd0-c1716ee69101', '2021-05-28', '02:15:56', NULL, './comprobantes/EKU9003173C9/A/64/92.xml', './comprobantes/EKU9003173C9/A/64/92.pdf', '2021-05-28 02:15:30', 'Prueba...'),
(93, 4, 1, 2, 'B', '1', '2021-05-31', '18:50:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, 'bfc46fda-ca2c-4a2f-ab2d-cf4025e7a1a2', '2021-05-31', '19:23:28', NULL, './comprobantes/EKU9003173C9/B/1/93.xml', './comprobantes/EKU9003173C9/B/1/93.pdf', '2021-05-31 18:52:34', 'Probando con una nueva serie.'),
(94, 1, 1, 2, 'A', '65', '2021-05-31', '18:55:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'D08', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, 'b44ee519-178e-4406-a356-f1385e268473', '2021-05-31', '19:23:57', NULL, './comprobantes/EKU9003173C9/A/65/94.xml', './comprobantes/EKU9003173C9/A/65/94.pdf', '2021-05-31 18:56:04', 'Prueba porque no sé por qué no timbra.'),
(95, 0, 1, 1, 'B', '2', '2021-05-31', '19:24:00', 'AED', '', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-31 19:24:41', 'Probando...'),
(96, 1, 1, 1, 'A', '66', '2021-05-31', '19:31:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 700, 112, 0, 0, 0, 112, 0, 812, 'ebc61c19-5ec5-4f35-a0ca-9c26cb18cca0', '2021-05-31', '19:31:52', NULL, './comprobantes/EKU9003173C9/A/66/96.xml', './comprobantes/EKU9003173C9/A/66/96.pdf', '2021-05-31 19:31:38', 'No sé por qué ya no timbra algunos CFDI.'),
(97, 1, 1, 1, 'A', '67', '2021-05-31', '21:11:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '05', 'P01', '-----', '56260', '601', 14000, 2240, 0, 0, 0, 2240, 100, 16140, 'fc528f29-76ac-4ef8-8f1b-14cb26eb196d', '2021-05-31', '21:12:06', NULL, './comprobantes/EKU9003173C9/A/67/97.xml', './comprobantes/EKU9003173C9/A/67/97.pdf', '2021-05-31 21:11:49', 'Última prueba del día.'),
(98, 1, 1, 2, 'C', '1', '2021-05-31', '15:59:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 70, 11.2, 0, 0, 0, 11.2, 0, 81.2, '7546cf3e-437e-4df9-8191-a20e3fb1332c', '2021-06-01', '16:06:51', NULL, './comprobantes/EKU9003173C9/C/1/98.xml', './comprobantes/EKU9003173C9/C/1/98.pdf', '2021-06-01 16:00:58', 'Prueba del día...'),
(99, 0, 1, 2, 'A', '68', '2021-06-01', '20:47:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 140, 22.4, 0, 0, 0, 22.4, 0, 162.4, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-01 20:48:01', 'Probando con Emisor actualizado'),
(100, 1, 1, 1, 'A', '69', '2021-06-01', '20:48:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 140, 22.4, 0, 0, 0, 22.4, 0, 162.4, '1d26f308-d2c4-4482-815f-9177aa75d43d', '2021-06-02', '12:58:16', NULL, './comprobantes/EKU9003173C9/A/69/100.xml', './comprobantes/EKU9003173C9/A/69/100.pdf', '2021-06-01 20:48:53', 'Probando...'),
(101, 0, 1, 1, 'A', '70', '2021-06-01', '20:57:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 140, 22.4, 0, 0, 0, 22.4, 0, 162.4, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-01 20:58:43', 'Prueba porque no sé por qué ya no timbra.'),
(102, 1, 1, 2, 'A', '71', '2021-06-01', '20:59:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PPD', '01', 'G01', '-----', '56260', '601', 700, 112, 0, 0, 0, 112, 0, 812, '15709e66-9595-4d44-9720-7ee63e1a558c', '2021-06-02', '12:57:56', NULL, './comprobantes/EKU9003173C9/A/71/102.xml', './comprobantes/EKU9003173C9/A/71/102.pdf', '2021-06-01 21:00:15', ''),
(103, 1, 1, 1, 'A', '72', '2021-06-02', '12:56:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, '011ad864-bf43-4b6f-a728-9dd985d580d3', '2021-06-02', '12:57:34', NULL, './comprobantes/EKU9003173C9/A/72/103.xml', './comprobantes/EKU9003173C9/A/72/103.pdf', '2021-06-02 12:57:19', 'Por favor que timbre :('),
(104, 1, 1, 1, 'A', '73', '2021-06-04', '09:29:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'G01', '-----', '56260', '601', 70, 11.2, 0, 0, 0, 11.2, 0, 81.2, '747de758-e06c-4184-84bf-9c926db6241b', '2021-06-04', '09:29:53', NULL, './comprobantes/EKU9003173C9/A/73/104.xml', './comprobantes/EKU9003173C9/A/73/104.pdf', '2021-06-04 09:29:30', ''),
(105, 1, 1, 1, 'A', '74', '2021-06-04', '15:57:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 1400, 224, 0, 0, 0, 224, 0, 1624, 'ea87bc50-b344-4960-80f3-0773cab02d31', '2021-06-04', '15:58:35', NULL, './comprobantes/EKU9003173C9/A/74/105.xml', './comprobantes/EKU9003173C9/A/74/105.pdf', '2021-06-04 15:57:43', 'Prueba del día'),
(106, 1, 1, 2, 'A', '75', '2021-06-04', '15:57:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 2300, 368, 0, 0, 0, 368, 0, 2668, 'e4592f27-762d-4106-9d2c-c60c812afe0d', '2021-06-04', '15:59:10', NULL, './comprobantes/EKU9003173C9/A/75/106.xml', './comprobantes/EKU9003173C9/A/75/106.pdf', '2021-06-04 15:58:27', 'Probando con Producto Nuevo'),
(107, 1, 1, 1, 'A', '76', '2021-06-03', '18:42:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 140, 22.4, 0, 0, 0, 22.4, 0, 162.4, 'c1b4c7c4-6687-481d-8e38-122b105ef662', '2021-06-04', '19:08:44', NULL, './comprobantes/EKU9003173C9/A/76/107.xml', './comprobantes/EKU9003173C9/A/76/107.pdf', '2021-06-04 18:42:46', 'Probando con el nuevo modelo'),
(108, 0, 1, 1, 'A', '77', '2021-06-04', '19:06:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'G01', '-----', '56260', '601', 115, 18.4, 0, 0, 0, 18.4, 0, 133.4, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-04 19:06:46', 'Prueba con nuevo modelo.'),
(109, 1, 1, 2, 'A', '78', '2021-06-04', '20:26:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 114, 18.24, 0, 0, 0, 18.24, 0, 132.24, 'e364c42c-870d-45ad-b552-3dc8930da043', '2021-06-04', '20:28:48', NULL, './comprobantes/EKU9003173C9/A/78/109.xml', './comprobantes/EKU9003173C9/A/78/109.pdf', '2021-06-04 20:27:59', ''),
(110, 1, 1, 1, 'A', '79', '2021-06-08', '01:09:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'G01', '-----', '56260', '601', 98, 15.68, 0, 0, 0, 15.68, 0, 113.68, '93489c01-c377-4f8a-ad65-04279cbdefd4', '2021-06-08', '01:11:25', NULL, './comprobantes/EKU9003173C9/A/79/110.xml', './comprobantes/EKU9003173C9/A/79/110.pdf', '2021-06-08 01:11:06', ''),
(111, 0, 1, 3, 'C', '2', '2021-06-09', '13:35:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 42, 6.72, 0, 0, 0, 6.72, 3.36, 45.36, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-09 13:39:15', ''),
(112, 1, 1, 2, 'A', '80', '2021-06-10', '14:59:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 2300, 368, 0, 0, 0, 368, 0, 2668, '118d3f59-1f9e-4948-b9be-f8db75f45ad4', '2021-06-10', '15:00:17', NULL, './comprobantes/EKU9003173C9/A/80/112.xml', './comprobantes/EKU9003173C9/A/80/112.pdf', '2021-06-10 15:00:03', ''),
(113, 0, 1, 3, 'A', '81', '2021-06-10', '13:00:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56260', '601', 46, 7.36, 0, 0, 0, 7.36, 0, 53.36, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-10 15:02:37', ''),
(114, 4, 1, 1, 'A', '82', '2021-06-15', '13:46:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 35, 5.6, 0, 0, 0, 5.6, 0, 40.6, '02cfc549-cce4-47a4-9900-68d12794db8f', '2021-06-15', '13:47:31', NULL, './comprobantes/EKU9003173C9/A/82/114.xml', './comprobantes/EKU9003173C9/A/82/114.pdf', '2021-06-15 13:47:09', 'Prueba del día...'),
(115, 1, 1, 4, 'A', '83', '2021-06-14', '13:49:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 105, 16.8, 0, 0, 0, 16.8, 0, 121.8, '11e92595-2865-4f1d-be88-059854e4f127', '2021-06-15', '13:50:21', NULL, './comprobantes/EKU9003173C9/A/83/115.xml', './comprobantes/EKU9003173C9/A/83/115.pdf', '2021-06-15 13:50:04', 'Otra prueba del día'),
(116, 0, 1, 3, 'A', '84', '2021-06-19', '17:41:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 21, 3.36, 0, 0, 0, 3.36, 0, 24.36, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-19 17:41:42', 'Probando...'),
(117, 4, 1, 4, 'A', '85', '2021-06-21', '19:18:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 49, 7.84, 0, 0, 0, 7.84, 0, 56.84, '48c72dd0-6e35-4ac8-820b-8a2c38b9b91c', '2021-06-21', '19:18:59', 'Vigente', './comprobantes/EKU9003173C9/A/85/117.xml', './comprobantes/EKU9003173C9/A/85/117.pdf', '2021-06-21 19:18:32', ''),
(118, 1, 1, 2, 'A', '86', '2021-06-24', '17:09:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 63, 10.08, 0, 0, 0, 10.08, 6.72, 66.36, '32d4adb3-93ff-42c4-a44c-a5703df5122b', '2021-06-24', '17:11:18', NULL, './comprobantes/EKU9003173C9/A/86/118.xml', './comprobantes/EKU9003173C9/A/86/118.pdf', '2021-06-24 17:10:52', ''),
(119, 3, 1, 1, 'A', '87', '2021-06-25', '20:27:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'G01', '-----', '56230', '601', 140, 22.4, 0, 0, 0, 0, 0, 162.4, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-26 20:28:49', ''),
(120, 0, 1, 1, 'A', '88', '2021-06-26', '20:52:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'G01', '-----', '56230', '601', 23, 3.68, 0, 0, 0, 3.68, 0, 26.68, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-26 20:52:50', 'Probando Spinner'),
(121, 0, 1, 2, 'A', '89', '2021-06-25', '20:53:00', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 21, 3.36, 0, 0, 0, 3.36, 0, 24.36, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-26 20:54:05', '2da Prueba de Spinner'),
(122, 4, 1, 1, 'C', '3', '2021-06-26', '23:50:33', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 14, 2.24, 0, 0, 0, 2.24, 0, 16.240000000000002, '856a9842-7332-433b-9731-d871d2dc8b97', '2021-06-27', '00:22:31', NULL, './comprobantes/EKU9003173C9/C/3/122.xml', './comprobantes/EKU9003173C9/C/3/122.pdf', '2021-06-26 23:54:06', 'Prueba para solucionar error con las series.'),
(123, 1, 1, 1, 'A', '90', '2021-07-02', '19:11:51', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 40, 6.4, 0, 0, 0, 6.4, 0, 46.4, '5bad4f05-1273-404f-bf8d-de7a1abd5032', '2021-07-02', '19:21:22', NULL, './comprobantes/EKU9003173C9/A/90/123.xml', './comprobantes/EKU9003173C9/A/90/123.pdf', '2021-07-02 19:13:07', 'Primer prueba del mes de Julio'),
(124, 1, 1, 4, 'A', '91', '2021-07-07', '20:37:01', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', '-----', '56230', '601', 70, 11.2, 0, 0, 0, 11.2, 0, 81.2, '94e8f785-11ec-4207-967b-4903b0b21f78', '2021-07-07', '20:38:49', NULL, './comprobantes/EKU9003173C9/A/91/124.xml', './comprobantes/EKU9003173C9/A/91/124.pdf', '2021-07-07 20:37:51', ''),
(125, 1, 1, 1, 'A', '92', '2021-07-07', '21:59:07', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'G01', 'Adquisición de mercancías', '56230', '601', 23, 3.68, 0, 0, 0, 3.68, 0, 26.68, 'a01edfcc-07e5-43f4-9f42-8a5d7949412c', '2021-07-09', '17:30:56', NULL, './comprobantes/EKU9003173C9/A/92/125.xml', './comprobantes/EKU9003173C9/A/92/125.pdf', '2021-07-07 21:59:44', ''),
(126, 1, 1, 1, 'A', '93', '2021-07-07', '22:03:06', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', 'Por definir', '56230', '601', 14, 2.24, 0, 0, 0, 2.24, 0, 16.240000000000002, 'b03ec97d-985b-4bc3-a47e-0af82e0df22f', '2021-07-07', '22:15:56', NULL, './comprobantes/EKU9003173C9/A/93/126.xml', './comprobantes/EKU9003173C9/A/93/126.pdf', '2021-07-07 22:04:04', 'Probando UsoCFDI'),
(127, 1, 1, 1, 'A', '94', '2021-07-09', '17:31:11', 'MXN', '1.00', 'I', '', '30001000000400002434', 'PUE', '01', 'P01', 'Por definir', '56230', '601', 14, 2.24, 0, 0, 0, 2.24, 0, 16.240000000000002, 'f14b234e-f2ad-40ec-8ff7-4baaa030563f', '2021-07-09', '17:31:48', NULL, './comprobantes/EKU9003173C9/A/94/127.xml', './comprobantes/EKU9003173C9/A/94/127.pdf', '2021-07-09 17:31:38', 'Probando que funcione después de modificar la serie.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `Id` int(11) NOT NULL,
  `Emisor` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Nombre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `RFC` varchar(13) COLLATE utf8mb4_spanish_ci NOT NULL,
  `TipoPersona` varchar(1) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Direccion` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Telefono` varchar(13) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Correo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`Id`, `Emisor`, `Estatus`, `Nombre`, `RFC`, `TipoPersona`, `Direccion`, `Telefono`, `Correo`) VALUES
(1, 1, 1, 'Nombre o razón social de la empresa S.A. de C.V.', 'XAXX010101000', 'M', 'Texcoco, México', '1234567890', 'nuevo@cliente.com'),
(2, 1, 1, 'Persona Física', 'GARE970115IYA', 'F', 'Texcoco, México', '5581630684', 'edd.galan@hotmail.com'),
(3, 1, 1, 'Edson Galan Rosano', 'GARE961214OCA', 'F', 'San Bernardino, Texcoco, México', '5581630684', 'correo@dominio.com'),
(4, 1, 1, 'Público en general', 'XAXX010101000', 'F', 'Ciudad de México', '0000000000', 'alguien@correo.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `confmailgun`
--

CREATE TABLE `confmailgun` (
  `Id` int(11) NOT NULL,
  `Testing` int(1) NOT NULL DEFAULT 1,
  `Nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `APIKey` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `APIHost` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Dominio` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Test_APIKey` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Test_APIHost` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Test_Dominio` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `confmailgun`
--

INSERT INTO `confmailgun` (`Id`, `Testing`, `Nombre`, `APIKey`, `APIHost`, `Dominio`, `Test_APIKey`, `Test_APIHost`, `Test_Dominio`) VALUES
(1, 1, 'Sistema de Notificaciones', 'dfed66db24db559dce9073b9b772c2ac-6ae2ecad-78848cf3', 'https://api.mailgun.net/v3/sandbox0e83be53e7154039b85a3a0e5eff62ae.mailgun.org', 'sandbox0e83be53e7154039b85a3a0e5eff62ae.mailgun.org', 'dfed66db24db559dce9073b9b772c2ac-6ae2ecad-78848cf3', 'https://api.mailgun.net/v3/sandbox0e83be53e7154039b85a3a0e5eff62ae.mailgun.org', 'sandbox0e83be53e7154039b85a3a0e5eff62ae.mailgun.org');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `Id` int(11) NOT NULL,
  `Cliente` int(1) NOT NULL,
  `Alias` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ApellidoPaterno` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ApellidoMaterno` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Puesto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Num1` varchar(12) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Num2` varchar(12) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`Id`, `Cliente`, `Alias`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Puesto`, `Email`, `Num1`, `Num2`) VALUES
(1, 1, 'Lic. Juan', 'Juan Alberto', 'García', 'Rosano', 'Contador', 'jagarcia@miempresa.com', '0000000000', '0000000000'),
(3, 2, '', 'Edson', 'Galan', 'Rosano', 'Desarrollador', 'edd.galan@hotmail.com', '5581630684', NULL),
(7, 1, 'Ventas', 'Edson', 'Galan', 'Rosano', 'Gerente de Ventas', 'edd.galan@hotmail.com', '5581630684', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `csd`
--

CREATE TABLE `csd` (
  `Id` int(11) NOT NULL,
  `Emisor` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `NoCertificado` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Certificado` varchar(3000) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `PathCertificado` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `PathKey` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `PassCer` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `VigenciaInicio` date DEFAULT NULL,
  `VigenciaFin` date DEFAULT NULL,
  `PathPem` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `csd`
--

INSERT INTO `csd` (`Id`, `Emisor`, `Estatus`, `NoCertificado`, `Certificado`, `PathCertificado`, `PathKey`, `PassCer`, `VigenciaInicio`, `VigenciaFin`, `PathPem`) VALUES
(1, 1, 1, '30001000000400002434', '', '0', '0', '0', '2021-04-01', NULL, '0'),
(3, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecomprobante`
--

CREATE TABLE `detallecomprobante` (
  `Id` int(11) NOT NULL,
  `Comprobante` int(11) NOT NULL,
  `Producto` int(11) NOT NULL,
  `SKU` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `PrecioUnitario` float NOT NULL DEFAULT 0,
  `Cantidad` float NOT NULL DEFAULT 0,
  `Unidad` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descuento` float NOT NULL DEFAULT 0,
  `Importe` float NOT NULL DEFAULT 0,
  `TipoImpuesto` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Impuestos` float NOT NULL DEFAULT 0,
  `Total` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `detallecomprobante`
--

INSERT INTO `detallecomprobante` (`Id`, `Comprobante`, `Producto`, `SKU`, `Descripcion`, `PrecioUnitario`, `Cantidad`, `Unidad`, `Descuento`, `Importe`, `TipoImpuesto`, `Impuestos`, `Total`) VALUES
(34, 38, 1, 'ABCDEF-00', 'Café chico', 14, 50, 'H87 | Pieza', 50, 700, 'IVA 16 | 0.16%', 112, 762),
(64, 64, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 0, 14000, 'IVA 16 | 0.16%', 2240, 16240),
(65, 65, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 0, 14000, 'IVA 16 | 0.16%', 2240, 16240),
(66, 66, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 0, 14000, 'IVA 16 | 0.16%', 2240, 16240),
(67, 67, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 0, 14000, 'IVA 16 | 0.16%', 2240, 16240),
(68, 68, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 500, 14000, 'IVA 16 | 0.16%', 2240, 15740),
(69, 69, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 500, 14000, 'IVA 16 | 0.16%', 2240, 15740),
(70, 70, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(71, 71, 1, 'ABCDEF-00', 'Café chico', 14, 5, 'H87 | Pieza', 0, 70, 'IVA 16 | 0.16%', 11.2, 81.2),
(72, 72, 1, 'ABCDEF-00', 'Café chico', 14, 5, 'H87 | Pieza', 10, 70, 'IVA 16 | 0.16%', 11.2, 71.2),
(73, 73, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 0, 14000, 'IVA 16 | 0.16%', 2240, 16240),
(74, 74, 1, 'ABCDEF-00', 'Café chico', 14, 5, 'H87 | Pieza', 0, 70, 'IVA 16 | 0.16%', 11.2, 81.2),
(75, 75, 1, 'ABCDEF-00', 'Café chico', 14, 50, 'H87 | Pieza', 0, 700, 'IVA 16 | 0.16%', 112, 812),
(76, 76, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(77, 77, 1, 'ABCDEF-00', 'Café chico', 14, 50, 'H87 | Pieza', 0, 700, 'IVA 16 | 0.16%', 112, 812),
(78, 78, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(79, 79, 1, 'ABCDEF-00', 'Café chico', 14, 3, 'H87 | Pieza', 0, 42, 'IVA 16 | 0.16%', 6.72, 48.72),
(80, 80, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(81, 81, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(82, 82, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(83, 83, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(84, 84, 1, 'ABCDEF-00', 'Café chico', 14, 10, 'H87 | Pieza', 35, 140, 'IVA 16 | 0.16%', 22.4, 127.4),
(85, 85, 1, 'ABCDEF-00', 'Café chico', 14, 5, 'H87 | Pieza', 0, 70, 'IVA 16 | 0.16%', 11.2, 81.2),
(86, 86, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(87, 87, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 150, 1400, 'IVA 16 | 0.16%', 224, 1474),
(88, 88, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 15, 1400, 'IVA 16 | 0.16%', 224, 1609),
(89, 89, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(90, 90, 1, 'ABCDEF-00', 'Café chico', 14, 10, 'H87 | Pieza', 0, 140, 'IVA 16 | 0.16%', 22.4, 162.4),
(91, 91, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 50, 1400, 'IVA 16 | 0.16%', 224, 1574),
(92, 92, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 50, 1400, 'IVA 16 | 0.16%', 224, 1574),
(93, 93, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(94, 94, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(95, 95, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(96, 96, 1, 'ABCDEF-00', 'Café chico', 14, 50, 'H87 | Pieza', 0, 700, 'IVA 16 | 0.16%', 112, 812),
(97, 97, 1, 'ABCDEF-00', 'Café chico', 14, 1000, 'H87 | Pieza', 100, 14000, 'IVA 16 | 0.16%', 2240, 16140),
(98, 98, 1, 'ABCDEF-00', 'Café chico', 14, 5, 'H87 | Pieza', 0, 70, 'IVA 16 | 0.16%', 11.2, 81.2),
(99, 99, 1, 'ABCDEF-00', 'Café chico', 14, 10, 'H87 | Pieza', 0, 140, 'IVA 16 | 0.16%', 22.4, 162.4),
(100, 100, 1, 'ABCDEF-00', 'Café chico', 14, 10, 'H87 | Pieza', 0, 140, 'IVA 16 | 0.16%', 22.4, 162.4),
(101, 101, 1, 'ABCDEF-00', 'Café chico', 14, 10, 'H87 | Pieza', 0, 140, 'IVA 16 | 0.16%', 22.4, 162.4),
(102, 102, 1, 'ABCDEF-00', 'Café chico', 14, 50, 'H87 | Pieza', 0, 700, 'IVA 16 | 0.16%', 112, 812),
(103, 103, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(104, 104, 1, 'ABCDEF-00', 'Café chico', 14, 5, 'H87 | Pieza', 0, 70, 'IVA 16 | 0.16%', 11.2, 81.2),
(105, 105, 1, 'ABCDEF-00', 'Café chico', 14, 100, 'H87 | Pieza', 0, 1400, 'IVA 16 | 0.16%', 224, 1624),
(106, 106, 4, 'ABCDEF-02', 'Café Americano', 23, 100, 'H87 | Pieza', 0, 2300, 'IVA 16 | 0.16%', 368, 2668),
(107, 107, 1, 'ABCDEF-00', 'Café chico', 14, 10, 'H87 | Pieza', 0, 140, 'IVA 16 | 0.16%', 22.4, 162.4),
(108, 108, 4, 'ABCDEF-02', 'Café Americano', 23, 5, 'H87 | Pieza', 0, 115, 'IVA 16 | 0.16%', 18.4, 133.4),
(109, 109, 1, 'ABCDEF-00-00', 'Café Moka', 14, 2, 'H87 | Pieza', 0, 28, 'IVA 16 | 0.16%', 4.48, 32.48),
(110, 109, 4, 'ABCDEF-00-02', 'Café Americano', 23, 1, 'H87 | Pieza', 0, 23, 'IVA 16 | 0.16%', 3.68, 26.68),
(111, 109, 6, 'ABCDEF-01-00', 'Waffles de Chocolate (3 piezas)', 21, 3, 'H87 | Pieza', 0, 63, 'IVA 16 | 0.16%', 10.08, 73.08),
(112, 110, 7, 'ABCDEF-01-01', 'SpiderWaffles', 26, 2, 'H87 | Pieza', 0, 52, 'IVA 16 | 0.16%', 8.32, 60.32),
(113, 110, 4, 'ABCDEF-00-02', 'Café Americano', 23, 2, 'H87 | Pieza', 0, 46, 'IVA 16 | 0.16%', 7.36, 53.36),
(114, 111, 9, 'ABCDEF-00-03', 'Café Capuchino Vainilla', 21, 1, 'H87 | Pieza', 3.36, 21, 'IVA 16 | 0.16%', 3.36, 21),
(115, 111, 6, 'ABCDEF-01-00', 'Waffles de Chocolate (3 piezas)', 21, 1, 'H87 | Pieza', 0, 21, 'IVA 16 | 0.16%', 3.36, 24.36),
(116, 112, 4, 'ABCDEF-00-02', 'Café Americano', 23, 100, 'H87 | Pieza', 0, 2300, 'IVA 16 | 0.16%', 368, 2668),
(117, 113, 4, 'ABCDEF-00-02', 'Café Americano', 23, 2, 'H87 | Pieza', 0, 46, 'IVA 16 | 0.16%', 7.36, 53.36),
(118, 114, 6, 'ABCDEF-01-00', 'Waffles de Chocolate (3 piezas)', 21, 1, 'H87 | Pieza', 0, 21, 'IVA 16 | 0.16%', 3.36, 24.36),
(119, 114, 1, 'ABCDEF-00-00', 'Café Moka', 14, 1, 'H87 | Pieza', 0, 14, 'IVA 16 | 0.16%', 2.24, 16.24),
(120, 115, 1, 'ABCDEF-00-00', 'Café Moka', 14, 3, 'H87 | Pieza', 0, 42, 'IVA 16 | 0.16%', 6.72, 48.72),
(121, 115, 6, 'ABCDEF-01-00', 'Waffles de Chocolate (3 piezas)', 21, 3, 'H87 | Pieza', 0, 63, 'IVA 16 | 0.16%', 10.08, 73.08),
(122, 116, 9, 'ABCDEF-00-03', 'Café Capuchino Vainilla', 21, 1, 'H87 | Pieza', 0, 21, 'IVA 16 | 0.16%', 3.36, 24.36),
(123, 117, 4, 'ABCDEF-00-02', 'Café Americano', 23, 1, 'H87 | Pieza', 0, 23, 'IVA 16 | 0.16%', 3.68, 26.68),
(124, 117, 7, 'ABCDEF-01-01', 'SpiderWaffles', 26, 1, 'H87 | Pieza', 0, 26, 'IVA 16 | 0.16%', 4.16, 30.16),
(125, 118, 9, 'ABCDEF-00-03', 'Café Capuchino Vainilla', 21, 1, 'H87 | Pieza', 0, 21, 'IVA 16 | 0.16%', 3.36, 24.36),
(126, 118, 6, 'ABCDEF-01-00', 'Waffles de Chocolate (3 piezas)', 21, 2, 'H87 | Pieza', 6.72, 42, 'IVA 16 | 0.16%', 6.72, 42),
(127, 120, 4, 'ABCDEF-00-02', 'Café Americano', 23, 1, 'H87 | Pieza', 0, 23, 'IVA 16 | 0.16%', 3.68, 26.68),
(128, 121, 9, 'ABCDEF-00-03', 'Café Capuchino Vainilla', 21, 1, 'H87 | Pieza', 0, 21, 'IVA 16 | 0.16%', 3.36, 24.36),
(129, 122, 1, 'ABCDEF-00-00', 'Café Moka', 14, 1, 'H87 | Pieza', 0, 14, 'IVA 16 | 0.16%', 2.24, 16.24),
(130, 123, 1, 'ABCDEF-00-00', 'Café Moka', 14, 1, 'H87 | Pieza', 0, 14, 'IVA 16 | 0.16%', 2.24, 16.24),
(131, 123, 7, 'ABCDEF-01-01', 'SpiderWaffles', 26, 1, 'H87 | Pieza', 0, 26, 'IVA 16 | 0.16%', 4.16, 30.16),
(132, 124, 1, 'ABCDEF-00-00', 'Café Moka', 14, 2, 'H87 | Pieza', 0, 28, 'IVA 16 | 0.16%', 4.48, 32.48),
(133, 124, 6, 'ABCDEF-01-00', 'Waffles de Chocolate (3 piezas)', 21, 2, 'H87 | Pieza', 0, 42, 'IVA 16 | 0.16%', 6.72, 48.72),
(134, 125, 4, 'ABCDEF-00-02', 'Café Americano', 23, 1, 'H87 | Pieza', 0, 23, 'IVA 16 | 0.16%', 3.68, 26.68),
(135, 126, 1, 'ABCDEF-00-00', 'Café Moka', 14, 1, 'H87 | Pieza', 0, 14, 'IVA 16 | 0.16%', 2.24, 16.24),
(136, 127, 1, 'ABCDEF-00-00', 'Café Moka', 14, 1, 'H87 | Pieza', 0, 14, 'IVA 16 | 0.16%', 2.24, 16.24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emisores`
--

CREATE TABLE `emisores` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Nombre` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `RFC` varchar(13) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Domicilio` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `CP` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Persona` varchar(1) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Regimen` varchar(3) COLLATE utf8mb4_spanish_ci NOT NULL,
  `DescRegimen` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `PathLogo` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `PAC` int(11) NOT NULL,
  `Testing` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `emisores`
--

INSERT INTO `emisores` (`Id`, `Estatus`, `Nombre`, `RFC`, `Domicilio`, `CP`, `Persona`, `Regimen`, `DescRegimen`, `PathLogo`, `PAC`, `Testing`) VALUES
(1, 1, 'Emisor para Pruebas  S.A. de C.V.', 'EKU9003173C9', 'San Bernardino, Texcoco, México', '56260', 'M', '601', 'General de Ley Personas Morales', 'uploads/EKU9003173C9/logo.jpg', 1, 1),
(2, 1, 'Coffee Shake', 'GARE970115IYA', 'Texcoco, México', '56230', 'M', '601', 'General de Ley Personas Morales', 'uploads/GARE970115IYA/logo.jpg', 1, 1),
(6, 1, 'DESICI', 'DESICI0101012', '', '', 'M', '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`Id`, `Nombre`, `Descripcion`) VALUES
(1, 'Administradores', 'Grupo con todos los permisos del sistema'),
(2, 'Emisores', 'Grupo de todos los Emisores'),
(6, 'Prueba', 'Probando permisos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_usuario`
--

CREATE TABLE `grupos_usuario` (
  `Id` int(11) NOT NULL,
  `IdGrupo` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `grupos_usuario`
--

INSERT INTO `grupos_usuario` (`Id`, `IdGrupo`, `IdUsuario`) VALUES
(16, 1, 1),
(23, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pac`
--

CREATE TABLE `pac` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Nombre` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `NombreCorto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `EndPoint` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `EndPoint_Pruebas` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `UsrPAC` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `PassPAC` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Observaciones` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pac`
--

INSERT INTO `pac` (`Id`, `Estatus`, `Nombre`, `NombreCorto`, `EndPoint`, `EndPoint_Pruebas`, `UsrPAC`, `PassPAC`, `Observaciones`) VALUES
(1, 1, 'Proveedores de Facturación Electrónica y Software S.A. de C.V.', 'PROFACT_PR', 'https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl', 'https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl', 'mvpNUXmQfK8=', '12345678', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `Id` int(11) NOT NULL,
  `UsuarioId` int(11) NOT NULL,
  `Nombre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ApellidoPaterno` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ApellidoMaterno` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Emisor` int(11) NOT NULL,
  `Puesto` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`Id`, `UsuarioId`, `Nombre`, `ApellidoPaterno`, `ApellidoMaterno`, `Emisor`, `Puesto`) VALUES
(1, 1, 'Admin', '', '', 1, 'Administrador del sistema'),
(2, 2, 'Edson', 'Galan', 'Rosano', 2, 'Web Developer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `Id` int(11) NOT NULL,
  `GrupoId` int(11) NOT NULL,
  `DashboardAdmin` int(1) NOT NULL DEFAULT 0,
  `Admin_miempresa` int(1) NOT NULL DEFAULT 0,
  `Admin_usuario` int(1) NOT NULL DEFAULT 0,
  `Admin_grupos` int(1) NOT NULL DEFAULT 0,
  `Admin_perfiles` int(1) NOT NULL DEFAULT 0,
  `Admin_emisores` int(1) NOT NULL DEFAULT 0,
  `Admin_clientes` int(1) NOT NULL DEFAULT 1,
  `Admin_prodserv` int(1) NOT NULL DEFAULT 1,
  `Admin_series` int(1) NOT NULL DEFAULT 1,
  `Comprobantes_facturas` int(1) NOT NULL DEFAULT 1,
  `Reportes_reportemensual` int(1) NOT NULL DEFAULT 1,
  `CatSAT_claves_prodserv` int(1) NOT NULL DEFAULT 1,
  `CatSAT_unidades` int(1) NOT NULL DEFAULT 1,
  `CatSAT_formaspago` int(1) NOT NULL DEFAULT 1,
  `CatSAT_monedas` int(1) NOT NULL DEFAULT 1,
  `CatSAT_impuestos` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`Id`, `GrupoId`, `DashboardAdmin`, `Admin_miempresa`, `Admin_usuario`, `Admin_grupos`, `Admin_perfiles`, `Admin_emisores`, `Admin_clientes`, `Admin_prodserv`, `Admin_series`, `Comprobantes_facturas`, `Reportes_reportemensual`, `CatSAT_claves_prodserv`, `CatSAT_unidades`, `CatSAT_formaspago`, `CatSAT_monedas`, `CatSAT_impuestos`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Id` int(11) NOT NULL,
  `Emisor` int(11) NOT NULL,
  `Estatus` int(11) NOT NULL DEFAULT 1,
  `SKU` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ClaveProdServ` int(11) NOT NULL,
  `ClaveUnidad` int(11) NOT NULL,
  `Precio` float NOT NULL,
  `Impuesto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id`, `Emisor`, `Estatus`, `SKU`, `Nombre`, `ClaveProdServ`, `ClaveUnidad`, `Precio`, `Impuesto`) VALUES
(1, 1, 1, 'ABCDEF-00-00', 'Café Moka', 11, 1, 14, 1),
(2, 1, 1, 'ABCDEF-00-01', 'Café Cappuccino', 11, 1, 24, 1),
(4, 1, 1, 'ABCDEF-00-02', 'Café Americano', 11, 1, 23, 1),
(6, 1, 0, 'ABCDEF-01-00', 'Waffles de Chocolate (3 piezas)', 14, 1, 21, 1),
(7, 1, 1, 'ABCDEF-01-01', 'SpiderWaffles', 14, 1, 26, 1),
(9, 1, 1, 'ABCDEF-00-03', 'Café Capuchino Vainilla', 11, 1, 21, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

CREATE TABLE `series` (
  `Id` int(11) NOT NULL,
  `Emisor` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Serie` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descripcion` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `TipoComprobante` varchar(1) COLLATE utf8mb4_spanish_ci NOT NULL,
  `DescripcionTipoComp` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Consecutivo` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `series`
--

INSERT INTO `series` (`Id`, `Emisor`, `Estatus`, `Serie`, `Descripcion`, `TipoComprobante`, `DescripcionTipoComp`, `Consecutivo`) VALUES
(1, 1, 1, 'A', 'Serie para todo tipo de Ingresos', 'I', 'Ingreso', '94'),
(2, 1, 1, 'B', 'Serie de Prueba', 'I', 'Ingreso', '2'),
(3, 1, 1, 'C', 'Serie para Traslados', 'E', 'Egreso', '3'),
(4, 1, 0, 'D', 'Serie de prueba.', 'P', 'Pago', '10'),
(7, 1, 0, 'F', 'Nueva serie', 'I', 'Ingreso', '11'),
(8, 1, 0, 'G', 'Probando nueva serie', 'I', 'Ingreso', '0'),
(9, 2, 1, 'A', 'Prueba', 'I', 'Ingreso', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id` int(11) NOT NULL,
  `Estatus` int(1) NOT NULL DEFAULT 1,
  `Username` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Password` varchar(256) COLLATE utf8mb4_spanish_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ChangePass` int(1) NOT NULL DEFAULT 1,
  `Created` datetime NOT NULL DEFAULT current_timestamp(),
  `LastSession` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id`, `Estatus`, `Username`, `Password`, `Email`, `ChangePass`, `Created`, `LastSession`) VALUES
(1, 1, 'Admin', '$2y$15$iliQ5UwvImILwDA/zMSiP.tFKRYlFC5qZp3ow0DDnEpvNmNA5ls2O', '', 1, '2021-04-17 16:58:42', NULL),
(2, 1, 'eddgalan', '$2y$15$ee5/w.0iRgyF/HwuDBwq8eS3soiu4c4ZwacRrLNiP/BD7/aPZBnLe', 'edd.galan@hotmail.com', 1, '2021-04-19 16:34:13', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catsatclavesprodserv`
--
ALTER TABLE `catsatclavesprodserv`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_ClaveProdServ` (`Emisor`);

--
-- Indices de la tabla `catsatformaspago`
--
ALTER TABLE `catsatformaspago`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_CatSATFormasPago` (`Emisor`);

--
-- Indices de la tabla `catsatimpuestos`
--
ALTER TABLE `catsatimpuestos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_CatSATImpuestos` (`Emisor`);

--
-- Indices de la tabla `catsatmetodos`
--
ALTER TABLE `catsatmetodos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_CatSATMetodos` (`Emisor`);

--
-- Indices de la tabla `catsatmoneda`
--
ALTER TABLE `catsatmoneda`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_CatSATMoneda` (`Emisor`);

--
-- Indices de la tabla `catsatunidades`
--
ALTER TABLE `catsatunidades`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_CatSATUnidades` (`Emisor`);

--
-- Indices de la tabla `catsatusocfdi`
--
ALTER TABLE `catsatusocfdi`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_CatSATUsoCFDI` (`Emisor`);

--
-- Indices de la tabla `cfdi`
--
ALTER TABLE `cfdi`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_Cliente` (`Emisor`);

--
-- Indices de la tabla `confmailgun`
--
ALTER TABLE `confmailgun`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Contacto_Cliente` (`Cliente`);

--
-- Indices de la tabla `csd`
--
ALTER TABLE `csd`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_CSD` (`Emisor`);

--
-- Indices de la tabla `detallecomprobante`
--
ALTER TABLE `detallecomprobante`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `emisores`
--
ALTER TABLE `emisores`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `RFC` (`RFC`),
  ADD KEY `PAC` (`PAC`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `grupos_usuario`
--
ALTER TABLE `grupos_usuario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Grupo` (`IdGrupo`),
  ADD KEY `Usuario` (`IdUsuario`);

--
-- Indices de la tabla `pac`
--
ALTER TABLE `pac`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `UsuarioId_Unico` (`UsuarioId`),
  ADD KEY `Emisor_Perfil` (`Emisor`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `GrupoIdUnico` (`GrupoId`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_Producto` (`Emisor`),
  ADD KEY `ClaveProdServ_Producto` (`ClaveProdServ`),
  ADD KEY `ClaveUnidad_Producto` (`ClaveUnidad`),
  ADD KEY `Impuesto_Producto` (`Impuesto`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Emisor_Serie` (`Emisor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username_Unico` (`Username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catsatclavesprodserv`
--
ALTER TABLE `catsatclavesprodserv`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `catsatformaspago`
--
ALTER TABLE `catsatformaspago`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `catsatimpuestos`
--
ALTER TABLE `catsatimpuestos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `catsatmetodos`
--
ALTER TABLE `catsatmetodos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `catsatmoneda`
--
ALTER TABLE `catsatmoneda`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `catsatunidades`
--
ALTER TABLE `catsatunidades`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `catsatusocfdi`
--
ALTER TABLE `catsatusocfdi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cfdi`
--
ALTER TABLE `cfdi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `confmailgun`
--
ALTER TABLE `confmailgun`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `csd`
--
ALTER TABLE `csd`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detallecomprobante`
--
ALTER TABLE `detallecomprobante`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT de la tabla `emisores`
--
ALTER TABLE `emisores`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `grupos_usuario`
--
ALTER TABLE `grupos_usuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `pac`
--
ALTER TABLE `pac`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `series`
--
ALTER TABLE `series`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `catsatclavesprodserv`
--
ALTER TABLE `catsatclavesprodserv`
  ADD CONSTRAINT `Emisor_ClaveProdServ` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `catsatformaspago`
--
ALTER TABLE `catsatformaspago`
  ADD CONSTRAINT `Emisor_CatSATFormasPago` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `catsatimpuestos`
--
ALTER TABLE `catsatimpuestos`
  ADD CONSTRAINT `Emisor_CatSATImpuestos` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `catsatmetodos`
--
ALTER TABLE `catsatmetodos`
  ADD CONSTRAINT `Emisor_CatSATMetodos` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `catsatmoneda`
--
ALTER TABLE `catsatmoneda`
  ADD CONSTRAINT `Emisor_CatSATMoneda` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `catsatunidades`
--
ALTER TABLE `catsatunidades`
  ADD CONSTRAINT `Emisor_CatSATUnidades` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `catsatusocfdi`
--
ALTER TABLE `catsatusocfdi`
  ADD CONSTRAINT `Emisor_CatSATUsoCFDI` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `Emisor_Cliente` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `Contacto_Cliente` FOREIGN KEY (`Cliente`) REFERENCES `clientes` (`Id`);

--
-- Filtros para la tabla `csd`
--
ALTER TABLE `csd`
  ADD CONSTRAINT `Emisor_CSD` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);

--
-- Filtros para la tabla `emisores`
--
ALTER TABLE `emisores`
  ADD CONSTRAINT `PAC` FOREIGN KEY (`PAC`) REFERENCES `pac` (`Id`);

--
-- Filtros para la tabla `grupos_usuario`
--
ALTER TABLE `grupos_usuario`
  ADD CONSTRAINT `Grupo` FOREIGN KEY (`IdGrupo`) REFERENCES `grupos` (`Id`),
  ADD CONSTRAINT `Usuario` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`Id`);

--
-- Filtros para la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD CONSTRAINT `Emisor_Perfil` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`),
  ADD CONSTRAINT `Usuario_Perfil` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `IdGrupo` FOREIGN KEY (`GrupoId`) REFERENCES `grupos` (`Id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `ClaveProdServ_Producto` FOREIGN KEY (`ClaveProdServ`) REFERENCES `catsatclavesprodserv` (`Id`),
  ADD CONSTRAINT `ClaveUnidad_Producto` FOREIGN KEY (`ClaveUnidad`) REFERENCES `catsatunidades` (`Id`),
  ADD CONSTRAINT `Emisor_Producto` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`),
  ADD CONSTRAINT `Impuesto_Producto` FOREIGN KEY (`Impuesto`) REFERENCES `catsatimpuestos` (`Id`);

--
-- Filtros para la tabla `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `Emisor_Serie` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
