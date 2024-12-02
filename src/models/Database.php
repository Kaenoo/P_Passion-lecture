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

    /* ---------------- Fonctions (Livres) ---------------- */

    // Récupère les 5 derniers ouvrages publiés
    public function showFiveLastBooks()
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

    /* TODO: récupère la liste de tous les enseignants de la BD */
    public function searchABook()
    {
        // TODO: avoir la requête sql
        $query = "SELECT * FROM db_passion_lecture.TABLES LIMIT 0, 5;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);
    }

    /* TODO: ajouter les informations de 1 enseignant */
    public function listTitleBook()
    {
        // 
        $query = "SELECT titre FROM t_ouvrage;";

        // 
        $result = $this->querySimpleExecute($query);

        // Retourne
        return $result;
    }

    public function listAuthorBook($data)
    {
        // TODO: avoir la requête sql
        $query = "SELECT nom, prenom FROM t_ecrivain WHERE ecrivain_id = $data;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;
    }


    public function listPseudo($data)
    {
        // TODO: avoir la requête sql
        $query = "SELECT pseudo FROM t_utilisateur WHERE utilisateur_id = $data;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;
    }

    public function listCategoryBook($data)
    {
        // TODO: avoir la requête sql
        $query = "SELECT nom FROM t_categorie WHERE categorie_id = $data;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;
    }



    /* ---------------- Fonctions (Ajouter un Livre) ---------------- */
    //permet de ajouter un livre
    public function addBook($datas, $files)
    {
        // var_dump($files);
        // die();
        //$query = "INSERT INTO `t_ouvrage`(`ouvrage_id`, `titre`, `nombre_page`, `extrait`, `resume`, `date_edition`, `image_couverture`, `editeur`, `ecrivain_id`, `utilisateur_id`, `categorie_id`) VALUES ( DEFAULT , :titre, 123, 'test' ,'test' ,2024 , 'test' ,'test' ,5 ,5 ,5)";
        
        // recuperer les données
        $titre = $datas['title'];
        //$authorFirstname = $datas[''];
        //$authorLasttname = $datas['authorLastname'];
        //$categorie = $datas['category'];
        $ecrivain_id = $datas['auteur'];
        $utilisateur_id = $_SESSION['utilisateur_id'];
        $categorie_id = $datas['category_id'];
        $pages = $datas['pages'];
        //$categorie = $datas['category'];
        $extrait = $datas['extrait'];
        $editeur = $datas['publisher'];
        $dateEdition = $datas['published_date'];
        $resume = $datas['summary'];
        $image_couverture = $files['image_couverture'];
        
        $query = "INSERT INTO `t_ouvrage`(`ouvrage_id`, `titre`, `nombre_page`, `extrait`, `resume`, `date_edition`, `image_couverture`, `editeur`, `ecrivain_id`, `utilisateur_id`, `categorie_id`) VALUES (DEFAULT, :titre, :pages, :extrait, :resume, :dateEdition, :image_couverture ,:editeur ,:ecrivain_id , :utilisateur_id, :categorie_id )";

        $binds = [];
        $binds[] = [":titre", $titre, PDO::PARAM_STR];
        $binds[] = [":pages", $pages, PDO::PARAM_INT];
        $binds[] = [":extrait", $extrait, PDO::PARAM_STR];
        $binds[] = [":resume", $resume, PDO::PARAM_STR];
        $binds[] = [":dateEdition", $dateEdition, PDO::PARAM_INT];
        $binds[] = [":image_couverture", $image_couverture, PDO::PARAM_STR];
        $binds[] = [":editeur", $editeur, PDO::PARAM_STR];
        $binds[] = [":ecrivain_id", $ecrivain_id, PDO::PARAM_INT];
        $binds[] = [":utilisateur_id", $utilisateur_id, PDO::PARAM_INT];
        $binds[] = [":categorie_id", $categorie_id, PDO::PARAM_INT];
        $req = $this->queryPrepareExecute($query, $binds);

        $books = $this->formatData($req);

        echo "<pre>";
        var_dump($books);
        echo "</pre>";
    }

    // Afficher les catégories
    public function listCategoriesBook()
    {
        // TODO: avoir la requête sql
        $query = "SELECT * FROM t_categorie;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;
    }

    // Afficher les auteurs
    public function listAuthors()
    {
        // TODO: avoir la requête sql
        $query = "SELECT * FROM t_ecrivain;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;
    }
    
    // Afficher les ouvrages
    public function listOuvrages()
    {
        // TODO: avoir la requête sql
        $query = "SELECT * FROM t_ouvrage;";

        // TODO: appeler la méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // TODO: retour tous les enseignants
        return $result;
    }
    
}
