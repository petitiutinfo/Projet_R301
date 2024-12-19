<?php
// Informations de connexion
$servername = "sqlXXX.infinityfree.net"; // Remplace avec ton serveur
$username = "epiz_12345678";             // Ton utilisateur
$password = "ton_mot_de_passe";          // Ton mot de passe
$dbname = "epiz_12345678_nomdelabase";   // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>