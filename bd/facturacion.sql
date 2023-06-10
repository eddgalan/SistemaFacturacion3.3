-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-08-2021 a las 16:10:28
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
  `TipoComprobante` varchar(25) COLLATE utf8mb4_spanish_ci NOT NULL,
  `CondicionesPago` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `NoCertificado` varchar(256) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `MetodoPago` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `FormaPago` varchar(35) COLLATE utf8mb4_spanish_ci NOT NULL,
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
(1, 1, 1, 'Publico en general', 'XAXX010101000', 'F', 'CDMX', '1234567890', 'cliente@correo.com'),
(2, 1, 1, 'Persona Física', 'SASS200216XXX', 'F', 'CDMX', '5500000000', 'cliente@correo.com');

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
(1, 1, 1, '30001000000400002434', '', '0', '0', '0', '2021-04-01', NULL, '0');

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
(1, 1, 'Emisor Pruebas  S.A. de C.V.', 'EKU9003173C9', 'Ciudad de México', '56260', 'M', '601', 'General de Ley Personas Morales', 'uploads/EKU9003173C9/logo.jpg', 1, 1),
(2, 1, 'Otro_Emisor', 'EKU9003173C0', 'CDMX', '56230', 'M', '601', 'General de Ley Personas Morales', 'uploads/GARE970115IYA/logo.jpg', 1, 1);

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
(2, 'Emisores', 'Grupo de todos los Emisores');

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
(1, 1, 1),
(2, 2, 2);

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
(1, 1, 'Proveedores de Facturación Electrónica y Software S.A. de C.V.', 'PROFACT_PR', 'https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl', 'https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl', 'mvpNUXmQfK8=', '87654321', 'Estas son las credenciales de prueba para facturar.');

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
(2, 2, 'Edson', 'Galan', '---', 2, '---');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `Id` int(11) NOT NULL,
  `GrupoId` int(11) NOT NULL,
  `DashboardAdmin` int(1) NOT NULL DEFAULT 0,
  `Admin_miempresa` int(1) NOT NULL DEFAULT 0,
  `Admin_PAC` int(1) NOT NULL DEFAULT 0,
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

INSERT INTO `permisos` (`Id`, `GrupoId`, `DashboardAdmin`, `Admin_miempresa`, `Admin_PAC`, `Admin_usuario`, `Admin_grupos`, `Admin_perfiles`, `Admin_emisores`, `Admin_clientes`, `Admin_prodserv`, `Admin_series`, `Comprobantes_facturas`, `Reportes_reportemensual`, `CatSAT_claves_prodserv`, `CatSAT_unidades`, `CatSAT_formaspago`, `CatSAT_monedas`, `CatSAT_impuestos`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

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
(1, 1, 'Admin', '$2y$15$F0rGRQNowj8XRN48hbtX9uR2Nkdqe0b47sEKgBElM9KrIJTLZ77JW', '', 1, '2021-04-17 16:58:42', NULL),
(2, 1, 'Usuario Emisor', '$2y$15$FvpP3yYri1cBWb/7KxCNS.docYfwULRH1825Ywd4yaArE.OH58QJq', 'alguien@correo.com', 1, '2021-04-19 16:34:13', NULL);

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
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CFDI_Emisor` (`Emisor`),
  ADD KEY `CFDI_Cliente` (`ClienteId`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catsatformaspago`
--
ALTER TABLE `catsatformaspago`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catsatimpuestos`
--
ALTER TABLE `catsatimpuestos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catsatmetodos`
--
ALTER TABLE `catsatmetodos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catsatmoneda`
--
ALTER TABLE `catsatmoneda`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catsatunidades`
--
ALTER TABLE `catsatunidades`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catsatusocfdi`
--
ALTER TABLE `catsatusocfdi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cfdi`
--
ALTER TABLE `cfdi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `confmailgun`
--
ALTER TABLE `confmailgun`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `csd`
--
ALTER TABLE `csd`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `detallecomprobante`
--
ALTER TABLE `detallecomprobante`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `emisores`
--
ALTER TABLE `emisores`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupos_usuario`
--
ALTER TABLE `grupos_usuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pac`
--
ALTER TABLE `pac`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `series`
--
ALTER TABLE `series`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `cfdi`
--
ALTER TABLE `cfdi`
  ADD CONSTRAINT `CFDI_Cliente` FOREIGN KEY (`ClienteId`) REFERENCES `clientes` (`Id`),
  ADD CONSTRAINT `CFDI_Emisor` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `Emisor_CSD` FOREIGN KEY (`Emisor`) REFERENCES `emisores` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
