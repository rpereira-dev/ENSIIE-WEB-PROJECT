<?php

/* include path */
require '../vendor/autoload.php'; 

/* recupere la session */
session_start();

/* recupere l'utilisateur */
$bdd = \Model\BDD::instance();

/* recupere l'utilisateur */
$user = \Model\Utilisateur::instance();

/* code de retour */
$responseCode = 401;

/* vérifie que les entrées existent */
if (isset($_POST['email']) && isset($_POST['pseudo']) && isset($_POST['pass'])) {
    /* verifie la validité des entrées (injections sql ...) */
    $mail   = filter_input(INPUT_POST, 'email',     FILTER_SANITIZE_EMAIL);
    $pseudo = filter_input(INPUT_POST, 'pseudo',    FILTER_SANITIZE_STRING);
    $pass   = filter_input(INPUT_POST, 'pass',      FILTER_SANITIZE_STRING);

    /* on enregistre l'utilisateur */
    try {
        $user->register($bdd, $mail, $pseudo, $pass);
        $responseCode = 200;
    } catch (Exception $e) {
        /** erreur base de donnée */
        $responseCode = 503;
    }
}

/* code de reponse */
http_response_code($responseCode);

?>