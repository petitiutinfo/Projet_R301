<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Fonction pour récupérer les joueurs actifs pour un match donné
function recupererJoueursActifs($pdo, $id_match) {
    try {
        // Préparer la requête SQL pour récupérer les joueurs actifs associés à un match
        $stmt = $pdo->prepare("
            SELECT j.*, 
                   c.Commentaire, 
                   p.Note AS Evaluations, 
                   IFNULL(p.Poste, '--') AS Poste, 
                   IFNULL(p.Titulaire_ou_remplaçant, '--') AS Titulaire_ou_remplaçant
            FROM Joueur j
            LEFT JOIN Commentaire c ON j.IdJoueur = c.IdJoueur
            LEFT JOIN Participer p ON p.IdJoueur = j.IdJoueur AND p.IdMatch = :id_match
            WHERE j.Statut = '0' 
        ");
        
        // Lier le paramètre :id_match à la valeur du match
        $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
        
        // Exécuter la requête
        $stmt->execute();
        
        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gérer les erreurs éventuelles et les relancer sous forme d'exception
        throw new Exception("Erreur lors de la récupération des joueurs actifs : " . $e->getMessage());
    }
}
?>