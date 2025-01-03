<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Vérifier si l'ID du match est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID du match non spécifié.";
    exit;
}

$id_match = intval($_GET['id']);

// Récupérer les participations pour le match
try {
    $stmt = $pdo->prepare("
        SELECT 
            p.IdJoueur, p.Poste, p.Titulaire_ou_remplaçant, p.Note,
            j.Nom, j.Prénom, j.Taille, j.Poids, c.Commentaire
        FROM Participer p
        INNER JOIN Joueur j ON p.IdJoueur = j.IdJoueur
        LEFT JOIN Commentaire c ON c.IdJoueur = j.IdJoueur
        WHERE p.IdMatch = :id_match
    ");
    $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
    $stmt->execute();
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des participations : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Feuille de match passée">
    <meta name="author" content="Enzo">
    <title>Feuille de Match Passée</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <h1>Feuille de Match Passée pour le match ID : <?php echo htmlspecialchars($id_match); ?></h1>

    <form id="formPerformanceJoueurs" action="../controleur/ControleurEvaluationPerformance.php" method="POST">
        <input type="hidden" name="id_match" value="<?php echo htmlspecialchars($id_match); ?>">
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
                        <td><?php echo htmlspecialchars($joueur['Poste'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Titulaire_ou_remplaçant'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Nom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Prénom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Taille']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Poids']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Commentaire'] ?? 'Aucun commentaire'); ?></td>
                        <td>
                            <select name="note_<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <option value="1" <?php echo (isset($joueur['Note']) && $joueur['Note'] == 1) ? 'selected' : ''; ?>>1</option>
                                <option value="2" <?php echo (isset($joueur['Note']) && $joueur['Note'] == 2) ? 'selected' : ''; ?>>2</option>
                                <option value="3" <?php echo (isset($joueur['Note']) && $joueur['Note'] == 3) ? 'selected' : ''; ?>>3</option>
                                <option value="4" <?php echo (isset($joueur['Note']) && $joueur['Note'] == 4) ? 'selected' : ''; ?>>4</option>
                                <option value="5" <?php echo (isset($joueur['Note']) && $joueur['Note'] == 5) ? 'selected' : ''; ?>>5</option>
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