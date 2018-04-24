<?php

namespace Controller;

/**
 *  Représente le footer (bas du site)
 */
class Footer {

    /**
	 *	affiches le contenu dans la page
     */
    public function afficher() {
		include VIEW_FOLDER . "/footer.phtml";
    }
}

?>
