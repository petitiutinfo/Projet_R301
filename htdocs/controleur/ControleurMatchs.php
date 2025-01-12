<?php include('db_connexion.php');
/**
 * Récupère les informations d'un match à partir de son ID.
 *
 * @param PDO $pdo
 * @param int $id
 * @return array|null
 */
function getMatchById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM Matchs WHERE IdMatch = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function recupererMatchs($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM Matchs");
        $stmt->execute();
        $matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Remplacer les valeurs NULL par des chaînes vides
        foreach ($matchs as $index => $match) {
            foreach ($match as $key => $value) {
                if (is_null($value)) {
                    $matchs[$index][$key] = "";
                }
            }
        }
        return $matchs;
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des matchs : " . $e->getMessage());
    }
}

$matchs = recupererMatchs($pdo);

?>