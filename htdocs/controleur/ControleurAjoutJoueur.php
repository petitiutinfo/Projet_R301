<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_license = $_POST['numero_license'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $statut = $_POST['statut'];

    if ($numero_license && $nom && $prenom && $date_naissance && $taille && $poids && $statut !== null)
    try {
            $stmt = $pdo->prepare("INSERT INTO Joueur (Numéro_de_license, Nom, Prénom, Date_de_naissance, Taille, Poids, Statut) 
                                    VALUES (:numero_license, :nom, :prenom, :date_naissance, :taille, :poids, :statut)");
            $stmt->execute([
                ':numero_license' => $numero_license,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':date_naissance' => $date_naissance,
                ':taille' => $taille,
                ':poids' => $poids,
                ':statut' => $statut
            ]);

            header('Location: ../vue/IHMJoueurs.php');
            exit;
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout du joueur : " . $e->getMessage();
    }
}
?>