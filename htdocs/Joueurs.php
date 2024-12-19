<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Joueurs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Liste des Joueurs</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>License</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de naissance</th>
                <th>Taille</th>
                <th>Poids</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db_connexion.php';

            // Exemple : requête pour récupérer des joueurs
            $sql = "SELECT * FROM Joueur LIMIT 15";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "Joueur : " . $row['nom'] . " " . $row['prenom'] . "<br>";
                }
            } else {
                echo "Aucun joueur trouvé.";
            }
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['licence'] . "</td>";
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['date_naissance'] . "</td>";
                    echo "<td>" . $row['taille'] . "</td>";
                    echo "<td>" . $row['poids'] . "</td>";
                    echo "<td>" . $row['statut'] . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"modifierJoueur(" . $row['id'] . ")\">Modifier</button> ";
                    echo "<button onclick=\"gererCommentaires(" . $row['id'] . ")\">Commentaires</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Aucun joueur trouvé</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Fermer la connexion
    $conn->close();
    ?>

    <script>
        function modifierJoueur(id) {
            window.location.href = `modifier_joueur.php?id=${id}`;
        }

        function gererCommentaires(id) {
            window.location.href = `commentaires.php?id=${id}`;
        }
    </script>
</body>
</html>
