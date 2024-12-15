<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Le page pour ajouter un livre
 */
session_start();
include("./models/database.php");
include("./controllers/user.php");

// Vérifie que l'user soit bien connecté
if (isUserConnected() !== true) {
  header("Location: ./index.php");
}


$db = new Database();
$categories = $db->listCategories();
$authors = $db->listAuthors();
$ouvrages = $db->listOuvrages();
$author = $db->addAuteur($_POST);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $action = $_POST['action'] ?? '';

//   if ($action === 'addAuteur') {
//     // addAuteur
//   } elseif ($action === 'addCategorie') {
//     // addCategorie
//     $categorie = $db->addCategorie($_POST);
//   } elseif ($action === 'addEditeur') {
//     // addEditeur
//     // $author = $db->addEditeur($_POST);
//   } else {
//     echo "Erreur";
//   }
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Processus de téléchargement de fichiers
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/'; // Répertoire à installer
    $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

    // Vérifiez l'existence du répertoire et créez-le sinon
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Téléchargement du fichier
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
      $uploadedFilePath = $uploadFile;
    } else {
      $error = "Une erreur s'est produite lors du téléchargement du fichier.";
    }
  } else {
    $error = "Vous n'avez pas sélectionné un fichier valide.";
  }
}

var_dump($_FILES);

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

  <main>
    <div class="text-center">
      <!-- Form Section -->
      <h2 class="text-2xl font-semibold text-gray-700 mb-6">Ajouter un ouvrage</h2>
      <div class="p-6">
        <form action="./controllers/checkAddBook.php" method="POST" enctype="multipart/form-data">
          <div class="grid grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
              <!-- Titre -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="title" class="block text-gray-600 font-medium">Titre</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <input type="text" id="title" name="title" class="border border-gray-300 rounded-lg px-4 py-2 w-full" required>
                </div>
              </div>

              <!-- Auteur -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="author" class="block text-gray-600 font-medium">Auteur</label>
                </div>
                <!-- Droite: Input -->
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




                <!-- Open the modal using ID.showModal() method -->
                <!-- <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="my_modal_3.showModal()">+</button>
                <dialog id="my_modal_1" class="modal">
                  <div class="modal-box">

                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>

                    <h3 class="text-lg font-bold">Ajouter un auteur!</h3>
                    <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour ajouter</p>
                    <label class="input input-bordered flex items-center gap-2">

                      <input id="author" name="authorPrenom" type="text" class="grow" placeholder="Prénom" />
                    </label>
                    <label class="input input-bordered flex items-center gap-2">

                      <input id="author" name="authorNom" type="text" class="grow" placeholder="Nom" />
                    </label>




                    <div class="modal-action">
                      <form action="./addAuteur.php" method="POST"> -->
                <!-- if there is a button in form, it will close the modal -->

                <!-- <button type="submit" class="btn">Ajouter</button>
                      </form>
                    </div>
                  </div>
                </dialog> -->


                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="my_modal_3.showModal()">+</button>
                <dialog id="my_modal_3" class="modal">
                  <div class="modal-box">
                    <form method="dialog">
                      <!-- <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button> -->
                    </form>
                    <div class="flex items-center justify-center">
                      <form action="asfdfsf" method="post" class="space-y-4">
                        <h3 class="text-lg font-bold">Ajouter un auteur!</h3>
                        <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour ajouter</p>
                        <label class="input input-bordered flex items-center gap-2">
                          <input type="hidden" name="addAuteur" value="addAuteur">
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
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="category" class="block text-gray-600 font-medium">Catégorie</label>
                </div>
                <!-- Droite: Input -->
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
                <!-- <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="my_modal_3.showModal()">+</button>
                <dialog id="my_modal_3" class="modal">
                  <div class="modal-box">
                    <form method="dialog"> -->
                      <!-- <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button> -->
                    <!-- </form>
                    <div class="flex items-center justify-center">
                      <form action="#" method="post" class="space-y-4">
                        <h3 class="text-lg font-bold">Ajouter un aCategorie!</h3>
                        <p class="py-4">Appuyez sur la touche ESC ou cliquez sur le bouton ci-dessous pour ajouter</p>
                        <label class="input input-bordered flex items-center gap-2">
                          <input type="hidden" name="addCategorie" value="addCategorie">
                          <input id="addCategorie" name="categorieNom" type="text" class="grow" placeholder="Categorie" />
                        </label>
                        <button type="submit" class="btn w-full mt-4 bg-green-700 text-lg text-white font-semibold hover:bg-green-600">
                          Ajouter
                        </button>
                      </form>
                    </div>

                  </div>
                </dialog> -->
              </div>

              <!-- Nombre de pages -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="pages" class="block text-gray-600 font-medium">Nombre de pages</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <input id="pages" name="pages" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                </div>
              </div>

              <!-- Extrait -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="extrait" class="block text-gray-600 font-medium">Extrait</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <input type="text" id="extrait" name="extrait" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                </div>
              </div>

              <!-- Éditeur -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="publisher" class="block text-gray-600 font-medium">Éditeur</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <select id="publisher" name="publisher" class="border border-gray-300 rounded-lg px-4 py-2 w-full" required>
                    <option value="" disabled selected>-- Sélectionnez un editeur --</option>
                    <?php foreach ($ouvrages as $ouvrage): ?>
                      <option>
                        <?= $ouvrage['editeur']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow">
                  +
                </button>
              </div>

              <!-- Date d'édition -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="published_date" class="block text-gray-600 font-medium">Date d'édition</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <input type="number" id="published_date" name="published_date" class="border border-gray-300 rounded-lg px-4 py-2 w-full" min="1000" max="9999" placeholder="YYYY">
                </div>
              </div>

              <!-- Résumé -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="summary" class="block text-gray-600 font-medium">Résumé</label>
                </div>
                <!-- Droite: Input -->
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
                <!-- <input type="file" id="image" name="image" hidden>
                <label class="border border-gray-300 rounded-lg px-4 py-5 w-full" for="image">Insérer une image</label> -->
                <form action="" method="post" enctype="multipart/form-data">
                  <label for="photo"></label>
                  <input type="file" name="photo" id="photo" accept="image/*">
                  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Charger</button>
                </form>
              </div>
              <div class="col-start-1 flex justify-center">
                <div class="flex justify-center items-center py-5">
                  <!-- <img class="object-contain w-3/5 h-auto" src="./imgCoverBook/La-Treve.jpg" alt="Sunset in the mountains"> -->
                  <?php if (!empty($error)): ?>
                    <p style="color: red;">Erreur: <?php echo htmlspecialchars($error); ?></p>
                  <?php endif; ?>

                  <?php if (!empty($uploadedFilePath)): ?>
                    <img class="object-contain w-3/5 h-auto" src="<?php echo htmlspecialchars($uploadedFilePath); ?>" alt="Photo téléchargée" style="max-width: 100%; height: auto;">
                  <?php endif; ?>
                </div>
              </div>
              <div class="font-bold text-xl mb-2"><?php echo $_FILES['photo']['name'] ?></div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
          </div>
        </form>
      </div>
  </main>
  </div>

  <?php
  include("./views/footer.php");
  ?>

</body>

</html>