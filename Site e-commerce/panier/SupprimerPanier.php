<?php
session_start();

if (isset($_SESSION['SigmaPrime_panier'])) {
    unset($_SESSION['SigmaPrime_panier']);
}

header("Location: ../Panier.php");
exit();
?>
