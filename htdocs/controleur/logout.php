<?php
// Démarre la session
session_start();

// Vide toutes les variables de session
$_SESSION = array();

// Détruit toutes les données associées à la session en cours (déconnecte l'utilisateur)
session_destroy();

// Redirige l'utilisateur vers la page d'accueil (index.php)
header("Location: ../index.php");

// Assure que le script s'arrête après la redirection
exit;
?>
