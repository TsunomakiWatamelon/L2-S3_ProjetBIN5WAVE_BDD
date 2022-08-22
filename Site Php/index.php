<?php include "connection.inc.php";
session_start();
if (isset($_SESSION['pseudo'])) {
    header("Location: page_daccueil.php");
    die();
}
else {
    header("Location: inscription.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
    <header>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <link rel="stylesheet" href="thewave.css">

        <title>The Wave</title>
    </header>

</html>