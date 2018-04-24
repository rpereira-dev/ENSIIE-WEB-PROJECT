<?php

namespace Controller;

/**
 *  Représente le footer (bas du site)
 */
abstract class Footer {

    /**
     *  Fonction principal qui affiche le contenu
     */
    public static function afficher($user) {
		include VIEW_FOLDER . "/footer.phtml";
    }
}

?>
