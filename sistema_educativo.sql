-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2024 a las 00:15:45
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
-- Base de datos: `sistema_educativo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitacion`
--

CREATE TABLE `capacitacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `horario` time NOT NULL,
  `jornada` enum('Mañana','Tarde','Noche') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre`, `horario`, `jornada`) VALUES
(1, 'Modulo 1 Sistemas de direccion y conducción.', '00:00:00', ''),
(2, 'Modulo 1 Sistemas de direccion y conducción.', '00:00:00', ''),
(3, 'Modulo 1 Sistemas de dirección y conducción.', '00:00:00', ''),
(4, 'Modulo 2 sistemas de alimentación', '00:00:00', ''),
(5, 'Modulo 2 sistemas de alimentación', '00:00:00', ''),
(6, 'Modulo 2 sistemas de alimentación', '00:00:00', ''),
(7, 'Modulo 3 Motores de combustión interna', '00:00:00', ''),
(8, 'Modulo 3 Motores de combustión interna', '00:00:00', ''),
(9, 'Modulo 3 Motores de combustión interna', '00:00:00', ''),
(10, 'Modulo 4 Sistema Eléctrico.', '00:00:00', ''),
(11, 'Modulo 4 Sistema Eléctrico.', '00:00:00', ''),
(12, 'Modulo 4 Sistema Eléctrico.', '00:00:00', ''),
(13, 'Inyección Electrónica', '00:00:00', ''),
(14, 'Inyección Electrónica', '00:00:00', ''),
(15, 'Inyección Electrónica', '00:00:00', ''),
(16, 'Sistema Electrónico Avanzado', '00:00:00', ''),
(17, 'Sistema Electrónico Avanzado', '00:00:00', ''),
(18, 'Sistema Electrónico Avanzado', '00:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado_de_pago` enum('Al dia','Atrasado') NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `jornada` enum('Sábado','Domingo') NOT NULL,
  `horario` enum('Matutino','Vespertino') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `nombre`, `direccion`, `estado_de_pago`, `usuario_id`, `jornada`, `horario`) VALUES
(1, 'Dionicio Vasquez', 'Ciudad', 'Al dia', NULL, 'Sábado', 'Matutino'),
(3, 'Gilmar Garcia', 'Ciudad', 'Atrasado', NULL, 'Domingo', 'Matutino'),
(4, 'Jeremy Loaiza', 'Ciudad', 'Al dia', NULL, 'Domingo', 'Matutino'),
(5, 'Fernando Diaz', 'Mixco', 'Al dia', NULL, 'Domingo', 'Matutino'),
(6, 'Pedro Guerra', 'Mixco', 'Al dia', NULL, 'Sábado', 'Vespertino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `mensaje_usuario` text NOT NULL,
  `respuesta_asistente` text NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `feedback`
--

INSERT INTO `feedback` (`id`, `usuario`, `mensaje_usuario`, `respuesta_asistente`, `fecha_hora`) VALUES
(1, 'anonimo', 'hola', 'Hola, Escribe una de las siguientes opciones para ayudarte:\r\n        ayuda, registro, pago, calificaciones', '2024-11-09 19:36:03'),
(2, 'anonimo', 'registro', 'Para registrarte, dirígete a la sección \"Registro de Usuario\". Sigue las instrucciones en pantalla para completar tu registro.', '2024-11-09 19:36:14'),
(3, 'anonimo', 'hola', 'Hola, Escribe una de las siguientes opciones para ayudarte:\r\n        ayuda, registro, pago, calificaciones', '2024-11-09 23:12:36'),
(4, 'anonimo', 'pago', 'Para realizar pagos, ve a la sección \"Gestión de Pagos\". Ahí podrás ver el estado de tus pagos y realizar abonos.', '2024-11-09 23:12:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) DEFAULT NULL,
  `modulo` varchar(50) NOT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL CHECK (`calificacion` >= 0 and `calificacion` <= 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Gestionar Estudiantes', 'Permiso para ver, modificar y eliminar estudiantes'),
(2, 'Gestionar Pagos', 'Permiso para ver y registrar pagos de estudiantes'),
(3, 'Gestionar Notas', 'Permiso para modificar notas de estudiantes'),
(4, 'Ver Reportes', 'Permiso para visualizar reportes académicos y financieros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `clase_asignada` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_capacitacion`
--

CREATE TABLE `registro_capacitacion` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `capacitacion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Profesor'),
(3, 'Secretaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permisos`
--

CREATE TABLE `rol_permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `permiso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_permisos`
--

INSERT INTO `rol_permisos` (`id`, `rol_id`, `permiso_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 3, 2),
(6, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `rol` enum('Profesor','Administrador','Secretaria') NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `rol`, `password`, `email`) VALUES
(12, 'Marlon', 'Administrador', '$2y$10$JJwHFz1NCpmiFWq2n7MkL.qmIZ4.gTKELdleqfpbFkCFa1DYpmFoq', 'marlonadmin@localhost.com'),
(13, 'Melanie', 'Secretaria', '$2y$10$lMMn9co8L17G8UcfpqaHGeLI6ZAJSPjr56kIvS8HmySVQ58mHcVrm', 'melaniesecre@localhost.com'),
(14, 'Giancarlo ', 'Profesor', '$2y$10$Iexzl6eHM6RYTqR190IHkOR2dWuB16XRg6KyosSDcXQka8LskQ1IK', 'giancarloprofe@localhost.com'),
(15, 'Rodolfo', 'Profesor', '$2y$10$ximCmaUeiXmNWs0mJFjGzuy.WodsyLZXeZze01nJhUuGW1SR2NIF6', 'rodolfoprofe@localhost.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `capacitacion`
--
ALTER TABLE `capacitacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `clase_asignada` (`clase_asignada`);

--
-- Indices de la tabla `registro_capacitacion`
--
ALTER TABLE `registro_capacitacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `capacitacion_id` (`capacitacion_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol_permisos`
--
ALTER TABLE `rol_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_id` (`rol_id`),
  ADD KEY `permiso_id` (`permiso_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `capacitacion`
--
ALTER TABLE `capacitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_capacitacion`
--
ALTER TABLE `registro_capacitacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol_permisos`
--
ALTER TABLE `rol_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`);

--
-- Filtros para la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD CONSTRAINT `profesores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `profesores_ibfk_2` FOREIGN KEY (`clase_asignada`) REFERENCES `clases` (`id`);

--
-- Filtros para la tabla `registro_capacitacion`
--
ALTER TABLE `registro_capacitacion`
  ADD CONSTRAINT `registro_capacitacion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `registro_capacitacion_ibfk_2` FOREIGN KEY (`capacitacion_id`) REFERENCES `capacitacion` (`id`);

--
-- Filtros para la tabla `rol_permisos`
--
ALTER TABLE `rol_permisos`
  ADD CONSTRAINT `rol_permisos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `rol_permisos_ibfk_2` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
