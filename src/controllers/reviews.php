<?php
// Retourne la note d'un ouvrage
function bookReview($db, $bookID){
    return $db->getBookReviews($bookID);
}

// Intègre dans la db un nouvel avis sur un ouvrage
function giveReview($db, $bookID, $userID, $note, $review){
    $db->giveReviewOnABook($bookID, $userID, $note, $review);
}

// Retourne tous les avis et notes d'un ouvrage
function allReviewsBook($db, $bookID){
    return $db->getAllReviewsBook($bookID);
}

// Retourne un bool vérifiant si l'user a déjà posté un avis sur un ouvrage
function verifyReviewUser($db, $userID, $bookID){
    return $db->userReviewBook($userID, $bookID);
}

?>