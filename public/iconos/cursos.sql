-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generaci�n: 06-07-2023 a las 10:08:15
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
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(191) NOT NULL,
  `estado_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_curso_id` bigint(20) UNSIGNED NOT NULL,
  `curso_modulo_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `modif_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `descripcion`, `estado_id`, `tipo_curso_id`, `curso_modulo_id`, `user_id`, `modif_user_id`, `created_at`, `updated_at`) VALUES
(1, 'BOCADITOS DULCES Y SALADOS', 1, 1, 2, 1, 1, '2023-06-29 01:40:30', '2023-06-29 01:40:30'),
(2, 'TORTAS Y PASTELES', 1, 1, 2, 1, 1, '2023-07-03 20:40:10', '2023-07-05 23:08:49'),
(3, 'U�AS ESCULPIDAS', 1, 3, 2, 3, 3, '2023-07-05 14:22:12', '2023-07-05 14:22:12'),
(4, 'BOCADITOS DULCES Y SALADOS', 1, 1, 3, 1, 1, '2023-07-05 23:10:13', '2023-07-05 23:10:24'),
(5, 'BOCADITOS DULCES Y SALADOS', 1, 1, 4, 1, 1, '2023-07-05 23:10:55', '2023-07-05 23:10:55'),
(6, 'TORTAS Y PASTELES', 1, 1, 3, 1, 1, '2023-07-05 23:11:46', '2023-07-05 23:11:46'),
(7, 'CONFITER�A', 1, 1, 2, 1, 1, '2023-07-05 23:12:33', '2023-07-05 23:12:33'),
(8, 'CONFITER�A', 1, 1, 3, 1, 1, '2023-07-05 23:12:44', '2023-07-05 23:12:44'),
(9, 'COMIDAS NAVIDE�AS', 1, 1, 2, 1, 1, '2023-07-05 23:13:07', '2023-07-05 23:13:07'),
(10, 'PANADERIA', 1, 1, 2, 1, 1, '2023-07-05 23:13:17', '2023-07-05 23:13:17'),
(11, 'CORTE Y CONFECCI�N', 1, 17, 2, 1, 1, '2023-07-05 23:14:33', '2023-07-05 23:14:33'),
(12, 'CORTE Y CONFECCI�N', 1, 17, 3, 1, 1, '2023-07-05 23:14:47', '2023-07-05 23:15:12'),
(13, 'CORTE Y CONFECCI�N', 1, 17, 4, 1, 1, '2023-07-05 23:15:34', '2023-07-05 23:15:34'),
(14, 'CORTE Y CONFECCI�N', 1, 17, 6, 1, 1, '2023-07-05 23:15:46', '2023-07-05 23:15:46'),
(15, 'MAQUILLAJE', 1, 3, 2, 1, 1, '2023-07-05 23:16:27', '2023-07-05 23:16:27'),
(16, 'MAQUILLAJE', 1, 3, 3, 1, 1, '2023-07-05 23:16:40', '2023-07-05 23:16:40'),
(17, 'AUTOMAQUILLAJE', 1, 3, 2, 1, 1, '2023-07-05 23:17:08', '2023-07-05 23:17:08'),
(18, 'TODO PESTA�AS', 1, 3, 2, 1, 1, '2023-07-05 23:17:34', '2023-07-05 23:17:34'),
(19, 'CEJAS PERFECTAS', 1, 3, 2, 1, 1, '2023-07-05 23:17:53', '2023-07-05 23:17:53'),
(20, 'PELUQUERIA DAMAS', 1, 3, 2, 1, 1, '2023-07-05 23:18:23', '2023-07-05 23:18:23'),
(21, 'PELUQUERIA DAMAS', 1, 3, 3, 1, 1, '2023-07-05 23:18:45', '2023-07-05 23:18:45'),
(22, 'PELUQUERIA DAMAS', 1, 3, 4, 1, 1, '2023-07-05 23:18:58', '2023-07-05 23:18:58'),
(23, 'PELUQUERIA Y BARBER�A', 1, 3, 2, 1, 1, '2023-07-05 23:19:34', '2023-07-05 23:20:16'),
(24, 'PELUQUERIA Y BARBER�A', 1, 3, 3, 1, 1, '2023-07-05 23:19:49', '2023-07-05 23:19:49'),
(25, 'PELUQUERIA Y BARBER�A', 1, 3, 4, 1, 1, '2023-07-05 23:20:04', '2023-07-05 23:20:04'),
(26, 'PELUQUERIA DAMAS AVANZADO', 1, 3, 2, 1, 1, '2023-07-05 23:21:06', '2023-07-05 23:21:06'),
(27, 'PELUQUERIA DAMAS AVANZADO', 1, 3, 3, 1, 1, '2023-07-05 23:21:21', '2023-07-05 23:22:36'),
(28, 'PELUQUERIA Y BARBER�A AVANZADO', 1, 3, 2, 1, 1, '2023-07-05 23:22:05', '2023-07-05 23:22:05'),
(29, 'PELUQUERIA Y BARBER�A AVANZADO', 1, 3, 3, 1, 1, '2023-07-05 23:22:22', '2023-07-05 23:22:22'),
(30, 'MANICURA Y PEDICURA', 1, 3, 2, 1, 1, '2023-07-05 23:23:07', '2023-07-05 23:23:07'),
(31, 'U�AS ESCULPIDAS', 1, 3, 2, 1, 1, '2023-07-05 23:23:24', '2023-07-05 23:23:24'),
(32, 'U�AS ACRILICAS', 1, 3, 2, 1, 1, '2023-07-05 23:23:49', '2023-07-05 23:23:49'),
(33, 'U�AS ACRILICAS', 1, 3, 3, 1, 1, '2023-07-05 23:24:01', '2023-07-05 23:24:01'),
(34, 'TRENZAS AFRO', 1, 3, 2, 1, 1, '2023-07-05 23:24:21', '2023-07-05 23:24:21'),
(35, 'OPERADOR B�SICO', 1, 4, 2, 1, 1, '2023-07-05 23:25:13', '2023-07-05 23:25:13'),
(36, 'OPERADOR AVANZADO', 1, 4, 2, 1, 1, '2023-07-05 23:25:30', '2023-07-05 23:25:30'),
(37, 'CAJERO PROFESIONAL', 1, 4, 2, 1, 1, '2023-07-05 23:25:49', '2023-07-05 23:25:49'),
(38, 'CAJERO PROFESIONAL', 1, 4, 3, 1, 1, '2023-07-05 23:26:01', '2023-07-05 23:26:01'),
(39, 'SECRETARIADO EJECUTIVO', 1, 4, 2, 1, 1, '2023-07-05 23:26:29', '2023-07-05 23:26:29'),
(40, 'SECRETARIADO EJECUTIVO', 1, 4, 3, 1, 1, '2023-07-05 23:26:40', '2023-07-05 23:26:40'),
(41, 'AUXILIAR CONTABLE', 1, 4, 2, 1, 1, '2023-07-05 23:27:07', '2023-07-05 23:27:07'),
(42, 'AUXILIAR CONTABLE', 1, 4, 3, 1, 1, '2023-07-05 23:27:20', '2023-07-05 23:27:20'),
(43, 'AUXILIAR CONTABLE', 1, 4, 4, 1, 1, '2023-07-05 23:27:35', '2023-07-05 23:27:35'),
(44, 'ELABORACI�N DE MO�OS', 1, 5, 2, 1, 1, '2023-07-05 23:28:22', '2023-07-05 23:28:22'),
(45, 'ELABORACI�N DE MO�OS', 1, 5, 3, 1, 1, '2023-07-05 23:28:39', '2023-07-05 23:28:39'),
(46, 'ZAPATILLAS BORDADAS', 1, 5, 2, 1, 1, '2023-07-05 23:28:57', '2023-07-05 23:28:57'),
(47, 'ZAPATILLAS BORDADAS', 1, 5, 3, 1, 1, '2023-07-05 23:29:09', '2023-07-05 23:29:09'),
(48, 'ARTE Y RECICLADO', 1, 5, 2, 1, 1, '2023-07-05 23:29:30', '2023-07-05 23:29:30'),
(49, 'TERMO FORRADO', 1, 3, 2, 1, 1, '2023-07-05 23:29:52', '2023-07-05 23:29:52'),
(50, 'TERMO FORRADO', 1, 5, 3, 1, 1, '2023-07-05 23:30:07', '2023-07-05 23:30:07'),
(51, 'PINTURA SOBRE TELA', 1, 5, 2, 1, 1, '2023-07-05 23:30:45', '2023-07-05 23:30:45'),
(52, 'PINTURA SOBRE TELA', 1, 5, 3, 1, 1, '2023-07-05 23:30:56', '2023-07-05 23:30:56'),
(53, 'PINTURA SOBRE TELA', 1, 5, 4, 1, 1, '2023-07-05 23:31:08', '2023-07-05 23:31:08'),
(54, 'CURSO DE DIBUJO ANIME', 1, 5, 2, 1, 1, '2023-07-05 23:31:41', '2023-07-05 23:31:41'),
(55, 'CURSO DE DIBUJO ANIME', 1, 5, 3, 1, 1, '2023-07-05 23:31:54', '2023-07-05 23:31:54'),
(56, 'LETTERING', 1, 5, 2, 1, 1, '2023-07-05 23:32:10', '2023-07-05 23:32:10'),
(57, 'CURSO DE BIJOUTERIE Y BOMBILLAS DECORADAS', 1, 5, 2, 1, 1, '2023-07-05 23:33:05', '2023-07-05 23:33:05'),
(58, 'RESINA', 1, 5, 2, 1, 1, '2023-07-05 23:33:18', '2023-07-05 23:33:18'),
(59, 'TRAPILLO Y MACRAM�', 1, 5, 2, 1, 1, '2023-07-05 23:33:39', '2023-07-05 23:33:39'),
(60, 'INSTALACI�N DE CIRCUITO CERRADO', 1, 6, 2, 1, 1, '2023-07-05 23:34:36', '2023-07-05 23:34:36'),
(61, 'T�CNICO DE CELULAR', 1, 6, 2, 1, 1, '2023-07-05 23:35:02', '2023-07-05 23:35:02'),
(62, 'T�CNICO DE CELULAR', 1, 6, 3, 1, 1, '2023-07-05 23:35:25', '2023-07-05 23:35:25'),
(63, 'T�CNICO DE CELULAR', 1, 6, 4, 1, 1, '2023-07-05 23:35:38', '2023-07-05 23:35:38'),
(64, 'ELECTRICIDAD DOMICILIARIA', 1, 6, 2, 1, 1, '2023-07-05 23:35:59', '2023-07-05 23:35:59'),
(65, 'ELECTRICIDAD DOMICILIARIA', 1, 6, 3, 1, 1, '2023-07-05 23:36:12', '2023-07-05 23:36:12'),
(66, 'ELECTRICIDAD DOMICILIARIA', 1, 6, 4, 1, 1, '2023-07-05 23:36:23', '2023-07-05 23:36:23'),
(67, 'INSTALACI�N DE C�MARAS CCTV', 1, 6, 2, 1, 1, '2023-07-05 23:36:58', '2023-07-05 23:36:58'),
(68, '�ANDUTI', 1, 7, 2, 1, 1, '2023-07-05 23:37:30', '2023-07-05 23:37:30'),
(69, '�ANDUTI', 1, 7, 3, 1, 1, '2023-07-05 23:37:41', '2023-07-05 23:37:41'),
(70, 'ENCAJE JU', 1, 7, 2, 1, 1, '2023-07-05 23:38:02', '2023-07-05 23:38:02'),
(71, 'ENCAJE JU', 1, 7, 3, 1, 1, '2023-07-05 23:38:25', '2023-07-05 23:38:25'),
(72, 'AMIGURUMIS', 1, 7, 2, 1, 1, '2023-07-05 23:38:55', '2023-07-05 23:38:55'),
(73, 'AMIGURUMIS', 1, 7, 3, 1, 1, '2023-07-05 23:39:07', '2023-07-05 23:39:07'),
(74, 'CROCHET', 1, 7, 2, 1, 1, '2023-07-05 23:39:28', '2023-07-05 23:39:28'),
(75, 'CROCHET', 1, 7, 3, 1, 1, '2023-07-05 23:39:41', '2023-07-05 23:39:41'),
(76, 'MEC�NICA DE MOTOS', 1, 8, 2, 1, 1, '2023-07-05 23:42:11', '2023-07-05 23:42:11'),
(77, 'MEC�NICA DE MOTOS', 1, 8, 3, 1, 1, '2023-07-05 23:42:25', '2023-07-05 23:42:25'),
(78, 'ELECTRICIDAD DEL AUTOMOVIL', 1, 8, 2, 1, 1, '2023-07-05 23:43:06', '2023-07-05 23:43:06'),
(79, 'ELECTRICIDAD DEL AUTOMOVIL', 1, 8, 3, 1, 1, '2023-07-05 23:43:27', '2023-07-05 23:43:27'),
(80, 'REFRIGERACI�N DEL AUTOMOVIL', 1, 8, 2, 1, 1, '2023-07-05 23:43:59', '2023-07-05 23:43:59'),
(81, 'REFRIGERACI�N DEL AUTOMOVIL', 1, 8, 3, 1, 1, '2023-07-05 23:44:11', '2023-07-05 23:44:11'),
(82, 'PULIDA DE FARO Y AUTOMOVIL', 1, 8, 2, 1, 1, '2023-07-05 23:44:35', '2023-07-05 23:44:35'),
(83, 'CHAPERIA Y PINTURA', 1, 8, 2, 1, 1, '2023-07-05 23:44:59', '2023-07-05 23:44:59'),
(84, 'SERIGRAF�A', 1, 9, 2, 1, 1, '2023-07-05 23:45:17', '2023-07-05 23:45:17'),
(85, 'SERIGRAF�A', 1, 9, 3, 1, 1, '2023-07-05 23:45:29', '2023-07-05 23:45:29'),
(86, 'LOMITOS Y HAMBURGUESAS', 1, 11, 2, 1, 1, '2023-07-05 23:47:46', '2023-07-05 23:47:46'),
(87, 'EMPANADAS CASERAS Y FRITAS', 1, 11, 2, 1, 1, '2023-07-05 23:48:57', '2023-07-05 23:48:57'),
(88, 'ELABORACI�N DE PASTAS', 1, 11, 2, 1, 1, '2023-07-05 23:49:18', '2023-07-05 23:49:18'),
(89, 'POSTRES EN VASO', 1, 11, 2, 1, 1, '2023-07-05 23:49:47', '2023-07-05 23:49:47'),
(90, 'DECORACI�N DE TORTAS', 1, 11, 2, 1, 1, '2023-07-05 23:50:18', '2023-07-05 23:50:18'),
(91, 'ELABORACI�N DE PRODUCTOS DE LIMPIEZA', 1, 11, 2, 1, 1, '2023-07-05 23:50:46', '2023-07-05 23:50:46'),
(92, 'COMIDA SALUDABLE', 1, 11, 2, 1, 1, '2023-07-05 23:51:05', '2023-07-05 23:51:05'),
(93, 'PERSONAJES BIBLICOS', 1, 12, 2, 1, 1, '2023-07-05 23:52:31', '2023-07-05 23:52:31'),
(94, 'OPERADOR B�SICO', 1, 12, 2, 1, 1, '2023-07-05 23:52:51', '2023-07-05 23:52:51'),
(95, 'OPERADOR AVANZADO', 1, 12, 2, 1, 1, '2023-07-05 23:53:10', '2023-07-05 23:53:10'),
(96, 'COCINERITOS', 1, 12, 2, 1, 1, '2023-07-05 23:53:29', '2023-07-05 23:53:29'),
(97, 'PINTURA SOBRE TELA', 1, 12, 2, 1, 1, '2023-07-05 23:53:48', '2023-07-05 23:53:48'),
(98, 'PINTURA SOBRE TELA', 1, 12, 3, 1, 1, '2023-07-05 23:54:05', '2023-07-05 23:54:05'),
(99, 'PINTURA SOBRE TELA', 1, 12, 4, 1, 1, '2023-07-05 23:54:18', '2023-07-05 23:54:18'),
(100, 'INGL�S', 1, 13, 2, 1, 1, '2023-07-06 01:17:28', '2023-07-06 01:17:28'),
(101, 'INGL�S', 1, 13, 3, 1, 1, '2023-07-06 01:17:44', '2023-07-06 01:17:44'),
(102, 'INGL�S', 1, 13, 4, 1, 1, '2023-07-06 01:17:56', '2023-07-06 01:17:56'),
(103, 'INGL�S', 1, 13, 6, 1, 1, '2023-07-06 01:18:13', '2023-07-06 01:18:13'),
(104, 'PORTUGU�S', 1, 13, 2, 1, 1, '2023-07-06 01:18:40', '2023-07-06 01:18:40'),
(105, 'PORTUGU�S', 1, 13, 3, 1, 1, '2023-07-06 01:18:59', '2023-07-06 01:18:59'),
(106, 'PORTUGU�S', 1, 13, 4, 1, 1, '2023-07-06 01:19:22', '2023-07-06 01:19:22'),
(107, 'PORTUGU�S', 1, 13, 6, 1, 1, '2023-07-06 01:19:43', '2023-07-06 01:19:43'),
(108, 'GLOBOLOG�A', 1, 14, 2, 1, 1, '2023-07-06 01:20:29', '2023-07-06 01:20:29'),
(109, 'GLOBOLOG�A', 1, 14, 3, 1, 1, '2023-07-06 01:20:45', '2023-07-06 01:20:45'),
(110, 'DECORACI�N EN TELA', 1, 14, 2, 1, 1, '2023-07-06 01:21:38', '2023-07-06 01:21:38'),
(111, 'DECORACI�N EN TELA', 1, 14, 3, 1, 1, '2023-07-06 01:21:56', '2023-07-06 01:21:56'),
(112, 'T�CNICO EN FREZZER Y VISICOOLER', 1, 15, 2, 1, 1, '2023-07-06 01:22:39', '2023-07-06 01:22:39'),
(113, 'T�CNICO EN FREZZER Y VISICOOLER', 1, 15, 3, 1, 1, '2023-07-06 01:23:12', '2023-07-06 01:23:12'),
(114, 'T�CNICO DE LAVARROPAS, SECARROPAS Y CENTRIFUGADORA', 1, 15, 2, 1, 1, '2023-07-06 01:23:52', '2023-07-06 01:23:52'),
(115, 'T�CNICO DE LAVARROPAS, SECARROPAS Y CENTRIFUGADORA', 1, 15, 3, 1, 1, '2023-07-06 01:24:08', '2023-07-06 01:24:08'),
(116, 'T�CNICO DE REFRIGERACI�N, AIRE SPLIT', 1, 15, 2, 1, 1, '2023-07-06 01:24:40', '2023-07-06 01:24:40'),
(117, 'T�CNICO DE REFRIGERACI�N, AIRE SPLIT', 1, 15, 3, 1, 1, '2023-07-06 01:24:57', '2023-07-06 01:24:57'),
(118, 'T�CNICO DE TV, EQUIPO DE SONIDO', 1, 15, 2, 1, 1, '2023-07-06 01:25:23', '2023-07-06 01:25:23'),
(119, 'T�CNICO DE TV, EQUIPO DE SONIDO', 1, 15, 3, 1, 1, '2023-07-06 01:25:36', '2023-07-06 01:25:36'),
(120, 'T�CNICO DE LICUADORA, HORNO, MIXTERA, MICROONDAS', 1, 15, 2, 1, 1, '2023-07-06 01:26:21', '2023-07-06 01:26:21'),
(121, 'T�CNICO DE LICUADORA, HORNO, MIXTERA, MICROONDAS', 1, 15, 3, 1, 1, '2023-07-06 01:26:45', '2023-07-06 01:26:45'),
(122, 'PALETS', 1, 16, 2, 1, 1, '2023-07-06 01:27:03', '2023-07-06 01:27:03'),
(123, 'PALETS', 1, 16, 3, 1, 1, '2023-07-06 01:31:17', '2023-07-06 01:31:17'),
(124, 'BARMAN', 1, 16, 2, 1, 1, '2023-07-06 01:31:35', '2023-07-06 01:31:35'),
(125, 'BARMAN', 1, 16, 3, 1, 1, '2023-07-06 01:31:51', '2023-07-06 01:31:51'),
(126, 'KARANDA\'Y', 1, 16, 2, 1, 1, '2023-07-06 01:32:19', '2023-07-06 01:32:19');

--
-- �ndices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cursos_estado_id_foreign` (`estado_id`),
  ADD KEY `cursos_tipo_curso_id_foreign` (`tipo_curso_id`),
  ADD KEY `cursos_curso_modulo_id_foreign` (`curso_modulo_id`),
  ADD KEY `cursos_user_id_foreign` (`user_id`),
  ADD KEY `cursos_modif_user_id_foreign` (`modif_user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
