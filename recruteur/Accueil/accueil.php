<?php
session_start();

include("../../backend/database.php");

$email = $_SESSION['emailRecruteur'];

try {

    $getUserInfo = $bdd->prepare("SELECT id_utilisateur, Nom, Prenom FROM utilisateur WHERE email = ?");
    $getUserInfo->execute([$email]);
    $userInfo = $getUserInfo->fetch();

    if ($userInfo) {

        $id = $userInfo['id_utilisateur'];
        $Nom = $userInfo['Nom'];
        $Prenom = $userInfo['Prenom'];

        include("accueil.html");
        
    } else {

        echo "User information not found.";
    }
} catch (PDOException $e) {
    echo "Error fetching user information: " . $e->getMessage();
}
?>
