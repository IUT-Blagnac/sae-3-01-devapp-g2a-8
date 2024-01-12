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

        table {
            width: 35%;
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
    
        echo "<form method='post'>";
            echo "<center><table border='3' >";
                echo "<tr>";
                    echo"<td>Identifiant</td>";
                    echo "<td>".$result[0]["idArticle"]."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Nom</td>";
                    echo "<td><input type='text' name='nom' value='".$result[0]["nomArticle"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Prix</td>";
                    echo "<td><input type='text' name='prix' value='".$result[0]["prix"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Categorie</td>";
                    echo "<td><input type='text' name='categorie' value='".$result[0]["categorie"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Taille</td>";
                    echo "<td><input type='text' name='taille' value='".$result[0]["taille"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Couleur</td>";
                    echo "<td><input type='text' name='couleur' value='".$result[0]["couleur"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Goût</td>";
                    echo "<td><input type='text' name='gout' value='".$result[0]["gout"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Stock</td>";
                    echo "<td><input type='text' name='stock' value='".$result[0]["stock"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Regroupement</td>";
                    echo "<td><input type='text' name='regroupement' value='".$result[0]["regroupement"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Article Apparenté (id)</td>";
                    echo "<td><input type='text' name='artApparente' value='".$result[0]["articleApparente"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Description</td>";
                    echo "<td><textarea name='description' rows='4' cols='60'>".$result[0]["description"]."</textarea> </td>";
                echo "</tr>";
            echo "</table>";
            echo "</br><input type='submit' value='Valider' name = 'Valider' />";
            echo"</center>";
        echo"</form>";

        echo"<center>";
        if (isset($_POST['Valider'])){
            if(isset($_POST['nom']) AND isset($_POST['prix'])AND isset($_POST['categorie'])AND isset($_POST['description'])){
                
                $donneesChangees = false;
                if($_POST['nom'] != $result[0]["nomArticle"]){
                    $donneesChangees = true;
                    
                    $requeteNom = $conn->prepare("CALL updateArticle(:id, 'nomArticle', '".$_POST['nom']."')");
                    $requeteNom->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['prix'] != $result[0]["prix"]){
                    $donneesChangees = true;
                    
                    $requetePrix = $conn->prepare("CALL updateArticlePrixStock(:id, 'prix', ".$_POST['prix'].")");
                    $requetePrix->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['taille'] != $result[0]["taille"]){
                    $donneesChangees = true;
                    
                    $requeteTaille = $conn->prepare("CALL updateArticle(:id, 'taille', '".$_POST['taille']."')");
                    $requeteTaille->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['categorie'] != $result[0]["categorie"]){
                    $donneesChangees = true;
                    
                    $requeteCategorie = $conn->prepare("CALL updateArticle(:id, 'categorie', '".$_POST['categorie']."')");
                    $requeteCategorie->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['gout'] != $result[0]["gout"]){
                    $donneesChangees = true;
                    
                    $requeteGout = $conn->prepare("CALL updateArticle(:id, 'gout', '".$_POST['gout']."')");
                    $requeteGout->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['stock'] != $result[0]["stock"]){
                    $donneesChangees = true;
                    
                    $requeteGout = $conn->prepare("CALL updateArticlePrixStock(:id, 'stock', '".$_POST['stock']."')");
                    $requeteGout->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['couleur'] != $result[0]["couleur"]){
                    $donneesChangees = true;
                    
                    $requeteCouleur = $conn->prepare("CALL updateArticle(:id, 'couleur', '".$_POST['couleur']."')");
                    $requeteCouleur->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['regroupement'] != $result[0]["regroupement"]){
                    $donneesChangees = true;
                    
                    $requeteRegroupement = $conn->prepare("CALL updateArticle(:id, 'regroupement', '".$_POST['regroupement']."')");
                    $requeteRegroupement->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['artApparente'] != $result[0]["articleApparente"]){
                    $donneesChangees = true;
                    
                    $requeteArtApparente = $conn->prepare("CALL updateArticle(:id, 'articleApparente', '".$_POST['artApparente']."')");
                    $requeteArtApparente->execute(['id'=>$_GET['pIdArticle']]);
                }
                if($_POST['description'] != $result[0]["description"]){
                    $donneesChangees = true;
                    
                    $requeteDescription = $conn->prepare("CALL updateArticle(:id, 'description', '".$_POST['description']."')");
                    $requeteDescription->execute(['id'=>$_GET['pIdArticle']]);
                }
    
                if($donneesChangees){
                    echo '<script language="JavaScript" type="text/javascript">
                            alert("Modification effectuée");
                            </script>';
                            echo '<script language="JavaScript" type="text/javascript">
                            window.location.replace("ConsultProduit.php?pIdArticle='.$_GET['pIdArticle'].'");
                            </script>'; 
                }
                else{
                    echo "</br> </br> <h3>Veuillez changer un des champs afin de modifier les informations de l'article</h3>";
                }
                
            }
            else{
                echo '</br> </br> <h3>Le nom, le prix, la catégorie et la description doivent être renseignés</h3>';
            }
            echo"</center>";
        }
    ?>
</body>

