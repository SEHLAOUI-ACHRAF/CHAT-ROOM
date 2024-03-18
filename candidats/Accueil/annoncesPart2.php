<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Les offres</title>
    <link rel="stylesheet" href="../../recruteur/Accueil/styleprem.css" />
    <link rel="stylesheet" href="annonces.css" />
    <link rel="icon" href="../../img/JOBNET.png" />
</head>

<body>
    <div class="nav-container" style="position: fixed;">
        <nav>
            <div class="user">
                <img id="usernavimage" src="../../img/icon_profile.png" alt="user icon" />
                <div class="name_id">
                    <div id="nomcomplet">
                        <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom'] ?>
                    </div>
                    <div id="iduser">
                        <label for="id"><?php echo '#' . $_SESSION['id']; ?></label>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <a href="profile.php">
                    <button onclick="">
                        <img src="../../img/icon_profile.png" class="buttonimg">
                        <label for="Profile">Profile</label>
                    </button>
                </a>
                <a href="annoncesPart2.php">
                    <button id="selected" onclick="">
                        <img src="../../img/portfolio.png" class="buttonimg">
                        <label for="Annonces">Offres</label>
                    </button>
                </a>
                <a href="cv-form.php">
                    <button onclick="">
                        <img src="../../img/doc.png" class="buttonimg">
                        <label for="mon cv">Mon CV</label>
                    </button>
                </a>
                <a href="messagesAcceuil.php">
                    <button onclick="">
                        <img src="../../img/chat.png" class="buttonimg">
                        <label for="Profile">Messages</label>
                    </button>
                </a>
            </div>
        </nav>
    </div>

    <main style="overflow: auto; margin-left: 25%">
        <div style="margin-top: 30px">

            <?php

            include("../../backend/database.php");

            $query = "SELECT * FROM annonce";
            $result = $bdd->query($query);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $profil = $row['profil'];
                    $entreprise = $row['entreprise'];
                    $lieu = $row['lieu'];
                    $type_contrat = $row['type_contrat'];
                    $date_pub = $row['Date_Pub'];
                    $id = $row['id'];

                    echo '<div class="announcement-center">';
                    echo '<div class="announcement-container">';
                    echo '<div class="user-job-container">';
                    echo '<div class="user-announcement">';
                    echo '<img class="user-img" src="../../img/icon_profile_black.png" alt="user icon" />';
                    echo '<div>';
                    echo '<div class="full-name" id="nomcomplet">' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</div>';
                    echo '<div id="iduser"><label for="id">' . '#' . $id . '</label></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div id="metier">';
                    echo '<p class="job">' . $profil . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="announcement">';
                    echo '<div class="announcement-details">';
                    echo '<p class="title">Entreprise :</p>';
                    echo '<p>' . $entreprise . '</p>';
                    echo '</div>';
                    echo '<div class="announcement-details">';
                    echo '<p class="title">Lieu :</p>';
                    echo '<p>' . $lieu . '</p>';
                    echo '</div>';
                    echo '<div class="announcement-details">';
                    echo '<p class="title">Type de contrat :</p>';
                    echo '<p>' . $type_contrat . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="announcement-footer">';
                    echo '<p class="announcement-date">' . $date_pub . '</p>';
                    echo '<button class="submit-btn" onclick="window.location.href=\'annonceDetails.php?id=' . $id . '\'">Détail</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div style="display: flex; justify-content: center; color: #6A6A6A">';
                echo "<p>Aucune annonce trouvée.</p>";
                echo '</div>';
            }

            $bdd = null;
            ?>

        </div>


        <script src="checkAnnouces.js"></script>
    </main>
</body>

</html>