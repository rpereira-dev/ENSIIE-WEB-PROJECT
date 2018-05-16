<?php

/**
 *  @file
 *  @brief Renvoie la liste de toutes les permissions existantes
 *  @param :
 *  @return
 *      - JSON : les permissions
 *      - code reponse:
 *                      - 200 : les permissions ont été généré avec succès
 */

// /@cond INTERNAL

/* include path */
use Model\ULC\Permissions\Permission;

require '../../../../vendor/autoload.php';

$permissions = array ();

foreach ( Permission::getPermissions () as $permission ) {
	array_push ( $permissions, array (
			"id" => $permission->getID (),
			"name" => $permission->getName (),
			"desc" => $permission->getDescription () 
	) );
}

echo json_encode ( $permissions );

// /@endcode

?>