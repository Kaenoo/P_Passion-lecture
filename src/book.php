<?php
session_start();
include("./controllers/user.php");
include("./models/Database.php");
include("./controllers/books.php");
$db = new Database();

//var_dump(dataBook($db, $_GET["id"]));
$dataBook = dataBook($db, $_GET["id"]);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css">
    <title>Passion Lecture - <?= $dataBook["titre"]?></title>
</head>
<body class="m-auto w-full">
  <?php include("./views/header.php"); ?>

  <main class="px-12 text-justify">
    <h1 class="my-4 text-4xl font-bold text-center"><?= $dataBook["titre"]?></h1>
    <h2 class="my-4 text-xl text-center"><?= writer($db, $dataBook["ecrivain_id"] )?></h2>

    <div></div>
    
  </main>

  <?php include("./views/footer.php");?>
        
</body>
</html>
