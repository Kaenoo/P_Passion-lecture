<!-- 
Auteur : Kaeno Eyer
Date : 03.12.2024
Description :  Controller de tout ce qui concerne les utilisateurs
-->
<?php

include_once("./models/Database.php");

class userController
{
    private $db;

    // Constructeur
    public function __construct()
    {
        $this->db = new Database();
    }


    //Créer un compte utilisateur
    public function createAccountUser($lastName, $firstName, $pseudo, $password, $date)
    {
        $this->db->CreateAccount($lastName, $firstName, $pseudo, $password, $date);
    }

    // Vérifie les identifiants lors de la connexion
    public function verifyLogin($pseudo, $password)
    {
        $verify = $this->db->getDataAccount($pseudo);

        // Retourne false si le pseudo n'est pas trouvé ou que le mot de passe n'est pas bon
        if (count($verify) == 0) {
            return false;
        } elseif (password_verify($password, $verify["mot_de_passe"]) === false) {
            return false;
        }

        return true;
    }

    // Vérifie si l'user utilise un compte 
    public function isUserConnected()
    {
        if (isset($_SESSION["user"]) && count($_SESSION["user"]) > 1) {
            return true;
        }
        false;
    }

    // Connecte l'utilisateur et le redirige à la page d'acceuil
    public function getConnectedUser($userID)
    {
        $userData = $this->db->getDataAccount($userID);

        $_SESSION["user"] = [];
        $_SESSION["user"]["surname"] = $userData["nom"];
        $_SESSION["user"]["forename"] = $userData["prenom"];
        $_SESSION["user"]["pseudo"] = $userData["pseudo"];
        $_SESSION["user"]["admin"] = $userData["admin"];
        $_SESSION["user"]["userID"] = $userData["utilisateur_id"];
        header("Location: ./index.php");
        exit;
    }

    // Retourne le pseudo de l'user
    public function UserPseudo($userID)
    {
        return $this->db->getPseudoUser($userID);
    }

    // Vérifie si l'user est admin
    public function isUserAdmin($userID)
    {
        $right = $this->db->getUserRight($userID);

        // Si l'user est admin -> retourne true
        if ($right == 1) {
            return true;
        }
        return false;
    }

    // Change les données d'un user en effectuant des vérifications avant
    public function verifyAndChangeData($surname, $forename, $pseudo)
    {
        // Dans le cas d'un nouveau pseudo entré, vérifie s'il n'existe pas déjà
        if ($this->verifyPseudoExistence($pseudo) === false || $pseudo === $_SESSION["user"]["pseudo"]) {
            // Mise à jour des données
            $this->db->changeDataUser($_SESSION["user"]["userID"], $surname, $forename, $pseudo);
            $_SESSION["user"]["surname"] = $forename;
            $_SESSION["user"]["forename"] = $forename;
            $_SESSION["user"]["pseudo"] = $pseudo;

            return 'Les données ont bien été modifiées';
        } else {
            return  'Le pseudo existe déjà !';
        }
    }

    // Change le mot de passe d'un user en effectuant des vérifications avant
    public function verifyAndChangePassword($userID, $postActualPassword, $newPassword, $newPassword2)
    {
        $acutalPassword = $this->db->getPasswordUser($userID);

        // Vérifie si le mot de passe acutel entré correspond à celui de la db
        if (password_verify($postActualPassword, $acutalPassword)) {
            // Si le nouveau mot de passe est identique sur les 2 entrés -> changement de mot de passe 
            if ($newPassword === $newPassword2) {

                $finalPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->db->changePassword($userID, $finalPassword);
            } else {
                return 'Le nouveau mot de passe n\'est pas identique entre les deux entrées !';
            }
        } else {
            return 'Le mot passe entré est incorrect !';
        }

        return 'Le mot de passe a bien été modifié !';
    }

    // Vérifie l'existence d'un pseudo dans la db
    public function verifyPseudoExistence($pseudo)
    {
        $verify = $this->db->getDataAccount($pseudo);

        if ($verify !== null) {
            return true;
        }

        return null;
    }

    // Affiche le pseudo d'un utilisateur
    public function listPseudoUser($data){
        return $this->db->getListPseudoUser($data);
    }

    //Déconnecte l'utilisateur
    public function deconnectUser()
    {
        $_SESSION["user"] = null;
    }
}
