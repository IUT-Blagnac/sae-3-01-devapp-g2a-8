<?php
    session_start();
    require_once("connect.inc.php");
    
    if (!isset($_POST['idEval']) || !isset($_POST['reponse']) || !isset($_SESSION['SigmaPrime_idClient'])) {
        header('Location: index.php');
        exit();
    }

    $idClient = $_SESSION['SigmaPrime_idClient'];
    
    $idEval = $_POST['idEval'];
    $reponse = $_POST['reponse'];
    
    $req = $conn->prepare("INSERT INTO ReponseEvaluation (idEval, idClient, reponseClient) VALUES (:idEval, :idClient, :reponseClient)");
    $req->bindParam(':idEval', $idEval);
    $req->bindParam(':idClient', $idClient);
    $req->bindParam(':reponseClient', $reponse);
    $req->execute();

    
    header('Location: index.php');
    exit();
?>