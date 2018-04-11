<?php

/** docker */
require '../../../vendor/autoload.php';

/**
 *  Renvoie une nouvelle connexion dans la base de donnée
 *  sous forme de PDO.
 *  @param string $dbUser l'utilisateur de la bdd
 *  @param string $dbPassword mot de passe de l'utilisateur
 *  @see http://php.net/manual/en/class.pdo.php
 */
function getDB($dbUser, $dbPassword) {
    try {
	    $dbName = getenv('DB_NAME');
		$db = new PDO("pgsql:host=postgres user=$dbUser dbname=$dbName password=$dbPassword");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return ($db);
    } catch (PDOException $e) {
        return (NULL);
    }
}

?>