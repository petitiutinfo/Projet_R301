<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = intval($_POST['id']);
    $numero_license = $_POST['numero_license'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $statut = $_POST['statut'];

    try {
        // Préparer et exécuter la requête de mise à jour
        $stmt = $pdo->prepare("UPDATE Joueur 
                               SET Numéro_de_license = :numero_license,
                                   Nom = :nom,
                                   Prénom = :prenom,
                                   Date_de_naissance = :date_naissance,
                                   Taille = :taille,
                                   Poids = :poids,
                                   Statut = :statut
                               WHERE IdJoueur = :id");
        $stmt->execute([
            ':numero_license' => $numero_license,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':date_naissance' => $date_naissance,
            ':taille' => $taille,
            ':poids' => $poids,
            ':statut' => $statut,
            ':id' => $id
        ]);

        echo "Les informations du joueur ont été mises à jour avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour des informations : " . $e->getMessage();
    }
}
?>