<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Panier d'achat</title>
</head>
<body>
    <?php
        include("include/header.php");
        include("connect.inc.php");
        include("PanierController.php");

        if (isset($_POST['idProduit']) && isset($_POST['quantite'])) {
            $idProduit = $_POST['idProduit'];
            $nouvelleQuantite = $_POST['quantite'];

            if (isset($_SESSION['SigmaPrime_panier'][$idProduit])) {
                $_SESSION['SigmaPrime_panier'][$idProduit]['quantite'] = $nouvelleQuantite;
            }
        }
    ?>

    <?php
        if (!empty($_SESSION['SigmaPrime_panier'])) {
            echo '<form method="post" action="Panier.php">';
            echo '<table>';
            echo '<tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Total</th><th>Actions</th></tr>';

            foreach ($_SESSION['SigmaPrime_panier'] as $idProduit => $produit) {
                echo '<tr>';
                echo '<td>' . $produit['nomArticle'] . '</td>';
                echo '<td>' . $produit['prix'] . ' €</td>';
                echo '<td>';
                echo '<form method="post" action="Panier.php">';
                echo '<input type="hidden" name="idProduit" value="' . $idProduit . '">';
                echo '<select name="quantite" onchange="this.form.submit()">';
                $req = $conn->prepare("SELECT stock FROM Article WHERE idArticle = :idArticle");
                $req->bindParam(':idArticle', $idProduit);
                $req->execute();
                $result = $req->fetch(PDO::FETCH_ASSOC);

                if($result['stock'] < 10){
                    for ($i = 1; $i <= $result['stock']; $i++) {
                        echo '<option value="' . $i . '" ' . ($i == $produit['quantite'] ? 'selected' : '') . '>' . $i . '</option>';
                    }
                }else{
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<option value="' . $i . '" ' . ($i == $produit['quantite'] ? 'selected' : '') . '>' . $i . '</option>';
                    }
                }

                echo '</select>';
                echo '</form>';
                echo '</td>';
                echo '<td>' . ($produit['prix'] * $produit['quantite']) . ' €</td>';
                echo '<td>';
                echo '<form method="post" action="panier/SupprimerLignePanier.php">';
                echo '<input type="hidden" name="idProduit" value="' . $idProduit . '">';
                echo '<input type="submit" value="Supprimer">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';

            $total = prixTotal($_SESSION['SigmaPrime_panier']);
            echo '<div>';
            echo '<p>Prix total : ' . $total . ' €</p>';
            echo '<button class="button" type="submit" formaction="paiement.php">Procéder au paiement</button>';
            echo '</div>';

            echo '</form>';
            echo '<br><br>';
            echo '<form method="post" action="panier/SupprimerPanier.php">';
            echo '<input type="submit" value="Supprimer mon panier">';
            echo '</form>';
        } else {
            echo '<p>Votre panier est vide.</p>';
        }
    ?>

    <?php
        include("include/footer.php")
    ?>
</body>
</html>