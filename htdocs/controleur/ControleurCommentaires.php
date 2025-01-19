<?php
// Inclure le fichier de connexion à la base de données
// Ce fichier contient les paramètres nécessaires pour établir une connexion avec la base via PDO
include('db_connexion.php');

// Récupérer les données envoyées depuis le formulaire
// 'id' est récupéré et converti en entier (0 par défaut s'il n'est pas défini)
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
// 'commentaire' est récupéré et les espaces superflus sont supprimés
$commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : '';

// Échapper les caractères spéciaux dans le commentaire pour éviter l'injection de code HTML ou JavaScript
$commentaire = htmlspecialchars($commentaire, ENT_QUOTES, 'UTF-8');

// Vérifier que l'ID est valide (supérieur à 0) avant de continuer
if ($id > 0) {
    try {
        // Vérifier si un commentaire existe déjà pour ce joueur (dans la table 'Commentaire')
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Commentaire WHERE IdJoueur = ?");
        $stmt->execute([$id]);
        $existe = $stmt->fetchColumn() > 0; // Retourne true si un commentaire existe déjà

        if (empty($commentaire)) {
            // Si le commentaire est vide mais qu'il existe déjà, supprimer l'entrée correspondante
            if ($existe) {
                $stmt = $pdo->prepare("DELETE FROM Commentaire WHERE IdJoueur = ?");
                $stmt->execute([$id]);
            }
        } else {
            if ($existe) {
                // Si un commentaire existe déjà, le mettre à jour avec le nouveau contenu
                $stmt = $pdo->prepare("UPDATE Commentaire SET commentaire = ? WHERE IdJoueur = ?");
                $stmt->execute([$commentaire, $id]);
            } else {
                // Si aucun commentaire n'existe, insérer une nouvelle entrée dans la table
                $stmt = $pdo->prepare("INSERT INTO Commentaire (IdJoueur, commentaire) VALUES (?, ?)");
                $stmt->execute([$id, $commentaire]);
            }
        }
    } catch (PDOException $e) {
        // En cas d'erreur lors de l'exécution des requêtes SQL, afficher un message d'erreur
        echo "Erreur de base de données : " . $e->getMessage();
        exit; // Arrêter le script en cas d'erreur
    }
}

// Après avoir effectué les opérations, rediriger l'utilisateur vers la page des joueurs
header("Location: ../vue/IHMJoueurs.php");
exit; // Terminer le script après la redirection pour éviter toute exécution supplémentaire
?>