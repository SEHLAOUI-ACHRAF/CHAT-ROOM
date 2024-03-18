<?php

session_start();

include("../../backend/database.php");

$id = $_SESSION['id'];
if (isset($_POST["filtreCv"])) {
    $ville = htmlspecialchars($_POST["ville"]);
    $age = htmlspecialchars($_POST["age"]);
    $domaine = htmlspecialchars($_POST["domaine"]);
    $sexe = htmlspecialchars($_POST["sexe"]);
    $diplome = htmlspecialchars($_POST["diplome"]);
    $diplomeScore = $_POST["diplomeScore"];
    $stageScore = $_POST["stageScore"];
    $experienceScore = $_POST["experienceScore"];
    $certifScore = $_POST["certifScore"];
}

try {
    $candidat = "SELECT * FROM utilisateur
                  WHERE ville = ?
                  AND YEAR(NOW()) - YEAR(datenaissance) = ?
                  AND sexe = ?
                  LIMIT 1";

    // Préparation et exécution de la première requête
    $getUserInfo = $bdd->prepare($candidat);
    $getUserInfo->execute(array($ville, $age, $sexe));

    // Récupération des résultats
    $userInfo = $getUserInfo->fetch(PDO::FETCH_ASSOC);
    if ($userInfo) {
        $id_utilisateur = $userInfo['id_utilisateur'];
        // Si l'utilisateur existe, recherche du CV correspondant
        $cvQuery = "SELECT *
                FROM Cv
                WHERE id_utilisateur = ?
                  AND idCv IN (
                      SELECT idCv
                      FROM informations
                      WHERE domaine = ?
                      AND idCv IN (
                          SELECT idCv
                          FROM diplome
                          WHERE nomDiplome = ?
                      )
                  )
                  LIMIT 1";

        // Préparation et exécution de la deuxième requête
        $getCvInfo = $bdd->prepare($cvQuery);
        $getCvInfo->execute(array($id_utilisateur, $domaine, $diplome));

        // Récupération des résultats des CV
        $cvInfo = $getCvInfo->fetch(PDO::FETCH_ASSOC);
        if($cvInfo){
            $cv = "SELECT nomDiplome, nomStage, poste as nomExp
             FROM Cv, diplome, stage, experPro
             WHERE Cv.idCv=stage.idCv AND
                   Cv.idCv=diplome.idCv AND
                   Cv.idCv=experPro.idCv
             LIMIT 1";

        // Préparation et exécution de la troisième requête
        $getCvInfo = $bdd->prepare($cv);
        $getCvInfo->execute();
        $cvResults = $getCvInfo->fetch(PDO::FETCH_ASSOC);
        $diplomeCv = $cvResults["nomDiplome"];
        $stageCv = $cvResults["nomStage"];
        $expérienceCv = $cvResults["nomExp"];
        include("afficheCv.html");
        }
        else{
            echo "Cv n'existe pas";
        }
    }
    else{
        echo "utilisateur n'existe pas";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
