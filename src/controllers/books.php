<?php

// Récupère les données des 5 derniers ouvrages
function getFiveLastBooks($db){    
    return $db->showFiveLastBooks();
}

// Prépare la présentation des ouvrages en isolant le titre et l'image
function booksPresentation($db){
    $content[] = [];

    
    foreach (getFiveLastBooks($db) as $key => $book) {
        $content[$key][0] = $book["titre"];
        $content[$key][1] = $book["image_couverture"];
        
    }
    
    return $content;

}

// Récupère les ouvrages de l'user et les prépare à la présentation
function showMyBooks($db, $userID){

    $content[] = [];

    
    foreach ($db->userBooks($userID) as $key => $book) {
        $content[$key][0] = $book["titre"];
        $content[$key][1] = $book["image_couverture"];
        
    }
    
    return $content;
}
?>