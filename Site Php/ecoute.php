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
        <li><a href="actualite.php">Actualite</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>

        <title>Ecoute</title>
    </header>


    <body>
        <h1 class='title'><center>Écoute</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];
        extract($_POST);
      
      
$prep = $dbh->prepare("SELECT id_user FROM utilisateur WHERE pseudo = :pseudo");
$prep->execute(['pseudo' => $pseudo]);
$res = $prep->fetch();
$id = $_SESSION['id_user'];
$prep = $dbh->prepare("SELECT titre, nom FROM morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe WHERE id_morceau = :morceau");
$prep->execute(['morceau'=>$morceau]);
$res = $prep->fetch();
$titre = $res["titre"];
$nom = $res["nom"];
$prep = $dbh->prepare("INSERT INTO ecoute(id_morceau, id_user,date_ecoute) VALUES (:morceau, :usr, NOW())");
$prep->execute(['usr' => $id, 'morceau'=>$morceau]);?>
<div  class = deux><?php
echo "<p> Vous écoutez : $titre de $nom </p>";
?></div>


</body>

</html>
