<?php include "connection.inc.php";
session_start();?>

<!DOCTYPE html>  </body>
<head>
   <meta charset="UTF-8">
   <ul> 
        <li><a href="page_daccueil.php">Accueil</a></li>
        <li><a href="page_daccueil_perso.php">Mon profil</a></li>
        <li><a href="recherche.php">Recherche</a></li>
        <li><a href="actualite.php">Actualite</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>
   <title>creer playlist</title>
</head>
<style>
body{
      background-color:#111;
  }
  </style>
<body>

<section id="statut_playlist">
               <h2>Statut Playlist</h2>
<form action="" method="POST" >

        <label for="titre">Nom de la playlist:</label>
            <input type="text" id="titre" name="titre" placeholder="nom" required>
            <br>
            <br>

            <label for="descript">Description:</label>
            <input type="texte" id="descript"  name="descript"  placeholder="description de la playlist">
            <br>
   
            <button type="submit" name="valider">Crée!</button>
             </form>
 <form>
 <button formaction='page_daccueil_perso.php'>abandonner</button >
 </form>

</section>


<?php

    if(isset($_POST['valider'])){
       
        $pseudo = $_SESSION['pseudo'];
        $erreurs = 0;

        //recherche si une playlist sous le meme titre existe
        $sql = "SELECT  titre   
        FROM playlist NATURAL JOIN utilisateur
        WHERE  pseudo = ?";
    
        $q = $dbh->prepare($sql);
        $q->execute(array($pseudo));
        $result = $q->fetchAll();
        foreach($result as $row) {
    
            if( $row['titre'] == $_POST['titre']){
                $erreurs ++;
                echo"Vous posséder deja une playlist sous ce nom";
            }
        }

        if($erreurs==0){

            $id_user = $_SESSION['id_user'];
            if(empty($_POST['descript'])){
                $prep = $dbh->prepare("INSERT INTO playlist(id_playlist,titre, visible, id_user) VALUES(DEFAULT,:titre,:visible,:id)");
                
            }
            else{
            $prep = $dbh->prepare("INSERT INTO playlist(id_playlist,titre, visible, descript, id_user) VALUES(DEFAULT,:titre,:visible,:descript,:id)");
            $prep ->bindParam(':descript' , $descript);
            $descript = $_POST['descript'];
           
            }

            $prep ->bindParam(':titre' , $titre);
            $prep ->bindParam(':visible' , $visible);
            $prep ->bindParam(':id' , $id_user);

            $titre = $_POST['titre'];
            $visible = false;
            $prep->execute();
            header('Location:page_daccueil_perso.php');
          
            }}
            
               
?>
</body>
</html>
           