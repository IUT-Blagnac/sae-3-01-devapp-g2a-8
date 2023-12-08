<?php
session_start();

if (!isset($_SESSION['SigmaPrime_admin']) || $_SESSION['SigmaPrime_admin'] !== "Admin") {
    header('Location: index.php');
    exit();
}
?>