<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <style>
        .product-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            text-align: center;
            width: calc(20% - 20px);
            box-sizing: border-box;
        }

        .product-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .filter-bar {
            display: none;
            background-color: #f8f8f8;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .filter-bar.submitted {
            display: block;
        }

        .filter-bar label {
            margin-right: 10px;
        }

        .filter-bar select,
        .filter-bar input {
            padding: 8px;
            margin-right: 10px;
        }

        .toggle-button {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ddd;
            margin: 10px;
        }
    </style>
    <title>SigmaPrime - Accueil</title>
</head>
<body>

    <?php
    include("include/header.php");
    ?>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once("connect.inc.php");

    if (isset($_GET['idCategorie'])) {
        $idCategorie = $_GET['idCategorie'];

        $reqCategorieMere = $conn->prepare("SELECT categorieMere FROM Categorie WHERE idCategorie = ?");
        $reqCategorieMere->execute([$idCategorie]);
        $categorieMere = $reqCategorieMere->fetchColumn();

        $triPrix = isset($_POST['triPrix']) ? $_POST['triPrix'] : 'prixCroissant';
        $prixMin = isset($_POST['prixMin']) ? floatval($_POST['prixMin']) : 0;
        $prixMax = isset($_POST['prixMax']) ? floatval($_POST['prixMax']) : 0;

        $selectedTailles = [];
        if (!empty($categorieMere) && $categorieMere == 'vetement') {
            if (isset($_POST['tailleM'])) {
                $selectedTailles[] = 'M';
            }
            if (isset($_POST['tailleL'])) {
                $selectedTailles[] = 'L';
            }
            if (isset($_POST['tailleXL'])) {
                $selectedTailles[] = 'XL';
            }
            if (isset($_POST['tailleS'])) {
                $selectedTailles[] = 'S';
            }
        }

        $reqNbArticlesCategorie = $conn->prepare("CALL getNbArticlesByCategorie(:id);");
        $reqNbArticlesCategorie->execute(['id'=>$idCategorie]);
        $nbArticlesCategorie = $reqNbArticlesCategorie->fetchColumn();
        $reqNbArticlesCategorie->closeCursor();
        echo $idCategorie . "(".$nbArticlesCategorie.")";

       
        echo '<div class="toggle-button" onclick="toggleFilterBar()">Trier</div>';
        echo '<div class="filter-bar">';
        echo '  <form method="post" action="" onsubmit="onSubmitForm()">';
        echo '      <label for="triPrix">Trier par prix :</label>';
        echo '      <select name="triPrix" id="triPrix">';
        echo '          <option value="prixCroissant" ' . ($triPrix === 'prixCroissant' ? 'selected' : '') . '>Prix croissant</option>';
        echo '          <option value="prixDecroissant" ' . ($triPrix === 'prixDecroissant' ? 'selected' : '') . '>Prix décroissant</option>';
        echo '          <option value="prixPersonnalise" ' . ($triPrix === 'prixPersonnalise' ? 'selected' : '') . '>Prix personnalisé</option>';
        echo '      </select>';
        echo '      <br>';
        
        if (!empty($categorieMere) && $categorieMere == 'vetement') {
            echo '      <label for="tailles">Sélectionner les tailles :</label>';
            echo '      <br>';
            echo '      <input type="checkbox" name="tailleM" value="M" ' . (in_array('M', $selectedTailles) ? 'checked' : '') . '> M';
            echo '      <input type="checkbox" name="tailleL" value="L" ' . (in_array('L', $selectedTailles) ? 'checked' : '') . '> L';
            echo '      <input type="checkbox" name="tailleXL" value="XL" ' . (in_array('XL', $selectedTailles) ? 'checked' : '') . '> XL';
            echo '      <input type="checkbox" name="tailleS" value="S" ' . (in_array('S', $selectedTailles) ? 'checked' : '') . '> S';
            echo '      <br>';
        }
        echo '      <label for="prixMin">Prix minimum :</label>';
        echo '      <input type="number" name="prixMin" id="prixMin" placeholder="Entrez le prix minimum" value="' . $prixMin . '">';
        echo '      <br>';
        echo '      <label for="prixMax">Prix maximum :</label>';
        echo '      <input type="number" name="prixMax" id="prixMax" placeholder="Entrez le prix maximum" value="' . $prixMax . '">';
        echo '      <br>';
        echo '      <input type="submit" value="Trier">';
        echo '  </form>';
        echo '</div>';

        $conditionTaille = empty($selectedTailles) ? '1' : 'taille IN ("' . implode('","', $selectedTailles) . '")';

        switch ($triPrix) {
            case 'prixCroissant':
                $orderPrix = 'prix ASC';
                break;
            case 'prixDecroissant':
                $orderPrix = 'prix DESC';
                break;
            case 'prixPersonnalise':
                $orderPrix = 'prix ASC';  
                break;
            default:
                $orderPrix = 'prix ASC';
                break;
        }

        $reqConsultArticles = $conn->prepare("SELECT DISTINCT * FROM Article WHERE categorie LIKE ? AND $conditionTaille ORDER BY $orderPrix");
        $reqConsultArticles->execute([$idCategorie]);

        echo "<div class='product-wrapper'>";

        while ($row = $reqConsultArticles->fetch()) {
            echo "<a href='DetailProduit.php?idArticle=" . $row["idArticle"] . "' class='product-container'>";
            echo "<h2>" . $row["nomArticle"] . "</h2>";
            echo "<p>Prix : " . $row["prix"] . " €</p>";
            echo "<p>Taille : " . $row["taille"] . "</p>";

            $reqMoyenneAvis = $conn->prepare("SELECT AVG(note) AS moyenneAvis FROM Evaluation WHERE idArticle = ?");
            $reqMoyenneAvis->execute([$row["idArticle"]]);
            $moyenneAvis = $reqMoyenneAvis->fetchColumn();

            echo "<p>Moyenne des avis : " . ($moyenneAvis ? number_format($moyenneAvis, 1) : "Aucun avis") . "</p>";

            echo "</a>";
        }

        echo "</div>";
    } else {
        echo "ID de catégorie non spécifié.";
    }
    ?>

    <?php
    include("include/footer.php");
    ?>

    <script>
        function toggleFilterBar() {
            var filterBar = document.querySelector('.filter-bar');
            filterBar.style.display = (filterBar.style.display === 'none' || filterBar.style.display === '') ? 'block' : 'none';
        }

        function onSubmitForm() {
            var filterBar = document.querySelector('.filter-bar');
            filterBar.classList.add('submitted');
        }
    </script>

</body>
</html>
