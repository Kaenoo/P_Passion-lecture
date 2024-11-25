<?php
include("../controllers/user.php");
?>

<header class="flex items-center py-6 px-28 bg-green-700">
    <a href="../index.php">
      <h1 class="text-4xl font-bold">Passion Livre</h1>
    </a>

    <div class="flex ml-auto space-x-14 ">
      
      <?php if (isset($_SESSION["user"])) {
        echo '<a href="./addbook.php">
        <img class="size-12" src="img/addBook.png" alt="">
      </a>';}?>
      <a href="./booklist.php">
        <img class="size-12" src="img/book_list.png" alt="">
      </a>
      <?php if (!isset($_SESSION["user"])) {
        echo '<a href="./login.php">
              <img class="size-12" src="img/account2.png" alt="">
              </a>';}
              else {
                # proposer le menu dropdown avec log out et ajout d'ouvrages + bonus paramètre
              }?>
      

      <div class="relative inline-block text-left">
  <img 
    src="../img/account2.png" 
    alt="Options" 
    class="size-12"
    id="menu-button" 
    onclick="toggleMenu()" 
    aria-expanded="false" 
    aria-haspopup="true"
  />

  <div 
    id="dropdown-menu" 
    class="absolute right-0 z-10 mt-2 w-16 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none transform opacity-0 scale-95 transition ease-in-out duration-100"
    role="menu" 
    aria-orientation="vertical" 
    aria-labelledby="menu-button" 
    tabindex="-1"
  >
    <div class="py-1" role="none">
      <a href="#" class="block px-4 py-2" role="menuitem" tabindex="-1" id="menu-item-0">
        <img class="size-7" src="../img/settings.png" alt="Paramètres">
      </a>
      <a href="#" class="block px-4 py-2" role="menuitem" tabindex="-1" id="menu-item-1">
        <img class="size-7" src="../img/myBooks.png" alt="Mes ouvrages">
      </a>
      <a href="#" class="block px-4 py-2" role="menuitem" tabindex="-1" id="menu-item-2">
        <img class="size-7" src="../img/logOut.png" alt="Déconnexion">
      </a>
    </div>
  </div>
</div>

<script>
  function toggleMenu() {
    const menu = document.getElementById("dropdown-menu");
    const isVisible = menu.classList.contains("opacity-100");

    if (isVisible) {
      // Masquer le menu
      menu.classList.remove("opacity-100", "scale-100");
      menu.classList.add("opacity-0", "scale-95");
    } else {
      // Afficher le menu
      menu.classList.remove("opacity-0", "scale-95");
      menu.classList.add("opacity-100", "scale-100");
    }
  }

  // Cacher le menu si l'utilisateur clique en dehors
  window.addEventListener("click", (event) => {
    const menu = document.getElementById("dropdown-menu");
    const button = document.getElementById("menu-button");
    if (!menu.contains(event.target) && !button.contains(event.target)) {
      menu.classList.remove("opacity-100", "scale-100");
      menu.classList.add("opacity-0", "scale-95");
    }
  });
</script>


  </header>