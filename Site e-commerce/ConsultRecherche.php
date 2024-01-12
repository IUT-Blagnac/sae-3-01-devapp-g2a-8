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
    <title>Résultats de la Recherche</title>
</head>
<body>

    <?php
    include("include/header.php");
    ?>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once("connect.inc.php");

    $searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

    $triPrix = isset($_POST['triPrix']) ? $_POST['triPrix'] : 'prixCroissant';
    $prixMin = isset($_POST['prixMin']) ? floatval($_POST['prixMin']) : 0;
    $prixMax = isset($_POST['prixMax']) ? floatval($_POST['prixMax']) : 0;

    $reqNbArticlesRecherche = $conn->prepare("SELECT COUNT(*) FROM Article WHERE nomArticle LIKE :searchTerm");
    $reqNbArticlesRecherche->execute(['searchTerm' => '%' . $searchTerm . '%']);
    $nbArticlesRecherche = $reqNbArticlesRecherche->fetchColumn();
    $reqNbArticlesRecherche->closeCursor();
    echo 'Résultats de la recherche pour "' . htmlspecialchars($searchTerm) . '" (' . $nbArticlesRecherche . ')';

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

    echo '      <label for="prixMin">Prix minimum :</label>';
    echo '      <input type="number" name="prixMin" id="prixMin" placeholder="Entrez le prix minimum" value="' . $prixMin . '">';
    echo '      <br>';
    echo '      <label for="prixMax">Prix maximum :</label>';
    echo '      <input type="number" name="prixMax" id="prixMax" placeholder="Entrez le prix maximum" value="' . $prixMax . '">';
    echo '      <br>';
    echo '      <input type="submit" value="Trier">';
    echo '  </form>';
    echo '</div>';

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

    $reqConsultArticles = $conn->prepare("SELECT * FROM Article WHERE nomArticle LIKE :searchTerm ORDER BY $orderPrix");
    $reqConsultArticles->execute(['searchTerm' => '%' . $searchTerm . '%']);

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
