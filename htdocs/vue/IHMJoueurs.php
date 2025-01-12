<?php
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclusion des fichiers nécessaires
include('Menu.php');
include('../controleur/ControleurJoueurs.php');

// Vérification de la connexion à la base de données
if (!isset($pdo)) {
    die("Erreur : Connexion à la base de données non établie.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Page affichage joueurs">
    <meta name="author" content="Enzo">
    <title>Joueurs</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <h1>Liste des Joueurs</h1>
    <a href="IHMAjoutJoueur.php">
        <button>Ajouter</button>
    </a>
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
                <th>Commentaires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($joueurs)) : ?>
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($joueur['IdJoueur']); ?></td>
                        <td><?= htmlspecialchars($joueur['Numéro_de_license']); ?></td>
                        <td><?= htmlspecialchars($joueur['Nom']); ?></td>
                        <td><?= htmlspecialchars($joueur['Prénom']); ?></td>
                        <td><?= htmlspecialchars($joueur['Date_de_naissance']); ?></td>
                        <td><?= htmlspecialchars($joueur['Taille']); ?></td>
                        <td><?= htmlspecialchars($joueur['Poids']); ?></td>
                        <td><?= htmlspecialchars($statut_mapping[$joueur['Statut']] ?? 'Inconnu'); ?></td>
                        <td><?= htmlspecialchars($joueur['A_Participé']); ?></td>
                        <td><?= htmlspecialchars($joueur['Commentaire'] ?? ''); ?></td>
                        <td>
                            <a href="IHMDetailsJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                                <button>Consulter</button>
                            </a>
                            <a href="IHMModifierJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                                <button>Modifier</button>
                            </a>
                            <a href="IHMCommentaire.php?id=<?= $joueur['IdJoueur']; ?>">
                                <button>Commenter</button>
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
            <?php else: ?>
                <tr>
                    <td colspan="11">Aucun joueur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>