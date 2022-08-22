<?php include "connection.inc.php";
session_start();?>

<!DOCTYPE html>
<html lang="fr">
    <header>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
       <link rel="stylesheet" href="connexion.css" media="screen" type="text/css" />

        <title>Connexion</title>
    </header>


    <body>
                    

                    <br/>
                    <div class = "connexion">
                    <form class="con-form" method="post" action="">
                             <h1 class='title'><center>Connexion</center></h1>

                        <label>Pseudo :</label></br>
                        <input class="input" type="text" name="pseudo" placeholder="Votre pseudo" required="required"></br></br>

                        <label>Mot de passe :</label></br>
                        <input class="input" type="password" name="mdp" placeholder="Mot de passe" required="required"></br></br>

                        <div class="row">
                                <button type="submit" name="ok">Se connecter
                                </button></br>
                            </div>
                        

                            <p><a href = "inscription.php" >Je n'ai pas encore de compte</a></p>
                    </form>
        </div>

    </body>
 <?php
{
    if(isset($_POST['ok']))
    {

        extract($_POST);
        if (!empty($pseudo) && !empty($mdp))
        {
            $q = $dbh->prepare("SELECT * FROM utilisateur WHERE pseudo = :pseudo");
            $q->execute(['pseudo' => $pseudo]);
            $result = $q->fetch();

            if($result == true)
            {
                $mdp_bdd = $result['mdp'];
                if($mdp_bdd == $mdp)
                {
                    echo "<p>Authentification réussie</p>";
                    $_SESSION['pseudo'] = $pseudo;
                    $_SESSION['id_user'] = $result['id_user'];
                    header('Location:page_daccueil.php');
                    die();

                }
                else
                {
                    echo"<p>Mot de passe incorrect</p>";
                }
            }
            else
            {
                echo"<p>Le compte n'existe pas</p>";
            }

        }
        else
        {
            echo "<p>veuillez remplir tous les champs!</p>";
        }

    }
}
?>



</html>



