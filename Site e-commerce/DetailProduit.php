<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styleDetail.css">
    
    <title>SigmaPrime - Accueil</title>
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
            echo "<h1>" . $row["nomArticle"] . "</h1>";
            echo "<p>à partir de : </p><h2>" . $row["prix"] . " €</h2>";
            echo "<p>" . $row["description"] . "</p>";
            echo '<form method="post">';
            
            echo '<input type="hidden" name="idProduit" value="' . $idArticle . '">';
            echo '<input type="hidden" name="nomProduit" value="' . $row["nomArticle"] . '">';
            echo '<input type="hidden" name="prixProduit" value="' . $row["prix"] . '">';
            echo '<input type="hidden" name="quantite" value="1" min="1">';
            echo '<input type="submit" name="ajouterAuPanier" value="Ajouter au Panier" class="add-to-cart-button">';
            echo '</form>';

            
        }

        $reqAvis = $conn->prepare("SELECT e.*, c.prenomClient, SUBSTRING(c.nomClient, 1, 1) as premiereLettreNom FROM Evaluation e 
                          JOIN Client c ON e.idClient = c.idClient
                          WHERE e.idArticle = ?");
        $reqAvis->execute([$idArticle]);

        while ($avis = $reqAvis->fetch()) {
            echo "<div class='avis'>";
            echo "<p>Avis de : " . $avis['prenomClient'] . " " . $avis['premiereLettreNom'] . "</p>";
            echo "<p>Note : " . $avis['note'] . " / 5</p>";
            echo "<p>Commentaire : " . $avis['avis'] . "</p>";

            if (file_exists("img/avis/idEval_" . $avis['idClient'] . "_" . $avis['idArticle'] . ".jpg")) {
                echo '<img class="zoomable-image" src="img/avis/idEval_' . $avis['idClient'] . '_' . $avis['idArticle'] . '.jpg" alt="Image de l\'avis">';
            }

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
