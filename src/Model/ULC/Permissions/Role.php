<?php

namespace Model\ULC\Permissions;

/**
 * Représente une permission de la bdd
 */
abstract class Role {
	
	/**
	 * les différents rôles
	 */
	
	/**
	 *
	 * @var Role role pour un utilisateur hors ligne
	 */
	public static $UTILISATEUR;
	
	/**
	 *
	 * @var Role role pour un joueur
	 */
	public static $JOUEUR;
	
	/**
	 *
	 * @var Role role pour un moderateur
	 */
	public static $MODERATEUR;
	
	/**
	 *
	 * @var Role role pour un administrateur
	 */
	public static $ADMINISTRATEUR;
	
	/**
	 * le tableau qui contient tous les roles
	 */
	private static $ROLES_BY_ID = array ();
	private static $ROLES_BY_NAME = array ();
	
	/**
	 * initialises les variables statiques
	 */
	public static function __init() {
		Role::$UTILISATEUR = new RoleUtilisateur ();
		Role::$JOUEUR = new RoleJoueur ();
		Role::$MODERATEUR = new RoleModerateur ();
		Role::$ADMINISTRATEUR = new RoleAdministrateur ();
	}
	
	/**
	 *
	 * @return Role renvoie le role par son ID (clef primaire)
	 */
	public static function getRoleByID($roleID) {
		return (Role::$ROLES_BY_ID [$roleID]);
	}
	
	/**
	 *
	 * @return Role renvoie le role par son nom
	 */
	public static function getRoleByName($roleName) {
		return (Role::$ROLES_BY_NAME [$roleName]);
	}
	
	/**
	 *
	 * @return array la liste de tous les roles
	 */
	public static function getRoles() {
		return (Role::$ROLES_BY_ID);
	}
	
	/** @var number la clef primaire de la permission */
	private $id;
	
	/** @var array permissions liées au role */
	private $permissions;
	
	/**
	 * constructeur
	 */
	public function __construct() {
		// les permissions
		$this->permissions = array ();
		
		// ajoute au tableau global
		$this->id = count ( Role::$ROLES_BY_ID );
		Role::$ROLES_BY_ID [$this->id] = $this;
		Role::$ROLES_BY_NAME [$this->getName ()] = $this;
	}
	
	/**
	 * Renvoie l'id de la permission
	 *
	 * @return number l'id de la permission
	 */
	public function getID() {
		return ($this->id);
	}
	
	/**
	 * Renvoie le nom de la permission
	 *
	 * @return number le nom de la permission
	 */
	public abstract function getName();
	
	/**
	 * Renvoie les permissions associés à ce role
	 *
	 * @return array les permissions
	 */
	public function getPermissions() {
		return ($this->permissions);
	}
	
	/**
	 * ajoutes une permission au role
	 *
	 * @param Permission $permission
	 */
	public function addPermission($permission) {
		array_push ( $this->permissions, $permission );
	}
	
	/**
	 *
	 * @param
	 *        	Permission la permission
	 * @return true si le role possède la permission
	 */
	public function hasPermission($permission) {
		return (in_array ( $permission, $this->permissions ));
	}
}

Role::__init ();


