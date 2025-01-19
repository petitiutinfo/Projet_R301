<?php
// Inclure le fichier de connexion à la base de données
include('db_connexion.php');

/**
 * Récupère les participations d'un match spécifique.
 *
 * @param PDO $pdo L'objet PDO pour la connexion à la base de données.
 * @param int $id_match L'identifiant du match.
 * @return array Retourne un tableau contenant les informations des joueurs et leurs participations.
 */
function getParticipationsByMatch(PDO $pdo, int $id_match): array {
    // Préparer une requête pour récupérer les participations des joueurs au match donné
    $stmt = $pdo->prepare("
        SELECT 
            p.IdJoueur, p.Poste, p.Titulaire_ou_remplaçant, p.Note,
            j.Nom, j.Prénom, j.Taille, j.Poids, c.Commentaire
        FROM Participer p
        INNER JOIN Joueur j ON p.IdJoueur = j.IdJoueur
        LEFT JOIN Commentaire c ON c.IdJoueur = j.IdJoueur
        WHERE p.IdMatch = :id_match
    ");
    // Lier le paramètre :id_match à la valeur de l'identifiant du match
    $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
    // Exécuter la requête
    $stmt->execute();
    // Retourner tous les résultats sous forme de tableau associatif
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Vérifier si une requête POST a été soumise avec un identifiant de match
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_match'])) {
    // Récupérer et convertir l'identifiant du match en entier
    $id_match = intval($_POST['id_match']);

    try {
        // Démarrer une transaction pour garantir la cohérence des données
        $pdo->beginTransaction();

        // Préparer une requête pour mettre à jour les notes des performances des joueurs
        $stmt = $pdo->prepare("
            UPDATE Participer 
            SET Note = :note
            WHERE IdMatch = :id_match AND IdJoueur = :id_joueur
        ");

        // Parcourir les données du formulaire
        foreach ($_POST as $key => $value) {
            // Vérifier si la clé du champ commence par "note_"
            if (strpos($key, 'note_') === 0) {
                // Extraire l'identifiant du joueur à partir de la clé
                $id_joueur = intval(str_replace('note_', '', $key));
                // Convertir la valeur de la note en entier
                $performance = intval($value);

                // Exécuter la requête pour mettre à jour la note du joueur
                $stmt->execute([
                    ':id_match' => $id_match,
                    ':id_joueur' => $id_joueur,
                    ':note' => $performance,
                ]);
            }
        }

        // Valider la transaction après toutes les mises à jour
        $pdo->commit();
        // Rediriger l'utilisateur vers la page des matchs après la mise à jour
        header("Location: ../vue/IHMMatchs.php");
        exit;

    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        // Afficher un message d'erreur
        echo "Erreur lors de la mise à jour des performances : " . $e->getMessage();
    }
}

// Exemple d'utilisation pour récupérer les participations d'un match
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_match'])) {
    // Récupérer et convertir l'identifiant du match en entier
    $id_match = intval($_GET['id_match']);
    try {
        // Récupérer les participations des joueurs au match
        $joueurs = getParticipationsByMatch($pdo, $id_match);

        // La variable $joueurs peut être utilisée pour l'affichage ou d'autres traitements
    } catch (Exception $e) {
        // Afficher un message d'erreur en cas de problème
        echo "Erreur lors de la récupération des participations : " . $e->getMessage();
    }
}
?>