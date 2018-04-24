<?php

namespace Controller;

/**
 *  Représente la barre en haut du site
 */
abstract class Navbar {

    /**
     *  Fonction principal qui affiche le contenu
     */
    public static function afficher($user) {
        include "../src/View/navbar.phtml";
    }
}

?>