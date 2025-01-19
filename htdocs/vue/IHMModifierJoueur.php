<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion des fichiers nécessaires pour récupérer les informations du joueur depuis la base de données
include('../controleur/ControleurRecupererJoueur.php');

// Vérifier si l'ID du joueur est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Conversion de l'ID en entier
    $id = intval($_GET['id']);
    
    // Appel de la fonction pour récupérer les informations du joueur par son ID
    $joueur = recupererJoueurParId($pdo, $id);
    
    // Si le joueur n'existe pas dans la base de données, afficher un message d'erreur
    if (!$joueur) {
        echo "Aucun joueur trouvé avec cet ID.";
        exit;
    }
} else {
    // Si l'ID du joueur n'est pas spécifié, afficher un message d'erreur
    echo "ID du joueur non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition de l'encodage des caractères pour le document HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le SEO -->
    <meta name="description" content="Page modification joueurs">
    
    <!-- Nom de l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Modifier Joueur</title>
    
    <!-- Lien vers le fichier CSS pour le style de la page -->
    <link rel="stylesheet" href="style/stylePageAjoutModification.css">
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>

    <!-- Titre de la page de modification -->
    <h1 id="titrePageAccueil">Page de modification de joueur</h1>

    <!-- Formulaire pour modifier les informations du joueur -->
    <form id="formulaireModifierJoueur" action="../controleur/ControleurModifierJoueur.php" method="POST">
        <!-- Champ caché pour envoyer l'ID du joueur -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($joueur['IdJoueur']); ?>">

        <!-- Champ pour le numéro de license du joueur -->
        <div class="form-group">
            <label for="numero_license">Numéro de License :</label>
            <input type="number" id="numero_license" name="numero_license" value="<?php echo htmlspecialchars($joueur['Numéro_de_license']); ?>" required>
        </div>

        <!-- Champ pour le nom du joueur -->
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" maxlength="50" value="<?php echo htmlspecialchars($joueur['Nom']); ?>" required>
        </div>

        <!-- Champ pour le prénom du joueur -->
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" maxlength="50" value="<?php echo htmlspecialchars($joueur['Prénom']); ?>" required>
        </div>

        <!-- Champ pour la date de naissance du joueur -->
        <div class="form-group">
            <label for="date_naissance">Date de Naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($joueur['Date_de_naissance']); ?>" required>
        </div>

        <!-- Champ pour la taille du joueur (en cm) -->
        <div class="form-group">
            <label for="taille">Taille (en cm) :</label>
            <input type="number" id="taille" name="taille" min="50" max="250" value="<?php echo htmlspecialchars($joueur['Taille']); ?>" required>
        </div>

        <!-- Champ pour le poids du joueur (en kg) -->
        <div class="form-group">
            <label for="poids">Poids (en kg) :</label>
            <input type="number" id="poids" name="poids" step="0.1" value="<?php echo htmlspecialchars($joueur['Poids']); ?>" required>
        </div>

        <!-- Champ pour sélectionner le statut du joueur -->
        <div class="form-group">
            <label for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <!-- Options de statut pré-remplies selon la valeur actuelle du joueur -->
                <option value="actif" <?= ($joueur['Statut'] == 0) ? 'selected' : ''; ?>>Actif</option>
                <option value="blessé" <?= ($joueur['Statut'] == 1) ? 'selected' : ''; ?>>Blessé</option>
                <option value="suspendu" <?= ($joueur['Statut'] == 2) ? 'selected' : ''; ?>>Suspendu</option>
                <option value="absent" <?= ($joueur['Statut'] == 3) ? 'selected' : ''; ?>>Absent</option>
            </select>
        </div>

        <!-- Bouton pour soumettre les modifications du joueur -->
        <button id="bontonModificationJoueur" type="submit">Confirmer les modifications</button>
    </form>
</body>
</html>