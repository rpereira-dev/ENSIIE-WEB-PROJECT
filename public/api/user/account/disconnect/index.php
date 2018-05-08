<?php

/**
 *  @file
 *  @brief Detruis la session utilisateur
 *	@details supprimes la session utilisateur coté serveur.
 *	@param :
 *      - COOKIE \a PHPSESSID : le cookie de session
 *	@return
 *		- code reponse:
 *						- 200 : l'utilisateur est déconnecté
 */

///@cond INTERNAL

/* include path */
require '../../../../../vendor/autoload.php'; 

/* recupere la session */
session_start();

/** fin de la session */
session_destroy();

/* code de reponse */
http_response_code(200);
echo "OK";

///@endcond

?>
