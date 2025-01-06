<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page d'acceuil du site web
-->

<?php
session_start();
include("./controllers/user.php");
include("./controllers/books.php");
$userController = new userController();

$booksController = new booksController();

//Si l'user veut se déconnecter
if (isset($_GET["login"]) && $_GET["login"] === "out") {   
 $userController->deconnectUser();
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

  <main class="px-6 md:px-12 text-start">
    <h1 class="my-4 text-3xl md:text-4xl font-bold text-center">Accueil</h1>

    <!-- Message d'introduction -->
    <div class="lg:mx-16 my-10 lg:p-16 p-6 text-lg lg:text-2xl leading-7 md:leading-9 bg-green-200">
      <p>Bienvenue sur Passion Lecture, votre espace dédié à la découverte et au partage littéraire! Que vous soyez un amateur de romans, un passionné d’essais ou un curieux de récits historiques, ce site vous permet :</p>

      <ul class="list-disc pl-8">
        <li>Explorer de nouvelles lectures : Parcourez une vaste bibliothèque d’ouvrages classés par catégories, genres, ou auteurs.</li>
        <li>Partager vos avis : Notez les livres que vous avez lus et lisez les commentaires des autres membres de la communauté.</li>
        <li>Découvrir des recommandations personnalisées : Trouvez votre prochaine lecture grâce à nos suggestions basées sur vos préférences.</li>
        <li>Suivre vos auteurs favoris : Restez informé des œuvres de vos écrivains préférés.</li>
      </ul>
      <p>Les cinq derniers ouvrages ajoutés sont disponibles directement sur cette page pour une exploration immédiate. Bonne lecture ! 📚</p>
    </div>

    <!-- 5 derniers ouvrages -->
    <h1 class="my-4 text-3xl md:text-4xl font-bold text-center">5 derniers ouvrages ajoutés</h1>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 items-center">
      <?php
        foreach ($booksController->booksPresentation() as $index => $bookArray) {
          echo '<div> <a href="./book.php?id=' . $bookArray[0] .'">';
          echo '<img class="block mx-auto p-6 md:p-8 size-fit object-cover justify-center" src="' . $bookArray[2] . '" alt="Première de couverture de l\'ouvrage ' . $bookArray[0] . '">';
          echo '<h2 class="mb-2 md:mb-5 text-center justify-center font-light text-2xl hover:text-green-700 hover:font-normal">' . $bookArray[1] .'</h2>';
          echo '</a> </div>';  
        }
      ?>
    </div>
    
  </main>

  <?php include("./views/footer.php");?>
        
</body>
</html>
