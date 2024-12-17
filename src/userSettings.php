<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page d'acceuil du site web
-->

<?php
session_start();
include("./controllers/user.php");
include("./models/database.php");
include("./controllers/books.php");
$db = new Database();

//Si l'user veut se déconnecter
if (isset($_GET["login"]) && $_GET["login"] === "out") {   
 deconnectUser();
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

  <main class="lg:px-12 text-justify">
    <h1 class="my-4 text-2xl lg:text-4xl font-bold text-center">Paramètre Profil</h1>


  </main>

  <?php include("./views/footer.php");?>
        
</body>
</html>
