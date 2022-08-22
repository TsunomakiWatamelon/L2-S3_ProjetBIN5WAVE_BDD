<?php include "connection.inc.php";
session_start();
      
        $req_delete ='DELETE from playlist WHERE id_playlist = ?';
        $res = $dbh->prepare($req_delete);
        $res->execute(array($_POST['morceau']));
        $result = $res->rowCount();
        sleep(0.10);
        header('Location:page_daccueil_perso.php');
           
        
?>
</section>
</html>
