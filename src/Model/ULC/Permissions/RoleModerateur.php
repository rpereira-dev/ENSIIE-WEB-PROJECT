<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'moderateur'
 */
class RoleModerateur extends RoleJoueur {
	public function getName() {
		return ('moderateur');
	}
	protected function addPermissions($permissions) {
		parent::addPermissions ( $permissions );
		array_push ( $permissions, Permission::$CREATE_TOURNAMENT );
	}
}

