<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  En-tête du site web
-->
<?
$userController = new userController();
?>

<header class="sticky z-50 top-0 flex items-center py-6 px-4 lg:px-28 bg-green-700">
    <a href="../index.php">
      <img class="w-52 sm:w-80" src="./img/iconWebsite.png" alt="Logo du site">  
    </a>

    <!-- Menu version ordinateur -->
    <div class="hidden lg:visible lg:flex lg:ml-auto lg:space-x-14 pt-8">
      
      <?php if (isset($_SESSION["user"])) {
        echo '<a href="./addBook.php">
        <img class="lg:size-12" src="img/addBook.png" alt="Ajouter un ouvrage">
      </a>';}?>
      <a href="./bookList.php">
        <img class="lg:size-12" src="img/book_list.png" alt="Liste des ouvrages">
      </a>

      <div class="flex flex-col">
        <?php 
        if (!isset($_SESSION["user"])) {
          echo '<a href="./login.php">
                <img class="lg:size-12" src="img/account.png" alt="Compte utilisateur">
                </a>';
        }
        else { 
          include('./controllers/menu.php'); 
        }
        
        if ($userController->isUserConnected()) {
          echo '<p class="text-center font-semibold text-lg">' . $_SESSION["user"]["pseudo"] . '</p>';
        }
        ?>
      </div>
</div>

    <!-- Menu version mobile -->
    <div class="lg:hidden flex ml-auto">
      <div class="dropdown dropdown-end">
        <img tabindex="0" class="size-9" src="../img/menu_Hamburger.svg" alt="menu Hamburger">
        <ul tabindex="0" class="dropdown-content menu bg-base-100 z-50 mt-6 w-max p-2 shadow">
          <li>
            <?php if (isset($_SESSION["user"])) {
              echo '<a href="./addBook.php">
              <img class="size-7" src="img/addBook.png" alt="Ajouter un ouvrage">
              </a>';}?>
          </li>
          <li>
            <a href="./bookList.php">
              <img class="size-7" src="img/book_list.png" alt="Liste des ouvrages">
            </a>
          </li>
          <li>
          <?php 
            if (!isset($_SESSION["user"])) {
              echo '<a href="./login.php">
                    <img class="size-7" src="img/account.png" alt="Compte utilisateur">
                    </a>';
            }
            else { 
              echo ' <details open>
                      <summary>
                        <img class="size-7" src="img/account.png" alt="Compte utilisateur">
                      </summary>
                      <ul>
                        <li>
                          <a href="../userSettings.php" class="block px-4 py-2" role="menuitem" tabindex="-1" id="menu-item-0">
                            <img class="size-7" src="../img/settings.png" alt="Paramètres">
                          </a>
                        </li>
                        <li>
                          <a href="../myBooks.php?userID=' . $_SESSION["user"]["userID"] . '" class="block px-4 py-2" role="menuitem" tabindex="-1" id="menu-item-1">
                            <img class="size-7" src="../img/myBooks.png" alt="Mes ouvrages">
                          </a>
                        </li>
                        <li>
                          <a href="../index.php?login=out" class="block px-4 py-2" role="menuitem" tabindex="-1" id="menu-item-2">
                            <img class="size-7" src="../img/logOut.png" alt="Déconnexion">
                          </a>
                        </li>
                      </ul>
                    </details>'; 
            }?>
          </li>
        </ul>
    </div>

   
    </div>

    
       
        
</header>