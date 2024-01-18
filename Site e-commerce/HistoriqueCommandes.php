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
            ?>

            <div id="historique-commandes">
                <h2>Historique des commandes</h2>

                <?php
                $req = $conn->prepare("SELECT DISTINCT BC.idBC, BC.dateBC 
                                       FROM BonCommande BC 
                                       WHERE BC.idClient = :idClient;");
                $req->bindParam(':idClient', $idClient);
                $req->execute();

                while ($commande = $req->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="commande">';
                    echo '<p>Commande #' . $commande['idBC'] . ' - Date: ' . $commande['dateBC'] . '</p>';
                    echo '<form method="post" action="DetailsCommande.php">';
                    echo '<input type="hidden" name="idBC" value="' . $commande['idBC'] . '">';
                    echo '<button class="button" type="submit">Afficher mes articles</button>';
                    echo '</form>';

                    echo '</div>';
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
