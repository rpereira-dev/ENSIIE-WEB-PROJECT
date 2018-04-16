<?php

namespace Model;

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
}

