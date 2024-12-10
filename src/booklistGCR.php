<?php 
  /* Auteure       : Sarah Dongmo
  *  Date          : 25.11.2024
  *  Description   : Présentation des livres avec option de recherche */

  session_start();
  include("./models/database.php");
  $db = new Database();

  if ($_SERVER["REQUEST_METHOD"] === "GET") 
  {
 
    // foreach($_POST as $k => $value){echo $value;};
    $listBooks = $db->searchABook($_GET["search"]);
    
  }
  else
  {
    $listBooks = $db->listBooks();
    var_dump($listBooks);
   // InitialList();
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
      <?php include("./views/header.php"); ?>
      <main>
        <h1 class="py-4 text-4xl font-bold text-center">Liste des ouvrages</h1>
        <div class="search-container">
          <form action="" method="GET">
            <input type="text" placeholder="Search.." id="search" name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
          <?php
          $html = "";
          foreach($listBooks as $book) {
            $html .= "<div>";
            $html .= $book["titre"];
            $html .= "</div>";
          }
          echo $html;
          ?>
        </div>
      </main>
      <?php include("./views/footer.php"); ?>
    </body>
  </html>

