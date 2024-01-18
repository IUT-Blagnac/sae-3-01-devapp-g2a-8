<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styleDetail.css">
    <title>SigmaPrime - Réponses</title>
</head>
<body>
    <?php
        include("include/header.php");
        require_once("connect.inc.php");
    
        if (!isset($_GET['idEval'])) {
            header('Location: index.php');
            exit();
        }
        
        $idEval = $_GET['idEval'];
        
        $req = $conn->prepare("SELECT E.*, C.prenomClient FROM Evaluation E, Client C WHERE E.idClient = C.idClient AND E.idEval = :idEval");
        $req->bindParam(':idEval', $idEval);
        $req->execute();
        $avisInitial = $req->fetch();

        $reqReponses = $conn->prepare("SELECT R.*, C.prenomClient FROM ReponseEvaluation R, Client C WHERE R.idClient = C.idClient AND R.idEval = :idEval");
        $reqReponses->bindParam(':idEval', $idEval);
        $reqReponses->execute();        
    ?>

    <button class='button' onclick="history.back()">Retour</button>
    
    <?php
        echo '<div class="avis-container">';
        echo '<h2>Avis initial</h2>';
        echo '<div class="avis">';
        echo '<p><b>Avis de ' . $avisInitial['prenomClient'] . '</b></p>';
        echo '<p>Note : ' . $avisInitial['note'] . ' / 5</p>';
        echo '<p>Commentaire : ' . $avisInitial['avis'] . '</p>';
        echo '</div>';

        echo '<h2>Réponses à l\'évaluation</h2>';
        while ($reponse = $reqReponses->fetch()) {
            echo '<div class="avis">';
            echo '<p><b>Réponse de SigmaPrime</b></p>';
            echo '<p><i>' . $reponse['reponseClient'] . '</i></p>';
            echo '</div>';
        }

        echo '</div>';
    ?>

    <?php
        include("include/footer.php");
    ?>
</body>
</html>
