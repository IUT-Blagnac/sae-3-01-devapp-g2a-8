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
        $req = $conn->prepare("SELECT idClient,mdp,ptFidelite,civiliteClient,nomClient,prenomClient,adresseRueClient,codePostalClient,villeClient,telephoneClient,dtNaissanceClient,emailClient,typeCompte FROM Client WHERE idClient = :id");
        $req->execute(['id' => $_GET['pIdClient']]);
        $result = $req->fetchAll();
        echo "<center><table border='3' >";
			echo "<tr><th>Nom</th><th>Prénom</th><th>E-Mail</th><th>Civilite</th><th>Adresse</th><th>Code Postal</th><th>Ville</th><th>Telephone</th><th>Date de Naissance</th></tr>";	
			foreach($result as $cle) {
				echo "<tr>";
					echo "<td>".$cle[4]."</td>";
					echo "<td>".$cle[5]."</td>";
					echo "<td>".$cle[11]."</td>";
                    echo "<td>".$cle[3]."</td>";
                    echo "<td>".$cle[6]."</td>";
                    echo "<td>".$cle[7]."</td>";
                    echo "<td>".$cle[8]."</td>";
                    echo "<td>".$cle[9]."</td>";
                    echo "<td>".$cle[10]."</td>";
				echo "</tr>";
			}
		echo "</table></center>";
		echo "</br>";
        echo "<center>";
        echo "Modifier : <a href='ModifClient.php?pIdClient=".$_GET['pIdClient']."'><img src='../img/bouton_modifier.png' alt='Modifier' width='5%'></a>";
        echo "</center>";
    ?>
</body>

