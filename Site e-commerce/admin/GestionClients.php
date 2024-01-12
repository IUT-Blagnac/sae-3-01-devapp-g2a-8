<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin Gestion Clients</title>
</head>
<style>
        body {
            font-size: 90%;
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
        require_once("../connect.inc.php");
        $req = $conn->prepare("SELECT idClient,mdp,ptFidelite,civiliteClient,nomClient,prenomClient,adresseRueClient,codePostalClient,villeClient,telephoneClient,dtNaissanceClient,emailClient,typeCompte FROM Client WHERE typeCompte = 'Client'");
        $req->execute();
        $result = $req->fetchAll();
        
        echo "<center><table border='3' >";
			echo "<tr><th>Nom</th><th>Prénom</th><th>EMail</th></tr>";	
			foreach($result as $cle) {
				echo "<tr>";
					echo "<td>".$cle[4]."</td>";
					echo "<td>".$cle[5]."</td>";
					echo "<td>".$cle[11]."</td>";
                    echo "<td><a href='ConsultClient.php?pIdClient=".$cle[0]."'>Informations client</a></td>";
                    echo "<td><a href='ConsultCommandes.php?pIdClient=".$cle[0]."'>Commandes</a></td>";
				echo "</tr>";
			}
		echo "</table></center>";
		echo "</br>";
        echo "<center>";
        echo "Ajouter un client : <a href='AjoutClient.php'><img src='../img/ajouter.png' alt='AjoutClient' width='5%'></a>";
        echo "</center>";

        include("../include/footer.php");
    ?>
</body>

