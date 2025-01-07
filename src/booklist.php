<?php
/* Auteure       : Sarah Dongmo
  *  Date          : 25.11.2024
  *  Description   : Présentation des livres avec option de recherche */

session_start();
include("./controllers/searchBooks.php");
$searchController = new searchBooksController();

include("./controllers/books.php");
$booksController = new booksController();

include("./controllers/user.php");
$userController = new userController();

$limit = 5;
$page = 4;
$disabled = 0;
$nbOfPages;
$pagination = 0;
$page = 1;
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

  <main>
    <!-- Lien pour revenir sur l'affichage par défaut -->
    <h1 class="mt-2 lg:my-4 text-3xl md:text-4xl font-bold text-center"> <a href="bookList.php">Liste des ouvrages </a></h1>
    <!-- Barre de recherche -->
    <form action="#" method="get">
      <div class='flex justify-center mt-4 mb-4'>
        <div class="join">
          <div>
            <div>
              <input class="input input-bordered join-item w-40 md:w-auto"
                <?php if (isset($_GET['search']) || isset($_GET['categorie'])) {
                  echo 'value="' . $_GET['search'] . '"';
                } ?>
                placeholder="Recherche" id="search" name="search" />
            </div>
          </div>
          <select id="categorie" name="categorie" class="select select-bordered join-item w-12 md:w-auto">
            <option value="Filtre" selected>
              <?php if (isset($_GET['search']) || isset($_GET['categorie'])) {
                echo $_GET['categorie'];
              } else {
                echo "Filtre";
              } ?>
            </option>
            <!-- Affichage dynamique des catégories -->
            <?php
            $categories = $booksController->categories();
            foreach ($categories as $key => $value) {
              echo '<option value="' . $value["nom"] . '">' . $value["nom"] . '</option>';
            }
            ?>
          </select>
          <div class="indicator">
            <button type="submit" class="btn join-item bg-green-700 hover:bg-green-600 font-bold w-24 md:w-auto text-xs md:text-base">Rechercher</button>
          </div>
        </div>
      </div>
    </form>

    <!-- Recherche des livres disponibles dans la base de données -->
    <?php

    // Requête vers la base de données pour connaître le nombre de livres selon si une recherche a été effectuée ou pas
    if (isset($_GET['search']) || isset($_GET['categorie'])) {
      $nbOfBooks = $searchController->rowsNumberOfSearch($_GET);
    } else {
      $nbOfBooks = $searchController->rowsNumberOfList();
    }

    // Définition du nombre de page
    $nbOfPages = $nbOfBooks / $limit;
    if ($nbOfBooks % $limit != 0) {
      $nbOfPages++;
      $nbOfPages = floor($nbOfPages); //Arrondi à l'entier inférieur
    }

    // Mise à jour de l'état de pagination
    if ($nbOfPages > 1) {
      $pagination = 1;
    }

    // Calcul de l'index de la valeur de la requête
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    }
    $index = (($limit * $page) - $limit);
    if ($page != 1) {
      $index++;
    }

    // Requête vers la base de données selon si une recherche est effectuée ou non
    if (isset($_GET['search']) || isset($_GET['categorie'])) {
      $getListBooks = $booksController->SearchBooks($_GET, $index, $limit);
    } else {
      $getListBooks = $booksController->listBooks($index, $limit);
    }

    foreach ($getListBooks as $dataBook) {

      //Déclaration de variables
      $pseudoUser = $userController->listPseudoUser($dataBook["utilisateur_id"]);
      $authorName = $booksController->authorBook($dataBook["ecrivain_id"]);
      $categoryName = $booksController->categoryBook($dataBook["categorie_id"]);
      $getListSummaryBook = $booksController->listSummaryBook($dataBook["ouvrage_id"]);


      echo "<div class ='grid sm:grid-cols-2 md:gap-2 sm:mx-20 lg:mx-36'>";

      echo "<div class='grid place-self-center sm:col-start-1 w-52 md:w-60 lg:w-96 h-auto mb-2 p-2'>";
      echo '<a href="userBooks.php?userID=' . $pseudoUser["utilisateur_id"] . '">';
      echo '<img src="' . $dataBook["image_couverture"] . '" alt="Couverture du livre"></a>';
      echo "</div>";

      echo "<div class='sm:col-start-2 p-2 sm:pr-10'>";
      echo "<div class='flex justify-center sm:justify-end'>";
      echo '<a class="hover:text-green-700 hover:font-semibold" href="userBooks.php?userID=' . $pseudoUser["utilisateur_id"] . '">';
      echo '<p>' . $pseudoUser["pseudo"] . "</p></a>";
      echo "</div>";
      echo '<a class="hover:text-green-700 hover:font-semibold" href="book.php?id=' . $dataBook["ouvrage_id"] . '">';
      echo '<p class="px-4 sm:px-0 text-center sm:text-start">' . $dataBook["titre"] . ", " . $authorName . "</p></a>";

      echo "<div class='text-sm'>";
      echo '<p class="px-4 sm:px-0 text-center sm:text-start">'.  $categoryName . '</p>';
      echo '<p class="px-4 sm:px-0 text-center sm:text-start">'. $getListSummaryBook["resume"] . '</p></br>';
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }

    // Pagination adaptée au nombre de livres
    if ($nbOfBooks > $limit) //pagination == 1
    {
      $i = 1;
      echo '<div class="join">
          <input class="join-item btn bg-transparent" type="radio" name="options" onclick="window.location.href=\'bookList.php?page=' . ($page > 1 ? $page - 1 : $page) . '\';"aria-label="&laquo;" />';

      for ($i; $i <= $nbOfPages; $i++) {
        // Identification de la page active
        if (isset($_GET["page"])) {
          $currentPage = $_GET["page"];
        } else {
          $currentPage = 1;
        }

        // Indexation de la page active
        if ($i == $currentPage) {
          $checked = 'checked="checked"';
        } else {
          $checked = '';
        }

        if ($i == 1) {
          echo '<input class="join-item btn bg-transparent" type="radio" name="options" 
              onclick="window.location.href=\'bookList.php?page=' . $i . '\';" aria-label="' . $i . '" ' . $checked . '/>';
        } else {
          echo '<input class="join-item btn bg-transparent" type="radio" name="options" onclick="window.location.href=\'bookList.php?page=' . $i . '\';"
              aria-label="' . $i . '"/>';
        }
      }
      echo '<input class="join-item btn bg-transparent" type="radio" name="options" onclick="window.location.href=\'bookList.php?page=' . ($page < $nbOfPages ? $page + 1 : $page) . '\';"aria-label="&raquo;" />';
    }

    ?>
  </main>
  <?php include("./views/footer.php"); ?>
</body>
</body>

</html>