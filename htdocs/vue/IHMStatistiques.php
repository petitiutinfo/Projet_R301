<?php
// Inclure le contrôleur des statistiques
include('../controleur/ControleurStatistiques.php');

// Récupérer les statistiques générales et par joueur
try {
    $statistiques_generales = recupererStatistiquesGenerales($pdo);
    $joueurs = recupererStatistiquesJoueurs($pdo);
    $participations = recupererParticipations($pdo);
    $selections_consecutives = calculerSelectionsConsecutives($participations);

    $total_matchs = $statistiques_generales['total_matchs'];
    $pourcentage_gagnes = $total_matchs ? round(($statistiques_generales['total_gagnes'] / $total_matchs) * 100, 2) : 0;
    $pourcentage_perdus = $total_matchs ? round(($statistiques_generales['total_perdus'] / $total_matchs) * 100, 2) : 0;
    $pourcentage_nuls = $total_matchs ? round(($statistiques_generales['total_nuls'] / $total_matchs) * 100, 2) : 0;

    $statut_mapping = [
        0 => 'Actif',
        1 => 'Blessé',
        2 => 'Suspendu',
        3 => 'Absent'
    ];
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des données : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Statistiques des matchs et joueurs">
    <meta name="author" content="Enzo">
    <title>Statistiques</title>
    <link rel="stylesheet" href="stylePageStatistiques.css">
    <?php include('Menu.php'); ?>
</head>
<body>
    <h1>Statistiques</h1>
    <h2>Statistiques générales des matchs</h2>
    <ul>
        <li>Nombre total de matchs : <?= $total_matchs ?></li>
        <li>Pourcentage de matchs gagnés : <?= $pourcentage_gagnes ?>%</li>
        <li>Pourcentage de matchs perdus : <?= $pourcentage_perdus ?>%</li>
        <li>Pourcentage de matchs nuls : <?= $pourcentage_nuls ?>%</li>
    </ul>
    <h2>Statistiques par joueur</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Statut</th>
                <th>Poste Préféré</th>
                <th>Sélections Titulaires</th>
                <th>Sélections Remplaçants</th>
                <th>Moyenne des Évaluations</th>
                <th>% Victoires</th>
                <th>Sélections Consécutives</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($joueurs as $joueur) : ?>
                <tr>
                    <td><?= htmlspecialchars($joueur['Nom']) ?></td>
                    <td><?= htmlspecialchars($joueur['Prénom']) ?></td>
                    <td><?= htmlspecialchars($statut_mapping[$joueur['Statut']] ?? 'Inconnu') ?></td>
                    <td><?= htmlspecialchars($joueur['poste_prefere']) ?></td>
                    <td><?= $joueur['total_titulaires'] ?></td>
                    <td><?= $joueur['total_remplacants'] ?></td>
                    <td><?= round($joueur['moyenne_evaluations'], 2) ?></td>
                    <td><?= $joueur['pourcentage_victoires'] ?>%</td>
                    <td><?= $selections_consecutives[$joueur['IdJoueur']] ?? 0 ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>