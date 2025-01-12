<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Inclure le contrôleur des joueurs
include('../controleur/ControleurJoueurs.php');

// Vérifier si l'ID du joueur est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du joueur via le contrôleur
        $joueur = getJoueurById($pdo, $id);

        if (!$joueur) {
            echo htmlspecialchars("Aucun joueur trouvé avec cet ID.");
            exit;
        }
    } catch (Exception $e) {
        echo htmlspecialchars("Erreur lors de la récupération des informations.");
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
    <meta name="description" content="Détails du joueur">
    <meta name="author" content="Enzo">
    <title>Détails du Joueur</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <!-- En-tête avec le nom du joueur -->
    <header class="header-joueur">
        <h1><?= htmlspecialchars($joueur['Nom']) . " " . htmlspecialchars($joueur['Prénom']); ?></h1>
        <p>#<?= htmlspecialchars($joueur['Numéro_de_license']); ?></p>
    </header>

    <!-- Contenu principal -->
    <main class="details-joueur">
        <!-- Organisation en deux colonnes -->
        <section class="colonne-gauche">
            <h2>Informations générales</h2>
            <ul>
                <li><strong>ID :</strong> <?= htmlspecialchars($joueur['IdJoueur']); ?></li>
                <li><strong>Numéro de license :</strong> <?= htmlspecialchars($joueur['Numéro_de_license']); ?></li>
                <li><strong>Nom :</strong> <?= htmlspecialchars($joueur['Nom']); ?></li>
                <li><strong>Prénom :</strong> <?= htmlspecialchars($joueur['Prénom']); ?></li>
            </ul>
        </section>

        <section class="colonne-droite">
            <h2>Caractéristiques</h2>
            <ul>
                <li><strong>Date de naissance :</strong> <?= htmlspecialchars($joueur['Date_de_naissance']); ?></li>
                <li><strong>Taille :</strong> <?= htmlspecialchars($joueur['Taille']); ?> cm</li>
                <li><strong>Poids :</strong> <?= htmlspecialchars($joueur['Poids']); ?> kg</li>
                <li><strong>Statut :</strong> <?= htmlspecialchars($joueur['Statut']); ?></li>
            </ul>
        </section>
    </main>
</body>
</html>