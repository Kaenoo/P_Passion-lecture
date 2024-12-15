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

    // permet de recupérer les catégories
    public function getAllCategorie()
    {
        $query = "SELECT * FROM t_categorie";
        $req = $this->querySimpleExecute($query);

        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $categories = $this->formatData($req);

        return $categories;
    }

    /* ---------------- Fonctions (Compte utilisateur) ---------------- */
    // Vérifie l'existence du compte dans la DB, si c'est le cas -> return les valeurs associées
    public function verifyAccount($login, $password)
    {


        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo";

        $binds = [];
        $binds[] = [":pseudo", $login, PDO::PARAM_STR];

        $req = $this->queryPrepareExecute($query, $binds);

        $verify = $this->formatData($req);

        // Retourne false si le pseudo n'est pas trouvé ou que le mot de passe n'est pas bon
        if (count($verify) == 0) {
            return false;
        } elseif (password_verify($password, $verify[0]["mot_de_passe"]) === false) {
            return false;
        }

        return true;
    }

    // Récupère les donnéees du compte utilisateur
    public function getDataAccount($login)
    {
        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo";

        $binds = [];
        $binds[] = [":pseudo", $login, PDO::PARAM_STR];

        $req = $this->queryPrepareExecute($query, $binds);

        $verify = $this->formatData($req);


        return $verify[0];
    }

    // Vérifie si le pseudo existe dans la db
    public function verifyPseudoExistence($pseudo)
    {

        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo";

        $binds = [];
        $binds[] = [":pseudo", $pseudo, PDO::PARAM_STR];

        $req = $this->queryPrepareExecute($query, $binds);

        $verify = $this->formatData($req);

        if (count($verify) > 0) {


            return true;
        }

        return false;
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
    public function getPseudoUser($userID){
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

    // Récupère les données de l'écrivain
    public function getBookWriter($writerID){
        $query = "SELECT * FROM `t_ecrivain` WHERE `ecrivain_id` = :writerID";

        $binds = [];
        $binds[] = [":writerID", $writerID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $writer = $this->formatData($req);

        return $writer[0];
    }

    // Récupère la catégorie d'un ouvrage
    public function getBookCategory($categoryID){
        $query = "SELECT `nom` FROM `t_categorie` WHERE `categorie_id` = :categoryID";

        $binds = [];
        $binds[] = ["categoryID", $categoryID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $writer = $this->formatData($req);

        return $writer[0]["nom"];
    }

    // Récupère les catégories
    public function getCategories()
    {
        $query = "SELECT `nom` FROM `t_categorie`";
        $req = $this->querySimpleExecute($query);

        $categories = $this->formatData($req);

        return $categories;
    }

    // Supprime un ouvrage
    public function deleteBook($bookID){
        $query = "DELETE FROM t_apprecier WHERE ouvrage_id = :bookID; ";
        $query2 = "DELETE FROM t_ouvrage WHERE ouvrage_id = :bookID";

        $binds = [];
        $binds[] = ["bookID", $bookID, PDO::PARAM_INT];
        $this->queryPrepareExecute($query, $binds);
        $this->queryPrepareExecute($query2, $binds);
    }

    /* ---------------- Fonctions (Avis utilisateurs) ---------------- */

    // Récupère les notations arrondies des users sur un ouvrage
    public function getBookReviews($bookID){

        $query = "SELECT  ROUND(AVG(`note`)) FROM `t_apprecier` WHERE `ouvrage_id`= :bookID ";

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
    public function giveReviewOnABook($bookID, $userID, $note, $review){

        $query = "INSERT INTO `t_apprecier`(`ouvrage_id`, `utilisateur_id`, `note`, `commentaire`) VALUES (:bookID, :userID, :note, :review)";

        $binds = [];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];
        $binds[] = [":note", $note, PDO::PARAM_INT];
        $binds[] = [":review", $review, PDO::PARAM_STR];
        

        $this->queryPrepareExecute($query, $binds);

    }

    // Récupère tous les avis et notation d'un ouvrage
    public function getAllReviewsBook($bookID){
        $query = "SELECT `utilisateur_id`, `note`, `commentaire` FROM `t_apprecier` WHERE `ouvrage_id` = :bookID";

        $binds = [];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);
        
        $reviews = $this->formatData($req);
        

        return $reviews;
    }

    // Récupère l'avis d'un user sur un ouvrage (Si c'est le cas, il ne peut plus en poster sur celui là)
    public function userReviewBook($userID, $bookID){
        $query = "SELECT * FROM `t_apprecier` WHERE `utilisateur_id` = :userID and `ouvrage_id` = :bookID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_INT];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];
        
        $req = $this->queryPrepareExecute($query, $binds);
        
        $review = $this->formatData($req);

        if (count($review) > 0) {
            return true;
        }
        return false;

    }
	
	// Affiche les résultats de la recherche utilisateur
    public function searchBooks($search)
    {
        //$query = "SELECT * FROM db_passion_lecture.TABLES LIMIT 0, 5;";

        // $query = "SELECT DISTINCT o.titre, e.nom, e.prenom, u.pseudo, c.nom;

        //         $query = "SELECT DISTINCT o.titre, e.nom, e.prenom, u.pseudo, c.nom 
        //         FROM `t_ouvrage` o 
        //         INNER JOIN `t_ecrivain` e ON o.ecrivain_id = e.ecrivain_id 
        //         INNER JOIN `t_utilisateur` u ON o.ecrivain_id = u.utilisateur_id 
        //         INNER JOIN `t_categorie` c ON o.categorie_id = c.categorie_id 
        //         WHERE o.titre LIKE :titre
        //         OR e.nom LIKE :nom
        //         OR e.prenom LIKE :prenom
        //         OR c.nom LIKE :nom;";


        //     foreach ($search as $searching => $word)
        //     {
        //         $wording = $word . "%";
        //         $binds =
        //         [
        //             ["o.titre", $wording, PDO::PARAM_STR],
        //             ["e.nom", $wording, PDO::PARAM_STR],
        //             ["e.prenom", $wording, PDO::PARAM_STR],
        //             ["c.nom", $wording, PDO::PARAM_STR],

        //         ];
        //    }




        $query = "SELECT DISTINCT *
        FROM `t_ouvrage`
        WHERE titre LIKE :titre;";

        //$binds = [];
        foreach ($search as $searching => $word) {
            $wording = "%" . $word . "%";
            $binds =
                [
                    "titre", $wording, PDO::PARAM_STR,
                ];
        }
        // Méthode pour executer la requête
        $req = $this->queryPrepareExecute($query, $binds);

        // Mise en forme en tableau
        //$searchBooks = $this->formatData($req);

        // Retourne le résultat d'une recherche de livre
        //return $searchBooks;

        $req = $this->queryPrepareExecute($query, $binds);
        $writer = $this->formatData($req);

        return $writer;
    }

    // Liste les titres des livres
    public function listBooks()
    {
        // 
        $query = "SELECT * FROM t_ouvrage;";

        // Méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Mise en forme en tableau
        $listBooks = $this->formatData($result);

        // Retourne la liste des livres
        return $listBooks;
    }

    // Liste le noms des auteurs en fonction des livres écrits
    public function listAuthorBook($data)
    {
        // 
        $query = "SELECT nom, prenom FROM t_ecrivain WHERE ecrivain_id = $data;";

        // Méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Mise en forme en tableau
        $listAuthorBook = $this->formatData($result);

        // Retourne la liste des noms et prénoms des auteurs
        return $listAuthorBook;
    }

    // Liste le pseudo des utilisateurs en fonction des livres publiés
    public function listPseudoUser($data)
    {
        // Requête SQL
        $query = "SELECT * FROM t_utilisateur WHERE utilisateur_id = $data;";

        // Méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Mise en forme en tableau

        // Retorune les pseudos utilisateur
        return $result;
    }

    // Liste les livres selon leur catégorie
    public function listCategoryBook($data)
    {
        // TODO: avoir la requête sql
        $query = "SELECT nom FROM t_categorie WHERE categorie_id = $data;";

        // Méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Mise en forme en tableau
        $this->formatData($result);

        // Retourne la catégorie des livres
        return $result;
    }

    /* ---------------- Fonctions (Ajouter un Livre) ---------------- */
    // Permet de ajouter un livre
    public function addBook($datas, $files, $userID)
    {
        // Recuperer les données
        $titre = $datas['title'];
        $ecrivain_id = $datas['author'];
        $categorie_id = $datas['category'];
        $pages = $datas['pages'];
        $extrait = $datas['extrait'];
        $editeur = $datas['publisher'];
        $dateEdition = $datas['published_date'];
        $resume = $datas['summary'];
        $image_couverture = $files['image']['tmp_name'];

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
        $binds[] = [":image_couverture", $image_couverture, PDO::PARAM_STR];
        $binds[] = [":editeur", $editeur, PDO::PARAM_STR];
        $binds[] = [":ecrivain_id", $ecrivain_id, PDO::PARAM_INT];
        $binds[] = [":utilisateur_id", $userID, PDO::PARAM_INT];
        $binds[] = [":categorie_id", $categorie_id, PDO::PARAM_INT];

        // Méthode pour executer la requête
        $req = $this->queryPrepareExecute($query, $binds);
    }

    // Afficher les auteurs
    public function listAuthors()
    {
        // Avoir la requête sql
        $query = "SELECT * FROM t_ecrivain;";

        // Appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Retour tous les enseignants
        return $result;
    }

    // Afficher les ouvrages
    public function listCategories()
    {
        // Avoir la requête sql
        $query = "SELECT * FROM t_categorie;";

        // Appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Retour tous les enseignants
        return $result;
    }

    // Afficher les ouvrages
    public function listOuvrages()
    {
        // Avoir la requête sql
        $query = "SELECT * FROM t_ouvrage;";

        // Appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Retour tous les enseignants
        return $result;
    }
}
