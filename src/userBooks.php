<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page qui affiche les ouvrages publiés d'un user
-->

<?php
session_start();

include("./controllers/user.php");
$userController = new userController();

include("./controllers/books.php");
$booksController = new booksController();

// Vérifie que l'user soit bien connecté
if ($userController->isUserConnected() !== true) {
  header("Location: ./index.php");
}
//Si l'user veut voir ses propres ouvrages où l'admin veut voir les ouvrages -> redirection vers la page qui permet de modifier
else if ($userController->isUserAdmin($_SESSION["user"]["userID"]) === true || $_SESSION["user"]["userID"] == $_GET["userID"]) {
  header('Location: ./myBooks.php?userID='. $_GET["userID"] . '');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Mes publications - Passion lecture</title>
</head>
<body class="m-auto w-full">
  <?php include("./views/header.php"); ?>

  <main class="lg:px-12 text-justify">
    <h1 class="mt-4 mb-8 text-2xl lg:text-4xl font-bold text-center">Mes publications d'ouvrages</h1>



    <!-- /!\ : Remplisseur de page -->
    <div class="grid grid-cols-1 px-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 sm:gap-4 items-center">
      <?php

        // Vérifie si l'user a publié des ouvrages
        if ($booksController->userHaveBooks($db, $_GET["userID"])) {
          foreach ($booksController->showMyBooks($db, $_GET["userID"]) as $index => $bookArray) {
            $html = '<div class="pt-6 lg:pt-0 mb-5 lg:mb-0 sm:h-full sm:w-full p-2 bg-gray-200 rounded-2xl">'; 
            
            // Affichage de la couverture et du tire de l'ouvrage
            $html .= '<a href="./book.php?id=' . $bookArray[0] .'">';
            $html .= '<img class="px-6 pb-2 lg:p-5 lg:object-scale-down lg:h-auto justify-center" src="' . $bookArray[2] . '" alt="Première de couverture de l\'ouvrage ' . $bookArray[1] . '">';
            $html .= '<h2 class="mb-5 text-center justify-center font-light text-2xl hover:font-normal hover:text-green-700">' . $bookArray[1] .'</h2>';
            $html .= '</a> </div>';  
            
            echo $html;
          }
        }
        else {
          $html = '<p class="lg:col-span-5 py-5 text-base lg:text-lg text-center">Vous n\'avez publié encore aucun ouvrage.</p>';
          
          echo $html;
        }
      ?>
    </div>

  </main>

  <?php include("./views/footer.php"); ?>
        
</body>
</html>
