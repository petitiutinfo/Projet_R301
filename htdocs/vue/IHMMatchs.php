<?php 
// Inclusion du fichier pour vérifier l'authentification de l'utilisateur
include('../controleur/VerificationAuthentification.php');

// Inclusion du fichier de gestion des matchs
include('../controleur/ControleurMatchs.php');

// Inclusion de la fonction pour formater le score des matchs
include('../controleur/FormaterScore.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition de l'encodage des caractères du document HTML -->
    <meta charset="UTF-8">
    
    <!-- Description de la page pour le SEO -->
    <meta name="description" content="Page affichage matchs">
    
    <!-- Indication de l'auteur de la page -->
    <meta name="author" content="Enzo">
    
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Matchs</title>
    
    <!-- Lien vers le fichier CSS pour styliser la page -->
    <link rel="stylesheet" href="style/stylePageAffichage.css">
</head>
<body>
    <!-- Inclusion du menu de navigation -->
    <?php include('Menu.php'); ?>
    
    <!-- Titre principal de la page affichant la liste des matchs -->
    <h1>Liste des Matchs</h1>
    
    <!-- Lien pour ajouter un nouveau match -->
    <a id="BoutonAjouter" href="IHMAjoutMatch.php">
        <button>Ajouter</button>
    </a>
    
    <!-- Tableau affichant les informations des matchs -->
    <table border="1">
        <thead>
            <!-- En-têtes de colonnes pour chaque information sur le match -->
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
            <!-- Boucle pour afficher chaque match -->
            <?php foreach ($matchs as $match): 
                // Vérifier si la date du match est dans le futur
                $dateDuMatch = new DateTime($match['Date_Match']);
                $dateActuelle = new DateTime(); 
                $estDansLeFutur = $dateDuMatch > $dateActuelle;
            ?>
                <tr>
                    <!-- Affichage des informations du match avec sécurisation via htmlspecialchars -->
                    <td><?= htmlspecialchars($match['IdMatch']); ?></td>
                    <td><?= htmlspecialchars($match['Date_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Heure_Match']); ?></td>
                    <td><?= htmlspecialchars($match['Equipe_Adverse']); ?></td>
                    <td><?= htmlspecialchars($match['Lieu_Match']); ?></td>
                    <!-- Affichage de "Domicile" ou "Extérieur" selon la valeur de la colonne 'Domicile' -->
                    <td><?= htmlspecialchars($match['Domicile'] ? 'Extérieur' : 'Domicile'); ?></td>
                    <!-- Formattage du score du match via la fonction 'formaterScore' -->
                    <td><?= formaterScore($match['Resultat']); ?></td>
                    <td>
                        <!-- Lien pour consulter les détails du match -->
                        <a href="IHMDetailsMatch.php?id=<?= $match['IdMatch']; ?>">
                            <button>Consulter</button>
                        </a>
                        <?php if ($estDansLeFutur): ?>
                            <!-- Si le match est dans le futur, permettre de modifier ou supprimer -->
                            <a href="IHMModifierMatch.php?id=<?= $match['IdMatch']; ?>">
                                <button>Modifier</button>
                            </a>
                            <!-- Formulaire pour supprimer un match -->
                            <form id="formulaireSuppresionMatch" method="POST" action="../controleur/ControleurSuppressionMatch.php"
                            style="display:inline;">
                                <input type="hidden" name="IdMatch" value="<?= $match['IdMatch']; ?>">
                                <button type="submit" class="delete-button">Supprimer</button>
                            </form>
                        <?php else: ?>
                            <!-- Si le match est dans le passé, permettre de modifier seulement le résultat -->
                            <a href="IHMModifierResultatMatch.php?id=<?= $match['IdMatch']; ?>">
                                <button>Modifier Résultat</button>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($estDansLeFutur): ?>
                            <!-- Si le match est dans le futur, afficher la feuille de match avant le match -->
                            <a href="IHMFueilledematchAVANT.php?id=<?= $match['IdMatch']; ?>">
                                <button>Feuille de match</button>
                            </a>
                        <?php else: ?>
                            <!-- Si le match est passé, afficher la feuille de match après le match -->
                            <a href="IHMFueilledematchAPRES.php?id=<?= $match['IdMatch']; ?>">
                                <button>Feuille de match</button>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>