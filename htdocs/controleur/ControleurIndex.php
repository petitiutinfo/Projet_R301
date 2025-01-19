<?php
// Inclure le fichier de connexion à la base de données
include('db_connexion.php');

// Vérifier si le formulaire a été soumis avec une requête POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données saisies par l'utilisateur dans le formulaire
    $numero_license = $_POST['identifiant']; // Récupérer l'identifiant
    $mot_de_passe = $_POST['mot_de_passe'];  // Récupérer le mot de passe

    // Préparer une requête SQL pour vérifier l'existence de l'identifiant dans la table 'Utilisateur'
    $query = "SELECT * FROM Utilisateur WHERE identifiant = :identifiant";
    $stmt = $pdo->prepare($query); // Préparer la requête avec des paramètres nommés
    $stmt->bindParam(':identifiant', $identifiant, PDO::PARAM_STR); // Associer la variable $identifiant au paramètre :identifiant

    // Exécuter la requête préparée
    $stmt->execute();

    // Vérifier si un utilisateur avec l'identifiant donné a été trouvé
    if ($stmt->rowCount() > 0) {
        // Récupérer les informations de l'utilisateur trouvé
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comparer le mot de passe saisi avec le mot de passe haché stocké dans la base de données
        if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Si le mot de passe est correct, rediriger l'utilisateur vers la page modèle
            header('Location: ../vue/IHMJoueurs.php');
            exit();
        } else {
            // Si le mot de passe est incorrect, afficher un message d'erreur
            echo "Mot de passe incorrect.";
        }
    } else {
        // Si aucun utilisateur n'a été trouvé avec l'identifiant donné, afficher un message d'erreur
        echo "Identifiant incorrect.";
    }
}
?>
