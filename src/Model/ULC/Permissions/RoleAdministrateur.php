<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'administrateur'
 */
class RoleAdministrateur extends RoleModerateur {
	/**
	 * constructeur: ajout des permissions
	 */
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 *
	 * {@inheritdoc}
	 * @see \Model\ULC\Permissions\RoleModerateur::getName()
	 */
	public function getName() {
		return ('administrateur');
	}
}

