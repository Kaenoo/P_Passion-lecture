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
// Vérifie si l'user est admin ou auteur de cette page
elseif (isUserAdmin($db, $_SESSION["user"]["userID"]) === false && $_SESSION["user"]["userID"] != $_GET["userID"]) {
  header('Location: ./userbooks.php?userID='. $_GET["userID"] . '');
}

// Supprime l'ouvrage lors du clic
if (isset($_POST["confirmDelete"])) {
  delete($db, $_POST["confirmDelete"]);

 // header("Location: ./myBooks.php");
}

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

  <main class="lg:px-12 text-justify">
    <h1 class="my-4 text-2xl lg:text-4xl font-bold text-center">Mes publications d'ouvrages</h1>



    <!-- /!\ : Remplisseur de page -->
    <div class="grid grid-cols-1 px-8 lg:grid-cols-5 lg:gap-4 items-center">
      <?php

        // Vérifie si l'user a publié des ouvrages
        if (userHaveBooks($db, $_GET["userID"])) {
          foreach (showMyBooks($db, $_GET["userID"]) as $index => $bookArray) {
            $html = '<div class="mb-5 lg:mb-0 lg:h-full lg:w-full p-2 bg-gray-200 rounded-2xl">'; 
            // Menu dropdown : Modification ou supression de l'ouvrage
            $html .= '<p class=""><div class="dropdown dropdown-right flex pr-1 justify-end">
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
                                <form method="post">
                                  <input type="hidden" name="pathBookCover" value="' . $bookArray[2] . '" >
                                  <button type="submit" name="confirmDelete" value="' . $bookArray[0] .  '" class="btn bg-red-600 hover:bg-red-700 text-white font-bold">Confirmer</button>
                                </form>
                              </div>
                            </div>
                          </dialog>
                        </a>
                      </li>
                    </ul>  
                  </div></p>';
            // Affichage de la couverture et du tire de l'ouvrage
            $html .= '<a href="./book.php?id=' . $bookArray[0] .'">';
            $html .= '<img class="px-6 pb-2 lg:p-5 lg:object-scale-down lg:h-auto justify-center" src="' . $bookArray[2] . '" alt="Première de couverture de l\'ouvrage ' . $bookArray[1] . '">';
            $html .= '<h2 class="mb-5 text-center justify-center font-light text-2xl hover:font-normal hover:text-green-700">' . $bookArray[1] .'</h2>';
            $html .= '</a> </div>';

            echo $html;
          }
        }
        else {
          $html = '<p class="lg:col-span-5 py-5 text-base lg:text-lg text-center">Vous n\'avez publié encore aucun ouvrage.</p>';

          echo $html;
        }
      ?>
    </div>

  </main>

  <?php include("./views/footer.php"); ?>
        
</body>
</html>
