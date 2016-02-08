-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 08 Février 2016 à 10:51
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `testsba`
--

-- --------------------------------------------------------

--
-- Structure de la table `competition`
--

CREATE TABLE IF NOT EXISTS `competition` (
  `ID` int(11) NOT NULL COMMENT 'ID de la compétition',
  `NOM` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nom de la compétition',
  `DATE_DEBUT` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `competition`
--

INSERT INTO `competition` (`ID`, `NOM`, `DATE_DEBUT`) VALUES
(1, 'Champions League', '2016-02-16'),
(2, 'Eng. Premier League', '2016-02-29');

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE IF NOT EXISTS `matchs` (
  `ID` int(11) NOT NULL,
  `DATE_MATCH` datetime NOT NULL,
  `GROUPE_PHASE` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ID_EQUIPE_1` int(11) DEFAULT NULL,
  `SCORE_EQUIPE_1` int(11) DEFAULT NULL,
  `SCORE_EQUIPE_2` int(11) DEFAULT NULL,
  `ID_EQUIPE_2` int(11) DEFAULT NULL,
  `ID_GAGNANT` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `matchs`
--

INSERT INTO `matchs` (`ID`, `DATE_MATCH`, `GROUPE_PHASE`, `ID_EQUIPE_1`, `SCORE_EQUIPE_1`, `SCORE_EQUIPE_2`, `ID_EQUIPE_2`, `ID_GAGNANT`) VALUES
(1, '2016-06-12 22:00:00', 'Groupe A', 1, NULL, NULL, 13, 0),
(2, '2016-06-13 18:00:00', 'Groupe A', 32, NULL, NULL, 22, 0),
(3, '2016-06-17 21:00:00', 'Groupe A', 1, NULL, NULL, 32, 0),
(4, '2016-06-18 21:00:00', 'Groupe A', 22, NULL, NULL, 13, 0),
(5, '2016-06-23 22:00:00', 'Groupe A', 22, NULL, NULL, 1, 0),
(6, '2016-06-23 22:00:00', 'Groupe A', 13, NULL, NULL, 32, 0),
(7, '2016-06-13 21:00:00', 'Groupe B', 10, NULL, NULL, 5, 0),
(8, '2016-06-14 00:00:00', 'Groupe B', 17, NULL, NULL, 28, 0),
(9, '2016-06-19 00:00:00', 'Groupe B', 10, NULL, NULL, 17, 0),
(10, '2016-06-18 18:00:00', 'Groupe B', 28, NULL, NULL, 5, 0),
(11, '2016-06-23 18:00:00', 'Groupe B', 28, NULL, NULL, 10, 0),
(12, '2016-06-23 18:00:00', 'Groupe B', 5, NULL, NULL, 17, 0),
(13, '2016-06-14 18:00:00', 'Groupe C', 16, NULL, NULL, 12, 0),
(14, '2016-06-15 00:00:00', 'Groupe C', 21, NULL, NULL, 26, 0),
(15, '2016-06-19 18:00:00', 'Groupe C', 16, NULL, NULL, 21, 0),
(16, '2016-06-20 00:00:00', 'Groupe C', 26, NULL, NULL, 12, 0),
(17, '2016-06-24 22:00:00', 'Groupe C', 26, NULL, NULL, 16, 0),
(18, '2016-06-24 22:00:00', 'Groupe C', 12, NULL, NULL, 21, 0),
(19, '2016-06-14 21:00:00', 'Groupe D', 19, NULL, NULL, 30, 0),
(20, '2016-06-15 03:00:00', 'Groupe D', 9, NULL, NULL, 3, 0),
(21, '2016-06-19 21:00:00', 'Groupe D', 19, NULL, NULL, 9, 0),
(22, '2016-06-20 18:00:00', 'Groupe D', 3, NULL, NULL, 30, 0),
(23, '2016-06-24 18:00:00', 'Groupe D', 3, NULL, NULL, 19, 0),
(24, '2016-06-24 18:00:00', 'Groupe D', 30, NULL, NULL, 9, 0),
(25, '2016-06-15 18:00:00', 'Groupe E', 6, NULL, NULL, 18, 0),
(26, '2016-06-15 21:00:00', 'Groupe E', 14, NULL, NULL, 31, 0),
(27, '2016-06-20 21:00:00', 'Groupe E', 6, NULL, NULL, 14, 0),
(28, '2016-06-21 00:00:00', 'Groupe E', 31, NULL, NULL, 18, 0),
(29, '2016-06-25 22:00:00', 'Groupe E', 31, NULL, NULL, 6, 0),
(30, '2016-06-25 22:00:00', 'Groupe E', 18, NULL, NULL, 14, 0),
(31, '2016-06-16 00:00:00', 'Groupe F', 15, NULL, NULL, 8, 0),
(32, '2016-06-16 21:00:00', 'Groupe F', 25, NULL, NULL, 20, 0),
(33, '2016-06-21 18:00:00', 'Groupe F', 15, NULL, NULL, 25, 0),
(34, '2016-06-22 00:00:00', 'Groupe F', 20, NULL, NULL, 8, 0),
(35, '2016-06-25 18:00:00', 'Groupe F', 20, NULL, NULL, 15, 0),
(36, '2016-06-25 18:00:00', 'Groupe F', 8, NULL, NULL, 25, 0),
(37, '2016-06-16 18:00:00', 'Groupe G', 4, NULL, NULL, 11, 0),
(38, '2016-06-17 00:00:00', 'Groupe G', 23, NULL, NULL, 29, 0),
(39, '2016-06-21 21:00:00', 'Groupe G', 4, NULL, NULL, 23, 0),
(40, '2016-06-22 21:00:00', 'Groupe G', 29, NULL, NULL, 11, 0),
(41, '2016-06-26 18:00:00', 'Groupe G', 29, NULL, NULL, 4, 0),
(42, '2016-06-26 18:00:00', 'Groupe G', 11, NULL, NULL, 23, 0),
(43, '2016-06-17 18:00:00', 'Groupe H', 2, NULL, NULL, 24, 0),
(44, '2016-06-18 00:00:00', 'Groupe H', 7, NULL, NULL, 27, 0),
(45, '2016-06-23 00:00:00', 'Groupe H', 2, NULL, NULL, 7, 0),
(46, '2016-06-22 18:00:00', 'Groupe H', 27, NULL, NULL, 24, 0),
(47, '2016-06-26 22:00:00', 'Groupe H', 27, NULL, NULL, 2, 0),
(48, '2016-06-26 22:00:00', 'Groupe H', 24, NULL, NULL, 7, 0),
(49, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(50, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(51, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(52, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(53, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(54, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(55, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(56, '2016-06-28 18:00:00', 'Huitièmes', NULL, NULL, NULL, NULL, 0),
(57, '2016-07-04 22:00:00', 'Quarts', NULL, NULL, NULL, NULL, 0),
(58, '2016-07-04 18:00:00', 'Quarts', NULL, NULL, NULL, NULL, 0),
(59, '2016-07-05 22:00:00', 'Quarts', NULL, NULL, NULL, NULL, 0),
(60, '2016-07-05 18:00:00', 'Quarts', NULL, NULL, NULL, NULL, 0),
(61, '2016-07-08 22:00:00', 'Demies', NULL, NULL, NULL, NULL, 0),
(62, '2016-07-09 22:00:00', 'Demies', NULL, NULL, NULL, NULL, 0),
(63, '2016-07-13 21:00:00', 'Finale', NULL, NULL, NULL, NULL, 0),
(64, '2016-02-11 16:50:00', '', 33, NULL, NULL, 24, 0);

-- --------------------------------------------------------

--
-- Structure de la table `pronos_matchs`
--

CREATE TABLE IF NOT EXISTS `pronos_matchs` (
  `ID_JOUEUR` int(11) NOT NULL,
  `ID_MATCH` int(11) NOT NULL,
  `SCORE_EQUIPE_1` int(11) NOT NULL,
  `SCORE_EQUIPE_2` int(11) NOT NULL,
  `ID_GAGNANT` int(11) NOT NULL,
  `POINTS_GAGNES` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pronos_qualif`
--

CREATE TABLE IF NOT EXISTS `pronos_qualif` (
  `ID_JOUEUR` int(11) NOT NULL,
  `ID_PREMIER` int(11) NOT NULL,
  `ID_SECOND` int(11) NOT NULL,
  `ID_TROISIEME` int(11) NOT NULL,
  `ID_1_GP_A` int(11) NOT NULL,
  `ID_2_GP_A` int(11) NOT NULL,
  `ID_1_GP_B` int(11) NOT NULL,
  `ID_2_GP_B` int(11) NOT NULL,
  `ID_1_GP_C` int(11) NOT NULL,
  `ID_2_GP_C` int(11) NOT NULL,
  `ID_1_GP_D` int(11) NOT NULL,
  `ID_2_GP_D` int(11) NOT NULL,
  `ID_1_GP_E` int(11) NOT NULL,
  `ID_2_GP_E` int(11) NOT NULL,
  `ID_1_GP_F` int(11) NOT NULL,
  `ID_2_GP_F` int(11) NOT NULL,
  `ID_1_GP_G` int(11) NOT NULL,
  `ID_2_GP_G` int(11) NOT NULL,
  `ID_1_GP_H` int(11) NOT NULL,
  `ID_2_GP_H` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `DRAP_URL` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `AUTRE` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `teams`
--

INSERT INTO `teams` (`ID`, `NOM`, `DRAP_URL`, `AUTRE`) VALUES
(1, 'Brésil', 'http://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Flag_of_Brazil.svg/20px-Flag_of_Brazil.svg.png', ''),
(2, 'Belgique', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/92/Flag_of_Belgium_%28civil%29.svg/20px-Flag_of_Belgium_%28civil%29.svg.png', ''),
(3, 'Italie', 'http://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Flag_of_Italy.svg/20px-Flag_of_Italy.svg.png', ''),
(4, 'Allemagne', 'http://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Flag_of_Germany.svg/20px-Flag_of_Germany.svg.png', ''),
(5, 'Pays-Bas', 'http://upload.wikimedia.org/wikipedia/commons/thumb/2/20/Flag_of_the_Netherlands.svg/20px-Flag_of_the_Netherlands.svg.png', ''),
(6, 'Suisse', 'http://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Flag_of_Switzerland.svg/15px-Flag_of_Switzerland.svg.png', ''),
(7, 'Russie', 'http://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Flag_of_Russia.svg/20px-Flag_of_Russia.svg.png', ''),
(8, 'Bosnie-Herzégovine', 'http://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/Flag_of_Bosnia_and_Herzegovina.svg/20px-Flag_of_Bosnia_and_Herzegovina.svg.png', ''),
(9, 'Angleterre', 'http://upload.wikimedia.org/wikipedia/commons/thumb/b/be/Flag_of_England.svg/20px-Flag_of_England.svg.png', ''),
(10, 'Espagne', 'http://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Flag_of_Spain.svg/20px-Flag_of_Spain.svg.png', ''),
(11, 'Portugal', 'http://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Flag_of_Portugal.svg/20px-Flag_of_Portugal.svg.png', ''),
(12, 'Grèce', 'http://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Flag_of_Greece.svg/20px-Flag_of_Greece.svg.png', ''),
(13, 'Croatie', 'http://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Flag_of_Croatia.svg/20px-Flag_of_Croatia.svg.png', ''),
(14, 'France', 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Flag_of_France.svg/20px-Flag_of_France.svg.png', ''),
(15, 'Argentine', 'http://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Flag_of_Argentina.svg/20px-Flag_of_Argentina.svg.png', ''),
(16, 'Colombie', 'http://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Flag_of_Colombia.svg/20px-Flag_of_Colombia.svg.png', ''),
(17, 'Chili', 'http://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Flag_of_Chile.svg/20px-Flag_of_Chile.svg.png', ''),
(18, 'Équateur', 'http://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Flag_of_Ecuador.svg/20px-Flag_of_Ecuador.svg.png', ''),
(19, 'Uruguay', 'http://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_Uruguay.svg/20px-Flag_of_Uruguay.svg.png', ''),
(20, 'Nigeria', 'http://upload.wikimedia.org/wikipedia/commons/thumb/7/79/Flag_of_Nigeria.svg/20px-Flag_of_Nigeria.svg.png', ''),
(21, 'Côte d''Ivoire', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_C%C3%B4te_d''Ivoire.svg/20px-Flag_of_C%C3%B4te_d''Ivoire.svg.png', ''),
(22, 'Cameroun', 'http://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Flag_of_Cameroon.svg/20px-Flag_of_Cameroon.svg.png', ''),
(23, 'Ghana', 'http://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Flag_of_Ghana.svg/20px-Flag_of_Ghana.svg.png', ''),
(24, 'Algérie', 'http://upload.wikimedia.org/wikipedia/commons/thumb/7/77/Flag_of_Algeria.svg/20px-Flag_of_Algeria.svg.png', ''),
(25, 'Iran', 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Flag_of_Iran.svg/20px-Flag_of_Iran.svg.png', ''),
(26, 'Japon', 'http://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Flag_of_Japan.svg/20px-Flag_of_Japan.svg.png', ''),
(27, 'Corée du Sud', 'http://upload.wikimedia.org/wikipedia/commons/thumb/0/09/Flag_of_South_Korea.svg/20px-Flag_of_South_Korea.svg.png', ''),
(28, 'Australie', 'http://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Flag_of_Australia.svg/20px-Flag_of_Australia.svg.png', ''),
(29, 'États-Unis', 'http://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/20px-Flag_of_the_United_States.svg.png', ''),
(30, 'Costa Rica', 'http://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Flag_of_Costa_Rica.svg/20px-Flag_of_Costa_Rica.svg.png', ''),
(31, 'Honduras', 'http://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Flag_of_Honduras.svg/20px-Flag_of_Honduras.svg.png', ''),
(32, 'Mexique', 'http://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Flag_of_Mexico.svg/20px-Flag_of_Mexico.svg.png', ''),
(33, 'PSG', 'http://www.rezofoot.com/images/photos_fiches/club_201403011837.jpg', '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `MDP` varchar(26) COLLATE utf8_unicode_ci NOT NULL,
  `AUTRE_1` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `AUTRE_2` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `POINTS` int(11) NOT NULL,
  `TENDANCE` int(11) NOT NULL,
  `ADMIN` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HAS_PAID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`ID`, `NOM`, `EMAIL`, `MDP`, `AUTRE_1`, `AUTRE_2`, `POINTS`, `TENDANCE`, `ADMIN`, `HAS_PAID`) VALUES
(1, 'Edgar', 'edgar.herbo@capgemini.com', '7mzd80', '', '', 0, 0, 'X', 0),
(2, 'Pierre', 'pierre.aguilar@capgemini.com', 'wl3u33', '', '', 0, 0, 'X', 1),
(3, 'Cyrille', 'cyrille.de-benque@capgemini.com', '4nb73s', '', '', 0, 0, 'X', 0),
(4, 'Sébastien', 'sebastien.bazin@capgemini.com', '3e39ox', '', '', 0, 0, 'X', 1),
(5, 'Admin', 'admin', 'admin', '', '', 0, 0, 'X', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
