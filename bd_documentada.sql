-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2026 a las 16:41:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_bolsa_oruro`
--
CREATE DATABASE IF NOT EXISTS `bd_bolsa_oruro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `bd_bolsa_oruro`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_auditoria`
--

CREATE TABLE `bitacora_auditoria` (
  `id_bitacora` int(11) NOT NULL COMMENT 'ID del evento de seguridad',
  `id_usuario` int(11) DEFAULT NULL COMMENT 'Usuario que ejecutó la acción',
  `accion` varchar(100) NOT NULL COMMENT 'Tipo de operación realizada',
  `detalle` text NOT NULL COMMENT 'Descripción técnica del evento',
  `direccion_ip` varchar(45) NOT NULL COMMENT 'IP desde donde se realizó la operación',
  `fecha_evento` datetime DEFAULT current_timestamp() COMMENT 'Marca de tiempo del evento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Bitácora de seguridad y trazabilidad del G.A.D.OR.';

--
-- Volcado de datos para la tabla `bitacora_auditoria`
--

INSERT INTO `bitacora_auditoria` (`id_bitacora`, `id_usuario`, `accion`, `detalle`, `direccion_ip`, `fecha_evento`) VALUES
(1, 3, 'INICIO_SESION', 'Acceso correcto al sistema', '127.0.0.1', '2026-11-11 11:26:02'),
(2, 4, 'INICIO_SESION', 'Acceso correcto al sistema', '127.0.0.1', '2026-11-11 11:26:53'),
(3, 4, 'NUEVA_OFERTA', 'ecargado de limpieza', '127.0.0.1', '2026-11-11 11:27:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas_laborales`
--

CREATE TABLE `ofertas_laborales` (
  `id_oferta` int(11) NOT NULL COMMENT 'Identificador único de la vacante',
  `id_empresa` int(11) NOT NULL COMMENT 'Usuario o unidad que publica la oferta',
  `titulo_cargo` varchar(150) NOT NULL COMMENT 'Nombre del puesto requerido',
  `descripcion` text NOT NULL COMMENT 'Requisitos y funciones del cargo',
  `municipio` varchar(80) DEFAULT 'Oruro Cercado' COMMENT 'Ubicación dentro del departamento de Oruro',
  `salario_referencial` decimal(10,2) NOT NULL COMMENT 'Monto salarial en Bolivianos (Bs)',
  `modalidad` enum('Presencial','Semipresencial','Teletrabajo') DEFAULT 'Presencial' COMMENT 'Modalidad de trabajo',
  `estado_oferta` enum('Vigente','Cerrada') DEFAULT 'Vigente' COMMENT 'Estado actual de la convocatoria',
  `eliminado` tinyint(1) DEFAULT 0 COMMENT 'Borrado lógico: 0=Activo, 1=Eliminado',
  `fecha_publicacion` datetime DEFAULT current_timestamp() COMMENT 'Fecha de creación de la oferta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Registro de vacantes laborales departamentales';

--
-- Volcado de datos para la tabla `ofertas_laborales`
--

INSERT INTO `ofertas_laborales` (`id_oferta`, `id_empresa`, `titulo_cargo`, `descripcion`, `municipio`, `salario_referencial`, `modalidad`, `estado_oferta`, `eliminado`, `fecha_publicacion`) VALUES
(1, 1, 'Desarrollador de Sistemas Web', 'Titulado en Ing. de Sistemas, Informática o Técnico Superior con dominio de MVC y MySQL.', 'Oruro Cercado', 6500.00, 'Presencial', 'Vigente', 0, '2026-11-11 10:59:10'),
(2, 1, 'Administrador de Redes e Infraestructura', 'Especialista en cableado estructurado, routers y servidores Linux/Windows.', 'Challapata', 5800.00, 'Presencial', 'Vigente', 0, '2026-11-11 10:59:10'),
(3, 4, 'ecargado de limpieza', 'no se requiere experiencia solo compromiso', 'Oruro Cercado', 3500.00, 'Presencial', 'Vigente', 0, '2026-11-11 11:27:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id_postulacion` int(11) NOT NULL COMMENT 'Identificador único de la postulación',
  `id_oferta` int(11) NOT NULL COMMENT 'Oferta laboral a la que aplica',
  `id_postulante` int(11) NOT NULL COMMENT 'Profesional que se postula',
  `resumen_perfil` text NOT NULL COMMENT 'Carta de presentación o resumen de experiencia',
  `enlace_cv` varchar(255) NOT NULL COMMENT 'Ruta o enlace al Currículum Vitae',
  `estado_postulacion` enum('Recibido','En Revisión','Seleccionado','Descartado') DEFAULT 'Recibido' COMMENT 'Fase de evaluación',
  `fecha_postulacion` datetime DEFAULT current_timestamp() COMMENT 'Fecha y hora exacta de postulación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Relación entre profesionales postulantes y ofertas laborales';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL COMMENT 'Identificador único del usuario',
  `nombre_completo` varchar(120) NOT NULL COMMENT 'Nombre completo o razón social',
  `correo` varchar(100) NOT NULL COMMENT 'Correo electrónico para login',
  `clave` varchar(255) NOT NULL COMMENT 'Contraseña encriptada con Bcrypt',
  `rol` enum('postulante','empresa','administrador') DEFAULT 'postulante' COMMENT 'Nivel de acceso en el sistema',
  `telefono` varchar(20) NOT NULL COMMENT 'Teléfono de contacto en Oruro',
  `eliminado` tinyint(1) DEFAULT 0 COMMENT 'Borrado lógico: 0=Activo, 1=Eliminado',
  `fecha_registro` datetime DEFAULT current_timestamp() COMMENT 'Fecha de alta del registro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Almacena los actores de la Bolsa de Trabajo Departamental';

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_completo`, `correo`, `clave`, `rol`, `telefono`, `eliminado`, `fecha_registro`) VALUES
(1, 'Gobierno Autónomo Departamental de Oruro', 'rrhh@oruro.gob.bo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'empresa', '60408150', 0, '2026-11-11 10:59:10'),
(2, 'Juan Pérez Mamani - Ing. Sistemas', 'juan@correo.bo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'postulante', '71800000', 0, '2026-11-11 10:59:10'),
(3, 'mariela guzman', 'marielaguzman@gmail.com', '$2y$10$ZBgo9K4XCsolmZHjRYM9P.qi..emevEFm39jIKUoGgrKC5TWGq9O6', 'postulante', '72454088', 0, '2026-11-11 11:25:56'),
(4, 'hotel eden', 'hoteleden@gmail.com', '$2y$10$VvTcHv4vk2Vg1ascBwPphO2zeiduK9xITRBqa1jv3xfDGwF8WPXHW', 'empresa', '78458458', 0, '2026-11-11 11:26:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora_auditoria`
--
ALTER TABLE `bitacora_auditoria`
  ADD PRIMARY KEY (`id_bitacora`);

--
-- Indices de la tabla `ofertas_laborales`
--
ALTER TABLE `ofertas_laborales`
  ADD PRIMARY KEY (`id_oferta`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id_postulacion`),
  ADD KEY `id_oferta` (`id_oferta`),
  ADD KEY `id_postulante` (`id_postulante`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora_auditoria`
--
ALTER TABLE `bitacora_auditoria`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID del evento de seguridad', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ofertas_laborales`
--
ALTER TABLE `ofertas_laborales`
  MODIFY `id_oferta` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la vacante', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id_postulacion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la postulación';

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único del usuario', AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ofertas_laborales`
--
ALTER TABLE `ofertas_laborales`
  ADD CONSTRAINT `ofertas_laborales_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD CONSTRAINT `postulaciones_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas_laborales` (`id_oferta`),
  ADD CONSTRAINT `postulaciones_ibfk_2` FOREIGN KEY (`id_postulante`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
