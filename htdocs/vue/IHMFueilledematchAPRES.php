<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion du contrôleur pour gérer les participations et les évaluations de performance
include('../controleur/ControleurEvaluationPerformance.php');

// Vérification si l'ID du match est passé dans l'URL (par la méthode GET)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si l'ID n'est pas spécifié, afficher un message d'erreur et arrêter l'exécution du script
    echo htmlspecialchars("ID du match non spécifié.");
    exit;
}

// Récupérer l'ID du match et le convertir en entier pour éviter des injections de type SQL
$id_match = intval($_GET['id']);

// Récupérer les participations des joueurs pour le match spécifié
try {
    // Appeler la fonction pour récupérer les participations via la base de données
    $joueurs = getParticipationsByMatch($pdo, $id_match);

    // Si aucune participation n'est trouvée pour ce match, afficher un message et arrêter l'exécution
    if (!$joueurs) {
        echo htmlspecialchars("Aucune participation trouvée pour ce match.");
        exit;
    }
} catch (Exception $e) {
    // Si une exception est levée lors de la récupération des participations, afficher un message d'erreur
    echo htmlspecialchars("Erreur lors de la récupération des participations.");
    // Enregistrer l'erreur dans le fichier de log
    error_log("Erreur : " . $e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définir l'encodage des caractères du document HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le référencement SEO -->
    <meta name="description" content="Feuille de match à venir">
    
    <!-- Indiquer l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Feuille de Match</title>
    
    <!-- Lien vers le fichier CSS pour styliser la page -->
    <link rel="stylesheet" href="style/styleFeuilleDeMatch.css">
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>

    <!-- Titre principal de la page affichant l'ID du match -->
    <h1>Feuille de Match pour le match ID : <?= htmlspecialchars($id_match); ?></h1>

    <!-- Formulaire pour évaluer la performance des joueurs -->
    <form id="formPerformanceJoueurs" action="../controleur/ControleurEvaluationPerformance.php" method="POST">
        <!-- Champ caché contenant l'ID du match -->
        <input type="hidden" name="id_match" value="<?= htmlspecialchars($id_match); ?>">
        
        <!-- Tableau affichant les joueurs et permettant d'évaluer leurs performances -->
        <table>
            <thead>
                <!-- En-têtes de colonne pour chaque information à afficher -->
                <tr>
                    <th>Poste</th>
                    <th>Titulaire / Remplaçant</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille (cm)</th>
                    <th>Poids (kg)</th>
                    <th>Commentaires</th>
                    <th>Évaluations de Performance</th>
                </tr>
            </thead>
            <tbody>
                <!-- Boucle pour afficher chaque joueur et ses informations dans une ligne du tableau -->
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <!-- Affichage du poste du joueur (si disponible) -->
                        <td><?= htmlspecialchars($joueur['Poste'] ?? ''); ?></td>
                        
                        <!-- Affichage du rôle (Titulaire / Remplaçant) du joueur (si disponible) -->
                        <td><?= htmlspecialchars($joueur['Titulaire_ou_remplaçant'] ?? ''); ?></td>
                        
                        <!-- Affichage du nom du joueur -->
                        <td><?= htmlspecialchars($joueur['Nom']); ?></td>
                        
                        <!-- Affichage du prénom du joueur -->
                        <td><?= htmlspecialchars($joueur['Prénom']); ?></td>
                        
                        <!-- Affichage de la taille du joueur -->
                        <td><?= htmlspecialchars($joueur['Taille']); ?></td>
                        
                        <!-- Affichage du poids du joueur -->
                        <td><?= htmlspecialchars($joueur['Poids']); ?></td>
                        
                        <!-- Affichage des commentaires du joueur, ou un message par défaut si aucun commentaire -->
                        <td><?= htmlspecialchars($joueur['Commentaire'] ?? 'Aucun commentaire'); ?></td>
                        
                        <!-- Sélecteur de notes pour l'évaluation de la performance du joueur -->
                        <td>
                            <select name="note_<?= htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <!-- Boucle pour générer les options de notation de 1 à 5 -->
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i; ?>" <?= (isset($joueur['Note']) && $joueur['Note'] == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Bouton pour soumettre le formulaire et enregistrer les évaluations des performances -->
        <button type="submit">Enregistrer les performances</button>
    </form>
</body>
</html>
