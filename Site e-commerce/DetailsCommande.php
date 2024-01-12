<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Détails de la commande</title>
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['SigmaPrime_acces']) && $_SESSION['SigmaPrime_acces'] !== "oui") {
            header('Location: FormConnexion.php');
            exit();
        }
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

                if (isset($_POST['idBC'])) {
                    $idBC = $_POST['idBC'];

                    $reqDetails = $conn->prepare("SELECT C.quantite, A.idArticle, A.nomArticle FROM Commander C, Article A WHERE C.idBC = :idBC AND C.idArticle = A.idArticle;");
                    $reqDetails->bindParam(':idBC', $idBC);
                    $reqDetails->execute();

                    echo '<h2>Détails de la commande #' . $idBC . '</h2>';
                    echo '<table>';
                    echo '<tr><th>Article</th><th>Quantité</th><th>Évaluation</th></tr>';
                    while ($detail = $reqDetails->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . $detail['nomArticle'] . '</td>';
                        echo '<td>' . $detail['quantite'] . '</td>';
                        echo '<td>';

                        $evalReq = $conn->prepare("SELECT idEval FROM Evaluation WHERE idArticle = :idArticle AND idClient = :idClient");
                        $evalReq->bindParam(':idArticle', $detail['idArticle']);
                        $evalReq->bindParam(':idClient', $idClient);
                        $evalReq->execute();

                        $evaluation = $evalReq->fetch(PDO::FETCH_ASSOC);

                        if (!$evaluation) {
                            echo '<a class="button" href="AvisArticle.php?idArticle=' . $detail['idArticle'] . '&idBC=' . $idBC . '">Donner mon avis !</a>';
                        } else {
                            echo 'Vous avez déjà évalué cet article !';
                        }

                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
            ?>
        </div>
    </div>
    <?php
        include("include/footer.php");
    ?>
</body>
</html>
