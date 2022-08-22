<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
    <header>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <link rel="stylesheet" href="thewave.css">
        <ul> 
        <li><a href="page_daccueil.php">Accueil</a></li>
        <li><a href="page_daccueil_perso.php">Mon profil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>
        <title>Actualités</title>
    </header>


    <body>
        <h1 class='title'><center>Actualités</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];?>
<div  class = deux><?php  
 

//    $q = $dbh->prepare("SELECT count(*), id_morceau, titre, nom FROM ecoute NATURAL JOIN (morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe) AS max2021  WHERE date_ecoute > CURRENT_DATE - INTERVAL '100 days' GROUP BY id_morceau, titre, nom ORDER BY count DESC LIMIT 5");
//    $q->execute();
//    $result = $q->fetch();
    echo "<h3> Morceaux des groupes suivis: </h3>";
    $q = $dbh->prepare("SELECT id_morceau, titre, nom 
                      FROM morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe
                      WHERE groupe.id_groupe IN (SELECT id_groupe
                                                 FROM suis_groupe
                                                 WHERE id_user = ?
                                                 AND parametre = 'M' OR parametre ='AM' OR parametre = 'MA'
                                                 )
                      LIMIT 5");
    $q->execute(array($_SESSION['id_user']));
    $result = $q->fetchAll();
    foreach($result as $row) {
        $titre = $row['titre'];
        $nom = $row['nom'];
        $id_morceau = $row['id_morceau'];
        echo "<p> $titre de $nom :</p>";
        echo "<form action='affiche_morceau.php' method='post'>";
        echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
        echo "<button>détails</button>";
        echo "</form>";
    };?></div>
    <div  class = un><?php
    echo "<h3> Albums des groupes suivis: </h3>";
    $q = $dbh->prepare("SELECT id_album, titre, nom
                      FROM album NATURAL JOIN groupe
                      WHERE id_groupe IN (SELECT id_groupe
                                          FROM suis_groupe
                                          WHERE id_user = ?
                                          AND parametre = 'A' OR parametre ='AM' OR parametre = 'MA'
                                          )
                      ORDER BY date_parution DESC
                      LIMIT 5;");
    $q->execute(array($_SESSION['id_user']));
    $result = $q->fetchAll();
    foreach($result as $row) {
        $titre = $row['titre'];
        $id_album = $row['id_album'];
        echo "<p>$titre :</p>";
        echo "<form action='affiche_album.php' method='post'>";
        echo "<input type='hidden' name='album' value='$id_album'/>";
        echo "<button>détails</button>";
        echo "</form>";
    };?></div>

    <div class = ‘deux’><h3>Playlists des utilisateurs suivis</h3><?php

    $sql = "SELECT  *
            FROM playlist 
            WHERE  id_user IN (SELECT id_user2 as id_user FROM suis_user WHERE id_user = ?)
            AND visible = true";
    $q = $dbh->prepare($sql);
    $user = $_SESSION['id_user'];
    $q->execute(array($user));
    $result = $q->fetchAll();
    foreach($result as $row) {
        $titre = $row['titre'];
        $descript =$row['descript'];
        $id_playlist =$row['id_playlist'];

        echo "<p>titre : ".$titre." Description : ".$descript."</p>";
        echo "<form action='affiche_playlist.php' method='post'>";
        echo "<input type='hidden' name='playlist' value='$id_playlist'/>";
        echo "<button>détails</button>";
        echo "</form>";
    }
?>

</body>

</html>