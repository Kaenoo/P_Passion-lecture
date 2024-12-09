<?php 
  /* Auteure       : Sarah Dongmo
  *  Date          : 25.11.2024
  *  Description   : Présentation des livres avec option de recherche */

  session_start();
  include("./models/Database.php");
  include("./controllers/books.php");
  $db = new Database();

  if ($_GET["search"]) 
  {
    var_dump($_GET);
    //[0]["nom"]
    $listBooks = $db->searchBooks($_GET);
  }
  else
  {
    $listBooks = $db->listBooks();
  }

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
      <h1 class="py-4 text-4xl font-bold text-center">Liste des ouvrages</h1>
      <div class="search-container">
        <!-- <form action="" method="get">
          <input type="text" placeholder="Search.." id="search" name="search" oninput="myFunction()">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>

      <script>
      function myFunction() 
      {
        <? $searchValue = '"document.getElementById("search").value';
          // $db->searchABook($searchValue);?>
      }
      </script> -->


      <!-- Barre de recherche -->
      <form action="#" method="get">
        <div class = 'searchBar'>
            <div class="join">
                <div>
                <div>
                  <input class="input input-bordered join-item" placeholder="Recherche" id="search" name="search"/>
                </div>
              </div>
              <select id="categories" name="categories" class="select select-bordered join-item">
                <option value="filter" selected>Filtre</option>
                <!-- Afficher dynamiquement les catégories -->
                <?php 
                    $categories = categories($db);
                    foreach ($categories as $key => $value) {
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
          
    <?php      
        
        foreach ($listBooks as $dataBook)
        { 
          echo "<div class = 'globalDataBook'>";

            echo "<tr>";
            echo "<td>";
            echo "<div class='cat'>";
            echo '<img src="'.$dataBook["image_couverture"].'" alt="Couverture du livre">';
            echo "</div>";
            echo "</td>";

            echo "<div class='textDataBook'>";
              $listPseudoUser = $db->listPseudoUser ($dataBook["utilisateur_id"]);
              foreach ($listPseudoUser as $pseudoUser)
              {
                echo "<tr>";
                echo "<td>";
                echo "<div class='pseudo'>";
                echo '<a href="myBooks.php?id='. $pseudoUser["utilisateur_id"] .'">' . $pseudoUser["pseudo"] . "</a>" . "<br> ";
                echo "</div>";
                echo "</td>";
              }

              echo "<div class='directDataBook'>";
                echo "<tr>";
                echo "<td>";
                echo '<a href="book.php?id='. $dataBook["ouvrage_id"] .'">' . $dataBook["titre"] . "</a>" . ", ";
                echo "</td>";
                
                $listAuthorBook = $db->listAuthorBook($dataBook["ecrivain_id"]);
                foreach ($listAuthorBook as $authorBook)
                {
                  echo "<tr>";
                  echo "<td>";
                  echo $authorBook["prenom"] . " ";
                  echo $authorBook["nom"] . "</br>";
                  echo "</td>";
                }
              echo "</div>";
              $listCategoryBook = $db->listCategoryBook ($dataBook["categorie_id"]);
              foreach ($listCategoryBook as $categoryBook)
              {
                echo "<tr>";
                echo "<td>";
                echo $categoryBook["nom"] . " ";
                echo "</td>";
              }
            echo "</div>";

            echo "</tr>";
          echo "</div>";
        }
      ?>
    </main>

    <?php
    include("./views/footer.php");
    ?>
        


        <style>
        .globalDataBook {
          display : flex;
          /* align-items : center;
          justify-content: center;*/
          margin-left: 30%;
          margin-right: 30%;
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
        object-fit: cover;
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
        font-size: 25px;

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


