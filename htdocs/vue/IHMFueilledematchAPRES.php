<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Inclure le contrôleur pour les participations
include('../controleur/ControleurEvaluationPerformance.php');

// Vérifier si l'ID du match est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo htmlspecialchars("ID du match non spécifié.");
    exit;
}

$id_match = intval($_GET['id']);

// Récupérer les participations pour le match
try {
    $joueurs = getParticipationsByMatch($pdo, $id_match);

    if (!$joueurs) {
        echo htmlspecialchars("Aucune participation trouvée pour ce match.");
        exit;
    }
} catch (Exception $e) {
    echo htmlspecialchars("Erreur lors de la récupération des participations.");
    error_log("Erreur : " . $e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Feuille de match à venir">
    <meta name="author" content="Enzo">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <h1>Feuille de Match pour le match ID : <?= htmlspecialchars($id_match); ?></h1>

    <form id="formPerformanceJoueurs" action="../controleur/ControleurEvaluationPerformance.php" method="POST">
        <input type="hidden" name="id_match" value="<?= htmlspecialchars($id_match); ?>">
        <table>
            <thead>
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
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($joueur['Poste'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($joueur['Titulaire_ou_remplaçant'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($joueur['Nom']); ?></td>
                        <td><?= htmlspecialchars($joueur['Prénom']); ?></td>
                        <td><?= htmlspecialchars($joueur['Taille']); ?></td>
                        <td><?= htmlspecialchars($joueur['Poids']); ?></td>
                        <td><?= htmlspecialchars($joueur['Commentaire'] ?? 'Aucun commentaire'); ?></td>
                        <td>
                            <select name="note_<?= htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i; ?>" <?= (isset($joueur['Note']) && $joueur['Note'] == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Enregistrer les performances</button>
    </form>
</body>
</html>