-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2017 a las 04:46:25
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `loencontre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` bigint(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `name`, `image`, `date`) VALUES
(48, 0, 'Francy Liliana Fuentes Parra', '35.jpg', '2017-03-14'),
(47, 0, 'Junior Fabian Ortega Lopez', '34.jpg', '2017-03-14'),
(46, 0, 'Danilo Armando Barrera Alarcon', '33.jpg', '2017-03-15'),
(45, 0, 'Mailith Dayana Barrera Torres', '32.jpg', '2017-03-15'),
(43, 0, 'Maria Paula Arias Avila', '30.jpg', '2017-03-16'),
(42, 0, 'Rosa Angelica Moyano Quintero', '29.jpg', '2017-03-16'),
(41, 0, 'Lenny Tatiana Usgame Fagua', '28.jpg', '2017-03-16'),
(40, 0, 'Tania Alejandra Gonzalez Muñoz', '27.jpg', '2017-03-17'),
(39, 0, 'Wilmer Alexander Martinez Hernandez', '26.jpg', '2017-03-17'),
(38, 0, 'Laura Natalia Cano Pinzon', '25.jpg', '2017-03-17'),
(37, 0, 'Yeison Fernando Gonzalez Bernal', '24.jpg', '2017-03-19'),
(36, 0, 'Diego Alejandro Ballesteros Enciso', '23.jpg', '2017-03-20'),
(35, 0, 'Diego Alejandro Esterling Menjura', '22.jpg', '2017-03-21'),
(34, 0, 'Adriana Alexandra Monroy Cañan', '21.jpg', '2017-03-21'),
(33, 0, 'Hector Javier Forero Santisteban', '20.jpg', '2017-03-22'),
(49, 0, 'Maria Paula Mendoza Franco', '36.jpg', '2017-03-13'),
(50, 0, 'Carolina Romero Sanchez', '37.jpg', '2017-03-12'),
(51, 0, 'Angie Natalia Gordillo Avila', '38.jpg', '2017-03-09'),
(52, 0, 'Nestor Javier Condia Chavez', '39.jpg', '2017-03-09'),
(53, 0, 'Monica Liliana Leguizamon Parada', '40.jpg', '2017-03-09'),
(54, 0, 'Angie Katerin Cepeda Mantilla', '41.jpg', '2017-03-09'),
(55, 0, 'Gisell Tatiana Sandoval Rangel', '42.jpg', '2017-03-07'),
(56, 0, 'Cristian Adolfo Acuña Martinez', '43.jpg', '2017-03-07'),
(57, 0, 'Ever FAbian Martinez contreras', '44.jpg', '2017-03-06'),
(58, 0, 'Maria Fernanda', '45.jpg', '2017-03-03'),
(59, 0, 'Yeison Estiven Suarez Paipilla', '46.jpg', '2017-03-03'),
(60, 0, 'Diego Leonardo Paez Montero', '47.jpg', '2017-03-02'),
(61, 0, 'Maria Alejandra Torres Suarez', '48.jpg', '2017-03-01'),
(62, 0, 'Lady Tatiana Fandiño medina', '49.jpg', '2017-02-28'),
(63, 0, ' ikcnoh\'gw carol daniela rodríguez pineda', '17554585_609479729245478_5546163889095581609_n.jpg', '2017-03-30'),
(64, 0, ' yefferson augusto suarez molina', '17757297_2091888064371344_8739752045878595607_n.jpg', '2017-04-04'),
(65, 0, ' juanita andrea rodriguez moya', '17637077_1401082929956522_8425725430198842333_o.jpg', '2017-04-04'),
(66, 0, ' angela patricia gil sosa', 'carnet2.jpg', '2017-04-04'),
(67, 0, ' alejandra goyeneche camargo', '17795844_10211298690759690_4800723043608778745_n.jpg', '2017-04-15'),
(69, 0, ' jose daniel muñoz rivera nieria', '17861885_1469654839757783_5574626680803301242_n.jpg', '2017-04-15'),
(70, 0, ' francisco javier barrera rodriguez', 'WhatsApp Image 2017-04-19 at 4.49.28 PM.jpeg', '2017-04-19'),
(71, 0, ' cristian fernando cho', 'j.jpg', '2017-04-19'),
(72, 0, ' sebastián cruz rooayo cgw:»•', '81785d8d-e681-4e2b-8386-272f81d75fc4.jpg', '2017-04-19'),
(73, 0, ' crtstian alexander roa garcia scxaes', 'd4cbc0db-14b6-4b37-b825-f0489ffad4ab.jpg', '2017-04-20'),
(74, 0, ' angela marcela fernández parra', 'care.jpg', '2017-04-20'),
(75, 0, ' angie jimena rodriguez', '18051769_1505422319467848_859035735_nJI.jpg', '2017-04-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`) VALUES
(10155313580034231, 'Andrés Mauricio Gómez', 'andresmauriciogomezr@gmail.com', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
