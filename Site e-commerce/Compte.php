<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Mon compte</title>
</head>
<body>

    <?php include("include/header.php"); ?>

    <div class="wrapper">
        <?php include("include/menus.php"); ?>

        <div class="content">
            <?php
                if (!isset($_SESSION['SigmaPrime_acces']) && $_SESSION['SigmaPrime_acces'] !== "oui") {
                    header('Location: FormConnexion.php');
                    exit();
                }
                include("connect.inc.php");

                $idClient = $_SESSION['SigmaPrime_idClient'];

                $req = $conn->prepare("SELECT idClient, nomClient, prenomClient, adresseRueClient, codePostalClient, villeClient, telephoneClient, dtNaissanceClient, emailClient FROM Client WHERE idClient=:id");
                $req->bindParam(':id', $idClient);
                $req->execute();

                $infoCompte = $req->fetch(PDO::FETCH_ASSOC);
            ?>

            <h1>Informations du compte</h1>

            <?php
                echo '<p>Nom: ' . $infoCompte['nomClient'] . '</p>';
                echo '<p>Prénom: ' . $infoCompte['prenomClient'] . '</p>';
                echo '<p>Adresse e-mail: ' . $infoCompte['emailClient'] . '</p>';
                echo '<p>Adresse: ' . $infoCompte['adresseRueClient'] . '</p>';
                echo '<p>Code postal: ' . $infoCompte['codePostalClient'] . '</p>';
                echo '<p>Ville: ' . $infoCompte['villeClient'] . '</p>';
                echo '<p>Téléphone: ' . $infoCompte['telephoneClient'] . '</p>';
                echo '<p>Date de naissance: ' . $infoCompte['dtNaissanceClient'] . '</p>';

                echo '<a href="ModifCompte.php" class="button">Modifier mes informations</a>';
            ?>
        </div>
    </div>

    <?php include("include/footer.php"); ?>

</body>
</html>
