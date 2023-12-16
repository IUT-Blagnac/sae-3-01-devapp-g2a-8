<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Panier d'achat</title>
    <style>

        section {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #000;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #000;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <?php
        include("include/header.php");
        include("connect.inc.php");

        include("PanierController.php");

        if(isset($_POST['idProduit']) && isset($_SESSION['SigmaPrime_panier'][$_POST['idProduit']])) {
            unset($_SESSION['SigmaPrime_panier'][$_POST['idProduit']]);
        }

        if (isset($_POST['testAjout'])) {
            ajouterPanier('leggingL', 'Leggings (L)', 3, 2);
            ajouterPanier('pullL', 'Pulle (L)', 8, 1);
            ajouterPanier('avoine1kg', 'Flocons d\'avoines (1kg)', 12, 1);
        }
    ?>

    <form method="post" action="Panier.php">
        <input type="submit" name="testAjout" value="Test Ajout">
    </form>
	
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

                echo '<input type="hidden" name="idProduit" value="' . $idProduit . '">';
                echo '<select name="quantite" onchange="updateQuantity(' . $idProduit . ', this.value)">';

                $req = $conn->prepare("SELECT stock FROM Article WHERE idArticle = :idArticle");
                $req->bindParam(':idArticle', $idProduit);
                $req->execute();
                $result = $req->fetch(PDO::FETCH_ASSOC);

                for ($i = 1; $i <= $result['stock']; $i++) {
                    echo '<option value="' . $i . '" ' . ($i == $produit['quantite'] ? 'selected' : '') . '>' . $i . '</option>';
                }

                echo '</select>';
                echo '<input type="submit" value="Modifier">';
                echo '</td>';
                echo '<td>' . ($produit['prix'] * $produit['quantite']) . ' €</td>';
                echo '<td>';
                echo '<input type="hidden" name="idProduit" value="' . $idProduit . '">';
                echo '<input type="submit" value="Supprimer">';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</form>';

            echo '<form method="post" action="SupprimerPanier.php">';
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
