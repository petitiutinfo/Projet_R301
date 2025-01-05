<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

try {
    // Nombre total de matchs et pourcentage de résultats
    $stmt = $pdo->query("SELECT 
        COUNT(*) AS total_matchs,
        SUM(CASE WHEN Resultat > 1 THEN 1 ELSE 0 END) AS total_gagnes,
        SUM(CASE WHEN Resultat < 1 THEN 1 ELSE 0 END) AS total_perdus,
        SUM(CASE WHEN Resultat = 0 THEN 1 ELSE 0 END) AS total_nuls
    FROM Matchs");
    $resultats = $stmt->fetch(PDO::FETCH_ASSOC);

    $total_matchs = $resultats['total_matchs'];
    $pourcentage_gagnes = $total_matchs ? round(($resultats['total_gagnes'] / $total_matchs) * 100, 2) : 0;
    $pourcentage_perdus = $total_matchs ? round(($resultats['total_perdus'] / $total_matchs) * 100, 2) : 0;
    $pourcentage_nuls = $total_matchs ? round(($resultats['total_nuls'] / $total_matchs) * 100, 2) : 0;

    // Statistiques par joueur
    $stmt = $pdo->query("SELECT 
        j.Nom, j.Prénom, j.Statut,
        MAX(p.Poste) AS poste_prefere,
        SUM(CASE WHEN p.Titulaire_ou_remplaçant = 'Titulaire' THEN 1 ELSE 0 END) AS total_titulaires,
        SUM(CASE WHEN p.Titulaire_ou_remplaçant = 'Remplaçant' THEN 1 ELSE 0 END) AS total_remplacants,
        AVG(p.Note) AS moyenne_evaluations,
        ROUND(SUM(CASE WHEN m.Resultat = 'Gagné' THEN 1 ELSE 0 END) * 100.0 / COUNT(m.idMatch), 2) AS pourcentage_victoires,
        MAX(DATEDIFF(CURRENT_DATE, m.Date_Match)) AS selections_consecutives
    FROM Joueur j
    LEFT JOIN Participer p ON j.idJoueur = p.idJoueur
    LEFT JOIN Matchs m ON p.idMatch = m.idMatch
    GROUP BY j.idJoueur");
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur lors de la récupération des statistiques : " . $e->getMessage();
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
    <link rel="stylesheet" href="StatistiquesCSS.css">
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
                    <td><?= htmlspecialchars($joueur['Prenom']) ?></td>
                    <td><?= htmlspecialchars($joueur['Statut']) ?></td>
                    <td><?= htmlspecialchars($joueur['poste_prefere']) ?></td>
                    <td><?= $joueur['total_titulaires'] ?></td>
                    <td><?= $joueur['total_remplacants'] ?></td>
                    <td><?= round($joueur['moyenne_evaluations'], 2) ?></td>
                    <td><?= $joueur['pourcentage_victoires'] ?>%</td>
                    <td><?= $joueur['selections_consecutives'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>