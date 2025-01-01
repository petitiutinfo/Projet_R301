<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Vérifier si l'ID du joueur est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du joueur avec l'ID
        $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE idJoueur = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $joueur = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$joueur) {
            echo "Aucun joueur trouvé avec cet ID.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des informations : " . $e->getMessage();
        exit;
    }
} else {
    echo "ID du joueur non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Détails du joueur">
    <meta name="author" content="Enzo">
    <title>Détails du Joueur</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <!-- En-tête avec le nom du joueur -->
    <header class="header-joueur">
        <h1><?php echo htmlspecialchars($joueur['Nom']) . " " . htmlspecialchars($joueur['Prénom']); ?></h1>
        <p>#<?php echo htmlspecialchars($joueur['Numéro_de_license']); ?></p>
    </header>

    <!-- Contenu principal -->
    <main class="details-joueur">
        <!-- Organisation en deux colonnes -->
        <section class="colonne-gauche">
            <h2>Informations générales</h2>
            <ul>
                <li><strong>ID :</strong> <?php echo htmlspecialchars($joueur['IdJoueur']); ?></li>
                <li><strong>Numéro de license :</strong> <?php echo htmlspecialchars($joueur['Numéro_de_license']); ?></li>
                <li><strong>Nom :</strong> <?php echo htmlspecialchars($joueur['Nom']); ?></li>
                <li><strong>Prénom :</strong> <?php echo htmlspecialchars($joueur['Prénom']); ?></li>
            </ul>
        </section>

        <section class="colonne-droite">
            <h2>Caractéristiques</h2>
            <ul>
                <li><strong>Date de naissance :</strong> <?php echo htmlspecialchars($joueur['Date_de_naissance']); ?></li>
                <li><strong>Taille :</strong> <?php echo htmlspecialchars($joueur['Taille']); ?> cm</li>
                <li><strong>Poids :</strong> <?php echo htmlspecialchars($joueur['Poids']); ?> kg</li>
                <li><strong>Statut :</strong> <?php echo htmlspecialchars($joueur['Statut']); ?></li>
            </ul>
        </section>
    </main>

    <!-- Optionnel : bouton de retour ou d'action -->
    <footer class="footer-joueur">
        <a href="/liste_joueurs.php" class="btn-retour">Retour à la liste</a>
        <a href="/modifier_joueur.php?id=<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" class="btn-modifier">Modifier le joueur</a>
    </footer>
</body>
</html>