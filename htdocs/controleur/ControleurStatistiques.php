<?php
include('db_connexion.php');

/**
 * Récupère les statistiques générales des matchs.
 * 
 * @param PDO $pdo La connexion à la base de données.
 * @return array Les statistiques des matchs.
 */
function recupererStatistiquesGenerales($pdo) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS total_matchs,
            SUM(CASE WHEN Resultat > 0 THEN 1 ELSE 0 END) AS total_gagnes,
            SUM(CASE WHEN Resultat < 0 THEN 1 ELSE 0 END) AS total_perdus,
            SUM(CASE WHEN Resultat = 0 THEN 1 ELSE 0 END) AS total_nuls
        FROM Matchs
        WHERE Resultat IS NOT NULL AND Resultat != ''
    ");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les statistiques par joueur.
 * 
 * @param PDO $pdo La connexion à la base de données.
 * @return array Les statistiques par joueur.
 */
function recupererStatistiquesJoueurs($pdo) {
    $stmt = $pdo->prepare("
        SELECT j.IdJoueur, j.Nom, j.Prénom, j.Statut,
        MAX(p.Poste) AS poste_prefere,
        SUM(CASE WHEN p.Titulaire_ou_remplaçant = 'Titulaire' THEN 1 ELSE 0 END) AS total_titulaires,
        SUM(CASE WHEN p.Titulaire_ou_remplaçant = 'Remplaçant' THEN 1 ELSE 0 END) AS total_remplacants,
        AVG(p.Note) AS moyenne_evaluations,
        ROUND(SUM(CASE WHEN m.Resultat > 0 THEN 1 ELSE 0 END) * 100.0 / COUNT(m.idMatch), 2) AS pourcentage_victoires
        FROM Joueur j
        LEFT JOIN Participer p ON j.idJoueur = p.idJoueur
        LEFT JOIN Matchs m ON p.idMatch = m.idMatch
        GROUP BY j.idJoueur
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les participations pour calculer les sélections consécutives.
 * 
 * @param PDO $pdo La connexion à la base de données.
 * @return array Les participations.
 */
function recupererParticipations($pdo) {
    $stmt = $pdo->prepare("
        SELECT p.IdJoueur, m.Date_Match
        FROM Participer p
        JOIN Matchs m ON p.IdMatch = m.IdMatch
        ORDER BY p.IdJoueur, m.Date_Match ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Calcule les sélections consécutives des joueurs.
 * 
 * @param array $participations Les participations récupérées.
 * @return array Les sélections consécutives par joueur.
 */
function calculerSelectionsConsecutives($participations) {
    $selections_consecutives = [];
    $longueur_max = 1;
    $joueur_actuel = null;

    foreach ($participations as $index => $participation) {
        $id_joueur = $participation['IdJoueur'];

        if ($id_joueur != $joueur_actuel) {
            if ($joueur_actuel != null) {
                $selections_consecutives[$joueur_actuel] = max($longueur_max, $selections_consecutives[$joueur_actuel] ?? 0);
            }
            $joueur_actuel = $id_joueur;
            $longueur_max = 1;
        } else {
            if (isset($participations[$index + 1]) && $participations[$index + 1]['IdJoueur'] == $id_joueur) {
                $longueur_max++;
            } else {
                $selections_consecutives[$id_joueur] = max($longueur_max, $selections_consecutives[$id_joueur] ?? 0);
                $longueur_max = 1;
            }
        }
    }

    if ($joueur_actuel != null) {
        $selections_consecutives[$joueur_actuel] = max($longueur_max, $selections_consecutives[$joueur_actuel] ?? 0);
    }

    return $selections_consecutives;
}
?>