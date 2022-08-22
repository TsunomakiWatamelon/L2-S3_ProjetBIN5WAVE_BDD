<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo']) OR !isset($_POST['album'])) {
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
        <li><a href="actualite.php">Actualite</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>
        <title>Info album</title>
    </header>


    <body>
        <h1 class='title'><center>Info album</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];
    
        
$album = $_POST['album'];
$sql = "SELECT * FROM album JOIN groupe ON auteur = id_groupe WHERE id_album = ? ";
$q = $dbh->prepare($sql);
$q->execute(array($album));
$result = $q->fetchAll();
?>
<div  class = deux><?php
echo "<h1> Info : </h1>";
foreach($result as $row) {
    $titre = $row['titre'];
    $groupe = $row['nom'];
    $parution = $row['date_parution'];
    $descript = $row['descript'];
    echo "<p>Groupe : ".$groupe." Titre : ".$titre."</p>";
    echo "<p>Date de parution : $parution</p>";
    echo "<p>Description : $descript </p>";
}?></div>
<div  class = un><?php
echo "<h1> morceaux : </h1>";
$sql = "SELECT * FROM (SELECT * FROM morceau NATURAL JOIN dans_album WHERE id_album = ?) AS a JOIN groupe ON a.id_groupe = groupe.id_groupe ORDER BY numero ASC";
$q = $dbh->prepare($sql);
$q->execute(array($album));
$result = $q->fetchAll();
foreach($result as $row) {
    $titre = $row['titre'];
    $id_morceau = $row['id_morceau'];
    $nomgroupe = $row['nom'];
    $numero = $row['numero'];
    if (is_null($numero)){
        $numero = 'Non classifié';
    }
    echo "<p>$numero : $titre de $nomgroupe :</p>";
    echo "<form action='affiche_morceau.php' method='post'>";
    echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
    echo "<button>détails</button>";
    echo "</form>";
};

    




?></div>
    </body>

</html>