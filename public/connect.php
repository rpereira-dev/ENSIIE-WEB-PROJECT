<?php

/* include path */
require '../vendor/autoload.php'; 

/* recupere la session */
session_start();

/* recupere l'utilisateur */
$bdd = \Model\BDD::instance();

/* recupere l'utilisateur */
$user = \Model\Utilisateur::instance();

/* vérifie que les entrées existent */
if (isset($_POST['email']) && isset($_POST['pass'])) {
    /* verifie la validité des entrées (injections sql ...) */
    $mail = filter_input(INPUT_POST, 'email',   FILTER_SANITIZE_EMAIL);
    $pass = filter_input(INPUT_POST, 'pass',    FILTER_SANITIZE_STRING);

    /* on enregistre l'utilisateur */
    try {
        http_response_code(200);
        $user->connectAs($bdd, $mail, $pass);
        echo $user->asJoueur()->toJSON();
    } catch (Exception $e) {
        /** erreur base de donnée */
        http_response_code(503);
        echo "identifiants incorrects.";
    }
} else {
    http_response_code(401);
    echo "la requête est mal formattée";
}


?>
