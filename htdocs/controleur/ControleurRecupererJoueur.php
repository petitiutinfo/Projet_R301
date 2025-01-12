<?php
include('db_connexion.php');

/**
 * Fonction pour récupérer un joueur par son ID.
 *
 * @param PDO $pdo La connexion PDO.
 * @param int $id L'ID du joueur à rechercher.
 * @return array|false Les informations du joueur, ou `false` si non trouvé.
 */

function recupererJoueurParId($pdo, $id) {
    try {
        $sql = "SELECT * FROM Joueur WHERE idJoueur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération du joueur : " . $e->getMessage();
    }
}
?>