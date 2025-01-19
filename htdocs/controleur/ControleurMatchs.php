<?php 
// Inclure le fichier de connexion à la base de données
include('db_connexion.php');

/**
 * Récupère les informations d'un match à partir de son ID.
 *
 * @param PDO $pdo La connexion à la base de données
 * @param int $id L'ID du match à récupérer
 * @return array|null Les informations du match sous forme de tableau associatif ou null si aucun match trouvé
 */
function getMatchById(PDO $pdo, int $id): ?array {
    // Préparer une requête pour sélectionner le match avec l'ID spécifié
    $stmt = $pdo->prepare("SELECT * FROM Matchs WHERE IdMatch = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Associer l'ID au paramètre de la requête
    $stmt->execute(); // Exécuter la requête
    // Retourner les informations du match ou null si aucune ligne n'est trouvée
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Récupère tous les matchs présents dans la base de données.
 *
 * @param PDO $pdo La connexion à la base de données
 * @return array Un tableau contenant les informations des matchs
 */
function recupererMatchs($pdo) {
    try {
        // Préparer une requête pour récupérer tous les matchs
        $stmt = $pdo->prepare("SELECT * FROM Matchs");
        $stmt->execute(); // Exécuter la requête
        $matchs = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes sous forme de tableau associatif

        // Parcourir chaque match pour remplacer les valeurs NULL par des chaînes vides
        foreach ($matchs as $index => $match) {
            foreach ($match as $key => $value) {
                if (is_null($value)) { // Vérifier si une valeur est NULL
                    $matchs[$index][$key] = ""; // Remplacer la valeur NULL par une chaîne vide
                }
            }
        }
        return $matchs; // Retourner les données des matchs
    } catch (PDOException $e) {
        // En cas d'erreur, afficher un message et interrompre l'exécution
        die("Erreur lors de la récupération des matchs : " . $e->getMessage());
    }
}

// Appeler la fonction pour récupérer la liste des matchs
$matchs = recupererMatchs($pdo);
?>