<?php
/*
 * Auteur       : Mustafa Yildiz
 * Date         : 19.11.2024
 * Description  : Le page pour ajouter un livre
 */
session_start();
include("./models/Database.php");
$db = new Database();

// Permet de ajouter un livre
$db->addBook($_POST, $_FILES, $_SESSION['user']['userID']);

// Aller au page accueil après ajouter un livre
header("location: ./index.php");
