<?php
session_start();

if (isset($_SESSION['SigmaPrime_acces']) || $_SESSION['SigmaPrime_acces'] == "oui") {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/formulaire.css">
    <title>SigmaPrime - Créer un compte</title>
</head>
<body>

    <?php
      include("include/header.php")
    ?>

    <div class="login-container">
        <h1>Créer un compte <br>SigmaPrime</h1>
        <form action="TraitCreationCompte.php" method="post">
        <?php
            if (isset($_GET['msgErreur'])) {
                echo '<p style="color: red;">' . htmlspecialchars($_GET['msgErreur']) . '</p>';
            }
        ?>
            <div class="form-columns">
                <div class="form-column">
                    <div class="form-field">
                        <input type="text" name="nom" required>
                        <span></span>
                        <label>Nom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="prenom" required>
                        <span></span>
                        <label>Prénom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="email" required>
                        <span></span>
                        <label>Adresse e-mail</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="adresse" required>
                        <span></span>
                        <label>Adresse</label>
                    </div>
                    <div class="form-field">
                        <input type="date" name="date" value="2000-01-01" required>
                        <span></span>
                        <label>Date de naissance</label>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-field">
                        <input type="text" name="ville" required>
                        <span></span>
                        <label>Ville</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="codePostal" required>
                        <span></span>
                        <label>Code postal</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="telephone" required>
                        <span></span>
                        <label>Téléphone</label>
                    </div>
                    <div class="form-field">
                        <input type="password" name="password" required>
                        <span></span>
                        <label>Mot de passe</label>
                    </div>
                    <div class="form-field">
                        <input type="password" name="confirmPassword" required>
                        <span></span>
                        <label>Confirmer le mot de passe</label>
                    </div>
                </div>
            </div>

            <input type="submit" name="EnvoiCreation" value="S'inscrire">
            <div class="signup-link">
                Vous avez déjà un compte ? <a href="FormConnexion.php">Connectez-vous !</a>
            </div>
        </form>
    </div>

    <?php
      include("include/footer.php")
    ?>

</body>
</html>
