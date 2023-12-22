<div id="sidebar" class="sidebar-offcanvas sidebar">
    <div style="padding-top: 30px;" class="col-md-12">
        <ul class="nav nav-pills flex-column">
            <?php
                $page = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
                
                echo '<div class="menu-container">';
                
                echo '<li class="menu-item">';
                if ($page == 'Compte.php') {
                    echo '<a class="menu-link active" href="Compte.php">Mes informations</a>';
                }
                else {
                    echo '<a class="menu-link" href="Compte.php">Mes informations</a>';
                }
                echo '</li>';
                
                
                echo '<li class="menu-item">';
                if ($page == 'HistoriqueCommandes.php') {
                    echo '<a class="menu-link active" href="HistoriqueCommandes.php">Voir l\'historique de mes commandes</a>';
                }
                else {
                    echo '<a class="menu-link" href="HistoriqueCommandes.php">Voir l\'historique de mes commandes</a>';
                }
                echo '</li>';
                
                echo '<li class="menu-item">';
                if ($page == 'Deconnexion.php') {
                    echo '<a class="menu-link active" href="Deconnexion.php">Déconnexion</a>';
                }
                else {
                    echo '<a class="menu-link" href="Deconnexion.php">Déconnexion</a>';
                }
                echo '</li>';
                
                echo '</div>';
            ?>
        </ul>
    </div>
</div>