<?php

namespace Controller;

/**
 *  Représente la barre à gauche du site
 */
class Sidebar extends PageElement {

    /**
	 *	affiches le contenu dans la page
     */
    public function afficher() {
        include "../src/View/sidebar.phtml";
    }

}

?>