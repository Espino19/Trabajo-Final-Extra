-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 05-12-2015 a las 18:26:30
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `inventario`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `almacen`
-- 

CREATE TABLE `almacen` (
  `id_a` varchar(30) NOT NULL,
  `existencias` int(10) NOT NULL,
  `limite` int(10) NOT NULL,
  PRIMARY KEY  (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `almacen`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `articulo`
-- 

CREATE TABLE `articulo` (
  `id_a` varchar(30) NOT NULL,
  `codigo` varchar(40) NOT NULL,
  `nombre_a` varchar(20) NOT NULL,
  `precio_p` double(10,2) NOT NULL,
  `precio_v` double(10,2) NOT NULL,
  `precio_m` double(10,2) NOT NULL,
  `existencias` int(10) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY  (`id_a`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `nombre_a` (`nombre_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `articulo`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `entrada_almacen`
-- 

CREATE TABLE `entrada_almacen` (
  `id_e` int(50) NOT NULL auto_increment,
  `id_a` varchar(30) NOT NULL,
  `RFC` varchar(30) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `f_e` date NOT NULL,
  PRIMARY KEY  (`id_e`),
  KEY `id_a` (`id_a`),
  KEY `RFC` (`RFC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `entrada_almacen`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `entrada_tienda`
-- 

CREATE TABLE `entrada_tienda` (
  `id_r` int(50) NOT NULL auto_increment,
  `id_a` varchar(30) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `f_e_t` date NOT NULL,
  PRIMARY KEY  (`id_r`),
  KEY `id_a` (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `entrada_tienda`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `proveedor`
-- 

CREATE TABLE `proveedor` (
  `nombre_p` varchar(20) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `cp` int(20) NOT NULL,
  `telefono` int(20) NOT NULL,
  `RFC` varchar(30) NOT NULL,
  `correo` varchar(30) NOT NULL,
  PRIMARY KEY  (`RFC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `proveedor`
-- 

INSERT INTO `proveedor` VALUES ('PEQUESILLO', 'NOSE', 2378, 2147483647, 'ZADJ940915', 'jesus_bariofl@hotmail.com');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `reporte`
-- 

CREATE TABLE `reporte` (
  `id_r` int(99) NOT NULL auto_increment,
  `nombre_a` varchar(100) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_a` varchar(60) NOT NULL,
  `limite` int(50) NOT NULL,
  `existencias` int(50) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id_r`),
  UNIQUE KEY `id_a` (`id_a`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `nombre_a` (`nombre_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `reporte`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `reporte_almacen`
-- 

CREATE TABLE `reporte_almacen` (
  `id_r` int(99) NOT NULL auto_increment,
  `nombre_a` varchar(100) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_a` varchar(60) NOT NULL,
  `limite` int(50) NOT NULL,
  `existencias` int(50) NOT NULL,
  `fecha_m` date NOT NULL,
  PRIMARY KEY  (`id_r`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `id_a` (`id_a`),
  KEY `nombre_a` (`nombre_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `reporte_almacen`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `reporte_venta`
-- 

CREATE TABLE `reporte_venta` (
  `id_r` int(255) NOT NULL auto_increment,
  `codigo` varchar(100) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `fecha_v` date NOT NULL,
  PRIMARY KEY  (`id_r`),
  KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `reporte_venta`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tienda`
-- 

CREATE TABLE `tienda` (
  `id_a` varchar(30) NOT NULL,
  `existencias` int(11) NOT NULL,
  `limite` int(10) NOT NULL,
  PRIMARY KEY  (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `tienda`
-- 


-- 
-- Filtros para las tablas descargadas (dump)
-- 

-- 
-- Filtros para la tabla `almacen`
-- 
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`id_a`) REFERENCES `articulo` (`id_a`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `entrada_almacen`
-- 
ALTER TABLE `entrada_almacen`
  ADD CONSTRAINT `entrada_almacen_ibfk_3` FOREIGN KEY (`id_a`) REFERENCES `articulo` (`id_a`) ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_almacen_ibfk_4` FOREIGN KEY (`RFC`) REFERENCES `proveedor` (`RFC`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `entrada_tienda`
-- 
ALTER TABLE `entrada_tienda`
  ADD CONSTRAINT `entrada_tienda_ibfk_1` FOREIGN KEY (`id_a`) REFERENCES `articulo` (`id_a`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `reporte`
-- 
ALTER TABLE `reporte`
  ADD CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`nombre_a`) REFERENCES `articulo` (`nombre_a`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_ibfk_2` FOREIGN KEY (`codigo`) REFERENCES `articulo` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_ibfk_3` FOREIGN KEY (`id_a`) REFERENCES `articulo` (`id_a`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `reporte_almacen`
-- 
ALTER TABLE `reporte_almacen`
  ADD CONSTRAINT `reporte_almacen_ibfk_7` FOREIGN KEY (`nombre_a`) REFERENCES `articulo` (`nombre_a`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_almacen_ibfk_8` FOREIGN KEY (`codigo`) REFERENCES `articulo` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_almacen_ibfk_9` FOREIGN KEY (`id_a`) REFERENCES `articulo` (`id_a`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `reporte_venta`
-- 
ALTER TABLE `reporte_venta`
  ADD CONSTRAINT `reporte_venta_ibfk_1` FOREIGN KEY (`codigo`) REFERENCES `articulo` (`codigo`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `tienda`
-- 
ALTER TABLE `tienda`
  ADD CONSTRAINT `tienda_ibfk_1` FOREIGN KEY (`id_a`) REFERENCES `articulo` (`id_a`) ON UPDATE CASCADE;
