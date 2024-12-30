<?php
include('../controleur/db_connexion.php');

$joueurs = [];

// Requête pour récupérer les joueurs
try {
    // Récupérer les données depuis la table `Joueurs`
    $stmt = $pdo->query("SELECT * FROM Joueur");
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère les données sous forme de tableau associatif
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des joueurs : " . $e->getMessage();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Page affichage joueurs">
    <meta name="author" content="Enzo">
    <title>Joueurs</title>
    <!-- Fichier CSS -->
     <!-- http://localhost/PROJET_PHP/htdocs/vue/IHMAjoutJoueur.html -->
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<?php include('Menu.php'); ?>
<body>
    <h1>Liste des Joueurs</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Numéro de license</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de naissance</th>
                <th>Taille</th>
                <th>Poids</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($joueurs as $joueur): ?>
                <tr>
                    <td><?= htmlspecialchars($joueur['IdJoueur']); ?></td>
                    <td><?= htmlspecialchars($joueur['Numéro_de_license']); ?></td>
                    <td><?= htmlspecialchars($joueur['Nom']); ?></td>
                    <td><?= htmlspecialchars($joueur['Prénom']); ?></td>
                    <td><?= htmlspecialchars($joueur['Date_de_naissance']); ?></td>
                    <td><?= htmlspecialchars($joueur['Taille']); ?></td>
                    <td><?= htmlspecialchars($joueur['Poids']); ?></td>
                    <td><?= htmlspecialchars($joueur['Statut']); ?></td>
                    <td>
                        <a href="IHMDetailsJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                            <button>Consulter</button>
                        </a>
                        <a href="IHMModifierJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                            <button>Modifier</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<a href="IHMAjoutJoueur.php">
<button>Ajouter</button>
</body>
</html>