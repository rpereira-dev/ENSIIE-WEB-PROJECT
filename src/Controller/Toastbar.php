<?php

namespace Controller;

/**
 *  Représente le header de la page
 */
class Toastbar extends PageElement {

    /**
	 *	affiches le contenu dans la page
     */
    public function afficher() {
        include "../src/View/toastbar.phtml";
    }
}

?>