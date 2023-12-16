<?php
    $motDePasse = "MdpClient5";
    $motDePasseChiffre = password_hash($motDePasse, PASSWORD_DEFAULT);
    echo $motDePasseChiffre;
?>