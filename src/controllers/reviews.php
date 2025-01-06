<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Controller de tout ce qui concerne les avis
-->
<?php
include_once("./models/Database.php");

class reviewController{
    
    private $db;

    // Constructeur
    public function __construct() {
        $this->db = new Database();
    }


    // Retourne la note d'un ouvrage
    public function bookReview($bookID){
        return $this->db->getBookReviews($bookID);
    }

    // Intègre dans la db un nouvel avis sur un ouvrage
    public function giveReview($bookID, $userID, $note, $review){
        $this->db->giveReviewOnABook($bookID, $userID, $note, $review);
    }

    // Retourne tous les avis et notes d'un ouvrage
    public function allReviewsBook($bookID){
        return $this->db->getAllReviewsBook($bookID);
    }

    // Retourne un bool vérifiant si l'user a déjà posté un avis sur un ouvrage
    public function verifyReviewUser($userID, $bookID){
        return $this->db->userReviewBook($userID, $bookID);
    }

}

?>