<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Le page pour contrôlere de editer un livre
 */
session_start();
include("C:\Users\Mustafa\Desktop\Projets\P_Passion-lecture\src\models\Database.php");

// if (!$this->isUserAuthorized($userID, $id_ouvrage)) {
//     throw new RuntimeException("Vous n'êtes pas autorisé à mettre à jour ce livre.");
// };

echo "<pre>";
var_dump($_POST);
echo "</pre>";

echo "<pre>";
var_dump($_FILES);
echo "</pre>";

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
$db = new Database();


// Permet de ajouter un livre
$db->editBook($_POST, $_FILES, $_SESSION['user']['userID']);


// Permet de contôler fichier





// Aller au page accueil après ajouter un livre
header("location: ../index.php");
exit;