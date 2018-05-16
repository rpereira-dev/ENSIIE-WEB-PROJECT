<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'utilisateur' (non connecté(e)), role par défaut
 */
class RoleUtilisateur extends Role {
	
	/**
	 *
	 * {@inheritdoc}
	 * @see \Model\ULC\Permissions\Role::getName()
	 */
	public function getName() {
		return ('utilisateur');
	}
}

