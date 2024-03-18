<?php
    include("../../backend/database.php");
    try {
        $cvReq = "SELECT * FROM cv
                    WHERE id_utilisateur = ?";

        // Préparation et exécution de la première requête
        $getCv = $bdd->prepare($cvReq);
        $getCv->execute(array($id));

        // Récupération des résultats
        $cv = $getCv->fetch(PDO::FETCH_ASSOC);
        if ($cv) {
            $formDirection="modifier";
            $formChemin = "Cv-updater.php";
            $formButton="Valider";
            $idCv=$cv["idCv"];
            // $_SESSION["idCv"]=$idCv;
            $cvReqInfo = "SELECT * FROM cv,informations,diplome,stage,experpro,certificats,autre
            WHERE cv.idCv = ?";

            // Préparation et exécution de la première requête
            $getCvInfo = $bdd->prepare($cvReqInfo);
            $getCvInfo->execute(array($idCv));

            // Récupération des résultats
            $cvInfo = $getCvInfo->fetch(PDO::FETCH_ASSOC);
            if($cvInfo){
                $profession = $cvInfo["profession"];
                $domaine = $cvInfo["domaine"];
                $etablissement = $cvInfo["etablissement"];
                $diplomeName = $cvInfo["diplomeName"];
                $diplomeDuree = $cvInfo["diplomeDuree"];
                $nomStage = $cvInfo["nomStage"];
                $stageDuree = $cvInfo["stageDuree"];
                $entrepriseStage = $cvInfo["entrepriseStage"];
                $sujet = $cvInfo["sujet"];
                $poste = $cvInfo["poste"];
                $dureeEx = $cvInfo["dureeEx"];
                $entrepriseExp = $cvInfo["entrepriseExp"];
                $certifNom = $cvInfo["certifNom"];
                $interet = $cvInfo["interet"];
            }
        } else {
            $formDirection="cvFormulaire";
            $formChemin = "Cv-inserter.php";
            $formButton="Soumettre";
            // $stmtCv = $bdd->prepare("INSERT INTO Cv (id_utilisateur) VALUES (?)");
            // try {
            //     $stmtCv->execute(array($id));
            // } catch (PDOException $e) {
            //     echo "Une erreur est survenue lors de remplissage : " . $e->getMessage();
            // }
            $profession = "";
            $domaine = "";
            $etablissement = "";
            $diplomeName = "";
            $diplomeDurée = "";
            $nomStage = "";
            $stageDuree = "";
            $entrepriseStage = "";
            $sujet = "";
            $poste = "";
            $dureeEx = "";
            $entrepriseExp = "";
            $certifNom = "";
            $interet = "";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
?>