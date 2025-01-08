<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Page ajout match">
    <meta name="author" content="Enzo">
    <title>Joueurs</title>
    <!-- Fichier CSS -->
     <!-- http://localhost/PROJET_PHP/htdocs/vue/IHMAjoutJoueur.html -->
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<?php include('Menu.php'); ?>
<body>
    <h1 id="titrePageAccueil">Page d'ajout de match</h1>

    <form id="formulaireAjoutMatch" action="../controleur/ControleurAjoutMatchs.php" method="POST">
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="heure">Heure :</label>
            <input type="hour" id="heure" name="heure" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="equipe_adverse">Equipe adverse :</label>
            <input type="text" id="equipe_adverse" name="equipe_adverse" maxlength="50" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="Lieu">Lieu :</label>
            <input type="varchar " id="Lieu" name="Lieu" maxlength="50" required>
        </div>
        <div>
            <label class="labelFormJoueur" for="Domicile">Lieu du match :</label>
            <select id="Domicile" name="Domicile" required>
                <option value="0">Domicile</option>
                <option value="1">Extérieur</option>
            </select>
        </div>
        <button id="bontonAjoutMatch"type="submit">Ajouter le match</button>
    </form>
</body>
</html>