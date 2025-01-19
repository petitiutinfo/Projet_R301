<?php
// Définir les informations de connexion à la base de données MySQL
$host = 'sql112.infinityfree.com'; // Numéro du serveur SQL (hôte)
$dbname = 'if0_37947754_1'; // Nom exact de la base de données
$username = 'if0_37947754'; // Nom d'utilisateur MySQL pour la connexion
$password = 'eD280823IuT3'; // Mot de passe MySQL associé à l'utilisateur

try {
    // Tentative de connexion à la base de données MySQL en utilisant PDO
    // La connexion utilise l'hôte, le nom de la base de données et le jeu de caractères UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurer PDO pour lancer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si une erreur survient lors de la connexion, arrêter le script et afficher le message d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>