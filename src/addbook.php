<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Le page pour ajouter un livre
 */


// Affichage les erreurs
// echo "<pre>";
// var_dump($errors);
// echo "</pre>";

session_start();
include("./models/database.php");
include("./controllers/user.php");
$userController = new userController();
$editeurs = [];

// Vérifie que l'user soit bien connecté
if ($userController->isUserConnected() === false) {
  header("Location: ./index.php");
  exit;
}

$db = new Database();

// pour stocker les editeurs
$ouvrages = $db->listOuvrages();

// permet de mettre les editeurs dans le list
foreach ($ouvrages as $ouvrage) {
  $editeurs[] = $ouvrage['editeur'];
}


// permet d'eviter le $_POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST["authorNom"])) {

    // Ajouter un auteur
    $author = $db->addAuteur($_POST);
    //header("Location: ./addBook.php");
  } elseif (isset($_POST["categorieNom"])) {

    // Ajouter un catégorie
    $categorie = $db->addCategorie($_POST);
    //header("Location: ./addBook.php");
  } elseif (isset($_POST["editeur"])) {

    // Ajouter un editeur
    $editeurs[] = $_POST["editeur"];
  } else {

    echo "Erreur";
  }
}

$categories = $db->listCategories();
$authors = $db->listAuthors();

function addList($data, $addData)
{
  $data[] += $addData;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/output.css">
  <title>Accueil - Passion lecture Add Book</title>
</head>

<body class="m-auto w-full">
  <?php
  include("./views/header.php");
  ?>
  <main class="text-center">
    <!-- Form Section -->
    <h1 class="my-4 text-4xl font-bold text-center">Ajouter un ouvrage</h1>

    <div class="p-6">
      <form action="./controllers/checkAddBook.php" method="post" enctype="multipart/form-data">
        <div class="grid grid-cols-2 gap-6">
          <!-- Left Column -->
          <div>
            <!-- Titre -->
            <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
              <div class="w-1/4">
                <label for="title" class="block text-gray-600 font-medium">Titre</label>
              </div>
              <div class="w-3/4">
                <input type="text" id="title" name="title" class="border border-gray-300 rounded-lg px-4 py-2 w-full" required>
              </div>
            </div>

            <!-- Auteur -->
            <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
              <div class="w-1/4">
                <label for="author" class="block text-gray-600 font-medium">Auteur</label>
              </div>
              <div class="w-3/4">
                <select id="author" name="author" class="border border-gray-300 rounded-lg px-4 py-2 w-full" required>
                  <option value="" disabled selected>-- Sélectionnez un auteur --</option>
                  <?php foreach ($authors as $author): ?>
                    <option value=<?= $author['ecrivain_id']; ?>>
                      <?= $author['prenom'] . " " . $author['nom']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="modalAddAuteur.showModal()">+</button>
              <dialog id="modalAddAuteur" class="modal">
                <div class="modal-box">
                  <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button>
                  </form>
                  <div class="flex items-center justify-center">
                    <form action="#" method="post" class="space-y-4">
                      <h3 class="text-lg font-bold">Ajouter un auteur!</h3>
                      <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour ajouter</p>
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

            </div>

            <!-- Catégorie -->
            <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
              <div class="w-1/4">
                <label for="category" class="block text-gray-600 font-medium">Catégorie</label>
              </div>
              <div class="w-3/4">
                <select id="category" name="category" class="border border-gray-300 rounded-lg px-4 py-2 w-full" required>
                  <option value="" disabled selected>-- Sélectionnez une catégorie --</option>
                  <?php foreach ($categories as $category): ?>
                    <option value=<?= $category['categorie_id']; ?>>
                      <?= $category['nom']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="modalAddCategorie.showModal()">+</button>
              <dialog id="modalAddCategorie" class="modal">
                <div class="modal-box">
                  <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button>
                  </form>
                  <div class="flex items-center justify-center">
                    <form action="#" method="post" class="space-y-4">
                      <h3 class="text-lg font-bold">Ajouter une catégorie!</h3>
                      <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour ajouter</p>
                      <label class="input input-bordered flex items-center gap-2">
                        <input id="addCategorie" name="categorieNom" type="text" class="grow" placeholder="Categorie" />
                      </label>
                      <button type="submit" class="btn w-full mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                        Ajouter
                      </button>
                    </form>
                  </div>
                </div>
              </dialog>
            </div>

            <?php
            $data[0][0] = "Nombre de pages";
            $data[0][1] = "pages";
            $data[1][0] = "Extrait";
            $data[1][1] = "extrait";

            for ($i = 0; $i < 2; $i++) {
              $html = '<div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                        <div class="w-1/4">
                        <label for="' . $data[$i][1] . '" class="block text-gray-600 font-medium">' . $data[$i][0] . '</label>
                        </div>
                        <div class="w-3/4">
                        <input id="' . $data[$i][1] . '" name="' . $data[$i][1] . '" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                        </div>
                        </div>';
              echo $html;
            }
            ?>

            <!-- Éditeur -->
            <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
              <div class="w-1/4">
                <label for="publisher" class="block text-gray-600 font-medium">Éditeur</label>
              </div>
              <div class="w-3/4">
                <select id="publisher" name="publisher" class="border border-gray-300 rounded-lg px-4 py-2 w-full" required>
                  <option value="" disabled selected>-- Sélectionnez un editeur --</option>
                  <?php foreach ($editeurs as $editeur): ?>
                    <option>
                      <?= $editeur; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="modalAddEditeur.showModal()">+</button>
              <dialog id="modalAddEditeur" class="modal">
                <div class="modal-box">
                  <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button>
                  </form>
                  <div class="flex items-center justify-center">
                    <form action="#" method="post" class="space-y-4">
                      <h3 class="text-lg font-bold">Ajouter un editeur!</h3>
                      <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour ajouter</p>
                      <label class="input input-bordered flex items-center gap-2">
                        <input id="addEditeur" name="editeur" type="text" class="grow" placeholder="Editeur" />
                      </label>
                      <button type="submit" class="btn w-full mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                        Ajouter
                      </button>
                    </form>
                  </div>
                </div>
              </dialog>
            </div>

            <!-- Date d'édition -->
            <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
              <div class="w-1/4">
                <label for="published_date" class="block text-gray-600 font-medium">Date d'édition</label>
              </div>
              <div class="w-3/4">
                <input type="number" id="published_date" default="2000" name="published_date" class="border border-gray-300 rounded-lg px-4 py-2 w-full" max="9999" placeholder="YYYY">
              </div>
            </div>

            <!-- Résumé -->
            <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
              <div class="w-1/4">
                <label for="summary" class="block text-gray-600 font-medium">Résumé</label>
              </div>
              <div class="w-3/4">
                <textarea id="summary" name="summary" class="border border-gray-300 rounded-lg px-4 py-2 w-full"></textarea>
              </div>
            </div>
          </div>


          <!-- Right Column -->
          <!-- Image -->
          <div>
            <div class="mb-4">
              <p class="text-gray-600 font-medium mb-2 py-5">Image</p>
              <input action="./controllers/checkAddBook.php" type="file" name="image" id="image" onchange="loadFile(event)" method="post" enctype="multipart/form-data">
              <img id="output" />
              <script src="./js/loadFile.js"></script>
            </div>
            <!-- Submit Button -->
            <div class="mt-6 flex justify-end">
              <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
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