<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styleDetail.css">
    <title>SigmaPrime - Produits</title>
</head>
<body id="detail-product">

    <?php
    include("include/header.php");
    include("PanierController.php");
    ?>
	
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once("connect.inc.php");
    if (isset($_GET['idArticle'])) {
        $idArticle = $_GET['idArticle'];

        $reqDetailArticles = $conn->prepare("SELECT * FROM Article WHERE idArticle= ?");
        $reqDetailArticles->execute([$idArticle]);
        while ($row = $reqDetailArticles->fetch()) {
            echo '<br><br>';
            echo '<div class="product-details">';
            echo '<img src="img/avis/idEval_2_articleTest.jpg" alt="Image du produit" class="product-image">';
            echo '<h1 class="product-title">' . htmlentities($row["nomArticle"]) . '</h1>';
            echo '<p class="product-price">À partir de : <span>' . htmlentities($row["prix"]) . ' €</span></p>';
            echo '<p class="product-description">' . htmlentities($row["description"]) . '</p>';
            echo '<form method="post">';
            echo '<input type="hidden" name="idProduit" value="' . $idArticle . '">';
            echo '<input type="hidden" name="nomProduit" value="' . htmlentities($row["nomArticle"]) . '">';
            echo '<input type="hidden" name="prixProduit" value="' . htmlentities($row["prix"]) . '">';
            echo '<input type="hidden" name="quantite" value="1" min="1">';
            echo '<input type="submit" name="ajouterAuPanier" value="Ajouter au Panier" class="add-to-cart-button">';
            echo '</form>';
            echo '</div>';
            echo '<br><br><br><br><br><br>';
        }

        $reqAvis = $conn->prepare("SELECT e.*, c.prenomClient FROM Evaluation e, Client c WHERE e.idClient = c.idClient AND e.idArticle = ?");
        $reqAvis->execute([$idArticle]);


        if(!empty($_SESSION['SigmaPrime_idClient'])){
            $idClient = $_SESSION['SigmaPrime_idClient'];
        }
        
        while ($avis = $reqAvis->fetch()) {
            echo "<div class='avis'>";
            echo "<p><b>Avis de " . $avis['prenomClient'] . "</b></p>";
            echo "<p>Note : " . $avis['note'] . " / 5</p>";
            echo "<p>Commentaire : " . $avis['avis'] . "</p>";

            if (file_exists("img/avis/idEval_" . $avis['idClient'] . "_" . $avis['idArticle'] . ".jpg")) {
                echo '<img class="zoomable-image" src="img/avis/idEval_' . $avis['idClient'] . '_' . $avis['idArticle'] . '.jpg" alt="Image de l\'avis">';
            }
            

            if(!empty($idClient) && !empty($_SESSION['SigmaPrime_admin'])){
                $req = $conn->prepare("SELECT * FROM ReponseEvaluation WHERE idEval = ? AND idClient = ?");
                $req->execute([$avis['idEval'], $idClient]);

                if ($req->rowCount() == 0) {
                    echo "<a href='Repondre.php?idEval=" . $avis['idEval'] . "' class='button'>Répondre</a><br><br>";
                }
            }

            echo "<a href='AfficherReponses.php?idEval=" . $avis['idEval'] . "' class='button'>Voir les réponses</a>";
            echo "</div>";
        }
    }
    ?>

    <?php
    include("include/footer.php");
    if (isset($_POST['ajouterAuPanier'])) {
        $idProduit = $_POST['idProduit'];
        $nomProduit = $_POST['nomProduit'];
        $prixProduit = $_POST['prixProduit'];
        $quantite = $_POST['quantite'];

        // Appel à la fonction ajouterPanier du PanierController
        ajouterPanier($idProduit, $nomProduit, $prixProduit, $quantite);
    }
    ?>

</body>
</html>
