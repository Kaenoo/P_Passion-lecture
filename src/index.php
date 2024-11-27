<?php
session_start();
include("./controllers/user.php");
include("./models/Database.php");
include("./controllers/books.php");
$db = new Database();

//Si l'user veut se déconnecter
if (isset($_GET["login"]) && $_GET["login"] === "out") {   
 deconnectUser();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Accueil - Passion lecture</title>
</head>
<body class="m-auto w-full">
  <?php
  include("./views/header.php");
  ?>

  <main class="px-12 text-justify">
    <h1 class="my-4 text-4xl font-bold text-center">Accueil</h1>

    <!-- introductory message -->
    <div class="m-5 p-5 bg-green-200 ">
      <p>Bienvenue sur Passion Lecture, votre espace dédié à la découverte et au partage littéraire ! Que vous soyez un amateur de romans, un passionné d’essais ou un curieux de récits historiques, ce site vous permet :</p>

      <ul class="list-disc pl-8">
        <li>Explorer de nouvelles lectures : Parcourez une vaste bibliothèque d’ouvrages classés par catégories, genres, ou auteurs.</li>
        <li>Partager vos avis : Notez les livres que vous avez lus et lisez les commentaires des autres membres de la communauté.</li>
        <li>Découvrir des recommandations personnalisées : Trouvez votre prochaine lecture grâce à nos suggestions basées sur vos préférences.</li>
        <li>Suivre vos auteurs favoris : Restez informé des œuvres de vos écrivains préférés.</li>
      </ul>
      <p>Les cinq derniers ouvrages ajoutés sont disponibles directement sur cette page pour une exploration immédiate. Bonne lecture ! 📚 <br>
      Si vous avez des précisions à apporter ou souhaitez une version plus ciblée, faites-le-moi savoir !</p>
    </div>

    <!-- 5 derniers ouvrages -->
    <h1 class="my-4 text-4xl font-bold text-center">5 derniers ouvrages ajoutés</h1>

    <!-- TODO : div permettant d'aligner les ouvrages sur une même page -->
    <div class="grid grid-cols-5 gap-4 items-center">
      <?php
        foreach (booksPresentation(($db)) as $index => $bookArray) {
          echo '<div>';
          echo '<img class="block mx-auto p-8 size-fit object-cover justify-center" src="' . $bookArray[1] . '" alt="Première de couverture de l\'ouvrage ' . $bookArray[0] . '">';
          echo '<h2 class="mb-5 text-center justify-center font-light text-2xl">' . $bookArray[0] .'</h2>';
          echo '</div>';  
        }
      ?>
    </div>
    
  </main>

  <?php

  include("./views/footer.php");
  ?>
        
</body>
</html>
