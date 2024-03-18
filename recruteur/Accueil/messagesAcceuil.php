<?php
session_start();
/*la sécurité*/
if (!isset($_SESSION['id'])) {
    header("Location: ../Accée/Log-in.html");
    exit(); // Stoppe l'exécution du code après la redirection
}

// Configuration de la connexion à la base de données
include("../../backend/database.php");


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
    <title>Messages</title>
    <link rel="stylesheet" href="../../recruteur/Accueil/styleprem.css">
    <link rel="stylesheet" href="messages.css">
    <link rel="icon" href="../../img/JOBNET.png" />
</head>
<body>

<div id="users">
    <?php
    $recupUsers = $bdd->query("SELECT * FROM utilisateur");
    while ($user = $recupUsers->fetch()) {
        ?>
        <a href="messagesPrive.php?id=<?php echo $user['id_utilisateur'] ?>">
        <p><?php echo $user['Nom'] . ' ' . $user['Prenom']; ?></p>
        </a>
        <?php
    }
    ?>
</div>


<div>
    <form method="post" action="">
        <input type="submit" name="logout" value="Se déconnecter">
    </form>
</div>

</body>
</html>
