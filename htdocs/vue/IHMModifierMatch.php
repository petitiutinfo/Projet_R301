<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion des fichiers nécessaires pour la récupération des informations du match
include('../controleur/ControleurRecupererMatch.php');

// Vérifier si l'ID du match est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Conversion de l'ID en entier
    $id = intval($_GET['id']);

    try {
        // Appel de la fonction pour récupérer les informations du match par son ID
        $match = recupererMatchParId($pdo, $id);
        
        // Si le match n'existe pas dans la base de données, afficher un message d'erreur
        if (!$match) {
            echo "Aucun match trouvé avec cet ID.";
            exit;
        }
    } catch (PDOException $e) {
        // Gestion des erreurs en cas de problème lors de la récupération des informations
        echo "Erreur lors de la récupération des informations : " . $e->getMessage();
        exit;
    }
} else {
    // Si l'ID du match n'est pas spécifié, afficher un message d'erreur
    echo "ID du match non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition de l'encodage des caractères pour le document HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le SEO -->
    <meta name="description" content="Page modification match">
    
    <!-- Nom de l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Modifier Match</title>
    
    <!-- Lien vers le fichier CSS pour le style de la page -->
    <link rel="stylesheet" href="style/stylePageAjoutModification.css">
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>

    <!-- Titre de la page de modification -->
    <h1 id="titrePageAccueil">Page de modification de match</h1>

    <!-- Formulaire pour modifier les informations du match -->
    <form id="formulaireModifierMatch" action="../controleur/ControleurModifierMatch.php" method="POST">
        <!-- Champ caché pour envoyer l'ID du match -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($match['IdMatch']); ?>">

        <!-- Champ pour la date du match -->
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($match['Date_Match']); ?>" required>
        </div>

        <!-- Champ pour l'heure du match -->
        <div class="form-group">
            <label for="heure">Heure :</label>
            <input type="time" id="heure" name="heure" value="<?php echo htmlspecialchars($match['Heure_Match']); ?>" required>
        </div>

        <!-- Champ pour l'équipe adverse -->
        <div class="form-group">
            <label for="equipe_adverse">Équipe adverse :</label>
            <input type="text" id="equipe_adverse" name="equipe_adverse" maxlength="50" value="<?php echo htmlspecialchars($match['Equipe_Adverse']); ?>" required>
        </div>

        <!-- Champ pour le lieu du match -->
        <div class="form-group">
            <label for="Lieu">Lieu :</label>
            <input type="text" id="Lieu" name="Lieu" maxlength="50" value="<?php echo htmlspecialchars($match['Lieu_Match']); ?>" required>
        </div>

        <!-- Champ pour le statut domicile ou extérieur -->
        <div class="form-group">
            <label for="Domicile">Domicile ou extérieur :</label>
            <select id="Domicile" name="Domicile" required>
                <!-- Option pour Extérieur, sélectionnée si le match est extérieur -->
                <option value="1" <?php echo ($match['Domicile'] == 1) ? 'selected' : ''; ?>>Extérieur</option>
                <!-- Option pour Domicile, sélectionnée si le match est à domicile -->
                <option value="0" <?php echo ($match['Domicile'] == 0) ? 'selected' : ''; ?>>Domicile</option>
            </select>
        </div>

        <!-- Bouton pour soumettre les modifications du match -->
        <button id="bontonModificationMatch" type="submit">Confirmer les modifications</button>
    </form>
</body>
</html>