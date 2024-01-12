<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">

    <style>
        

        .privacy-policy {
            margin: 20px; 
        }
    </style>

    <title>SigmaPrime - Accueil</title>
</head>

<body>

    <?php
    include("include/header.php");
    ?>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once("connect.inc.php");
    ?>

    <div class="privacy-policy">
        <h2>Charte de Protection des Données Personnelles pour SigmaPrime</h2>

        <p>Bienvenue sur SigmaPrime. Nous nous engageons à protéger la confidentialité et la sécurité de vos données personnelles. Cette charte a pour objectif de vous informer sur la manière dont nous collectons, utilisons, partageons et protégeons vos données personnelles.</p>

        <h3>1. Collecte de Données Personnelles</h3>
        <p>Nous collectons des données personnelles lorsque vous interagissez avec notre site, que ce soit lors de la navigation, de l'inscription, de l'achat de produits ou de la souscription à des services. Ces données peuvent inclure, mais ne se limitent pas à, votre nom, votre adresse, votre adresse e-mail, votre numéro de téléphone, vos informations de paiement, et d'autres informations nécessaires à votre expérience sur notre site.</p>

        <h3>2. Utilisation des Données Personnelles</h3>
        <p>Nous utilisons vos données personnelles pour les finalités suivantes :</p>
        <ul>
            <li>Traitement de vos commandes et transactions.</li>
            <li>Personnalisation de votre expérience sur notre site.</li>
            <li>Communication avec vous concernant votre compte, vos commandes, et des offres promotionnelles.</li>
            <li>Amélioration de nos produits et services.</li>
            <li>Respect des obligations légales.</li>
        </ul>

        <h3>3. Partage des Données Personnelles</h3>
        <p>Nous ne partageons vos données personnelles qu'avec des tiers dans le cadre strictement nécessaire à la réalisation des finalités mentionnées ci-dessus. Cela peut inclure des prestataires de services tiers tels que des sociétés de traitement des paiements et des services de livraison.</p>

        <h3>4. Sécurité des Données</h3>
        <p>Nous prenons des mesures de sécurité techniques et organisationnelles appropriées pour protéger vos données personnelles contre tout accès non autorisé, altération, divulgation ou destruction.</p>

        <h3>5. Cookies et Technologies Similaires</h3>
        <p>Nous utilisons des cookies et des technologies similaires pour améliorer votre expérience de navigation sur notre site. Vous avez la possibilité de configurer vos préférences en matière de cookies dans les paramètres de votre navigateur.</p>

        <h3>6. Vos Droits</h3>
        <p>Vous avez le droit d'accéder à vos données personnelles, de les rectifier, de les supprimer, de vous opposer à leur traitement ou de demander leur portabilité. Pour exercer ces droits, veuillez nous contacter à l'adresse sigmaprime@gmail.com.</p>

        <h3>7. Modifications de la Charte de Protection des Données Personnelles</h3>
        <p>Nous nous réservons le droit de mettre à jour cette charte de protection des données personnelles à tout moment. Toute modification substantielle sera clairement indiquée sur notre site et prendra effet à la date de sa publication.</p>

        <h3>8. Contact</h3>
        <p>Pour toute question ou préoccupation concernant notre traitement de vos données personnelles, veuillez nous contacter à l'adresse sigmaprime@gmail.com.</p>

        <p>Merci de votre confiance.</p>
        <p>Cordialement,</p>
        <p>L'équipe de SigmaPrime</p>
    </div>

    <?php
    include("include/footer.php");
    ?>

</body>

</html>
