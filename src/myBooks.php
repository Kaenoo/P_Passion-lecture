<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page qui affiche les ouvrages publiés d'un user
-->

<?php
session_start();
include("./controllers/user.php");
include("./models/database.php");
include("./controllers/books.php");
$db = new Database();

// Vérifie que l'user soit bien connecté
if (isUserConnected() !== true) {
  header("Location: ./index.php");
}

// Supprime l'ouvrage lors du clic
if (isset($_GET["confirmDelete"])) {
  delete($db, $_GET["confirmDelete"]);
  header("Location: ./myBooks.php");
}

var_dump($_GET);

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

            echo '<div class="p-2 bg-gray-200 rounded-2xl">'; 
            echo '<p class=""><div class="dropdown dropdown-right flex pr-1 justify-end">
                  <div tabindex="0" role="button" class="font-bold text-3xl align-text-top">...</div>
                  <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-14 shadow">
                    <li>
                      <a class="p-1 text-center" href="./modifyBook.php">
                        <img class="size-6" src="./img/edit.png" alt="Modifier">
                      </a>
                    </li>
                    <li>
                      <a class="p-1 object-center"> 
                        <img class="size-6" onclick="my_modal_5.showModal()" src="./img/delete.png" alt="Supprimer">
                        <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
                          <div class="modal-box">
                          <form method="dialog">
                              <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                            </form>
                            <h3 class="text-lg font-bold">Supprimer l\'ouvrage</h3>
                              <p class="py-4">Souhaitez-vous vraiment supprimer <b> '. $bookArray[1] . '</b>.<br>Les notations et commentaires associés disparaitront avec !</p>
                            <div class="modal-action">
                              <form method="dialog">
                                <button class="btn">Annuler</button>
                              </form>
                              <form method="get">
                                <button type="submit" name="confirmDelete" value="' . $bookArray[0] .  '" class="btn bg-red-600 hover:bg-red-700 text-white font-bold">Confirmer</button>
                              </form>
                            </div>
                          </div>
                        </dialog>
                      </a>
                    </li>
                  </ul>
                      
                    </div></p>';
            echo '<a href="./book.php?id=' . $bookArray[0] .'">';
            echo '<img class="block mx-auto px-8 pb-8 size-fit object-cover justify-center" src="' . $bookArray[2] . '" alt="Première de couverture de l\'ouvrage ' . $bookArray[1] . '">';
            echo '<h2 class="mb-5 text-center justify-center font-light text-2xl hover:font-normal hover:text-green-700">' . $bookArray[1] .'</h2>';
            echo '</a> </div>';  
          }
        }
        else {
          echo '<p class="col-span-5 py-5 text-lg text-center">Vous n\'avez publié encore aucun ouvrage.</p>';
        }
      ?>
    </div>

    

      

  </main>

  <?php include("./views/footer.php"); ?>
        
</body>
</html>
