<?php

namespace Model\ULC\Permissions;

/**
 * Représente une permission de la bdd
 */
class Permission {
	
	/**
	 * les différentes permissions
	 */
	public static $CREATE_TEAM;
	public static $CREATE_TOURNAMENT;
	
	/**
	 * le tableau qui contient tous les permissions
	 */
	private static $PERMISSIONS_BY_ID = array ();
	private static $PERMISSIONS_BY_NAME = array ();
	
	/**
	 * ajoute un permission dans le tableau
	 */
	private static function setPermission(&$PERMISSION_REF, $PERMISSION) {
		$PERMISSION_REF = $PERMISSION;
		Permission::$PERMISSIONS_BY_ID [$PERMISSION_REF->getID ()] = $PERMISSION_REF;
		Permission::$PERMISSIONS_BY_NAME [$PERMISSION_REF->getName ()] = $PERMISSION_REF;
	}
	
	/**
	 * initialises les variables statiques
	 */
	public static function __init() {
		Permission::setPermission ( Permission::$CREATE_TEAM, new Permission ( 0, "create_team", "Créer une équipe" ) );
		Permission::setPermission ( Permission::$CREATE_TOURNAMENT, new Permission ( 1, "create_tournament", "Créer un tournoi" ) );
	}
	
	/**
	 *
	 * @return array la liste de tous les permissions
	 */
	public static function getPermissions() {
		return (Permission::$PERMISSIONS_BY_ID);
	}
	
	/**
	 *
	 * @return Permission la permission par son ID (clef primaire)
	 */
	public static function getPermissionByID($permissionID) {
		return (Permission::$PERMISSIONS_BY_ID [$permissionID]);
	}
	
	/**
	 *
	 * @return Permission la permission role par son nom
	 */
	public static function getPermissionByName($permissionName) {
		return (Permission::$PERMISSIONS_BY_NAME [$permissionName]);
	}
	
	/** @var number la clef primaire de la permission */
	private $id;
	
	/** @var string le nom de la permission */
	private $name;
	
	/** @var string description de la permission */
	private $description;
	
	/**
	 * constructeur
	 *
	 * @param number $id
	 * @param string $name
	 * @param array $permissions
	 */
	public function __construct($id, $name, $description) {
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
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
	public function getName() {
		return ($this->name);
	}
	
	/**
	 * Renvoie la description
	 *
	 * @return string la description de la permission
	 */
	public function getDescription() {
		return ($this->description);
	}
}

Permission::__init ();




