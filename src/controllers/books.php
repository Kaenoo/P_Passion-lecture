<?php
include_once("./models/Database.php");

class booksController {
    private $db;

    // Constructeur
    public function __construct() {
        $this->db = new Database();
    }

    // Retourne les données des 5 derniers ouvrages
    public function FiveLastBooks() {
        return $this->db->getFiveLastBooks();
    }


    // Prépare la présentation des ouvrages en isolant le titre et l'image
    public function booksPresentation(){
    $content[] = [];
    
    foreach ($this->FiveLastBooks() as $key => $book) {
        $content[$key][0] = $book["ouvrage_id"];
        $content[$key][1] = $book["titre"];
        $content[$key][2] = $book["image_couverture"];
    }
    return $content;
    }

    // Supprime un ouvrage
    public function delete($bookID){
        $this->db->deleteBook($bookID);
    }

    // Vérifie si l'user a publié des ouvrages
    public function userHaveBooks($userID){
        $content = $this->db->userBooks($userID);
    
        if (count($content) > 0) {
            return true;
        }
    
        return false;
    }

    // Retourne les ouvrages de l'user et les prépare à la présentation
    public function showMyBooks($userID){

        $content[] = [];

        foreach ($this->db->userBooks($userID) as $key => $book) {
            $content[$key][0] = $book["ouvrage_id"];
            $content[$key][1] = $book["titre"];
            $content[$key][2] = $book["image_couverture"];
            
        }
        
        return $content;
    }

    // Retourne les données d'un ouvrage
    public function dataBook($bookID){
        return $this->db->getDataBook($bookID);
    }

    // Retourne le nom et prénom de l'écrivain
    public function writerBook($writerID){

        $content = $this->db->getBookWriter($writerID);
        
        $writerName = $content["prenom"] . " " . $content["nom"];

        return $writerName;
    }

    // Retourne la catégorie d'un ouvrage
    public function categoryBook($categoryID){
        return $this->db->getBookCategory($categoryID);
    }

    // Retourne les catégories
    public function categories(){
        return $this->db->getAllCategories();
    }

    // Retourne tous les éditeurs
    public function editors(){
        return $this->db->getAllEditors();
    }

    // Retourne tous les éditeurs
    public function authors(){
        return $this->db->getAllAuthors();
    }

    // Ajoute un auteur dans la db
    public function updateAuthor($surname, $forename){
        return $this->db->addAuteur($surname, $forename);
    }

    // Ajoute une catégorie dans la db
    public function updateCategory($categoryName){
        return $this->db->addCategory($categoryName);
    }

     // Ajoute une catégorie dans la db
     public function updateBook($data, $files, $userID){
        return $this->db->addBook($data, $files, $userID);
    }

    // Supprime la page de couverture d'un ouvrage supprimé -> répertoire imgCoverBook
    public function deleteImgCoverBook($path){
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
?>