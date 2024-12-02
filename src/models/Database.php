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

        
        foreach($binds as $bind) {
            $req->bindValue($bind[0], $bind[1], PDO::PARAM_INT);
        }
        
        $req->execute();
        

        return $req;
    }

    // Permet de recuperer les données dans tableau associatif
    private function formatData($req)
    {
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    // permet de vider
    private function unsetData($req)
    {
        // Vider le jeu d'enregistrements
        return $req->closeCursor();
    }

    // permet de récupérer les catégories
    public function getAllCategorie()
    {
        $query = "SELECT * FROM t_categorie";
        $req = $this->querySimpleExecute($query);
        
        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $categories = $this->formatData($req);
        
        return $categories;
    }

    /* ---------------- Fonctions (Compte utilisateur) ---------------- */

    // Vérifie l'existence du compte dans la DB
    public function verifyAccount($login, $password){


        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo";

        $binds = [];
        $binds[] = [":pseudo", $login, PDO::PARAM_STR];
        
        $req = $this->queryPrepareExecute($query, $binds);
        
        $verify = $this->formatData($req);   

        // Retourne false si le pseudo n'est pas trouvé ou que le mot de passe n'est pas bon
        if (count($verify) == 0) {
            return false;
        }
        elseif (password_verify($password, $verify[0]["mot_de_passe"]) === false) {
            return false;
        }

        return true;
    }

    // Récupère les donnéees du compte utilisateur
    public function getDataAccount($login){
        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo";

        $binds = [];
        $binds[] = [":pseudo", $login, PDO::PARAM_STR];
        
        $req = $this->queryPrepareExecute($query, $binds);
        
        $verify = $this->formatData($req);


        return $verify[0];
    }

    // Vérifie si le pseudo existe dans la db
    public function verifyPseudoExistence($pseudo){

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
    public function CreateAccount($lastName, $firstName, $pseudo, $password, $date){
        $query = "INSERT INTO `t_utilisateur` (`utilisateur_id`, `pseudo`, `date_entree`, `admin`, `nom`, `prenom`, `mot_de_passe`) VALUES (NULL, :pseudo, :date, '0', :lastName, :firstName, :password);";

        $binds = [];
        $binds[] = [":lastName", $lastName, PDO::PARAM_STR];
        $binds[] = [":firstName", $firstName, PDO::PARAM_STR];
        $binds[] = [":pseudo", $pseudo, PDO::PARAM_STR];
        $binds[] = [":password", $password, PDO::PARAM_STR];
        $binds[] = [":date", $date, PDO::PARAM_STR];
        
        $this->queryPrepareExecute($query, $binds);

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
    public function userBooks($userID){
        $query = "SELECT `ouvrage_id`, `titre`, `image_couverture` FROM `t_ouvrage` WHERE `utilisateur_id` = :userID";

        $binds = [];
        $binds[] = [":userID", $userID, PDO::PARAM_STR];

        $req = $this->queryPrepareExecute($query, $binds);

        $books = $this->formatData($req);

        return $books;

    }

    // Récupère les données d'un ouvrage 
    public function getDataBook($bookID){
        $query = "SELECT * FROM `t_ouvrage` WHERE `ouvrage_id` = :bookID";

        $binds = [];
        $binds[] = [":bookID", $bookID, PDO::PARAM_INT];

        $req = $this->queryPrepareExecute($query, $binds);

        $book = $this->formatData($req);

        return $book[0];
    }

    // Récupère les données de l'écrivain
    public function getWriter($writerID){
        $query = "SELECT * FROM `t_ecrivain` WHERE `ecrivain_id` = :writerID";
        
        $binds = [];
        $binds[] = [":writerID", $writerID, PDO::PARAM_INT];
        
        $req = $this->queryPrepareExecute($query, $binds);
        
        $writer = $this->formatData($req);
        
        return $writer[0];
    }

    // Récupère les catégories
    public function getCategories(){
        $query = "SELECT `nom` FROM `t_categorie`";
        $req = $this->querySimpleExecute($query);
        
        $categories = $this->formatData($req);
        
        return $categories;
    }
	
	/* TODO: récupère la liste de tous les enseignants de la BD */
    public function searchABook()
    {
        // TODO: avoir la requête sql
        $query = "SELECT * FROM db_passion_lecture.TABLES LIMIT 0, 5;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);
    }

    /* TODO: ajouter les informations de 1 enseignant */
    public function listTitleBook ()
    {
        // 
        $query = "SELECT titre FROM t_ouvrage;";

        // 
        $result = $this->querySimpleExecute($query);

        // Retourne
        return $result;
    }

    public function listAuthorBook ($data)
    {
        // TODO: avoir la requête sql
        $query = "SELECT nom, prenom FROM t_ecrivain WHERE ecrivain_id = $data;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;

        
    }


    public function listPseudo ($data)
    {
        // TODO: avoir la requête sql
        $query = "SELECT pseudo FROM t_utilisateur WHERE utilisateur_id = $data;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;

        
    }

    public function listCategoryBook ($data)
    {
        // TODO: avoir la requête sql
        $query = "SELECT nom FROM t_categorie WHERE categorie_id = $data;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;
    }

}