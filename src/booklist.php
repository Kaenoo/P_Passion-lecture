<?php 
  /* Auteure       : Sarah Dongmo
  *  Date          : 25.11.2024
  *  Description   : Présentation des livres avec option de recherche */
session_start();
  include("./models/Database.php");
  include("./controllers/books.php");
  $db = new Database();
  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    $db->searchABook($_POST);
  }
  else
  {
    // $listTitleBook = $db->listTitleBook ();
    // $listAuthorBook = $db->listAuthorBook($listTitleBook["ecrivain_id"]);
    // $listPseudo = $db->listPseudo ($listTitleBook["utilisateur_id"]);
    // $listCategoryBook = $db->listCategoryBook ($listTitleBook["categorie_id"]);
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
        <form action=#> <!--"booklist.php?search={}"-->
          <input type="text" placeholder="Search.." id="search" name="search" oninput="myFunction()">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>

      <script>
      function myFunction() 
      {
        <? $searchValue = '"document.getElementById("search").value';
           $db->searchABook($searchValue);?>
      }
      </script>
        
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
          echo "<tr>";
          echo "<td>";
          echo $teacher['teaName'] . " " . $teacher['teaFirstname'];
          echo "</td>";
          echo "<td>";
          echo $teacher['teaNickname'];
          echo "</td>";
          echo "<td class='containerOptions'>";
          echo "</td>";
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