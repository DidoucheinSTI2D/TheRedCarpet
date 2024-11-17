DROP DATABASE IF EXISTS TheRedCarpet;
CREATE DATABASE TheRedCarpet;

USE TheRedCarpet;

-- Base de données : `theredcarpet`
--

-- --------------------------------------------------------

--
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 13 nov. 2024 à 22:00
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `theredcarpet`
--

-- --------------------------------------------------------

--
-- Structure de la table `artist`
--

DROP TABLE IF EXISTS `artist`;
CREATE TABLE IF NOT EXISTS `artist` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `firstName` char(255) NOT NULL,
  `lastName` char(255) NOT NULL,
  `biography` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `helpText` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `representation`
--

DROP TABLE IF EXISTS `representation`;
CREATE TABLE IF NOT EXISTS `representation` (
  `first_date` datetime NOT NULL,
  `last_date` datetime NOT NULL,
  `spectacle_id` int NOT NULL,
  `room_id` int NOT NULL,
  KEY `fk_representationS` (`spectacle_id`) USING BTREE,
  KEY `fk_representationR` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role` varchar(255) NOT NULL,
  `artist_id` int NOT NULL,
  `spectacle_id` int NOT NULL,
  KEY `fk_roleA` (`artist_id`),
  KEY `fk_roleS` (`spectacle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `name` char(1) NOT NULL,
  `gauge` int NOT NULL,
  `theater_id` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_theatre` (`theater_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `date` datetime NOT NULL,
  `booked` int NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `amount` float NOT NULL,
  `comment` text NOT NULL,
  `notation` int NOT NULL,
  `reactions` json NOT NULL,
  `spectacle_id` int NOT NULL,
  `subscriber_id` int NOT NULL,
  KEY `fk_scheduleSP` (`spectacle_id`),
  KEY `fk_scheduleSU` (`subscriber_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `spectacle`
--

DROP TABLE IF EXISTS `spectacle`;
CREATE TABLE IF NOT EXISTS `spectacle` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL,
  `synopsis` text NOT NULL,
  `duration` time NOT NULL,
  `price` float NOT NULL,
  `language` enum('français','VO','surtitré','audio') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_spectacle` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subscriber`
--

DROP TABLE IF EXISTS `subscriber`;
CREATE TABLE IF NOT EXISTS `subscriber` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` datetime NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `theatre`
--

DROP TABLE IF EXISTS `theatre`;
CREATE TABLE IF NOT EXISTS `theatre` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `presentation` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `borough` int NOT NULL,
  `geolocalisation` point NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `representation`
--
ALTER TABLE `representation`
  ADD CONSTRAINT `fk_representationR` FOREIGN KEY (`room_id`) REFERENCES `room` (`ID`),
  ADD CONSTRAINT `fk_representationS` FOREIGN KEY (`spectacle_id`) REFERENCES `spectacle` (`ID`);

--
-- Contraintes pour la table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `fk_roleA` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`ID`),
  ADD CONSTRAINT `fk_roleS` FOREIGN KEY (`spectacle_id`) REFERENCES `spectacle` (`ID`);

--
-- Contraintes pour la table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_theatre` FOREIGN KEY (`theater_id`) REFERENCES `theatre` (`ID`);

--
-- Contraintes pour la table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_scheduleSP` FOREIGN KEY (`spectacle_id`) REFERENCES `spectacle` (`ID`),
  ADD CONSTRAINT `fk_scheduleSU` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`ID`);

--
-- Contraintes pour la table `spectacle`
--
ALTER TABLE `spectacle`
  ADD CONSTRAINT `fk_spectacle` FOREIGN KEY (`category_id`) REFERENCES `category` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
