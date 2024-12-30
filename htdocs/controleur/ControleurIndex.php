<?php
include('connexionBD.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $numero_license = $_POST['identifiant'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Préparer la requête pour vérifier les identifiants dans la table 'Utilisateur'
    $query = "SELECT * FROM Utilisateur WHERE identifiant = :identifiant";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
    
    // Exécuter la requête
    $stmt->execute();

    // Vérifier si un utilisateur a été trouvé
    if ($stmt->rowCount() > 0) {
        // Récupérer les informations de l'utilisateur
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le mot de passe est correct
        if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Si les informations sont valides, rediriger vers la page modèle
            header('Location: PageModele.php');
            exit();
        } else {
            // Si le mot de passe est incorrect
            echo "Mot de passe incorrect.";
        }
    } else {
        // Si l'identifiant n'existe pas dans la base de données
        echo "Identifiant incorrect.";
    }
}
?>