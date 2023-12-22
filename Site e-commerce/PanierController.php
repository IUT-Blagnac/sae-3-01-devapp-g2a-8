<?php
if (!session_id()) {
    session_start();
}

function ajouterPanier($idProduit, $nomProduit, $prixProduit, $quantite) {
    if (!isset($_SESSION['SigmaPrime_panier'])) {
        $_SESSION['SigmaPrime_panier'] = array();
    }

    if (isset($_SESSION['SigmaPrime_panier'][$idProduit])) {
        $_SESSION['SigmaPrime_panier'][$idProduit]['quantite'] += $quantite;
    } else {
        $_SESSION['SigmaPrime_panier'][$idProduit] = array(
            'nomArticle' => $nomProduit,
            'prix' => $prixProduit,
            'quantite' => $quantite
        );
    }
}

function prixTotal($panier) {
    $total = 0;

    foreach ($panier as $produit) {
        $total += $produit['prix'] * $produit['quantite'];
    }

    return $total;
}

?>
