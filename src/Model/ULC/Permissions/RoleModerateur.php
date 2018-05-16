<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'moderateur'
 */
class RoleModerateur extends RoleJoueur {
	
	/**
	 * constructeur: ajout des permissions
	 */
	public function __construct() {
		parent::__construct ();
		$this->addPermission(Permission::$CREATE_TOURNAMENT);
	}
	
	/**
	 *
	 * {@inheritdoc}
	 * @see \Model\ULC\Permissions\RoleJoueur::getName()
	 */
	public function getName() {
		return ('moderateur');
	}
}

