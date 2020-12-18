<?php
session_start(); // Crée le tableau $_SESSION (ou le charge avec les données récupérée)

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
// index.php?route=connectuser => Connexion d'un utilisateur, redirigée vers espace membre
// index.php?route=membre => Affichage de l'espace membre
// index.php?route=inserttask => Ajout d'une nouvelle tâche, redirigée vers affichage de la page espace membre
// -----------------------------------------------------------------------------------------------------

switch($route) {

    case "accueil": $toTemplate = showHome();
    break;
    case "insertuser" : insert_user(); // Redirigée vers "accueil"
    break;
    case "connectuser" : connect_user(); // Redirigée vers "mon espace"
    break;
    case "membre" : $toTemplate = showMember(); 
    break;
    case "inserttask" : insert_task(); // Redirigée vers "mon espace"
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
function showHome(): array {
    return ["template" => "accueil.php", "datas" => null];
}

/**
 * Affichage de l'espace membre
 * "template" => Le fichier template à inclure
 * 'datas" => Les données à lui envoyer (éventuellement, si besoin)
 * @return array
 */
function showMember(): array {
    return ["template" => "espacemembre.php", "datas" => null];
}

/**
 * Ajout d'un utilisateur
 * Redirigée vers route=accueil (fonction d'affichage de la page d'accueil)
 */
function insert_user() {
     
    var_dump($_POST);
    //'username' => string 'Test' (length=4) => $_POST["username"]
    //'password' => string 'test' (length=4) => $_POST["password"]
    //'password2' => string 'test' (length=4) => $_POST["password2"]

    if(!empty($_POST["username"]) && !empty($_POST["password"]) && $_POST["password"] === $_POST["password2"]) {
        // Je peux procéder à la suite de l'ajout d'un utilisateur

        require_once "models/User.php";

        $user = new User($_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));

        // Résultat de l'exécution de save_user()
        $user->save_user();
        
    } else {
        // Je ne peux pas procéder à la suite de l'ajout d'un utilisateur
        $_SESSION["errors"]["connexion"] = "Erreur lors de l'enregistrement";

    }

    // Je redirige vers une fonction d'affichage
    header("Location:index.php?route=accueil");
    exit;
}

function connect_user() {

    require_once "models/User.php";

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {

        $user = new User($_POST["username"], $_POST["password"]);
        if($user->verify_user()) {
            // L'utilisateur est "autorisé" à se connecter
            $_SESSION["user"]["user_id"] = $user->getUserId();
            $_SESSION["user"]["username"] = $user->getUsername();

            header("Location:index.php?route=membre");
            exit;

        } else {
            // L'utilisateur n'est pas "autorisé" à se connecter
            $_SESSION["errors"]["connexion"] = "Vous avez entré un mauvais identifiant et/ou mot de passe";
        }

    } else {

        $_SESSION["errors"]["champs"] = "L'ensemble des champs est obligatoire.";

    }

    header("Location:index.php?route=accueil");
    exit;
}


/**
 * Ajout d'une nouvelle tâche
 * Redirigée vers la route "membre" (affichage espace membre)
 */
function insert_task() {

    require_once "models/Task.php";
    var_dump($_POST);
    // 'description' => string 'Terminer correction' (length=19) => $_POST["description"]
    // 'deadline' => string '2020-12-18' (length=10) => $_POST["deadline"]

    var_dump($_SESSION);

    $task = new Task($_POST["description"], $_POST["deadline"], $_SESSION["user"]["user_id"]);
    $task->save_task();

    //header("Location:index.php?route=membre");
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