<?php include('db_connexion.php');

/**
 * Récupère les informations d'un joueur à partir de son ID.
 *
 * @param PDO $pdo
 * @param int $id
 * @return array|null
 */
function getJoueurById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE IdJoueur = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Récupère le commentaire d'un joueur à partir de son ID.
 *
 * @param PDO $pdo
 * @param int $id
 * @return string|null
 */
function getCommentaireByJoueurId(PDO $pdo, int $id): ?string {
    $stmt = $pdo->prepare("SELECT Commentaire FROM Commentaire WHERE IdJoueur = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() ?: null;
}

function recupererJoueurs($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT j.IdJoueur, j.Numéro_de_license, j.Nom, j.Prénom, j.Date_de_naissance, j.Taille, j.Poids, j.Statut,
                   CASE WHEN p.IdJoueur IS NULL THEN 'Non' ELSE 'Oui' END AS A_Participé, c.Commentaire
            FROM Joueur j
            LEFT JOIN Participer p ON j.IdJoueur = p.IdJoueur
            LEFT JOIN Commentaire c ON j.IdJoueur = c.IdJoueur
            GROUP BY j.IdJoueur, j.Numéro_de_license, j.Nom, j.Prénom, j.Date_de_naissance, j.Taille, j.Poids, j.Statut, p.IdJoueur, c.Commentaire;
        ");
        $stmt->execute();
        $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $joueurs;
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des joueurs : " . $e->getMessage());
    }
}

$joueurs = recupererJoueurs($pdo);

$statut_mapping = [
    0 => 'Actif',
    1 => 'Blessé',
    2 => 'Suspendu',
    3 => 'Absent'
];
?>