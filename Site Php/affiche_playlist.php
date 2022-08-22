<?php

include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo']) OR !isset($_POST['playlist'])) {
    header("Location: index.php");
    die();
}

$id_playlist =  $_POST['playlist'];
$_SESSION['playlist'] = $id_playlist;
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
        <li><a href="actualite.php">Actualite</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul><?php 

$id_playlist =  $_POST['playlist'];
$q = $dbh->prepare("SELECT titre, id_user
                    FROM playlist
                    WHERE id_playlist =  ?");
$q->execute(array($id_playlist));
$result = $q->fetch();
$titre = $result['titre'];
$auteur = $result['id_user'];
$q = $dbh->prepare("SELECT pseudo
                    FROM utilisateur
                    WHERE id_user =  ?");
$q->execute(array($auteur));
$result = $q->fetch();
$pseudoauteur = $result['pseudo'];
$_SESSION['playlist'] = $id_playlist;
echo "<h2>".$titre." de ".$pseudoauteur."</h2>";


 //statut de la playlist
 if ($auteur == $_SESSION['id_user']){
    echo "<form action='statut_playlist.php' method='post'>";
    echo "<input type='hidden' name='playlist' value='$id_playlist'/>";
    echo "<button> modifier le statut de ma playlist</button>";
    echo "</form>";
 }
$q = $dbh->prepare("SELECT titre,id_morceau, nom
                    FROM dans_playlist NATURAL JOIN  (morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe) AS gr
                    WHERE id_playlist =  ?");
$q->execute(array($id_playlist));
$result = $q->fetchAll();

foreach($result as $row) {
    $titre = $row['titre'];
    $id_morceau = $row['id_morceau'];
    $nom = $row['nom'];

    echo "<p>titre : ".$titre." statut : ".$nom."</p>";

    //info sur le morceau
    echo "<form action='affiche_morceau.php' method='post'>";
    echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
    echo "<button>détails</button>";
    echo "</form>";

    //supprimer le morceau
    if ($auteur == $_SESSION['id_user']){
        echo "<form action='supprimer_morceau.php' method='post'>";
        echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
        echo "<input type='hidden' name='playlist' value='$id_playlist'/>";
        echo "<button>enlever de la playlist</button>";
        echo "</form>";
    }



}

?>

</body>
</html>
