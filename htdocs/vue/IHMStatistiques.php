<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion du contrôleur pour récupérer les statistiques des matchs et des joueurs
include('../controleur/ControleurStatistiques.php');

// Récupérer les statistiques générales et les statistiques par joueur
try {
    // Récupération des statistiques générales des matchs
    $statistiques_generales = recupererStatistiquesGenerales($pdo);
    // Récupération des statistiques des joueurs
    $joueurs = recupererStatistiquesJoueurs($pdo);
    // Récupération des participations des joueurs aux matchs
    $participations = recupererParticipations($pdo);
    // Calcul des sélections consécutives des joueurs
    $selections_consecutives = calculerSelectionsConsecutives($participations);

    // Calcul du nombre total de matchs
    $total_matchs = $statistiques_generales['total_matchs'];
    // Calcul du nombre total de matchs gagnés
    $total_gagnes = $statistiques_generales['total_gagnes'];
    // Calcul du pourcentage de matchs gagnés
    $pourcentage_gagnes = $total_matchs ? round(($statistiques_generales['total_gagnes'] / $total_matchs) * 100, 2) : 0;
    // Calcul du nombre total de matchs perdus
    $total_perdus = $statistiques_generales['total_perdus'];
    // Calcul du pourcentage de matchs perdus
    $pourcentage_perdus = $total_matchs ? round(($statistiques_generales['total_perdus'] / $total_matchs) * 100, 2) : 0;
    // Calcul du nombre total de matchs gagnés
    $total_nuls = $statistiques_generales['total_nuls'];
    // Calcul du pourcentage de matchs nuls
    $pourcentage_nuls = $total_matchs ? round(($statistiques_generales['total_nuls'] / $total_matchs) * 100, 2) : 0;

    // Tableau associatif pour mapper les statuts des joueurs à des valeurs lisibles
    $statut_mapping = [
        0 => 'Actif',
        1 => 'Blessé',
        2 => 'Suspendu',
        3 => 'Absent'
    ];
} catch (PDOException $e) {
    // Si une erreur se produit lors de la récupération des données, afficher un message d'erreur et arrêter l'exécution
    echo "Erreur lors de la récupération des données : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition du charset pour la page HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le SEO -->
    <meta name="description" content="Statistiques des matchs et joueurs">
    
    <!-- Nom de l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Statistiques</title>
    
    <!-- Lien vers le fichier CSS pour le style de la page -->
    <link rel="stylesheet" href="style/stylePageStatistiques.css">
    
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>
</head>
<body>
    <!-- Titre principal de la page -->
    <h1>Statistiques</h1>
    
    <!-- Section des statistiques générales des matchs -->
    <h2>Statistiques générales des matchs</h2>
    <ul id="statsGénérales">
        <!-- Affichage du nombre total de matchs -->
        <li>Nombre total de matchs : <?= $total_matchs ?></li>
        <!-- Affichage du nombre total et le poucentage de matchs gagnés -->
        <li>Nombre total de matchs gagnés : <?= $total_gagnes ?> - Pourcentage de matchs gagnés : <?= $pourcentage_gagnes ?>%</li>
        <!-- Affichage du nombre total et le poucentage de matchs perdus -->
        <li>Nombre total de matchs perdus : <?= $total_perdus ?> - Pourcentage de matchs perdus : <?= $pourcentage_perdus ?>%</li>
        <!-- Affichage du nombre total et le poucentage de matchs nuls-->
        <li>Nombre total de matchs nuls : <?= $total_nuls ?> - Pourcentage de matchs nuls : <?= $pourcentage_nuls ?>%</li>
    </ul>
    
    <!-- Section des statistiques par joueur -->
    <h2>Statistiques par joueur</h2>
    <!-- Table affichant les statistiques des joueurs -->
    <table>
        <thead>
            <tr>
                <!-- En-têtes de colonnes pour chaque statistique -->
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
                <!-- Ligne de la table pour chaque joueur -->
                <tr>
                    <!-- Affichage des informations de chaque joueur -->
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