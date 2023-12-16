
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Mon compte</title>
</head>
<body>

    <?php
        include("include/header.php")
    ?>

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

        echo '<a href="ModifCompte.php">Éditer</a>';
    ?>

    <div id="historique-commandes">
        <h2>Historique des commandes</h2>
        
        <?php
            $req = $conn->prepare("SELECT BC.idBC, BC.dateBC, C.quantite, C.idArticle, A.nomArticle FROM BonCommande BC, Commander C, Article A WHERE BC.idBC = C.idBC AND C.idArticle = A.idArticle AND BC.idClient = :idClient;");
            $req->bindParam(':idClient', $idClient);
            $req->execute();

            while ($commande = $req->fetch(PDO::FETCH_ASSOC)) {
                echo '<p>Commande #' . $commande['idBC'] . ' - Date: ' . $commande['dateBC'] . '</p>';
                echo '<p>Article: ' . $commande['nomArticle'] . ' - Quantité: ' . $commande['quantite'] . '</p>';
            }
        ?>
    </div>

    <?php
        include("include/footer.php")
    ?>
    
</body>
</html>