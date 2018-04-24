<?php

namespace Controller;

/**
 *  Représente une partie du site
 */
abstract class PageElement {

	/* la base de donnée */
	private $bdd;

	/* l'utilisateur du site */
	private $user;

	/**
	 *	constructeur:
	 *
	 *	@param BDD $bdd : la base de donnée du site
	 *	@param Utilisateur $user : l'utilisateur du site
	 */
	public function __construct($bdd, $user) {
		$this->bdd  = $bdd;
		$this->user = $user;
	}

	/**
	 *	@return la base de donnée du site
	 */
	public function getBDD() {
		return ($this->bdd);
	}

	/**
	 *	@return l'utilisateur dus ite
	 */
	public function getUser() {
		return ($this->user);
	}

	/**
	 *	affiches le contenu dans la page
	 */
	public abstract function afficher();


}