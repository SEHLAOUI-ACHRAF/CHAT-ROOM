<?php 
session_start();
$idCv=$_SESSION["idCv"];
include("../../backend/database.php");
if (isset($_POST["modifier"])) {
    try {
        // Update informations table
        $stmt1 = $bdd->prepare("UPDATE informations SET profession = ?, domaine = ?, etablissement = ? WHERE idCv = ?");
        $stmt1->execute(array($profession, $domaine, $etablissement, $idCv));

        // Update diplome table
        $stmt2 = $bdd->prepare("UPDATE diplome SET diplomeName = ?, diplomeDuree = ? WHERE idCv = ?");
        $stmt2->execute(array($diplomeName, $diplomeDuree, $idCv));

        // Update stage table
        $stmt3 = $bdd->prepare("UPDATE stage SET nomStage = ?, stageDuree = ?, entrepriseStage = ?, sujet = ? WHERE idCv = ?");
        $stmt3->execute(array($nomStage, $stageDuree, $entrepriseStage, $sujet, $idCv));

        // Update experPro table
        $stmt4 = $bdd->prepare("UPDATE experPro SET poste = ?, dureeEx = ?, entrepriseExp = ? WHERE idCv = ?");
        $stmt4->execute(array($poste, $dureeEx, $entrepriseExp, $idCv));

        // Update certificats table
        $stmt5 = $bdd->prepare("UPDATE certificats SET certifNom = ? WHERE idCv = ?");
        $stmt5->execute(array($certifNom, $idCv));
        
        // Update Autre table
        $stmt5 = $bdd->prepare("UPDATE autre SET interet = ? WHERE idCv = ?");
        $stmt5->execute(array($interet, $idCv));
        header("Location: cv-info.php");
    } catch(PDOException $e) {
        echo "An error occurred while updating data: " . $e->getMessage();
    }
}
?>
