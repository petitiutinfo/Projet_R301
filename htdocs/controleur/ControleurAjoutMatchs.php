<?php
// Inclure le fichier de connexion à la base de données
// Ce fichier contient les paramètres nécessaires pour se connecter à la base de données via PDO
include('db_connexion.php');

// Vérifier si le formulaire a été soumis via la méthode POST
// Cela indique qu'une requête a été envoyée pour insérer un match
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    // Utiliser l'opérateur de coalescence (??) pour fournir une valeur par défaut (null) si une donnée est absente
    $date = $_POST['date'] ?? null; // Date du match
    $heure = $_POST['heure'] ?? null; // Heure du match
    $equipe_adverse = $_POST['equipe_adverse'] ?? null; // Nom de l'équipe adverse
    $lieu = $_POST['Lieu'] ?? null; // Lieu du match
    $domicile = isset($_POST['Domicile']) ? (int)$_POST['Domicile'] : null; // Indique si le match est à domicile (1) ou à l'extérieur (0)

    // Vérifier si toutes les données obligatoires sont présentes
    // La condition vérifie que toutes les variables sont renseignées (non nulles)
    if ($date && $heure && $equipe_adverse && $lieu && $domicile !== null) {
        
        // Récupérer la date actuelle sous forme d'objet DateTime pour une comparaison facile
        $dateActuelle = new DateTime();

        // Convertir la date du match en objet DateTime pour faciliter la comparaison
        $dateMatch = new DateTime($date);

        // Vérifier si la date du match est dans le futur
        if ($dateMatch < $dateActuelle) {
            // Si la date du match est dans le futur, afficher un message d'erreur et rediriger
            echo "<script>
                    alert('Erreur : La date du match ne peut pas être dans le passé.');
                    window.location.href = '../vue/IHMMatchs.php?';
                </script>";
            exit; // Arrêter l'exécution du script
        }

        try {
            // Préparer une requête SQL pour insérer un nouveau match dans la table 'Matchs'
            $stmt = $pdo->prepare("INSERT INTO Matchs (Date_Match, Heure_Match, Equipe_Adverse, Lieu_Match, Domicile) 
                                   VALUES (:date_match, :heure, :equipe_adverse, :lieu, :domicile)");
            
            // Exécuter la requête en fournissant les valeurs sous forme de tableau associatif
            $stmt->execute([
                ':date_match' => $date, // Date du match
                ':heure' => $heure, // Heure du match
                ':equipe_adverse' => $equipe_adverse, // Nom de l'équipe adverse
                ':lieu' => $lieu, // Lieu du match
                ':domicile' => $domicile // Statut domicile/extérieur
            ]);

            // Si l'insertion est réussie, rediriger l'utilisateur vers une autre page
            // Ici, on suppose qu'il s'agit d'une interface listant les matchs
            header('Location: ../vue/IHMMatchs.php');
            exit; // Terminer le script après la redirection pour éviter l'exécution d'autres instructions
        } catch (PDOException $e) {
            // En cas d'erreur liée à la base de données, afficher un message d'erreur
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Si des champs obligatoires sont manquants, afficher un message d'erreur
        echo "Tous les champs sont obligatoires.";
    }
}
?>