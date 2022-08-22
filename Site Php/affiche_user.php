<?php include "connection.inc.php";
session_start();
if (isset($_SESSION['return']) AND !isset($_POST['user'])){
    $_POST['user'] = $_SESSION['return'];
    unset($_SESSION['return']);
}
if (!isset($_SESSION['pseudo']) OR !isset($_POST['user']) OR !isset($_SESSION['id_user'])) {
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
        <h1 class='title'><center>Info Utilisateur</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];
     
        
    $user = $_POST['user'];
    $req_select = "SELECT pseudo FROM utilisateur WHERE id_user = ?";
    $res = $dbh->prepare($req_select);
    $res->execute(array($user));
    $userp = $res->fetch();
    $userp = $userp['pseudo'];?>
    <div  class = deux><?php
    echo "<h1> Utilisateur : $userp </h1>";?></div>
    <div  class = un><?php
    echo "<h1> Playlist publiques : </h1>";
    $sql = "SELECT  *
            FROM playlist 
            WHERE  id_user = ?
            AND visible = true";
        
    $q = $dbh->prepare($sql);
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
    ?></div>
    
    <div  class = un><?php
    echo "<h1> suivi par : </h1>";

    $sql = "SELECT pseudo, id_user FROM utilisateur WHERE id_user in (SELECT  id_user
            FROM suis_user WHERE id_user2 = ?)" ;
        
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
    }  ?></div>

<div  class = deux><?php
    echo "<h1> utilisateur suivi :  </h1>";
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

    $self = $_SESSION['id_user'];
    //regarde si lutilisateur le suit déjà ou pas
    $sql = "SELECT id_user2 FROM suis_user
            WHERE id_user = $self AND id_user2 = $user";
  
    $q = $dbh->query($sql);

    $result = $q->fetch();?></div>
   <div  class = un><?php
    echo "<h1> Suivre / Arrêter de suivre : </h1>";
    if($result == false){//cas où l'utilisateur ne suit pas cette utilisateur
        echo "<form method ='post' action ='follow_user.php'> ";
        echo "<input type = 'hidden' name = 'hidden_id' value = $user>";
        echo "<button formaction='follow_user.php'>Follow</button > </form>";
       ;}
    
    else{
        echo "<form method ='post' action ='unfollow_user.php'> ";
        echo "<input type = 'hidden' name = 'hidden_id' value = $user>";
        echo "<button formaction='unfollow.php'>Unfollow</button ></form>";
        }

        ?></div>
    
    
    </body>
</html>