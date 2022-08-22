<?php
$user = "user";
$pass = "pass";

try
{
	$dbh = new PDO("pgsql:host=sqletud.u-pem.fr;dbname=dbname_db", $user,$pass);
}
catch(PDOException $e)
{
	echo("ERREUR : LA CONNEXION A ECHOUEE");
	header("Location: dbdead.html");
	die();
}


?>
