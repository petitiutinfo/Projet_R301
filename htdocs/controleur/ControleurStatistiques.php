<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

/**
 * Récupère les statistiques générales des matchs.
 * 
 * @param PDO $pdo La connexion à la base de données.
 * @return array Les statistiques des matchs.
 */
function recupererStatistiquesGenerales($pdo) {
    // Préparer la requête SQL pour récupérer les statistiques globales des matchs
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS total_matchs,
            SUM(CASE WHEN Resultat > 0 THEN 1 ELSE 0 END) AS total_gagnes,
            SUM(CASE WHEN Resultat < 0 THEN 1 ELSE 0 END) AS total_perdus,
            SUM(CASE WHEN Resultat = 0 THEN 1 ELSE 0 END) AS total_nuls
        FROM Matchs
        WHERE Resultat IS NOT NULL AND Resultat != ''
    ");
    // Exécuter la requête
    $stmt->execute();
    // Retourner les résultats sous forme de tableau associatif
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les statistiques par joueur.
 * 
 * @param PDO $pdo La connexion à la base de données.
 * @return array Les statistiques par joueur.
 */
function recupererStatistiquesJoueurs($pdo) {
    // Préparer la requête SQL pour récupérer les statistiques par joueur
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
        WHERE Resultat IS NOT NULL AND Resultat != ''
        GROUP BY j.idJoueur
    ");
    // Exécuter la requête
    $stmt->execute();
    // Retourner les résultats sous forme de tableau associatif
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les participations pour calculer les sélections consécutives.
 * 
 * @param PDO $pdo La connexion à la base de données.
 * @return array Les participations.
 */
function recupererParticipations($pdo) {
    // Préparer la requête SQL pour récupérer les participations des joueurs aux matchs
    $stmt = $pdo->prepare("
        SELECT p.IdJoueur, m.Date_Match
        FROM Participer p
        JOIN Matchs m ON p.IdMatch = m.IdMatch
        ORDER BY p.IdJoueur, m.Date_Match ASC
    ");
    // Exécuter la requête
    $stmt->execute();
    // Retourner les résultats sous forme de tableau associatif
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Calcule les sélections consécutives des joueurs.
 * 
 * @param array $participations Les participations récupérées.
 * @return array Les sélections consécutives par joueur.
 */
function calculerSelectionsConsecutives($participations) {
    // Initialiser un tableau pour stocker les sélections consécutives
    $selections_consecutives = [];
    $longueur_max = 1;  // Longueur maximale des sélections consécutives
    $joueur_actuel = null;  // Variable pour suivre le joueur actuel

    // Parcourir les participations pour calculer les sélections consécutives
    foreach ($participations as $index => $participation) {
        $id_joueur = $participation['IdJoueur'];  // ID du joueur de la participation actuelle

        // Si l'ID du joueur change (nouveau joueur), mettre à jour les sélections consécutives
        if ($id_joueur != $joueur_actuel) {
            if ($joueur_actuel != null) {
                // Sauvegarder la longueur maximale des sélections consécutives pour le joueur précédent
                $selections_consecutives[$joueur_actuel] = max($longueur_max, $selections_consecutives[$joueur_actuel] ?? 0);
            }
            $joueur_actuel = $id_joueur;  // Changer de joueur
            $longueur_max = 1;  // Réinitialiser la longueur maximale pour le nouveau joueur
        } else {
            // Si le même joueur apparaît à l'index suivant, augmenter la longueur des sélections consécutives
            if (isset($participations[$index + 1]) && $participations[$index + 1]['IdJoueur'] == $id_joueur) {
                $longueur_max++;  // Augmenter la longueur
            } else {
                // Sauvegarder la longueur des sélections consécutives pour le joueur
                $selections_consecutives[$id_joueur] = max($longueur_max, $selections_consecutives[$id_joueur] ?? 0);
                $longueur_max = 1;  // Réinitialiser la longueur pour la prochaine séquence
            }
        }
    }

    // Sauvegarder la dernière séquence pour le joueur actuel
    if ($joueur_actuel != null) {
        $selections_consecutives[$joueur_actuel] = max($longueur_max, $selections_consecutives[$joueur_actuel] ?? 0);
    }

    // Retourner les sélections consécutives par joueur
    return $selections_consecutives;
}
?>