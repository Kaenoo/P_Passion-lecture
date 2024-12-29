<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Page de création de compte
-->
<?php
session_start();
include("./models/database.php");
include("./controllers/user.php");
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 1) {

  var_dump($_POST);
    // Vérifie si le pseudo existe dans la db, si ce n'est pas le cas -> Création de compte
    if ($db->verifyPseudoExistence($_POST["pseudo"]) !== true) {
      
      // Vérifie si l'user ne s'est pas trompé dans l'entrée des mots de passe
      if ($_POST["password"] === $_POST["password2"]) {
        //Préparation des données
        $date = date("Y-m-d");
        $password = password_hash($_POST["pseudo"], PASSWORD_DEFAULT);
  
        $db->CreateAccount($_POST["lastName"], $_POST["firstName"], $_POST["pseudo"], $password, $date);
        
        // Récupère l'id de l'user
        $userData = $db->getDataAccount($_POST["pseudo"]);
        $idUser = $userData["utilisateur_id"];
        
        //Créer une session au nouvel user
        getConnectedUser(0, $idUser);
      }
      else {
        $error = 'Les mots de passe entrés sont différents !';
      }
    }
    else {
      $error = "Ce pseudo existe déjà, prends-en un autre !";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css">
    <title>Créer un compte</title>
</head>
<body class="h-full">
<?php include("./views/header.php"); ?>

<div class="flex min-h-full flex-col justify-center px-6 py-8 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <!-- <img class="mx-auto h-10 w-auto" src="./img/account.png" alt=""> -->
    <h2 class="mt-5 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Créer un compte</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

    <!-- DEBUT FORMULAIRE -->
    <form class="space-y-6" action="#" method="post" id="formLogin">
        <div>
            <label for="lastName" class="block text-sm/6 font-medium text-gray-900">Nom de famille</label>
            <div class="mt-2">
                <input id="lastName" name="lastName" pattern="[A-Za-z]+" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
            </div>
        </div>

        <div>
            <label for="firstName" class="block text-sm/6 font-medium text-gray-900">Prénom</label>
            <div class="mt-2">
                <input id="firstName" name="firstName" pattern="[A-Za-z]+" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
            </div>
        </div> 

      <div>
        <label for="pseudo" class="block text-sm/6 font-medium text-gray-900">Pseudo</label>
        <div class="mt-2">
          <input id="pseudo" name="pseudo" pattern="[A-Za-z0-9]+" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-900">Mot de passe</label>
        </div>
        <div class="mt-2">
          <input id="password" name="password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
        </div>
      </div>

      <!-- Confirmation du mot de passe -->
      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-900">Confirmation du mot de passe</label>
        </div>
        <div class="mt-2">
          <input id="password2" name="password2" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
        </div>
      </div>

      <!-- En cas d'erreur, le message s'affiche ici -->
      <?php
          if (isset($error)) {
            echo '<p class="text-center font-semibold text-red-700">' . $error . '</p>';
          }
        ?>

      <!-- Validation du compte -->
      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-green-700 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-green-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700">Créer un compte</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6">
      <a href="./index.php" class="font-semibold text-green-700 hover:text-green-600">Retourner à la page d'acceuil</a>
    </p>
  </div>
</div>
</body>
</html>