<?php
// Inclure le fichier de connexion à la base de données
include('db_connexion.php');

// Définition d'une fonction pour vérifier les identifiants d'un utilisateur
function verifierIdentifiants($pdo, $username, $password) {
    try {
        // Préparer une requête pour récupérer le mot de passe haché de l'utilisateur dans la base de données
        $stmt = $pdo->prepare("SELECT password_hashed FROM Utilisateur WHERE Id = :username");
        // Lier le paramètre ':username' à la valeur du nom d'utilisateur fourni
        $stmt->bindParam(':username', $username);
        // Exécuter la requête
        $stmt->execute();
        // Récupérer le résultat de la requête sous forme de tableau associatif
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si un utilisateur correspondant a été trouvé et si le mot de passe est correct
        if (password_verify($password, $result['password_hashed'])) {
            return true; // Authentification réussie
        } else {
            return false; // Échec de l'authentification
        }
    } catch (PDOException $e) {
        // En cas d'erreur avec la base de données, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
        return false; // Retourner 'false' en cas d'exception
    }
}