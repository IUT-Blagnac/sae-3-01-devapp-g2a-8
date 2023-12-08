<?php
    session_start();
?>

<header>
    <div id="header-left">
        <a href="index.php">
            <img src="img/SigmaPrime_Logo.png" alt="Logo SigmaPrime">
        </a>
        <nav>
            <ul class="main-menu">
            <li>
                <a href="#">Nutrition</a>
                <ul class="menu-deroulant">
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Compléments</a>
                <ul class="menu-deroulant">
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Vêtements</a>
                <ul class="menu-deroulant">
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Conseils sportifs</a>
                <ul class="menu-deroulant">
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                <li><a href="#">Texte</a></li>
                </ul>
            </li>
            </ul>
        </nav>
    </div>
    <div id="header-right">
        <input type="text" placeholder="Rechercher...">
        <a href="panier.php">
            <img src="img/panier.png" alt="Logo Panier"  class="white-background">
        </a>
        <a href="FormConnexion.php">
            <?php
                if (isset($_SESSION['SigmaPrime_acces']) && $_SESSION['SigmaPrime_acces'] == "oui") {
                    echo '<a href="Deconnexion.php"><img src="img/logout.png" alt="Logo Déconnexion" class="white-background"></a>';
                    if ($_SESSION['SigmaPrime_admin'] == "Admin") {
                        echo '<a href="Admin.php"><img src="img/admin.png" alt="Logo Administration" class="white-background"></a>';
                    }
                } else {
                    echo '<a href="FormConnexion.php"><img src="img/identification.png" alt="Logo Identification" class="white-background"></a>';
                }
            ?>
        </a>
    </div>
</header>