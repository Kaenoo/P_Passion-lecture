<?php
session_start();

include("./models/Database.php");
$db = new Database();


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

    <h1 class="my-4 text-4xl font-bold text-center">5 derniers ouvrages ajoutés</h1>

    <img class="block mx-auto p-8 justify-center" src="./img/Rectangle.png" alt="rectangle">    

    <h2 class="mb-5 text-center justify-center font-light text-2xl">Titre du livre</h2>


  </main>

  <?php
  include("./views/footer.php");
  ?>
        
</body>
</html>


<?php

foreach ($ouvrage as $key => $value) {
  # code...
}

?>