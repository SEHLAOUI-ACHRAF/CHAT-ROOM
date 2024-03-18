<?php
session_start();
/*la sécurité*/
if (!isset($_SESSION['id'])) {
    header("Location: ../Accée/Log-in.html");
    exit(); // Stoppe l'exécution du code après la redirection
}

// Configuration de la connexion à la base de données
include("../../backend/database.php");
/* Insertion de message envoyé dans la base de données */
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $recupUsers = $bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
    $recupUsers->execute(array($getid));
    $users = $recupUsers->fetch();
    if ($users) {
        if (isset($_POST["envoyer"])) {
            if (!empty($_POST["message"])) {
                $message = htmlspecialchars($_POST["message"]);
                // Requête d'insertion de message dans la base de données
                $insertmsg = $bdd->prepare("INSERT INTO message (contenu , receiver, sender) VALUES (?, ?, ?)");
                $insertmsg->execute(array($message, $getid, $_SESSION['id']));
            }
        }
    } else {
        echo "Aucun utilisateur trouvé";
    }
} else {
    echo "Aucun ID trouvé";
}

// Déconnexion de l'utilisateur
if (isset($_POST['logout'])) {
    // Détruire toutes les données associées à la session courante
    session_unset();
    // Détruire la session
    session_destroy();
    // Redirection vers une page de connexion ou une autre page appropriée
    header("Location:../Accée/Log-in.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Conversations</h1>
<div class="Conversations">
    <section id="messages">
        <?php
        if (isset($getid)) {
            $recupMsg = $bdd->prepare("SELECT * FROM message WHERE (sender=? AND receiver=?) OR (sender=? AND receiver=?)");
            $recupMsg->execute(array($_SESSION['id'], $getid, $getid, $_SESSION['id']));
            while ($msg = $recupMsg->fetch()) {
                $messageColor = ($msg['receiver'] == $_SESSION['id']) ? 'blue' : 'red';
                ?>
                <p style="color: <?= $messageColor; ?>;"><?= htmlspecialchars($msg['contenu']); ?></p>
                <?php
            }
        }
        ?>
    </section>
</div>


<div id="EnvoiMessage">
    <form method="post" action="">
        <textarea name="message"></textarea>
        <br><br>
        <input type="submit" name="envoyer">
    </form>
</div>

<div>
    <form method="post" action="">
        <input type="submit" name="logout" value="Se deconnecter">
    </form>
</div>

  
  
</body>
</html>

