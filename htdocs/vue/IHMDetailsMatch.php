<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion du fichier contrôleur pour récupérer les données des matchs
include('../controleur/ControleurMatchs.php');

// Inclusion du fichier pour formater le score des matchs
include('../controleur/FormaterScore.php');

// Vérification si l'ID du match est passé dans l'URL via la méthode GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Conversion de l'ID en entier pour éviter les injections SQL
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du match en utilisant la fonction getMatchById()
        $match = getMatchById($pdo, $id);

        // Si aucun match n'est trouvé avec cet ID, afficher un message d'erreur
        if (!$match) {
            echo htmlspecialchars("Aucun match trouvé avec cet ID.");
            exit;
        }
    } catch (Exception $e) {
        // En cas d'erreur lors de la récupération des données du match, afficher un message d'erreur
        // et enregistrer l'erreur dans le fichier de log pour le suivi
        echo htmlspecialchars("Erreur lors de la récupération des informations.");
        error_log("Erreur : " . $e->getMessage());
        exit;
    }
} else {
    // Si l'ID du match n'est pas spécifié dans l'URL, afficher un message d'erreur
    echo htmlspecialchars("ID du match non spécifié.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définir l'encodage des caractères du document HTML -->
    <meta charset="UTF-8">
    
    <!-- Fournir une description de la page pour le référencement SEO -->
    <meta name="description" content="Détails du match">
    
    <!-- Indiquer l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Définir le titre de la page qui sera affiché dans l'onglet du navigateur -->
    <title>Détails du Match</title>
    
    <!-- Inclusion du fichier CSS pour styliser la page -->
    <link rel="stylesheet" href="style/stylePageDetails.css">
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>

    <!-- Titre principal de la page affichant les détails du match -->
    <h1>Détails du Match</h1>

    <!-- Tableau pour afficher les détails du match -->
    <table>
        <!-- Ligne pour afficher l'ID du match -->
        <tr>
            <th>ID</th>
            <td><?= htmlspecialchars($match['IdMatch']); ?></td>
        </tr>
        <!-- Ligne pour afficher la date du match -->
        <tr>
            <th>Date</th>
            <td><?= htmlspecialchars($match['Date_Match']); ?></td>
        </tr>
        <!-- Ligne pour afficher l'heure du match -->
        <tr>
            <th>Heure</th>
            <td><?= htmlspecialchars($match['Heure_Match']); ?></td>
        </tr>
        <!-- Ligne pour afficher l'équipe adverse -->
        <tr>
            <th>Équipe adverse</th>
            <td><?= htmlspecialchars($match['Equipe_Adverse']); ?></td>
        </tr>
        <!-- Ligne pour afficher le lieu de la rencontre -->
        <tr>
            <th>Lieu de la rencontre</th>
            <td><?= htmlspecialchars($match['Lieu_Match']); ?></td>
        </tr>
        <!-- Ligne pour afficher si le match est à domicile ou à l'extérieur -->
        <tr>
            <th>Domicile ou extérieur</th>
            <td><?= htmlspecialchars($match['Domicile'] ? 'Extérieur' : 'Domicile'); ?></td>
        </tr>
        <!-- Ligne pour afficher le résultat du match en utilisant la fonction formaterScore() -->
        <tr>
            <th>Résultat</th>
            <td><?= formaterScore($match['Resultat']); ?></td>
        </tr>
    </table>
</body>
</html>