<?php
// Inclure le fichier de connexion à la base de données
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
        // Requête SQL pour récupérer les informations d'un joueur par son ID
        $sql = "SELECT * FROM Joueur WHERE idJoueur = :id";
        
        // Préparer la requête pour l'exécution
        $stmt = $pdo->prepare($sql);
        
        // Lier le paramètre ID à la requête SQL
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Exécuter la requête
        $stmt->execute();
        
        // Récupérer les résultats sous forme de tableau associatif et les retourner
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gérer les erreurs éventuelles et afficher un message d'erreur
        echo "Erreur lors de la récupération du joueur : " . $e->getMessage();
    }
}
?>