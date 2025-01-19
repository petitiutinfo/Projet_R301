<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Vérifier si la méthode de requête est POST et si l'ID du match est défini dans le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdMatch'])) {
    // Récupérer l'ID du match depuis le formulaire et le convertir en entier
    $idMatch = intval($_POST['IdMatch']);

    try {
        // Supprimer les participations liées au match avant de supprimer le match
        $stmt = $pdo->prepare("DELETE FROM Participer WHERE IdMatch = :idMatch");
        // Lier le paramètre :idMatch à la variable $idMatch
        $stmt->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
        // Exécuter la requête de suppression des participations
        $stmt->execute();

        // Supprimer le match de la table Matchs
        $stmt = $pdo->prepare("DELETE FROM Matchs WHERE IdMatch = :idMatch");
        // Lier le paramètre :idMatch à la variable $idMatch
        $stmt->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
        // Exécuter la requête de suppression du match
        $stmt->execute();

        // Rediriger l'utilisateur vers la page des matchs après la suppression
        header('Location: ../vue/IHMMatchs.php');
        exit;  // S'assurer que le script s'arrête après la redirection
    } catch (PDOException $e) {
        // Si une erreur se produit, afficher un message d'erreur
        echo "Erreur lors de la suppression du match : " . $e->getMessage();
    }
}
?>