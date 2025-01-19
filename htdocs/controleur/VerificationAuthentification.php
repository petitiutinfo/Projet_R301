<?php
// Démarre une session ou reprend une session existante
session_start();

// Vérifie si l'utilisateur est authentifié en vérifiant la valeur de la variable de session 'authenticated'
// - Si la variable 'authenticated' n'est pas définie ou si elle n'est pas égale à true :
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    // Redirige l'utilisateur vers la page de connexion
    header("Location: ../Index.php");
    // Arrête l'exécution du script pour éviter toute exécution ultérieure non autorisée
    exit;
}
?>