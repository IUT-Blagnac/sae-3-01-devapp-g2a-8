<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin Gestion Articles</title>
</head>
<body>
    <?php
        include("../include/header.php");
        
        if (!isset($_SESSION['SigmaPrime_admin']) || $_SESSION['SigmaPrime_admin'] !== "Admin") {
            header('Location: ../index.php');
            exit();
        }

        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
        require_once("../connect.inc.php");
        $req = $conn->prepare("SELECT * FROM Article");
        $req->execute();
        $result = $req->fetchAll();
        echo "<center><table border='3' >";
			echo "<tr><th>id</th><th>Nom</th><th>Prix</th><th>Categorie</th></tr>";	
			foreach($result as $cle) {
				echo "<tr>";
					echo "<td>".$cle[0]."</td>";
					echo "<td>".$cle[1]."</td>";
					echo "<td>".$cle[5]."</td>";
                    echo "<td>".$cle[8]."</td>";
                    echo "<td><a href='ConsultProduit.php?pIdArticle=".$cle[0]."'>Détails article</a></td>";
				echo "</tr>";
			}
		echo "</table></center>";
		echo "</br>";
        echo "<center>";
        echo "Ajouter un article : <a href='AjoutProduit.php'><img src='../img/ajouter.png' alt='Ajouter' width='5%'></a>";
        echo "</center>";

        include("../include/footer.php");
    ?>
</body>

