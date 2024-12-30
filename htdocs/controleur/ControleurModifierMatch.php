<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = intval($_POST['id']);
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $equipe_adverse = $_POST['equipe_adverse'];
    $lieu = $_POST['Lieu'];
    $domicile = $_POST['Domicile'];
    $resultat = $_POST['resultat'];

    try {
        // Requête pour mettre à jour les informations du match
        $stmt = $pdo->prepare("UPDATE Matchs 
                               SET Date_Match = :date,
                                   Heure_Match = :heure,
                                   Equipe_Adverse = :equipe_adverse,
                                   Lieu_Match = :lieu,
                                   Domicile = :domicile,
                                   Resultat = :resultat
                               WHERE IdMatch = :id");
        $stmt->execute([
            ':date' => $date,
            ':heure' => $heure,
            ':equipe_adverse' => $equipe_adverse,
            ':lieu' => $lieu,
            ':domicile' => $domicile,
            ':resultat' => $resultat,
            ':id' => $id
        ]);

        echo "Les informations du match ont été mises à jour avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour des informations : " . $e->getMessage();
    }
}
?>