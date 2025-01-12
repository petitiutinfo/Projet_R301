<?php
function verifierIdentifiants($pdo, $username, $password) {
    try {
        // Rechercher l'utilisateur dans la base de données
        $stmt = $pdo->prepare("SELECT password_hashed FROM Utilisateur WHERE Id = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if (password_verify($password, $result['password_hashed'])) {
            return true; // Authentification réussie
        } else {
            return false; // Échec de l'authentification
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}