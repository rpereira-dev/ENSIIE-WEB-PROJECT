<?php

namespace Controller;

/**
 *  Représente le header de la page
 */
abstract class Toastbar {

    /**
     *  Fonction principal qui affiche le contenu
     */
    public static function afficher($user) {
        include "../src/View/toastbar.phtml";
    }
}

?>