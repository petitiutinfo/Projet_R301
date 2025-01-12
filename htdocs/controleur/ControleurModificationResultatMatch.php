<?php
include('db_connexion.php');

/**
 * Fonction pour mettre à jour le résultat d'un match dans la base de données.
 * @param PDO $pdo La connexion PDO.
 * @param int $id L'ID du match à mettre à jour.
 * @param string $resultat Le résultat du match à enregistrer.
 * @return bool True si la mise à jour a réussi, False sinon.
 */
function modifierResultatMatch($pdo, $id, $resultat) {
    try {
        // Vérification explicite des types des paramètres
        if (!is_int($id) || $id <= 0 || !is_string($resultat)) {
            throw new InvalidArgumentException("Paramètres invalides pour la mise à jour.");
        }

        // Préparer la requête pour mettre à jour le résultat du match
        $updateStmt = $pdo->prepare("UPDATE Matchs SET Resultat = :resultat WHERE idMatch = :id");

        // Lier les paramètres avec leur type exact
        $updateStmt->bindValue(':resultat', $resultat, PDO::PARAM_STR);
        $updateStmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Exécuter la requête
        $result = $updateStmt->execute();

        if (!$result) {
            // Afficher les détails de l'erreur si execute() échoue
            $errorInfo = $updateStmt->errorInfo();
            echo "Erreur lors de l'exécution de la requête : " . $errorInfo[2];
            return false;
        }

        return true;
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
        return false;
}

var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de l'existence des champs attendus
    if (isset($_POST['id']) && isset($_POST['resultat'])) {
        // Sécurisation et validation des entrées utilisateur
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $resultat = trim($_POST['resultat']);

        if ($id !== false || $resultat !== '')  {
            // Appeler la fonction pour mettre à jour le résultat du match
            if (modifierResultatMatch($pdo, $id, $resultat)) {
                echo "Résultat mis à jour avec succès.";
                header('Location: IHMMatchs.php');
                exit;
            } else {
                echo "Une erreur s'est produite lors de la mise à jour du résultat.";
            }
        } else {
            echo "ID ou résultat invalides.";
        }
    } else {
        echo "ID ou résultat manquants dans le formulaire.";
    }
} else {
    echo "Formulaire non soumis.";
}
?>