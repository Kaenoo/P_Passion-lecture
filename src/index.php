<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page d'acceuil du site web
-->

<?php
session_start();
include("./controllers/user.php");
include("./models/database.php");
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
  <?php include("./views/header.php"); ?>

  <main class="lg:px-12 text-justify">
    <h1 class="my-4 text-2xl lg:text-4xl font-bold text-center">Accueil</h1>

    <!-- Message d'introduction -->
    <div class="m-2 p-6 text-base md:rounded-xl md:bg-gray-200 lg:m-5 lg:p-5 lg:text-left lg:text-lg">


      <p class="md:text-center md:pb-3">Bienvenue sur Passion Lecture, votre espace dédié à la découverte et au partage littéraire !</p>

      <p>Que vous soyez amateur de romans, passionné d’essais ou curieux de récits historiques, ce site est fait pour vous.
        Explorez une vaste bibliothèque d’ouvrages classés par catégories, genres et auteurs, et découvrez de nouvelles lectures adaptées à vos goûts.
        Partagez vos avis avec une communauté de passionnés, et laissez-vous guider par nos recommandations personnalisées pour trouver facilement votre prochaine lecture.
        Suivez également les actualités de vos écrivains préférés et ne manquez aucune de leurs nouvelles œuvres.
        Les cinq derniers ouvrages ajoutés sont disponibles directement sur cette page pour une exploration immédiate.
      </p>

        <p class="md:text-center lg:pt-3" >Bonne lecture ! 📚</p>
    </div>

    <!-- 5 derniers ouvrages -->
    <h1 class="my-4 text-2xl lg:text-4xl font-bold text-center">5 derniers ouvrages ajoutés</h1>

    <div class="grid grid-cols-1 px-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 sm:gap-4 items-center">
      <?php
        foreach (booksPresentation(($db)) as $index => $bookArray) {
          $html = '<div '; 
          $html = '<div class="mb-5 pt-6 lg:pt-0 lg:mb-0 sm:h-full sm:w-full p-2 bg-gray-200 rounded-2xl"> <a href="./book.php?id=' . $bookArray[0] .'">';
          $html .= '<img class="block mx-auto px-6 pb-2 lg:p-8 size-fit object-cover justify-center" src="' . $bookArray[2] . '" alt="Première de couverture de l\'ouvrage ' . $bookArray[1] . '">';
          $html .= '<h2 class="mb-5 text-center justify-center font-light text-xl lg:text-2xl">' . $bookArray[1] .'</h2>';
          $html .= '</a> </div>';

          echo $html;
        }
        ?>
    </div>
    
  </main>

  <?php include("./views/footer.php");?>
        
</body>
</html>
