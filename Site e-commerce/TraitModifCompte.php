<?php
session_start();

if (!isset($_SESSION['SigmaPrime_acces']) && $_SESSION['SigmaPrime_acces'] !== "oui") {
    header('Location: FormConnexion.php');
    exit();
}

include("connect.inc.php");

$updatePassword = false;

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['telephone']) && isset($_POST['adresse']) && isset($_POST['codepostal']) && isset($_POST['ville'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $codePostal = $_POST['codepostal'];
    $ville = $_POST['ville'];

    $idClient = $_SESSION['SigmaPrime_idClient'];

    $req = $conn->prepare("SELECT COUNT(*) as count FROM Client WHERE emailClient = :email AND idClient != :id");
    $req->bindParam(':email', $email);
    $req->bindParam(':id', $idClient);
    $req->execute();
    $count = $req->fetch(PDO::FETCH_ASSOC)['count'];

    if ($count > 0) {
        header('Location: ModifCompte.php?msgErreur=L\'adresse e-mail est déjà utilisée par un autre compte.');
        exit();
    }

    $req = $conn->prepare("SELECT mdp FROM Client WHERE idClient = :id");
    $req->bindParam(':id', $idClient);
    $req->execute();
    $infoCompte = $req->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST['old_password']) && password_verify($_POST['old_password'], $infoCompte['mdp']) && !empty($_POST['new_password'])) {
        $updatePassword = true;
    } else {
        if (!empty($_POST['new_password'])) {
            header('Location: ModifCompte.php?msgErreur=Le mot de passe actuel est incorrect');
            exit();
        }
    }

    $req = $conn->prepare("UPDATE Client SET nomClient=:nom, prenomClient=:prenom, emailClient=:email, telephoneClient=:telephone, adresseRueClient=:adresse, codePostalClient=:codePostal, villeClient=:ville WHERE idClient=:id");
    $req->bindParam(':nom', $nom);
    $req->bindParam(':prenom', $prenom);
    $req->bindParam(':email', $email);
    $req->bindParam(':telephone', $telephone);
    $req->bindParam(':adresse', $adresse);
    $req->bindParam(':codePostal', $codePostal);
    $req->bindParam(':ville', $ville);
    $req->bindParam(':id', $idClient);
    $req->execute();

    if ($updatePassword && !empty($_POST['new_password'])) {
        $newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $req = $conn->prepare("UPDATE Client SET mdp=:mdp WHERE idClient=:id");
        $req->bindParam(':mdp', $newPasswordHash);
        $req->bindParam(':id', $idClient);
        $req->execute();
    }

    header('Location: Compte.php');
    exit();
} else {
    header('Location: Compte.php');
    exit();
}
?>
