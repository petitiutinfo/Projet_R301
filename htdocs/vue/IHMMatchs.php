<?php include('Menu.php');?>
<?php include('../controleur/ControleurMatchs.php');?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Page affichage matchs">
    <meta name="author" content="Enzo">
    <title>Matchs</title>
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<body>
    <h1>Liste des Matchs</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Equipe adverse</th>
                <th>Lieu</th>
                <th>Domicile ou extérieur</th>
                <th>Résultat</th>
                <th>Actions</th>
                <th>Feuille de match</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matchs as $match): 
                // Vérifier si la date du match est dans le futur
                $dateDuMatch = new DateTime($match['Date_Match']);
                $dateActuelle = new DateTime(); 
                $estDansLeFutur = $dateDuMatch > $dateActuelle;
            ?>
                <tr>
                    <td><?= htmlspecialchars($match['IdMatch']); ?></td>
                    <td><?= htmlspecialchars($match['Date_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Heure_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Equipe_Adverse']); ?></td>
                    <td><?= htmlspecialchars($match['Lieu_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Domicile'] ? 'Extérieur' : 'Domicile'); ?></td>
                    <td><?= htmlspecialchars($match['Resultat']); ?></td>
                    <td>
                        <a href="IHMDetailsMatch.php?id=<?= $match['IdMatch']; ?>">
                            <button>Consulter</button>
                        </a>
                        <?php if ($estDansLeFutur): ?>
                            <a href="IHMModifierMatch.php?id=<?= $match['IdMatch']; ?>">
                                <button>Modifier</button>
                            </a>
                            <form method="POST" action="../controleur/ControleurSuppressionMatch.php" style="display:inline;">
                                <input type="hidden" name="IdMatch" value="<?= $match['IdMatch']; ?>">
                                <button type="submit" class="delete-button">Supprimer</button>
                            </form>
                        <?php else: ?>
                            <a href="IHMModifierResultatMatch.php?id=<?= $match['IdMatch']; ?>">
                                <button>Modifier Résultat</button>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($estDansLeFutur): ?>
                            <a href="IHMFueilledematchAVANT.php?id=<?= $match['IdMatch']; ?>">
                                <button>Feuille de match</button>
                            </a>
                        <?php else: ?>
                            <a href="IHMFueilledematchAPRES.php?id=<?= $match['IdMatch']; ?>">
                                <button>Feuille de match</button>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="IHMAjoutMatch.php">
        <button>Ajouter</button>
    </a>
</body>
</html>