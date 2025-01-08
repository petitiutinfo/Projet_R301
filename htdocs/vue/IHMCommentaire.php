<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Vérifier si l'ID du joueur est défini et non vide
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Assurer que l'ID est un entier
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du joueur avec l'ID
        $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE IdJoueur = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $joueur = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si un joueur a été trouvé
        if (!$joueur) {
            echo htmlspecialchars("Aucun joueur trouvé avec cet ID.");
            exit;
        }

        // Récupérer le commentaire existant (si disponible)
        $stmt = $pdo->prepare("SELECT Commentaire FROM Commentaire WHERE IdJoueur = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $commentaire = $stmt->fetchColumn();

    } catch (PDOException $e) {
        // Afficher un message d'erreur générique
        echo htmlspecialchars("Une erreur est survenue lors de la récupération des données.");
        // Journaliser l'erreur pour diagnostic
        error_log("Erreur PDO : " . $e->getMessage());
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
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($joueur['nom']); ?></p>
        <p><strong>Prénom :</strong> <?php echo htmlspecialchars($joueur['prenom']); ?></p>
        <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($joueur['date_naissance']); ?></p>
        <p><strong>Taille :</strong> <?php echo htmlspecialchars($joueur['taille']); ?> cm</p>
        <p><strong>Poids :</strong> <?php echo htmlspecialchars($joueur['poids']); ?> kg</p>
        <p><strong>Statut :</strong> <?php echo htmlspecialchars($joueur['statut']); ?></p>
    </div>

    <form action="../controleur/ControleurCommentaires.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="form-group">
            <label for="commentaire">Commentaires :</label>
            <textarea id="commentaire" name="commentaire" rows="10" cols="50"><?php echo htmlspecialchars($commentaire ?? ''); ?></textarea>
        </div>

        <button type="submit">Valider</button>
    </form>
</body>
</html>