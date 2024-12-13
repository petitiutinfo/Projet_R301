<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Page joueurs">
    <meta name="author" content="Miegemolle">
    <title>Joueurs</title>
    <!-- Fichier CSS -->
    <link rel="stylesheet" href="JoueursCSS.css">
</head>
<header id="hautDePage">
    <nav id="navigation">
        <ul id="menu">
            <li><a href="#section1">Joueurs</a></li>
            <li><a href="#section2">Matchs</a></li>
            <li><a href="#section3">Statistiques</a></li>
        </ul>
    </nav>
</header>
<body>
    <h1 id="titrePageAccueil">Page d'ajout de joueur</h1>

    <form id="formulaireAjoutJoueur" action="/ajouter_joueur" method="POST">
        <div class="form-group">
            <label for="numero_license">Numéro de License :</label>
            <input type="number" id="numero_license" name="numero_license" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" maxlength="50" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" maxlength="50" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="date_naissance">Date de Naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="taille">Taille (en cm) :</label>
            <input type="number" id="taille" name="taille" min="50" max="250" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="poids">Poids (en kg) :</label>
            <input type="number" id="poids" name="poids" step="0.1" required>
        </div>
        <div class="form-group">
            <label class="labelFormJoueur" for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <option value="actif">Actif</option>
                <option value="blessé">Blessé</option>
                <option value="suspendu">Suspendu</option>
                <option value="absent">Absent</option>
            </select>
        </div>
        <button id="bontonAjoutJoueur"type="submit">Ajouter le Joueur</button>
    </form>

</body>
</html>
