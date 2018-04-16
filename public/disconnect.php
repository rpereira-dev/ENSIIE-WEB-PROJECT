<?php

/* include path */
require '../vendor/autoload.php'; 

/* recupere la session */
session_start();

/* code de retour */
$responseCode = 200;

/** fin de la session */
session_destroy();

/* code de reponse */
echo "OK";
http_response_code($responseCode);

?>
