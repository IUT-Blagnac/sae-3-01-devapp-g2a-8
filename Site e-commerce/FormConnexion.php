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

    <?php
        session_start();

        if (isset($_COOKIE["SigmaPrime_remember_me"])) {
            $email = $_COOKIE["SigmaPrime_remember_me"];
        } else {
            $email = '';
        }
    ?>

    <div class="login-container">
        <h1>Connexion à mon <br>espace SigmaPrime</h1>
        <form action="TraitConnexion.php" method="post">
        <?php
            if (isset($_GET['msgErreur'])) {
                echo '<p style="color: red;">' . htmlspecialchars($_GET['msgErreur']) . '</p>';
            }
        ?>
            <div class="form-field">
                <input type="text" name="email" required value="<?php echo $email; ?>" required>
                <span></span>
                <label>Adresse e-mail</label>
            </div>
            <div class="form-field">
                <input type="password" name="password" required>
                <span></span>
                <label>Mot de passe</label>
            </div>
            <div class="forgot-password">Mot de passe oublié ?</div>
            <input type="checkbox" name="remember_me" id="remember_me">Se souvenir de moi<br><br>
            <input type="submit" name="EnvoiLogin" value="Me connecter">
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