<?php

namespace Controller;

/**
 *  Représente la barre à gauche du site
 */
abstract class Sidebar {

    /**
     *  Fonction principal qui affiche le contenu
     */
    public static function afficher($user) {
        include "../src/View/sidebar.phtml";
    }
}

?>