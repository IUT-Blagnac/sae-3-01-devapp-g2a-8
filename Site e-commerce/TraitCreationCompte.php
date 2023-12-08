<?php

include("connect.inc.php");

if (!empty($_POST['EnvoiCreation']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['adresse']) && !empty($_POST['date']) && !empty($_POST['ville']) && !empty($_POST['codePostal']) && !empty($_POST['telephone']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
    if (
        isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) &&
        isset($_POST['adresse']) && isset($_POST['date']) && isset($_POST['ville']) &&
        isset($_POST['codePostal']) && isset($_POST['telephone']) && isset($_POST['password']) &&
        isset($_POST['confirmPassword'])
    ) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $adresse = $_POST['adresse'];
        $dateNaissance = date('Y-m-d', strtotime($_POST['date']));
        $ville = $_POST['ville'];
        $codePostal = $_POST['codePostal'];
        $telephone = $_POST['telephone'];
        $motDePasse = $_POST['password'];
        $confirmMotDePasse = $_POST['confirmPassword'];

        if(!is_numeric($codePostal)){
            header("Location: CreerCompte.php?msgErreur=Le code postal doit être composé de chiffres !");
            exit();
        }

        if(!is_numeric($telephone)){
            header("Location: CreerCompte.php?msgErreur=Le numéro de téléphone doit être composé de chiffres !");
            exit();
        }

        if ($motDePasse === $confirmMotDePasse) {
            $motDePasseChiffre = password_hash($motDePasse, PASSWORD_DEFAULT);

            $ptFidelite = 0;
            $civilite = 'H';
            $typeCompte = "C";

            $req = $conn->prepare("INSERT INTO Client (mdp, ptFidelite, civiliteClient, nomClient, prenomClient, adresseRueClient, codePostalClient, villeClient, telephoneClient, dtNaissanceClient, emailClient, typeCompte) VALUES (:mdp, :ptFidelite, :civilite, :nom, :prenom, :adresse, :codePostal, :ville, :telephone, :dateNaissance, :email, :typeCompte)");

            $req->bindParam(':mdp', $motDePasseChiffre);
            $req->bindParam(':ptFidelite', $ptFidelite);
            $req->bindParam(':civilite', $civilite);
            $req->bindParam(':nom', $nom);
            $req->bindParam(':prenom', $prenom);
            $req->bindParam(':adresse', $adresse);
            $req->bindParam(':codePostal', $codePostal);
            $req->bindParam(':ville', $ville);
            $req->bindParam(':telephone', $telephone);
            $req->bindParam(':dateNaissance', $dateNaissance);
            $req->bindParam(':email', $email);
            $req->bindParam(':typeCompte', $typeCompte);

            $req->execute();

            header("Location: index.php");

            exit();
        } else {
            header("Location: CreerCompte.php?msgErreur=Les mots de passe ne correspondent pas");
            exit();
        }
    } else {
        header("Location: CreerCompte.php?msgErreur=Tous les champs doivent être remplis");
        exit();
    }
} else {
    header("Location: CreerCompte.php");
    exit();
}
?>
