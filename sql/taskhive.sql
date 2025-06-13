-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-06-2025 a las 10:47:06
-- Versión del servidor: 10.11.10-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u458548233_taskhive`
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
(117, 135),
(118, 136),
(124, 142),
(127, 145),
(128, 146),
(129, 147),
(130, 148),
(137, 155),
(143, 161);

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
(453, 'kuigiukhpoij', 64, 137, '2025-06-13 08:18:16'),
(454, 'safafdd', 64, 137, '2025-06-13 12:02:40'),
(455, 'qetqe', 64, 137, '2025-06-13 12:02:41');

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
(135, 'El proyecto de guille', '2025-05-16 08:29:55', 'Diego'),
(136, 'El proyecto de samy', '2025-05-16 11:55:29', 'Diego'),
(142, 'El proyecto de samy', '2025-05-20 11:49:45', 'Asier1'),
(145, 'Proyecto1', '2025-05-20 15:30:35', 'Diego1'),
(146, 'El proyecto de prueba', '2025-05-21 09:50:25', 'Diego'),
(147, 'Mi nuevo proyecto', '2025-05-21 10:51:19', 'Diego'),
(148, 'dasda', '2025-05-21 09:23:08', 'Sammy13'),
(155, 'El proyecto de samy', '2025-05-26 13:04:52', 'Diego'),
(161, 'Pepito', '2025-06-12 11:21:37', 'Diego');

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
(63, 148, 'creador'),
(63, 155, 'colaborador'),
(64, 155, 'creador'),
(64, 161, 'creador'),
(65, 155, 'colaborador');

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
  `color_agenciado` char(7) DEFAULT '#bebdbd',
  `idUsuarioAsignado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `task`
--

INSERT INTO `task` (`id`, `idProyecto`, `titulo`, `estado`, `estimacion`, `prioridad`, `creador`, `fecha_creacion`, `descripcion`, `color_agenciado`, `idUsuarioAsignado`) VALUES
(199, 145, 'MI nueva tarea', 2, '2025-05-09', 0, 'Diego1', '2025-05-20 00:00:00', 'La vida está compuesta por instantes que, aunque parezcan simples, pueden tener un gran impacto. Cada paso, cada error, cada logro deja una huella. A veces no entendemos el propósito de ciertas situaciones, pero con el tiempo descubrimos que todo tiene un sentido. La paciencia, la empatía y la gratitud son claves para avanzar con equilibrio. Vivir con atención plena nos ayuda a valorar lo que somos, lo que tenemos y todo lo que aún podemos llegar a ser.', '#febebe', NULL),
(200, 145, 'Mi otra tarea', 2, '2025-05-22', 0, 'Diego1', '2025-05-20 00:00:00', 'sadasdasd', '#fdb4fe', NULL),
(201, 145, 'sdfsfd', 0, '2025-05-16', 0, 'Diego1', '2025-05-21 00:00:00', 'La vida está llena de pequeños momentos que nos enseñan lecciones importantes. A veces enfrentamos desafíos, pero son esos obstáculos los que nos permiten crecer y encontrar la felicidad en el camino.', '#bebdbd', NULL),
(202, 145, 'wweew', 0, '2025-05-10', 0, 'Diego1', '2025-05-21 00:00:00', 'La vida está compuesta por instantes que, aunque parezcan simples, pueden tener un gran impacto. Cada paso, cada error, cada logro deja una huella. A veces no entendemos el propósito de ciertas situaciones, pero con el tiempo descubrimos que todo tiene un sentido. La paciencia, la empatía y la gratitud son claves para avanzar con equilibrio. Vivir con atención plena nos ayuda a valorar lo que somos, lo que tenemos y todo lo que aún podemos llegar a ser. wewe', '#bebdbd', NULL),
(203, 147, 'Mi nueva tarea', 1, '2025-05-15', 0, 'Diego', '2025-05-21 00:00:00', 'erfqwerqwrqw', '#ffd6d6', NULL),
(205, 148, 'KLK', 1, '2025-05-22', 0, 'Sammy13', '2025-05-21 00:00:00', 'asd', '#bebdbd', 63),
(213, 155, 'Plan Semanal', 2, '2025-05-23', 0, 'Diego', '2025-05-26 00:00:00', 'Organiza las actividades y compromisos de la semana. Asigna prioridades, tiempos y objetivos claros para mantenerte enfocado y productivo.', '#fea9a9', 64),
(214, 155, 'Revisión Doc', 4, '2025-05-23', 1, 'Diego', '2025-05-26 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#b3bfff', 64),
(215, 155, 'Cita Médica', 4, '2025-05-23', 0, 'Diego', '2025-05-26 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#ffb8f2', 64),
(216, 155, 'Lista Compras', 1, '2025-05-23', 0, 'Diego', '2025-05-26 00:00:00', 'Haz una lista detallada de los productos que necesitas comprar, priorizando alimentos, artículos del hogar y cualquier otra necesidad urgente.', '#ffe894', 64),
(219, 155, 'Estudio Final', 2, '2025-05-23', 0, 'Diego', '2025-05-27 00:00:00', 'Revisa apuntes, libros y material de apoyo para prepararte adecuadamente para tu examen final. Establece tiempos de estudio y descansos.', '#c7c7c7', 64),
(220, 155, 'Ideas Nuevas', 3, '2025-05-23', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#b4fef5', 65),
(221, 155, 'Limpieza Hogar', 2, '2025-05-23', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#d4fec8', 64),
(222, 155, 'Leer Artículo', 3, '2025-05-23', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#ffce7a', 64),
(223, 155, 'Pago Servicios', 0, '2025-05-23', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#8ae8ff', 64),
(224, 155, 'Orden Armario', 4, '2025-05-24', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#fe9090', 64),
(225, 155, 'Ejercicio Hoy', 2, '2025-05-30', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#95fecd', 64),
(226, 155, 'Clases Online', 3, '2025-05-22', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#86dafe', 64),
(227, 155, 'Enviar Email', 1, '2025-05-09', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#a2f1fb', 64),
(228, 155, 'Llamar Cliente', 0, '2025-05-30', 0, 'Diego', '2025-05-27 00:00:00', 'La vida está llena de momentos únicos que, aunque pequeños, pueden tener un gran impacto. Cada sonrisa, cada palabra amable y cada gesto de bondad contribuyen a un mundo mejor. No subestimes el poder de tus acciones cotidianas, porque incluso los actos más simples pueden transformar un día entero. Vive con intención y gratitud.', '#ffc7c7', 64),
(230, 155, 'Hacer comida', 2, '2025-06-04', 4, 'Diego', '2025-06-03 00:00:00', 'Hacer la comida', '#ffbeb3', 63);

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
(63, 'Sammy13', '../avatars/asierasier@gmail.com_avatar.png', 'Dian13', 'sammydianya@gmail.com', '$2y$10$DySCiy1sNVKUntMFvO7k0OxDQeKcPHGGEXt6dV80ZPfuPe12hGmge', '2025-05-21 09:23:46'),
(64, 'Diego', '../avatars/diego.martinez.alberquilla@gmail.com_avatar.jpg', 'Martínez Alberquilla', 'diego.martinez.alberquilla@gmail.com', '$2y$10$6iYyVVXKGRiGzU2kmk3/veJE3nuExQEm45jQ5GiIRtJZQ8UIDnIQS', '2025-06-13 10:34:36'),
(65, 'admin', '../avatars/taskhive@taskhive.space_avatar.png', 'admin', 'taskhive@taskhive.space', '$2y$10$VCb2PKNDx7I9XJVJ1XyDvejJ/Gv9wi6FPoOKB0t0at0XHZABFbZT.', '2025-05-29 12:38:45'),
(66, 'María', '', 'Fernández', 'matefe1706@gmail.com', '$2y$10$k84BKF2f.4udewYGHVFDju/Cj55AwUzquBQG4SQFIjDxWdgDkNTP6', '2025-06-12 11:20:11');

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
  ADD KEY `idx_task_proyecto` (`idProyecto`),
  ADD KEY `fk_task_usuario_asignado` (`idUsuarioAsignado`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=456;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
  ADD CONSTRAINT `fk_task_proyecto` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_usuario_asignado` FOREIGN KEY (`idUsuarioAsignado`) REFERENCES `usuario` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
