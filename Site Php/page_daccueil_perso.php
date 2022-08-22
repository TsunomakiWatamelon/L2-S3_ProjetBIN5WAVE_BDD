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
    <link rel="stylesheet" href="thewave.css">
    <ul> 
        <li><a href="page_daccueil.php">Accueil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        <li><a href="actualite.php">Actualite</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>
    <title>Mon compte</title>
    </header>
<body>
        <h1 class='title'><center>Mon profil</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];
    
    if(!empty($_SESSION['pseudo'])){
        $id = $_SESSION['id_user'];
        $pseudo = $_SESSION['pseudo'];?>
   
    <div  class = un><?php
    echo "<h1> Historique de mes dernières ecoute : </h1>";
    $sql = "SELECT *
            FROM ((morceau JOIN groupe on morceau.id_groupe = groupe.id_groupe) AS S1 JOIN ecoute ON s1.id_morceau = ecoute.id_morceau)
            WHERE id_user = ?
            ORDER BY date_ecoute DESC
            LIMIT 5;";

    $q = $dbh->prepare($sql);
    $q->execute(array($id));
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
  <div  class = deux><?php
    echo "<h1> Mes sons les plus écoutés : </h1>";
    $q = $dbh->prepare("SELECT count(*), id_morceau, titre, nom 
                        FROM ecoute NATURAL JOIN (morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe) AS max2021
                        WHERE id_user = ?
                        GROUP BY id_morceau, titre, nom
                        ORDER BY count DESC
                        LIMIT 5");
    $q->execute(array($id));
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
<div  class = deux><?php
    
     echo "<h1> Mes playlist : </h1>";
     echo "<form><button formaction='creer_playlist.php'>créer une playlist</button > </form>";
      
     $sql = "SELECT  *
             FROM playlist NATURAL JOIN utilisateur
             WHERE  pseudo = ?";
         
     $q = $dbh->prepare($sql);
     $q->execute(array($pseudo));
     $result = $q->fetchAll();
     foreach($result as $row) {
         $titre = $row['titre'];
         $statue = $row['visible'];
         $descript =$row['descript'];
         $id_playlist =$row['id_playlist'];
 
         if($statue){
             $visible = "Public";
         }
         else{
             $visible = "Privée";
         }
         echo "<p>titre : ".$titre." statut : ".$visible." Description : ".$descript."</p>";
         echo "<form action='affiche_playlist.php' method='post'>";
         echo "<input type='hidden' name='playlist' value='$id_playlist'/>";
         echo "<input type='hidden' name='titre' value='$titre'/>";
         echo "<button>détails</button>";
         echo "</form>";
 
         //supprimer la playlist
         echo "<form action='effacer_playlist.php' method='post'>";
         echo "<input type='hidden' name='morceau' value='$id_playlist'/>";
         echo "<button formaction='effacer_playlist.php'>effacer la playlist</button > </form>";
         echo "</form>";
     }
     ?></div>
     <div  class = un><?php
    
    echo "<h1> Utilisateur suivi : </h1>";
    $user = $_SESSION['id_user'];
    $sql = "SELECT pseudo, id_user FROM utilisateur WHERE id_user in (SELECT id_user2 FROM suis_user WHERE id_user = ?)" ;
        
    $q = $dbh->prepare($sql);
    $q->execute(array($user));
  
    $result = $q->fetchAll();
    foreach($result as $row) {
        $pseudo = $row['pseudo'];
        echo "<p> $pseudo :</p>";
        $usr = $row['id_user'];
        echo "<form action='affiche_user.php' method='post'>";
        echo "<input type='hidden' name='user' value='$usr'/>";
        echo "<button>détails</button>";
        echo "</form>";
    }

    ?></div>
    <div  class = deux><?php
    echo "<h1> Suivi par : </h1>";
    $sql = "SELECT pseudo, id_user FROM utilisateur WHERE id_user in (SELECT id_user FROM suis_user WHERE id_user2 = ?)" ;
    $q = $dbh->prepare($sql);
    $q->execute(array($user));
  
    $result = $q->fetchAll();
    foreach($result as $row) {
        $pseudo = $row['pseudo'];
        echo "<p> $pseudo :</p>";
        $usr = $row['id_user'];
        echo "<form action='affiche_user.php' method='post'>";
        echo "<input type='hidden' name='user' value='$usr'/>";
        echo "<button>détails</button>";
        echo "</form>";
    }?></div>
    <div  class = un><?php
    echo "<h1> Groupes suivi : </h1>";
    $sql = "SELECT * FROM suis_groupe WHERE id_user = $id";
    $q = $dbh->query($sql);
    $result = $q->fetchAll();
    foreach($result AS $row){
        $type = $row['parametre'];
        $idg = $row['id_groupe'];
        $sql2 = "SELECT * FROM groupe WHERE id_groupe = $idg";
        $q2 = $dbh->query($sql2);
        $result2 = $q2->fetch();
        $fnom = $result2['nom'];
        echo "<p>$fnom</p>";
        echo "<h2> Type de suivi : $type </h2>";
        echo "<form action='affiche_groupe.php' method='post'>";
        echo "<input type='hidden' name='groupe' value='$idg'/>";
        echo "<button>détails</button>";
        echo "</form>";

    }
    
    
    }?></div>
 
    </body>
</html>

