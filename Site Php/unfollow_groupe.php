<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo']) OR !isset($_POST['hidden_id'])) {
    header("Location: index.php");
    die();
}



$sql = "DELETE from suis_groupe WHERE id_user = ? AND id_groupe = ?";
$prep = $dbh->prepare($sql);
$prep->execute(array($_SESSION['id_user'],$_POST['hidden_id']));

sleep(0.5);
$_SESSION['return'] = $_POST['hidden_id'];
header('Location:affiche_groupe.php');



?>