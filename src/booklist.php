<?php 
  /* Auteure       : Sarah Dongmo
  *  Date          : 25.11.2024
  *  Description   : Présentation des livres avec option de recherche */

  session_start();
  include("./models/Database.php");
  $db = new Database();

  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    var_dump($_POST);
    $db->searchABook($_POST);
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
        <form action=#> <!--"booklist.php?search={}"-->
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



      <?php 
        foreach ($listBooks as $titleBook)
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