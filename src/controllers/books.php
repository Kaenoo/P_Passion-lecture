<?php

// Retourne les données des 5 derniers ouvrages
function FiveLastBooks($db){    
    return $db->getFiveLastBooks();
}

// Prépare la présentation des ouvrages en isolant le titre et l'image
function booksPresentation($db){
    $content[] = [];

    
    foreach (FiveLastBooks($db) as $key => $book) {
        $content[$key][0] = $book["ouvrage_id"];
        $content[$key][1] = $book["titre"];
        $content[$key][2] = $book["image_couverture"];
        
    }
    
    return $content;

}

// Vérifie si l'user a publié des ouvrages
function userHaveBooks($db, $userID){
    $content = $db->userBooks($userID);

    if (count($content) > 0) {
        return true;
    }

    return false;
}

// Retourne les ouvrages de l'user et les prépare à la présentation
function showMyBooks($db, $userID){

    $content[] = [];

    
    foreach ($db->userBooks($userID) as $key => $book) {
        $content[$key][0] = $book["ouvrage_id"];
        $content[$key][1] = $book["titre"];
        $content[$key][2] = $book["image_couverture"];
        
    }
    
    return $content;
}

// Retourne les données d'un ouvrage
function dataBook($db, $bookID){
    return $db->getDataBook($bookID);
}

// Retourne le nom et prénom de l'écrivain
function writer($db, $writerID){

    $content = $db->getWriter($writerID);
    
    $writerName = $content["prenom"] . " " . $content["nom"];

    return $writerName;
}

// Retourne les catégories
function categories($db){
    $arrayCategories = $db->getCategories();
    $categories = [];

    foreach ($arrayCategories as $key => $keyCategorie) {
        $categories[] = $keyCategorie["nom"];
    }

    return $categories;
}
?>