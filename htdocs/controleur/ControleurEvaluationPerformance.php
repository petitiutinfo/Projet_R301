<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

$id_match = intval($_POST['id_match']);

try {
    // Début de la transaction
    $pdo->beginTransaction();

    // Préparer la requête pour mettre à jour la performance
    $stmt = $pdo->prepare("
        UPDATE Participer 
        SET Note = :note
        WHERE IdMatch = :id_match AND IdJoueur = :id_joueur
    ");

    // Mettre à jour chaque joueur
    foreach ($_POST as $key => $value) {
        // Vérifier si la clé commence par "note"
        if (strpos($key, 'note_') === 0) {
            $id_joueur = intval(str_replace('note_', '', $key));
            $performance = intval($value);

            // Exécuter la mise à jour
            $stmt->execute([
                ':id_match' => $id_match,
                ':id_joueur' => $id_joueur,
                ':note' => $performance,
            ]);
        }
    }

    // Validation de la transaction
    $pdo->commit();
    echo "Performances enregistrées avec succès.";
} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    $pdo->rollBack();
    echo "Erreur lors de la mise à jour des performances : " . $e->getMessage();
}
?>