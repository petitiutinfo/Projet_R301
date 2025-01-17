<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Fonction pour récupérer les joueurs actifs pour un match donné
function recupererJoueursActifs($pdo, $id_match) {
    try {
        $stmt = $pdo->prepare("
            SELECT j.*, 
                   c.Commentaire, 
                   p.Note AS Evaluations, 
                   p.Poste, 
                   p.Titulaire_ou_remplaçant 
            FROM Joueur j
            LEFT JOIN Commentaire c ON j.IdJoueur = c.IdJoueur
            LEFT JOIN Participer p ON p.IdJoueur = j.IdJoueur AND p.IdMatch = :id_match
            WHERE j.Statut = '0'
        ");
        $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération des joueurs actifs : " . $e->getMessage());
    }
}
?>