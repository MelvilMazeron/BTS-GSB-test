-- phpMyAdmin SQL Dump
-- version 5.2.2-1.fc41
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 02 mai 2025 à 08:08
-- Version du serveur : 10.11.11-MariaDB
-- Version de PHP : 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsb_rapport`
--

-- --------------------------------------------------------

--
-- Structure de la table `echantillon`
--

CREATE TABLE `echantillon` (
  `Id_Echantillon` int(11) NOT NULL,
  `DateDistributionEchantillon` date DEFAULT NULL,
  `NomEchantillon` varchar(50) DEFAULT NULL,
  `Libele` varchar(50) DEFAULT NULL,
  `QuantiteEchantillon` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `echantillon`
--

INSERT INTO `echantillon` (`Id_Echantillon`, `DateDistributionEchantillon`, `NomEchantillon`, `Libele`, `QuantiteEchantillon`) VALUES
(1, '2025-04-06', 'echantillon 1', 'libelle ech 1', '5'),
(2, '2025-03-26', 'echantillon 2', 'libelle ech 2', '7');

-- --------------------------------------------------------

--
-- Structure de la table `practicien`
--

CREATE TABLE `practicien` (
  `Id_Practicien` int(11) NOT NULL,
  `EmailPracticien` varchar(50) DEFAULT NULL,
  `SpecialiteMedecin` varchar(50) DEFAULT NULL,
  `DescriptionMedecin` varchar(255) DEFAULT NULL,
  `Cabinet` varchar(255) DEFAULT NULL,
  `AdressePracticien` varchar(50) DEFAULT NULL,
  `CodePostalPracticien` varchar(50) DEFAULT NULL,
  `VillePracticien` varchar(50) DEFAULT NULL,
  `IdRegion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `Id_Produit` int(11) NOT NULL,
  `NomProduit` varchar(50) DEFAULT NULL,
  `DateAjoutProduit` date DEFAULT NULL,
  `Libele` varchar(50) DEFAULT NULL,
  `QuantiteProduit` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`Id_Produit`, `NomProduit`, `DateAjoutProduit`, `Libele`, `QuantiteProduit`) VALUES
(1, 'produit 1', '2025-04-07', 'libelle 1', '5'),
(2, 'produit 2', '2025-04-06', 'libelle 2', '7');

-- --------------------------------------------------------

--
-- Structure de la table `rapport`
--

CREATE TABLE `rapport` (
  `Id_Rappport` int(11) NOT NULL,
  `AdresseRapport` varchar(255) DEFAULT NULL,
  `DateRapport` date DEFAULT NULL,
  `CodePostal` int(5) DEFAULT NULL,
  `Id_Echantillon` int(11) NOT NULL,
  `Id_Produit` int(11) NOT NULL,
  `Id_Visiteur` int(11) NOT NULL,
  `Id_Practicien` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rapport`
--

INSERT INTO `rapport` (`Id_Rappport`, `AdresseRapport`, `DateRapport`, `CodePostal`, `Id_Echantillon`, `Id_Produit`, `Id_Visiteur`, `Id_Practicien`) VALUES
(1, '25 avenue de Montlouis 69410 Champagne-au-Mont-d\'Or', '2025-04-08', 0, 0, 0, 0, 1),
(2, '25 avenue de Montlouis 69410 Champagne-au-Mont-d\'Or', '2025-04-08', 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `IdRegion` int(11) NOT NULL,
  `NomRegion` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`IdRegion`, `NomRegion`) VALUES
(3, 'Auvergne-Rhône-Alpes'),
(4, 'Bourgogne-Franche-Comté'),
(5, 'Bretagne'),
(6, 'Centre-Val de Loire'),
(7, 'Corse'),
(8, 'Grand Est'),
(9, 'Hauts-de-France'),
(10, 'Île-de-France'),
(11, 'Normandie'),
(12, 'Nouvelle-Aquitaine'),
(13, 'Occitanie'),
(14, 'Pays de la Loire'),
(15, 'Provence-Alpes-Côte d\'Azur'),
(16, 'Guadeloupe'),
(17, 'Martinique'),
(18, 'Guyane'),
(19, 'La Réunion'),
(20, 'Mayotte');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `Id_Utilisateur` int(11) NOT NULL,
  `MotDePasse` varchar(255) DEFAULT NULL,
  `NomUtilisateur` varchar(50) DEFAULT NULL,
  `Role` enum('visiteur','delegue','responsable') NOT NULL,
  `PrenomUtilisateur` varchar(50) DEFAULT NULL,
  `NumeroTelephoneUtilisateur` varchar(15) DEFAULT NULL,
  `MailUtilisateur` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `echantillon`
--
ALTER TABLE `echantillon`
  ADD PRIMARY KEY (`Id_Echantillon`);

--
-- Index pour la table `practicien`
--
ALTER TABLE `practicien`
  ADD PRIMARY KEY (`Id_Practicien`),
  ADD KEY `IdRegion` (`IdRegion`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`Id_Produit`);

--
-- Index pour la table `rapport`
--
ALTER TABLE `rapport`
  ADD PRIMARY KEY (`Id_Rappport`),
  ADD KEY `Id_Echantillon` (`Id_Echantillon`),
  ADD KEY `Id_Produit` (`Id_Produit`),
  ADD KEY `Id_Visiteur` (`Id_Visiteur`),
  ADD KEY `Id_Practicien` (`Id_Practicien`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`IdRegion`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Id_Utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `echantillon`
--
ALTER TABLE `echantillon`
  MODIFY `Id_Echantillon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `practicien`
--
ALTER TABLE `practicien`
  MODIFY `Id_Practicien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `Id_Produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rapport`
--
ALTER TABLE `rapport`
  MODIFY `Id_Rappport` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `IdRegion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `Id_Utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
