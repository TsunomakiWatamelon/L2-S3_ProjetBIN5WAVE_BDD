<?php include "connection.inc.php";
session_start();
if (!isset($_SESSION['pseudo'])) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
    <header>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <link rel="stylesheet" href="thewave.css">
        <ul> 
        <li><a href="page_daccueil.php">Accueil</a></li>
        <li><a href="page_daccueil_perso.php">Mon profil</a></li>
        <li><a href="actualite.php">Actualite</a></li>
        <li><a href="suggestion.php">Mes suggestions</a></li>
        <li><a href="deconnexion.php">Déconnexion</a></li>
</ul>
        <title>Recherche</title>
    </header>


    <body>
        <h1 class='title'><center>Recherche</center></h1>
        <?php $pseudo = $_SESSION['pseudo'];
    
        ?>
        
        <form method="post" action="">
    
<div  class = deux> 
        <p>Veuillez choisir ce que vous recherchez :</p>
        <div>
        <input type="radio" id="morceau" name="type" value="0" required>
            <label for="morceau">Morceau</label>
        <input type="radio" id="groupe" name="type" value="1">
            <label for="groupe">Groupe</label>
        <input type="radio" id="album" name="type" value="2">
            <label for="album">Album</label>
        <input type="radio" id="playlist" name="type" value="3">
            <label for="playlist">Playlist</label>
        <input type="radio" id="user" name="type" value="4">
            <label for="user">Utilisateurs</label>
        </div>

        <p>Recherche par :</p>
        <div>
        <input type="radio" id="motcle" name="type2" value="0" required>
            <label for="motcle">Mot clé</label>
        <input type="radio" id="titre" name="type2" value="1">
            <label for="titre">Titre</label>
        <input type="radio" id="genre" name="type2" value="2">
            <label for="genre">Genre</label>
        <input type="radio" id="artiste" name="type2" value="3">
            <label for="artiste">Artiste</label>
        </div>

        <label for="champ">Champ de recherche:</label>

        <input type="text" id="champ" name="champ" required>
        

  <div>
    <button type="submit">Rechercher</button>
  </div>
</form>
</div>
 <?php
    if(isset($_POST['champ'])){
        $pseudo = $_SESSION['pseudo'];
        extract($_POST);
        $lance = 1;
        $champ = strtolower($champ);
        if ($type == 0) { // morceau
            if ($type2 == 0) { // mot cle
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_morceau, titre, nom
                                    FROM morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe
                                    WHERE (lower(titre) LIKE :champ) OR (lower(nom) LIKE :champ) OR (lower(morceau.genre) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 1) { // titre
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_morceau, titre, nom
                                    FROM morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe
                                    WHERE (lower(titre) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 2) { // genre
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_morceau, titre, nom
                                    FROM morceau JOIN groupe ON morceau.id_groupe = groupe.id_groupe
                                    WHERE (lower(morceau.genre) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 3) { // artiste
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_morceau, titre, groupe.nom
                                    FROM ((morceau NATURAL JOIN participe) as s1 NATURAL JOIN artiste) AS s2 JOIN groupe ON s2.id_groupe = groupe.id_groupe
                                    WHERE (lower(s2.nom) LIKE :champ) OR (lower(s2.prenom) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
        }
        if ($type == 1) { // groupe
            if ($type2 == 0) { // mot cle
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_groupe, nom
                                    FROM groupe
                                    WHERE (lower(nom) LIKE :champ) OR (lower(genre) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 1) { // titre
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_groupe, nom
                                    FROM groupe
                                    WHERE (lower(nom) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 2) { // genre
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_groupe, nom
                                    FROM groupe
                                    WHERE (lower(genre) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 3) { // artiste
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT s1.id_groupe, s1.nom
                                    FROM (groupe NATURAL JOIN appartient) as s1 JOIN artiste ON s1.id_artiste = artiste.id_artiste
                                    WHERE (lower(artiste.nom) LIKE :champ) OR (lower(artiste.prenom) LIKE :champ)
                                    AND depart IS NULL");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
        }
        if ($type == 2) { // album
            if ($type2 == 0 or $type2 == 1) { // mot cle
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_album, album.titre, nom
                                    FROM album JOIN groupe ON album.auteur = groupe.id_groupe
                                    WHERE lower(titre) LIKE :champ");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 2) { // genre
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_album, album.titre, nom
                                    FROM album JOIN groupe ON album.auteur = groupe.id_groupe
                                    WHERE (lower(genre) LIKE :champ)");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 3) { // artiste
                $no = 1;
            }
        }
        if ($type == 3) { // playlist
            if ($type2 == 0) { // mot cle
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_playlist, titre, pseudo
                                    FROM playlist NATURAL JOIN utilisateur
                                    WHERE (lower(titre) LIKE :champ) OR (pseudo LIKE :champ) OR (lower(descript) LIKE :champ)
                                    AND (visible = 't' OR pseudo = :pseudo)");
                $q->execute(['champ' => $search, 'pseudo' => $pseudo]);
                $result = $q->fetchAll();
            }
            if ($type2 == 1) { // titre
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT id_playlist, titre, pseudo
                                    FROM playlist NATURAL JOIN utilisateur
                                    WHERE (lower(titre) LIKE :champ) OR (pseudo LIKE :champ)
                                    AND visible = 't'");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 2) { // genre
                $no = 1;
            }
            if ($type2 == 3) { // artiste
                $no = 1;
            }
        }
        if ($type == 4) { // utilisateurs
            if ($type2 == 0 OR $type2 == 1) { // mot cle
                $search = "%{$champ}%";
                $q = $dbh->prepare("SELECT pseudo, id_user
                                    FROM utilisateur
                                    WHERE lower(pseudo) LIKE :champ
                                   ");
                $q->execute(['champ' => $search]);
                $result = $q->fetchAll();
            }
            if ($type2 == 2) { // genre
                $no = 1;
            }
            if ($type2 == 3) { // artiste
                $no = 1;
            }
        }
    }
?>
<?php
    if (isset($no)) {
        echo "<h3> Paramètres incompatibles, veuillez modifier votre recherche </h3>";
    }
    else if (isset($lance)){
        echo "<h3> Résultat de recherche</h3>";
        if ($type == 0) { // morceau
            echo "<h3> Morceaux : </h3>";
            foreach($result as $row) {

                $titre = $row['titre'];
                $nom = $row['nom'];
                $id_morceau = $row['id_morceau'];
                echo "<p> $titre de $nom :</p>";
                echo "<form action='affiche_morceau.php' method='post'>";
                echo "<input type='hidden' name='morceau' value='$id_morceau'/>";
                echo "<button>détails</button>";
                echo "</form>";
            }
        }
        if ($type == 1) { // groupe
            echo "<h3> Groupes : </h3>";
            foreach($result as $row) {
                $nom = $row['nom'];
                $id_groupe = $row['id_groupe'];
                echo "<p> $nom :</p>";
                echo "<form action='affiche_groupe.php' method='post'>";
                echo "<input type='hidden' name='groupe' value='$id_groupe'/>";
                echo "<button>détails</button>";
                echo "</form>";
            }
        }
        if ($type == 2) { // album
            echo "<h3> Albums : </h3>";
            foreach($result as $row) {
                $titre = $row['titre'];
                $nom = $row['nom'];
                $id_album = $row['id_album'];
                echo "<p> $titre de $nom :</p>";
                echo "<form action='affiche_album.php' method='post'>";
                echo "<input type='hidden' name='album' value='$id_album'/>";
                echo "<button>détails</button>";
                echo "</form>";
            }
        }
        if ($type == 3) { // Playlists
            echo "<h3> Playlistes : </h3>";
            foreach($result as $row) {
                $titre = $row['titre'];
                $pseudo = $row['pseudo'];
                $id_playlist = $row['id_playlist'];
                echo "<p> $titre de $pseudo :</p>";
                echo "<form action='affiche_playlist.php' method='post'>";
                echo "<input type='hidden' name='playlist' value='$id_playlist'/>";
                echo "<button>détails</button>";
                echo "</form>";
            }
        }
        if ($type == 4) { // utilisateurs
            echo "<h3> Utilisateurs : </h3>";
            foreach($result as $row) {
                $pseudo = $row['pseudo'];
                $usr = $row['id_user'];
                echo "<p> $pseudo :</p>";
                echo "<form action='affiche_user.php' method='post'>";
                echo "<input type='hidden' name='user' value='$usr'/>";
                echo "<button>détails</button>";
                echo "</form>";
            }
        }
    }
?>

</body>

</html>