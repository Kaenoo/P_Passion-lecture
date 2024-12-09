<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page affichant les informations d'un ouvrage à l'aide son ID
-->
<?php
session_start();
include("./controllers/user.php");
include("./models/database.php");
include("./controllers/books.php");
include("./controllers/reviews.php");
$db = new Database();

$dataBook = dataBook($db, $_GET["id"]);

if (isUserConnected() !== true) {
  header("Location: ./index.php");
}

//var_dump($dataBook);
// Vérifie si l'user a donné un avis
if (count($_POST) > 0 && verifyReviewUser($db, $_SESSION["user"]["userID"], $dataBook["ouvrage_id"]) === false) {
  giveReview($db, $dataBook["ouvrage_id"], $_SESSION["user"]["userID"], $_POST["rating-4"], $_POST["review"]);

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
    <h1 class="my-4 text-4xl font-bold text-center"><?= $dataBook["titre"] ?></h1>
    <h2 class="my-4 text-xl text-center"><?= writerBook($db, $dataBook["ecrivain_id"]) ?></h2>

    <div class="grid grid-cols-2 px-16 gap-32">
      <div class="col-start-1 flex justify-end" >
        <img class="object-contain w-3/5 h-auto " src="<?= $dataBook["image_couverture"] ?>" alt="Première de couverture de l'ouvrage <?= $dataBook["titre"] ?>">
      </div>

      <!-- 2ème colonne -->
      <div class="col-start-2">
        <p class="pt-10 text-lg">Éditeur : <?= $dataBook["editeur"] ?></p>
        <p class="text-lg">Pages : <?= $dataBook["nombre_page"] ?></p>
        <p class="text-lg">Catégorie : <?= categoryBook($db, $dataBook["categorie_id"]) ?></p>
        <p class="text-lg">Parution : <?= $dataBook["date_edition"] ?></p>
        <p class="text-lg">Publié par : <a class="hover:font-semibold hover:text-green-700" href=""><?= UserPseudo($db, $dataBook["utilisateur_id"])?></a></p>
        <h3 class="py-5 text-2xl font-bold text-green-700 underline decoration-green-700 decoration-8">Résumé</h3>
        <p class="text-lg"><?= $dataBook["resume"] ?></p>

        <h3 class="pt-16 pb-5 text-2xl font-bold text-green-700 underline decoration-green-700 decoration-8">Avis utilisateurs</h3>

        <!-- Notation en étoile -->
        <div class="rating">
          <?php
          // Si l'ouvrage a des notations, affichage des étoiles
          if (bookReview($db, $dataBook["ouvrage_id"]) != null) {
            $review = bookReview($db, $dataBook["ouvrage_id"]);
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
        if (verifyReviewUser($db, $_SESSION["user"]["userID"], $dataBook["ouvrage_id"]) === false) {
          
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
         $reviews = allReviewsBook($db, $dataBook["ouvrage_id"]);
         foreach ($reviews as $user => $dataArray) { 
          if ($dataArray["note"] != null) { ?>
            
            <div class="grid grid-cols-4 gap-2 mt-5 p-5 bg-gray-200 rounded-box">
              <div class="col-start-1">
                <?= '<p class="font-semibold text-lg">' . UserPseudo($db, $dataArray["utilisateur_id"]) . '</p>' ?>
                <div class="rating mr-4">
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
              </div>

              <!-- Commentaire -->
              <?php
              $dataArray["commentaire"];
              if (strlen($dataArray["commentaire"]) > 0) {
                echo '<div class="chat chat-start col-start-2 col-span-3 mt-5"><div class="chat-bubble">' . $dataArray["commentaire"] . '</div></div>';
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