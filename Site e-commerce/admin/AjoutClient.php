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
                    echo"<td>Nom</td>";
                    echo "<td><input type='text' name='nom'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Prénom</td>";
                    echo "<td><input type='text' name='prenom'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>E-Mail</td>";
                    echo "<td><input type='text' name='email'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Mot de Passe</td>";
                    echo "<td><input type='text' name='mdp'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Civilite</td>";
                    echo "<td><input type='text' name='civilite'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Adresse</td>";
                    echo "<td><input type='text' name='adr'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Ville</td>";
                    echo "<td><input type='text' name='ville'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Code Postal</td>";
                    echo "<td><input type='text' name='codePostal'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Telephone</td>";
                    echo "<td><input type='text' name='tel'></td>";
                echo "</tr>";
                echo "<tr>";
                    echo"<td>Date de Naissance</td>";
                    echo "<td><input type='text' name='dtn'></td>";
                echo "</tr>";
            echo "</table>";
            echo "</br><input type='submit' value='Valider' name = 'Valider' />";
            
        echo"</form>";
        if (isset($_POST['Valider'])){
            if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email'])AND !empty($_POST['civilite'])AND !empty($_POST['adr'])AND !empty($_POST['ville'])AND !empty($_POST['codePostal'])AND !empty($_POST['tel'])AND !empty($_POST['dtn'])AND !empty($_POST['mdp'])){
                require_once("../connect.inc.php");
                $req = $conn->prepare("INSERT INTO Client VALUES (NULL,'".password_hash($_POST['mdp'], PASSWORD_BCRYPT)."',0,'".$_POST['civilite']."','".$_POST['prenom']."','".$_POST['nom']."','".$_POST['adr']."',".$_POST['codePostal'].",'".$_POST['ville']."','".$_POST['tel']."','".$_POST['dtn']."','".$_POST['email']."','Client'); ");
                $req->execute();
                echo '<script language="JavaScript" type="text/javascript">
                    alert("Ajout effectué");
                    </script>';
                echo '<script language="JavaScript" type="text/javascript">
                window.location.replace("GestionClients.php");
                </script>'; 
            }
            else{
                echo '</br> </br> <h3>Tous les champs doivent être remplis.</h3>';
            }
        }
        echo"</center>";
    ?>
</body>

