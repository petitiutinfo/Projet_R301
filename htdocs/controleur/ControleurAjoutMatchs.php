<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $date = $_POST['date'] ?? null;
    $heure = $_POST['heure'] ?? null;
    $equipe_adverse = $_POST['equipe_adverse'] ?? null;
    $lieu = $_POST['Lieu'] ?? null;
    $domicile = isset($_POST['Domicile']) ? (int)$_POST['Domicile'] : null;

    // Vérifier si toutes les données obligatoires sont renseignées
    if ($date && $heure && $equipe_adverse && $lieu && $domicile !== null) {
        try {
            // Préparer la requête d'insertion
            $stmt = $pdo->prepare("INSERT INTO Matchs (Date_Match, Heure_Match, Equipe_Adverse, Lieu_Match, Domicile) 
                                   VALUES (:date_match, :heure, :equipe_adverse, :lieu, :domicile)");
            
            // Exécuter la requête avec les données du formulaire
            $stmt->execute([
                ':date_match' => $date,
                ':heure' => $heure,
                ':equipe_adverse' => $equipe_adverse,
                ':lieu' => $lieu,
                ':domicile' => $domicile
            ]);

            // Rediriger vers une page de confirmation ou de liste des matchs
            header('Location: ../vue/IHMMatchs.php');
            exit;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Afficher un message d'erreur si des champs sont manquants
        echo "Tous les champs sont obligatoires.";
    }
}