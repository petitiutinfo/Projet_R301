<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Vérifier si l'ID du match est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Récupérer les informations du match avec l'ID
        $stmt = $pdo->prepare("SELECT * FROM Matchs WHERE idMatch = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$match) {
            echo "Aucun match trouvé avec cet ID.";
            exit;
        }

        // Vérifier si le formulaire a été soumis pour mettre à jour le résultat
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resultat'])) {
            $resultat = htmlspecialchars($_POST['resultat']);
            
            // Mettre à jour le résultat dans la base de données
            $updateStmt = $pdo->prepare("UPDATE Matchs SET Resultat = :resultat WHERE idMatch = :id");
            $updateStmt->bindParam(':resultat', $resultat, PDO::PARAM_STR);
            $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $updateStmt->execute();

            header('Location: IHMMatchs.php');
            echo "Résultat mis à jour avec succès.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des informations : " . $e->getMessage();
        exit;
    }
} else {
    echo "ID du match non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Modification du résultat du match">
    <meta name="author" content="Enzo">
    <title>Modifier le Résultat du Match</title>
    <link rel="stylesheet" href="JoueursCSS.css">
    <?php include('Menu.php'); ?>
</head>
<body>
    <h1>Modifier le Résultat du Match</h1>

    <table>
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($match['IdMatch']); ?></td>
        </tr>
        <tr>
            <th>Numéro de licence</th>
            <td><?php echo htmlspecialchars($match['Date_Match']); ?></td>
        </tr>
        <tr>
            <th>Nom</th>
            <td><?php echo htmlspecialchars($match['Heure_Match']); ?></td>
        </tr>
        <tr>
            <th>Prénom</th>
            <td><?php echo htmlspecialchars($match['Equipe_Adverse']); ?></td>
        </tr>
        <tr>
            <th>Date de naissance</th>
            <td><?php echo htmlspecialchars($match['Lieu_Match']); ?></td>
        </tr>
        <tr>
            <th>Taille</th>
            <td><?php echo htmlspecialchars($match['Domicile']); ?></td>
        </tr>
        <tr>
            <th>Poids</th>
            <td><?php echo htmlspecialchars($match['Resultat']); ?></td>
        </tr>
    </table>

    <h2>Modifier le Résultat</h2>
    <form method="POST">
        <label for="resultat">Nouveau Résultat:</label>
        <input type="text" id="resultat" name="resultat" value="<?php echo htmlspecialchars($match['Resultat']); ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>