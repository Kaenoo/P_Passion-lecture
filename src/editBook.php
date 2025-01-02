<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 24.12.2024
 * Description  : Le page pour editer un livre
 */

session_start();

include("./controllers/user.php");
$userController = new userController();

include("./controllers/books.php");
$booksController = new booksController();

// Vérifie que l'user soit bien connecté
if ($userController->isUserConnected() === false) {
  header("Location: ./index.php");
  exit;
}

// Instanciation de variables
$categories = $booksController->categories();
$authors = $booksController->authors();

if (!isset($_SESSION["user"]["editeurs"])) {
  $_SESSION["user"]["editeurs"] = $booksController->editors();
}
$editeurs = $_SESSION["user"]["editeurs"];

// Données de l'ouvrage
$dataBook = $booksController->dataBook($_GET["id"]);
// S'il y a une requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Ajoute un auteur
  if (isset($_POST["authorNom"])) {
    $author = $booksController->updateAuthor(htmlspecialchars($_POST["authorNom"], ENT_QUOTES), htmlspecialchars($_POST["authorPrenom"], ENT_QUOTES));
  }
  // Ajoute une catégorie
  elseif (isset($_POST["categorieNom"])) {
    $categorie = $booksController->updateCategory(htmlspecialchars($_POST["categorieNom"], ENT_QUOTES));
  }
  // Ajoute un éditeur
  elseif (isset($_POST["editeur"])) {
    $newEditeurs = $editeurs;
    $newEditeurs[] = ["editeur" => htmlspecialchars($_POST["editeur"], ENT_QUOTES)];
    $editeurs = $newEditeurs;
    $_SESSION["user"]["editeurs"] = $newEditeurs;
  }

  // Modifie un ouvrage si les conditions sont remplies
  if (isset($_POST["submit"])) {
    // Si un nouveau fichier est entrée -> ajout dans le répertoire et suppression de l'ancien
    if (isset($_FILES["image"]["size"]) && $_FILES["image"]["size"] > 0) {
      $booksController->deleteImgCoverBook($dataBook["image_couverture"]);
      $source = $_FILES["image"]["tmp_name"];
      $destination = "./imgCoverBook/" . $_FILES["image"]["name"]; // permet de définir le chemin du ficher ainsi que son nom
      move_uploaded_file($source, $destination);
    } else {
      $destination = $dataBook["image_couverture"];
    }

    $booksController->changeBook($_POST, $destination, $_SESSION['user']['userID']);
    header("Location: ./index.php");
    exit;
  }

  header("Location: ./addBook.php?id={$_GET["id"]}");
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <title>Ajouter un ouvrage - Passion lecture</title>
</head>

<body class="m-auto w-full">
  <?php
  include("./views/header.php");
  ?>
  <main class="text-center">
    <!-- Form Section -->
    <h1 class="my-4 text-3xl md:text-4xl font-bold text-center">Modifier un ouvrage</h1>

    <div class="p-6">
      <form action="#" method="post" enctype="multipart/form-data">
        <div class="md:grid md:grid-cols-2 md:gap-6">
          <!-- Left Column -->
          <div class="md:col-start-1">
            <!-- Titre -->
            <div class="flex flex-col items-center md:items-start gap-2">
              <label for="title" class="ml-3 text-gray-600 text-lg font-medium">Titre</label>
              <input type="text" id="title" name="title" placeholder="<?= $dataBook["titre"]; ?>" value="<?= $dataBook["titre"]; ?>" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 w-4/5" required>
            </div>

            <!-- Auteur -->
            <div class="flex flex-col items-center md:items-start gap-2">
              <label for="author" class="ml-3 text-gray-600 text-lg font-medium">Auteur</label>
              <div class="flex justify-center md:justify-normal items-center md:items-start gap-1 w-full">
                <select id="author" name="author" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 w-9/12">
                  <option value="<?= $dataBook["ecrivain_id"]; ?>" selected><?= $booksController->writerBook($dataBook["ecrivain_id"]); ?></option>
                  <?php
                  foreach ($authors as $key => $author) {
                    if ($author["ecrivain_id"] !== $dataBook["ecrivain_id"]) {
                      $html = '<option value="' . $author["ecrivain_id"] . '">' . $author["prenom"] . ' ' . $author["nom"] . '</option>';
                      echo $html;
                    }
                  } ?>
                </select>
                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="modalAddAuteur.showModal()">+</button>
              </div>
            </div>

            <dialog id="modalAddAuteur" class="modal">
              <div class="modal-box">
                <form method="dialog">
                  <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button>
                </form>
                <div class="flex items-center justify-center">
                  <form action="" method="post" class="space-y-4">
                    <h3 class="text-lg font-bold">Ajouter un auteur</h3>
                    <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour quitter</p>
                    <label class="input input-bordered flex items-center gap-2">
                      <input id="author" name="authorPrenom" type="text" class="grow" placeholder="Prénom" />
                    </label>
                    <label class="input input-bordered flex items-center gap-2">
                      <input id="author" name="authorNom" type="text" class="grow" placeholder="Nom" />
                    </label>
                    <button type="submit" class="btn w-full mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                      Ajouter
                    </button>
                  </form>
                </div>
              </div>
            </dialog>


            <!-- Catégorie -->
            <div class="flex flex-col items-center md:items-start gap-2">
              <label for="category" class="ml-3 text-gray-600 text-lg font-medium">Catégorie</label>
              <div class="flex justify-center md:justify-normal items-center md:items-start gap-1 w-full">
                <select id="category" name="category" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 w-9/12">
                  <option value="<?= $dataBook["categorie_id"]; ?>" selected><?= $booksController->categoryBook($dataBook["categorie_id"])  ?></option>
                  <?php
                  foreach ($categories as $key => $value) {
                    if ($value["categorie_id"] !== $dataBook["categorie_id"]) {
                      $html = '<option value="' . $value["categorie_id"] . '">' . $value["nom"] . '</option>';
                      echo $html;
                    }
                  } ?>
                </select>
                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="modaladdCategory.showModal()">+</button>
              </div>
            </div>

            <dialog id="modaladdCategory" class="modal">
              <div class="modal-box">
                <form method="dialog">
                  <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button>
                </form>
                <div class="flex items-center justify-center">
                  <form action="#" method="post" class="space-y-4">
                    <h3 class="text-lg font-bold">Ajouter une catégorie</h3>
                    <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour quitter</p>
                    <label class="input input-bordered flex items-center gap-2">
                      <input id="addCategory" name="categorieNom" type="text" class="grow" placeholder="Catégorie" />
                    </label>
                    <button type="submit" class="btn w-full mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                      Ajouter
                    </button>
                  </form>
                </div>
              </div>
            </dialog>

            <!-- Nombre de pages -->
            <div class="flex flex-col items-center md:items-start gap-2">          
            <label for="pages" class="ml-3 text-gray-600 text-lg font-medium">Nombre de pages</label>
            <input id="pages" name="pages" pattern="^[0-9]+$" value="<?= $dataBook["nombre_page"]; ?>" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 w-4/5" required>
            </div>

            <!-- Extrait -->
            <div class="flex flex-col items-center md:items-start gap-2">          
            <label for="extrait" class="ml-3 text-gray-600 text-lg font-medium">Extrait au format PDF (optionnel)</label>
            <input id="extrait" name="extrait" pattern="\.pdf$" value="<?= $dataBook["extrait"]; ?>" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 w-4/5">
            </div>

            <!-- Éditeur -->
            <div class="flex flex-col items-center md:items-start gap-2">
              <label for="publisher" class="ml-3 text-gray-600 text-lg font-medium">Éditeur</label>
              <div class="flex justify-center md:justify-normal items-center md:items-start gap-1 w-full">
                <select id="publisher" name="publisher" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 w-9/12">
                  <option value="<?= $dataBook["editeur"]; ?>" selected><?= $dataBook["editeur"]; ?></option>
                  <?php
                  foreach ($editeurs as $key => $editeur) {
                    if ($editeur["editeur"] !== $dataBook["editeur"]) {
                      $html = '<option>' . $editeur["editeur"] . '</option>';
                      echo $html;
                    }
                  } ?>
                </select>
                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="modalAddEditeur.showModal()">+</button>
              </div>
            </div>
            <dialog id="modalAddEditeur" class="modal">
              <div class="modal-box">
                <form method="dialog">
                  <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button>
                </form>
                <div class="flex items-center justify-center">
                  <form action="#" method="post" class="space-y-4">
                    <h3 class="text-lg font-bold">Ajouter un éditeur</h3>
                    <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour quitter</p>
                    <label class="input input-bordered flex items-center gap-2">
                      <input id="addEditeur" name="editeur" type="text" class="grow" placeholder="Éditeur" />
                    </label>
                    <button type="submit" class="btn w-full mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                      Ajouter
                    </button>
                  </form>
                </div>
              </div>
            </dialog>

            <!-- Date d'édition -->
            <div class="flex flex-col items-center md:items-start gap-2">
              <label for="published_date" class="ml-3 text-gray-600 text-lg font-medium">Date d'édition</label>
              <input type="number" id="published_date" name="published_date" value="<?= $dataBook["date_edition"] ?>" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 w-4/5" max="9999" placeholder="YYYY" required>
            </div>

            <!-- Résumé -->
            <div class="flex flex-col items-center md:items-start gap-2">
              <label for="summary" class="ml-3 text-gray-600 text-lg font-medium">Résumé</label>
              <textarea id="summary" name="summary" class="border mb-3 border-gray-300 rounded-lg px-4 py-2 min-h-[100px] w-4/5" required><?= $dataBook["resume"] ?></textarea>
            </div>
          </div>


          <!-- Right Column -->
          <!-- Image -->
          <div class="md:col-start-2">
            <div class="flex flex-col items-center md:col-start-2 content-center mb-4">
              <p class="text-gray-600 font-medium mb-2 py-5">Image de couverture</p>
              <input action="#" type="file" accept=".png, .jpg, .jpeg" name="image" id="image" onchange="loadFile(event)" method="post" enctype="multipart/form-data">
              <img class="pt-5 w-80 h-auto" id="output" />
              <img class="pt-5 w-80 h-auto" id="defaultImage" src="<?= $dataBook["image_couverture"]; ?>" alt="image de couverture">
              <script src="./js/loadFile.js"></script>
            </div>
            <!-- Submit Button -->
            <div class="md:flex md:justify-end md:mt-28 md:mr-10">
              <input type="hidden" name="ouvrage_id" value="<?= $dataBook["ouvrage_id"]; ?>">
              <button type="submit" name="submit" value="save" class="bg-green-700 hover:bg-green-600 text-white text-lg font-medium px-6 py-2 rounded-lg">Enregistrer</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>
  <?php
  include("./views/footer.php");
  ?>

</body>

</html>