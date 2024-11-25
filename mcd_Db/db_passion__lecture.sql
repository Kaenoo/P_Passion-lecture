-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db:3306
-- Généré le : lun. 25 nov. 2024 à 09:52
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
DROP DATABASE IF EXISTS `db_passion_lecture`;
CREATE DATABASE `db_passion_lecture`;
USE `db_passion_lecture`;
-- --------------------------------------------------------

--
-- Structure de la table `t_apprecier`
--

CREATE TABLE `t_apprecier` (
  `ouvrage_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `note` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `t_apprecier`
--

INSERT INTO `t_apprecier` (`ouvrage_id`, `utilisateur_id`, `note`) VALUES
(1, 1, 5),
(2, 2, 4),
(3, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_categorie`
--

CREATE TABLE `t_categorie` (
  `categorie_id` int NOT NULL,
  `nom` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `t_categorie`
--

INSERT INTO `t_categorie` (`categorie_id`, `nom`) VALUES
(1, 'Science Fiction'),
(2, 'Fantaisie'),
(3, 'Biographie');

-- --------------------------------------------------------

--
-- Structure de la table `t_ecrivain`
--

CREATE TABLE `t_ecrivain` (
  `ecrivain_id` int NOT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `prenom` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `t_ecrivain`
--

INSERT INTO `t_ecrivain` (`ecrivain_id`, `nom`, `prenom`) VALUES
(1, 'Asimov', 'Isaac'),
(2, 'Tolkien', 'J.R.R.'),
(3, 'Obama', 'Barack'),
(4, 'Levi', 'Primo');

-- --------------------------------------------------------

--
-- Structure de la table `t_ouvrage`
--

CREATE TABLE `t_ouvrage` (
  `ouvrage_id` int NOT NULL,
  `titre` varchar(128) DEFAULT NULL,
  `nombre_page` smallint DEFAULT NULL,
  `extrait` varchar(250) NOT NULL,
  `resume` varchar(500) DEFAULT NULL,
  `date_edition` year DEFAULT NULL,
  `image_couverture` varchar(250) DEFAULT NULL,
  `editeur` varchar(50) DEFAULT NULL,
  `ecrivain_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `categorie_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `t_ouvrage`
--

INSERT INTO `t_ouvrage` (`ouvrage_id`, `titre`, `nombre_page`, `extrait`, `resume`, `date_edition`, `image_couverture`, `editeur`, `ecrivain_id`, `utilisateur_id`, `categorie_id`) VALUES
(1, 'Fondation', 255, 'Un extrait passionnant...', 'Un classique de la science-fiction.', 1951, 'fondation.jpg', 'Gnome Press', 1, 1, 1),
(2, 'Le Seigneur des Anneaux', 1178, 'Un extrait épique...', 'Une épopée fantastique.', 1954, 'lotr.jpg', 'Allen & Unwin', 2, 2, 2),
(3, 'Une Terre Promise', 768, 'Un extrait inspirant...', 'Les mémoires du président.', 2020, 'terre_promise.jpg', 'Crown', 3, 1, 3),
(4, 'Si c\'est un homme', 206, 'Un témoignage poignant...', 'Un récit autobiographique sur les camps de concentration.', 1947, 'si_c_est_un_homme.jpg', 'De Silva', 4, 1, 3),
(5, 'La Trêve', 264, 'Un récit captivant...', 'Suite de Si c\'est un homme, décrivant le retour en Italie.', 1963, 'la_treve.jpg', 'Einaudi', 4, 1, 3),
(6, 'Les Naufragés et les Rescapés', 203, 'Une réflexion profonde...', 'Un essai sur la mémoire et le pardon.', 1986, 'naufrages_rescapes.jpg', 'Einaudi', 4, 2, 3);

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
-- Déchargement des données de la table `t_utilisateur`
--

INSERT INTO `t_utilisateur` (`utilisateur_id`, `pseudo`, `date_entree`, `admin`, `nom`, `prenom`, `mot_de_passe`) VALUES
(1, 'lecteur1', '2023-01-15', 0, 'Doe', 'John', 'password123'),
(2, 'admin', '2020-05-20', 1, 'Smith', 'Jane', 'adminpass'),
(3, 'lectrice2', '2024-03-10', 0, 'Brown', 'Emma', 'pass456');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_apprecier`
--
ALTER TABLE `t_apprecier`
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
  MODIFY `categorie_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `t_ecrivain`
--
ALTER TABLE `t_ecrivain`
  MODIFY `ecrivain_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  MODIFY `ouvrage_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  MODIFY `utilisateur_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_apprecier`
--
ALTER TABLE `t_apprecier`
  ADD CONSTRAINT `t_apprecier_ibfk_1` FOREIGN KEY (`ouvrage_id`) REFERENCES `t_ouvrage` (`ouvrage_id`),
  ADD CONSTRAINT `t_apprecier_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `t_utilisateur` (`utilisateur_id`);

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
