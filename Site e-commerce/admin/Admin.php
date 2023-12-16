<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin</title>
</head>
<body>
    <?php
        include("../include/header.php");
    ?>
        <a href="GestionClients.php">Gestion des clients</a>
        <a href="GestionProduits.php">Gestion des articles</a>
    <?php
        include("../include/footer.php");
        if (!isset($_SESSION['SigmaPrime_admin']) || $_SESSION['SigmaPrime_admin'] !== "Admin") {
            header('Location: ../index.php');
            exit();
        }
    ?>
</body>

