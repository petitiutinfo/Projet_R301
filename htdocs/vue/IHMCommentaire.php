<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Inclure le contrôleur pour récupérer les données
include('../controleur/ControleurJoueurs.php');

// Vérifier si l'ID du joueur est défini et non vide
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du joueur
        $joueur = getJoueurById($pdo, $id);

        // Récupérer le commentaire existant (si disponible)
        $commentaire = getCommentaireByJoueurId($pdo, $id);

    } catch (Exception $e) {
        echo htmlspecialchars("Une erreur est survenue lors de la récupération des données.");
        error_log("Erreur : " . $e->getMessage());
        exit;
    }

} else {
    echo htmlspecialchars("ID du joueur non spécifié.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Page Commentaire">
    <meta name="author" content="Enzo">
    <title>Modifier le Commentaire</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <h1>Modifier le Commentaire du Joueur</h1>
    
    <div>
        <h2>Informations du joueur</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($joueur['Nom']); ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($joueur['Prénom']); ?></p>
        <p><strong>Date de naissance :</strong> <?= htmlspecialchars($joueur['Date_de_naissance']); ?></p>
        <p><strong>Taille :</strong> <?= htmlspecialchars($joueur['Taille']); ?> cm</p>
        <p><strong>Poids :</strong> <?= htmlspecialchars($joueur['Poids']); ?> kg</p>
        <p><strong>Statut :</strong> <?= htmlspecialchars($joueur['Statut']); ?></p>
    </div>

    <form action="../controleur/ControleurCommentaires.php" method="POST">
        <input type="hidden" name="id" value="<?= $id; ?>">
        
        <div class="form-group">
            <label for="commentaire">Commentaires :</label>
            <textarea id="commentaire" name="commentaire" rows="10" cols="50"><?= htmlspecialchars($commentaire ?? ''); ?></textarea>
        </div>

        <button type="submit">Valider</button>
    </form>
</body>
</html>