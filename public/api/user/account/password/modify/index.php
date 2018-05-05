<?php

/**
 *  Réinitialise le mot de passe si le token est correct.
 *
 *	Requete GET
 *
 *  Paramètres:
 *      - mail  : l'adresse mail associé au compte
 *      - token : le token associé au compte
 */

/* include path */
require '../../../../../../vendor/autoload.php'; 

/* import */
use Model\BDD;
use Model\Utils;

//si le joueur n'est pas connecté
if (!isset($_GET['mail']) || !isset($_GET['token'])) {
    http_response_code(400);
    echo "Requete invalide";
} else {
	$bdd = BDD::instance();
	try {
		$pdo = $bdd->getConnection("ulc");
		$stmt = $pdo->prepare("
								SELECT * FROM reset_token
									JOIN joueur ON joueur_id=id
										WHERE mail=:mail AND token=:token AND (NOW() BETWEEN date_generation AND date_generation +  '15 minutes'::interval)
							");
        $stmt->bindParam(':mail', $_GET['mail'], PDO::PARAM_STR);
        $stmt->bindParam(':token', $_GET['token'], PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
    		http_response_code(400);
    		echo "Token invalide";
        } else {
        	$entry = $stmt->fetch();
        	//TODO : input pour entrer le nouveau mot de passe
        }
	} catch (Exception $e) {
		http_response_code(500);
		echo "Erreur serveur : " . $e;
	}
}