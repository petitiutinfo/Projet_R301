<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

$id_match = intval($_POST['id_match']);
$joueurs = $_POST['joueurs'];

try {
    // Début de la transaction
    $pdo->beginTransaction();

    // Ajouter ou mettre à jour les participations des joueurs dans la base de données
    $stmt = $pdo->prepare("
        INSERT INTO Participer (IdJoueur, IdMatch, Poste, Titulaire_ou_remplaçant) 
        VALUES (:id_joueur, :id_match, :poste, :role)
        ON DUPLICATE KEY UPDATE Poste = :poste, Titulaire_ou_remplaçant = :role
    ");

    foreach ($joueurs as $id_joueur) {
        $poste = $_POST['poste_' . $id_joueur];
        $role = $_POST['role_' . $id_joueur];

        $stmt->execute([
            ':id_match' => $id_match,
            ':id_joueur' => $id_joueur,
            ':poste' => $poste,
            ':role' => $role,
        ]);
    }

    // Validation de la transaction
    $pdo->commit();
    echo "Feuille de match mise à jour avec succès.";
} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    $pdo->rollBack();
    echo "Erreur lors de la mise à jour des participations : " . $e->getMessage();
}