<?php

namespace View\Page;

/**
 *  Représente la page listant les tournois
 */
class PageTournois extends Page {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Tournois");
    }


    /**
     *  Affiche le contenu de la page (entre 2 balises <div class="page"> </div>)
     */
    public function afficherContent() {
?>
		coucou c ns les tournwa
<?php
    }
}

?>