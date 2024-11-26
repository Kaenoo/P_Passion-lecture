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
        try 
        {
            $this->connector = new PDO('mysql:host=localhost:6033;dbname=db_passion_lecture;charset=utf8', 'root', 'root');
        } catch (PDOException $e) 
        {
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


    // Vérifie l'existence du compte dans la DB, si c'est le cas -> return les valeurs associées
    public function verifyAccount($login, $password)
    {

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

    public function showFiveLastBooks()
    {
        
    }
	
	// Affiche les résultats de la recherche utilisateur
    public function searchABook($search)
    {
        // TODO: avoir la requête sql
        //$query = "SELECT * FROM db_passion_lecture.TABLES LIMIT 0, 5;";

        $query = "SELECT DISTINCT o.titre, e.nom, e.prenom, u.pseudo, c.nom 
        FROM `t_ouvrage` o 
        INNER JOIN `t_ecrivain` e ON o.ecrivain_id = e.ecrivain_id 
        INNER JOIN `t_utilisateur` u ON o.ecrivain_id = u.utilisateur_id 
        INNER JOIN `t_categorie` c ON o.categorie_id = c.categorie_id 
        WHERE IF(o.titre LIKE $search, 'True', 'False') = 'True'
        OR IF(e.nom LIKE $search, 'True', 'False') = 'True'
        OR IF(e.prenom LIKE $search, 'True', 'False') = 'True'
        OR IF(c.nom LIKE $search, 'True', 'False') = 'True';";

        // Méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Mise en forme en tableau
        $searchABook = $this->formatData($result);

        // Retourne le résultat d'une recherche de livre
        return $searchABook;        
    }

    // Liste les titres des livres
    public function listBooks ()
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
    public function listAuthorBook ($data)
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
    public function listPseudoUser ($data)
    {
        // Requête SQL
        $query = "SELECT pseudo FROM t_utilisateur WHERE utilisateur_id = $data;";

        // Méthode pour executer la requête
        $result = $this->querySimpleExecute($query);

        // Mise en forme en tableau

        // Retorune les pseudos utilisateur
        return $result;
    }

    // Liste les livres selon leur catégorie
    public function listCategoryBook ($data)
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
}