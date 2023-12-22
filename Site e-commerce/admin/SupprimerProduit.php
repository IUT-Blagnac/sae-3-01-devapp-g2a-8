<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin Supprimer Article</title>
</head>

<body>
    <?php
        include("../include/header.php");
        if (!isset($_SESSION['SigmaPrime_admin']) || $_SESSION['SigmaPrime_admin'] !== "Admin") {
            header('Location: ../index.php');
            exit();
        }
    ?>
    <?php
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
        require_once("../connect.inc.php");
        $req = $conn->prepare("DELETE FROM Article WHERE idArticle = '".$_GET['pIdArticle']."'");
        $req->execute();
        echo '<script language="JavaScript" type="text/javascript">
            alert("Suppression effectuée");
            </script>';
        echo '<script language="JavaScript" type="text/javascript">
        window.location.replace("GestionProduits.php");
        </script>'; 
    ?>
</body>

