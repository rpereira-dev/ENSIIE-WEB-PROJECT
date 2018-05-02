<?php

/**
 *  Requete GET
 *
 *  Relis l'utilisateur de la session courante au compte
  * League of Legend passé en paramètre.
 *
 *  Arguments: -

 *  Code erreur:
 *      - 200: la liaison a bien été enregistré.
 *      - 400: reqûete mal formatté. (paramètre manquant, utilisateur non connecté, ou sumonnerID inexistant)
 */

/* include path */
require '../../../../../vendor/autoload.php'; 

use Model\ULCRiot;
use Model\BDD;
use Model\Utilisateur;

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
    $code = 'IMATOSS';
    $_SESSION['third-party-code'] = $code;
    echo $code;
}