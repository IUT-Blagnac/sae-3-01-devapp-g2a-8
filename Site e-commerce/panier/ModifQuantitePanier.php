<?php
session_start();

if (isset($_POST['idProduit']) && isset($_POST['quantite'])) {
    $idProduit = $_POST['idProduit'];
    $nouvelleQuantite = $_POST['quantite'];

    if (isset($_SESSION['SigmaPrime_panier'][$idProduit])) {
        $_SESSION['SigmaPrime_panier'][$idProduit]['quantite'] = $nouvelleQuantite;
    }
}

header("Location: ../Panier.php");
exit();
?>
