<?php
$user = "iman.mellouk";
$pass = "imaniman";

try
{
	$dbh = new PDO("pgsql:host=sqletud.u-pem.fr;dbname=iman.mellouk_db", $user,$pass);
}
catch(PDOException $e)
{
	echo("ERREUR : LA CONNEXION A ECHOUEE");
	header("Location: dbdead.html");
	die();
}


?>
