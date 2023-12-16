<?php
    session_start();
?>

<header>
    <?php
        require_once("connect.inc.php");
        ?>
    <div id="header-left">
        <a href="index.php">
            <img src="img/SigmaPrime_Logo.png" alt="Logo SigmaPrime">
        </a>
        <nav>
            <ul class="main-menu">
            
            <?php
                $reqNutr = "SELECT idCategorie, nomCategorie FROM Categorie WHERE categorieMere= 'nutr'";
               
                $result = $conn->query($reqNutr);
            ?>
            
            <li>
                <a href="#">Nutrition</a>
                <ul class="menu-deroulant">
            <?php
                while ($row = $result->fetch()) {
                echo "<li><a href='ConsultProduit.php?idCategorie=" . $row['idCategorie'] . "'>" . $row['nomCategorie'] . "</a></li>";
                }
            ?>
            </ul>
            </li>
            
            <?php
                $reqComplement = "SELECT idCategorie, nomCategorie FROM Categorie WHERE categorieMere= 'complement'";
               
                $result = $conn->query($reqComplement);
            ?>
            
            <li>
                <a href="#">Compléments</a>
                <ul class="menu-deroulant">
            <?php
                while ($row = $result->fetch()) {
                echo "<li><a href='ConsultProduit.php?idCategorie=" . $row['idCategorie'] . "'>" . $row['nomCategorie'] . "</a></li>";
                }
            ?>
            </ul>
            </li>
            
            <?php
                $reqVetements = "SELECT idCategorie, nomCategorie FROM Categorie WHERE categorieMere= 'vetement'";
               
                $result = $conn->query($reqVetements);
            ?>
            
            <li>
                <a href="#">Vêtements</a>
                <ul class="menu-deroulant">
            <?php
                while ($row = $result->fetch()) {
                echo "<li><a href='ConsultProduit.php?idCategorie=" . $row['idCategorie'] . "'>" . $row['nomCategorie'] . "</a></li>";
                }
            ?>
            </ul>
            </li>
            
            <?php
                $reqConseil = "SELECT idCategorie, nomCategorie FROM Categorie WHERE categorieMere= 'conseil'";
               
                $result = $conn->query($reqConseil);
            ?>
            
            <li>
                <a href="#">Conseil</a>
                <ul class="menu-deroulant">
            <?php
                while ($row = $result->fetch()) {
                echo "<li><a href='ConsultProduit.php?idCategorie=" . $row['idCategorie'] . "'>" . $row['nomCategorie'] . "</a></li>";
                }
            ?>
            </ul>
            </li>
            
        </ul>

        </nav>
    </div>
    <div id="header-right">
        <input type="text" placeholder="Rechercher...">
        <a href="Panier.php">
            <img src="img/panier.png" alt="Logo Panier"  class="white-background">
        </a>
        <a href="FormConnexion.php">
            <?php
                if (isset($_SESSION['SigmaPrime_acces']) && $_SESSION['SigmaPrime_acces'] == "oui") {
                    echo '<a href="Compte.php"><img src="img/compte.png" alt="Logo Compte" class="white-background"></a>';
                    echo '<a href="Deconnexion.php"><img src="img/logout.png" alt="Logo Déconnexion" class="white-background"></a>';
                    if (isset($_SESSION['SigmaPrime_admin']) && $_SESSION['SigmaPrime_admin'] == "Admin") {
                        echo '<a href="./admin/Admin.php"><img src="img/admin.png" alt="Logo Administration" class="white-background"></a>';
                    }
                } else {
                    echo '<a href="FormConnexion.php"><img src="img/identification.png" alt="Logo Identification" class="white-background"></a>';
                }
            ?>
        </a>
    </div>
</header>