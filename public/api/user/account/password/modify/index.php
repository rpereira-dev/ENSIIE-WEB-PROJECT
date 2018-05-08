<?php

/**
 *  @file
 *	@brief Modifie le mot de passe de l'utilisateur à partir d'un \a token généré au préalable.
 *	@param :
 *		- POST \a token : un token généré via \ref api/user/account/password/reset/index.php
 *		- POST \a mail
 *		- POST \a pass
 *	@return
 *		- code reponse:
 *						- 200 : le mot de passe a été modifié avec succès
 *						- 400 : erreur de la requête (paramètre(s) manquant(s) ou invalide(s))
 *						- 401 : token incorrect
 *						- 503 : erreur serveur (accès à la base de donnée)
 */

///@cond INTERNAL

/* include path */
require '../../../../../../vendor/autoload.php'; 

/* import */
use Model\BDD;
use Model\Utilisateur;
use Model\Utils;

//si le joueur n'est pas connecté
if (!isset($_POST['mail']) || !isset($_POST['token']) || !isset($_POST['pass'])) {
    http_response_code(400);
    echo "Requete invalide";
} else {
	$bdd   = BDD::instance();
	$user  = Utilisateur::instance();
	$mail  = $_POST['mail'];
	$token = $_POST['token'];
	$pass  = $_POST['pass'];
	try {
        if ($user->isTokenValid($bdd, $mail, $token)) {
        	$user->modifyPassword($bdd, $mail, $pass);
        	http_response_code(200);
        	echo "OK";
        } else {
    		http_response_code(401);
    		echo "Token invalide";
        }
	} catch (Exception $e) {
		http_response_code(503);
		echo "Erreur serveur";
	}
}

///@endcond

?>