<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo']) OR !isset($_POST['hidden_id'])) {
    header("Location: index.php");
    die();
}




$sql = "INSERT INTO suis_groupe(id_groupe, id_user, parametre) VALUES(?, ?, ?)";
$prep = $dbh->prepare($sql);
if ($_POST['type'] == 0) {
    $type = 'AM';
}
if ($_POST['type'] == 1) {
    $type = 'A';
}
if ($_POST['type'] == 2) {
    $type = 'M';
}
$prep->execute(array($_POST['hidden_id'], $_SESSION['id_user'], $type));
/*$prep ->bindParam(':id_user' , $id);
$prep ->bindParam(':id_user2' , $id);*/

sleep(0.2);
$_SESSION['return'] = $_POST['hidden_id'];
header('Location:affiche_groupe.php');



?>