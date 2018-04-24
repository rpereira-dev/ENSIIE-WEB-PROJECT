<?php

namespace Controller\Content;

/**
 *  Représente la page du live twitch
 */
class Live extends \Controller\Content {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Live");
    }

    /**
     *  Renvoie le code html à être inséré dans le contenu de la page
     *  (entre 2 balises <div class="page"> </div>)
     *  @return le fichier .phtml qui correspond au contenu de la page
     */
    public function getPHTML() {
        return ('/live.phtml');
    }
}

?>