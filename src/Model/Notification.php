<?php

namespace Model;

/** Contient les données d'un joueur connecté */
class Notification {
    
    /** sa primary key dans la base de données */
    private $uuid;
    
    /** le titre de la notification */
    private $title;
    
    /** le contenu de la notification */
    private $content;

    /** le lien de redirection de la notification */
    private $redirect;
    
    /** constructeur */
    public function __construct($uuid, $title, $content, $redirect) {
        $this->uuid     = $uuid;
        $this->title    = $title;
        $this->content  = $content;
        $this->redirect = $redirect;
    }
    
    /** la clef primaire du joueur dans la base de donnée */
    public function getUUID() {
        return ($this->uuid);
    }
    
    /** le titre */
    public function getTitle() {
        return ($this->mail);
    }
    
    /** le contenu */
    public function getContent() {
        return ($this->pseudo);
    }

    /** le lien de redirection */
    public function getRedirection() {
        return ($this->ecole);
    }
}

