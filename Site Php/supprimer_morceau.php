<?php include "connection.inc.php";
session_start();


    
    $id_play= $_POST['playlist'];
    $id_morceau = $_POST['morceau'];

    $sql = "SELECT id_morceau
    FROM playlist NATURAL JOIN dans_playlist
    WHERE  id_playlist = ?";
   
    $q = $dbh->prepare($sql);
    $q->execute(array($id_play));
    $result = $q->fetchAll();
    foreach($result as $row) {

        if( $row['id_morceau'] == $id_morceau){
            $req_delete ='DELETE from dans_playlist WHERE id_morceau = ? And id_playlist = ?';
                        $res = $dbh->prepare($req_delete);
                        $res->execute(array($id_morceau,$id_play));
                        
        }
    }
    sleep(0.10);
    header('Location:page_daccueil_perso.php');



?>
</section>
</html>
