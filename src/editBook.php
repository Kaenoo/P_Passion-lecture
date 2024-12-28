<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 24.12.2024
 * Description  : Le page pour editer un livre
 */

session_start();
include("./models/database.php");
include("./controllers/user.php");
$editeurs = [];

// Vérifie que l'user soit bien connecté
if (isUserConnected() === false) {
  header("Location: ./index.php");
  exit;
}

$db = new Database();

// pour stocker les editeurs
$ouvrages = $db->listBooks();

// pour stocker actuel livre
$actuelBook;

// permet de mettre les editeurs dans le list
foreach ($ouvrages as $ouvrage) {
  if ($_GET['id'] == $ouvrage['ouvrage_id']) {
    $actuelBook = $ouvrage;
  }
}

// Affichage les erreurs
echo "<pre>";
var_dump($actuelBook);
echo "</pre>";

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

echo "<pre>";
var_dump($_POST);
echo "</pre>";

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
  <main>
    <div class="text-center">
      <!-- Form Section -->
      <h2 class="text-2xl font-semibold text-gray-700 mb-6">Ajouter un ouvrage</h2>
      <div class="p-6">
        <form action="./controllers/checkEditBook.php" method="post" enctype="multipart/form-data">
          <div class="grid grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
              <!-- Titre -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                <input type="hidden" name="ouvrage_id" value="<?php echo $actuelBook['ouvrage_id']?>">
                  <label for="title" class="block text-gray-600 font-medium">Titre</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <input type="text" id="title" name="title" class="border border-gray-300 rounded-lg px-4 py-2 w-full" value="<?php echo $actuelBook['titre']?>" required>
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
                      


                    <?php if($actuelBook['ecrivain_id'] == $author['ecrivain_id']){
                        echo "lkjgbkc";
                        
                    }?>


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
                      <form action="" method="post" class="space-y-4">
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

                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded-lg shadow" onclick="modalAddCategorie.showModal()">+</button>
                <dialog id="modalAddCategorie" class="modal">
                  <div class="modal-box">
                    <form method="dialog">
                      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">X</button>
                    </form>
                    <div class="flex items-center justify-center">
                      <form action="#" method="post" class="space-y-4">
                        <h3 class="text-lg font-bold">Ajouter un categorie!</h3>
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

              <!-- Nombre de pages -->
              <div class="flex items-start space-x-4 border-2 border-gray-500 rounded-lg p-4 mb-4">
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="pages" class="block text-gray-600 font-medium">Nombre de pages</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <input id="pages" name="pages" class="border border-gray-300 rounded-lg px-4 py-2 w-full" value="<?php echo $actuelBook['nombre_page']?>">
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
                  <input type="text" id="extrait" name="extrait" class="border border-gray-300 rounded-lg px-4 py-2 w-full" value="<?php echo $actuelBook['extrait']?>">
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
                <!-- Gauche: Label -->
                <div class="w-1/4">
                  <label for="published_date" class="block text-gray-600 font-medium">Date d'édition</label>
                </div>
                <!-- Droite: Input -->
                <div class="w-3/4">
                  <input type="number" id="published_date" name="published_date" class="border border-gray-300 rounded-lg px-4 py-2 w-full" min="1000" max="9999" placeholder="YYYY" value="<?php echo $actuelBook['date_edition']?>">
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
                  <textarea id="summary" name="summary" class="border border-gray-300 rounded-lg px-4 py-2 w-full" <?php echo $actuelBook['resume']?>><?php echo $actuelBook['resume']?></textarea>
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
                <script>
                  var loadFile = function(event) {
                    var output = document.getElementById('output');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = function() {
                      URL.revokeObjectURL(output.src) // free memory
                    }
                  };
                </script>
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
  </div>

  <?php
  include("./views/footer.php");
  ?>

</body>

</html>