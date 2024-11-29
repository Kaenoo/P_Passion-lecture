<?php

function createAccountUser(){
    
}

// Vérifie si l'user utilise un compte 
function isUserConnected() {
    if (isset($_SESSION["user"]) && count($_SESSION["user"]) > 1) {
       return true;
    }
    else{
        header("Location: ./index.php");
    }
    
}

// Connecte l'utilisateur et le redirige à la page d'acceuil
function getConnectedUser($admin) {
    $_SESSION["user"] = [];
    $_SESSION["user"]["pseudo"] = $_POST["pseudo"];
    $_SESSION["user"]["password"] = $_POST["password"];
    $_SESSION["user"]["admin"] = $admin;
    header("Location: ./index.php");
}

//Déconnecte l'utilisateur
function deconnectUser() { 
    $_SESSION["user"] = null;
}

?>