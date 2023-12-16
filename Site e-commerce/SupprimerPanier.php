<?php
session_start();

unset($_SESSION['SigmaPrime_panier']);

header("Location: Panier.php");
exit();
?>
