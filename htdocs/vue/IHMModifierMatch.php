<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Vérifier si l'ID du match est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du match avec l'ID
        $stmt = $pdo->prepare("SELECT * FROM Matchs WHERE IdMatch = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <meta name="description" content="Page modification match">
    <meta name="author" content="Enzo">
    <title>Modifier Match</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <h1 id="titrePageAccueil">Page de modification de match</h1>

    <!-- Formulaire prérempli avec les données existantes -->
    <form id="formulaireModifierMatch" action="../controleur/ControleurModifierMatch.php" method="POST">
        <!-- Champ caché pour envoyer l'ID du match -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($match['IdMatch']); ?>">

        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($match['Date_Match']); ?>" required>
        </div>
        <div class="form-group">
            <label for="heure">Heure :</label>
            <input type="time" id="heure" name="heure" value="<?php echo htmlspecialchars($match['Heure_Match']); ?>" required>
        </div>
        <div class="form-group">
            <label for="equipe_adverse">Équipe adverse :</label>
            <input type="text" id="equipe_adverse" name="equipe_adverse" maxlength="50" value="<?php echo htmlspecialchars($match['Equipe_Adverse']); ?>" required>
        </div>
        <div class="form-group">
            <label for="Lieu">Lieu :</label>
            <input type="text" id="Lieu" name="Lieu" maxlength="50" value="<?php echo htmlspecialchars($match['Lieu_Match']); ?>" required>
        </div>
        <div class="form-group">
            <label for="Domicile">Domicile ou extérieur :</label>
            <select id="Domicile" name="Domicile" required>
                <option value="1" <?php echo ($match['Domicile'] == 1) ? 'selected' : ''; ?>>Domicile</option>
                <option value="0" <?php echo ($match['Domicile'] == 0) ? 'selected' : ''; ?>>Extérieur</option>
            </select>
        </div>
        <div class="form-group">
            <label for="resultat">Résultat :</label>
            <input type="text" id="resultat" name="resultat" maxlength="50" value="<?php echo htmlspecialchars($match['Resultat']); ?>">
        </div>
        <button id="bontonModificationMatch" type="submit">Confirmer les modifications</button>
    </form>
</body>
</html>