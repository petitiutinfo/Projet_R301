<?php
$host = 'sql112.infinityfree.com'; // Remplacez XXX par le numéro de votre serveur SQL
$dbname = 'if0_37947754_1'; // Nom exact de votre base de données
$username = 'if0_37947754'; // Votre nom d'utilisateur MySQL
$password = 'eD280823IuT3'; // Votre mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>