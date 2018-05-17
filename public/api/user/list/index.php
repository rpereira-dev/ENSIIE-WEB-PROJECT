<?php

/**
 *  @file
 *  @brief Recuperes la liste des joueurs
 *	@return
 *		- code reponse:
 *						- 200 : la liste a bien été générée
 *						- 400 : erreur requête (paramètre(s) manquant(s))
 						- 500 : erreur de connection à la base de donnée
 */

///@cond INTERNAL

/* include path */
use Model\ULC\BDD\BDD;
require '../../../../vendor/autoload.php'; 

/* on recupere la connection à la pdo */
$bdd = BDD::instance ();
$pdo = $bdd->getConnection ( "ulc" );
if ($pdo == NULL) {
	throw new PDOException ( "Connection error" );
}

/* prépares la base de données */
$stmt = $pdo->prepare ( 'SELECT pseudo, mail FROM Utilisateur');
$stmt->execute();

http_response_code ( 200 );

/* on enregistre la liste des joueurs */
echo '{"liste_joueurs":[';
if ($stmt->rowCount () > 0) {
	$entry = $stmt->fetch ();
	while ( $entry != NULL ) {
		echo '{';
		echo '"pseudo":"' . $entry ['pseudo'] . '"';
		echo ',';
		echo '"mail":"' . $entry ['mail'] . '"';
		echo '}';
		$entry = $stmt->fetch ();
		if ($entry != NULL) {
			echo ',';
		}
	}
}
echo ']}';




// /@endcode

?>