
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

      <?php 
      if (!isset($_SESSION["user"])) {
        echo '<a href="./login.php">
              <img class="size-12" src="img/account2.png" alt="">
              </a>';
      }
      else { 
        include('./controllers/menu.php'); 
      }
      ?> 

</header>