<?php
// Inclure le fichier de connexion à la base de données
// Ce fichier contient les informations nécessaires pour se connecter à la base de données via PDO
include('db_connexion.php');

// Vérifier si la méthode de requête HTTP est POST (c'est-à-dire que le formulaire a été soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par le formulaire via la méthode POST
    $numero_license = $_POST['numero_license'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $statut = $_POST['statut'];

    // Vérifier que toutes les données nécessaires sont présentes
    // Si une des valeurs est vide (ou null), la condition échoue
    if ($numero_license && $nom && $prenom && $date_naissance && $taille && $poids && $statut !== null)
        try {
            // Préparer une requête SQL pour insérer un nouveau joueur dans la table 'Joueur'
            $stmt = $pdo->prepare("INSERT INTO Joueur (Numéro_de_license, Nom, Prénom, Date_de_naissance, Taille, Poids, Statut) 
                                    VALUES (:numero_license, :nom, :prenom, :date_naissance, :taille, :poids, :statut)");

            // Exécuter la requête avec les données fournies dans un tableau associatif
            $stmt->execute([
                ':numero_license' => $numero_license,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':date_naissance' => $date_naissance,
                ':taille' => $taille,
                ':poids' => $poids,
                ':statut' => $statut
            ]);

            // Si l'insertion réussit, rediriger vers la page des joueurs
            header('Location: ../vue/IHMJoueurs.php');
            // Terminer le script immédiatement après la redirection
            exit;
        } catch (PDOException $e) {
            // En cas d'erreur PDO (par exemple problème avec la requête SQL ou la connexion à la base), afficher un message d'erreur
            echo "Erreur lors de l'ajout du joueur : " . $e->getMessage();
        }
}
?>