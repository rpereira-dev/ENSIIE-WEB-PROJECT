<?php

/**
 *  @file
 *  @brief Renvoie la liste de tous les roles existants au format JSON, avec un tableau contenant l'ID des permissions
 *  @param :
 *  @return
 *      - JSON : les roles
 *      - code reponse:
 *                      - 200 : les roles ont été généré avec succès
 */

// /@cond INTERNAL

/* include path */
use Model\ULC\Permissions\Permission;
use Model\ULC\Permissions\Role;

require '../../../../vendor/autoload.php';

$roles = array ();

foreach ( Role::getRoles () as $role ) {
	$permissions = array ();
	foreach ( Permission::getPermissions () as $permission ) {
		array_push ( $permissions, $permission->getID () );
	}
	array_push ( $roles, array (
			"id" => $role->getID (),
			"name" => $role->getName (),
			"permissions" => $permissions 
	) );
}

echo json_encode ( $roles );

// /@endcode

?>