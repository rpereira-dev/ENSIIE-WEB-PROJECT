<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'administrateur'
 */
class RoleAdministrateur extends RoleModerateur {
	public function getName() {
		return ('administrateur');
	}
	protected function addPermissions($permissions) {
		parent::addPermissions ( $permissions );
	}
}

