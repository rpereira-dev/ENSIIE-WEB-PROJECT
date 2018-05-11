<?php

namespace Model\ULC\Utilisateur;

use Model\ULC\BDD\BDD;
use Model\ULC\BDD\ConnectionException;
use PDO;
use PDOException;

/**
 * Contient les données d'un joueur connecté
 */
class Joueur {
	
	/**
	 * l'entrée dans la base de données
	 */
	private $entry;
	
	/**
	 * constructeur
	 */
	public function __construct($entry) {
		$this->entry = $entry;
	}
	
	/**
	 * fonction interne pour lire l'entrée de la table
	 */
	private function get($name) {
		return (isset ( $this->entry [$name] ) ? $this->entry [$name] : NULL);
	}
	
	/**
	 * la clef primaire du joueur dans la base de donnée
	 */
	public function getID() {
		return ($this->get ( 'id' ));
	}
	
	/**
	 * l'adresse mail du joueur
	 */
	public function getMail() {
		return ($this->get ( 'mail' ));
	}
	
	/**
	 * le pseudo du joueur
	 */
	public function getPseudo() {
		return ($this->get ( 'pseudo' ));
	}
	
	/**
	 * l'ecole à laquelle le joueur appartient
	 */
	public function getEcole() {
		return ($this->get ( 'ecole' ));
	}
	
	/**
	 * renvoie le joueur sous une string au format JSON
	 */
	public function toJSON() {
		return ('
{
  "pseudo": "' . $this->getPseudo () . '"
}
');
	}
	
	/**
	 * Lie l'utilisateur du site au compte League of Legend
	 *
	 * @param integer $summonerID
	 * @throws PDOException : si le summonerID est déjà lié à un autre joueur
	 * @throws ConnectionException : connection echouée
	 */
	public function linkLolAccount($summonerID) {
		$pdo = BDD::instance ()->getConnection ( "ulc" );
		
		$stmt = $pdo->prepare ( "INSERT INTO joueur_lol (joueur_id, summoner_id) VALUES (:joueur_id, :summoner_id)" );
		$id = $this->getID ();
		$stmt->bindParam ( ':joueur_id', $id, PDO::PARAM_INT );
		$stmt->bindParam ( ':summoner_id', $summonerID, PDO::PARAM_INT );
		$stmt->execute ();
		return (true);
	}
	
	/**
	 * Liste les comptes League of Legends lié à ce joueur
	 *
	 * @throws PDOException : si la connection à la bdd échoue
	 * @throws ConnectionException : connection echouée
	 */
	public function listLolAccounts() {
		$pdo = BDD::instance ()->getConnection ( "ulc" );
		
		$stmt = $pdo->prepare ( "SELECT * FROM joueur_lol WHERE joueur_id = :joueur_id" );
		$id = $this->getID ();
		$stmt->bindParam ( ':joueur_id', $id, PDO::PARAM_INT );
		$stmt->execute ();
		
		/* renvoie un tableau associatif de l'entrée dans la table */
		$r = array ();
		
		while ( ($entry = $stmt->fetch ()) != NULL ) {
			array_push ( $r, $entry ['summoner_id'] );
		}
		
		return ($r);
	}
}

