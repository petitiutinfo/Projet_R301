<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion du contrôleur pour récupérer les données des joueurs
include('../controleur/ControleurJoueurs.php');

// Vérifier si l'ID du joueur est défini et non vide dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Conversion de l'ID en entier pour éviter les injections SQL
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du joueur à partir de la base de données
        $joueur = getJoueurById($pdo, $id);

        // Récupérer le commentaire existant du joueur, s'il existe
        $commentaire = getCommentaireByJoueurId($pdo, $id);

    } catch (Exception $e) {
        // Si une erreur se produit, afficher un message d'erreur générique
        // et loguer l'erreur dans les fichiers de log pour un suivi plus détaillé
        echo htmlspecialchars("Une erreur est survenue lors de la récupération des données.");
        error_log("Erreur : " . $e->getMessage());
        exit;
    }

} else {
    // Si l'ID du joueur n'est pas spécifié, afficher un message d'erreur
    echo htmlspecialchars("ID du joueur non spécifié.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définir l'encodage des caractères du document HTML -->
    <meta charset="UTF-8">
    
    <!-- Fournir une description pour le SEO -->
    <meta name="description" content="Page Commentaire">
    
    <!-- Spécifier l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page dans l'onglet du navigateur -->
    <title>Modifier le Commentaire</title>
    
    <!-- Inclusion du fichier CSS pour la mise en forme de la page -->
    <link rel="stylesheet" href="style/stylePageCommentaire.css">
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>

    <!-- Titre de la page indiquant l'action (modifier le commentaire) -->
    <h1>Modifier le Commentaire du Joueur</h1>
    
    <!-- Affichage des informations du joueur récupérées -->
    <div>
        <h2>Informations du joueur</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($joueur['Nom']); ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($joueur['Prénom']); ?></p>
        <p><strong>Date de naissance :</strong> <?= htmlspecialchars($joueur['Date_de_naissance']); ?></p>
        <p><strong>Taille :</strong> <?= htmlspecialchars($joueur['Taille']); ?> cm</p>
        <p><strong>Poids :</strong> <?= htmlspecialchars($joueur['Poids']); ?> kg</p>
        <p><strong>Statut :</strong> <?= htmlspecialchars($statut_mapping[$joueur['Statut']] ?? 'Inconnu'); ?></p>
    </div>

    <!-- Formulaire permettant de modifier le commentaire du joueur -->
    <form action="../controleur/ControleurCommentaires.php" method="POST">
        <!-- Champ caché pour envoyer l'ID du joueur au contrôleur lors de la soumission -->
        <input type="hidden" name="id" value="<?= $id; ?>">
        
        <!-- Champ de texte pour permettre à l'utilisateur de saisir ou modifier le commentaire -->
        <div class="form-group">
            <label for="commentaire">Commentaires :</label>
            <textarea id="commentaire" name="commentaire" rows="10" cols="50"><?= htmlspecialchars($commentaire ?? ''); ?></textarea>
             <!-- Bouton pour soumettre le formulaire et enregistrer les changements -->
            <button type="submit">Valider</button>
        </div>


    </form>
</body>
</html>
