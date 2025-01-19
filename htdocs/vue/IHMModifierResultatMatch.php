<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');
include('../controleur/ControleurRecupererMatch.php');
//include('../controleur/ControleurModificationResultatMatch.php');
include('../controleur/FormaterScore.php');

// Vérifier si l'ID du match est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $match = recupererMatchParId($pdo, $id);
        if (!$match) {
            echo "Aucun match trouvé avec cet ID.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des informations : " . $e->getMessage();
        exit;
    }
} else {
    echo "ID du match non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Modification du résultat du match">
    <meta name="author" content="Enzo">
    <title>Modifier le Résultat du Match</title>
    <link rel="stylesheet" href="JoueursCSS.css">
    <?php include('Menu.php'); ?>
</head>
<body>
    <h1>Modifier le Résultat du Match</h1>

    <table>
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($match['IdMatch']); ?></td>
        </tr>
        <tr>
            <th>Date du match</th>
            <td><?php echo htmlspecialchars($match['Date_Match']); ?></td>
        </tr>
        <tr>
            <th>Heure du match</th>
            <td><?php echo htmlspecialchars($match['Heure_Match']); ?></td>
        </tr>
        <tr>
            <th>Equipe adverse</th>
            <td><?php echo htmlspecialchars($match['Equipe_Adverse']); ?></td>
        </tr>
        <tr>
            <th>Lieu du match</th>
            <td><?php echo htmlspecialchars($match['Lieu_Match']); ?></td>
        </tr>
        <tr>
            <th>Domicile ou Exterieur</th>
            <td><?= htmlspecialchars($match['Domicile'] ? 'Extérieur' : 'Domicile'); ?></td>
        </tr>
        <tr>
            <th>Resultat</th>
            <td><?= formaterScore($match['Resultat']); ?></td>
        </tr>
    </table>

    <h2>Modifier le Résultat</h2>
    <form method="POST" action="../controleur/ControleurModificationResultatMatch.php" style="display:inline;">
        <input type="hidden" name="id" value="<?= $match['IdMatch']; ?>">
        <label for="resultat">Nouveau Résultat:</label>
        <select id="resultat" name="resultat" required>
            <option value="-3" <?= ($match['Resultat'] == -3) ? 'selected' : ''; ?>>0-3</option>
            <option value="-2" <?= ($match['Resultat'] == -2) ? 'selected' : ''; ?>>1-3</option>
            <option value="-1" <?= ($match['Resultat'] == -1) ? 'selected' : ''; ?>>2-3</option>
            <option value="0" <?= ($match['Resultat'] == 0) ? 'selected' : ''; ?>>0-0</option>
            <option value="1" <?= ($match['Resultat'] == 1) ? 'selected' : ''; ?>>3-2</option>
            <option value="2" <?= ($match['Resultat'] == 2) ? 'selected' : ''; ?>>3-1</option>
            <option value="3" <?= ($match['Resultat'] == 3) ? 'selected' : ''; ?>>3-0</option>
        </select>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>