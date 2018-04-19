<?php

namespace View\Page;

/**
 *  Représente la page d'erreur de redirections
 */
class PageErreur extends Page {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Erreur");
    }


    /**
     *  Affiche le contenu de la page (entre 2 balises <div class="page"> </div>)
     */
    public function afficherContent() {
?>
		t'es duper wala
<?php
    }
}

?>