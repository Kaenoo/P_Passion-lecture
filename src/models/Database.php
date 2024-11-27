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

     /**
     * Avec query
     */
    private function querySimpleExecute($query)
    {
        // TODO: permet de pr�parer et d�ex�cuter une requ�te de type simple (sans where)
        return $this->connector->query($query);
    }
 
    /**
     * Avec prepare
     */
    private function queryPrepareExecute($query, $binds)
    {
        //permet de préparer et d'exécuter une requéte    
        $req = $this->connector->prepare($query);

        foreach($binds as $bind) {
            $req->bindValue($bind[0], $bind[1], $bind[2]);
        }
        
        $req->execute();

        return $req;
    }

    /**
     * Permet de recuperer les données dans tableau associatif
     */
    private function formatData($req)
    {
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * permet de vider
     */
    private function unsetData($req)
    {
        // Vider le jeu d'enregistrements
        return $req->closeCursor();
    }

	    /**
     * permet de recupérer les catégories
     */
    public function getAllCategorie()
    {
        $query = "SELECT * FROM t_categorie";
        $req = $this->querySimpleExecute($query);
        
        // Appeler la méthode pour avoir le résultat sous forme de tableau
        $categories = $this->formatData($req);
        
        return $categories;
    }


    // Vérifie l'existence du compte dans la DB, si c'est le cas -> return les valeurs associées
    public function verifyAccount($login, $password){

        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo and `mot_de_passe` = :password";

        $binds = [];
        $binds[] = [":pseudo", $login, PDO::PARAM_STR];
        $binds[] = [":password", $password, PDO::PARAM_STR];
        
        $req = $this->queryPrepareExecute($query, $binds);
        
        $verify = $this->formatData($req);

        if (count($verify) == 0) {
            return $verify;
        }

        return $verify[0];
    }

    // Récupère les 5 derniers ouvrages publiées
    public function showFiveLastBooks()
    {
        $query = "SELECT * FROM `t_ouvrage` ORDER BY `ouvrage_id` DESC LIMIT 5";

        $req = $this->querySimpleExecute($query);

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