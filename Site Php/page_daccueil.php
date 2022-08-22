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
        
        <li><a href="page_daccueil_perso.php">Mon profil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        <li><a href="actualite.php">Actualite</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>
        <title>Connexion</title>
    </header>


    <body>
        <h1 class='title'><center>Page principale</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];?>
       
        
        <div  class = un><?php
   echo "<h3> Morceaux en vedette cette semaine : </h3>";
    $q = $dbh->query("SELECT count(*), id_morceau, titre, nom 
                      FROM ecoute NATURAL JOIN (morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe) AS max2021
                      WHERE date_ecoute > CURRENT_DATE - INTERVAL '100 days'
                      GROUP BY id_morceau, titre, nom
                      ORDER BY count DESC
                      LIMIT 5");
//    echo $result['titre'];
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
    };?>   </div>
  <div  class = deux> <?php
    echo "<h3> Groupes les plus suivis : </h3>";
    $q = $dbh->query("SELECT count(*), id_groupe, nom 
                      FROM suis_groupe NATURAL JOIN groupe
                      GROUP BY (id_groupe, nom)
                      ORDER BY count DESC
                      LIMIT 5;");
    $result = $q->fetchAll();
    foreach($result as $row) {
        $nom = $row['nom'];
        $id_groupe = $row['id_groupe'];
        echo "<p>$nom :</p>";
        echo "<form action='affiche_groupe.php' method='post'>";
        echo "<input type='hidden' name='groupe' value='$id_groupe'/>";
        echo "<button>détails</button>";
        echo "</form>";
    };?>
    </div>
    <div  class = un>
    <?php

    echo "<h3> Dernier albums publiés : </h3>";
    $q = $dbh->query("SELECT id_album, titre
                      FROM album
                      ORDER BY date_parution DESC
                      LIMIT 5;");
    $result = $q->fetchAll();
    foreach($result as $row) {
        $titre = $row['titre'];
        $id_album = $row['id_album'];
        echo "<p>$titre :</p>";
        echo "<form action='affiche_album.php' method='post'>";
        echo "<input type='hidden' name='album' value='$id_album'/>";
        echo "<button>détails</button>";
        echo "</form>";
    };
?> </div>

</body>

</html>
