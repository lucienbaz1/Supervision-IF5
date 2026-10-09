<?php
$host = '127.0.0.1'; // ou localhost
$dbname = 'bazdoné';
$username = 'root'; // Utilisateur par défaut sur EasyPHP/WAMP
$password = '';     // Mot de passe vide par défaut

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configuration pour afficher les erreurs SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur, on arrête tout et on affiche le message
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>