<?php
// Affichage du code HTML pour le header de la page
echo '
<header id="hautDePage">
    <!-- Début de la navigation -->
    <nav id="navigation">
        <!-- Liste principale contenant le lien vers la page "Volley Master" -->
        <ul id="volleyMaster" >
            <li><a href="IHMJoueurs.php">Volley Master</a></li>
        </ul>
        
        <!-- Liste des éléments du menu principal -->
        <ul id="menu">
            <!-- Lien vers la page des joueurs -->
            <li><a href="IHMJoueurs.php">Joueurs</a></li>
            <!-- Lien vers la page des matchs -->
            <li><a href="IHMMatchs.php">Matchs</a></li>
            <!-- Lien vers la page des statistiques -->
            <li><a href="IHMStatistiques.php">Statistiques</a></li>
        </ul>
        
        <!-- Liste des éléments du menu de déconnexion -->
        <ul id="menuLogout">
            <!-- Lien vers la page de déconnexion -->
            <li><a href="../controleur/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>
';
?>