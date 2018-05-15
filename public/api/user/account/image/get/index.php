<?php

/**
 *  @file
 *  @brief Recuperes l'image de profil d'un joueur
 *	@param :
 *		- GET \a pseudo : le pseudo du joueur
 *	@return
 *		- code reponse:
 *						- 200 : l'image a été trouvé et renvoyé
 *						- 400 : erreur requête (paramètre(s) manquant(s))
 */

///@cond INTERNAL

/* include path */
require '../../../../../../vendor/autoload.php'; 

if (!isset($_GET['pseudo'])) {
	http_response_code(400);
    echo 'Erreur requete';
} else {
    http_response_code(200);
    echo "http://localhost:8080/api/user/account/image/get/" . $_GET['pseudo'] . ".png";
}

///@cond INTERNAL

?>
