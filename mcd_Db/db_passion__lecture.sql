-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db:3306
-- Généré le : lun. 18 nov. 2024 à 10:17
-- Version du serveur : 8.0.30
-- Version de PHP : 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_passion _lecture`
--

-- --------------------------------------------------------

--
-- Structure de la table `apprecier`
--

CREATE TABLE `apprecier` (
  `ouvrage_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `note` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_categorie`
--

CREATE TABLE `t_categorie` (
  `categorie_id` int NOT NULL,
  `nom` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_ecrivain`
--

CREATE TABLE `t_ecrivain` (
  `ecrivain_id` int NOT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `prenom` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_ouvrage`
--

CREATE TABLE `t_ouvrage` (
  `ouvrage_id` int NOT NULL,
  `titre` varchar(128) DEFAULT NULL,
  `nombre_page` tinyint DEFAULT NULL,
  `extrait` varchar(250) NOT NULL,
  `resume` varchar(500) DEFAULT NULL,
  `date_edition` date DEFAULT NULL,
  `image_couverture` varchar(250) DEFAULT NULL,
  `editeur` varchar(50) DEFAULT NULL,
  `ecrivain_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `categorie_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_utilisateur`
--

CREATE TABLE `t_utilisateur` (
  `utilisateur_id` int NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `date_entree` date DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `prenom` varchar(128) DEFAULT NULL,
  `mot_de_passe` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `apprecier`
--
ALTER TABLE `apprecier`
  ADD PRIMARY KEY (`ouvrage_id`,`utilisateur_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Index pour la table `t_ecrivain`
--
ALTER TABLE `t_ecrivain`
  ADD PRIMARY KEY (`ecrivain_id`);

--
-- Index pour la table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  ADD PRIMARY KEY (`ouvrage_id`),
  ADD KEY `ecrivain_id` (`ecrivain_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  ADD PRIMARY KEY (`utilisateur_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_categorie`
--
ALTER TABLE `t_categorie`
  MODIFY `categorie_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_ecrivain`
--
ALTER TABLE `t_ecrivain`
  MODIFY `ecrivain_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  MODIFY `ouvrage_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  MODIFY `utilisateur_id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `apprecier`
--
ALTER TABLE `apprecier`
  ADD CONSTRAINT `apprecier_ibfk_1` FOREIGN KEY (`ouvrage_id`) REFERENCES `t_ouvrage` (`ouvrage_id`),
  ADD CONSTRAINT `apprecier_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `t_utilisateur` (`utilisateur_id`);

--
-- Contraintes pour la table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  ADD CONSTRAINT `t_ouvrage_ibfk_1` FOREIGN KEY (`ecrivain_id`) REFERENCES `t_ecrivain` (`ecrivain_id`),
  ADD CONSTRAINT `t_ouvrage_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `t_utilisateur` (`utilisateur_id`),
  ADD CONSTRAINT `t_ouvrage_ibfk_3` FOREIGN KEY (`categorie_id`) REFERENCES `t_categorie` (`categorie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
