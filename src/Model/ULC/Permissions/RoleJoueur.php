<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'joueur'
 */
class RoleJoueur extends RoleUtilisateur {
	public function getName() {
		return ('joueur');
	}
	protected function addPermissions($permissions) {
		parent::addPermissions ( $permissions );
		array_push ( $permissions, Permission::$CREATE_TEAM );
	}
}

