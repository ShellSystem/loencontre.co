-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2017 at 09:32 PM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `goodfirm_entregas`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `image`, `contact`, `date`) VALUES
(48, 'Francy Liliana Fuentes Parra', '35.jpg', 'no_contact   ', '2017-03-14'),
(47, 'Junior Fabian Ortega Lopez', '34.jpg', 'no_contact   ', '2017-03-14'),
(46, 'Danilo Armando Barrera Alarcon', '33.jpg', 'no_contact   ', '2017-03-15'),
(45, 'Mailith Dayana Barrera Torres', '32.jpg', 'no_contact   ', '2017-03-15'),
(43, 'Maria Paula Arias Avila', '30.jpg', 'no_contact   ', '2017-03-16'),
(42, 'Rosa Angelica Moyano Quintero', '29.jpg', 'no_contact   ', '2017-03-16'),
(41, 'Lenny Tatiana Usgame Fagua', '28.jpg', 'no_contact   ', '2017-03-16'),
(40, 'Tania Alejandra Gonzalez Muñoz', '27.jpg', 'no_contact   ', '2017-03-17'),
(39, 'Wilmer Alexander Martinez Hernandez', '26.jpg', 'no_contact   ', '2017-03-17'),
(38, 'Laura Natalia Cano Pinzon', '25.jpg', 'no_contact   ', '2017-03-17'),
(37, 'Yeison Fernando Gonzalez Bernal', '24.jpg', 'no_contact   ', '2017-03-19'),
(36, 'Diego Alejandro Ballesteros Enciso', '23.jpg', 'no_contact   ', '2017-03-20'),
(35, 'Diego Alejandro Esterling Menjura', '22.jpg', 'no_contact   ', '2017-03-21'),
(34, 'Adriana Alexandra Monroy Cañan', '21.jpg', 'no_contact   ', '2017-03-21'),
(33, 'Hector Javier Forero Santisteban', '20.jpg', 'no_contact   ', '2017-03-22'),
(49, 'Maria Paula Mendoza Franco', '36.jpg', 'no_contact   ', '2017-03-13'),
(50, 'Carolina Romero Sanchez', '37.jpg', 'no_contact   ', '2017-03-12'),
(51, 'Angie Natalia Gordillo Avila', '38.jpg', 'no_contact   ', '2017-03-09'),
(52, 'Nestor Javier Condia Chavez', '39.jpg', 'no_contact   ', '2017-03-09'),
(53, 'Monica Liliana Leguizamon Parada', '40.jpg', 'no_contact   ', '2017-03-09'),
(54, 'Angie Katerin Cepeda Mantilla', '41.jpg', 'no_contact   ', '2017-03-09'),
(55, 'Gisell Tatiana Sandoval Rangel', '42.jpg', 'no_contact   ', '2017-03-07'),
(56, 'Cristian Adolfo Acuña Martinez', '43.jpg', 'no_contact   ', '2017-03-07'),
(57, 'Ever FAbian Martinez contreras', '44.jpg', 'no_contact   ', '2017-03-06'),
(58, 'Maria Fernanda', '45.jpg', 'no_contact   ', '2017-03-03'),
(59, 'Yeison Estiven Suarez Paipilla', '46.jpg', 'no_contact   ', '2017-03-03'),
(60, 'Diego Leonardo Paez Montero', '47.jpg', 'no_contact   ', '2017-03-02'),
(61, 'Maria Alejandra Torres Suarez', '48.jpg', 'no_contact   ', '2017-03-01'),
(62, 'Lady Tatiana Fandiño medina', '49.jpg', 'no_contact   ', '2017-02-28'),
(63, ' ikcnoh''gw carol daniela rodríguez pineda', '17554585_609479729245478_5546163889095581609_n.jpg', 'sadfasd', '2017-03-30'),
(64, ' yefferson augusto suarez molina', '17757297_2091888064371344_8739752045878595607_n.jpg', '32048563256', '2017-04-04'),
(65, ' juanita andrea rodriguez moya', '17637077_1401082929956522_8425725430198842333_o.jpg', '3164966200', '2017-04-04'),
(66, ' angela patricia gil sosa', 'carnet2.jpg', '3105698753', '2017-04-04'),
(67, ' alejandra goyeneche camargo', '17795844_10211298690759690_4800723043608778745_n.jpg', 'https://www.facebook.com/photo.php?fbid=10211298690759690&set=g.5347104545&type=1&theater', '2017-04-15'),
(69, ' jose daniel muñoz rivera nieria', '17861885_1469654839757783_5574626680803301242_n.jpg', 'https://www.facebook.com/photo.php?fbid=1469654839757783&set=g.5347104545&type=1&theater', '2017-04-15'),
(70, ' francisco javier barrera rodriguez', 'WhatsApp Image 2017-04-19 at 4.49.28 PM.jpeg', 'Hola', '2017-04-19'),
(71, ' cristian fernando cho', 'j.jpg', 'fgfgh ', '2017-04-19'),
(72, ' sebastián cruz rooayo cgw:»•', '81785d8d-e681-4e2b-8386-272f81d75fc4.jpg', '3134532202', '2017-04-19'),
(73, ' crtstian alexander roa garcia scxaes', 'd4cbc0db-14b6-4b37-b825-f0489ffad4ab.jpg', '3150265478', '2017-04-20'),
(74, ' angela marcela fernández parra', 'care.jpg', 'contacto----', '2017-04-20'),
(75, ' angie jimena rodriguez', '18051769_1505422319467848_859035735_nJI.jpg', '3102110112', '2017-04-20');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
