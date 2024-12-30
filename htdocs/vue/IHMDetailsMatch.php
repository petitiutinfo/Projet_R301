<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Vérifier si l'ID du joueur est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du joueur avec l'ID
        $stmt = $pdo->prepare("SELECT * FROM Matchs WHERE idMatch = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$match) {
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
    <title>Détail du Joueur</title>
    <link rel="stylesheet" href="style.css">
    <?php include('Menu.php'); ?>
</head>
<body>
    <h1>Détails du Joueur</h1>

    <table>
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($match['IdMatch']); ?></td>
        </tr>
        <tr>
            <th>Numéro de license</th>
            <td><?php echo htmlspecialchars($match['Date_Match']); ?></td>
        </tr>
        <tr>
            <th>Nom</th>
            <td><?php echo htmlspecialchars($match['Heure_Match']); ?></td>
        </tr>
        <tr>
            <th>Prénom</th>
            <td><?php echo htmlspecialchars($match['Equipe_Adverse']); ?></td>
        </tr>
        <tr>
            <th>Date de naissance</th>
            <td><?php echo htmlspecialchars($match['Lieu_Match']); ?></td>
        </tr>
        <tr>
            <th>Taille</th>
            <td><?php echo htmlspecialchars($match['Domicile']); ?></td>
        </tr>
        <tr>
            <th>Poids</th>
            <td><?php echo htmlspecialchars($match['Resultat']); ?></td>
        </tr>
    </table>
</body>
</html>