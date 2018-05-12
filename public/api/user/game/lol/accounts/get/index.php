<?php

/**
 *  @file
 *  @brief Renvoie la liste des comptes League of Legend associé à un compte
 *  @param :
 *      - COOKIE \a PHPSESSID : le cookie de session PHP \ref api/user/account/connect/index.php
 *  @return
 *		- la liste des comptes League of Legend lié à l'utilisateur.
 *      - code reponse:
 *                      - 200 : l'utilisateur a été enregistré avec succès
 *                      - 400 : erreur de la requête (paramètre(s) manquant(s) ou invalide(s))
 */

// /@cond INTERNAL

/* include path */
use Model\ULC\LOL\API;
use Model\ULC\Utilisateur\Utilisateur;

require ('../../../../../../../vendor/autoload.php');

/* recupere la session */
session_start ();

$user = Utilisateur::instance ();

// si le joueur n'est pas connecté
if (! $user->isConnected ()) {
	http_response_code ( 400 );
	echo 'Non connecté.';
	// si la requete est invalide
} else {
	http_response_code ( 200 );
	$riot = API::riot ();
	$summoners = array ();
	$summonersID = $user->asJoueur ()->listLolAccounts ();
	foreach ( $summonersID as $summonerID ) {
		array_push ( $summoners, $riot->getSummoner ( $summonerID ) );
	}
	echo json_encode ( $summoners );
}

// /@endcond INTERNAL

?>