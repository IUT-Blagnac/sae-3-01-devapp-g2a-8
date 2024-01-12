<?php
session_start();

include("connect.inc.php");

if (
    !isset($_POST['moyenPaiement']) || !isset($_POST['numeroCarte']) || !isset($_POST['dateExpirationMois']) ||
    !isset($_POST['dateExpirationAnnee']) || !isset($_POST['codeSecurite']) ||
    !isset($_POST['modeLivraison']) || !isset($_POST['adresseLivraison']) || !isset($_POST['codePostalLivraison']) ||
    !isset($_POST['villeLivraison'])
) {
    echo '<script>alert("Le paiement a échoué. Veuillez réessayer."); window.location.href = "Panier.php";</script>';
    exit();
}

$moyenPaiement = $_POST['moyenPaiement'];
$numeroCarte = $_POST['numeroCarte'];
$dateExpirationMois = $_POST['dateExpirationMois'];
$dateExpirationAnnee = $_POST['dateExpirationAnnee'];
$codeSecurite = $_POST['codeSecurite'];
$modeLivraison = $_POST['modeLivraison'];
$adresseLivraison = $_POST['adresseLivraison'];
$codePostalLivraison = $_POST['codePostalLivraison'];
$villeLivraison = $_POST['villeLivraison'];

try {
    $reqCBExistante = $conn->prepare("SELECT nCB FROM CarteBancaire WHERE nCB = :numeroCarte");
    $reqCBExistante->bindParam(':numeroCarte', $numeroCarte);
    $reqCBExistante->execute();
    $CBExistante = $reqCBExistante->fetch(PDO::FETCH_ASSOC);

    if ($CBExistante) {
        $idCarteBancaire = $CBExistante['nCB'];
    } else {
        $reqCB = $conn->prepare("INSERT INTO CarteBancaire (nCB, dateExp) VALUES (:numeroCarte, :dateExpiration)");
        $reqCB->bindParam(':numeroCarte', $numeroCarte);
        $reqCB->bindValue(':dateExpiration', "$dateExpirationAnnee-$dateExpirationMois-01");
        $reqCB->execute();
        $idCarteBancaire = $numeroCarte;
    }

    $reqAdrLivraison = $conn->prepare("INSERT INTO AdrLivraison (adresseLiv, codePostalLiv, villeLiv, idClient) VALUES (:adresseLivraison, :codePostalLivraison, :villeLivraison, :idClient)");
    $reqAdrLivraison->bindParam(':adresseLivraison', $adresseLivraison);
    $reqAdrLivraison->bindParam(':codePostalLivraison', $codePostalLivraison);
    $reqAdrLivraison->bindParam(':villeLivraison', $villeLivraison);
    $reqAdrLivraison->bindParam(':idClient', $_SESSION['SigmaPrime_idClient']);
    $reqAdrLivraison->execute();
    $idAdrLivraison = $conn->lastInsertId();

    $reqLivraison = $conn->prepare("INSERT INTO Livraison (modeLiv, fraisLiv) VALUES (:modeLivraison, :fraisLiv)");
    $reqLivraison->bindParam(':modeLivraison', $modeLivraison);
    $reqLivraison->bindValue(':fraisLiv', '0.01', PDO::PARAM_STR);
    $reqLivraison->execute();
    $idLivraison = $conn->lastInsertId();

    $reqBC = $conn->prepare("INSERT INTO BonCommande (dateBC, modePaiement, idClient, idLiv, nCB) VALUES (NOW(), :moyenPaiement, :idClient, :idLivraison, :idCarteBancaire)");
    $reqBC->bindParam(':moyenPaiement', $moyenPaiement);
    $reqBC->bindParam(':idClient', $_SESSION['SigmaPrime_idClient']);
    $reqBC->bindParam(':idLivraison', $idLivraison);
    $reqBC->bindParam(':idCarteBancaire', $idCarteBancaire);
    $reqBC->execute();
    $idBonCommande = $conn->lastInsertId();

    if (isset($_SESSION['SigmaPrime_panier']) && !empty($_SESSION['SigmaPrime_panier'])) {
        foreach ($_SESSION['SigmaPrime_panier'] as $idProduit => $produit) {
            $quantiteProduit = $produit['quantite'];

            $reqCommander = $conn->prepare("INSERT INTO Commander (quantite, idBC, idArticle) VALUES (:quantite, :idBonCommande, :idProduit)");
            $reqCommander->bindParam(':quantite', $quantiteProduit);
            $reqCommander->bindParam(':idBonCommande', $idBonCommande);
            $reqCommander->bindParam(':idProduit', $idProduit);
            $reqCommander->execute();
        }
    }

    header("Location: index.php");
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    echo '<script>alert("Le paiement a échoué. Veuillez réessayer."); window.location.href = "Panier.php";</script>';
}
?>
