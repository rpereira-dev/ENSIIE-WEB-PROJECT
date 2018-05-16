<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'utilisateur' (non connecté(e)), role par défaut
 */
class RoleUtilisateur extends Role {
	public function getName() {
		return ('utilisateur');
	}
	protected function addPermissions($permissions) {
	}
}

