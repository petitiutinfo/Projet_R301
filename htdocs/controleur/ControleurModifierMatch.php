<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = intval($_POST['id']);
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $equipe_adverse = $_POST['equipe_adverse'];
    $lieu = $_POST['Lieu'];
    $domicile = $_POST['Domicile'];
    $resultat = $_POST['resultat'];

    // Récupérer la date et l'heure actuelles
    $dateActuelle = date("Y-m-d");

    // Vérifier si la date du match est dans le futur
    if ($dateMatch < $dateActuelle) {
        echo "<script>
                alert('Erreur : La date du match ne peut pas être dans le futur.');
                window.location.href = '../vue/IHMModifierMatch.php?id=$id';
              </script>";
        exit;
    }

    try {
        // Requête pour mettre à jour les informations du match
        $stmt = $pdo->prepare("UPDATE Matchs 
                               SET Date_Match = :date,
                                   Heure_Match = :heure,
                                   Equipe_Adverse = :equipe_adverse,
                                   Lieu_Match = :lieu,
                                   Domicile = :domicile
                               WHERE IdMatch = :id");
        $stmt->execute([
            ':date' => $date,
            ':heure' => $heure,
            ':equipe_adverse' => $equipe_adverse,
            ':lieu' => $lieu,
            ':domicile' => $domicile,
            ':id' => $id
        ]);

        header("Location: ../vue/IHMMatchs.php");
        exit(); // Assure-toi que le script s'arrête après la redirection
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour des informations : " . $e->getMessage();
    }
}
?>