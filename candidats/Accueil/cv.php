<?php

    session_start();

    include("../../backend/database.php");
    $id=$_SESSION['id'];

    $stmtCv = $bdd->prepare("INSERT INTO Cv (id_utilisateur) VALUES (?)");
    try{
       $stmtCv->execute(array($id));
    } catch(PDOException $e) {
        echo "Une erreur est survenue lors de le remplissage : " . $e->getMessage();
    }

    try {

        $getUserInfo = $bdd->prepare("SELECT id_utilisateur, Nom, Prenom FROM utilisateur WHERE id_utilisateur = ?");
        $getCvInfo = $bdd->prepare("SELECT idCv FROM cv WHERE id_utilisateur = ?");

        $getUserInfo->execute([$id]);
        $getCvInfo->execute([$id]);
        $userInfo = $getUserInfo->fetch();
        $cvInfo = $getCvInfo->fetch();
    
        if ($userInfo || $cvInfo) {
    
            $Nom = $userInfo['Nom'];
            $Prenom = $userInfo['Prenom'];
            $idCv = $cvInfo['idCv'];
    
            include("cvs.html");
            
            if (isset($_POST["cvFormulaire"])) {
                $profession = htmlspecialchars($_POST["profession"]);
                $domaine = htmlspecialchars($_POST["domaine"]);
                $etablissement = htmlspecialchars($_POST["etablissement"]);
                $diplomeName = htmlspecialchars($_POST["diplomeName"]);
                $diplomeDurée = htmlspecialchars($_POST["diplomeDurée"]);
                $nomStage = htmlspecialchars($_POST["nomStage"]);
                $stageDuree = htmlspecialchars($_POST["stageDuree"]);
                $entrepriseName = htmlspecialchars($_POST["entrepriseName"]);
                $sujet=htmlspecialchars($_POST["sujet"]);
                $poste = htmlspecialchars($_POST["poste"]);
                $dureeEx = htmlspecialchars($_POST["dureeEx"]);
                $entreprise = htmlspecialchars($_POST["entreprise"]);
                $certifNom = htmlspecialchars($_POST["certifNom"]);
                $interet = htmlspecialchars($_POST["interet"]);
                $langue = htmlspecialchars($_POST["langue"]);
            
                $stmt1 = $bdd->prepare("INSERT INTO informations (profession, domaine, etablissement, idCv) VALUES (?, ?, ?, ?)");
                $stmt2 = $bdd->prepare("INSERT INTO diplome (nom, duree, idCv) VALUES (?, ?, ?)");
                $stmt3 = $bdd->prepare("INSERT INTO stage (nom, duree, entreprise, sujet, idCv) VALUES (?, ?, ?, ?, ?)");
                $stmt4 = $bdd->prepare("INSERT INTO experPro (poste, duree, entreprise, idCv) VALUES (?, ?, ?, ?)");
                $stmt5 = $bdd->prepare("INSERT INTO certificats(nom, idCv) VALUES (?, ?)");
                $stmt6 = $bdd->prepare("INSERT INTO Autre(interet, langues, idCv) VALUES (?, ?, ?)");
            
                try {
                    $stmt1->execute(array($profession, $domaine, $etablissement, $idCv));
                    $stmt2->execute(array($diplomeName, $diplomeDurée, $idCv));
                    $stmt3->execute(array($nomStage, $stageDuree, $entrepriseName, $sujet, $idCv));
                    $stmt4->execute(array($poste, $dureeEx, $entreprise, $idCv));
                    $stmt5->execute(array($certifNom, $idCv));
                    $stmt6->execute(array($interet, $langue, $idCv));
                    echo "Data successfully inserted into the database.";
                } catch(PDOException $e) {
                    echo "An error occurred while inserting data: " . $e->getMessage();
                }
            }

        } else {
    
            echo "User information not found.";
        }
    } catch (PDOException $e) {
        echo "Error fetching user information: " . $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit('POST request method required');
    }
    
    if (empty($_FILES)) {
        exit('$_FILES is empty - is file_uploads set to "On" in php.ini?');
    }
    
    // Use fileinfo to get the mime type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($_FILES["cv"]["tmp_name"]);
    
    // Check if the uploaded file is a PDF
    if ($mime_type !== "application/pdf") {
        exit("Invalid type de fichier importer un fichier pdf svp !.");
    }
    
    // Replace any characters not \w- in the original filename
    $pathinfo = pathinfo($_FILES["cv"]["name"]);
    
    $base = $pathinfo["filename"];
    
    $base = preg_replace("/[^\w-]/", "_", $base);
    
    $filename = $base . "." . $pathinfo["extension"];
    
    $destination = __DIR__ . "/CVpdf/" . $filename;
    
    // Add a numeric suffix if the file already exists
    $i = 1;
    
    while (file_exists($destination)) {
    
        $filename = $base . "($i)." . $pathinfo["extension"];
        $destination = __DIR__ . "/CVpdf/" . $filename;
    
        $i++;
    }
    
    if (!move_uploaded_file($_FILES["cv"]["tmp_name"], $destination)) {
    
        exit("Can't move uploaded file");
    
    }
    
    echo "File uploaded successfully.";

    
?>