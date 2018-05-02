<?php

/**
 *  Requete GET
 *
 *  Deconnectes un utilisateur
 */

/* include path */
require '../../../../vendor/autoload.php'; 

/* recupere la session */
session_start();

/** fin de la session */
session_destroy();

/* code de reponse */
echo "OK";
http_response_code(200);

?>
