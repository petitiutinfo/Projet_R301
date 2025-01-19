<?php
// Inclure le fichier de connexion à la base de données
include('db_connexion.php');

// Vérifier si les données nécessaires sont présentes dans le formulaire
if (isset($_POST['id'], $_POST['resultat']) && !empty($_POST['id'])) {
    // Récupérer et sécuriser les données envoyées via le formulaire
    $id = intval($_POST['id']); // Convertir l'ID en entier
    $resultat = intval($_POST['resultat']); // Convertir le résultat en entier

    try {
        // Préparer la requête SQL pour mettre à jour le résultat d'un match spécifique
        $sql = "UPDATE Matchs SET Resultat = :resultat WHERE IdMatch = :id";
        $stmt = $pdo->prepare($sql); // Préparer la requête pour l'exécution

        // Lier les paramètres pour éviter les injections SQL
        $stmt->bindParam(':resultat', $resultat, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Exécuter la requête SQL
        if ($stmt->execute()) {
            // Si l'exécution réussit, rediriger vers la page des matchs avec un message de succès
            header("Location: ../vue/IHMMatchs.php?message=Le résultat a été mis à jour avec succès.");
            exit;
        } else {
            // Si l'exécution échoue, afficher un message d'erreur
            echo "Erreur lors de la mise à jour du résultat.";
        }
    } catch (PDOException $e) {
        // Capturer les exceptions en cas d'erreur avec la base de données et afficher un message
        echo "Erreur lors de la mise à jour des informations : " . $e->getMessage();
    }
} else {
    // Si les données nécessaires sont manquantes, afficher un message d'erreur
    echo "Données invalides ou manquantes.";
    exit;
}
?>