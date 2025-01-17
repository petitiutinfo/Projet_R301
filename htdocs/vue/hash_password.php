<?php
include('../controleur/db_connexion.php');  // Assure-toi que ce fichier contient la connexion à la base de données

try {
    // Récupérer tous les utilisateurs avec leurs mots de passe
    $stmt = $pdo->query("SELECT Id, Mdp FROM Utilisateur");
    $utilisateur = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($utilisateur as $utilisateur) {
        $id = $utilisateur['Id'];
        $password_clair = $utilisateur['Mdp'];

        // Hacher le mot de passe
        $password_hache = password_hash($password_clair, PASSWORD_DEFAULT);

        // Mettre à jour la colonne `password_hashed`
        $stmt_update = $pdo->prepare("UPDATE Utilisateur SET password_hashed = :password_hashed WHERE Id = :id");
        $stmt_update->execute([
            ':password_hashed' => $password_hache,
            ':id' => $id
        ]);
    }

    echo "Mots de passe hachés avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

coucou