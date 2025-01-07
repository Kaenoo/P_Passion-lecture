<?php 
  /* Auteure       : Sarah Dongmo
  *  Date          : 25.11.2024
  *  Description   : Présentation des livres avec option de recherche */

  session_start();
  include("./models/database.php");
  include("./controllers/books.php");
  include("./controllers/user.php");
  $db = new Database();
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
      <h1 class="py-4 text-4xl font-bold text-center"> <a href="bookList.php">Liste des ouvrages </a></h1>

      <!-- Barre de recherche -->
      <form action="#" method="get">
        <div class = 'flex justify-center mb-4'>
            <div class="join">
                <div>
                <div>
                  <input class="input input-bordered join-item" 
                  <?php if (isset($_GET['search']) || isset($_GET['categorie'])){ echo 'value="' . $_GET['search']. '"';}?>
                  placeholder = "Recherche" id="search" name="search"/>  
                </div>
              </div>
              <select id="categorie" name="categorie" class="select select-bordered join-item">
                <option value="Filtre" selected>
                <?php  if (isset($_GET['search']) || isset($_GET['categorie'])){echo $_GET['categorie'];} else {echo "Filtre";} ?>
                </option>
                <!-- Affichage dynamique des catégories -->
                <?php 
                    $categories = $db->getAllCategories();
                    foreach ($categories as $key => $value) 
                    {
                      
                      echo '<option value="'. $value["nom"]. '">' . $value["nom"] . '</option>';
                    }
                ?>
              </select>
              <div class="indicator">
                <button type="submit" class="btn join-item bg-green-700 hover:bg-green-600 font-bold">Rechercher</button>
              </div>
            </div>
        </div>
      </form>
    
    <!-- Recherche des livres disponibles dans la base de données -->
    <?php
    
      // Requête vers la base de données pour connaître le nombre de livres selon si une recherche a été effectuée ou pas
      if (isset($_GET['search']) || isset($_GET['categorie'])) 
      {
        $nbOfBooks = $db->getRowsNumberOfSearch($_GET);
      }
      else
      {
        $nbOfBooks = $db->getRowsNumberOfList();
      }

      // Définition du nombre de page
      $nbOfPages = $nbOfBooks/$limit;
      if ($nbOfBooks % $limit != 0)
      { 
        $nbOfPages ++;
        $nbOfPages = floor($nbOfPages); //Arrondi à l'entier inférieur
      }

      // Mise à jour de l'état de pagination
      if ($nbOfPages > 1)
      {
        $pagination = 1;
      }

      // Calcul de l'index de la valeur de la requête
      if (isset($_GET['page'])) 
      {
        $page = $_GET['page'];
      }
      $index = (($limit * $page) - $limit);
      if ($page != 1) {$index++;}

      // Requête vers la base de données selon si une recherche est effectuée ou non
      if (isset($_GET['search']) || isset($_GET['categorie'])) 
      {
        $listBooks = $db->searchBooks($_GET, $index, $limit);
      }
      else
      {
        $listBooks = $db->listBooks($index, $limit);
      }

        foreach ($listBooks as $dataBook)
        { 
            echo "<div class = 'flex justify-between mx-30'>";
            echo "<div class='h-1/4 w-1/4 mb-2 flex-1 p-2'>";
            
            echo '<img src="'.$dataBook["image_couverture"].'" alt="Couverture du livre">';
            echo "</div>";

            echo "<div class='flex flex-col flex-1 p-2'>";
              $listPseudoUser = $db->listPseudoUser ($dataBook["utilisateur_id"]);
              foreach ($listPseudoUser as $pseudoUser)
              {
                echo "<div class='flex justify-end'>";
                echo '<a href="userBooks.php?userID='. $pseudoUser["utilisateur_id"] .'">' . $pseudoUser["pseudo"] . "</a>" . "<br> ";
                echo "</div>";
              }
                echo "<div class='flex flex-row font-clamp text-[clamp(1rem,3vw,1.8rem)] </div>
                '>";

                  echo '<a href="book.php?id='. $dataBook["ouvrage_id"] .'">' . $dataBook["titre"] . "</a>" . ", ";
                  
                  $listAuthorBook = $db->listAuthorBook($dataBook["ecrivain_id"]);
                  foreach ($listAuthorBook as $authorBook)
                  {
                    echo $authorBook["prenom"] . " ";
                    echo $authorBook["nom"] . "</br>";
                  }
                echo "</div>";            
              echo "<div class='text-sm'>";
              $listCategoryBook = $db->listCategoryBook ($dataBook["categorie_id"]);
              foreach ($listCategoryBook as $categoryBook)
              {
                echo $categoryBook["nom"] . "</br>";
              }

              $listSummaryBook = $db->listSummaryBook ($dataBook["ouvrage_id"]);
              foreach ($listSummaryBook as $summaryBook)
              {
                echo $summaryBook["resume"] . "...</br>";
              }
          echo "</div>";
          echo "</div>";
          echo "</div>";
        }

        // Pagination adaptée au nombre de livres
        if ($nbOfBooks > $limit)
        {
          $i = 1;

          // Définition de la page minimale
          echo '<div class="join">
          <input class="join-item btn btn-square " type="radio" name="options" onclick="window.location.href=\'bookList.php?page=' . ($page > 1 ? $page - 1 : $page) .'\';"aria-label="&laquo;" />';

          for ($i; $i <= $nbOfPages; $i++)
          {
            // Identification de la page active
            if (isset($_GET["page"])) 
            { $currentPage = $_GET["page"]; } 
            else 
            { $currentPage = 1;}
          
            // Indexation de la page active
            if ($i == $currentPage)
            { $checked = 'checked="checked"'; }
            else 
            { $checked = '';}

            echo '<input class="join-item btn btn-square" type="radio" name="options" 
            onclick="window.location.href=\'bookList.php?page=' . $i . '\';" aria-label="' . $i . '" ' . $checked . '/>'; 

          }

          // Définition de la page maximale
          echo '<input class="join-item btn btn-square" type="radio" name="options" onclick="window.location.href=\'bookList.php?page=' . ($page < $nbOfPages ? $page + 1 : $page). '\';"aria-label="&raquo;" />';
        }
      ?>
    </main>
  <?php include("./views/footer.php");?>
</body>
</body>
</html>