<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  En-tête du site web
-->
<header class="flex items-center py-6 px-4 lg:px-28 bg-green-700">
    <a href="../index.php">
      <h1 class="text-lg font-bold lg:text-4xl ">Passion Lecture</h1>
    </a>

    <div class="flex ml-auto space-x-10 lg:space-x-14 ">
      
      <?php if (isset($_SESSION["user"])) {
        echo '<a href="./addBook.php">
        <img class="size-8 lg:size-12" src="img/addBook.png" alt="Ajouter un ouvrage">
      </a>';}?>
      <a href="./booklist.php">
        <img class="size-8 lg:size-12" src="img/book_list.png" alt="Liste des ouvrages">
      </a>

      <?php 
      if (!isset($_SESSION["user"])) {
        echo '<a href="./login.php">
              <img class="size-8 lg:size-12" src="img/account2.png" alt="Compte utilisateur">
              </a>';
      }
      else { 
        include('./controllers/menu.php'); 
      }
      ?> 

</header>