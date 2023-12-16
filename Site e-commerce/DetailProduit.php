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
    include("include/header.php")
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
            echo '<input type="button" value="Ajouter au Panier" class="add-to-cart-button">';

            
        }
        

        
    }
    ?>

    <?php
    include("include/footer.php")
    ?>

</body>
</html>
