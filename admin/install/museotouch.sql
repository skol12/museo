-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2013 at 09:25 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `museotouch`
--
CREATE DATABASE IF NOT EXISTS `museotouch` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `museotouch`;

-- --------------------------------------------------------

--
-- Table structure for table `expositions`
--

CREATE TABLE IF NOT EXISTS `expositions` (
  `expositions_id` int(11) NOT NULL AUTO_INCREMENT,
  `expositions_musee` enum('Lyon','Nantes','','') NOT NULL,
  `expositions_photo` varchar(100) DEFAULT NULL,
  `expositions_nom_fr` varchar(50) NOT NULL,
  `expositions_nom_en` varchar(50) NOT NULL,
  `expositions_description_fr` varchar(500) NOT NULL,
  `expositions_description_en` varchar(500) NOT NULL,
  `expositions_valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'valide = 1',
  PRIMARY KEY (`expositions_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `expositions`
--

INSERT INTO `expositions` (`expositions_id`, `expositions_musee`, `expositions_photo`, `expositions_nom_fr`, `expositions_nom_en`, `expositions_description_fr`, `expositions_description_en`, `expositions_valid`) VALUES
(1, 'Nantes', '51e5b95fa9c7f.png', 'La tribu indienne', 'Indian horde', ' pure-u-1 l-centeredpure-u-1 l-centered pure-u-1 l-centered  pure-u-1 l-centered pure-u-1 l-centered pure-u-1 l-centeredpure-u-1 l-centeredpure-u-1 l-centered q', ' pure-u-1 l-centeredpure-u-1 l-centered pure-u-1 l-centered  pure-u-1 l-centered pure-u-1 l-centered pure-u-1 l-centeredpure-u-1 l-centeredpure-u-1 l-centered q', 1),
(2, 'Lyon', NULL, 'Navires de France', 'France Boats', 'Exposition française sur les navires', 'French exposition on boats', 1),
(3, 'Nantes', '', 'expo test 1', 'expo test one', 'test pour l''expo numero 1', 'test for the first expo', 1),
(4, 'Lyon', NULL, 'expo test 12345', 'text expo 1', 'Description Française', 'Description Anglaise', 1),
(5, 'Lyon', NULL, 'Nom Français', 'Nom Anglais', 'Description Française', 'Description Anglaise', 1),
(6, 'Lyon', '51e5a7ede2fc4', 'Nom Français', 'Nom Anglais', 'Description Française', 'Description Anglaisesdq', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expositions_objets`
--

CREATE TABLE IF NOT EXISTS `expositions_objets` (
  `expositions_id` int(11) NOT NULL,
  `objets_id` int(11) NOT NULL,
  PRIMARY KEY (`expositions_id`,`objets_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `expositions_objets`
--

INSERT INTO `expositions_objets` (`expositions_id`, `objets_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `objets`
--

CREATE TABLE IF NOT EXISTS `objets` (
  `objets_id` int(11) NOT NULL AUTO_INCREMENT,
  `objets_photo` varchar(150) DEFAULT NULL,
  `objets_nom_fr` varchar(50) NOT NULL,
  `objets_nom_en` varchar(50) NOT NULL,
  `objets_description_fr` text,
  `objets_description_en` text,
  `objets_valid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`objets_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `objets`
--

INSERT INTO `objets` (`objets_id`, `objets_photo`, `objets_nom_fr`, `objets_nom_en`, `objets_description_fr`, `objets_description_en`, `objets_valid`) VALUES
(1, '51e5b94544d34.png', 'Nom Français', 'Nom Anglaise', 'Description Françaiseqfs', 'Description Anglaise', 1),
(2, NULL, 'qd', 'e', 'qdg', 'qgd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `paniers`
--

CREATE TABLE IF NOT EXISTS `paniers` (
  `paniers_id` int(11) NOT NULL AUTO_INCREMENT,
  `paniers_token` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `paniers_date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `paniers_date_expiration` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `paniers_url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paniers_private` tinyint(1) NOT NULL DEFAULT '0',
  `paniers_password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`paniers_id`),
  KEY `baskets_url` (`paniers_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `paniers_objets`
--

CREATE TABLE IF NOT EXISTS `paniers_objets` (
  `paniers_id` int(11) NOT NULL,
  `objets_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '2 admin, 1 admin expo',
  `users_login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `users_password` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Cryptage SHA1',
  `users_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `users_prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `users_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date creation',
  `users_valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = valide',
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `user_login` (`users_login`),
  UNIQUE KEY `user_mail` (`users_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=204 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_admin`, `users_login`, `users_password`, `users_mail`, `users_nom`, `users_prenom`, `users_date`, `users_valid`) VALUES
(1, 0, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '', NULL, NULL, '2013-06-13 02:36:33', 1),
(103, 0, 'Nobles', '', 'at.iaculis.quis@non.co.uk', NULL, NULL, '2013-06-20 18:53:24', 1),
(104, 0, 'Walsh', '', 'eleifend.vitae.erat@diam.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(105, 0, 'Patterson', '', 'Donec.felis.orci@Sedidrisus.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(106, 0, 'Strong', '', 'Suspendisse.aliquet@ultrices.com', NULL, NULL, '2013-06-13 23:51:45', 1),
(108, 0, 'Mckee', '', 'lobortis.ultrices@eros.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(109, 0, 'Colon', '', 'ultrices.sit@parturientmontes.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(110, 0, 'Glover', '', 'laoreet.libero@CraspellentesqueSed.edu', NULL, NULL, '2013-06-13 23:51:45', 1),
(111, 0, 'Conley', '', 'magna.Suspendisse.tristique@dolorQuisque.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(112, 0, 'Melton', '', 'vulputate@rhoncusid.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(113, 0, 'Frazier', '', 'massa.Mauris.vestibulum@nec.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(114, 0, 'Ryan', '', 'et@Curae;.com', NULL, NULL, '2013-06-13 23:51:45', 1),
(115, 0, 'Cohen', '', 'elit@erosProinultrices.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(119, 0, 'Kerr', '', 'erat.neque.non@sollicitudin.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(120, 0, 'Coleman', '', 'venenatis@augueidante.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(121, 0, 'Huber', '', 'mauris@cursus.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(122, 0, 'Sheppard', '', 'elementum.purus.accumsan@purussapien.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(123, 0, 'Mcgee', '', 'orci@cursus.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(124, 0, 'Weeks', '', 'interdum@Naminterdumenim.edu', NULL, NULL, '2013-06-13 23:51:45', 1),
(125, 0, 'Hale', '', 'non@semper.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(126, 0, 'Macdonald', '', 'mus.Donec@tincidunt.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(128, 0, 'Pace', '', 'dictum.ultricies.ligula@dolor.edu', NULL, NULL, '2013-06-13 23:51:45', 1),
(129, 0, 'Mack', '', 'ut.molestie.in@scelerisquedui.com', NULL, NULL, '2013-06-13 23:51:45', 1),
(130, 0, 'Ramirez', '', 'Duis@aliquet.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(131, 0, 'Lowe', '', 'Donec.nibh.Quisque@metus.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(132, 0, 'Roberson', '', 'odio.Phasellus.at@habitant.com', NULL, NULL, '2013-06-13 23:51:45', 1),
(133, 0, 'Nash', '', 'Lorem.ipsum.dolor@fringilla.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(134, 0, 'Gaines', '', 'Quisque.ornare@nonlorem.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(135, 0, 'Savage', '', 'fermentum.convallis.ligula@Maecenasmi.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(136, 0, 'Woodward', '', 'diam.at@orci.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(137, 0, 'Rosario', '', 'augue.ut@ultricesVivamusrhoncus.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(138, 0, 'Dudley', '', 'suscipit.nonummy@turpis.edu', NULL, NULL, '2013-06-13 23:51:45', 1),
(139, 0, 'Cruz', '', 'sociis.natoque.penatibus@lacus.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(140, 0, 'Rocha', '', 'ridiculus@justosit.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(141, 0, 'Jenkins', '', 'dapibus.quam@vel.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(142, 0, 'Lloyd', '', 'dictum.placerat@velarcuCurabitur.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(143, 0, 'Hayes', '', 'Quisque.porttitor.eros@anteMaecenas.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(145, 0, 'Conway', '', 'ultricies@massanonante.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(146, 0, 'Hoffman', '', 'sed@Phasellusat.com', NULL, NULL, '2013-06-13 23:51:45', 1),
(147, 0, 'Duncan', '', 'eu.neque.pellentesque@tristiqueneque.edu', NULL, NULL, '2013-06-13 23:51:45', 1),
(148, 0, 'Hull', '', 'egestas@sociisnatoquepenatibus.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(149, 0, 'Mendez', '', 'consequat.lectus@Integervulputate.com', NULL, NULL, '2013-06-13 23:51:45', 1),
(150, 0, 'Jefferson', 'qdfgqfgd', 'et@acmattisornare.co.uk', 'gdqs', 'qdg', '2013-06-13 23:51:45', 1),
(151, 0, 'Roach', '', 'mattis.velit@erat.edu', NULL, NULL, '2013-06-13 23:51:45', 1),
(152, 0, 'Lynch', '', 'mi@Donec.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(153, 0, 'Guzman', '', 'molestie@ultrices.com', NULL, NULL, '2013-06-13 23:51:45', 1),
(154, 0, 'Watts', '', 'tempus.lorem@Etiamlaoreetlibero.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(158, 0, 'Holcomb', '', 'nisi.Cum@luctusCurabituregestas.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(159, 0, 'Chavez', '', 'adipiscing.elit@velitPellentesqueultricies.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(160, 0, 'Haley', '', 'lorem.Donec@pedemalesuadavel.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(162, 0, 'Collier', '', 'Nunc.ullamcorper.velit@neque.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(163, 0, 'Jones', '', 'dolor@PhasellusornareFusce.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(164, 0, 'Gill', '', 'magna.a@ornare.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(165, 0, 'Page', '', 'dui.in@justoProin.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(166, 0, 'Hubbard', '', 'Suspendisse@facilisis.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(167, 0, 'Combs', '', 'elit.Etiam.laoreet@semPellentesqueut.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(168, 0, 'Martinez', '', 'sem@ametornare.edu', NULL, NULL, '2013-06-13 23:51:45', 1),
(169, 0, 'Chen', 'password', 'Sed.nulla@id.net', NULL, NULL, '2013-07-03 18:29:03', 1),
(170, 0, 'Newman', '', 'Quisque.varius@purusaccumsan.co.uk', NULL, NULL, '2013-06-13 23:51:45', 1),
(171, 0, 'Stewart', '', 'elementum.sem@natoque.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(172, 0, 'Vaughan', '', 'Sed.nulla.ante@Nullamvitaediam.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(174, 0, 'Hampton', '', 'magna@nasceturridiculusmus.org', NULL, NULL, '2013-06-13 23:51:45', 1),
(175, 0, 'Owens', '', 'sem.Pellentesque.ut@Cras.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(177, 0, 'Wise', '', 'at@Morbineque.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(178, 0, 'Stout', '', 'et@idmagna.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(180, 0, 'House', '', 'in.faucibus@iaculis.net', NULL, NULL, '2013-06-13 23:51:45', 1),
(182, 0, 'Finch', '', 'augue.eu.tellus@non.ca', NULL, NULL, '2013-06-13 23:51:45', 1),
(183, 0, 'Newton', '', 'ut@cursuset.org', NULL, NULL, '2013-06-13 23:51:46', 1),
(184, 0, 'Guthrie', '', 'elit.pellentesque@eu.com', NULL, NULL, '2013-06-13 23:51:46', 1),
(185, 0, 'Kline', '', 'lacus.pede.sagittis@eunullaat.org', NULL, NULL, '2013-06-13 23:51:46', 1),
(186, 0, 'Herrera', '', 'vitae@Praesentinterdum.edu', NULL, NULL, '2013-06-13 23:51:46', 1),
(187, 0, 'Rivas', '', 'et.malesuada.fames@Duisrisus.ca', NULL, NULL, '2013-06-13 23:51:46', 1),
(188, 0, 'Zimmerman', '', 'pede.sagittis@ipsumPhasellusvitae.net', NULL, NULL, '2013-06-13 23:51:46', 1),
(189, 0, 'Hawkins', '', 'et.malesuada@utaliquamiaculis.ca', NULL, NULL, '2013-06-13 23:51:46', 1),
(191, 0, 'Hicks', '', 'mi.eleifend@nuncQuisque.org', NULL, NULL, '2013-06-13 23:51:46', 1),
(192, 0, 'Reeves', '', 'tincidunt.adipiscing.Mauris@Naminterdumenim.com', NULL, NULL, '2013-06-13 23:51:46', 1),
(193, 0, 'Giles', '', 'commodo@adipiscing.edu', NULL, NULL, '2013-06-13 23:51:46', 1),
(194, 0, 'Suarez', '', 'Suspendisse.tristique@suscipitnonummyFusce.org', NULL, NULL, '2013-06-13 23:51:46', 1),
(195, 0, 'Jacobs', '', 'elementum@perconubianostra.co.uk', NULL, NULL, '2013-06-13 23:51:46', 1),
(196, 0, 'Hutchinson', '', 'sem.eget.massa@sit.com', NULL, NULL, '2013-06-13 23:51:46', 1),
(198, 0, 'Dillard', '', 'elit@augue.com', NULL, NULL, '2013-06-13 23:51:46', 1),
(199, 0, 'Davenport', '', 'Praesent@cubiliaCurae;Phasellus.net', NULL, NULL, '2013-06-13 23:51:46', 1),
(200, 0, 'Guerra', '', 'diam.dictum.sapien@cursus.org', NULL, NULL, '2013-06-13 23:51:46', 1),
(202, 0, 'Small', '', 'adipiscing@imperdietullamcorperDuis.com', NULL, NULL, '2013-06-13 23:51:46', 1),
(203, 0, 'Herve', 'password', 'herve@gmail.com', 'Dupont', 'Herve', '0000-00-00 00:00:00', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
