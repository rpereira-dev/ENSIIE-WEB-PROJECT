<?php

/**
 *  Réinitialise le mot de passe si le token est correct.
 *
 *  Paramètres:
 *      - mail : l'adresse mail associé au compte
 */

/* include path */
require '../../../../../../vendor/autoload.php'; 

/* import */
use Model\BDD;
use Model\Utils;
