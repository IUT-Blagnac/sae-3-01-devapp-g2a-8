<?php

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$users = Array();
for ($i = 0; $i < 100; $i++) {
    $users[$i]["Nom"] = $faker->lastName;
    $users[$i]["Prenom"] = $faker->firstName;
    $users[$i]["Adresse"] = $faker->streetAddress;
    $users[$i]["Ville"] = $faker->city;
    $users[$i]["CodePostal"] = (int)$faker->postcode;
    $users[$i]["Tel"] = $faker->phoneNumber;
    $users[$i]["DtnNaissance"] = $faker->date($format = 'Y-m-d', $max = '2005-00-00');
    $users[$i]["Mdp"] = password_hash($faker->password, PASSWORD_BCRYPT);
    $users[$i]["Mail"] = $faker->email;
    $users[$i]["Genre"] = substr(str_shuffle("FHN"), 0, 1);
    $users[$i]["TypeCompte"] = 'Client';
}

$strResult = "";

for ($i = 0; $i < 100; $i++) {
    $strResult = $strResult . "INSERT INTO Client VALUES (NULL,'".$users[$i]["Mdp"]."',0,'".$users[$i]["Genre"]."','".$users[$i]["Prenom"]."','".$users[$i]["Nom"]."','".$users[$i]["Adresse"]."',".$users[$i]["CodePostal"].",'".$users[$i]["Ville"]."','".$users[$i]["Tel"]."','".$users[$i]["DtnNaissance"]."','".$users[$i]["Mail"]."','Client'); \n";
};

$fichier = 'insertClients.sql';
$fDest = fopen($fichier, 'w');
fwrite($fDest, $strResult);

?>