<?php

function createAccountUser() {}

// Vérifie si l'user utilise un compte 
function isUserConnected()
{
    if (isset($_SESSION["user"]) && count($_SESSION["user"]) > 1) {
        return true;
    }
    false;
}

// Connecte l'utilisateur et le redirige à la page d'acceuil
function getConnectedUser($userData)
{
    $_SESSION["user"] = [];
    $_SESSION["user"]["surname"] = $userData["nom"];
    $_SESSION["user"]["forename"] = $userData["prenom"];
    $_SESSION["user"]["pseudo"] = $_POST["pseudo"];
    $_SESSION["user"]["admin"] = $userData["admin"];
    $_SESSION["user"]["userID"] = $userData["utilisateur_id"];
    header("Location: ./index.php");
}

// Retourne le pseudo de l'user
function UserPseudo($db, $userID)
{
    return $db->getPseudoUser($userID);
}

// Vérifie si l'user est admin
function isUserAdmin($db, $userID)
{
    $right = $db->getUserRight($userID);

    // Si l'user est admin -> retourne true
    if ($right == 1) {
        return true;
    }
    return false;
}

// Change les données d'un user en effectuant des vérifications avant
function verifyAndChangeData($db, $surname, $forename, $pseudo)
{
    // Dans le cas d'un nouveau pseudo entré, vérifie s'il n'existe pas déjà
    if ($db->verifyPseudoExistence($pseudo) === false || $pseudo === $_SESSION["user"]["pseudo"]) {
        // Mise à jour des données
        $db->changeDataUser($_SESSION["user"]["userID"], $surname, $forename, $pseudo);
        $_SESSION["user"]["surname"] = $forename;
        $_SESSION["user"]["forename"] = $forename;
        $_SESSION["user"]["pseudo"] = $pseudo;

        return 'Les données ont bien été modifiées';
    } else {
        return  'Le pseudo existe déjà !';
    }
}

// Change le mot de passe d'un user en effectuant des vérifications avant
function verifyAndChangePassword($db, $userID, $postActualPassword, $newPassword, $newPassword2)
{
    $acutalPassword = $db->getPasswordUser($userID);

    // Vérifie si le mot de passe acutel entré correspond à celui de la db
    if (password_verify($postActualPassword, $acutalPassword)) {
        // Si le nouveau mot de passe est identique sur les 2 entrés -> changement de mot de passe 
        if ($newPassword === $newPassword2) {

            $finalPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $db->changePassword($userID, $finalPassword);
        } else {
            return 'Le nouveau mot de passe n\'est pas identique entre les deux entrées !';
        }
    } else {
        return 'Le mot passe entré est incorrect !';
    }

    return 'Le mot de passe a bien été modifié !';
}

//Déconnecte l'utilisateur
function deconnectUser()
{
    $_SESSION["user"] = null;
}
