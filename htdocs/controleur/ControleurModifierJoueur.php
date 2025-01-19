<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Vérifier si la méthode de la requête est POST (formulaire soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par le formulaire et les sécuriser
    $id = intval($_POST['id']); // Convertir l'ID en entier
    $numero_license = $_POST['numero_license']; // Récupérer le numéro de licence
    $nom = $_POST['nom']; // Récupérer le nom du joueur
    $prenom = $_POST['prenom']; // Récupérer le prénom du joueur
    $date_naissance = $_POST['date_naissance']; // Récupérer la date de naissance
    $taille = $_POST['taille']; // Récupérer la taille du joueur
    $poids = $_POST['poids']; // Récupérer le poids du joueur

    // Associer la valeur du statut texte à son équivalent numérique
    $statut_mapping = [
        'actif' => 0,    // "actif" devient 0
        'blessé' => 1,   // "blessé" devient 1
        'suspendu' => 2, // "suspendu" devient 2
        'absent' => 3    // "absent" devient 3
    ];

    // Récupérer le statut et attribuer une valeur par défaut de 0 (actif) si la valeur n'est pas trouvée
    $statut = $statut_mapping[$_POST['statut']] ?? 0;

    try {
        // Préparer la requête SQL pour mettre à jour les informations du joueur
        $stmt = $pdo->prepare("UPDATE Joueur 
                               SET Numéro_de_license = :numero_license,
                                   Nom = :nom,
                                   Prénom = :prenom,
                                   Date_de_naissance = :date_naissance,
                                   Taille = :taille,
                                   Poids = :poids,
                                   Statut = :statut
                               WHERE IdJoueur = :id");

        // Exécuter la requête avec les données du formulaire
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

        // Rediriger vers la page des joueurs après mise à jour réussie
        header("Location: ../vue/IHMJoueurs.php");
        exit(); // Assurer l'arrêt de l'exécution après la redirection
    } catch (PDOException $e) {
        // Capturer les erreurs de la base de données et afficher un message d'erreur
        echo "Erreur lors de la mise à jour des informations : " . $e->getMessage();
    }
}
?>