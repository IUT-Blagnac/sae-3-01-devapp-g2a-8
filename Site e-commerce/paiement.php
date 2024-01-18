<?php
session_start();

if (!isset($_SESSION['SigmaPrime_acces']) || $_SESSION['SigmaPrime_acces'] !== "oui") {
    header('Location: FormConnexion.php');
    exit();
}

include("PanierController.php");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/paiement.css">
    <title>Paiement - SigmaPrime</title>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h2>Informations de paiement</h2>
            <form id="paiementForm" method="post" action="ValiderPaiement.php">
                <label for="moyenPaiement">Moyen de paiement :</label>
                <select id="moyenPaiement" name="moyenPaiement" onchange="activerChampsCB()">
                    <option value="cb">Carte Bancaire</option>
                    <option value="paypal">PayPal</option>
                </select>

                <div class="cb-fields">
                    <label for="numeroCarte">Numéro de carte :</label>
                    <input type="text" id="numeroCarte" name="numeroCarte" placeholder="XXXX-XXXX-XXXX-XXXX" required pattern="\d{16}" inputmode="numeric">

                    <div class="flex">
                        <div class="flex-1">
                            <label for="dateExpirationMois">Mois d'expiration :</label>
                            <input type="text" id="dateExpirationMois" name="dateExpirationMois" placeholder="MM" required pattern="(0[1-9]|1[0-2])" inputmode="numeric">
                        </div>
                        <div class="flex-1">
                            <label for="dateExpirationAnnee">Année d'expiration :</label>
                            <input type="text" id="dateExpirationAnnee" name="dateExpirationAnnee" placeholder="YY" required pattern="\d{2}" inputmode="numeric">
                        </div>
                    </div>

                    <label for="codeSecurite">Code de sécurité :</label>
                    <input type="text" id="codeSecurite" name="codeSecurite" placeholder="123" required pattern="\d{3}" inputmode="numeric">
                </div>

                <br><br><br><br>
                <label for="modeLivraison">Mode de livraison :</label>
                <select id="modeLivraison" name="modeLivraison">
                    <option value="standard">Standard</option>
                    <option value="express">Express</option>
                </select>

                <br><br>
                <label for="adresseLivraison">Adresse de livraison :</label>
                <input type="text" id="adresseLivraison" name="adresseLivraison" placeholder="Adresse de livraison" required>
                <br><br>
                <label for="codePostalLivraison">Code postal de livraison :</label>
                <input type="text" id="codePostalLivraison" name="codePostalLivraison" placeholder="Code postal" required pattern="\d{5}" inputmode="numeric">
                <br><br>
                <label for="villeLivraison">Ville de livraison :</label>
                <input type="text" id="villeLivraison" name="villeLivraison" placeholder="Ville de livraison" required>
                <br><br>
                <a href="Panier.php" class="back-button">Retour</a>
                <button class="next-button" type="button" onclick="validerFormulaire()">Payer</button>
            </form>
        </div>

        <div class="right-panel">
            <h2>Récapitulatif de la commande</h2>
            <ul>
                <?php
                foreach ($_SESSION['SigmaPrime_panier'] as $idProduit => $produit) {
                    echo '<li>' . $produit['nomArticle'] . ' - x' . $produit['quantite'] . '</li>';
                }
                ?>
            </ul>
            <p>Prix total : <?php echo prixTotal($_SESSION['SigmaPrime_panier']); ?> €</p>
        </div>
    </div>

    <script>
        function activerChampsCB() {
            var moyenPaiement = document.getElementById("moyenPaiement").value;
            var champsCB = document.querySelector(".cb-fields");

            if (moyenPaiement === "cb") {
                champsCB.style.display = "block";
            } else {
                champsCB.style.display = "none";
            }
        }

        function validerFormulaire() {
            var moyenPaiement = document.getElementById("moyenPaiement").value;
            var formulaire = document.getElementById("paiementForm");

            if (moyenPaiement === "cb") {
                var numeroCarte = document.getElementById("numeroCarte").value;
                var dateExpirationMois = document.getElementById("dateExpirationMois").value;
                var dateExpirationAnnee = document.getElementById("dateExpirationAnnee").value;
                var codeSecurite = document.getElementById("codeSecurite").value;

                if (!/^\d{16}$/.test(numeroCarte) || !/^(0[1-9]|1[0-2])$/.test(dateExpirationMois) || !/^\d{2}$/.test(dateExpirationAnnee) || !/^\d{3}$/.test(codeSecurite)) {
                    alert("Veuillez remplir correctement les champs de la carte bancaire.");
                    return;
                }
            }

            formulaire.submit();
        }

        activerChampsCB();
    </script>
</body>
</html>
