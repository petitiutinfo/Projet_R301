<?php
include('db_connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdJoueur'])) {
    $idJoueur = intval($_POST['IdJoueur']);
    try{
        // Suppression du joueur
        $stmt = $pdo->prepare("DELETE FROM Joueur WHERE IdJoueur = :idJoueur");
        $stmt->bindParam(':idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->execute();

        // Redirection après suppression
        header('Location: ../vue/IHMJoueurs.php');
        exit;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>