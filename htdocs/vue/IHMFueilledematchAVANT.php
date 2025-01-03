<?php
// Inclure la connexion à la base de données
include('../controleur/db_connexion.php');

// Vérifier si l'ID du match est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID du match non spécifié.";
    exit;
}

$id_match = intval($_GET['id']);

// Récupérer les joueurs actifs
try {
    $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE Statut = '0'");
    $stmt->execute();
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des joueurs actifs : " . $e->getMessage();
    exit;
}

// Récupérer les participations existantes pour ce match
try {
    $stmt = $pdo->prepare("
        SELECT p.IdJoueur, p.Poste, p.Titulaire_ou_remplaçant 
        FROM Participer p 
        WHERE p.IdMatch = :id_match
    ");
    $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
    $stmt->execute();
    $participations_existantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des participations existantes : " . $e->getMessage();
    exit;
}

// Organiser les participations par ID du joueur pour un accès facile
$participations_par_joueur = [];
foreach ($participations_existantes as $participation) {
    $participations_par_joueur[$participation['IdJoueur']] = $participation;
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
    <link rel="stylesheet" href="JoueursCSS.css">
    <script>
        function verifierSelection() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length < <?php echo $nombre_minimum; ?>) {
                alert("Vous devez sélectionner au moins <?php echo $nombre_minimum; ?> joueurs.");
                return false;
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
                    <th>Évaluations de l'entraîneur</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueurs as $joueur): ?>
                    <?php
                        // Vérifier si le joueur a une participation existante
                        $participation = $participations_par_joueur[$joueur['IdJoueur']] ?? null;
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="joueurs[]" value="<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" 
                                   <?php echo $participation ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <select name="poste_<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <option value="Attaquant" <?php echo ($participation['Poste'] ?? '') == 'Attaquant' ? 'selected' : ''; ?>>Attaquant</option>
                                <option value="Centre avant" <?php echo ($participation['Poste'] ?? '') == 'Centre avant' ? 'selected' : ''; ?>>Centre avant</option>
                                <option value="Centre arrière" <?php echo ($participation['Poste'] ?? '') == 'Centre arrière' ? 'selected' : ''; ?>>Centre arrière</option>
                                <option value="Réceptionneur" <?php echo ($participation['Poste'] ?? '') == 'Réceptionneur' ? 'selected' : ''; ?>>Réceptionneur</option>
                                <option value="Pointu" <?php echo ($participation['Poste'] ?? '') == 'Pointu' ? 'selected' : ''; ?>>Pointu</option>
                                <option value="Passeur" <?php echo ($participation['Poste'] ?? '') == 'Passeur' ? 'selected' : ''; ?>>Passeur</option>
                            </select>
                        </td>
                        <td>
                            <select name="role_<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <option value="Titulaire" <?php echo ($participation['Titulaire_ou_remplaçant'] ?? '') == 'Titulaire' ? 'selected' : ''; ?>>Titulaire</option>
                                <option value="Remplaçant" <?php echo ($participation['Titulaire_ou_remplaçant'] ?? '') == 'Remplaçant' ? 'selected' : ''; ?>>Remplaçant</option>
                            </select>
                        </td>
                        <td><?php echo htmlspecialchars($joueur['Nom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Prénom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Taille']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Poids']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Commentaires']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['Evaluations']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Valider la feuille de match</button>
    </form>
</body>
</html>