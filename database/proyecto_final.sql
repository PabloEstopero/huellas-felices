-- Crear la base de datos si no existe y seleccionarla
CREATE DATABASE IF NOT EXISTS `proyecto_final` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `proyecto_final`;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2026 a las 23:29:47
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
-- Base de datos: `proyecto_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idCita` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `fecha_cita` date NOT NULL,
  `motivo_cita` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `texto` longtext NOT NULL,
  `fecha` date NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `imagen`, `texto`, `fecha`, `idUser`) VALUES
(17, '¡Encuentra a tu mejor amigo! Arranca nuestra campaña de adopción de verano', 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=800&q=80', 'El verano es una época de gran actividad en nuestra protectora y necesitamos más que nunca familias dispuestas a abrir su corazón y su hogar.\r\n\r\nEste mes hemos lanzado una campaña especial para dar visibilidad a perros y gatos que llevan más tiempo con nosotros esperando una oportunidad. Todos nuestros animales se entregan vacunados, desparasitados, con microchip y esterilizados.\r\n\r\nVen a conocernos en horario de visitas o pide una cita previa a través de nuestra web. ¡Salva una vida y gana un compañero fiel para toda la vida!', '2026-08-24', 3),
(18, '¡Gracias por vuestra generosidad en la última recogida de pienso!', 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=800&q=80', 'Queremos dar las más sinceras gracias a todos los voluntarios, colaboradores y vecinos que se acercaron el pasado fin de semana al punto de recogida solidaria en el centro comercial.\r\n\r\nGracias a vuestra enorme solidaridad, hemos conseguido recolectar más de 600 kilos de comida seca y húmeda, además de mantas y productos de limpieza indispensables para el día a día en el refugio.\r\n\r\nCon gestos como el vuestro, nuestros peludos tienen garantizado el alimento y el bienestar durante los próximos meses. ¡Sois increíbles!', '2026-08-24', 3),
(20, 'Consejos prácticos para proteger a tus mascotas de las altas temperaturas', 'https://images.unsplash.com/photo-1534361960057-19889db9621e?auto=format&fit=crop&w=800&q=80', 'Con la llegada de los meses más calurosos del año, es fundamental extremar las precauciones para proteger la salud de nuestros perros y gatos frente a los golpes de calor.\r\n\r\nAquí te dejamos algunas recomendaciones clave de nuestros veterinarios:\r\n\r\nAsegúrate de que siempre tengan agua fresca y limpia a su disposición.\r\n\r\nEvita pasear en las horas centrales del día; los adoquines y el asfalto caliente pueden quemar gravemente sus almohadillas.\r\n\r\nNunca dejes a un animal dentro de un vehículo estacionado, ni siquiera con las ventanillas ligeramente bajadas.\r\n\r\n¡Su seguridad y la de los tuyos está en nuestras manos!', '2026-08-24', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_data`
--

CREATE TABLE `users_data` (
  `idUser` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` text DEFAULT NULL,
  `sexo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users_data`
--

INSERT INTO `users_data` (`idUser`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_nacimiento`, `direccion`, `sexo`) VALUES
(3, 'Carlos', 'García', 'carlos.demo@example.com', '600000001', '1990-01-15', 'Calle Ejemplo 1, Málaga', 'Masculino'),
(22, 'Laura', 'Martínez', 'laura.demo@example.com', '600000002', '1992-05-20', 'Calle Ejemplo 2, Málaga', 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_login`
--

CREATE TABLE `users_login` (
  `idLogin` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users_login`
--

INSERT INTO `users_login` (`idLogin`, `idUser`, `usuario`, `password`, `rol`) VALUES
(1, 3, 'admin_demo', '$2y$10$euRDFpVnPYzY/Yxq5EWRMuKqlxxjKt/VY0W3f4rwBPKxIZIkSa62i', 'admin'),
(17, 22, 'usuario_demo', '$2y$10$WAnl9PwxHn1ePA8KQbNcKeDLotD.sVHodHfJh2jD/Qz707wBhNhm.', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idCita`),
  ADD KEY `fk_cita_user` (`idUser`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`),
  ADD UNIQUE KEY `titulo` (`titulo`),
  ADD KEY `fk_noticia_user` (`idUser`);

--
-- Indices de la tabla `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`idLogin`),
  ADD UNIQUE KEY `idUser` (`idUser`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `users_data`
--
ALTER TABLE `users_data`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `users_login`
--
ALTER TABLE `users_login`
  MODIFY `idLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_cita_user` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`) ON DELETE CASCADE;

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `fk_noticia_user` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users_login`
--
ALTER TABLE `users_login`
  ADD CONSTRAINT `fk_login_user` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
