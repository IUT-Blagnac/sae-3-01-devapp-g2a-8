<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin Consultation Client</title>
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
        $req = $conn->prepare("SELECT idClient,mdp,ptFidelite,civiliteClient,nomClient,prenomClient,adresseRueClient,
        codePostalClient,villeClient,telephoneClient,dtNaissanceClient,emailClient,typeCompte FROM Client WHERE idClient = :id");
        $req->execute(['id' => $_GET['pIdClient']]);
        $result = $req->fetchAll();
      
        echo "<form method='post'>";
            echo "<center><table border='3' >";
                echo "<tr>";
                    echo"<td>Nom</td>";
                    echo "<td><input type='text' name='nom' value='".$result[0]["nomClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Prénom</td>";
                    echo "<td><input type='text' name='prenom' value='".$result[0]["prenomClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>E-Mail</td>";
                    echo "<td><input type='text' name='email' value='".$result[0]["emailClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Civilite</td>";
                    echo "<td><input type='text' name='civilite' value='".$result[0]["civiliteClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Adresse</td>";
                    echo "<td><input type='text' name='adr' value='".$result[0]["adresseRueClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Ville</td>";
                    echo "<td><input type='text' name='ville' value='".$result[0]["villeClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Code Postal</td>";
                    echo "<td><input type='text' name='codePostal' value='".$result[0]["codePostalClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Telephone</td>";
                    echo "<td><input type='text' name='tel' value='".$result[0]["telephoneClient"]."'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Date de Naissance</td>";
                    echo "<td><input type='text' name='dtn' value='".$result[0]["dtNaissanceClient"]."'></td>";
                echo "</tr>";
            echo "</table>";
            echo "</br><input type='submit' value='Valider' name = 'Valider' />";
            echo"</center>";
        echo"</form>";

        echo"<center>";
        if (isset($_POST['Valider'])){
            if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email'])AND !empty($_POST['civilite'])AND !empty($_POST['adr'])
            AND !empty($_POST['ville'])AND !empty($_POST['codePostal'])AND !empty($_POST['tel'])AND !empty($_POST['dtn'])){
                $donneesChangees = false;
                if($_POST['nom'] != $result[0]["nomClient"]){
                    $donneesChangees = true;
                    
                    $requeteNom = $conn->prepare("UPDATE Client SET nomClient = '".$_POST['nom']."' WHERE idClient = :id");
                    $requeteNomType->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['prenom'] != $result[0]["prenomClient"]){
                    $donneesChangees = true;
                    
                    $requetePrenom = $conn->prepare("UPDATE Client SET prenomClient = '".$_POST['prenom']."' WHERE idClient = :id");
                    $requetePrenom->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['email'] != $result[0]["emailClient"]){
                    $donneesChangees = true;
                    
                    $requeteMail = $conn->prepare("UPDATE Client SET emailClient = '".$_POST['email']."' WHERE idClient = :id");
                    $requeteMail->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['civilite'] != $result[0]["civiliteClient"]){
                    $donneesChangees = true;
                    
                    $requeteCivilite = $conn->prepare("UPDATE Client SET civiliteClient = '".$_POST['civilite']."' WHERE idClient = :id");
                    $requeteCivilite->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['adr'] != $result[0]["adresseRueClient"]){
                    $donneesChangees = true;
                    
                    $requeteAdr = $conn->prepare("UPDATE Client SET adresseClient = '".$_POST['adresse']."' WHERE idClient = :id");
                    $requeteAdr->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['ville'] != $result[0]["villeClient"]){
                    $donneesChangees = true;
                    
                    $requeteVille = $conn->prepare("UPDATE Client SET villeClient = '".$_POST['ville']."' WHERE idClient = :id");
                    $requeteVille->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['codePostal'] != $result[0]["codePostalClient"]){
                    $donneesChangees = true;
                    
                    $requeteCodeP = $conn->prepare("UPDATE Client SET codePostalClient = ".$_POST['codePostal']." WHERE idClient = :id");
                    $requeteCodeP->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['tel'] != $result[0]["telephoneClient"]){
                    $donneesChangees = true;
                    $requeteTel = $conn->prepare("UPDATE Client SET telephoneClient = '".$_POST['tel']."' WHERE idClient = :id");
                    $requeteTel->execute(['id'=>$_GET['pIdClient']]);
                }
                if($_POST['dtn'] != $result[0]["dtNaissanceClient"]){
                    $donneesChangees = true;
                    
                    $requeteDTN = $conn->prepare("UPDATE Client SET dtNaissanceClient = '".$_POST['dtn']."' WHERE idClient = :id");
                    $requeteDTN->execute(['id'=>$_GET['pIdClient']]);
                }
    
                if($donneesChangees){
                    echo '<script language="JavaScript" type="text/javascript">
                            alert("Modification effectuée !");
                            </script>';
                            echo '<script language="JavaScript" type="text/javascript">
                            window.location.replace("ConsultClient.php?pIdClient='.$_GET['pIdClient'].'");
                            </script>'; 
                }
                else{
                    echo "</br> </br> <h3>Veuillez changer un des champs afin de modifier les informations du client</h3>";
                }
                
            }
            else{
                echo '</br> </br> <h3>Tous les champs doivent être remplis.</h3>';
            }
            echo"</center>";
        }
    ?>
</body>

