<?php

namespace View\Page;

/**
 *  Représente la page de la liste des joueurs
 */
class PageJoueurs extends Page {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Joueurs");
    }


    /**
     *  Affiche le contenu de la page (entre 2 balises <div class="page"> </div>)
     */
    public function afficherContent() {
?>
		coucou c ns les joueurs
<?php
    }
}

?>