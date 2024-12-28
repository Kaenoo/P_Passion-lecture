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
  header("Location: ./index.php");
}
var_dump($_POST);
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
    <h1 class="mt-4 mb-8 text-2xl lg:text-4xl font-bold text-center">Paramètre Profil</h1>

    <!-- Formulaire pour changer des données -->
    <form action="" method="post">

      <div class="flex flex-col items-center gap-4 mt-5">
        <label class="flex items-center justify-center input input-bordered w-72">
          <span class="flex-none font-bold mr-2">Nom :</span>
          <input type="text" name="surname" id="surname" class="grow" placeholder="<?= $_SESSION["user"]["surname"] ?>" />
        </label>
        <label class="flex items-center justify-center input input-bordered w-72">
          <span class="flex-none font-bold mr-2">Prénom :</span>
          <input type="text" name="forename" id="forename" class="grow" placeholder="<?= $_SESSION["user"]["forename"] ?>" />
        </label>
        <label class="flex items-center justify-start input input-bordered w-72">
          <span class="flex-none font-bold mr-2">Pseudo :</span>
          <input type="text" name="pseudo" id="pseudo" class="grow" placeholder="<?= $_SESSION["user"]["pseudo"] ?>" />
        </label>
        <button class="btn bg-green-700 text-lg text-white font-semibold hover:bg-green-600" type="submit">Sauvegarder</button>
      </div>
    </form>

    <!-- Modal pour changer de mot de passe -->
    <div class="flex gap-4 items-center justify-center mt-8">
      <button class="text-lg hover:bg-gray-300" onclick="my_modal_3.showModal()">Changer de mot de passe</button>
      <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
          <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
          </form>
          <div class="flex flex-col items-center justify-center">
            <form action="" method="post">
              <div class="mt-2">
                <div class="flex items-center justify-between">
                  <label for="password" class="block w-80 text-sm/6 font-medium text-gray-900">Mot de passe actuel</label>
                </div>
                <div class="mt-2">
                  <input id="password" name="password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
                </div>
              </div>

              <div class="mt-2">
                <div class="flex items-center justify-between">
                  <label for="password" class="block w-80 text-sm/6 font-medium text-gray-900">Nouveau mot de passe</label>
                </div>
                <div class="mt-2">
                  <input id="newpassword" name="newpassword" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
                </div>
              </div>

              <!-- Confirmation du mot de passe -->
              <div class="mt-2">
                <div class="flex items-center justify-between">
                  <label for="password" class="block w-80 text-sm/6 font-medium text-gray-900">Confirmation du mot de passe</label>
                </div>
                <div class="mt-2">
                  <input id="newpassword2" name="newpassword2" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-700 sm:text-sm/6">
                </div>
              </div>
              <button type="submit" class="btn w-48 mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                Confirmer
              </button>
            </form>
            <!-- METTRE UNE NOTIF OU MODAL CONFIRMANT LE CHANGEMENT -->
          </div>

        </div>
      </dialog>

    </div>

  </main>
  <?php include("./views/footer.php"); ?>
</body>

</html>