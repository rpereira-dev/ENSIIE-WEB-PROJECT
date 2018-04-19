<?php

namespace View\Page;

/**
 *  Représente la page d'accueil
 */
class PageEcoles extends Page {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Ecoles");
    }


    /**
     *  Affiche le contenu de la page (entre 2 balises <div class="page"> </div>)
     */
    public function afficherContent() {
?>
		Bienvenue sur l'école mdr
<?php
    }
}

?>