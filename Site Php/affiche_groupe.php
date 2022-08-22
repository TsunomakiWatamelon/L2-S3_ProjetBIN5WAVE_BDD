<?php include "connection.inc.php";
session_start();
if (isset($_SESSION['return']) AND !isset($_POST['groupe'])){
    $_POST['groupe'] = $_SESSION['return'];
    unset($_SESSION['return']);
}
if (!isset($_SESSION['pseudo']) OR !isset($_POST['groupe'])) {
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
        <title>Info groupe</title>
    </header>


    <body>
        <h1 class='title'><center>Info groupe</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];
      

$groupe = $_POST['groupe'];
$sql = "SELECT * FROM groupe WHERE id_groupe = ? ";
$q = $dbh->prepare($sql);
$q->execute(array($groupe));
$result = $q->fetchAll();?>
<div  class = deux><?php
echo "<h1> Info : </h1>";
foreach($result as $row) {
    $genre = $row['genre'];
    $nom = $row['nom'];  
    $nomgroupe = $row['nom'];  
    $nationalite = $row['nationalite'];  
    echo "<li>Groupe : ".$nom."</li>";
    echo "<li>Genre : ".$genre."</li>";
    echo "<li>Nationalite : ".$nationalite."</li>";
    
}
?></div>
<div  class = un><?php
echo "<h1> Artistes composant le groupe : </h1>";
$sql = "SELECT nom, prenom FROM artiste WHERE id_artiste IN (SELECT id_artiste FROM appartient WHERE id_groupe = ? AND depart IS NULL);
";
$q = $dbh->prepare($sql);
$q->execute(array($groupe));
$result = $q->fetchAll();

foreach($result as $row) {
   
    $prenom = $row['prenom'];
    $nom = $row['nom'];  
    
    echo "<li>Nom: ".$nom." Prenom : ".$prenom."</li>";
}
?></div>
<div  class = un><?php
echo "<h1> Historique des membres : </h1>";

$sql = "SELECT nom, prenom, depart, arrivee FROM artiste NATURAL JOIN appartient WHERE id_groupe = ? ORDER BY arrivee DESC";
$q = $dbh->prepare($sql);
$q->execute(array($groupe));
$result = $q->fetchAll();

foreach($result as $row) {
   
    $prenom = $row['prenom'];
    $nom = $row['nom'];
    $arrivee = $row['arrivee'];
    $depart = $row['depart'];
    if (is_null($depart)) {
        $depart = 'Non';
    }
    
    echo "<p>Nom: ".$nom." Prenom : ".$prenom."</p>";
    echo "<p>Arrivee: ".$arrivee." Depart : ".$depart."</p>";
}
?></div>
<div  class = deux><?php  
echo "<h1> morceaux : </h1>";
$sql = "SELECT * FROM morceau WHERE id_groupe = ?;
";
$q = $dbh->prepare($sql);
$q->execute(array($groupe));
$result = $q->fetchAll();

foreach($result as $row) {
    $titre = $row['titre'];
    $id_morceau = $row['id_morceau'];
    echo "<p> $titre de $nomgroupe :</p>";
    echo "<form action='affiche_morceau.php' method='post'>";
    echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
    echo "<button>détails</button>";
    echo "</form>";
};

$q = $dbh->prepare("SELECT count(*) FROM suis_groupe WHERE id_groupe = ?");
$q->execute(array($groupe));
$result = $q->fetch();
$nb = $result['count'];
?></div>
<div  class = un><?php
echo "<h1> Nombre d'utilisateurs qui suivent ce groupe : $nb";
?></div>
<div  class = deux><?php
echo "<h1> Suivre / Arrêter de suivre ce groupe : </h1>";
$self = $_SESSION['id_user'];
//regarde si lutilisateur le suit déjà ou pas
$sql = "SELECT id_groupe FROM suis_groupe WHERE id_groupe = $groupe AND id_user = $self";

$q = $dbh->query($sql);
$result = $q->fetch();

if($result == false){//cas où l'utilisateur ne suit pas cette utilisateur
    echo "<form method ='post' action ='follow_groupe.php'> ";
    echo "<div>";
    echo "<input type='radio' id='AM' name='type' value='0' required>";
    echo "<label for='AM'>Album et Morceau</label>";
    echo "<input type='radio' id='A' name='type' value='1'>";
    echo "<label for='A'>Album</label>";
    echo "<input type='radio' id='M' name='type' value='2'>";
    echo "<label for='M'>Morceau</label>";
    echo "<input type = 'hidden' name = 'hidden_id' value = $groupe>";
    echo "<button type='submit'>Follow</button > </form>";
   ;}

else{
    $sql = "SELECT parametre FROM suis_groupe WHERE id_groupe = $groupe AND id_user = $self";
    $q = $dbh->query($sql);
    $result = $q->fetch();
    $type = $result['parametre'];
    echo "<h2> Type de suivi : $type </h2>";
    echo "<form method ='post' action ='unfollow_groupe.php'> ";
    echo "<input type = 'hidden' name = 'hidden_id' value = $groupe>";
    echo "<button type='submit'>Unfollow</button ></form>";
    }

    ?></div>
    </body>

</html>