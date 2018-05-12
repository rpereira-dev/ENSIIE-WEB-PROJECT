<?php

namespace Controller\Content;

/**
 * Représente la page d'erreur de redirections
 */
class Erreur extends \Controller\Content {
	
	/**
	 *
	 * @return string : le titre de la page
	 */
	public function getTitle() {
		return ("Erreur");
	}
	
	/**
	 * Renvoie le code html à être inséré dans le contenu de la page
	 * (entre 2 balises <div class="page"> </div>)
	 *
	 * @return string : chemin du fichier .phtml qui correspond au contenu de la page
	 */
	public function getPHTML() {
		return ('/erreur.phtml');
	}
}

?>