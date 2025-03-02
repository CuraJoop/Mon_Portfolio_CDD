-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 18 déc. 2024 à 07:33
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stationnement`
--

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `idReservation` int NOT NULL AUTO_INCREMENT,
  `dateDebut` datetime DEFAULT NULL,
  `dateFin` datetime DEFAULT NULL,
  `statut` enum('En cours','Terminé','Annulé') COLLATE latin1_general_ci DEFAULT NULL,
  `idStationnement` int DEFAULT NULL,
  `idVehicule` int DEFAULT NULL,
  PRIMARY KEY (`idReservation`),
  KEY `idStationnement` (`idStationnement`),
  KEY `idVehicule` (`idVehicule`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`idReservation`, `dateDebut`, `dateFin`, `statut`, `idStationnement`, `idVehicule`) VALUES
(1, '2024-12-18 00:18:00', '2024-12-20 00:18:00', 'En cours', 2, 0),
(2, '2024-12-19 00:25:00', '2024-12-21 00:25:00', 'En cours', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `stationnement`
--

DROP TABLE IF EXISTS `stationnement`;
CREATE TABLE IF NOT EXISTS `stationnement` (
  `idStationnement` int NOT NULL AUTO_INCREMENT,
  `nomEmplacement` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `capaciteTotale` int DEFAULT NULL,
  `capaciteDisponible` int DEFAULT NULL,
  PRIMARY KEY (`idStationnement`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Déchargement des données de la table `stationnement`
--

INSERT INTO `stationnement` (`idStationnement`, `nomEmplacement`, `adresse`, `capaciteTotale`, `capaciteDisponible`) VALUES
(1, 'ESC1', 'Sacre-Coeur', 30, 30),
(2, 'ESC2', 'Sacré-Coeur', 20, 20),
(3, 'MD1', 'Médina', 15, 15),
(4, 'MD2', 'Médina', 45, 45);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `prenom` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `motDePasse` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `typeUtilisateur` enum('Admin','Agent','Client') COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nom`, `prenom`, `email`, `motDePasse`, `typeUtilisateur`) VALUES
(1, 'Diouf', 'Daouda', 'dadiouf2001@yahoo.fr', 'passer', 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `idVehicule` int NOT NULL AUTO_INCREMENT,
  `immatriculation` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `typeVehicule` enum('Voiture','Moto','Camion') COLLATE latin1_general_ci DEFAULT NULL,
  `idClient` int DEFAULT NULL,
  PRIMARY KEY (`idVehicule`),
  UNIQUE KEY `immatriculation` (`immatriculation`),
  KEY `idClient` (`idClient`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
