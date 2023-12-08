<?php
session_start();

include("connect.inc.php");

if (!empty($_POST['EnvoiLogin']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $req = $conn->prepare("SELECT emailClient, mdp, typeCompte FROM Client WHERE emailClient=:email");
    $req->bindParam(':email', $email);
    $req->execute();

    $user = $req->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['mdp'])){
        $_SESSION['SigmaPrime_acces'] = "oui";
        $_SESSION['SigmaPrime_login'] = htmlentities($email);

        if($user['typeCompte'] == "Admin"){
            $_SESSION['SigmaPrime_admin'] = "Admin";
        }

        if (isset($_POST['remember_me'])) {
            setcookie('SigmaPrime_remember_me', $email, time() + 900);
        }
        header("location: index.php");
        exit();
    } else {
        header("location: FormConnexion.php?msgErreur=L'adresse e-mail ou le mot de passe est incorrect !");
        exit();
    }
}
?>
