<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo']) OR !isset($_POST['hidden_id'])) {
    header("Location: index.php");
    die();
}



$sql = "DELETE from suis_user WHERE id_user = ? AND id_user2 = ?";
$prep = $dbh->prepare($sql);
$prep->execute(array($_SESSION['id_user'],$_POST['hidden_id']));
/*$prep ->bindParam(':id_user' , $id);
$prep ->bindParam(':id_user2' , $id);*/

$sql = "SELECT pseudo FROM utilisateur WHERE id_user = ?";
$prep->execute(array($_POST['hidden_id']));
$usr = $prep->fetch();
$usr = $usr['pseudo'];

echo "<h1> Vous ne suivez plus cet utilisateur : $usr</h1>";

sleep(0.5);
$_SESSION['return'] = $_POST['hidden_id'];
header('Location:affiche_user.php');



?>