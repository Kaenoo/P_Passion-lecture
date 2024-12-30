<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Le page pour ajouter un livre
 */
session_start();
include_once("../models/Database.php");
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
$db->addBook($_POST, $_FILES, $_SESSION['user']['userID']);


// Permet de contôler fichier



  

// Aller au page accueil après ajouter un livre
header("location: ../index.php");
exit;
