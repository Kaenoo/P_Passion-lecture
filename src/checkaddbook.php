<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Le page pour ajouter un livre
 */
session_start();
include ("./models/Database.php");
$db = new Database();
echo "<pre>";
var_dump($_POST);
echo "</pre>";

var_dump($_SESSION);
die;
$db->addBook($_POST, $_FILES, $_SESSION["userID"]);

header("location: ./index.php");