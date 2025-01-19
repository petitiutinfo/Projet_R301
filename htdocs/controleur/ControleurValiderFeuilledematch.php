<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Récupérer l'ID du match depuis les données POST et convertir en entier
$id_match = intval($_POST['id_match']);
// Récupérer la liste des joueurs sélectionnés, s'il y en a
$joueurs_selectionnes = isset($_POST['joueurs']) ? $_POST['joueurs'] : [];

// Vérification : vérifier que le nombre de joueurs sélectionnés ne dépasse pas 12
if (count($joueurs_selectionnes) > 12) {
    // Si trop de joueurs sont sélectionnés, afficher une erreur et arrêter l'exécution
    echo "Erreur : Vous ne pouvez pas sélectionner plus de 12 joueurs.";
    exit;
}

try {
    // Début de la transaction pour garantir que toutes les opérations de la base de données se réalisent ou échouent ensemble
    $pdo->beginTransaction();

    // Supprimer les joueurs non sélectionnés du match
    // Préparer la requête pour supprimer les participations des joueurs non sélectionnés
    $placeholders = str_repeat('?,', count($joueurs_selectionnes) - 1) . '?';  // Créer des placeholders pour la requête
    $query = "
        DELETE FROM Participer 
        WHERE IdMatch = ? AND IdJoueur NOT IN ($placeholders)
    ";
    $stmt = $pdo->prepare($query);
    // Exécuter la requête en passant l'ID du match et les IDs des joueurs sélectionnés
    $stmt->execute(array_merge([$id_match], $joueurs_selectionnes));

    // Ajouter ou mettre à jour les participations des joueurs sélectionnés
    // Préparer une requête pour insérer ou mettre à jour les participations des joueurs dans le match
    $stmt = $pdo->prepare("
        INSERT INTO Participer (IdJoueur, IdMatch, Poste, Titulaire_ou_remplaçant) 
        VALUES (:id_joueur, :id_match, :poste, :role)
        ON DUPLICATE KEY UPDATE Poste = :poste, Titulaire_ou_remplaçant = :role
    ");

    // Parcourir les joueurs sélectionnés et exécuter la requête pour chaque joueur
    foreach ($joueurs_selectionnes as $id_joueur) {
        // Exécuter la requête avec les valeurs des joueurs et leurs rôles/postes
        $stmt->execute([
            ':id_joueur' => $id_joueur,
            ':id_match' => $id_match,
            ':poste' => $_POST['poste_' . $id_joueur],  // Récupérer le poste du joueur depuis les données POST
            ':role' => $_POST['role_' . $id_joueur],    // Récupérer le rôle du joueur depuis les données POST
        ]);
    }

    // Valider la transaction si toutes les opérations se sont bien passées
    $pdo->commit();
    // Rediriger l'utilisateur vers la page des matchs
    header('Location: ../vue/IHMMatchs.php');
    exit;

} catch (PDOException $e) {
    // Si une erreur se produit, annuler la transaction
    $pdo->rollBack();
    // Afficher le message d'erreur
    echo "Erreur : " . $e->getMessage();
}
?>