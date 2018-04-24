<?php

namespace Controller;

/**
 *  Représente le header de la page
 */
abstract class Header {

    /**
     *  Fonction principal qui affiche le contenu
     */
    public static function afficher($user) {
		include VIEW_FOLDER . "/header.phtml";
    }
}