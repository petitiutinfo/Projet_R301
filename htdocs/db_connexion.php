<?php
// Informations de connexion
$servername = "sql107.infinityfree.com"; // Hostname
$username = "if0_37717881";              // Username
$password = "TON_MOT_DE_PASSE";          // Mot de passe (remplace par le vrai)
$dbname = "if0_37717881_1";              // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
} else {
    echo "Connexion réussie !";
}
?>