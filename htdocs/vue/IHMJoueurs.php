<?php
include('../controleur/db_connexion.php');

$joueurs = [];

// Requête pour récupérer les joueurs et vérifier leur participation
try {
    $stmt = $pdo->query("
        SELECT j.IdJoueur, j.Numéro_de_license, j.Nom, j.Prénom, j.Date_de_naissance, j.Taille, j.Poids, j.Statut,
               CASE WHEN p.IdJoueur IS NULL THEN 'Non' ELSE 'Oui' END AS A_Participé
        FROM Joueur j
        LEFT JOIN Participer p ON j.IdJoueur = p.IdJoueur
        GROUP BY j.IdJoueur, j.Numéro_de_license, j.Nom, j.Prénom, j.Date_de_naissance, j.Taille, j.Poids, j.Statut, p.IdJoueur;
    ");
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des joueurs : " . $e->getMessage();
}

// Activer l'affichage des erreurs
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
                <th>A Participé à un Match</th>
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
                    <td><?= htmlspecialchars($joueur['A_Participé']); ?></td>
                    <td>
                        <a href="IHMDetailsJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                            <button>Consulter</button>
                        </a>
                        <a href="IHMModifierJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                            <button>Modifier</button>
                        </a>
                        <?php if ($joueur['A_Participé'] === 'Non'): ?>
                            <form method="POST" action="../controleur/ControleurSuppressionJoueur.php" style="display:inline;">
                                <input type="hidden" name="IdJoueur" value="<?= $joueur['IdJoueur']; ?>">
                                <button type="submit" class="delete-button">Supprimer</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="IHMAjoutJoueur.php">
        <button>Ajouter</button>
    </a>
</body>
</html>