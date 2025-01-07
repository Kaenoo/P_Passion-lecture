<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Connection db
 */
class Database
{

    // Attribut de classe
    private $connector;

    public function __construct()
    {
        // Se connecter via PDO et utilise la variable de classe $connector
        try {
            $this->connector = new PDO('mysql:host=localhost:6033;dbname=db_passion_lecture;charset=utf8', 'root', 'root');
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Avec query
    private function querySimpleExecute($query)
    {
        // permet de préparer et d'executer une requéte de type simple (sans where)
        return $this->connector->query($query);
    }

    // Avec prepare
    private function queryPrepareExecute($query, $binds)
    {
        //permet de préparer et d'exécuter une requéte    
        $req = $this->connector->prepare($query);

        foreach ($binds as $bind) {
            $req->bindValue($bind[0], $bind[1], $bind[2]);
        }

        $req->execute();

        return $req;
    }

    // Permet de recuperer les données dans tableau associatif
    private function formatData($req)
    {
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Permet de vider
    private function unsetData($req)
    {
        // Vider le jeu d'enregistrements
        return $req->closeCursor();
    }


    /* ---------------- Fonctions (Compte utilisateur) ---------------- */
    // Vérifie l'existence du compte dans la DB, si c'est le cas -> return les valeurs associées
    public function checkAccount($login, $password)
    {
        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo";

        $binds = [];
        $binds[] = [":pseudo", $login, PDO::PARAM_STR];

        $req = $this->queryPrepareExecute($query, $binds);

        $verify = $this->formatData($req);

       return $verify;
    }

    // Récupère les donnéees du compte utilisateur
    public function getDataAccount($pseudo)
    {
        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo";

        $binds = [];
        $binds[] = [":pseudo", $pseudo, PDO::PARAM_STR];

        $req = $this->queryPrepareExecute($query, $binds);

        $verify = $this->formatData($req);

        if (count($verify) === 0) {
            return null;
        }

        return $verify[0];
    }

    // Vérifie les droits d'un user
    public function getUserRight($userID)
    {
        $query = "SELECT `admin` FROM `t_utilisateur` WHERE `utilisateur_id` = :userID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $right = $this->formatData($req);

        return $right[0]["admin"];
    }

    // Récupère le mot de passe haché d'un user
    public function getPasswordUser($userID)
    {
        $query = "SELECT `mot_de_passe` FROM `t_utilisateur` WHERE `utilisateur_id` = :userID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $password = $this->formatData($req);

        return $password[0]["mot_de_passe"];
    }

    // Change le mot de passe d'un user
    public function changePassword($userID, $newPassword)
    {
        $query = "UPDATE `t_utilisateur` SET `mot_de_passe` = :newPassword WHERE `utilisateur_id` = :userID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];
        $binds[] = [":newPassword", $newPassword, PDO::PARAM_STR];

        $this->queryPrepareExecute($query, $binds);

    }

    // Change les donnnées personnelles de l'user
    public function changeDataUser($userID, $surname, $forename, $pseudo)
    {
        $query = "UPDATE `t_utilisateur` SET `pseudo`= :pseudo,`nom`= :surname,`prenom`= :forename WHERE `utilisateur_id` = :userID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];
        $binds[] = [":surname", $surname, PDO::PARAM_STR];
        $binds[] = [":forename", $forename, PDO::PARAM_STR];
        $binds[] = [":pseudo", $pseudo, PDO::PARAM_STR];

        $this->queryPrepareExecute($query, $binds);
    }

    // Créer un compte à l'user
    public function CreateAccount($lastName, $firstName, $pseudo, $password, $date)
    {
        $query = "INSERT INTO `t_utilisateur` (`utilisateur_id`, `pseudo`, `date_entree`, `admin`, `nom`, `prenom`, `mot_de_passe`) VALUES (NULL, :pseudo, :date, '0', :lastName, :firstName, :password);";

        $binds = [];
        $binds[] = [":lastName", $lastName, PDO::PARAM_STR];
        $binds[] = [":firstName", $firstName, PDO::PARAM_STR];
        $binds[] = [":pseudo", $pseudo, PDO::PARAM_STR];
        $binds[] = [":password", $password, PDO::PARAM_STR];
        $binds[] = [":date", $date, PDO::PARAM_STR];

        $this->queryPrepareExecute($query, $binds);
    }

    // Récupère le pseudo d'un user
    public function getPseudoUser($userID)
    {
        $query = "SELECT `pseudo` FROM `t_utilisateur` WHERE `utilisateur_id` = :userID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $pseudo = $this->formatData($req);

        return $pseudo[0]["pseudo"];
    }

    /* ---------------- Fonctions (Livres) ---------------- */

    // Récupère les 5 derniers ouvrages publiés
    public function getFiveLastBooks()
    {
        $query = "SELECT * FROM `t_ouvrage` ORDER BY `ouvrage_id` DESC LIMIT 5";

        $req = $this->querySimpleExecute($query);

        $books = $this->formatData($req);

        return $books;
    }

    // Récupère les ouvrages publiés par l'user 
    public function userBooks($userID)
    {
        $query = "SELECT `ouvrage_id`, `titre`, `image_couverture` FROM `t_ouvrage` WHERE `utilisateur_id` = :userID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_STR];

        $req = $this->queryPrepareExecute($query, $binds);

        $books = $this->formatData($req);

        return $books;
    }

    // Récupère les données d'un ouvrage 
    public function getDataBook($bookID)
    {
        $query = "SELECT * FROM `t_ouvrage` WHERE `ouvrage_id` = :bookID";

        $binds = [];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $book = $this->formatData($req);

        return $book[0];
    }

    // Récupère la catégorie d'un ouvrage
    public function getBookCategory($categoryID)
    {
        $query = "SELECT `nom` FROM `t_categorie` WHERE `categorie_id` = :categoryID";

        $binds = [];
        $binds[] = ["categoryID", $categoryID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $writer = $this->formatData($req);

        return $writer[0]["nom"];
    }

    // Récupère toutes les catégories
    public function getAllCategories()
    {
        $query = "SELECT * FROM `t_categorie` order by `nom` ASC";
        $req = $this->querySimpleExecute($query);

        $categories = $this->formatData($req);

        return $categories;
    }    

    // Supprime un ouvrage
    public function deleteBook($bookID)
    {
        $query = "DELETE FROM t_apprecier WHERE ouvrage_id = :bookID ";
        $query2 = "DELETE FROM t_ouvrage WHERE ouvrage_id = :bookID";

        $binds = [];
        $binds[] = ["bookID", $bookID, PDO::PARAM_INT];
        $this->queryPrepareExecute($query, $binds);
        $this->queryPrepareExecute($query2, $binds);
    }

    /* ---------------- Fonctions (Avis utilisateurs) ---------------- */

    // Récupère les notations arrondies des users sur un ouvrage
    public function getBookReviews($bookID)
    {

        $query = "SELECT  ROUND(AVG(`note`)) FROM `t_apprecier` WHERE `ouvrage_id`= :bookID";

        $binds = [];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $review = $this->formatData($req);

        if (count($review) === 0) {
            return null;
        }

        return $review[0]["ROUND(AVG(`note`))"];
    }

    // Donne une notation et un avis d'un user sur un ouvrage
    public function giveReviewOnABook($bookID, $userID, $note, $review)
    {
        $query = "INSERT INTO `t_apprecier`(`ouvrage_id`, `utilisateur_id`, `note`, `commentaire`) VALUES (:bookID, :userID, :note, :review)";

        $binds = [];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];
        $binds[] = [":note", $note, PDO::PARAM_INT];
        $binds[] = [":review", $review, PDO::PARAM_STR];

        $this->queryPrepareExecute($query, $binds);
    }

    // Récupère tous les avis et notation d'un ouvrage
    public function getAllReviewsBook($bookID)
    {
        $query = "SELECT `utilisateur_id`, `note`, `commentaire` FROM `t_apprecier` WHERE `ouvrage_id` = :bookID";

        $binds = [];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $reviews = $this->formatData($req);

        return $reviews;
    }

    // Récupère l'avis d'un user sur un ouvrage (Si c'est le cas, il ne peut plus en poster sur celui là)
    public function userReviewBook($userID, $bookID)
    {
        $query = "SELECT * FROM `t_apprecier` WHERE `utilisateur_id` = :userID and `ouvrage_id` = :bookID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $review = $this->formatData($req);

        if (count($review) > 0) 
        {
            return true;
        }
        return false;
    }

    /* ---------------- Fonctions (Recherche utilisateurs) ---------------- */

    // Affiche les résultats de la recherche utilisateur
    public function getSearchBooks($search, $index, $limit)
    {
        $query = "SELECT DISTINCT *
        FROM `t_ouvrage` o 
        INNER JOIN `t_ecrivain` e ON o.ecrivain_id = e.ecrivain_id 
        INNER JOIN `t_categorie` c ON o.categorie_id = c.categorie_id 
        WHERE (o.titre LIKE :o_titre
        OR e.nom LIKE :e_nom
        OR e.prenom LIKE :e_prenom)
        AND c.nom LIKE :c_nom LIMIT $index, $limit;";


        $word = "%" . $search["search"] . "%";

        $categorie = "%%";

        if ($search["categorie"] != "Filtre") 
        {
            $categorie = $search["categorie"];
        }

        $binds =
        [
            ["o_titre", $word, PDO::PARAM_STR],
            ["e_nom", $word, PDO::PARAM_STR],
            ["e_prenom", $word, PDO::PARAM_STR],
            ["c_nom", $categorie, PDO::PARAM_STR],
        ];

        $req = $this->queryPrepareExecute($query, $binds);

        $getSearchBooks = $this->formatData($req);

        return $getSearchBooks;
    }

    // Compte le nombre de livre selon la recherche utilisateur
    public function getRowsNumberOfSearch($search)
    {
        $query = "SELECT COUNT(*)
        FROM `t_ouvrage` o 
        INNER JOIN `t_ecrivain` e ON o.ecrivain_id = e.ecrivain_id 
        INNER JOIN `t_categorie` c ON o.categorie_id = c.categorie_id 
        WHERE (o.titre LIKE :o_titre
        OR e.nom LIKE :e_nom
        OR e.prenom LIKE :e_prenom)
        AND c.nom LIKE :c_nom;";


        $word = "%" . $search["search"] . "%";

        $categorie = "%%";

        if ($search["categorie"] != "Filtre") 
        {
            $categorie = $search["categorie"];
        }

        $binds =
        [
            ["o_titre", $word, PDO::PARAM_STR],
            ["e_nom", $word, PDO::PARAM_STR],
            ["e_prenom", $word, PDO::PARAM_STR],
            ["c_nom", $categorie, PDO::PARAM_STR],
        ];

        $req = $this->queryPrepareExecute($query, $binds);

        $count = $req->fetchColumn();

        return $count;
    }

    // Compte le nombre de livre de l'affichage par défaut
    public function getRowsNumberOfList()
    {
        $query = "SELECT COUNT(*) FROM `t_ouvrage`;";
        $req = $this->querySimpleExecute($query);
        $count = $req->fetchColumn();

        return $count;
    }

    // Affiche le titre d'un livre
    public function getListBooks($min, $max)
     {
        $query = "SELECT * FROM t_ouvrage LIMIT $min, $max;";

        $result = $this->querySimpleExecute($query);

        $getListBooks = $this->formatData($result);

        return $getListBooks;
    }

    // Affiche les données d'un auteur
    public function listAuthorBook($data)
    {
        $query = "SELECT * FROM t_ecrivain WHERE ecrivain_id = :ecrivain_id;";

        $binds = [];
        $binds [] = ["ecrivain_id", $data, PDO::PARAM_STR];

        $result = $this->queryPrepareExecute($query, $binds);

        $listAuthorBook = $this->formatData($result);

        // Retourne la liste des noms et prénoms des auteurs
        return $listAuthorBook[0];
    }

    // Affiche le pseudo d'un utilisateur
    public function getListPseudoUser($data)
    {
        $query = "SELECT * FROM t_utilisateur WHERE utilisateur_id = :utilisateur_id;";

        $binds = [];
        $binds [] = ["utilisateur_id", $data, PDO::PARAM_STR];

        $result = $this->queryPrepareExecute($query, $binds);

        $getListPseudoUser = $this->formatData($result);

        return $getListPseudoUser[0];
    }

    // Affiche le résumé d'un livre
    public function getListSummaryBook($data)
    {
        $query = "SELECT SUBSTR(resume, 1,100) AS resume FROM `t_ouvrage` WHERE ouvrage_id = :ouvrage_id;";

        $binds = [];
        $binds [] = ["ouvrage_id", $data, PDO::PARAM_STR];

        $result = $this->queryPrepareExecute($query, $binds);

        $getListSummaryBook = $this->formatData($result);

        return $getListSummaryBook[0];
    }

    /* ---------------- Fonctions (Ajouter un Livre) ---------------- */
    // Ajoute un ouvrage
    public function addBook($data, $destinationFile, $userID)
    {
        // Récupère les données
        $titre = $data['title'];
        $ecrivain_id = $data['author'];
        $categorie_id = $data['category'];
        $pages = $data['pages'];
        $extrait = $data['extrait'];
        $editeur = $data['publisher'];
        $dateEdition = $data['published_date'];
        $resume = $data['summary'];

        // Avoir la requête sql
        $query = "INSERT INTO `t_ouvrage`(`ouvrage_id`, `titre`, `nombre_page`, `extrait`, `resume`, `date_edition`, `image_couverture`, `editeur`, `ecrivain_id`, `utilisateur_id`, `categorie_id`) 
                                VALUES (DEFAULT, :titre, :pages, :extrait, :resume, :dateEdition, :image_couverture ,:editeur ,:ecrivain_id , :utilisateur_id, :categorie_id )";

        // Avoir la list PDO pour requête prépare sql
        $binds = [];
        $binds[] = [":titre", $titre, PDO::PARAM_STR];
        $binds[] = [":pages", $pages, PDO::PARAM_INT];
        $binds[] = [":extrait", $extrait, PDO::PARAM_STR];
        $binds[] = [":resume", $resume, PDO::PARAM_STR];
        $binds[] = [":dateEdition", $dateEdition, PDO::PARAM_INT];
        $binds[] = [":image_couverture", $destinationFile, PDO::PARAM_STR];
        $binds[] = [":editeur", $editeur, PDO::PARAM_STR];
        $binds[] = [":ecrivain_id", $ecrivain_id, PDO::PARAM_INT];
        $binds[] = [":utilisateur_id", $userID, PDO::PARAM_INT];
        $binds[] = [":categorie_id", $categorie_id, PDO::PARAM_INT];

        // Méthode pour executer la requête
        $this->queryPrepareExecute($query, $binds);
    }


    // Modifie un ouvrage
    public function editBook($data, $destinationFile, $userID)
    {
        // Recuperer les données
        $id_ouvrage = $data['ouvrage_id'];
        $titre = $data['title'];
        $ecrivain_id = $data['author'];
        $categorie_id = $data['category'];
        $pages = $data['pages'];
        $extrait = $data['extrait'];
        $editeur = $data['publisher'];
        $dateEdition = $data['published_date'];
        $resume = $data['summary'];

        // Avoir la requête sql
        $query = "UPDATE `t_ouvrage` SET `titre`=:titre,`nombre_page`=:pages,`extrait`=:extrait,`resume`=:resume,`date_edition`=:dateEdition,`image_couverture`=:image_couverture,`editeur`=:editeur,`ecrivain_id`=:ecrivain_id,`utilisateur_id`=:utilisateur_id,`categorie_id`=:categorie_id WHERE `ouvrage_id`= :ouvrage_id";

        // Avoir la list PDO pour requête prépare sql
        $binds = [];
        $binds[] = [":ouvrage_id", $id_ouvrage, PDO::PARAM_INT];
        $binds[] = [":titre", $titre, PDO::PARAM_STR];
        $binds[] = [":pages", $pages, PDO::PARAM_INT];
        $binds[] = [":extrait", $extrait, PDO::PARAM_STR];
        $binds[] = [":resume", $resume, PDO::PARAM_STR];
        $binds[] = [":dateEdition", $dateEdition, PDO::PARAM_INT];
        $binds[] = [":image_couverture", $destinationFile, PDO::PARAM_STR];
        $binds[] = [":editeur", $editeur, PDO::PARAM_STR];
        $binds[] = [":ecrivain_id", $ecrivain_id, PDO::PARAM_INT];
        $binds[] = [":utilisateur_id", $userID, PDO::PARAM_INT];
        $binds[] = [":categorie_id", $categorie_id, PDO::PARAM_INT];

        // Méthode pour executer la requête
        $this->queryPrepareExecute($query, $binds);
    }

    // Récupère tous les auteurs
    public function getAllAuthors()
    {
        $query = "SELECT * FROM `t_ecrivain`ORDER BY `prenom` ASC";

        $req = $this->querySimpleExecute($query);

        $authors = $this->formatData($req);

        // Retourne tous les auteurs
        return $authors;
    }

    // Ajoute un auteur
    public function addAuteur($surname, $forename)
    {
        $query = "INSERT INTO `t_ecrivain`(`ecrivain_id`, `nom`, `prenom`) VALUES (DEFAULT,:nom,:prenom)";

        $binds = [];
        $binds[] = [":nom", $surname, PDO::PARAM_STR];
        $binds[] = [":prenom", $forename, PDO::PARAM_STR];

        // Méthode pour éxecuter la requête
        $this->queryPrepareExecute($query, $binds);
    }

    // Ajoute une catégorie
    public function addCategory($categoryName)
    {
        // Avoir la requête sql
        $query = "INSERT INTO `t_categorie`(`categorie_id`, `nom`) VALUES (DEFAULT,:nom)";

        // Avoir la list PDO pour requête prépare sql
        $binds = [];
        $binds[] = [":nom", $categoryName, PDO::PARAM_STR];

        // Méthode pour executer la requête
        $this->queryPrepareExecute($query, $binds);
    }

    // Récupère les éditeurs
    public function getAllEditors()
    {
        // Avoir la requête sql
        $query = "SELECT DISTINCT `editeur` FROM `t_ouvrage`";

        // Appeler la méthode pour executer la requête
        $req = $this->querySimpleExecute($query);

        $editors = $this->formatData($req);

        // Retour tous les enseignants
        return $editors;
    }
}