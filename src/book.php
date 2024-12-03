<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page affichant les informations d'un ouvrage à l'aide son ID
-->
<?php
session_start();
include("./controllers/user.php");
include("./models/Database.php");
include("./controllers/books.php");
$db = new Database();

$dataBook = dataBook($db, $_GET["id"]);
var_dump($dataBook);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Passion Lecture - <?= $dataBook["titre"]?></title>
</head>
<body class="m-auto w-full">
  <?php include("./views/header.php"); ?>

  <main class="px-12 text-justify">
    <h1 class="my-4 text-4xl font-bold text-center"><?= $dataBook["titre"]?></h1>
    <h2 class="my-4 text-xl text-center"><?= writerBook($db, $dataBook["ecrivain_id"] )?></h2>

    <div class="grid grid-cols-2 px-16">
      <img class="p-10 size-fit object-cover justify-start" src="<?= $dataBook["image_couverture"]?>" alt="Première de couverture de l\'ouvrage <?= $dataBook["titre"]?>">
      
      <!-- 2ème colonne -->
      <div class="col-start-2">
        <p class="pt-10 ">Éditeur : <?= $dataBook["editeur"]?></p>
        <p>Pages : <?= $dataBook["nombre_page"]?></p>
        <p>Catégorie : <?= categoryBook($db, $dataBook["categorie_id"])?></p>  
        <p>Parution : <?= $dataBook["date_edition"]?></p>
        <h3 class="py-5 text-2xl font-bold text-green-700 underline decoration-green-700 decoration-8">Résumé</h3>
        <p><?= $dataBook["resume"]?></p>

        <h3 class="pt-16 pb-5 text-2xl font-bold text-green-700">Avis utilisateurs</h3>

        <!-- Notation en étoile -->
        <div class="rating">
          <input type="radio" name="rating-4" class="mask mask-star-2 bg-green-700" />
          <input type="radio" name="rating-4" class="mask mask-star-2 bg-green-700" checked="checked" />
          <input type="radio" name="rating-4" class="mask mask-star-2 bg-green-700" />
          <input type="radio" name="rating-4" class="mask mask-star-2 bg-green-700" />
          <input type="radio" name="rating-4" class="mask mask-star-2 bg-green-700" />
        </div>

      </div>

    </div>
    

    

  </main>

  <?php include("./views/footer.php");?>
        
</body>
</html>
