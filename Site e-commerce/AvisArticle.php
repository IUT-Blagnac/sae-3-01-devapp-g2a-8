<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Évaluer l'article</title>
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
                if (!isset($_SESSION['SigmaPrime_acces']) || $_SESSION['SigmaPrime_acces'] !== "oui") {
                    header('Location: FormConnexion.php');
                    exit();
                }
                include("connect.inc.php");

                if (isset($_GET['idArticle'], $_GET['idBC'])) {
                    $idArticle = $_GET['idArticle'];
                    $idBC = $_GET['idBC'];

                    $commandeReq = $conn->prepare("SELECT C.idBC FROM Commander C, BonCommande BC WHERE C.idArticle = :idArticle AND C.idBC = :idBC AND BC.idClient = :idClient AND BC.idBC = C.idBC");
                    $commandeReq->bindParam(':idArticle', $idArticle);
                    $commandeReq->bindParam(':idBC', $idBC);
                    $commandeReq->bindParam(':idClient', $_SESSION['SigmaPrime_idClient']);
                    $commandeReq->execute();

                    $evalReq = $conn->prepare("SELECT idEval FROM Evaluation WHERE idArticle = :idArticle AND idClient = :idClient");
                    $evalReq->bindParam(':idArticle', $idArticle);
                    $evalReq->bindParam(':idClient', $_SESSION['SigmaPrime_idClient']);
                    $evalReq->execute();
                    $evaluation = $evalReq->fetch(PDO::FETCH_ASSOC);

                    if ($commandeReq->rowCount() === 0 || $evaluation) {
                        header('Location: HistoriqueCommandes.php');
                        exit();
                    }

                    $req = $conn->prepare("SELECT nomArticle FROM Article WHERE idArticle = :idArticle");
                    $req->bindParam(':idArticle', $idArticle);
                    $req->execute();
                    $resultNomArticle = $req->fetch(PDO::FETCH_ASSOC);
                    $nomArticle = $resultNomArticle['nomArticle'];

                    echo '<h2>Évaluer l\'article ' . htmlentities($nomArticle) . '</h2>';
                    echo '<form method="post" action="EvaluationArticle.php" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="idArticle" value="' . $idArticle . '">';
                    echo '<input type="hidden" name="idClient" value="' . $_SESSION['SigmaPrime_idClient'] . '">';
                    echo '<input type="hidden" name="nomArticle" value="' . htmlentities($nomArticle) . '">';
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
                    echo "Erreur : paramètres manquants.";
                }
            ?>
        </div>
    </div>

    <?php
        include("include/footer.php");
    ?>
</body>
</html>
