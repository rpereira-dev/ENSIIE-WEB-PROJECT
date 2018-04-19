<?php

namespace View\Page;

/**
 *  Représente la page d'accueil
 */
class PageAccueil extends Page {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Accueil");
    }


    /**
     *  Affiche le contenu de la page (entre 2 balises <div class="page"> </div>)
     */
    public function afficherContent() {
?>
		Bienvenue sur l'accueil mdr
<?php
    }
}

?>