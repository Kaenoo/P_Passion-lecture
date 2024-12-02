<?php
session_start();
include("./controllers/user.php");
include("./models/Database.php");
include("./controllers/books.php");
$db = new Database();

// Vérifie que l'user soit bien connecté
isUserConnected();

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

  <main class="px-12 text-justify">
    <h1 class="my-4 text-4xl font-bold text-center">Mes publications d'ouvrages</h1>



    <!-- /!\ : Remplisseur de page -->
    <div class="grid grid-cols-5 gap-4 items-center">
      <?php

        // Vérifie si l'user a publié des ouvrages
        if (userHaveBooks($db, $_SESSION["user"]["userID"])) {
          foreach (showMyBooks($db, $_SESSION["user"]["userID"]) as $index => $bookArray) {
            echo '<div> <a href="./book.php?id=' . $bookArray[0] .'">';
            echo '<img class="block mx-auto p-8 size-fit object-cover justify-center" src="' . $bookArray[2] . '" alt="Première de couverture de l\'ouvrage ' . $bookArray[0] . '">';
            echo '<h2 class="mb-5 text-center justify-center font-light text-2xl">' . $bookArray[1] .'</h2>';
            echo '</a> </div>';  
          }
        }
        else {
          echo '<p class="p-5 text-lg text-center">Vous n\'avez publié encore aucun ouvrage.</p>';
        }
      ?>

      
    </div>
    
  </main>

  <?php include("./views/footer.php"); ?>
        
</body>
</html>
