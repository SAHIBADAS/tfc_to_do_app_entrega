-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2025 a las 10:54:25
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
-- Base de datos: `taskhive`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `chat`
--

INSERT INTO `chat` (`id`, `idProyecto`) VALUES
(89, 107),
(91, 109),
(97, 115),
(117, 135);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` int(11) NOT NULL,
  `contenido` varchar(200) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idChat` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `contenido`, `idUsuario`, `idChat`, `fecha_creacion`) VALUES
(375, 'hola loca!', 39, 117, '2025-05-16 08:30:28'),
(376, 'como estas???\', 39, 117, '2025-05-16 08:30:31'),
(377, 'dfhdsfhdsfhdfsahhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 39, 117, '2025-05-16 10:23:20'),
(378, 'holaa!!!!', 40, 117, '2025-05-16 10:31:20'),
(379, 'dfhdsfhdsfhdfsahhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 40, 117, '2025-05-16 10:31:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `creador` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`id`, `nombre`, `fecha`, `creador`) VALUES
(107, 'Proyecto1', '2025-04-22 09:17:23', 'Pepito1'),
(109, 'El proyecto de Pepe', '2025-04-22 10:41:22', 'Pepito1'),
(115, 'El proyecto de samy', '2025-04-29 09:54:14', 'Pepe'),
(135, 'El proyecto de guille', '2025-05-16 08:29:55', 'Diego');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_usuario`
--

CREATE TABLE `proyecto_usuario` (
  `idUsuario` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `rol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `proyecto_usuario`
--

INSERT INTO `proyecto_usuario` (`idUsuario`, `idProyecto`, `rol`) VALUES
(39, 135, 'creador'),
(40, 135, 'colaborador'),
(52, 115, 'creador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL,
  `estimacion` date DEFAULT NULL,
  `prioridad` int(11) NOT NULL,
  `creador` varchar(45) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `color_agenciado` char(7) DEFAULT '#bebdbd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `task`
--

INSERT INTO `task` (`id`, `idProyecto`, `titulo`, `estado`, `estimacion`, `prioridad`, `creador`, `fecha_creacion`, `descripcion`, `color_agenciado`) VALUES
(163, 107, 'Mi nueva tarea', 0, '2025-04-16', 0, 'Pepito1', '2025-04-22 00:00:00', 'hola', '#bebdbd'),
(165, 109, 'Mi nueva tarea', 0, '2025-05-02', 0, 'Pepito1', '2025-04-22 00:00:00', 'hola', '#bebdbd'),
(171, 115, 'Mi nueva tarea', 0, '2025-04-17', 0, 'Pepe', '2025-04-29 00:00:00', 'Hola', '#bebdbd'),
(176, 135, 'Mi nueva tarea', 2, '2025-05-24', 1, 'Diego', '2025-05-16 00:00:00', 'Hola', '#d1d1d1'),
(177, 135, 'La tarea de ootro color', 2, '2025-05-30', 0, 'Diego', '2025-05-16 00:00:00', 'fsfsdfsdfsdf', '#eefcbb'),
(178, 135, 'Mi otra tarea de color', 2, '2025-05-30', 2, 'Diego', '2025-05-16 00:00:00', 'sdfsdfsdf', '#5deaa8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `ultima_sesion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `avatar`, `apellidos`, `email`, `clave`, `ultima_sesion`) VALUES
(39, 'Diego', '../avatars/diego.martinez.alberquilla@gmail.com_avatar.jpg', 'Martinez Alberquilla', 'diego.martinez.alberquilla@gmail.com', '$2y$10$2XR7AZ5reJHhjg7i4AFtQ.1g2HYkYDFNO28vSt2Yl8DllpwdAHfnq', '2025-05-16 08:33:24'),
(40, 'Aleksandra', '../avatars/aleksandra@gmail.com_avatar.jpg', 'Martinez', 'aleksandra@gmail.com', '$2y$10$5slk5I1YF0sLHsMLzNz7N.JCMa/iDLEnF8PAgJ6xAV9Zldipwbsee', '2025-05-16 10:31:14'),
(52, 'Pepe', '../avatars/pepito@gmail.com_avatar.jpg', 'Martinez Alberquilla', 'pepito@gmail.com', '$2y$10$KBmyliBqDBZvIb16ejXKueeh8DUlEfF4QWjkVKXLsRjwtmRmoS8Oy', '2025-04-29 16:50:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chat_proyecto` (`idProyecto`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mensaje_usuario` (`idUsuario`),
  ADD KEY `idx_mensaje_chat` (`idChat`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyecto_usuario`
--
ALTER TABLE `proyecto_usuario`
  ADD PRIMARY KEY (`idUsuario`,`idProyecto`),
  ADD KEY `fk_proyecto_usuario_proyecto` (`idProyecto`);

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_task_proyecto` (`idProyecto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=380;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_proyecto` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `fk_mensaje_chat` FOREIGN KEY (`idChat`) REFERENCES `chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mensaje_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto_usuario`
--
ALTER TABLE `proyecto_usuario`
  ADD CONSTRAINT `fk_proyecto_usuario_proyecto` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_proyecto_usuario_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk_task_proyecto` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
