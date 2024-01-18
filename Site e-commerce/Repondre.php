<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>SigmaPrime - Répondre</title>
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

        $req = $conn->prepare("SELECT e.*, c.prenomClient FROM Evaluation e, Client c WHERE e.idClient = c.idClient AND e.idEval = ?");
        $req->execute([$idEval]);
        $avisInitial = $req->fetch();
    ?>

    <button class='button' onclick="history.back()">Retour</button>

    <div class="reponse">
        <form action='TraitReponse.php' method='post'>
            <input type='hidden' name='idEval' value='<?= $idEval ?>'>

            <label class='reponse-label' for='avis_initial'>Avis de <?= $avisInitial['prenomClient'] ?></label>
            <p class='reponse-note'>Note : <?= $avisInitial['note'] ?> / 5</p>
            <p class='reponse-commentaire'>Commentaire : <?= $avisInitial['avis'] ?></p>

            <label class='reponse-label' for='reponse'>Votre réponse :</label>
            <textarea class='reponse-textarea' name='reponse' rows='4' cols='50'></textarea>
            <input class='reponse-submit' type='submit' value='Répondre'>
        </form>
    </div>

    <?php
        include("include/footer.php");
    ?>
</body>
</html>
