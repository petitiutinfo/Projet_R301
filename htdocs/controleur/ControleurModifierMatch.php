<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Vérifier si la méthode de la requête est POST (formulaire soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par le formulaire et les sécuriser
    $id = intval($_POST['id']); // Convertir l'ID en entier
    $date = $_POST['date']; // Récupérer la date du match
    $heure = $_POST['heure']; // Récupérer l'heure du match
    $equipe_adverse = $_POST['equipe_adverse']; // Récupérer le nom de l'équipe adverse
    $lieu = $_POST['Lieu']; // Récupérer le lieu du match
    $domicile = $_POST['Domicile']; // Récupérer l'information sur le domicile (true/false)
    $resultat = $_POST['resultat']; // Récupérer le résultat du match (non utilisé ici)

     // Récupérer la date actuelle sous forme d'objet DateTime pour une comparaison facile
     $dateActuelle = new DateTime();

     // Convertir la date du match en objet DateTime pour faciliter la comparaison
     $dateMatch = new DateTime($date);

    // Vérifier si la date du match est dans le futur
    if ($dateMatch < $dateActuelle) {
        // Si la date du match est dans le futur, afficher un message d'erreur et rediriger
        echo "<script>
                alert('Erreur : La date du match ne peut pas être dans le passé.');
                window.location.href = '../vue/IHMModifierMatch.php?id=$id';
              </script>";
        exit; // Arrêter l'exécution du script
    }

    try {
        // Préparer la requête SQL pour mettre à jour les informations du match
        $stmt = $pdo->prepare("UPDATE Matchs 
                               SET Date_Match = :date,
                                   Heure_Match = :heure,
                                   Equipe_Adverse = :equipe_adverse,
                                   Lieu_Match = :lieu,
                                   Domicile = :domicile
                               WHERE IdMatch = :id");

        // Exécuter la requête avec les données du formulaire
        $stmt->execute([
            ':date' => $date,
            ':heure' => $heure,
            ':equipe_adverse' => $equipe_adverse,
            ':lieu' => $lieu,
            ':domicile' => $domicile,
            ':id' => $id
        ]);

        // Rediriger vers la page des matchs après mise à jour réussie
        header("Location: ../vue/IHMMatchs.php");
        exit(); // Assurer l'arrêt de l'exécution après la redirection
    } catch (PDOException $e) {
        // Capturer les erreurs de la base de données et afficher un message d'erreur
        echo "Erreur lors de la mise à jour des informations : " . $e->getMessage();
    }
}
?>
