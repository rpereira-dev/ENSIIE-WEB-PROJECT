<?php

/**
 *  Liste les comptes League of Legends lié à l'utilisateur du site de la session courante.
 *
 *  Arguments: aucuns
 *
 *  Code erreur:
 *      - 200: le résultat a bien été envoyé
 *      - 400: reqûete mal formatté. (utilisateur non connecté)

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
    var_dump($user->asJoueur()->listLolAccounts());
}


?>