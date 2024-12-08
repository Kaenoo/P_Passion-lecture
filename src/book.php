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

var_dump(bookReview($db, $dataBook["ouvrage_id"]));


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
        <p class="pt-10 text-lg">Éditeur : <?= $dataBook["editeur"]?></p>
        <p class="text-lg">Pages : <?= $dataBook["nombre_page"]?></p>
        <p class="text-lg">Catégorie : <?= categoryBook($db, $dataBook["categorie_id"])?></p>  
        <p class="text-lg">Parution : <?= $dataBook["date_edition"]?></p>
        <h3 class="py-5 text-2xl font-bold text-green-700 underline decoration-green-700 decoration-8">Résumé</h3>
        <p class="text-lg"><?= $dataBook["resume"]?></p>

        <h3 class="pt-16 pb-5 text-2xl font-bold text-green-700">Avis utilisateurs</h3>

        <!-- Notation en étoile -->
        <div class="rating">
          <?php
            // Si l'ouvrage a des notations, affichage des étoiles
            if (bookReview($db, $dataBook["ouvrage_id"]) != null) {
              $review = bookReview($db, $dataBook["ouvrage_id"]);
              for ($i=1; $i <= 5; $i++) { 
                if ($review >= $i) {
                  echo '<input name="rating-4" class="mask mask-star-2 bg-green-700"/>'; // type="radio" checked="checked" 
                  
                }
                else{ echo '<input name="rating-4" class="mask mask-star-2 bg-green-700 bg-opacity-20" />'; } // type="radio"
              }
            }
            else { echo '<p class="text-lg">Cet ouvrage n\'a pas encore reçu d\'avis</p>'; }
          ?>
        </div>

        <?php
          if (isUserConnected() === true) {
            echo '<br> <button class="btn mt-10 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">Donner son avis</button>';
          }
        ?>
        
         
            
      </div>

    </div>
    

    

  </main>

  <?php include("./views/footer.php");?>

  <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>

        
</body>
</html>
