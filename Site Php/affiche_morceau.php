<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo']) OR !isset($_POST['morceau'])) {
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
        <title>Info morceau</title>
    </header>


    <body>
        <h1 class='title'><center>Info morceau</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];
        
    
extract($_POST);

echo "<h1> Morceau : </h1>";?>
<div  class = deux><?php
echo "<h2> Groupe : </h2>";

$q = $dbh->prepare("SELECT * 
                    FROM groupe
                    WHERE id_groupe IN (SELECT id_groupe
                                        FROM morceau
                                        WHERE id_morceau = ?)");
$q->execute(array($morceau));
$result = $q->fetchAll();
foreach($result AS $row){
    $nom = $row['nom'];
    $id_groupe = $row['id_groupe'];
    echo "<p> $nom </p>";
    echo "<form action='affiche_groupe.php' method='post'>";
    echo "<input type='hidden' name='groupe' value='$id_groupe'/>";
    echo "<button>détails</button>";
    echo "</form>";
}
?></div>
<div  class = un><?php
echo "<h2> Participants : </h2>";

$q = $dbh->prepare("SELECT * FROM artiste WHERE id_artiste IN (SELECT id_artiste FROM participe WHERE id_morceau = ?)");
$q->execute(array($morceau));
$result = $q->fetchAll();

foreach($result as $row) {
    $prenom = $row['prenom'];
    $nom = $row['nom'];  
    echo "<li>Nom: ".$nom." Prenom : ".$prenom."</li>";}

$sql = "SELECT * FROM morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe WHERE id_morceau = ?";

$q = $dbh->prepare($sql);
$q->execute(array($morceau));
$result = $q->fetchAll();

foreach($result as $row) {
   
    $titre = $row['titre'];
    $paroles = $row['paroles'];  
    $genre = $row['genre'];
    $nom = $row['nom'];
    $id_morceau = $row['id_morceau'];
    echo "<p> $titre de $nom :</p>";
    echo "<p> Genre : $genre :</p>";
    echo "<p> Paroles : $paroles</p>";
    echo "<form action='ecoute.php' method='post'>";
    echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
    echo "<button>écouter</button>";
    echo "</form>";

    //pour chaque playlist du l'utilisateur
    //ajouter des morceaux
    $sql = "SELECT  id_playlist,titre
    FROM playlist NATURAL JOIN utilisateur
    WHERE  pseudo = ? AND id_playlist NOT IN 
    (SELECT id_playlist FROM dans_playlist WHERE id_morceau =?)";

    $q = $dbh->prepare($sql);
    $q->execute(array($pseudo,$id_morceau));
    $result = $q->fetchAll();
    foreach($result as $row) {
       
        $id_playlist =$row['id_playlist'];
        $titre = $row['titre'];


        echo "<form action='add_morceau.php' method='post'>";
        echo "<input type='hidden' name='playlist' value='$id_playlist'/>";
        echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
        echo "<button formaction='add_morceau.php'>ajouter à $titre</button > </form>";
       }
}
    ?></div>
    </body>
</html>