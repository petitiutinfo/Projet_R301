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

    <?php
    // Requête SQL pour récupérer les joueurs
    $sql = "SELECT * FROM joueurs LIMIT 15";
    $result = $conn->query($sql);
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Âge</th>
                <th>Équipe</th>
                <th>Poste</th>
                <th>Nationalité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nom'] . "</td>";
                    echo "<td>" . $row['prenom'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['equipe'] . "</td>";
                    echo "<td>" . $row['poste'] . "</td>";
                    echo "<td>" . $row['nationalite'] . "</td>";
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
