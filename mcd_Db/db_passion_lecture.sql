-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db:3306
-- Généré le : ven. 13 déc. 2024 à 20:22
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
-- Base de données : `db_passion_lecture`
--
CREATE DATABASE IF NOT EXISTS `db_passion_lecture` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_passion_lecture`;

-- --------------------------------------------------------

--
-- Structure de la table `t_apprecier`
--

CREATE TABLE `t_apprecier` (
  `ouvrage_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `note` tinyint DEFAULT NULL,
  `commentaire` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `t_apprecier`
--

INSERT INTO `t_apprecier` (`ouvrage_id`, `utilisateur_id`, `note`, `commentaire`) VALUES
(3, 1, 3, 'Bof, sans plus.\r\nLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit esse dolores ipsam qui voluptatem distinctio accusamus, at id possimus assumenda voluptate eum culpa molestias totam incidunt, aut quis repellat voluptatum.'),
(18, 1, 5, 'Personnage attachant');

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
(3, 'Biographie'),
(4, 'Roman'),
(5, 'Bande dessinée'),
(6, 'Manga'),
(7, 'Philosophie');

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
(4, 'Levi', 'Primo'),
(5, 'Hugo', 'Victor'),
(6, 'Austen', 'Jane'),
(7, 'Dumas', 'Alexandre'),
(8, 'Rowling', 'J.K.'),
(9, 'Orwell', 'George'),
(10, 'Camus', 'Albert'),
(11, 'Oda', 'Eiichiro'),
(12, 'Miller', 'Frank'),
(13, 'Kishimoto', 'Masashi'),
(14, 'Toriyama', 'Akira'),
(15, 'Ohba', 'Tsugumi'),
(16, 'Tabata', 'Yūki'),
(17, 'Loeb', 'Jeph'),
(18, 'Moore', 'Alan'),
(19, 'Kubo', 'Tite'),
(20, 'Claremont', 'Chris');

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
  `date_edition` int DEFAULT NULL,
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
(1, 'Fondation', 255, 'Un extrait passionnant...', 'Isaac Asimov nous entraîne dans une galaxie en déclin, où un mathématicien visionnaire, Hari Seldon, utilise la psychohistoire pour prédire l’effondrement imminent de l’Empire Galactique. Il crée une Fondation sur une planète reculée pour préserver le savoir humain et réduire les âges sombres à venir. Ce récit explore la politique, la science et les luttes de pouvoir dans un univers complexe, tout en interrogeant la capacité de l\'humanité à modeler son destin.', 1951, './imgCoverBook/isaac_Asimov_Fondation.jpg', 'Gnome Press', 1, 1, 1),
(2, 'Le Seigneur des Anneaux', 1178, 'https://www.tolkiendil.com/_media/tolkien/biblio/excerpt_dt.pdf', 'Cette épopée de J.R.R. Tolkien suit la quête de Frodon Sacquet, chargé de détruire l\'Anneau Unique, un artefact maléfique forgé par Sauron. Accompagné par la Communauté de l’Anneau, il traverse des terres magnifiques et périlleuses, tout en affrontant des créatures mythiques et ses propres doutes. Cette œuvre magistrale célèbre l\'amitié, le courage et la lutte contre les ténèbres.', 1954, './imgCoverBook/Le_Seigneur_Des_Anneaux.jpg', 'Allen & Unwin', 2, 2, 2),
(3, 'Une Terre Promise', 768, 'https://blog.connectinstitute.ma/wp-content/uploads/2020/12/Barack-Obama-Une-terre-promise.pdf', 'Barack Obama nous plonge dans son parcours intime et politique, de son enfance à sa première élection présidentielle. Il décrit les défis et décisions majeures de son mandat, avec des réflexions sur la démocratie, la justice et l’espoir. Ce livre est un portrait sincère d’un leader face aux réalités complexes du pouvoir.', 2020, './imgCoverBook/Une-terre-promise.jpg', 'Crown', 3, 1, 3),
(6, 'Les Naufragés et les Rescapés', 203, 'Une réflexion profonde...', 'Cet essai de Levi analyse les mécanismes de l’Holocauste et ses impacts durables. Il interroge les responsabilités et les silences autour de cette tragédie, offrant une réflexion éthique sur la mémoire collective.', 1986, './imgCoverBook/Les_naufrages_et_les_rescapes.jpg', 'Einaudi', 4, 2, 3),
(7, 'Les Misérables', 1232, 'https://clg-mpagnol.sarthe.e-lyco.fr/wp-content/uploads/sites/46/2020/03/4A_4E_FR_Sqce5_S2_LaMortDe.JV_.pdf', 'Victor Hugo tisse une fresque magistrale de la société française du XIXᵉ siècle. À travers les destins croisés de Jean Valjean, Cosette et Javert, il explore la justice, la misère et la rédemption, tout en dénonçant les injustices sociales de son temps.', 2009, './imgCoverBook/les_miserables.jpg', 'Pocket', 5, 3, 4),
(8, 'Harry Potter à l\'école des sorciers', 309, 'https://bloc-note.ac-reunion.fr/stdenis5-application-bellepierre/files/2020/03/2-extrait-du-chapitre-7-de-Harry-Potter-à-lécole-des-sorciers.pdf', 'J.K. Rowling présente Harry Potter, un orphelin découvrant qu’il est un sorcier. Entre l’apprentissage de la magie à Poudlard et la découverte de son passé, il affronte le mage noir Voldemort, lançant une saga captivante d’amitié et de courage.', 1997, './imgCoverBook/harry-potter-a-l-ecole-des-sorciers.jpeg', 'Bloomsbury', 8, 3, 2),
(9, '1984', 328, 'https://ww2.ac-poitiers.fr/histoire-arts/sites/histoire-arts/IMG/pdf/extrait_1984_Orwell.pdf', 'George Orwell imagine un monde dystopique où Big Brother contrôle tout. Dans cette société totalitaire, la pensée est surveillée et manipulée. Winston Smith, le protagoniste, tente de résister à ce régime oppressif, mais à quel prix ?', 1949, './imgCoverBook/1984_George_orwell.jpg', 'Secker & Warburg', 9, 2, 1),
(10, 'L\'Étranger', 123, 'http://lettres.lem.online.fr/seconde/camus/camus_etranger_chap6_fin_1erepartie.pdf', 'Albert Camus raconte l’histoire de Meursault, un homme détaché du monde, qui commet un meurtre absurde. Ce roman explore l’absurdité de la vie et la quête de sens dans une société normative.', 1942, './imgCoverBook/L-Etranger.jpg', 'Gallimard', 10, 14, 7),
(18, 'One Piece', 100, 'Un extrait captivant.', 'Luffy, un jeune garçon rêvant de devenir le Roi des Pirates, part en quête du légendaire trésor, le One Piece. Accompagné d\'un équipage coloré, il affronte des ennemis redoutables et explore des îles mystérieuses. Luffy, doté de pouvoirs élastiques grâce au fruit du démon Gomu Gomu, doit surmonter des obstacles et découvrir les secrets du monde. Ce manga mêle aventure, camaraderie et détermination dans un univers riche et captivant.', 1997, './imgCoverBook/one_piece_1_edition_shueisha.webp', 'Shueisha', 11, 1, 6),
(19, 'Batman: Year One', 128, 'Un extrait fascinant.', 'Cette bande dessinée explore les débuts de Bruce Wayne en tant que Batman, alors qu’il lutte pour imposer la justice dans une Gotham gangrenée par le crime. En parallèle, Jim Gordon, nouvellement arrivé, tente de s’intégrer tout en combattant la corruption dans la police. Ensemble, ils forment une alliance fragile pour rétablir l’ordre. Ce récit offre une perspective sombre et réaliste sur la genèse du Chevalier Noir.', 1987, './imgCoverBook/batman_year_one.jpg', 'DC Comics', 12, 1, 5),
(31, 'Naruto', 220, 'Un extrait épique.', 'Naruto Uzumaki, un jeune ninja en quête de reconnaissance, rêve de devenir Hokage, le chef de son village. Portant en lui le démon-renard à neuf queues, il doit surmonter le rejet des autres tout en apprenant à maîtriser ses pouvoirs. Entre entraînements, missions et batailles épiques, Naruto tisse des liens précieux avec ses amis et découvre le véritable sens de la force et de la persévérance.', 1999, './imgCoverBook/naruto-1-kana.jpg', 'Shueisha', 13, 2, 6),
(32, 'Dragon Ball', 519, 'Un extrait légendaire.', 'Suivez Son Goku, un garçon à la force surhumaine, dans sa quête des Dragon Balls, des artefacts capables d’exaucer n’importe quel souhait. Avec ses amis, il affronte des ennemis redoutables et participe à des tournois de combat intenses. Ce récit mêle action, humour et aventure dans un univers fantastique où le courage et l’amitié triomphent toujours.', 1984, './imgCoverBook/dragon-ball-super-livre-1-glenat.jpg', 'Shueisha', 14, 3, 6),
(33, 'Death Note', 108, 'Un extrait intrigant.', 'Light Yagami, un étudiant brillant, découvre le Death Note, un cahier qui permet de tuer quiconque en inscrivant son nom. Décidé à purifier le monde des criminels, Light devient Kira, un justicier redouté. Mais son pouvoir attire l’attention du détective génial L, menant à une bataille psychologique et stratégique intense. Ce thriller explore les limites de la justice et les conséquences du pouvoir absolu.', 2003, './imgCoverBook/death_note.webp', 'Shueisha', 15, 14, 6),
(39, 'Black Clover', 200, 'Un extrait magique.', 'Asta, un jeune orphelin dépourvu de magie dans un monde où celle-ci règne, rêve de devenir Empereur Mage. Avec son ami et rival Yuno, il découvre un mystérieux grimoire doté d’un pouvoir anti-magie. Entre combats, entraînements et découvertes, Asta doit prouver sa valeur et surmonter de nombreux obstacles pour réaliser son rêve et protéger ses amis.', 2015, './imgCoverBook/manga-black-clover-vol-1-simple.jpg', 'Shueisha', 16, 1, 6),
(40, 'Spider-Man: Blue', 144, 'Un extrait nostalgique.', 'Peter Parker, alias Spider-Man, revisite ses souvenirs de jeunesse et son premier amour, Gwen Stacy. À travers ses combats contre des ennemis emblématiques, il exprime sa nostalgie et sa douleur face à sa perte. Ce récit introspectif et émotionnel explore les sacrifices d’un héros et les moments tendres qui définissent son humanité.', 2002, './imgCoverBook/spiderman_blue.jpg', 'Marvel Comics', 17, 2, 5),
(41, 'Watchmen', 416, 'Un extrait captivant.', 'Dans une Amérique alternative des années 1980, les super-héros sont des individus brisés, confrontés à leurs échecs et à la décadence du monde. Quand l’un d’eux est assassiné, une enquête dévoile un complot global menaçant l’humanité. Ce chef-d\'œuvre sombre et complexe redéfinit le genre des super-héros, explorant des thèmes de pouvoir, de morale et d’humanité.', 1986, './imgCoverBook/WATCHMEN-Tome-0.jpg', 'DC Comics', 18, 3, 5),
(42, 'Bleach', 366, 'Un extrait surnaturel.', 'Ichigo Kurosaki, un lycéen capable de voir les esprits, devient un Shinigami après avoir rencontré Rukia Kuchiki. Chargé de protéger les vivants des Hollows, des âmes corrompues, il découvre un monde rempli de mystères et de conflits. Entre devoirs, amitié et affrontements épiques, Ichigo doit se battre pour rétablir l\'équilibre entre les mondes.', 2001, './imgCoverBook/bleach_01.jpg', 'Shueisha', 19, 14, 5),
(43, 'X-Men: God Loves, Man Kills', 128, 'Un extrait profond.', 'Les X-Men font face au fanatique William Stryker, un prédicateur qui prêche la haine envers les mutants. Cette histoire aborde la discrimination, l’acceptation et les luttes pour les droits de ceux qui sont différents. Les X-Men doivent unir leurs forces pour protéger les innocents et démontrer que l’espoir et la tolérance peuvent triompher du fanatisme.', 1982, './imgCoverBook/x-men_God_loves_Man_kills.jpg', 'Marvel Comics', 20, 1, 6);

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
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `t_utilisateur`
--

INSERT INTO `t_utilisateur` (`utilisateur_id`, `pseudo`, `date_entree`, `admin`, `nom`, `prenom`, `mot_de_passe`) VALUES
(1, 'Kaeno', '2024-11-29', 1, 'Eyer', 'Kaeno', '$2y$10$KNiOZTUytSh2z9Pjb0XQcOekpu.y/LAoYOvI/AW7Q3OARDtA7gS3S'),
(2, 'Sarah', '2024-11-29', 0, 'Dongmo', 'Sarah', '$2y$10$MrbRYTkPIUNaHSkJz6rdpOkXMQgJdHmitbjoyb/b3HzLp0aBDzmpe'),
(3, 'Mustafa', '2024-11-29', 0, 'Yildiz', 'Mustafa', '$2y$10$zR/6J8tELzmpwnz4.0y0D.bN3geEyGZhUhTaE6zINnhtEw8mj9aqm'),
(14, 'GregLeBarbar', '2024-11-29', 0, 'Charmier', 'Grégory', '$2y$10$G/XII8Nzx5.99R41CvLouujgC8XgBO2mHtULFfR0513DvcDOzCAcC');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_apprecier`
--
ALTER TABLE `t_apprecier`
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `ouvrage_id` (`ouvrage_id`) USING BTREE;

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
  MODIFY `categorie_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `t_ecrivain`
--
ALTER TABLE `t_ecrivain`
  MODIFY `ecrivain_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `t_ouvrage`
--
ALTER TABLE `t_ouvrage`
  MODIFY `ouvrage_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `t_utilisateur`
--
ALTER TABLE `t_utilisateur`
  MODIFY `utilisateur_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
