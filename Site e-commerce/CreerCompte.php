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
        <form method="post">
            <div class="form-columns">
                <div class="form-column">
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Nom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Prénom</label>
                    </div>
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Adresse e-mail</label>
                    </div>
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Adresse</label>
                    </div>
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Date de naissance</label>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Ville</label>
                    </div>
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Code postal</label>
                    </div>
                    <div class="form-field">
                        <input type="text" required>
                        <span></span>
                        <label for="username">Téléphone</label>
                    </div>
                    <div class="form-field">
                        <input type="password" required>
                        <span></span>
                        <label for="password">Mot de passe</label>
                    </div>
                    <div class="form-field">
                        <input type="password" required>
                        <span></span>
                        <label for="password">Confirmer le mot de passe</label>
                    </div>
                </div>
            </div>

            <input type="submit" value="S'inscrire">
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
