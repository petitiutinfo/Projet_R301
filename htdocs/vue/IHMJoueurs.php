<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion des fichiers nécessaires pour gérer les joueurs
include('../controleur/ControleurJoueurs.php');

// Vérification de la connexion à la base de données
if (!isset($pdo)) {
    // Si la connexion à la base de données n'est pas établie, afficher un message d'erreur et arrêter l'exécution
    die("Erreur : Connexion à la base de données non établie.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définir l'encodage des caractères du document HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le référencement SEO -->
    <meta name="description" content="Page affichage joueurs">
    
    <!-- Indiquer l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Joueurs</title>
    
    <!-- Lien vers le fichier CSS pour styliser la page -->
    <link rel="stylesheet" href="style/stylePageAffichage.css">
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>

    <!-- Titre principal de la page affichant la liste des joueurs -->
    <h1>Liste des Joueurs</h1>
    
    <!-- Lien pour ajouter un nouveau joueur -->
    <a id="BoutonAjouter" href="IHMAjoutJoueur.php">
        <button>Ajouter</button>
    </a>
    
    <!-- Tableau affichant les informations des joueurs -->
    <table border="1">
        <thead>
            <!-- En-têtes de colonne pour chaque information à afficher -->
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
            <!-- Vérifier si la liste des joueurs n'est pas vide -->
            <?php if (!empty($joueurs)) : ?>
                <!-- Boucle pour afficher chaque joueur -->
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <!-- Affichage des informations du joueur, en s'assurant de sécuriser les données avec htmlspecialchars -->
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
                            <!-- Lien pour consulter les détails du joueur -->
                            <a href="IHMDetailsJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                                <button>Consulter</button>
                            </a>
                            <!-- Lien pour modifier les informations du joueur -->
                            <a href="IHMModifierJoueur.php?id=<?= $joueur['IdJoueur']; ?>">
                                <button>Modifier</button>
                            </a>
                            <!-- Lien pour ajouter un commentaire sur le joueur -->
                            <a href="IHMCommentaire.php?id=<?= $joueur['IdJoueur']; ?>">
                                <button>Commenter</button>
                            </a>
                            <!-- Si le joueur n'a pas participé à un match, permettre la suppression -->
                            <?php if ($joueur['A_Participé'] === 'Non'): ?>
                                <!-- Formulaire pour supprimer un joueur -->
                                <form method="POST" action="../controleur/ControleurSuppressionJoueur.php" style="display:inline;">
                                    <!-- Champ caché pour l'ID du joueur -->
                                    <input type="hidden" name="IdJoueur" value="<?= $joueur['IdJoueur']; ?>">
                                    <!-- Bouton pour supprimer le joueur -->
                                    <button type="submit" class="delete-button">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Si aucun joueur n'est trouvé, afficher un message dans une ligne de tableau -->
                <tr>
                    <td colspan="11">Aucun joueur trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>