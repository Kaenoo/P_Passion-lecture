<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page affichant les informations d'un ouvrage à l'aide son ID
-->
<?php
session_start();

include("./controllers/user.php");
$userController = new userController();

include("./controllers/reviews.php");
$reviewController = new reviewController();

include("./controllers/books.php");
$booksController = new booksController();

// Défintion de variables
$dataBook = $booksController->dataBook($_GET["id"]);
$userID = $_SESSION["user"]["userID"];

if ($userController->isUserConnected() !== true) {
  header("Location: ./index.php");
}

// Vérifie si l'user a donné un avis
if (count($_POST) > 0 && $reviewController->verifyReviewUser($userID, $dataBook["ouvrage_id"]) === false) {
  $reviewController->giveReview($dataBook["ouvrage_id"], $userID, $_POST["rating-4"], $_POST["review"]);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <title>Passion Lecture - <?= $dataBook["titre"] ?></title>
</head>

<body class="m-auto w-full">
  <?php include("./views/header.php"); ?>

  <main class="px-12 text-justify">
    <h1 class="mt-2 lg:my-4 text-2xl lg:text-4xl font-bold text-center"><?= $dataBook["titre"] ?></h1>
    <h2 class="mb-4 lg:my-4 text-base lg:text-xl text-center"><?= $booksController->writerBook($dataBook["ecrivain_id"]) ?></h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 lg:px-16 lg:gap-32">
      <!-- Alignement de l'image -->
      <div class="inline-block align-top">
        <div class="grid col-start-1 justify-items-center lg:justify-items-end lg:pt-10" >
          <img class="block object-cover mx-auto lg:mx-0 lg:object-contain size lg:w-3/5 h-auto " src="<?= $dataBook["image_couverture"] ?>" alt="Première de couverture de l'ouvrage <?= $dataBook["titre"] ?>">
        </div>
      </div>

      <!-- 2ème colonne -->
      <div class="text-center lg:text-left lg:col-start-2">
        <p class="pt-5 lg:pt-10 text-lg">Éditeur : <?= $dataBook["editeur"] ?></p>
        <p class="text-lg">Pages : <?= $dataBook["nombre_page"] ?></p>
        <p class="text-lg">Catégorie : <?= $booksController->categoryBook($dataBook["categorie_id"]) ?></p>
        <p class="text-lg">Parution : <?= $dataBook["date_edition"] ?></p>
        <p class="text-lg">Publié par : <a class="font-semibold hover:font-semibold hover:text-green-700" href="./userBooks.php?userID=<?= $dataBook["utilisateur_id"]?>"><?= $userController->UserPseudo($dataBook["utilisateur_id"])?></a></p>
        <?php
          //Vérifie si la donnée contient .pdf
          if (str_contains($dataBook["extrait"], ".pdf")) {
              $html = '<button class="btn mt-8 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                      <a href="'. $dataBook["extrait"] . '" target="_top">Extrait de l\'ouvrage</a>
                      </button>';
              echo $html;
            }
            ?>
        
        
        <h3 class="py-5 lg:pt-8 text-2xl font-bold text-green-700 underline decoration-green-700 decoration-8">Résumé</h3>
        <p class="text-lg"><?= $dataBook["resume"] ?></p>

        <h3 class="py-5 lg:pt-16 text-2xl font-bold text-green-700 underline decoration-green-700 decoration-8">Avis utilisateurs</h3>

        <!-- Notation en étoile -->
        <div class="rating">
          <?php
          // Si l'ouvrage a des notations, affichage des étoiles
          if ($reviewController->bookReview($dataBook["ouvrage_id"]) != null) {
            $review = $reviewController->bookReview($dataBook["ouvrage_id"]);
            for ($i = 1; $i <= 5; $i++) {
              if ($review >= $i) {
                echo '<input name="rating-4" class="mask mask-star-2 bg-green-700"/>';

              } else {
                echo '<input name="rating-4" class="mask mask-star-2 bg-green-700 bg-opacity-20" />';
              }
            }
          } else {
            echo '<p class="text-lg">Cet ouvrage n\'a pas encore reçu d\'avis</p>';
          }
          ?>
        </div>
          
        <!-- Option : Donner son avis -->
        <?php
        if ($reviewController->verifyReviewUser($userID, $dataBook["ouvrage_id"]) === false) {
          
          echo '<div class="mt-8">
          <button class="btn bg-green-700 text-lg text-white font-semibold hover:bg-green-600" onclick="my_modal_3.showModal()">Donner son avis</button>
          <dialog id="my_modal_3" class="modal">
            <div class="modal-box">
              <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
              </form>
              <div class="flex items-center justify-center">
                <form action="#" method="post" class="space-y-4">
                  <div class="rating flex justify-center">
                    <input type="radio" name="rating-4" value="1" class="mask mask-star-2 bg-green-700" checked="checked" />
                    <input type="radio" name="rating-4" value="2" class="mask mask-star-2 bg-green-700" />
                    <input type="radio" name="rating-4" value="3" class="mask mask-star-2 bg-green-700" />
                    <input type="radio" name="rating-4" value="4" class="mask mask-star-2 bg-green-700" />
                    <input type="radio" name="rating-4" value="5" class="mask mask-star-2 bg-green-700" />
                  </div>
                  <textarea name="review" class="textarea textarea-bordered w-full" placeholder="Donne ton avis"></textarea>
                  <button type="submit" class="btn w-full mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600" >
                    Publier
                  </button>
                </form>
              </div>
  
            </div>
          </dialog>

        </div>';
        }
        ?>
        
        <!-- Avis des utilisateurs -->
         <?php
         $reviews = $reviewController->allReviewsBook($dataBook["ouvrage_id"]);
         foreach ($reviews as $user => $dataArray) { 
          if ($dataArray["note"] != null) { ?>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 lg:gap-2 mt-5 pt-5 p-1 lg:p-5 bg-gray-200 rounded-box">
             
            <!-- Pseudo -->
            <div class="col-start-1">
                <?= '<p class="font-semibold text-lg">' . $userController->UserPseudo($dataArray["utilisateur_id"]) . '</p>' ?>
              </div>

              <!-- Étoiles -->
              <div class="col-start-2 lg:col-start-1 rating lg:mr-4">
                <?php 
                  for ($i = 1; $i <= 5; $i++) {
                    if ($dataArray["note"] >= $i) {
                      echo '<input name="rating-4" class="mask mask-star-2 bg-green-700"/>';

                    } else {
                      echo '<input name="rating-4" class="mask mask-star-2 bg-green-700 bg-opacity-20" />';
                    }
                  }
                ?>
              </div>

              <!-- Commentaire -->
              <?php
              $dataArray["commentaire"];
              if (strlen($dataArray["commentaire"]) > 0) {
                echo '<div class="chat chat-start col-start-1 col-span-2 lg:col-start-2 lg:col-span-3 mt-5 lg:mt-0"><div class="chat-bubble">' . $dataArray["commentaire"] . '</div></div>';
              }
              ?>
             

          </div>
        <?php }};?>

      </div>

    </div>

  </main>

  <?php include("./views/footer.php"); ?>

</body>

</html>