<?php
// Inclure le contrôleur pour récupérer les joueurs
include('../controleur/db_connexion.php');
include('../controleur/ControleurRecupererJoueur.php');

// Vérifier si l'ID du joueur est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $joueur = recupererJoueurParId($pdo,$id);
    if (!$joueur) {
        echo "Aucun joueur trouvé avec cet ID.";
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
    <meta name="description" content="Page modification joueurs">
    <meta name="author" content="Enzo">
    <title>Modifier Joueur</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <?php include('Menu.php'); ?>

    <h1 id="titrePageAccueil">Page de modification de joueur</h1>

    <!-- Formulaire prérempli avec les données existantes -->
    <form id="formulaireModifierJoueur" action="../controleur/ControleurModifierJoueur.php" method="POST">
        <!-- Champ caché pour envoyer l'ID du joueur -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($joueur['IdJoueur']); ?>">

        <div class="form-group">
            <label for="numero_license">Numéro de License :</label>
            <input type="number" id="numero_license" name="numero_license" value="<?php echo htmlspecialchars($joueur['Numéro_de_license']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" maxlength="50" value="<?php echo htmlspecialchars($joueur['Nom']); ?>" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" maxlength="50" value="<?php echo htmlspecialchars($joueur['Prénom']); ?>" required>
        </div>
        <div class="form-group">
            <label for="date_naissance">Date de Naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($joueur['Date_de_naissance']); ?>" required>
        </div>
        <div class="form-group">
            <label for="taille">Taille (en cm) :</label>
            <input type="number" id="taille" name="taille" min="50" max="250" value="<?php echo htmlspecialchars($joueur['Taille']); ?>" required>
        </div>
        <div class="form-group">
            <label for="poids">Poids (en kg) :</label>
            <input type="number" id="poids" name="poids" step="0.1" value="<?php echo htmlspecialchars($joueur['Poids']); ?>" required>
        </div>
        <div class="form-group">
            <label for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <option value="actif" <?= ($joueur['Statut'] == 0) ? 'selected' : ''; ?>>Actif</option>
                <option value="blessé" <?= ($joueur['Statut'] == 1) ? 'selected' : ''; ?>>Blessé</option>
                <option value="suspendu" <?= ($joueur['Statut'] == 2) ? 'selected' : ''; ?>>Suspendu</option>
                <option value="absent" <?= ($joueur['Statut'] == 3) ? 'selected' : ''; ?>>Absent</option>
            </select>
        </div>
        <button id="bontonModificationJoueur" type="submit">Confirmer les modifications</button>
    </form>
</body>
</html>