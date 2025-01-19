<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition de l'encodage des caractères utilisé dans le document -->
    <meta charset="UTF-8">
    <!-- Description de la page pour le SEO -->
    <meta name="description" content="Page ajout joueurs">
    <!-- Auteur de la page -->
    <meta name="author" content="Miegemolle">
    <title>Joueurs</title>
    <!-- Inclusion de la feuille de style CSS pour la mise en page de cette page -->
    <link rel="stylesheet" href="style/stylePageAjoutModification.css">
</head>

<!-- Inclusion du menu de navigation -->
<?php include('Menu.php'); ?>

<body>
    <!-- Titre de la page d'ajout de joueur -->
    <h1 id="titrePageAccueil">Page d'ajout de joueur</h1>

    <!-- Formulaire d'ajout d'un joueur -->
    <form id="formulaireAjoutJoueur" action="../controleur/ControleurAjoutJoueur.php" method="POST">
        <!-- Champ pour le numéro de licence du joueur -->
        <div class="form-group">
            <label for="numero_license">Numéro de License :</label>
            <input type="number" id="numero_license" name="numero_license" required>
        </div>

        <!-- Champ pour le nom du joueur -->
        <div class="form-group">
            <label class="labelFormJoueur" for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" maxlength="50" required>
        </div>

        <!-- Champ pour le prénom du joueur -->
        <div class="form-group">
            <label class="labelFormJoueur" for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" maxlength="50" required>
        </div>

        <!-- Champ pour la date de naissance du joueur -->
        <div class="form-group">
            <label class="labelFormJoueur" for="date_naissance">Date de Naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" required>
        </div>

        <!-- Champ pour la taille du joueur -->
        <div class="form-group">
            <label class="labelFormJoueur" for="taille">Taille (en cm) :</label>
            <input type="number" id="taille" name="taille" min="50" max="250" required>
        </div>

        <!-- Champ pour le poids du joueur -->
        <div class="form-group">
            <label class="labelFormJoueur" for="poids">Poids (en kg) :</label>
            <input type="number" id="poids" name="poids" step="0.1" required>
        </div>

        <!-- Champ pour choisir le statut du joueur -->
        <div class="form-group">
            <label class="labelFormJoueur" for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <option value="0">Actif</option>
                <option value="1">Blessé</option>
                <option value="2">Suspendu</option>
                <option value="3">Absent</option>
            </select>
        </div>

        <!-- Bouton pour soumettre le formulaire -->
        <button id="boutonAjout" type="submit">Ajouter le Joueur</button>
    </form>

</body>
</html>
