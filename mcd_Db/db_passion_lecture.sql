-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Dec 10, 2024 at 04:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_passion_lecture`
--
CREATE DATABASE IF NOT EXISTS `db_passion_lecture` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_passion_lecture`;

-- --------------------------------------------------------

--
-- Table structure for table `t_apprecier`
--

CREATE TABLE `t_apprecier` (
  `ouvrage_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `note` tinyint DEFAULT NULL,
  `commentaire` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_apprecier`
--

INSERT INTO `t_apprecier` (`ouvrage_id`, `utilisateur_id`, `note`, `commentaire`) VALUES
(4, 1, 5, 'Un livre excellent qui raconte une partie de l\'Histoire a ne pas oublié.'),
(3, 1, 3, 'Bof, sans plus.\r\nLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit esse dolores ipsam qui voluptatem distinctio accusamus, at id possimus assumenda voluptate eum culpa molestias totam incidunt, aut quis repellat voluptatum.');

-- --------------------------------------------------------

--
-- Table structure for table `t_categorie`
--

CREATE TABLE `t_categorie` (
  `categorie_id` int NOT NULL,
  `nom` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_categorie`
--

INSERT INTO `t_categorie` (`categorie_id`, `nom`) VALUES
(1, 'Science Fiction'),
(2, 'Fantaisie'),
(3, 'Biographie'),
(4, 'Roman'),
(5, 'Bande dessinée'),
(6, 'Manga'),
(7, 'Philosophie');

-- --------------------------------------------------------

--
-- Table structure for table `t_ecrivain`
--

CREATE TABLE `t_ecrivain` (
  `ecrivain_id` int NOT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `prenom` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_ecrivain`
--

INSERT INTO `t_ecrivain` (`ecrivain_id`, `nom`, `prenom`) VALUES
(1, 'Asimov', 'Isaac'),
(2, 'Tolkien', 'J.R.R.'),
(3, 'Obama', 'Barack'),
(4, 'Levi', 'Primo'),
(5, 'Hugo', 'Victor'),
(6, 'Austen', 'Jane'),
(7, 'Dumas', 'Alexandre'),
(8, 'Rowling', 'J.K.'),
(9, 'Orwell', 'George'),
(10, 'Camus', 'Albert');

-- --------------------------------------------------------

--
-- Table structure for table `t_ouvrage`
--

CREATE TABLE `t_ouvrage` (
  `ouvrage_id` int NOT NULL,
  `titre` varchar(128) DEFAULT NULL,
  `nombre_page` smallint DEFAULT NULL,
  `extrait` varchar(250) NOT NULL,
  `resume` varchar(500) DEFAULT NULL,
  `date_edition` int DEFAULT NULL,
  `image_couverture` varchar(250) DEFAULT NULL,
  `editeur` varchar(50) DEFAULT NULL,
  `ecrivain_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `categorie_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_ouvrage`
--

INSERT INTO `t_ouvrage` (`ouvrage_id`, `titre`, `nombre_page`, `extrait`, `resume`, `date_edition`, `image_couverture`, `editeur`, `ecrivain_id`, `utilisateur_id`, `categorie_id`) VALUES
(1, 'Fondation', 255, 'Un extrait passionnant...', 'Un classique de la science-fiction.', 1951, 'src\\imgCoverBook\\isaac_Asimov_Fondation.jpg', 'Gnome Press', 1, 1, 1),
(2, 'Le Seigneur des Anneaux', 1178, 'Un extrait épique...', 'Une épopée fantastique.', 1954, 'https://images.noosfere.org/couv/f/floisirs14777-2001.jpg', 'Allen & Unwin', 2, 2, 2),
(3, 'Une Terre Promise', 768, 'Un extrait inspirant...', 'Les mémoires du président.', 2020, 'https://des-livres-pour-changer-de-vie.com/wp-content/uploads/2023/05/Une-terre-promise.jpg', 'Crown', 3, 1, 3),
(4, 'Si c\'est un homme', 206, 'Un témoignage poignant...', 'Un récit autobiographique sur les camps de concentration.', 1947, 'https://cdn1.booknode.com/book_cover/1376/full/si-cest-un-homme-1375589.jpg', 'De Silva', 4, 1, 3),
(5, 'La Trêve', 264, 'Un récit captivant...', 'Suite de Si c\'est un homme, décrivant le retour en Italie.', 1963, 'https://static.fnac-static.com/multimedia/PE/Images/FR/NR/4b/07/15/1378123/1507-1/tsp20240928073107/La-Treve.jpg', 'Einaudi', 4, 1, 3),
(6, 'Les Naufragés et les Rescapés', 203, 'Une réflexion profonde...', 'Un essai sur la mémoire et le pardon.', 1986, 'https://m.media-amazon.com/images/I/71WKoQovrzL._AC_UF1000,1000_QL80_.jpg', 'Einaudi', 4, 2, 3),
(7, 'Les Misérables', 1232, 'Jean Valjean, ancien bagnard...', 'Un chef-d’œuvre racontant la lutte pour la justice sociale.', 2009, '', 'Pocket', 5, 3, 4),
(8, 'Harry Potter à l\'école des sorciers', 309, 'Mr et Mrs Dursley, qui habitaient au 4, Privet Drive...', 'Les débuts de l’aventure magique de Harry Potter.', 1997, 'harry_potter.jpg', 'Bloomsbury', 8, 3, 2),
(9, '1984', 328, 'Big Brother vous surveille...', 'Un roman dystopique sur un régime totalitaire et la surveillance de masse.', 1949, '1984.jpg', 'Secker & Warburg', 9, 2, 1),
(10, 'L\'Étranger', 123, 'Aujourd’hui, maman est morte...', 'Un homme détaché est confronté à un meurtre et à son procès.', 1942, 'etranger.jpg', 'Gallimard', 10, 14, 7);

-- --------------------------------------------------------

--
-- Table structure for table `t_utilisateur`
--

CREATE TABLE `t_utilisateur` (
  `utilisateur_id` int NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `date_entree` date DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `prenom` varchar(128) DEFAULT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_utilisateur`
--

INSERT INTO `t_utilisateur` (`utilisateur_id`, `pseudo`, `date_entree`, `admin`, `nom`, `prenom`, `mot_de_passe`) VALUES
(1, 'Kaeno', '2024-11-29', 1, 'Eyer', 'Kaeno', '$2y$10$KNiOZTUytSh2z9Pjb0XQcOekpu.y/LAoYOvI/AW7Q3OARDtA7gS3S'),
(2, 'Sarah', '2024-11-29', 0, 'Dongmo', 'Sarah', '$2y$10$MrbRYTkPIUNaHSkJz6rdpOkXMQgJdHmitbjoyb/b3HzLp0aBDzmpe'),
(3, 'Mustafa', '2024-11-29', 0, 'Yildiz', 'Mustafa', '$2y$10$zR/6J8tELzmpwnz4.0y0D.bN3geEyGZhUhTaE6zINnhtEw8mj9aqm'),
(14, 'GregLeBarbar', '2024-11-29', 0, 'Charmier', 'Grégory', '$2y$10$G/XII8Nzx5.99R41CvLouujgC8XgBO2mHtULFfR0513DvcDOzCAcC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_apprecier`
--
ALTER TABLE `t_apprecier`
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `ouvrage_id` (`ouvrage_id`) USING BTREE;

--
-- Indexes for table `t_categorie`
--
ALTER TABLE `t_categorie`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Indexes for table `t_ecrivain`
--
ALTER TABLE `t_ecrivain`
  ADD PRIMARY KEY (`ecrivain_id`);

--
-- Indexes for table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  ADD PRIMARY KEY (`ouvrage_id`),
  ADD KEY `ecrivain_id` (`ecrivain_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  ADD PRIMARY KEY (`utilisateur_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_categorie`
--
ALTER TABLE `t_categorie`
  MODIFY `categorie_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_ecrivain`
--
ALTER TABLE `t_ecrivain`
  MODIFY `ecrivain_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  MODIFY `ouvrage_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  MODIFY `utilisateur_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_apprecier`
--
ALTER TABLE `t_apprecier`
  ADD CONSTRAINT `t_apprecier_ibfk_1` FOREIGN KEY (`ouvrage_id`) REFERENCES `t_ouvrage` (`ouvrage_id`),
  ADD CONSTRAINT `t_apprecier_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `t_utilisateur` (`utilisateur_id`);

--
-- Constraints for table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  ADD CONSTRAINT `t_ouvrage_ibfk_1` FOREIGN KEY (`ecrivain_id`) REFERENCES `t_ecrivain` (`ecrivain_id`),
  ADD CONSTRAINT `t_ouvrage_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `t_utilisateur` (`utilisateur_id`),
  ADD CONSTRAINT `t_ouvrage_ibfk_3` FOREIGN KEY (`categorie_id`) REFERENCES `t_categorie` (`categorie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
