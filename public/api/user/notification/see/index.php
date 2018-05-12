<?php

/**
 *  @file
 *  @brief Marque une notification comme ayant été lu
 *  @param :
 *      - COOKIE \a PHPSESSID : le cookie de session PHP \ref api/user/account/connect/index.php
 *      - \a id : l'id de la notification à marquer comme étant lue. \ref api/user/notification/get/index.php
 *  @return
 *      - code reponse:
 *                      - 200 : la notification a été marqué comme lu
 *                      - 400 : erreur de la requête (paramètre(s) manquant(s) ou invalide(s))
 *						- 401 : non connecté(e)
 */

// /@cond INTERNAL

/* include path */
use Model\ULC\BDD\BDD;
use Model\ULC\Utilisateur\Utilisateur;

require '../../../../../vendor/autoload.php';

/* on charge la session */
session_start ();

/* on recupere le joueur */
$user = Utilisateur::instance ();
if (! $user->isConnected ()) {
	http_response_code ( 401 );
	echo "Non connecté";
	return;
}

if (! isset ( $_POST ['id'] )) {
	http_response_code ( 400 );
	echo "Erreur requête";
	return;
}

/* on recupere la connection à la pdo */
$bdd = BDD::instance ();
$pdo = $bdd->getConnection ( "ulc" );
if ($pdo == NULL) {
	throw new PDOException ( "Connection error" );
}

$stmt = $pdo->prepare ( "UPDATE notification SET status = 'seen' WHERE joueur_id = :joueur_id AND id = :id" );

$joueur_id = $user->asJoueur ()->getID ();
$stmt->bindParam ( ':joueur_id', $joueur_id, PDO::PARAM_INT );

$id = filter_input ( INPUT_POST, 'id', FILTER_SANITIZE_STRING );
$stmt->bindParam ( ':id', $id, PDO::PARAM_STR );

$stmt->execute ();

http_response_code ( 200 );
echo 'OK';

// /@endcond INTERNAL

?>