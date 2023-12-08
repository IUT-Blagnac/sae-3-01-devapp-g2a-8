<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=saephp08;charset=UTF8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage() . "<br>";
    die();
}
?>
