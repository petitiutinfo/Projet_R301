<?php
// Informations de connexion
$servername = "sql107.infinityfree.com"; // Hostname
$username = "if0_37947754";              // Username
$password = "eD280823IuT3";          // Mot de passe (remplace par le vrai)
$dbname = "if0_37947754_1";              // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
} else {
    echo "Connexion réussie !";
}
?>