<?php

/* include path */
set_include_path(get_include_path() . PATH_SEPARATOR . "../src");
require_once("Model/BDD.php");
require_once("Model/Utilisateur.php");

/* recupere la session */
session_start();

$bdd = BDD::instance();
$user = Utilisateur::instance();

$responseCode = 401;

/* vérifie que les entrées existent */
if (isset($_POST['email']) && isset($_POST['pass'])) {
    /* verifie la validité des entrées (injections sql ...) */
    $mail = filter_input(INPUT_POST, 'email',   FILTER_SANITIZE_EMAIL);
    $pass = filter_input(INPUT_POST, 'pass',    FILTER_SANITIZE_STRING);

    /* on enregistre l'utilisateur */
    try {
        if ($user->connectAs($bdd, $mail, $pass)) {
            /* le mot de passe est valide */
            $responseCode = 200;
        }
    } catch (PDOException $e) {
        /** erreur base de donnée */
        $responseCode = 503;
    }
}

/* code de reponse */
http_response_code($responseCode);

?>
