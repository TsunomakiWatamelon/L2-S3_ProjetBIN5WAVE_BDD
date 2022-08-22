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
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>

        <title>Recherche</title>
    </header>


    <body>
        <h1 class='title'><center>Suggestions</center></h1>
        <?php 
        extract($_SESSION);
       
     
       
        $q = $dbh->prepare("SELECT count(*), id_morceau, titre, nom, id_groupe
            FROM ecoute NATURAL JOIN (SELECT id_morceau, titre, nom, morceau.id_groupe FROM morceau INNER JOIN groupe ON morceau.id_groupe = groupe.id_groupe) AS max2021
            WHERE id_user = :usr
            GROUP BY id_morceau, titre, nom, id_groupe
            ORDER BY count DESC
            LIMIT 1");
        $q->execute(['usr' => $id_user]);
        $g1 = $q->fetch();
        $idg1 = $g1['nom'];
        ?></div>
        <div  class = un><?php  
        echo "<h3> Les utilisateurs qui écoutent $idg1 écoutent aussi: </h3>";
        $q = $dbh->prepare("SELECT * 
                        FROM (SELECT DISTINCT B.id_morceau, B.titre, B.nom
                              FROM (ecoute NATURAL JOIN (SELECT id_morceau, titre, nom, morceau.id_groupe FROM morceau INNER JOIN groupe ON morceau.id_groupe = groupe.id_groupe) AS max2021) AS A,
                                   (ecoute NATURAL JOIN (SELECT id_morceau, titre, nom, morceau.id_groupe FROM morceau INNER JOIN groupe ON morceau.id_groupe = groupe.id_groupe) AS max2021) AS B
                              WHERE A.id_user = B.id_user
                              AND A.id_morceau <= B.id_morceau
                              AND (B.id_groupe = :id OR A.id_groupe = :id)
                              LIMIT 5) AS peko
                        ORDER BY random()
                        ");
        $q->execute(['id'=>$g1['id_groupe']]);
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
        };
        ?></div>
<div  class = deux><?php  
        echo "<h3> Les abonnées de $idg1 suivent aussi: </h3>";
        $q = $dbh->prepare("SELECT DISTINCT B.id_groupe, B.nom
                          FROM (suis_groupe NATURAL JOIN groupe) AS A, (suis_groupe NATURAL JOIN groupe) AS B
                          WHERE A.id_groupe = :id AND B.id_groupe != :id
                          AND A.id_user = B.id_user
                          ");
        $q->execute(['id'=>$g1['id_groupe']]);
        $result = $q->fetchAll();
        foreach($result as $row) {
            $nom = $row['nom'];
            $id_groupe = $row['id_groupe'];
            echo "<p> $nom :</p>";
            echo "<form action='affiche_groupe.php' method='post'>";
            echo "<input type='hidden' name='groupe' value='$id_groupe'/>";
            echo "<button>détails</button>";
            echo "</form>";
        }
        $q = $dbh->prepare("SELECT DISTINCT morceau.genre, morceau.titre, morceau.id_morceau, groupe.nom
                            FROM morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe
                            WHERE morceau.genre IN (SELECT genre
                                            FROM morceau
                                            ORDER BY random()
                                            LIMIT 1)
                            LIMIT 5
                          ");
        $q->execute();
        $result = $q->fetchAll();
        $genre = $result[0]['genre'];
        ?></div>
<div  class = deux><?php  
        echo "<h3> Découvrez le genre : $genre </h3>";
        foreach($result as $row) {
            $titre = $row['titre'];
            $nom = $row['nom'];
            $id_morceau = $row['id_morceau'];
            echo "<p> $titre de $nom :</p>";
            echo "<form action='affiche_morceau.php' method='post'>";
            echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
            echo "<button>détails</button>";
            echo "</form>";
        }
        ?></div>
</body>

</html>