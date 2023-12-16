<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Modifier le compte</title>
</head>
<body>

    <?php include("include/header.php") ?>

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

    <div class="modif-compte-container">
        <h1>Modifier les <br>informations du compte</h1>

        <form action="TraitModifCompte.php" method="post">
        <?php
            if (isset($_GET['msgErreur'])) {
                echo '<p style="color: red;">' . htmlentities($_GET['msgErreur']) . '</p>';
            }
        ?>
            <div class="modif-form-field">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" value="<?php echo $infoCompte['nomClient']; ?>">
            </div>

            <div class="modif-form-field">
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" value="<?php echo $infoCompte['prenomClient']; ?>">
            </div>

            <div class="modif-form-field">
                <label for="email">Adresse e-mail :</label>
                <input type="text" name="email" value="<?php echo $infoCompte['emailClient']; ?>">
            </div>

            <div class="modif-form-field">
                <label for="telephone">Numéro de téléphone :</label>
                <input type="text" name="telephone" value="<?php echo $infoCompte['telephoneClient']; ?>">
            </div>

            <div class="modif-form-field">
                <label for="adresse">Adresse :</label>
                <input type="text" name="adresse" value="<?php echo $infoCompte['adresseRueClient']; ?>">
            </div>

            <div class="modif-form-field">
                <label for="codepostal">Code postal :</label>
                <input type="text" name="codepostal" value="<?php echo $infoCompte['codePostalClient']; ?>">
            </div>

            <div class="modif-form-field">
                <label for="ville">Ville :</label>
                <input type="text" name="ville" value="<?php echo $infoCompte['villeClient']; ?>">
            </div>

            <div class="modif-form-field">
                <label for="old_password">Mot de passe actuel :</label>
                <input type="password" name="old_password">
            </div>

            <div class="modif-form-field">
                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" name="new_password">
            </div>

            <input type="submit" value="Enregistrer les modifications">
        </form>
    </div>

    <?php include("include/footer.php") ?>
    
</body>
</html>
