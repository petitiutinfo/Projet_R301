<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test InfinityFree</title>
</head>
<body>
<h1>Test de connexion à la base de données</h1>
    <?php
    // Inclure le fichier de connexion
    include 'includes/db_connexion.php';

    $sql = "SHOW TABLES";
    $result = $conn->query($sql);

    if (!$result) {
        // Affiche une erreur si la requête échoue
        die("Erreur dans la requête SQL : " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "<h2>Liste des tables dans la base de données :</h2>";
        echo "<ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucune table trouvée dans la base de données.</p>";
    }
    ?>
</body>
</html>