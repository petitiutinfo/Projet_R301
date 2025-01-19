<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition de l'encodage des caractères du document -->
    <meta charset="UTF-8">
    <!-- Description de la page pour le SEO -->
    <meta name="description" content="Page ajout match">
    <!-- Auteur de la page -->
    <meta name="author" content="Enzo">
    <title>Joueurs</title>
    
    <!-- Fichier CSS pour la mise en forme de la page -->
    <link rel="stylesheet" href="style/stylePageAjoutModification.css">
</head>

<!-- Inclusion du menu de navigation -->
<?php include('Menu.php'); ?>

<body>
    <!-- Titre de la page d'ajout de match -->
    <h1 id="titrePageAccueil">Page d'ajout de match</h1>

    <!-- Formulaire d'ajout d'un match -->
    <form id="formulaireAjoutMatch" action="../controleur/ControleurAjoutMatchs.php" method="POST">
        
        <!-- Champ pour la date du match -->
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" required>
        </div>

        <!-- Champ pour l'heure du match -->
        <div class="form-group">
            <label class="labelFormJoueur" for="heure">Heure :</label>
            <input type="hour" id="heure" name="heure" required>
        </div>

        <!-- Champ pour l'équipe adverse -->
        <div class="form-group">
            <label class="labelFormJoueur" for="equipe_adverse">Equipe adverse :</label>
            <input type="text" id="equipe_adverse" name="equipe_adverse" maxlength="50" required>
        </div>

        <!-- Champ pour le lieu du match -->
        <div class="form-group">
            <label class="labelFormJoueur" for="Lieu">Lieu :</label>
            <input type="varchar" id="Lieu" name="Lieu" maxlength="50" required>
        </div>

        <!-- Sélection du lieu du match (domicile ou extérieur) -->
        <div>
            <label class="labelFormJoueur" for="Domicile">Lieu du match :</label>
            <select id="Domicile" name="Domicile" required>
                <option value="0">Domicile</option>
                <option value="1">Extérieur</option>
            </select>
        </div>

        <!-- Bouton pour soumettre le formulaire -->
        <button id="boutonAjout" type="submit">Ajouter le match</button>
    </form>
</body>
</html>