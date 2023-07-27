-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-07-2023 a las 05:45:06
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aepeq`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tadministrador`
--

CREATE TABLE `tadministrador` (
  `Id_Administrador` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Contraseña` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbecados`
--

CREATE TABLE `tbecados` (
  `CURP_beca` varchar(20) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttaller`
--

CREATE TABLE `ttaller` (
  `Id_Taller` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Hora` varchar(50) NOT NULL,
  `Aula` varchar(100) NOT NULL,
  `Dia` int(11) NOT NULL,
  `Capacidad_Maxima` int(100) NOT NULL,
  `Capacidad_Disponible` int(100) NOT NULL,
  `Id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tusuario`
--

CREATE TABLE `tusuario` (
  `Id_usuario` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Contraseña` varchar(50) NOT NULL,
  `Celular` int(15) NOT NULL,
  `Estado` varchar(100) NOT NULL,
  `Pais` varchar(100) NOT NULL,
  `Ocupacion` varchar(100) NOT NULL,
  `Lugar_Trabajo` varchar(100) NOT NULL,
  `Tipo_Usuario` int(11) NOT NULL DEFAULT 1,
  `Colegio_asociacion` varchar(250) DEFAULT NULL,
  `Certificado_Socio` varchar(250) DEFAULT NULL,
  `Comprobante_Pago` varchar(250) DEFAULT NULL,
  `Factura` tinyint(1) DEFAULT NULL,
  `DIA1` tinyint(1) DEFAULT NULL,
  `DIA2` tinyint(1) DEFAULT NULL,
  `DIA3` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tusuario`
--

INSERT INTO `tusuario` (`Id_usuario`, `Nombre`, `Apellido`, `Email`, `Contraseña`, `Celular`, `Estado`, `Pais`, `Ocupacion`, `Lugar_Trabajo`, `Tipo_Usuario`, `Colegio_asociacion`, `Certificado_Socio`, `Comprobante_Pago`, `Factura`, `DIA1`, `DIA2`, `DIA3`) VALUES
(1, 'diego', 'Vanegas', 'diego@correo.com', '$2y$10$obttrCQ8cWZUD0WCvbaOTea9SYBJ4msmMvFipNO9bdi', 444529913, 'SLP', 'SLP', 'Estudiante', 'UASLP', 1, 'UASLP', 'fondo1.jpg', 'Demo AEPEQ WEB (2).pdf', NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tadministrador`
--
ALTER TABLE `tadministrador`
  ADD PRIMARY KEY (`Id_Administrador`);

--
-- Indices de la tabla `tbecados`
--
ALTER TABLE `tbecados`
  ADD PRIMARY KEY (`CURP_beca`),
  ADD KEY `Id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `ttaller`
--
ALTER TABLE `ttaller`
  ADD PRIMARY KEY (`Id_Taller`),
  ADD KEY `Id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  ADD PRIMARY KEY (`Id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tadministrador`
--
ALTER TABLE `tadministrador`
  MODIFY `Id_Administrador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ttaller`
--
ALTER TABLE `ttaller`
  MODIFY `Id_Taller` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbecados`
--
ALTER TABLE `tbecados`
  ADD CONSTRAINT `tbecados_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `tusuario` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ttaller`
--
ALTER TABLE `ttaller`
  ADD CONSTRAINT `ttaller_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `tusuario` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
