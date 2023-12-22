<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin Consultation Article</title>
</head>
<style>
        body {
            font-size: 90%;
        }

        td {
            text-align: center; 
        }


</style>
<body>
    <?php
        include("../include/header.php");
        if (!isset($_SESSION['SigmaPrime_admin']) || $_SESSION['SigmaPrime_admin'] !== "Admin") {
            header('Location: ../index.php');
            exit();
        }
    ?>
    <?php
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
        require_once("../connect.inc.php");
        $req = $conn->prepare("SELECT * FROM Article WHERE idArticle = '".$_GET['pIdArticle']."'");
        $req->execute();
        $result = $req->fetchAll();
        echo "<center><table border='3' >";
			echo "<tr><th>id</th><th>Nom</th><th>Prix</th><th>Categorie</th><th>Taille</th><th>Couleur</th><th>Goût</th><th>Stock</th><th>Regroupement</th><th>Article Apparenté</th></tr>";	
			foreach($result as $cle) {
				echo "<tr>";
					echo "<td>".$cle[0]."</td>";
					echo "<td>".$cle[1]."</td>";
					echo "<td>".$cle[5]."</td>";
                    echo "<td>".$cle[8]."</td>";
                    echo "<td>".$cle[2]."</td>";
                    echo "<td>".$cle[3]."</td>";
                    echo "<td>".$cle[4]."</td>";
                    echo "<td>".$cle[7]."</td>";
                    echo "<td>".$cle[9]."</td>";
                    echo "<td>".$cle[10]."</td>";
				echo "</tr>";
			}
            echo"</table>";
        echo "</br>";
        echo "</br>";
        echo "<strong>Description de l'article : </strong>";
        echo $cle[6];
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "Modifier cet article : <a href='ModifProduit.php?pIdArticle=".$_GET['pIdArticle']."'><img src='../img/bouton_modifier.png' alt='Modifier' width='5%'></a>";
        echo "Supprimer : <a href='SupprimerProduit.php?pIdArticle=".$_GET['pIdArticle']."'><img src='../img/croix_supprimer.png' alt='Supprimer' width='5%'></a>";
        echo "</center>";
    ?>
</body>

