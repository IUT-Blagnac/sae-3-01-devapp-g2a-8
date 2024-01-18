<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Accueil</title>
</head>
<body>

    <?php
        include("include/header.php");
        require_once("connect.inc.php");

        $req = $conn->prepare("SELECT * FROM Pack");
        $req->execute();
        $packs = $req->fetchAll(PDO::FETCH_ASSOC);

        $reqVentes = $conn->prepare("SELECT Article.*, SUM(Commander.quantite) as totalVentes FROM Article, Commander WHERE Article.idArticle = Commander.idArticle 
                                            GROUP BY Article.idArticle ORDER BY totalVentes DESC LIMIT 4");
        $reqVentes->execute();
        $ventes = $reqVentes->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container">
        <div class="packs-title">Découvrez nos packs</div>
        <div class="packs-container">
            <?php
            foreach ($packs as $pack) {
                echo '<a href="DetailPack.php?idPack=' . htmlentities($pack['idPack']) . '" class="pack">';
                echo '<img src="img/avis/idEval_2_articleTest.jpg" alt="Image du pack">';
                echo '<h3>' . htmlentities($pack['nomPack']) . '</h3>';
                echo '<p>' . htmlentities($pack['description']) . '</p>';
                echo '<p>Prix: ' . htmlentities($pack['prix']) . ' €</p>';
                echo '</a>';
            }
            ?>
        </div>

        <div class="best-sellers-title">Meilleures ventes</div>
        <div class="best-sellers-container">
            <?php
            foreach ($ventes as $mVentes) {
                echo '<a href="DetailProduit.php?idArticle=' . htmlentities($mVentes['idArticle']) . '" class="best-seller">';
                echo '<img src="img/avis/idEval_2_articleTest.jpg" alt="Image de l\'article">';
                echo '<h3>' . htmlentities($mVentes['nomArticle']) . '</h3>';
                echo '<p>Prix: ' . htmlentities($mVentes['prix']) . ' €</p>';
                echo '</a>';
            }
            ?>
        </div>
    </div>

    <?php
        include("include/footer.php")
    ?>

</body>
</html>
