<?php

namespace Model;

use PDO;

/** Contient les données d'un joueur connecté */
class Joueur {
    
    /** sa primary key dans la base de données */
    private $uuid;
    
    /** le mail du joueur */
    private $mail;
    
    /** son pseudo */
    private $pseudo;

    /** l'école */
    private $ecole;

    /** constructeur */
    public function __construct($uuid, $mail, $pseudo, $ecole) {
        $this->uuid     = $uuid;
        $this->mail     = $mail;
        $this->pseudo   = $pseudo;
        $this->ecole    = $ecole;
    }
    
    /** la clef primaire du joueur dans la base de donnée */
    public function getUUID() {
        return ($this->uuid);
    }
    
    /** l'adresse mail du joueur */
    public function getMail() {
        return ($this->mail);
    }
    
    /** le pseudo du joueur */
    public function getPseudo() {
        return ($this->pseudo);
    }

    /** l'ecole à laquelle le joueur appartient */
    public function getEcole() {
        return ($this->ecole);
    }

    /** renvoie le joueur sous une string au format JSON */
    public function toJSON() {
        return (
'
{
  "pseudo": "' . $this->pseudo . '"
}
'
        );
    }

    /**
     * Lie l'utilisateur du site au compte League of Legend
     *  
     *  @param PDO $db
     *  @param integer $summonerID
     *  @throws PDOException : si la connection à la bdd échoue ou si le summonerID est déjà lié à un autre joueur
     */
    public function linkLolAccount($bdd, $summonerID) {
        $pdo = $bdd->getConnection("ulc");
        if ($pdo == NULL) {
            throw new PDOException("Connection error");
        }

        $stmt = $pdo->prepare("INSERT INTO joueur_lol (joueur_id, summoner_id) VALUES (:joueur_id, :summoner_id)");
        $uuid = $this->asJoueur()->getUUID();
        $stmt->bindParam(':joueur_id',   $uuid,         PDO::PARAM_INT);
        $stmt->bindParam(':summoner_id', $summonerID,   PDO::PARAM_INT);
        $stmt->execute();
        return (true);
    }


    /**
     * Liste les comptes League of Legends lié à ce joueur
     *  
     *  @param PDO $db
     *  @throws PDOException : si la connection à la bdd échoue
     */
    public function listLolAccounts($bdd) {
        $pdo = $bdd->getConnection("ulc");
        if ($pdo == NULL) {
            throw new PDOException("Connection error");
        }

        $stmt = $pdo->prepare("SELECT * FROM joueur_lol WHERE joueur_id = :joueur_id");
        $uuid = $this->asJoueur()->getUUID();
        $stmt->bindParam(':joueur_id',   $uuid,         PDO::PARAM_INT);
        $stmt->execute();

        $r = array();

        while (($entry = $stmt−>fetch()) != NULL) {
            $array_push($r, $entry['summoner_id']);
        }

        return ($r);
    }
}

