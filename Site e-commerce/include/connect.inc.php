<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=saemysql08;charset=UTF8', 'saemysql08', 'nP3SU33Wk6b3vd', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données.";
    die();
}
?>


