<?php
// Inclure la connexion à la base de données
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
        // Définir la requête SQL pour récupérer un match en fonction de son ID
        $sql = "SELECT * FROM Matchs WHERE IdMatch = :id";
        
        // Préparer la requête pour éviter les injections SQL
        $stmt = $pdo->prepare($sql);
        
        // Lier le paramètre ':id' à l'ID du match
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Exécuter la requête
        $stmt->execute();
        
        // Retourner les informations du match sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Si une exception se produit (par exemple une erreur SQL), relancer l'exception avec un message d'erreur
        throw new Exception("Erreur lors de la récupération des informations : " . $e->getMessage());
    }
}
?>