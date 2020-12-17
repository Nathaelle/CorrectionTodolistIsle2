<?php

// Porte d'entrée dans l'application == point d'entrée des données transmises pas l'utilisateur
// $toTemplate est la SEULE variable pour communiquer avec le contexte GLOBAL, donc le système de templates

// PLAN TYPE DE l'APPEL D'UNE ROUTE VIA GET (ici, notre paramètre de routage est identifié par la clé "route") :
//index.php?route=qquechose.....
//$_GET["route"] = "qquechose"

// Dans le cas où $_GET["route"] n'existe pas, je doit définir une route par défaut
// if(!isset($_GET["route"])) {
//     $_GET["route"] = "accueil";
// }
// Notation simplifiée (permet d'éviter une erreur de routage dans le cas où l'on ne transmet pas de route via GET) :
$route = (isset($_GET["route"]))? $_GET["route"] : "accueil";

// -----------------------------------------------------------------------------------------------------
// ROUTER
// Pour chaque nouvelle fonctionnalité => nouveau case

// Liste des routes : 
// Par défaut : Affichage de la page d'accueil
// index.php?route=accueil => Affichage de la page d'accueil
// index.php?route=insertuser => Ajout d'un nouvel utilisateur, redirigée vers affichage de la page d'accueil
// -----------------------------------------------------------------------------------------------------

switch($route) {

    case "accueil": $toTemplate = showHome();
    break;
    case "insertuser" : insert_user(); // Redirigée vers "accueil"
    break;
    default: $toTemplate = showHome();

}

// -----------------------------------------------------------------------------------------------------
// Fonctions de contrôle
// Une fonction == une responsabilité unique ! 
// -----------------------------------------------------------------------------------------------------

/**
 * Affichage de la page d'accueil, retourne un tableau de deux éléments
 * "template" => Le fichier template à inclure
 * 'datas" => Les données à lui envoyer (éventuellement, si besoin)
 * @return array
 */
function showHome() {
    return ["template" => "accueil.html", "datas" => null];
}

/**
 * Ajout d'un utilisateur
 * Redirigée vers route=accueil (fonction d'affichage de la page d'accueil)
 */
function insert_user() {
     
    echo "je dois insérer un utilisateur";
    // Je redirige vers une fonction d'affichage
    header("Location:index.php?route=accueil");
    exit;
}

// -----------------------------------------------------------------------------------------------------
// AFFICHAGE == Système de templates
// Contexte global, données transmissibles via $toTemplate
// -----------------------------------------------------------------------------------------------------

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon organiseur</title>
</head>
<body>

    <?php require "templates/".$toTemplate["template"] ?>

</body>
</html>