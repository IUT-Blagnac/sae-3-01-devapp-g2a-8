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
    </style>
    <title>SigmaPrime - Accueil</title>
</head>
<body>

    <?php
    include("include/header.php")
    ?>
	
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once("connect.inc.php");
    

        // Formulaire de tri
        echo '<form method="post" action="">';
        echo '  <label for="tri">Trier par :</label>';
        echo '  <select name="tri" id="tri">';
        echo '      <option value="prixCroissant">Prix croissant</option>';
        echo '      <option value="prixDecroissant">Prix décroissant</option>';
        echo '      <option value="prixPersonnalise">Prix personnalisé</option>';
        echo '  </select>';
        echo '  <br>';
        echo '  <label for="prixMin">Prix minimum :</label>';
        echo '  <input type="number" name="prixMin" id="prixMin" placeholder="Entrez le prix minimum">';
        echo '  <br>';
        echo '  <label for="prixMax">Prix maximum :</label>';
        echo '  <input type="number" name="prixMax" id="prixMax" placeholder="Entrez le prix maximum">';
        echo '  <br>';
        echo '  <input type="submit" value="Trier">';
        echo '</form>';

        // Récupérer la valeur de tri
        $tri = isset($_POST['tri']) ? $_POST['tri'] : 'prixCroissant';

        switch ($tri) {
            case 'prixCroissant':
                $reqConsultArticles = $conn->prepare("SELECT DISTINCT * FROM Pack  ORDER BY prix ASC");
                break;
            case 'prixDecroissant':
                $reqConsultArticles = $conn->prepare("SELECT DISTINCT * FROM Pack ORDER BY prix DESC");
                break;
            case 'prixPersonnalise':
                $prixMin = isset($_POST['prixMin']) ? floatval($_POST['prixMin']) : 0;
                $prixMax = isset($_POST['prixMax']) ? floatval($_POST['prixMax']) : PHP_FLOAT_MAX;
                $reqConsultArticles = $conn->prepare("SELECT DISTINCT * FROM Pack WHERE  prix BETWEEN $prixMin AND $prixMax ");
                break;
            default:
                $reqConsultArticles = $conn->prepare("SELECT DISTINCT * FROM Pack ");
                break;
            }
        $reqConsultArticles->execute();

        echo "<div class='product-wrapper'>"; 

        
    while ($row = $reqConsultArticles->fetch()) {
        echo "<a href='DetailPack.php?idPack=" . $row["idPack"] . "' class='product-container'>";
        echo "<h2>" . $row["nomPack"] . "</h2>";
        echo "<p>Prix : " . $row["prix"] . " €</p>";
        echo "</a>";
    }


        echo "</div>"; 
    
    ?>

    <?php
    include("include/footer.php")
    ?>

</body>

 <script>
 function toggleChampsPrix() {
 var triSelect = document.getElementById("tri");
 var prixMinLabel = document.getElementById("prixMinLabel");
 var prixMinInput = document.getElementById("prixMin");
 var prixMaxLabel = document.getElementById("prixMaxLabel");
 var prixMaxInput = document.getElementById("prixMax");
 if (triSelect.value === "prixPersonnalise") {
 prixMinLabel.style.display = "block";
 prixMinInput.style.display = "block";
 prixMaxLabel.style.display = "block";
 prixMaxInput.style.display = "block";
 } else {
 prixMinLabel.style.display = "none";
 prixMinInput.style.display = "none";
prixMaxLabel.style.display = "none";
prixMaxInput.style.display = "none";
   }
 }
 
 </script>
</html>
