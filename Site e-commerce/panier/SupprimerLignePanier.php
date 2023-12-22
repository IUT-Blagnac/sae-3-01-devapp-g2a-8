<?php
session_start();

if (isset($_POST['idProduit'])) {
    $idProduit = $_POST['idProduit'];

    if (isset($_SESSION['SigmaPrime_panier'][$idProduit])) {
        unset($_SESSION['SigmaPrime_panier'][$idProduit]);
    }
}

header("Location: ../Panier.php");
exit();
?>
