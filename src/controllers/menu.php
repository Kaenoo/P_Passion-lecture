<?php
if (isset($_GET["login"]) && $_GET["login"] === "out") {   
    $_SESSION["user"] = null;
}
?>
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
        <a href="../index.php?login=out" class="block px-4 py-2" role="menuitem" tabindex="-1" id="menu-item-2">
          <img class="size-7" src="../img/logOut.png" alt="Déconnexion">
        </a>
      </div>
    </div>
  </div>
  <script src="../js/menuDropdown.js"></script>