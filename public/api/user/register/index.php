<?php

/**
 *  Requete POST
 *
 *  Enregistre un utilisateur
 *
 *  Arguments:
 *      - email
 *      - pseudo
 *      - pass (en 'clair') (sera crypté par la suite)
 *      - g-recaptcha : code captcha google
 */

/* include path */
require '../../../../vendor/autoload.php'; 

/* recupere la session */
session_start();

/* recupere l'utilisateur */
$bdd = \Model\BDD::instance();

/* recupere l'utilisateur */
$user = \Model\Utilisateur::instance();

/* vérifie que les entrées existent */
if (isset($_POST['email']) && isset($_POST['pseudo']) && isset($_POST['pass']) && isset($_POST['g-recaptcha'])) {
    /* verifie la validité des entrées (injections sql ...) */
    $mail          = filter_input(INPUT_POST, 'email',     FILTER_SANITIZE_EMAIL);
    $pseudo        = filter_input(INPUT_POST, 'pseudo',    FILTER_SANITIZE_STRING);
    $pass          = filter_input(INPUT_POST, 'pass',      FILTER_SANITIZE_STRING);
    $grecaptcha    = $_POST['g-recaptcha'];

    /* si le mot de passe est trop court ... */
    if (strlen($pass) < 6) {
        http_response_code(401);
        echo "le mot de passe est trop court.";
    } else {
        /* on vérifie aupres de google que le captcha est correct */
        /* Verify captcha */
        $post_data = http_build_query(
            array(
                'secret' => "6LfSvVEUAAAAAOUCTZjrHx_jH4FolYPCtNiOWKRd",
                'response' => $grecaptcha,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result   = json_decode($response);
        /* si le captcha est faux */
        if (!$result->success) {
            http_response_code(401);
            echo "Un Robot sauvage apparait.";
        } else {
            /* sinon, on enregistre l'utilisateur */
            try {
                $user->register($bdd, $mail, $pseudo, $pass);
                http_response_code(200);
                echo "OK";
            } catch (Exception $e) {
                /** erreur base de donnée */
                http_response_code(503);
                echo "les identifiants sont déjà utilisés";
            }
        }
    }
} else {
    http_response_code(401);
    echo "la requête est mal formattée";
}
?>