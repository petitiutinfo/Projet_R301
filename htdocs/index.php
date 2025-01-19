<?php
// Démarrer la session pour pouvoir utiliser $_SESSION
session_start();

// Inclure les fichiers nécessaires pour le contrôleur d'authentification
include('controleur/ControleurConnexion.php');  // Contrôleur pour la gestion de l'authentification

// Vérifier si la méthode de la requête est POST (formulaire soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et nettoyer les données envoyées par le formulaire
    $username = trim($_POST['username']);  // Supprimer les espaces inutiles avant et après le nom d'utilisateur
    $password = trim($_POST['password']);  // Supprimer les espaces inutiles avant et après le mot de passe

    // Vérifier les identifiants via la fonction définie dans le contrôleur
    if (verifierIdentifiants($pdo, $username, $password)) {
        // Si l'authentification est réussie, créer une variable de session pour marquer l'utilisateur comme authentifié
        $_SESSION['authenticated'] = true;

        // Rediriger l'utilisateur vers la page principale des joueurs
        header("Location: /vue/IHMJoueurs.php");
        exit;  // Arrêter l'exécution du script après la redirection
    } else {
        // Si les identifiants sont incorrects, afficher un message d'erreur
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">  <!-- Spécifier l'encodage des caractères pour la page -->
    <title>Authentification</title>  <!-- Titre de la page -->
</head>
<body>
    <h1>Connexion</h1>  <!-- Titre principal de la page -->

    <!-- Si une erreur d'authentification existe, l'afficher -->
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>  <!-- Affichage du message d'erreur en rouge -->
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form method="POST" action="">
        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>  <!-- Champ pour le nom d'utilisateur -->
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>  <!-- Champ pour le mot de passe -->
        </div>
        <button type="submit">Se connecter</button>  <!-- Bouton de soumission du formulaire -->
    </form>
</body>
</html>
