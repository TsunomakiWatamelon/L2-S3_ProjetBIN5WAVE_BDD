<?php include "connection.inc.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="connexion.css" media="screen" type="text/css" />

    <title>inscription</title>
</head>


<body>
<div class="inscription">

    <br />
    <form method="post"  action="" class="blanc">
    <h1 class='title'><center>Inscription</center></h1>

        <label>
        Pseudo 
        <input type="text" name="usr_pseudo" id ="pseudo" placeholder="Un login de connexion" required/>
        </label>

    

    <label>
        E-mail    <input type="text" name="usr_email" id ="email" placeholder="Votre Courriel" required/>
    </label>

  
<label>
<br> <br>
    mot-de-passe <input type="password" name="usr_mdp" id = "mdp" placeholder="Mot de passe" required/>
</label> 

<label>
  Confirmation du mot de passe    <input type="password" name="mdp_confirme" id = "mdp1" placeholder="Confirmation de votre mot de passe" required/>
</label>
<br> 
<input type="submit" name="valider" value="Valider" />

<p align="center">
<BR>J'ai déjà un compte utilisateur. <B><a href = "connexion_user.php">Connexion</a></B>
</p>

</form>

</div>


</body>

<?php
    {
    if(isset($_POST['valider'])){
        extract($_POST);
        $erreurs =   0;
                    
        // cas ou email deja use (un compte existe deja avc cette adresse)

        /*$req_select =$dbh->prepare("SELECT email FROM utilisateur WHERE email = ?");
        $res = $dbh->query($req_select);
        $req_select->execute(array($_POST['email']));
        $result = $req_select->fetch();
        if(result != false){
            $erreurs+=1;
            echo"Un compte existe déjà avec cette adresse e-mail";
        }
        

        //cas nom dutilisateur deja pris
        $req_select2 =$dbh->prepare("SELECT pseudo FROM utilisateur WHERE pseudo = ?");
        $res = $dbh->query($req_select2);
        $req_select2->execute(array($_POST['usr_pseudo']);
        $result2 = $req_select2->fetch();
        if(result2 != false){
            $erreurs+=1;
            echo"Pseudo déjà utilisé veuillez en choisir un autre";
        }*/

        if(isset($_POST['usr_mdp']) and isset($_POST['mdp_confirme'])){
            if($_POST['usr_mdp'] != $_POST['mdp_confirme']){
                $erreurs+=1;
                echo'Vous avez saisie un mot de passe de confirmation incorrect';
            }
        }

               
        if($erreurs==0){
        
            
           
           // $req_select = "INSERT INTO utilisateur(pseudo, date_inscription, email, mdp) VALUES('".$_POST['pseudo']."','".$date."','".$_POST['email']."','".$_POST['mdp']."')";
            $prep = $dbh->prepare("INSERT INTO utilisateur(id_user,pseudo,date_inscription, email, mdp) VALUES(DEFAULT, :usr_pseudo,NOW(), :usr_email, :usr_mdp)");

            $prep ->bindParam(':usr_pseudo' , $pseudo);
            $prep ->bindParam(':usr_email' ,$email);
            $prep ->bindParam(':usr_mdp' ,$mdp);

            $pseudo = $_POST['usr_pseudo'];
            $email = $_POST['usr_email'];
            $mdp = $_POST['usr_mdp'];




            $essaie=$prep->execute();
            header('Location:connexion_user.php');
//            echo "\nPDOStatement::errorCode(): ";
//			var_dump($prep->errorInfo());

           
        }
    }

}?>