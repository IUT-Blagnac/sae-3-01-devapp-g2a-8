<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/formulaire.css">
    <title>SigmaPrime - Authentification</title>
</head>
<body>
    <?php
        include("include/header.php")
    ?>
    <div class="login-container">
        <h1>Connexion à mon <br>espace SigmaPrime</h1>
        <form method="post">
            <div class="form-field">
                <input type="text" required>
                <span></span>
                <label for="username">Adresse e-mail</label>
            </div>
            <div class="form-field">
                <input type="password" required>
                <span></span>
                <label for="password">Mot de passe</label>
            </div>
            <div class="forgot-password">Mot de passe oublié ?</div>
            <input type="submit" value="Me connecter">
            <div class="signup-link">
                Vous n'avez pas de compte ? <a href="CreerCompte.php">Créez-en un !</a>
            </div>
        </form>
    </div>
    
    <?php
        include("include/footer.php")
    ?>
</body>
</html>

