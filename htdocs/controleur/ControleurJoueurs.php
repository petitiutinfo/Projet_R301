<?php 
// Inclure le fichier de connexion à la base de données
include('db_connexion.php');

/**
 * Récupère les informations d'un joueur à partir de son ID.
 *
 * @param PDO $pdo La connexion à la base de données
 * @param int $id L'ID du joueur à récupérer
 * @return array|null Les informations du joueur sous forme de tableau associatif ou null si aucun joueur trouvé
 */
function getJoueurById(PDO $pdo, int $id): ?array {
    // Préparer une requête pour sélectionner le joueur avec l'ID spécifié
    $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE IdJoueur = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Associer l'ID au paramètre de la requête
    $stmt->execute(); // Exécuter la requête
    // Retourner les informations du joueur ou null si aucune ligne n'est trouvée
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Récupère le commentaire d'un joueur à partir de son ID.
 *
 * @param PDO $pdo La connexion à la base de données
 * @param int $id L'ID du joueur pour lequel récupérer le commentaire
 * @return string|null Le commentaire du joueur ou null si aucun commentaire trouvé
 */
function getCommentaireByJoueurId(PDO $pdo, int $id): ?string {
    // Préparer une requête pour sélectionner le commentaire associé à l'ID du joueur
    $stmt = $pdo->prepare("SELECT Commentaire FROM Commentaire WHERE IdJoueur = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Associer l'ID au paramètre de la requête
    $stmt->execute(); // Exécuter la requête
    // Retourner le commentaire ou null si aucune donnée n'est trouvée
    return $stmt->fetchColumn() ?: null;
}

/**
 * Récupère la liste complète des joueurs, y compris leurs participations et leurs commentaires.
 *
 * @param PDO $pdo La connexion à la base de données
 * @return array Un tableau contenant les informations des joueurs
 */
function recupererJoueurs($pdo) {
    try {
        // Préparer une requête pour récupérer les informations des joueurs
        $stmt = $pdo->prepare("
            SELECT 
                j.IdJoueur, 
                j.Numéro_de_license, 
                j.Nom, 
                j.Prénom, 
                j.Date_de_naissance, 
                j.Taille, 
                j.Poids, 
                j.Statut,
                CASE 
                    WHEN p.IdJoueur IS NULL THEN 'Non' 
                    ELSE 'Oui' 
                END AS A_Participé, 
                c.Commentaire
            FROM Joueur j
            LEFT JOIN Participer p ON j.IdJoueur = p.IdJoueur
            LEFT JOIN Commentaire c ON j.IdJoueur = c.IdJoueur
            GROUP BY 
                j.IdJoueur, 
                j.Numéro_de_license, 
                j.Nom, 
                j.Prénom, 
                j.Date_de_naissance, 
                j.Taille, 
                j.Poids, 
                j.Statut, 
                p.IdJoueur, 
                c.Commentaire;
        ");
        $stmt->execute(); // Exécuter la requête
        // Récupérer toutes les lignes résultantes sous forme de tableau associatif
        $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $joueurs; // Retourner les données récupérées
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message et interrompre l'exécution
        die("Erreur lors de la récupération des joueurs : " . $e->getMessage());
    }
}

// Appeler la fonction pour récupérer la liste des joueurs
$joueurs = recupererJoueurs($pdo);

// Tableau de mappage pour convertir les codes de statut en descriptions lisibles
$statut_mapping = [
    0 => 'Actif',
    1 => 'Blessé',
    2 => 'Suspendu',
    3 => 'Absent'
];
?>