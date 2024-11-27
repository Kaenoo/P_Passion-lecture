<?php

// Récupère les données des 5 derniers ouvrages
function getFiveLastBooks($db){    
    return $db->showFiveLastBooks();
}

// Prépare la présentation des livre en isolant le titre et l'image
function booksPresentation($db){
    $fiveBooks = getFiveLastBooks($db);
    $content[] = [];

    
    foreach (getFiveLastBooks($db) as $key => $book) {
        $content[$key][0] = $book["titre"];
        $content[$key][1] = $book["image_couverture"];
        
    }
    
    return $content;

}
?>