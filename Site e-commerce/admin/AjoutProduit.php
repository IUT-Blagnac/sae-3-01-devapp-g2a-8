<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin Ajout Client</title>
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
        echo "<form method='post'>";
            echo "<center><table border='3' >";
                 echo "<tr>";
                    echo"<td>Id</td>";
                    echo "<td><input type='text' name='id'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Nom</td>";
                    echo "<td><input type='text' name='nom'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Prix</td>";
                    echo "<td><input type='text' name='prix'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Catégorie</td>";
                    echo "<td><input type='text' name='categorie'></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<tr>";
                    echo"<td>Taille</td>";
                    echo "<td><input type='text' name='taille'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Stock</td>";
                    echo "<td><input type='text' name='stock'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Goût</td>";
                    echo "<td><input type='text' name='gout'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Couleur</td>";
                    echo "<td><input type='text' name='couleur'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Regroupement</td>";
                    echo "<td><input type='text' name='regroupement'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Article Apparenté</td>";
                    echo "<td><input type='text' name='artApparente'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Description</td>";
                    echo "<td><input type='text' name='description'></td>";
                echo "</tr>";
            echo "</table>";
            echo "</br><input type='submit' value='Valider' name = 'Valider' />";
            echo"</center>";
        echo"</form>";
        if (isset($_POST['Valider'])){
            if(isset($_POST['nom']) AND isset($_POST['prix'])AND isset($_POST['categorie'])AND isset($_POST['description'])){
                if (empty($_POST['stock'])){
                    $_POST['stock'] = 0;
                }
                if (!empty($_POST['regroupement'])){
                    $_POST['regroupement'] = "'".$_POST['regroupement']."'";
                }else{
                    $_POST['regroupement'] = 'NULL';
                }
                if (!empty($_POST['artApparente'])){
                    $_POST['artApparente'] = "'".$_POST['artApparente']."'";
                }else{
                    $_POST['artApparente'] = 'NULL';
                }
                echo "</br>";
                print( $_POST['regroupement']);
                echo "</br>";
                print( $_POST['artApparente']);
                echo "</br>";
                require_once("../connect.inc.php");
                print("INSERT INTO Article VALUES ('".$_POST['id']."','".$_POST['nom']."','".$_POST['taille']."','".$_POST['couleur']."','".$_POST['gout']."',".$_POST['prix'].",'".$_POST['description']."',".$_POST['stock'].",'".$_POST['categorie']."','".$_POST['regroupement']."','".$_POST['artApparente']."')");
                $req = $conn->prepare("INSERT INTO Article VALUES ('".$_POST['id']."','".$_POST['nom']."','".$_POST['taille']."','".$_POST['couleur']."','".$_POST['gout']."',".$_POST['prix'].",'".$_POST['description']."',".$_POST['stock'].",'".$_POST['categorie']."',".$_POST['regroupement'].",".$_POST['artApparente'].")");
                $req->execute();
                echo '<script language="JavaScript" type="text/javascript">
                    alert("Ajout effectué");
                    </script>';
                echo '<script language="JavaScript" type="text/javascript">
                window.location.replace("ConsultProduit.php?pIdArticle='.$_POST['id'].'");
                </script>'; 
            }
            else{
                echo '</br> </br> <h3>Le nom, le prix, la catégorie et la description doivent être renseignés</h3>';
            }
        }
        
    ?>
</body>

