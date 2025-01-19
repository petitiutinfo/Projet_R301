<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Vérifier si la méthode de requête est POST et si l'ID du joueur est défini dans le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdJoueur'])) {
    // Récupérer l'ID du joueur depuis le formulaire et le convertir en entier
    $idJoueur = intval($_POST['IdJoueur']);
    
    try {
        // Préparer la requête SQL pour supprimer le joueur avec l'ID spécifié
        $stmt = $pdo->prepare("DELETE FROM Joueur WHERE IdJoueur = :idJoueur");
        // Lier le paramètre :idJoueur à la variable $idJoueur
        $stmt->bindParam(':idJoueur', $idJoueur, PDO::PARAM_INT);
        // Exécuter la requête de suppression
        $stmt->execute();

        // Rediriger l'utilisateur vers la page des joueurs après la suppression
        header('Location: ../vue/IHMJoueurs.php');
        exit;  // S'assurer que le script s'arrête après la redirection
    } catch (Exception $e) {
        // Si une erreur se produit, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
}
?>
