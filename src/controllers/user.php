<?php

function isUserConnected() {

    return isset($_SESSION["user"]) && count($_SESSION["user"]) > 1;
}

function getConnectedUser() {
    if (isUserConnected())
        return $_SESSION["user"]["useLogin"];
}

function getUserRight() {
    if (isUserConnected()){
        $value = $_SESSION["user"]["useAdministrator"] == 0 ? "user" : "admin"; 
        return $value;
    }
    return false;
}

function isAdmin(){
    if (getUserRight() !== "admin") {
        header("Location: ./index.php");
    }    
}

function deconnectUser() {
    $_SESSION["user"] = null;
}

?>