-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 15 oct. 2019 à 13:16
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `akkappiness`
--

-- --------------------------------------------------------

--
-- Structure de la table `consultant`
--

DROP TABLE IF EXISTS `consultant`;
CREATE TABLE IF NOT EXISTS `consultant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `manager_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `consultant`
--

INSERT INTO `consultant` (`id`, `lastname`, `firstname`, `mail`, `state`, `manager_id`) VALUES
(1, 'MINOTTI', 'Francesco', 'francesco.minotti@akka.eu', 0, 1),
(2, 'LUCAS', 'Julien', 'julien.lucas@akka.eu', 0, 1),
(3, 'MAURY', 'Rémi', 'remi.maury@akka.eu', 0, 1),
(4, 'QUESNEL', 'Yann', 'yann.quesnel@akka.eu', 0, 1),
(5, 'RAYMOND', 'David', 'david.raymond@akka.eu', 0, 1),
(6, 'PEDELUCQ', 'Olivier', 'olivier.pedelucq@akka.eu', 0, 1),
(7, 'BENNIX', 'Badreddine', 'badreddine.bennix@akka.eu', 0, 1),
(8, 'FABRY', 'Antoine', 'antoine.fabry@akka.eu', 0, 2),
(9, 'VEDRENNE', 'Adrien', 'adrien.vedrenne@akka.eu', 0, 2),
(10, 'VERNIOLLE', 'Lisa', 'lisa.verniolle@akka.eu', 0, 2),
(11, 'POPNIKOLOV', 'Borislav', 'borislav.popnikolov@akka.eu', 0, 2),
(12, 'ROUYER', 'Thomas', 'thomas.rouyer@akka.eu', 0, 2),
(13, 'DEVY', 'JÃ©rÃ´me', 'jerome.devy@akka.eu', 0, 2),
(14, 'SALIN', 'Samuel', 'samuel.salin@akka.eu', 0, 2),
(15, 'SLAOUI', 'Mohammed', 'mohammed.slaoui@akka.eu', 0, 2),
(16, 'CHEVASSUS AGNES', 'Camille', 'camille.chevassusagnes@akka.eu', 0, 2),
(17, 'GUILLOT', 'Kevin', '', 0, 2),
(18, 'CHARBONNIER', 'Cédric', '', 0, 2),
(19, 'FREJ', 'Nawfal', '', 0, 2),
(20, 'MESPLET', ' Jérémy', '', 0, 2),
(21, 'PUGIBET', 'Loïc', '', 0, 2),
(22, 'GUILLOT', 'Jérémy', '', 0, 2),
(23, 'BRIAND', 'Chloe', '', 0, 2),
(24, 'IDOUBIHI', 'Mostapha', '', 0, 2),
(25, 'VARLET', 'Jérôme', '', 0, 2),
(26, 'BRIDON', 'Julien', '', 0, 2),
(27, 'BENNANI', 'Kawtar', '', 0, 2),
(28, 'BENRAHOU', 'Abdelillah', '', 0, 2),
(29, 'WAHID', 'Mohammed', '', 0, 2),
(30, 'ROULIN', 'Fabrice', '', 0, 2),
(31, 'BOUTIGNY', 'Adrien', '', 0, 2),
(33, 'CARRE', 'Lionel-bernard', '', 0, 3),
(34, 'GIRARD', 'Matthieu', '', 0, 3),
(35, 'QUINOT', 'Isabelle', '', 0, 3),
(36, 'MERZEAU', 'Aurelien', '', 0, 3),
(37, 'ADJANOH', 'Folly', '', 0, 3),
(38, 'GRANJOU', 'Matthieu', '', 0, 3),
(39, 'CHERKI', 'Safouane', '', 0, 3),
(40, 'GIRAUD', 'Kévin', '', 0, 3),
(41, 'ADELE', 'Michaël', '', 0, 3),
(42, 'MAGHOUS', 'Marouane', '', 0, 3),
(43, 'JOSSEAUME', 'Julien', '', 0, 3),
(44, 'MOUNJI', 'Amine', '', 0, 3),
(45, 'SELVA', 'Florian', '', 0, 3),
(46, 'SOUBRIE', 'Thomas', '', 0, 3),
(47, 'CHERIF', 'Mohamed', '', 0, 3),
(48, 'BOUJLAL', 'Youssef', '', 0, 3),
(49, 'ZRAIDI', 'Zouhair', '', 0, 3),
(50, 'MASSOT', 'Hugues', '', 0, 3),
(51, 'SAINT', 'MARC', '', 0, 3),
(52, 'COIN', 'Magali', '', 0, 3),
(53, 'RECROIX', 'Anissa', '', 0, 3),
(54, 'CHAHID', 'Yassine', '', 0, 3),
(55, 'MECHAIN', 'Marie-Eugénie', '', 0, 3),
(56, 'MOLLARET', 'Frédérick', '', 0, 3),
(57, 'SAKI', 'Hamza', '', 0, 3),
(58, 'RIOUALI', 'Youness', '', 0, 3),
(59, 'TIOURI', 'Meryem', '', 0, 3),
(60, 'ADOUANE', 'Lila', '', 0, 3),
(61, 'PEYRE', 'Renaud', '', 0, 3),
(62, 'CONSTANTIN', 'EMILIE', '', 0, 3),
(63, 'BOUTHERIN', 'Arnaud', '', 0, 3),
(64, 'BELARBI', 'Zaid', '', 0, 3),
(65, 'EL	FAROUQY', 'Ahmed', '', 0, 3),
(66, 'FONTAN', 'Virginie', '', 0, 3),
(67, 'GOANVIC', 'Maxime', '', 0, 3),
(68, 'NADALE', 'Sophie', '', 0, 3),
(69, 'BOUALAM', 'Othman', '', 0, 3),
(70, 'BRIOLAIS', 'Yohann', '', 0, 4),
(71, 'PORTMANN', 'Clement', '', 0, 4),
(72, 'BOUYA', 'Gérard', '', 0, 4),
(73, 'FALISSARD', 'David', '', 0, 4),
(74, 'CRUANAS', 'Sabine', '', 0, 4),
(75, 'CLERISSJ', 'Vincent', '', 0, 4),
(76, 'EL	JAZOULI', 'Noussair', '', 0, 4),
(77, 'TADHAK', 'Hamza', '', 0, 4),
(78, 'TAHIRI', 'Soufiane', '', 0, 4),
(79, 'GAILLARD', 'Romain', '', 0, 4),
(80, 'ROUSSEL', 'Mélanie', '', 0, 4),
(81, 'ZACCHELLO', 'Jean-Baptiste', '', 0, 4),
(82, 'LAMHAMDI', 'Salah', '', 0, 4),
(83, 'HIP-KI', 'Annie', '', 0, 4),
(84, 'BOYER DE LA GIRODAY', 'Pierre', '', 0, 4),
(85, 'BOUKRI', 'Hicham', '', 0, 4),
(86, 'BOURDARIE', 'Maxime', '', 0, 4),
(87, 'REYNAL', 'François', '', 0, 4),
(88, 'AUDOIN', 'Arnaud', '', 0, 4),
(89, 'MARTINEZ-JURADO', 'Daniel', '', 0, 4),
(90, 'CHARBONIER', 'Louis', '', 0, 4),
(91, 'BUTA', 'Ernestas', '', 0, 4),
(92, 'BEKRI', 'Estelle', '', 0, 4),
(93, 'DONNIO', 'Luc', '', 0, 4),
(94, 'TARTAS', 'Alexia', '', 0, 4),
(95, 'SASSUS-BOURDA', 'Pierre', '', 0, 4),
(96, 'PLASSE', 'Damien', '', 0, 4),
(97, 'JUNESTRAND', 'Axel', '', 0, 4),
(98, 'PONCELET', 'Edouard', '', 0, 4),
(99, 'TUVACHE', 'Marion', '', 0, 4),
(100, 'ELIDRISSI MENDILI', 'Mohamed', '', 0, 4),
(101, 'ARJAZ CHICHOU', 'Mohamed', '', 0, 4),
(102, 'IBARBOURE', 'Miren', '', 0, 4),
(103, 'MULLER', 'Mickaël', '', 0, 4),
(104, 'GUYARD', 'Arthur', '', 0, 4),
(105, 'MERCIER', 'Sandrine', '', 0, 4),
(106, 'COLLIN', 'Maxime', '', 0, 4),
(107, 'DORE', 'Virginie', '', 0, 4),
(108, 'YANG', 'Emilie', '', 0, 4),
(109, 'TATU', 'Alin', '', 0, 4),
(110, 'RAHHAL', 'Said', '', 0, 4),
(111, 'NEVEU', 'Eugenie', '', 0, 4),
(112, 'KAMOUCH', '	Amine', '', 0, 4),
(134, 'Costello', 'Veronica', 'roni_cost@example.com', 1, 1),
(135, 'Vasseur', 'Maxime', 'maxime.vasseur.79@hotmail.fr', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `state`) VALUES
(8, 'CDISCOUNT', '', 0),
(9, 'BNP PARIBAS', '', 0),
(10, 'OCIANE', '', 0),
(11, 'BETCLIC', '', 0),
(12, 'ORANGE BUSINESS SERVICES', '', 0),
(13, 'ORANGE UPR', '', 0),
(14, 'ORANGE EYSINES', '', 0),
(17, 'CAP GEMINI TECHNOLOGY SERVICES', '', 0),
(18, 'SFR', '', 0),
(19, 'ATOS', '', 0),
(20, 'Helloasso', '', 0),
(21, 'DEKRA', '', 0),
(22, 'BANQUE CASINO', '', 0),
(23, 'CEGEDIM', '', 0),
(24, '4SH', '', 0),
(25, 'AXA', '', 0),
(26, 'eSanté Technologie', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `enquete`
--

DROP TABLE IF EXISTS `enquete`;
CREATE TABLE IF NOT EXISTS `enquete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mission_id` int(11) NOT NULL,
  `resultat` int(11) DEFAULT '0' COMMENT '1:B 2:M 3:N',
  `created_at` datetime NOT NULL,
  `state` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `mission_id` (`mission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=499 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `enquete`
--

INSERT INTO `enquete` (`id`, `mission_id`, `resultat`, `created_at`, `state`) VALUES
(487, 124, 0, '2019-10-15 11:32:03', 1),
(494, 3, 1, '2019-10-15 13:02:18', 0),
(495, 6, 1, '2019-10-15 13:02:18', 0),
(496, 4, 2, '2019-10-15 13:02:18', 0),
(497, 7, 1, '2019-10-15 13:02:18', 0),
(498, 8, 1, '2019-10-15 13:02:18', 0);

-- --------------------------------------------------------

--
-- Structure de la table `job`
--

DROP TABLE IF EXISTS `job`;
CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `job`
--

INSERT INTO `job` (`id`, `name`) VALUES
(7, 'Développeur'),
(8, 'Scrum Master'),
(9, 'Chef de projet'),
(10, 'PO');

-- --------------------------------------------------------

--
-- Structure de la table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `manager`
--

INSERT INTO `manager` (`id`, `lastname`, `firstname`, `mail`, `state`) VALUES
(1, 'MEUNIER', 'Yann', 'yann.meunier@akka.eu', 0),
(2, 'MARTIN', 'Mélanie', 'melanie.martin@akka.eu', 0),
(3, 'MELAS', 'Mickaël', 'mickael.melas@akka.eu', 0),
(4, 'SINOQUET', 'Nadège', 'nadege.sinoquet@akka.eu', 0);

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

DROP TABLE IF EXISTS `mission`;
CREATE TABLE IF NOT EXISTS `mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `stop` datetime NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `job_id` (`job_id`),
  KEY `consultant_id` (`consultant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id`, `name`, `customer_id`, `job_id`, `consultant_id`, `start`, `stop`, `state`) VALUES
(3, 'MINO-CDISCOUNT', 8, 7, 1, '2019-01-30 00:00:00', '2020-01-24 00:00:00', 0),
(4, 'LUCA-CDISCOUNT', 8, 7, 2, '2019-08-09 00:00:00', '2019-10-08 00:00:00', 0),
(6, 'MAUR-CDISCOUNT', 8, 7, 3, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(7, 'QUES-CDISCOUNT', 8, 7, 4, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(8, 'RAYM-CDISCOUNT', 8, 7, 5, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(9, 'PEDE-CDISCOUNT', 8, 7, 6, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(10, 'BENN-CDISCOUNT', 8, 7, 7, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(11, 'FABR-BNP PARIBAS', 9, 7, 8, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(12, 'VEDR-OCIANE', 10, 7, 9, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(13, 'VERN-OCIANE', 10, 7, 10, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(14, 'POPN-BETCLIC', 11, 7, 11, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(15, 'ROUY-BETCLIC', 11, 7, 12, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(16, 'DEVY-ORANGE BUSINESS SERVICES', 12, 7, 13, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(17, 'SALI-ORANGE UPR', 13, 7, 14, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(18, 'SLAO-ORANGE EYSINES', 14, 7, 15, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(19, 'CHEV-ORANGE BUSINESS SERVICES', 12, 7, 16, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(20, 'GUIL-ORANGE EYSINES', 14, 7, 17, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(21, 'CHAR-CAP GEMINI TECHNOLOGY SERVICES', 17, 7, 18, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(22, 'FREJ-CAP GEMINI TECHNOLOGY SERVICES', 17, 7, 19, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(23, 'MESP-CAP GEMINI TECHNOLOGY SERVICES', 9, 7, 20, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(24, 'PUGI-CAP GEMINI TECHNOLOGY SERVICES', 17, 7, 21, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(25, 'GUIL-SFR', 10, 7, 22, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(26, 'BRIA-SFR', 18, 7, 23, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(27, 'IDOU-SFR', 18, 7, 24, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(28, 'VARL-SFR', 18, 7, 25, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(29, 'BRID-ATOS', 19, 7, 26, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(30, 'BENN-ATOS', 19, 7, 27, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(31, 'BENR-Helloasso', 20, 7, 28, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(32, 'WAHI-Helloasso', 20, 7, 29, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(33, 'ROUL-Helloasso', 20, 7, 30, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(34, 'BOUT-Helloasso', 20, 7, 31, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(35, 'CARR-CDISCOUNT', 8, 7, 33, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(36, 'GIRA-CDISCOUNT', 8, 7, 34, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(37, 'QUIN-CDISCOUNT', 8, 7, 35, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(38, 'MERZ-CDISCOUNT', 8, 7, 36, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(39, 'ADJA-CDISCOUNT', 8, 7, 37, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(40, 'GRAN-CDISCOUNT', 8, 7, 38, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(41, 'CHER-CDISCOUNT', 8, 7, 39, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(42, 'GIRA-CDISCOUNT', 8, 7, 40, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(43, 'ADEL-CDISCOUNT', 8, 7, 41, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(44, 'MAGH-CDISCOUNT', 8, 7, 42, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(45, 'JOSS-CDISCOUNT', 8, 7, 43, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(46, 'MOUN-CDISCOUNT', 8, 7, 44, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(47, 'SELV-CDISCOUNT', 8, 7, 45, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(48, 'SOUB-CDISCOUNT', 8, 7, 46, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(49, 'CHER-CDISCOUNT', 8, 7, 47, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(50, 'BOUJ-CDISCOUNT', 8, 7, 48, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(51, 'ZRAI-CDISCOUNT', 8, 7, 49, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(52, 'MASS-CDISCOUNT', 8, 7, 50, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(53, 'SAIN-CDISCOUNT', 8, 7, 51, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(54, 'COIN-CDISCOUNT', 8, 7, 52, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(55, 'RECR-CDISCOUNT', 8, 7, 53, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(56, 'CHAH-CDISCOUNT', 8, 7, 54, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(57, 'MECH-CDISCOUNT', 8, 7, 55, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(58, 'MOLL-CDISCOUNT', 8, 7, 56, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(59, 'SAKI-CDISCOUNT', 8, 7, 57, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(60, 'RIOU-CDISCOUNT', 8, 7, 58, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(61, 'TIOU-CDISCOUNT', 8, 7, 59, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(62, 'ADOU-CDISCOUNT', 8, 7, 60, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(63, 'PEYR-DEKRA', 21, 7, 61, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(64, 'CONS-DEKRA', 21, 7, 62, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(65, 'BOUT-DEKRA', 21, 7, 63, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(66, 'BELA-DEKRA', 21, 7, 64, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(67, 'EL F-DEKRA', 21, 7, 65, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(68, 'FONT-DEKRA', 21, 7, 66, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(69, 'GOAN-BANQUE CASINO', 22, 7, 67, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(70, 'BOUA-CEGEDIM', 23, 7, 69, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(71, 'BRIO-CDISCOUNT', 8, 7, 70, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(72, 'PORT-CDISCOUNT', 8, 7, 71, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(73, 'BOUY-CDISCOUNT', 8, 7, 72, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(74, 'FALI-CDISCOUNT', 8, 7, 73, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(75, 'CRUA-CDISCOUNT', 8, 7, 74, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(76, 'CLER-CDISCOUNT', 8, 7, 75, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(77, 'EL J-CDISCOUNT', 8, 7, 76, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(78, 'TADH-CDISCOUNT', 8, 7, 77, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(79, 'TAHI-CDISCOUNT', 8, 7, 78, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(80, 'GAIL-CDISCOUNT', 8, 7, 79, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(81, 'ROUS-CDISCOUNT', 8, 7, 80, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(82, 'ZACC-CDISCOUNT', 8, 7, 81, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(83, 'LAMH-CDISCOUNT', 8, 7, 82, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(84, 'HIP-CDISCOUNT', 8, 7, 83, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(85, 'BOYE-CDISCOUNT', 8, 7, 84, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(86, 'BOUK-CDISCOUNT', 8, 7, 85, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(87, 'BOUR-CDISCOUNT', 8, 7, 86, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(88, 'REYN-CDISCOUNT', 8, 7, 87, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(89, 'AUDO-CDISCOUNT', 8, 7, 88, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(90, 'MART-CDISCOUNT', 8, 7, 89, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(91, 'CHAR-CDISCOUNT', 8, 7, 90, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(92, 'BUTA-CDISCOUNT', 8, 7, 91, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(93, 'BEKR-CDISCOUNT', 8, 7, 92, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(94, 'DONN-CDISCOUNT', 8, 7, 93, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(95, 'TART-CDISCOUNT', 8, 7, 94, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(96, 'SASS-CDISCOUNT', 8, 7, 95, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(97, 'PLAS-CDISCOUNT', 8, 7, 96, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(98, 'JUNE-CDISCOUNT', 8, 7, 97, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(99, 'PONC-CDISCOUNT', 8, 7, 98, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(100, 'TUVA-CDISCOUNT', 8, 7, 99, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(101, 'ELID-CDISCOUNT', 8, 7, 100, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(102, 'ARJA-CDISCOUNT', 8, 7, 101, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(103, 'IBAR-CDISCOUNT', 8, 7, 102, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(104, 'MULL-CDISCOUNT', 8, 7, 103, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(105, 'GUYA-CDISCOUNT', 8, 7, 104, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(106, 'MERC-CDISCOUNT', 8, 7, 105, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(107, 'COLL-CDISCOUNT', 8, 7, 106, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(108, 'DORE-CDISCOUNT', 8, 7, 107, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(109, 'YANG-CDISCOUNT', 8, 7, 108, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(110, 'TATU-4SH', 24, 7, 109, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(111, 'RAHH-4SH', 24, 7, 110, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(112, 'NEVE-AXA', 25, 7, 111, '2019-06-08 00:00:00', '2019-10-08 00:00:00', 0),
(113, 'KAMO-eSanté Technologie', 26, 7, 112, '2019-09-08 00:00:00', '2019-10-08 00:00:00', 0),
(123, 'Veronica', 8, 7, 1, '2019-10-17 00:00:00', '2019-10-25 00:00:00', 1),
(124, 'missionTest', 8, 7, 135, '2019-10-10 00:00:00', '2019-10-31 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `mail`, `password`) VALUES
(3, 'maxime.vasseur@akka.eu', 'max'),
(4, 'juliette.bousseau@akka.eu', 'ju');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consultant`
--
ALTER TABLE `consultant`
  ADD CONSTRAINT `consultant_ibfk_2` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`);

--
-- Contraintes pour la table `enquete`
--
ALTER TABLE `enquete`
  ADD CONSTRAINT `enquete_ibfk_1` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`);

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `mission_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
