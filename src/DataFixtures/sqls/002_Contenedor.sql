-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-01-2019 a las 11:24:07
-- Versión del servidor: 5.7.24-0ubuntu0.16.04.1
-- Versión de PHP: 7.2.13-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `operaciones`
--

--
-- Volcado de datos para la tabla `Contenedor`
--

INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(1, 'CONTENEDOR ESTANDAR 20\' (STANDARD CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(2, 'CONTENEDOR ESTANDAR 40\' (STANDARD CONTAINER 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(3, 'CONTENEDOR ESTANDAR DE CUBO ALTO 40\' (HIGH CUBE STANDARD CONTAINER 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(4, 'CONTENEDOR TAPA DURA 20\' (HARDTOP CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(5, 'CONTENEDOR TAPA DURA 40\' (HARDTOP CONTAINER 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(6, 'CONTENEDOR TAPA ABIERTA 20\' (OPEN TOP CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(7, 'CONTENEDOR TAPA ABIERTA 40\' (OPEN TOP CONTAINER 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(8, 'FLAT 20\' (FLAT 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(9, 'FLAT 40\' (FLAT 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(10, 'PLATAFORMA 20\' (PLATFORM 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(11, 'PLATAFORMA 40\' (PLATFORM 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(12, 'CONTENEDOR VENTILADO 20\' (VENTILATED CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(13, 'CONTENEDOR TERMICO 20\' (INSULATED CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(14, 'CONTENEDOR TERMICO 40\' (INSULATED CONTAINER 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(15, 'CONTENEDOR REFRIGERANTE 20\' (REFRIGERATED CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(16, 'CONTENEDOR REFRIGERANTE 40\' (REFRIGERATED CONTAINER 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(17, 'CONTENEDOR REFRIGERANTE CUBO ALTO 40\' (HIGH CUBE REFRIGERATED CONTAINER 40\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(18, 'CONTENEDOR CARGA A GRANEL 20\' (BULK CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(19, 'CONTENEDOR TIPO TANQUE 20\' (TANK CONTAINER 20\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(20, 'CONTENEDOR ESTANDAR 45\' (STANDARD CONTAINER 45\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(21, 'CONTENEDOR ESTANDAR 48\' (STANDARD CONTAINER 48\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(22, 'CONTENEDOR ESTANDAR 53\' (STANDARD CONTAINER 53\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(23, 'CONTENEDOR ESTANDAR 8\' (STANDARD CONTAINER 8\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(24, 'CONTENEDOR ESTANDAR 10\' (STANDARD CONTAINER 10\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(25, 'CONTENEDOR ESTANDAR DE CUBO ALTO 45\' (HIGH CUBE STANDARD CONTAINER 45\').', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(26, 'SEMIRREMOLQUE CON RACKS PARA ENVASES DE BEBIDAS.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(27, 'SEMIRREMOLQUE CUELLO DE GANZO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(28, 'SEMIRREMOLQUE TOLVA CUBIERTO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(29, 'SEMIRREMOLQUE TOLVA (ABIERTO).', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(30, 'AUTO-TOLVA CUBIERTO/DESCARGA NEUMATICA.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(31, 'SEMIRREMOLQUE CHASIS.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(32, 'SEMIRREMOLQUE AUTOCARGABLE (CON SISTEMA DE ELEVACION).', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(33, 'SEMIRREMOLQUE CON TEMPERATURA CONTROLADA.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(34, 'SEMIRREMOLQUE CORTO TRASERO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(35, 'SEMIRREMOLQUE DE CAMA BAJA.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(36, 'PLATAFORMA DE 28\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(37, 'PLATAFORMA DE 45\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(38, 'PLATAFORMA DE 48\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(39, 'SEMIRREMOLQUE PARA TRANSPORTE DE CABALLOS.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(40, 'SEMIRREMOLQUE PARA TRANSPORTE DE GANADO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(41, 'SEMIRREMOLQUE TANQUE (LIQUIDOS)/SIN CALEFACCION/SIN AISLAR.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(42, 'SEMIRREOLQUE TANQUE (LIQUIDOS)/CON CALEFACCION/SIN AISLAR.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(43, 'SEMIRREMOLQUE TANQUE (LIQUIDOS)/SIN CALEFACCION/AISLADO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(44, 'SEMIRREMOLQUE TANQUE (LIQUIDOS)/CON CALEFACCION/AISLADO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(45, 'SEMIRREMOLQUE TANQUE (GAS)/SIN CALEFACCION/SIN AISLAR.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(46, 'SEMIRREMOLQUE TANQUE (GAS)/CON CALEFACCION/SIN AISLAR.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(47, 'SEMIRREMOLQUE TANQUE (GAS)/SIN CALEFACCION/AISLADO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(48, 'SEMIRREMOLQUE TANQUE (GAS)/CON CALEFACCION/AISLADO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(49, 'SEMIRREMOLQUE TANQUE (QUIMICOS)/SIN CALEFACCION/SIN AISLAR.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(50, 'SEMIRREMOLQUE TANQUE (QUIMICOS)/CON CALEFACCION/SIN AISLAR.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(51, 'SEMIRREMOLQUE TANQUE (QUIMICOS)/SIN CALEFACCION/AISLADO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(52, 'SEMIRREMOLQUE TANQUE (QUIMICOS)/CON CALEFACCION/AISLADO.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(53, 'SEMIRREMOLQUE GONDOLA-CERRADA.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(54, 'SEMIRREMOLQUE GONDOLA-ABIERTA.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(55, 'SEMIRREMOLQUE TIPO CAJA CERRADA 48\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(56, 'SEMIRREMOLQUE TIPO CAJA CERRADA 53\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(57, 'SEMIRREMOLQUE TIPO CAJA REFRIGERADA 48\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(58, 'SEMIRREMOLQUE TIPO CAJA REFRIGERADA 53\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(59, 'DOBLE SEMIRREMOLQUE.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(60, 'OTROS.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(61, 'TANQUE 20\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(62, 'TANQUE 40\'.', NULL, NULL);
INSERT INTO `Contenedor` (`Id`, `nombre`, `createdAt`, `updatedAt`) VALUES(63, 'CARRO DE FERROCARRIL', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
