-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generaci�n: 06-07-2023 a las 10:07:19
-- Versi�n del servidor: 10.6.14-MariaDB-cll-lve
-- Versi�n de PHP: 8.1.16

START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

--
-- Base de datos: `wweixrni_fundacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cursos`
--

CREATE TABLE `tipo_cursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estado_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `modif_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `tipo_cursos`
--

INSERT INTO `tipo_cursos` (`id`, `descripcion`, `estado_id`, `user_id`, `modif_user_id`, `created_at`, `updated_at`) VALUES
(1, 'GASTROMONIA', 1, 1, 1, '2023-06-29 01:40:21', '2023-06-29 01:40:21'),
(2, 'ADMINISTRACION Y GESTION ', 1, 3, 3, '2023-07-05 14:19:39', '2023-07-05 14:19:39'),
(3, 'BELLEZA Y ESTETICA', 1, 3, 3, '2023-07-05 14:21:45', '2023-07-05 14:21:45'),
(4, 'INFORM�TICA', 1, 1, 1, '2023-07-05 22:59:17', '2023-07-05 23:00:23'),
(5, 'ARTE Y ARTESANIA', 1, 1, 1, '2023-07-05 22:59:35', '2023-07-05 22:59:35'),
(6, 'ELECTRICIDAD Y ELECTR�NICA', 1, 1, 1, '2023-07-05 23:00:09', '2023-07-05 23:00:09'),
(7, 'TEJIDOS', 1, 1, 1, '2023-07-05 23:01:02', '2023-07-05 23:01:02'),
(8, 'AUTOMOTORES', 1, 1, 1, '2023-07-05 23:01:14', '2023-07-05 23:01:14'),
(9, 'INDUSTRIAS GRAFICAS', 1, 1, 1, '2023-07-05 23:01:26', '2023-07-05 23:01:26'),
(10, 'TALLERES', 2, 1, 1, '2023-07-05 23:01:39', '2023-07-05 23:46:43'),
(11, 'TALLERES', 1, 1, 1, '2023-07-05 23:02:03', '2023-07-05 23:02:03'),
(12, 'PARA NI�OS', 1, 1, 1, '2023-07-05 23:02:13', '2023-07-05 23:02:13'),
(13, 'IDIOMAS', 1, 1, 1, '2023-07-05 23:02:23', '2023-07-05 23:02:23'),
(14, 'PARA EVENTOS', 1, 1, 1, '2023-07-05 23:02:34', '2023-07-05 23:02:34'),
(15, 'T�CNICOS', 1, 1, 1, '2023-07-05 23:02:50', '2023-07-05 23:02:50'),
(16, 'OTROS', 1, 1, 1, '2023-07-05 23:02:57', '2023-07-05 23:02:57'),
(17, 'CORTE Y CONFECCI�N', 1, 1, 1, '2023-07-05 23:13:59', '2023-07-05 23:13:59');

--
-- �ndices para tablas volcadas
--

--
-- Indices de la tabla `tipo_cursos`
--
ALTER TABLE `tipo_cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_cursos_estado_id_foreign` (`estado_id`),
  ADD KEY `tipo_cursos_user_id_foreign` (`user_id`),
  ADD KEY `tipo_cursos_modif_user_id_foreign` (`modif_user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipo_cursos`
--
ALTER TABLE `tipo_cursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
