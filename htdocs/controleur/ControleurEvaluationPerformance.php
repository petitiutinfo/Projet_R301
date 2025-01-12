<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

/**
 * Récupère les participations pour un match spécifique.
 *
 * @param PDO $pdo
 * @param int $id_match
 * @return array
 */
function getParticipationsByMatch(PDO $pdo, int $id_match): array {
    $stmt = $pdo->prepare("
        SELECT 
            p.IdJoueur, p.Poste, p.Titulaire_ou_remplaçant, p.Note,
            j.Nom, j.Prénom, j.Taille, j.Poids, c.Commentaire
        FROM Participer p
        INNER JOIN Joueur j ON p.IdJoueur = j.IdJoueur
        LEFT JOIN Commentaire c ON c.IdJoueur = j.IdJoueur
        WHERE p.IdMatch = :id_match
    ");
    $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Vérifier si un formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_match'])) {
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
            // Vérifier si la clé commence par "note_"
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
        header("Location: ../vue/IHMMatchs.php");
        exit;

    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Erreur lors de la mise à jour des performances : " . $e->getMessage();
    }
}

// Exemple d'utilisation pour récupérer les participations
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_match'])) {
    $id_match = intval($_GET['id_match']);
    try {
        $joueurs = getParticipationsByMatch($pdo, $id_match);

        // Pour affichage ou autres traitements, vous pouvez utiliser la variable $joueurs
    } catch (Exception $e) {
        echo "Erreur lors de la récupération des participations : " . $e->getMessage();
    }
}
?>