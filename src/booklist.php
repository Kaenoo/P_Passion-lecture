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
    $listBooks = $db->searchBooks($_POST);
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
        <form action="" method="get">
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
      </script>

<<<<<<< HEAD


      <div class="listofbook">
=======
>>>>>>> Sarah
      <?php 
        foreach ($listBooks as $titleBook)

        
        <!-- Barre de recherche -->
         <form action="#" method="get">
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
          </form>
          
          <?php 
        foreach ($listTitleBook as $titleBook)
        { 
          $listCategoryBook = $db->listCategoryBook ($titleBook["categorie_id"]);
          foreach ($listCategoryBook as $categoryBook)
          {
            echo "<tr>";
            echo "<td>";
            echo $categoryBook["nom"] . " ";
            echo "</td>";
          }

          $listPseudoUser = $db->listPseudoUser ($titleBook["utilisateur_id"]);
          foreach ($listPseudoUser as $pseudoUser)
          {
            echo "<tr>";
            echo "<td>";
            echo $pseudoUser["pseudo"] . "</br>";
            echo "</td>";
          }

          echo "<tr>";
          echo "<td>";
          echo $titleBook["titre"] . ", ";
          echo "</td>";
           

          $listAuthorBook = $db->listAuthorBook($titleBook["ecrivain_id"]);
          foreach ($listAuthorBook as $authorBook)
          {
            echo "<tr>";
            echo "<td>";
            echo $authorBook["prenom"] . " ";
            echo $authorBook["nom"] . "</br>";
            echo "</td>";
          }

          echo "</tr>";
        }
      ?>
    </main>

    <?php
    include("./views/footer.php");
    ?>
        
</body>
</body>
</html>


