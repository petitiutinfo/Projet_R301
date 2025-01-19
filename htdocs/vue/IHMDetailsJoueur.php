<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');  // Fichier contenant la logique de connexion à la base de données

// Inclure le contrôleur des joueurs
include('../controleur/ControleurJoueurs.php');  // Fichier qui gère la logique des joueurs (récupération, manipulation des données des joueurs)

// Vérifier si l'ID du joueur est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {  // Vérifie si l'ID du joueur est passé et non vide dans l'URL
    $id = intval($_GET['id']);  // Récupère l'ID du joueur, assure qu'il est un entier

    try {
        // Récupérer les informations du joueur via le contrôleur
        $joueur = getJoueurById($pdo, $id);  // Fonction qui récupère les informations du joueur à partir de la base de données

        if (!$joueur) {  // Si aucune information n'est trouvée pour cet ID
            echo htmlspecialchars("Aucun joueur trouvé avec cet ID.");  // Affiche un message d'erreur
            exit;  // Arrête le script si aucune donnée n'est trouvée
        }
    } catch (Exception $e) {  // Si une exception est levée pendant la récupération des données
        echo htmlspecialchars("Erreur lors de la récupération des informations.");  // Affiche un message d'erreur
        error_log("Erreur : " . $e->getMessage());  // Enregistre l'erreur dans les logs du serveur pour le débogage
        exit;  // Arrête l'exécution du script
    }
} else {  // Si l'ID du joueur n'est pas spécifié dans l'URL
    echo htmlspecialchars("ID du joueur non spécifié.");  // Affiche un message d'erreur
    exit;  // Arrête l'exécution du script
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">  <!-- Spécifie le jeu de caractères utilisé -->
    <meta name="description" content="Détails du joueur">  <!-- Description pour le SEO -->
    <meta name="author" content="Enzo">  <!-- Auteur de la page -->
    <title>Détails du Joueur</title>  <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <link rel="stylesheet" href="style/stylePageDetails.css">  <!-- Lien vers la feuille de style CSS -->
</head>
<body>
    <?php include('Menu.php'); ?>  <!-- Inclusion du menu de navigation -->

    <!-- En-tête avec le nom du joueur -->
    <header class="header-joueur">
        <h1><?= htmlspecialchars($joueur['Nom']) . " " . htmlspecialchars($joueur['Prénom']); ?></h1>  <!-- Affiche le nom et le prénom du joueur -->
        <p>#<?= htmlspecialchars($joueur['Numéro_de_license']); ?></p>  <!-- Affiche le numéro de licence du joueur -->
    </header>

    <!-- Contenu principal -->
    <main class="details-joueur">
        <!-- Organisation en deux colonnes -->
        <section class="colonne-gauche">
            <h2>Informations générales</h2>
            <ul>
                <li><strong>ID :</strong> <?= htmlspecialchars($joueur['IdJoueur']); ?></li>  <!-- Affiche l'ID du joueur -->
                <li><strong>Numéro de license :</strong> <?= htmlspecialchars($joueur['Numéro_de_license']); ?></li>  <!-- Affiche le numéro de licence -->
                <li><strong>Nom :</strong> <?= htmlspecialchars($joueur['Nom']); ?></li>  <!-- Affiche le nom du joueur -->
                <li><strong>Prénom :</strong> <?= htmlspecialchars($joueur['Prénom']); ?></li>  <!-- Affiche le prénom du joueur -->
            </ul>
        </section>

        <section class="colonne-droite">
            <h2>Caractéristiques</h2>
            <ul>
                <li><strong>Date de naissance :</strong> <?= htmlspecialchars($joueur['Date_de_naissance']); ?></li>  <!-- Affiche la date de naissance du joueur -->
                <li><strong>Taille :</strong> <?= htmlspecialchars($joueur['Taille']); ?> cm</li>  <!-- Affiche la taille du joueur en cm -->
                <li><strong>Poids :</strong> <?= htmlspecialchars($joueur['Poids']); ?> kg</li>  <!-- Affiche le poids du joueur en kg -->
                <li><strong>Statut :</strong> <?= htmlspecialchars($statut_mapping[$joueur['Statut']] ?? 'Inconnu'); ?></li>  <!-- Affiche le statut du joueur avec une valeur par défaut 'Inconnu' si non trouvé -->
            </ul>
        </section>
    </main>
</body>
</html>
