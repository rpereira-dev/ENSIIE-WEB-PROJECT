<?php
use Model\ULC\BDD\BDD;
use Model\ULC\BDD\ConnectionException;

/**
 *
 *  @file
 *  @brief Recupères les roles d'un utilisateur
 * @param
 *        	GET \a pseudo : le pseudo du joueur
 * @return - JSON : les roles
 *         - code reponse:
 *         - 200 : les rôles ont été renvoyé avec succès
 *         - 400 : erreur requête
 *         - 503 : la connection à la base de données a échoué
 */

// /@cond INTERNAL
require '../../../../../../vendor/autoload.php';

if (! isset ( $_GET ['pseudo'] )) {
	http_response_code ( 400 );
	echo 'pseudo manquant';
} else {
	try {
		$pseudo = filter_input ( INPUT_GET, 'pseudo', FILTER_SANITIZE_STRING );
		
		$pdo = BDD::instance ()->getConnection ( "ulc" );
		
		/* recuperes tous les roles de l'utilisateur */
		$stmt = $pdo->prepare ( 'SELECT role.id, role.name FROM utilisateur_role JOIN role ON role_id=role.id JOIN utilisateur ON utilisateur_id=utilisateur.id WHERE pseudo = :pseudo' );
		$stmt->bindParam ( ':pseudo', $pseudo, PDO::PARAM_STR );
		$stmt->execute ();
		$roles = array ();
		while ( ($entry = $stmt->fetch ()) != NULL ) {
			array_push ( $roles, array("id" => $entry['id'], "name" => $entry['name']));
		}
		http_response_code ( 200 );
		echo json_encode ( $roles );
	} catch ( ConnectionException $e ) {
		http_response_code ( 503 );
	}
}

// /@endcode

?>