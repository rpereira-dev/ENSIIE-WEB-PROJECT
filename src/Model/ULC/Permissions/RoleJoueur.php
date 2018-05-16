<?php

namespace Model\ULC\Permissions;

/**
 * Représente le role 'joueur'
 */
class RoleJoueur extends RoleUtilisateur {
	
	/**
	 * constructeur: ajout des permissions
	 */
	public function __construct() {
		parent::__construct ();
		$this->addPermission ( Permission::$CREATE_TEAM );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 * @see \Model\ULC\Permissions\RoleUtilisateur::getName()
	 */
	public function getName() {
		return ('joueur');
	}
}

