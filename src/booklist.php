<?php 
  /* Auteure       : Sarah Dongmo
  *  Date          : 25.11.2024
  *  Description   : Présentation des livres avec option de recherche */

  session_start();
  include("./models/database.php");
  include("./controllers/books.php");
  $db = new Database();
  $booksController = new booksController();

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
        <div class = 'searchBar'>
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
                    $categories = $booksController->categories($db);
                    foreach ($categories as $key => $value) 
                    {
                      echo '<option value="'. $value . '">' . $value . '</option>';
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
          echo "<div class = 'globalDataBook'>";
          echo "<div class='cat'>";
          echo '<img src="'.$dataBook["image_couverture"].'" alt="Couverture du livre">';
          echo "</div>";

            echo "<div class='textDataBook'>";
              $listPseudoUser = $db->listPseudoUser ($dataBook["utilisateur_id"]);
              foreach ($listPseudoUser as $pseudoUser)
              {
                echo "<div class='pseudo'>";
                echo '<a href="userBooks.php?id='. $pseudoUser["utilisateur_id"] .'">' . $pseudoUser["pseudo"] . "</a>" . "<br> ";
                echo "</div>";
              }
                echo "<div class='directDataBook'>";
                echo '<a href="book.php?id='. $dataBook["ouvrage_id"] .'">' . $dataBook["titre"] . "</a>" . ", ";
                
                $listAuthorBook = $db->listAuthorBook($dataBook["ecrivain_id"]);
                foreach ($listAuthorBook as $authorBook)
                {
                  echo $authorBook["prenom"] . " ";
                  echo $authorBook["nom"] . "</br>";
                }
              
              $listCategoryBook = $db->listCategoryBook ($dataBook["categorie_id"]);
              foreach ($listCategoryBook as $categoryBook)
              {
                echo $categoryBook["nom"] . "</br>";
              }

              $listSummaryBook = $db->listSummaryBook ($dataBook["ouvrage_id"]);
              //var_dump($listSummaryBook);
              foreach ($listSummaryBook as $summaryBook)
              {
                echo $summaryBook["resume"] . "</br>";
              }
          echo "</div>";
          echo "</div>";
          echo "</div>";
        }


        // Pagination adaptée au nombre de livres
        if ($nbOfBooks > $limit) //pagination == 1
        {
          $i = 1;
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

            if ($i == 1)
            {
              echo '<input class="join-item btn btn-square" type="radio" name="options" 
              onclick="window.location.href=\'bookList.php?page=' . $i . '\';" aria-label="' . $i . '" ' . $checked . '/>'; 
            }
            else
            {
              echo '<input class="join-item btn btn-square" type="radio" name="options" onclick="window.location.href=\'bookList.php?page=' . $i . '\';"
              aria-label="' . $i . '"/>';
            }
          }
          echo '<input class="join-item btn btn-square" type="radio" name="options" onclick="window.location.href=\'bookList.php?page=' . ($page < $nbOfPages ? $page + 1 : $page). '\';"aria-label="&raquo;" />';
        }
  
      ?>
    </main>

  <?php include("./views/footer.php");?>

<style>
   .globalDataBook {
          display : flex;
          /*align-items : center;
          justify-content: center;*/
          /*margin-left: 30%;
          margin-right: 30%;*/
          width: 40%; /* Définit la largeur de l'élément à 40% de la largeur du conteneur parent */
      margin-left: auto; /* Centrer l'élément horizontalement */
    margin-right: auto; /* Centrer l'élément horizontalement */
    text-align : center;
        }

        img {
        height: 100%;
        width: 100%;
        object-fit: contain;
        }

        .cat {
        height:300px;
        width: 300px;
        margin-bottom: 2%;
        /*object-fit: cover;*/
        }

        .textDataBook
        {
          display : flex;
          flex-direction: column;
        }

      .pseudo {
        display : flex;
        justify-content:flex-end;
      }

      .directDataBook{
        display : flex;
        flex-direction: row;
        font-size: clamp(1rem, 3vw, 2rem);

      }

      .searchBar{
        display: flex;
        justify-content : center;
        margin-bottom: 4%;
      }

      .flex-container {
        display: flex;
        /* flex-wrap : wrap;
        flex-direction: column; */
      }
</style>
</body>
</body>
</html>