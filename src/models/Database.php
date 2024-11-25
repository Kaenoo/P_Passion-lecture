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

    // Vérifie l'existence du compte dans la DB
    public function verifyAccount($login, $password){

        $query = "SELECT * FROM t_utilisateur WHERE `pseudo` = :pseudo and `mot_de_passe` = :password";

        $binds = [];
        $binds[] = [":pseudo", $login, PDO::PARAM_STR];
        $binds[] = [":password", $password, PDO::PARAM_STR];
        
        $req = $this->queryPrepareExecute($query, $binds);
        

        // if (count($req) > 2) {
        //     return true;
        // }
        
        return false;
    }

    public function showFiveLastBooks()
    {
        
    }

}