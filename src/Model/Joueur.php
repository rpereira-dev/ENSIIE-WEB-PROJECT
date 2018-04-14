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
    
    /** constructeur */
    public function __construct($uuid, $mail, $pseudo) {
        $this->uuid = $uuid;
        $this->$mail = $mail;
        $this->$pseudo = $pseudo;
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
        return ($this->mail);
    }
}

