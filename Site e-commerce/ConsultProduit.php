<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <style>
        /* Ajoutez des styles pour les produits */
        .product-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            text-align: center;
            width: calc(20% - 20px); /* 20% pour 5 cases par ligne, ajustez si nécessaire */
            box-sizing: border-box; /* Inclut le padding et la bordure dans la largeur et la hauteur */
        }

        .product-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Pour répartir les éléments sur la ligne */
        }

        /* Ajoutez d'autres styles si nécessaire */
    </style>
    <title>SigmaPrime - Accueil</title>
</head>
<body>

    <?php
    include("include/header.php")
    ?>
	
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once("connect.inc.php");
    if (isset($_GET['idCategorie'])) {
        $idCategorie = $_GET['idCategorie'];

        $reqConsultArticles = $conn->prepare("SELECT DISTINCT * FROM Article WHERE categorie= ?");
        $reqConsultArticles->execute([$idCategorie]);

        echo "<div class='product-wrapper'>"; // Div pour contenir les produits

        
    while ($row = $reqConsultArticles->fetch()) {
        echo "<a href='DetailProduit.php?idArticle=" . $row["idArticle"] . "' class='product-container'>";
        echo "<h2>" . $row["nomArticle"] . "</h2>";
        echo "<p>Prix : " . $row["prix"] . " €</p>";
        echo "</a>";
    }


        echo "</div>"; // Fin de la div pour contenir les produits
    } else {
        echo "ID de catégorie non spécifié.";
    }
    ?>

    <?php
    include("include/footer.php")
    ?>

</body>
</html>
