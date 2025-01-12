<?php
include('db_connexion.php');

/**
 * Fonction pour récupérer les informations d'un match par son ID.
 *
 * @param PDO $pdo La connexion PDO.
 * @param int $id L'ID du match à récupérer.
 * @return array|false Les informations du match, ou `false` si non trouvé.
 */
function recupererMatchParId($pdo, $id) {
    try {
        $sql = "SELECT * FROM Matchs WHERE IdMatch = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Retourne une exception si la requête échoue
        throw new Exception("Erreur lors de la récupération des informations : " . $e->getMessage());
    }
}
?>