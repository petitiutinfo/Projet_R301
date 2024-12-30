<?php
include('../controleur/db_connexion.php');

$Matchs = [];

// Requête pour récupérer les joueurs
try {
    // Récupérer les données depuis la table `Joueurs`
    $stmt = $pdo->query("SELECT * FROM Matchs");
    $Matchs = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère les données sous forme de tableau associatif
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des matchs : " . $e->getMessage();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Page affichage matchs">
    <meta name="author" content="Enzo">
    <title>Joueurs</title>
    <!-- Fichier CSS -->
     <!-- http://localhost/PROJET_PHP/htdocs/vue/IHMAjoutJoueur.html -->
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<?php include('Menu.php'); ?>
<body>
    <h1>Liste des Matchs</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Equipe adverse</th>
                <th>Lieu</th>
                <th>Domicile ou exterieur</th>
                <th>Resultat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Matchs as $match): ?>
                <tr>
                    <td><?= htmlspecialchars($match['IdMatch']); ?></td>
                    <td><?= htmlspecialchars($match['Date_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Heure_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Equipe_Adverse']); ?></td>
                    <td><?= htmlspecialchars($match['Lieu_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Domicile']); ?></td>
                    <td><?= htmlspecialchars($match['Resultat']); ?></td>
                    <td>
                        <a href="IHMDetailsMatch.php?id=<?= $match['IdMatch']; ?>">
                            <button>Consulter</button>
                        </a>
                        <a href="IHMModifierMatch.php?id=<?= $match['IdMatch']; ?>">
                            <button>Modifier</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>