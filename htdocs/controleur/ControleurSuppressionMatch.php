<?php
include('db_connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdMatch'])) {
    $idMatch = intval($_POST['IdMatch']);

    try {
        // Supprimer les participations liées au match
        $stmt = $pdo->prepare("DELETE FROM Participer WHERE IdMatch = :idMatch");
        $stmt->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
        $stmt->execute();

        // Supprimer le match
        $stmt = $pdo->prepare("DELETE FROM Matchs WHERE IdMatch = :idMatch");
        $stmt->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
        $stmt->execute();

        // Redirection avec message
        header('Location: ../vue/IHMMatchs.php');
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du match : " . $e->getMessage();
    }
}
?>