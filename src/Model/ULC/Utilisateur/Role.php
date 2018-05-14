<?php

namespace Model\ULC\Utilisateur;

/**
 * Représente un role de la bdd
 */
class Role {
	
	/**
	 * les roles
	 */
	public static $JOUEUR = array (
			'id' => 0,
			'name' => "joueur" 
	);
	public static $MODERATEUR = array (
			'id' => 1,
			'name' => "moderateur" 
	);
	public static $ADMINISTRATEUR = array (
			'id' => 2,
			'name' => "administrateur" 
	);
	
	/**
	 * Recuperes un role par son ID
	 *
	 * @param number $id
	 * @return Role le role associé à l'id
	 */
	public static function getRoleByID($id) {
		switch ($id) {
			case Role::$JOUEUR ['id'] :
				return Role::$JOUEUR;
			
			case Role::$MODERATEUR ['id'] :
				return Role::$MODERATEUR;
			
			case Role::$ADMINISTRATEUR ['id'] :
				return Role::$ADMINISTRATEUR;
		}
	}

	
}

?>