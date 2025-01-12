<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

$id_match = intval($_POST['id_match']);
$joueurs_selectionnes = isset($_POST['joueurs']) ? $_POST['joueurs'] : [];

// Vérification : pas plus de 12 joueurs
if (count($joueurs_selectionnes) > 12) {
    echo "Erreur : Vous ne pouvez pas sélectionner plus de 12 joueurs.";
    exit;
}

try {
    // Début de la transaction
    $pdo->beginTransaction();

    // Supprimer les joueurs non sélectionnés
    $placeholders = str_repeat('?,', count($joueurs_selectionnes) - 1) . '?';
    $query = "
        DELETE FROM Participer 
        WHERE IdMatch = ? AND IdJoueur NOT IN ($placeholders)
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array_merge([$id_match], $joueurs_selectionnes));

    // Ajouter ou mettre à jour les participations
    $stmt = $pdo->prepare("
        INSERT INTO Participer (IdJoueur, IdMatch, Poste, Titulaire_ou_remplaçant) 
        VALUES (:id_joueur, :id_match, :poste, :role)
        ON DUPLICATE KEY UPDATE Poste = :poste, Titulaire_ou_remplaçant = :role
    ");

    foreach ($joueurs_selectionnes as $id_joueur) {
        $stmt->execute([
            ':id_joueur' => $id_joueur,
            ':id_match' => $id_match,
            ':poste' => $_POST['poste_' . $id_joueur],
            ':role' => $_POST['role_' . $id_joueur],
        ]);
    }

    // Valider la transaction
    $pdo->commit();
    header('Location: ../vue/IHMMatchs.php');
    exit;

} catch (PDOException $e) {
    // Annuler la transaction
    $pdo->rollBack();
    echo "Erreur : " . $e->getMessage();
}
?>