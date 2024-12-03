<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Le page pour ajouter un livre
 */
session_start();
include("./models/Database.php");
include("./controllers/user.php");

// Vérifie que l'user soit bien connecté
isUserConnected();

$db = new Database();
$categories = $db->listCategories();
$authors = $db->listAuthors();
$ouvrages = $db->listOuvrages();
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

      <form action="./checkaddbook.php" method="POST" enctype="multipart/form-data">
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
              <label for="image" class="block text-gray-600 font-medium mb-2">Image</label>
              <input type="file" id="image" name="image" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-end">
          <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
      </form>
    </div>
  </main>

  <?php
  include("./views/footer.php");
  ?>

</body>
</html>