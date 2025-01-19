<?php
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclure la fonction pour récupérer les joueurs actifs
include('../controleur/ControleurRécupererJoueursActifs.php');

// Vérifier si l'ID du match est passé dans l'URL (par la méthode GET)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si l'ID n'est pas spécifié, afficher un message d'erreur et arrêter l'exécution du script
    echo "ID du match non spécifié.";
    exit;
}

// Récupérer l'ID du match en le convertissant en entier
$id_match = intval($_GET['id']);

// Récupérer les joueurs actifs pour ce match via une fonction qui interroge la base de données
try {
    // Appel de la fonction pour récupérer les joueurs actifs
    $joueurs = recupererJoueursActifs($pdo, $id_match);
} catch (Exception $e) {
    // Si une erreur survient lors de la récupération des joueurs, afficher l'erreur et arrêter l'exécution
    echo $e->getMessage();
    exit;
}

// Définir le nombre minimum de joueurs requis pour valider la feuille de match
$nombre_minimum = 12;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définir l'encodage des caractères du document HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le référencement SEO -->
    <meta name="description" content="Feuille de match">
    
    <!-- Indiquer l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Feuille de Match</title>
    
    <!-- Lien vers le fichier CSS pour styliser la page -->
    <link rel="stylesheet" href="style/styleFeuilleDeMatch.css">
    
    <script>
        // Fonction JavaScript pour vérifier la sélection des joueurs avant la soumission du formulaire
        function verifierSelection() {
            // Récupérer toutes les cases à cocher sélectionnées
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            // Récupérer le nombre minimum de joueurs requis pour la validation
            const minimum = <?php echo $nombre_minimum; ?>;

            // Vérifier si le nombre de joueurs sélectionnés est inférieur au minimum requis
            if (checkboxes.length < minimum) {
                alert("Vous devez sélectionner au moins " + minimum + " joueurs.");
                return false;  // Empêcher l'envoi du formulaire
            }

            // Créer des objets pour suivre les postes et les rôles des joueurs sélectionnés
            const postes = {};
            const roles = {};

            // Parcourir les joueurs sélectionnés
            for (let checkbox of checkboxes) {
                const idJoueur = checkbox.value;
                const poste = document.querySelector(`[name="poste_${idJoueur}"]`).value;
                const role = document.querySelector(`[name="role_${idJoueur}"]`).value;

                // Vérifier si un joueur a un poste ou un rôle invalide (indiqué par "--")
                if (poste === '--' || role === '--') {
                    alert(`Le joueur ID ${idJoueur} a un poste ou un rôle invalide ("--").`);
                    return false;  // Arrêter l'exécution et empêcher l'envoi du formulaire
                }

                // Mettre à jour les objets postes
                if (!postes[poste]) {
                    postes[poste] = {Titulaire: 0, Remplaçant: 0};
                }
                if (role === "Titulaire") {
                    postes[poste].Titulaire += 1;
                } else if (role === "Remplaçant") {
                    postes[poste].Remplaçant += 1;
                }
            }

            // Vérifier que chaque poste sélectionné a exactement un titulaire et un remplaçant
            for (const poste in postes) {
                if (postes[poste].Titulaire !== 1 || postes[poste].Remplaçant !== 1) {
                    alert(`Le poste "${poste}" doit avoir exactement 1 titulaire et 1 remplaçant.`);
                    return false;  // Empêcher l'envoi du formulaire
                }
            }

            // Si toutes les vérifications passent, soumettre le formulaire
            return true;  // Le formulaire peut être soumis
        }
    </script>
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>

    <!-- Titre principal de la page affichant l'ID du match -->
    <h1>Feuille de Match pour le match numéro : <?php echo $id_match; ?></h1>

    <!-- Formulaire pour sélectionner les joueurs et valider la feuille de match -->
    <form id="formSelectionJoueurs" action="../controleur/ControleurValiderFeuilledematch.php" method="POST" onsubmit="return verifierSelection();">
        <!-- Champ caché contenant l'ID du match -->
        <input type="hidden" name="id_match" value="<?php echo $id_match; ?>">
        
        <!-- Tableau affichant les joueurs et permettant leur sélection -->
        <table>
            <thead>
                <!-- En-têtes de colonne -->
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
                <!-- Parcours des joueurs récupérés pour afficher leurs informations dans le tableau -->
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <!-- Case à cocher pour sélectionner le joueur -->
                        <td>
                            <input type="checkbox" name="joueurs[]" value="<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" 
                                <?php echo $joueur['Poste'] !== '--' && $joueur['Titulaire_ou_remplaçant'] !== '--' ? 'checked' : ''; ?>>
                        </td>
                        <!-- Menu déroulant pour sélectionner le poste du joueur -->
                        <td>
                            <select name="poste_<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <option value="--" <?php echo $joueur['Poste'] === '--' ? 'selected' : ''; ?>>--</option>
                                <option value="Attaquant" <?php echo $joueur['Poste'] === 'Attaquant' ? 'selected' : ''; ?>>Attaquant</option>
                                <option value="Central avant" <?php echo $joueur['Poste'] === 'Central avant' ? 'selected' : ''; ?>>Central avant</option>
                                <option value="Central arrière" <?php echo $joueur['Poste'] === 'Central arrière' ? 'selected' : ''; ?>>Central arrière</option>
                                <option value="Réceptionneur" <?php echo $joueur['Poste'] === 'Réceptionneur' ? 'selected' : ''; ?>>Réceptionneur</option>
                                <option value="Pointu" <?php echo $joueur['Poste'] === 'Pointu' ? 'selected' : ''; ?>>Pointu</option>
                                <option value="Passeur" <?php echo $joueur['Poste'] === 'Passeur' ? 'selected' : ''; ?>>Passeur</option>
                            </select>
                        </td>
                        <!-- Menu déroulant pour sélectionner le rôle du joueur (titulaire ou remplaçant) -->
                        <td>
                            <select name="role_<?php echo htmlspecialchars($joueur['IdJoueur']); ?>" required>
                                <option value="--" <?php echo $joueur['Titulaire_ou_remplaçant'] === '--' ? 'selected' : ''; ?>>--</option>
                                <option value="Titulaire" <?php echo $joueur['Titulaire_ou_remplaçant'] === 'Titulaire' ? 'selected' : ''; ?>>Titulaire</option>
                                <option value="Remplaçant" <?php echo $joueur['Titulaire_ou_remplaçant'] === 'Remplaçant' ? 'selected' : ''; ?>>Remplaçant</option>
                            </select>
                        </td>
                        <!-- Affichage des informations du joueur : nom, prénom, taille, poids, commentaires et évaluations -->
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

        <!-- Bouton pour soumettre le formulaire -->
        <button type="submit">Valider la feuille de match</button>
    </form>
</body>
</html>