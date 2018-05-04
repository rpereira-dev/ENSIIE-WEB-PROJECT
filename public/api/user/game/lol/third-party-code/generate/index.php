<?php

/**
 *	Génère un 'third-party-code'
 *
 *  Arguments: -

 *  Code erreur:
 *      - 200: le code a été généré
 *      - 400: reqûete mal formatté. (paramètre manquant, utilisateur non connecté, ou sumonnerID inexistant)
 */

/* include path */
require '../../../../../../../vendor/autoload.php'; 

use Model\BDD;
use Model\Utilisateur;
use Model\Utils;

/* recupere la session */
session_start();

$user = Utilisateur::instance();

//si le joueur n'est pas connecté
if (!$user->isConnected()) {
    http_response_code(400);
    echo 'Non connecté.';
//si la requete est invalide
} else {
    http_response_code(200);
    $code = Utils::random_str(32);
    $_SESSION['third-party-code'] = $code;
    echo $code;
}