<?php

namespace Controller\Content;

/**
 *  Représente la page d'accueil
 */
class Ecoles extends \Controller\Content {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Ecoles");
    }

    /**
     *  Renvoie le code html à être inséré dans le contenu de la page
     *  (entre 2 balises <div class="page"> </div>)
     *  @return le fichier .phtml qui correspond au contenu de la page
     */
    public function getPHTML() {
        return ('/ecoles.phtml');
    }
}

?>