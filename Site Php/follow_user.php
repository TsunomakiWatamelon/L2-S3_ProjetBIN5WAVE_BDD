<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo']) OR !isset($_POST['hidden_id'])) {
    header("Location: index.php");
    die();
}




$sql = "INSERT INTO suis_user(id_user,id_user2) VALUES(?, ?)";
$prep = $dbh->prepare($sql);
$prep->execute(array($_SESSION['id_user'],$_POST['hidden_id']));
/*$prep ->bindParam(':id_user' , $id);
$prep ->bindParam(':id_user2' , $id);*/

$sql = "SELECT pseudo FROM utilisateur WHERE id_user = ?";
$prep->execute(array($_POST['hidden_id']));
$usr = $prep->fetch();
$usr = $usr['pseudo'];

echo "<h1> Vous venez de suivre cet utilisateur : $usr</h1>";

sleep(0.2);
$_SESSION['return'] = $_POST['hidden_id'];
header('Location:affiche_user.php');



?>