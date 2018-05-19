<?php
use Model\ULC\Utilisateur\Permission;
use Model\ULC\Utilisateur\Utilisateur;

/**
 *
 *  @file
 *  @brief Ajoutes un rôle à un utilisateur
 * @param
 *        	COOKIE \a PHPSESSID : le cookie de session
 *        	POST \a pseudo : le pseudo du joueur
 *        	POST \a roleName : le nom du role
 * @return - code reponse:
 *         200 : le rôle a été attribué avec succès
 *         400 : erreur requête
 *         401 : non autorisé
 *         409 : le role n'a pas pu être attributé (role déjà attribué)
 *         503 : la connection à la base de données a échoué
 */

// /@cond INTERNAL
require '../../../../../../vendor/autoload.php';

session_start ();

$user = Utilisateur::instance ();

if (! $user->hasPermission ( Permission::$ASSIGN_ROLE )) {
	http_response_code ( 401 );
	echo "Non autorisé";
} else {
}

// TODO

// /@endcode

?>