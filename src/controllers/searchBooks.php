<!-- 
Auteur : Kaeno Eyer
Date : 07.01.2025
Description :  Controller de tout ce qui concerne les recherches
-->

<?php
include_once("./models/Database.php");

class searchBooksController {
    private $db;

    // Constructeur
    public function __construct() {
        $this->db = new Database();
    }

    // Compte le nombre de livre selon la recherche utilisateur
    public function RowsNumberOfSearch($search){
        return $this->db->getRowsNumberOfSearch($search);
    }

    // Compte le nombre de livre selon la recherche utilisateur
    public function rowsNumberOfList(){
        return $this->db->getRowsNumberOfList();
    }

}