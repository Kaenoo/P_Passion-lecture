<?php

function createAccountUser(){
    
}

// Vérifie si l'user utilise un compte 
function isUserConnected() {
    if (isset($_SESSION["user"]) && count($_SESSION["user"]) > 1) {
       return true;
    }
    false;
}

// Connecte l'utilisateur et le redirige à la page d'acceuil
function getConnectedUser($userData) {
    $_SESSION["user"] = [];
    $_SESSION["user"]["surname"] = $userData["nom"];
    $_SESSION["user"]["forename"] = $userData["prenom"];
    $_SESSION["user"]["pseudo"] = $_POST["pseudo"];
    $_SESSION["user"]["admin"] = $userData["admin"];
    $_SESSION["user"]["userID"] = $userData["utilisateur_id"];
    header("Location: ./index.php");
}

// Retourne le pseudo de l'user
function UserPseudo($db, $userID){
    return $db->getPseudoUser($userID);
}

// Vérifie si l'user est admin
function isUserAdmin($db, $userID){
    $right =  $db->getUserRight($userID);

    // Si l'user est admin -> retourne true
    if ($right == 1) {
        return true;
    }
    return false;
}

//Déconnecte l'utilisateur
function deconnectUser() { 
    $_SESSION["user"] = null;
}

?>