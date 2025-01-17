<?php
// Inclure la connexion à la base de données
include('db_connexion.php');

// Récupérer les données du formulaire
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : '';

// Valider le commentaire (par exemple, éviter les balises HTML)
$commentaire = htmlspecialchars($commentaire, ENT_QUOTES, 'UTF-8');

if ($id > 0) {
    try {
        // Vérifier si un commentaire existe déjà pour ce joueur
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Commentaire WHERE IdJoueur = ?");
        $stmt->execute([$id]);
        $existe = $stmt->fetchColumn() > 0;

        if (empty($commentaire)) {
            // Si le commentaire est vide et existe déjà, le supprimer
            if ($existe) {
                $stmt = $pdo->prepare("DELETE FROM Commentaire WHERE IdJoueur = ?");
                $stmt->execute([$id]);
            }
        } else {
            if ($existe) {
                // Mettre à jour le commentaire existant
                $stmt = $pdo->prepare("UPDATE Commentaire SET commentaire = ? WHERE IdJoueur = ?");
                $stmt->execute([$commentaire, $id]);
            } else {
                // Insérer un nouveau commentaire
                $stmt = $pdo->prepare("INSERT INTO Commentaire (IdJoueur, commentaire) VALUES (?, ?)");
                $stmt->execute([$id, $commentaire]);
            }
        }
    } catch (PDOException $e) {
        // Gérer l'exception en cas d'erreur
        echo "Erreur de base de données : " . $e->getMessage();
        exit;
    }
}

// Rediriger l'utilisateur vers la page des joueurs
header("Location: ../vue/IHMJoueurs.php");
exit;