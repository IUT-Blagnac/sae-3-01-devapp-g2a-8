<?php

include("connect.inc.php");

if (isset($_POST['idArticle'], $_POST['idClient'], $_POST['nomArticle'], $_POST['note'], $_POST['avis'])) {
    $idArticle = $_POST['idArticle'];
    $idClient = $_POST['idClient'];
    $nomArticle = $_POST['nomArticle'];
    $note = $_POST['note'];
    $avis = $_POST['avis'];

    $imageFileName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageFileName = "img/avis/idEval_" . $idClient . "_" . $idArticle . ".jpg"; // Utilisation de idClient + idArticle comme nom de fichier
        move_uploaded_file($_FILES['image']['tmp_name'], $imageFileName);
    }

    $req = $conn->prepare("INSERT INTO Evaluation (note, avis, dateEval, idArticle, idClient) VALUES (:note, :avis, NOW(), :idArticle, :idClient)");
    $req->bindParam(':note', $note);
    $req->bindParam(':avis', $avis);
    $req->bindParam(':idArticle', $idArticle);
    $req->bindParam(':idClient', $idClient);

    if ($req->execute()) {
        echo '<script language="JavaScript" type="text/javascript">';
        echo 'alert("Vous avez évalué l\'article avec succès !");';
        echo 'window.location.replace("HistoriqueCommandes.php");';
        echo '</script>';
    } else {
        echo '<script language="JavaScript" type="text/javascript">';
        echo 'alert("Une erreur est survenue.");';
        echo 'window.location.replace("HistoriqueCommandes.php");';
        echo '</script>';
    }
} else {
    echo "Erreur.";
}
?>
