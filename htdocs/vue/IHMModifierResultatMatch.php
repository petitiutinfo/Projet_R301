<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion des fichiers nécessaires pour la récupération des informations du match
include('../controleur/ControleurRecupererMatch.php');
include('../controleur/FormaterScore.php');

// Vérification si l'ID du match est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Conversion de l'ID du match en entier pour éviter les injections
    $id = intval($_GET['id']);

    try {
        // Récupération des informations du match par son ID
        $match = recupererMatchParId($pdo, $id);
        
        // Vérification si le match existe dans la base de données
        if (!$match) {
            // Si le match n'existe pas, afficher un message d'erreur
            echo "Aucun match trouvé avec cet ID.";
            exit;
        }
    } catch (PDOException $e) {
        // En cas d'erreur lors de la récupération des informations, afficher un message d'erreur
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
    <!-- Définition du charset pour la page HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le SEO -->
    <meta name="description" content="Modification du résultat du match">
    
    <!-- Nom de l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Modifier le Résultat du Match</title>
    
    <!-- Lien vers le fichier CSS pour le style de la page -->
    <link rel="stylesheet" href="style/styleModifierResultatMatch.css">
    
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>
</head>
<body>
    <!-- Titre principal de la page -->
    <h1>Modifier le Résultat du Match</h1>

    <!-- Table affichant les détails du match actuel -->
    <table>
        <!-- Affichage de l'ID du match -->
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($match['IdMatch']); ?></td>
        </tr>
        <!-- Affichage de la date du match -->
        <tr>
            <th>Date du match</th>
            <td><?php echo htmlspecialchars($match['Date_Match']); ?></td>
        </tr>
        <!-- Affichage de l'heure du match -->
        <tr>
            <th>Heure du match</th>
            <td><?php echo htmlspecialchars($match['Heure_Match']); ?></td>
        </tr>
        <!-- Affichage de l'équipe adverse -->
        <tr>
            <th>Equipe adverse</th>
            <td><?php echo htmlspecialchars($match['Equipe_Adverse']); ?></td>
        </tr>
        <!-- Affichage du lieu du match -->
        <tr>
            <th>Lieu du match</th>
            <td><?php echo htmlspecialchars($match['Lieu_Match']); ?></td>
        </tr>
        <!-- Affichage du statut domicile ou extérieur -->
        <tr>
            <th>Domicile ou Exterieur</th>
            <td><?= htmlspecialchars($match['Domicile'] ? 'Extérieur' : 'Domicile'); ?></td>
        </tr>
        <!-- Affichage du résultat formaté du match -->
        <tr>
            <th>Resultat</th>
            <td><?= formaterScore($match['Resultat']); ?></td>
        </tr>
    </table>

    <!-- Titre secondaire pour la modification du résultat -->
    <h2>Modifier le Résultat</h2>
    
    <!-- Formulaire pour modifier le résultat du match -->
    <form id="formulaireModificationResultat" method="POST" action="../controleur/ControleurModificationResultatMatch.php">
        <!-- Champ caché pour envoyer l'ID du match -->
        <input type="hidden" name="id" value="<?= $match['IdMatch']; ?>">

        <!-- Sélection du nouveau résultat du match -->
        <div class="form-row">
            <label for="resultat">Nouveau Résultat:</label>
            <select id="resultat" name="resultat" required>
                <!-- Liste des options de résultats possibles avec la valeur sélectionnée basée sur l'état actuel du match -->
                <option value="-3" <?= ($match['Resultat'] == -3) ? 'selected' : ''; ?>>0-3</option>
                <option value="-2" <?= ($match['Resultat'] == -2) ? 'selected' : ''; ?>>1-3</option>
                <option value="-1" <?= ($match['Resultat'] == -1) ? 'selected' : ''; ?>>2-3</option>
                <option value="0" <?= ($match['Resultat'] == 0) ? 'selected' : ''; ?>>0-0</option>
                <option value="1" <?= ($match['Resultat'] == 1) ? 'selected' : ''; ?>>3-2</option>
                <option value="2" <?= ($match['Resultat'] == 2) ? 'selected' : ''; ?>>3-1</option>
                <option value="3" <?= ($match['Resultat'] == 3) ? 'selected' : ''; ?>>3-0</option>
            </select>
        </div>

        <!-- Bouton pour soumettre le formulaire et mettre à jour le résultat -->
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>