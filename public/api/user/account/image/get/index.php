<?php

/**
 *  Récupères l'image de profil correspondant à l'utilisateur du stie
 *
 *  Paramètres:
 *      - joueur : nom du joueur
 *
 *  Reponse:
 *      - 200 : avec l'image
 *      - 404 : joueur not found
 */

/* include path */
require '../../../../../../vendor/autoload.php'; 

if (!isset($_POST['joueur'])) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo "<img src=http://localhost:8080/api/user/account/image/get/" . $_POST['joueur'] . ".png></img>";
}

?>
