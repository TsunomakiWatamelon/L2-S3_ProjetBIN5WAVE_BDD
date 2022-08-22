<?php include "connection.inc.php";
session_start();?>

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
    <title>statut playlist</title>
</head>
<style>
body{
      background-color:#111;
  }
  </style>
<body>
<body>

<section id="statut_playlist">

<div  class = deux>
                <h2>Statut Playlist</h2>
 <form action="" method="POST" >

                    <input type="radio" name="visible" value=true required >Public
                    <input type="radio" name="visible" value=false required >Privé
                    <button type="submit" name="valider">Enregistrer mon choix</button>

  </form>

</section>

    </body></div>
<?php

            if(isset($_POST['valider'])){
              
                $pseudo = $_SESSION['pseudo'];
                $id_playlist = $_SESSION['playlist'];
                $req_sql ="SELECT * FROM playlist WHERE pseudo = ?";
                $res = $dbh->prepare($req_sql);
                $res->execute(array($pseudo));
                $result = $res->fetch();

            if($result == true)
            {
            $q->execute(['visible' => $_POST[visible]]);


            $prep->execute();}
                echo$pseudo.'    ';
                echo$id_playlist;



            if($_POST['visible']=='true'){
                echo"votre playlist est en public";
                $req_update ='UPDATE playlist SET visible = true WHERE id_playlist = :id_playlist And id_user IN (SELECT id_user FROM utilisateur WHERE pseudo = :pseudo)';
                $prep = $dbh->prepare($req_update);
                $prep ->bindParam(':id_playlist', $id_playlist);
                $prep ->bindParam(':pseudo', $pseudo);
                $prep->execute();
                header('Location:page_daccueil_perso.php');
                
                  
            }

            else {

                echo"votre playlist est en privée";
                $req_update ='UPDATE playlist SET visible = false WHERE id_playlist = ? And id_user IN (SELECT id_user FROM utilisateur WHERE pseudo = ?)';
                $res = $dbh->prepare($req_update);
                $res->execute(array($id_playlist,$pseudo));
                header('Location:page_daccueil_perso.php');

                

            }

        }

?>
</section>
</html>
