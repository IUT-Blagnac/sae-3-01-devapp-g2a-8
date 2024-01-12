<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>SigmaPrime - Admin Consultation Commandes</title>
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
        $req = $conn->prepare("SELECT idBC,dateBC,modePaiement,idLiv,nCB FROM BonCommande WHERE idClient = :id");
        $req->execute(['id' => $_GET['pIdClient']]);
        $result1 = $req->fetchAll();
        $req->closeCursor();
        $req2 = $conn->prepare("SELECT adresseLiv,codePostalLiv,villeLiv FROM AdrLivraison WHERE idAdrLiv = :id");
        $req3 = $conn->prepare("SELECT quantite,idArticle FROM Commander WHERE idBC = :id");
        $req4 = $conn->prepare("SELECT nomArticle FROM Article WHERE idARticle = :id");	
			foreach($result1 as $cle1) {
                echo "<center><table border='3' >";
			    echo "<tr><th>Date</th><th>Mode de Paiement</th><th>Livraison</th></tr>";
                $req2->execute(['id'=> $cle1[3]]);
                $result2 = $req2->fetchAll();
				echo "<tr>";
					echo "<td>".$cle1[1]."</td>";
					echo "<td>".$cle1[2]."</td>";
					echo "<td>".$result2[0]['adresseLiv']. "  " .$result2[0]['villeLiv'].", ".$result2[0]['codePostalLiv']."</td>";
				echo "</tr>";
                $req3->execute(['id'=> $cle1[0]]);
                $result3 = $req3->fetchAll();
                
                foreach($result3 as $cle2) {
                    $req4->execute(['id'=> $cle2["idArticle"]]);
                    $result4 = $req4->fetchAll();
                    echo "<tr>";
                        echo "<center><td colspan='3'>".$result4[0]["nomArticle"]."           Quantite : ".$cle2["quantite"]."</center></td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan='3'>Supprimer : <a href='SupprimerCommande.php?pIdBC=".$cle1[0]."'><img src='../img/croix_supprimer.png' alt='Supprimer' width='5%'></a></td></tr>";
                echo "</table></center>";
			}
		
		
    ?>
</body>

