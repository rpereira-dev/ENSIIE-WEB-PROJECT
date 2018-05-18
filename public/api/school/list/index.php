<?php

/**
 *  @file
 *  @brief Recuperes la liste des écoles
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
$stmt = $pdo->prepare ( 'SELECT academie, nom, sigle, domaine, ville FROM ecole ORDER BY academie');
$stmt->execute();

http_response_code ( 200 );

/* on enregistre la liste des écoles */
echo '{"liste_ecoles":[';
if ($stmt->rowCount () > 0) {
	$entry = $stmt->fetch ();
	while ( $entry != NULL ) {
		echo '{';
		echo '"academie":"' . $entry ['academie'] . '"';
		echo ',';
		echo '"nom":"' . $entry ['nom'] . '"';
		echo ',';
		echo '"sigle":"' . $entry ['sigle'] . '"';
		echo ',';
		echo '"domaine":"' . $entry ['domaine'] . '"';
		echo ',';
		echo '"ville":"' . $entry ['ville'] . '"';
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