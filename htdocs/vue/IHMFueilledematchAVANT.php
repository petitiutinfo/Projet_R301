<?php
// Inclure la fonction pour récupérer les joueurs actifs
include('../controleur/ControleurRécupererJoueursActifs.php');

// Vérifier si l'ID du match est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID du match non spécifié.";
    exit;
}

$id_match = intval($_GET['id']);

// Récupérer les joueurs actifs
try {
    $joueurs = recupererJoueursActifs($pdo, $id_match);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

// Définir le nombre minimum de joueurs requis
$nombre_minimum = 12;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Feuille de match">
    <meta name="author" content="Enzo">
    <title>Feuille de Match</title>
    <!--<link rel="stylesheet" href="JoueursCSS.css">-->
    <script>
        function verifierSelection() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            const minimum = <?php echo $nombre_minimum; ?>;

            if (checkboxes.length < minimum) {
                alert("Vous devez sélectionner au moins " + minimum + " joueurs.");
                return false;
            }

            const postes = {};
            const roles = {};

            checkboxes.forEach((checkbox) => {
                const idJoueur = checkbox.value;
                const poste = document.querySelector(`[name="poste_${idJoueur}"]`).value;
                const role = document.querySelector(`[name="role_${idJoueur}"]`).value;

                postes[poste] = postes[poste] || [];
                postes[poste].push(role);

                if (!roles[poste]) {
                    roles[poste] = { Titulaire: 0, Remplaçant: 0 };
                }
                roles[poste][role]++;
            });

            for (const poste in postes) {
                if (roles[poste].Titulaire !== 1 || roles[poste].Remplaçant !== 1) {
                    alert(`Le poste "${poste}" doit avoir exactement 1 titulaire et 1 remplaçant.`);
                    return false;
                }
            }

            return true;
        }
    </script>
</head>
<body>
    <?php include('Menu.php'); ?>

    <h1>Feuille de Match pour le match numéro : <?php echo $id_match; ?></h1>

    <form id="formSelectionJoueurs" action="../controleur/ControleurValiderFeuilledematch.php" method="POST" onsubmit="return verifierSelection();">
        <input type="hidden" name="id_match" value="<?php echo $id_match; ?>">
        <table>
            <thead>
                <tr>
                    <th>Sélection</th>
                    <th>Poste</th>
                    <th>Titulaire / Remplaçant</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille (cm)</th>
                    <th>Poids (kg)</th>
                    <th>Commentaires</th>
                    <th>Évaluations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="joueurs[]" value="<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" 
                                <?php echo $joueur['Poste'] ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <select name="poste_<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <option value="Attaquant" <?php echo $joueur['Poste'] === 'Attaquant' ? 'selected' : ''; ?>>Attaquant</option>
                                <option value="Central avant" <?php echo $joueur['Poste'] === 'Central avant' ? 'selected' : ''; ?>>Central avant</option>
                                <option value="Central arrière" <?php echo $joueur['Poste'] === 'Central arrière' ? 'selected' : ''; ?>>Central arrière</option>
                                <option value="Réceptionneur" <?php echo $joueur['Poste'] === 'Réceptionneur' ? 'selected' : ''; ?>>Réceptionneur</option>
                                <option value="Pointu" <?php echo $joueur['Poste'] === 'Pointu' ? 'selected' : ''; ?>>Pointu</option>
                                <option value="Passeur" <?php echo $joueur['Poste'] === 'Passeur' ? 'selected' : ''; ?>>Passeur</option>
                            </select>
                        </td>
                        <td>
                            <select name="role_<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <option value="Titulaire" <?php echo $joueur['Titulaire_ou_remplaçant'] === 'Titulaire' ? 'selected' : ''; ?>>Titulaire</option>
                                <option value="Remplaçant" <?php echo $joueur['Titulaire_ou_remplaçant'] === 'Remplaçant' ? 'selected' : ''; ?>>Remplaçant</option>
                            </select>
                        </td>
                        <td><?php echo htmlspecialchars($joueur['Nom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Prénom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Taille']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Poids']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Commentaire']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Evaluations']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Valider la feuille de match</button>
    </form>
</body>
</html>