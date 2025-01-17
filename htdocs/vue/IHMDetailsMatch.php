<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Inclure le contrôleur des matchs
include('../controleur/ControleurMatchs.php');

// Vérifier si l'ID du match est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du match via le contrôleur
        $match = getMatchById($pdo, $id);

        if (!$match) {
            echo htmlspecialchars("Aucun match trouvé avec cet ID.");
            exit;
        }
    } catch (Exception $e) {
        echo htmlspecialchars("Erreur lors de la récupération des informations.");
        error_log("Erreur : " . $e->getMessage());
        exit;
    }
} else {
    echo htmlspecialchars("ID du match non spécifié.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Détails du match">
    <meta name="author" content="Enzo">
    <title>Détails du Match</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <h1>Détails du Match</h1>

    <table>
        <tr>
            <th>ID</th>
            <td><?= htmlspecialchars($match['IdMatch']); ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?= htmlspecialchars($match['Date_Match']); ?></td>
        </tr>
        <tr>
            <th>Heure</th>
            <td><?= htmlspecialchars($match['Heure_Match']); ?></td>
        </tr>
        <tr>
            <th>Équipe adverse</th>
            <td><?= htmlspecialchars($match['Equipe_Adverse']); ?></td>
        </tr>
        <tr>
            <th>Lieu de la rencontre</th>
            <td><?= htmlspecialchars($match['Lieu_Match']); ?></td>
        </tr>
        <tr>
            <th>Domicile ou extérieur</th>
            <td><?= htmlspecialchars($match['Domicile'] ? 'Extérieur' : 'Domicile'); ?></td>
        </tr>
        <tr>
            <th>Résultat</th>
            <td><?= htmlspecialchars($match['Resultat']); ?></td>
        </tr>
    </table>
</body>
</html>