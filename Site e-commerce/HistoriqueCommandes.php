<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Historique des commandes</title>
</head>
<body>
    <?php
        include("include/header.php");
    ?>

    <div class="wrapper">
        <?php
            include("include/menus.php");
        ?>

        <div class="content">
            <?php
                if (!isset($_SESSION['SigmaPrime_acces']) && $_SESSION['SigmaPrime_acces'] !== "oui") {
                    header('Location: FormConnexion.php');
                    exit();
                }
                include("connect.inc.php");

                $idClient = $_SESSION['SigmaPrime_idClient'];
            ?>

            <div id="historique-commandes">
                <h2>Historique des commandes</h2>

                <?php
                $req = $conn->prepare("SELECT BC.idBC, BC.dateBC, C.quantite, C.idArticle, A.nomArticle 
                                       FROM BonCommande BC, Commander C, Article A 
                                       WHERE BC.idBC = C.idBC 
                                       AND C.idArticle = A.idArticle 
                                       AND BC.idClient = :idClient;");
                $req->bindParam(':idClient', $idClient);
                $req->execute();

                while ($commande = $req->fetch(PDO::FETCH_ASSOC)) {
                    echo '<table>';
                    echo '<tr><td>Commande #</td><td>' . $commande['idBC'] . '</td></tr>';
                    echo '<tr><td>Date</td><td>' . $commande['dateBC'] . '</td></tr>';
                    echo '<tr><td>Article</td><td>' . $commande['nomArticle'] . '</td></tr>';
                    echo '<tr><td>Quantité</td><td>' . $commande['quantite'] . '</td></tr>';
                    echo '</table>';
                
                    $evalReq = $conn->prepare("SELECT idEval FROM Evaluation WHERE idArticle = :idArticle AND idClient = :idClient");
                    $evalReq->bindParam(':idArticle', $commande['idArticle']);
                    $evalReq->bindParam(':idClient', $idClient);
                    $evalReq->execute();
                
                    $evaluation = $evalReq->fetch(PDO::FETCH_ASSOC);
                
                    if (!$evaluation) {
                        echo '<form method="post" action="EvaluationArticle.php" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="idArticle" value="' . $commande['idArticle'] . '">';
                        echo '<input type="hidden" name="idClient" value="' . $idClient . '">';
                        echo '<input type="hidden" name="nomArticle" value="' . $commande['nomArticle'] . '">';
                        echo '<label for="note">Note:</label>';
                        echo '<select name="note" required>';
                        echo '<option value="1">1</option>';
                        echo '<option value="2">2</option>';
                        echo '<option value="3">3</option>';
                        echo '<option value="4">4</option>';
                        echo '<option value="5">5</option>';
                        echo '</select><br><br>';
                        echo '<label for="avis">Avis:</label>';
                        echo '<textarea name="avis" rows="4" cols="50" required></textarea><br><br>';
                        echo '<label for="image">Photo:</label>';
                        echo '<input type="file" name="image"><br><br>';
                        echo '<button type="submit">Évaluer</button>';
                        echo '</form>';
                    } else {
                        echo '<p>Déjà évalué</p>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
        include("include/footer.php");
    ?>
</body>
</html>
