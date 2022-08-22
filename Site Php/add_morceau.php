<?php include "connection.inc.php";
session_start();


   
    $id_play= $_POST['playlist'];
    $id_morceau = $_POST['morceau'];
    $numero = rand(0,10);

    $prep = $dbh->prepare("INSERT INTO dans_playlist(id_morceau, id_playlist, numero) VALUES (:id_morceau,:id_playlist,:num)");
    
    $prep ->bindParam(':id_morceau' ,$id_morceau);
    $prep ->bindParam(':id_playlist' ,$id_play);
    $prep ->bindParam(':num' ,$numero);


    $prep->execute();
    sleep(0.10);
    header('Location:page_daccueil_perso.php');



    
 ?>