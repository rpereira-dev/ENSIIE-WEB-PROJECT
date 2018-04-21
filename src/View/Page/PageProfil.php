<?php

namespace View\Page;

/**
 *  Représente la page de profil
 */
class PageProfil extends Page {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Profil");
    }


    /**
     *  Affiche le contenu de la page (entre 2 balises <div class="page"> </div>)
     */
    public function afficherContent() {
?>
		Bienvenue sur mon profil :D
<?php
    }
}

?>