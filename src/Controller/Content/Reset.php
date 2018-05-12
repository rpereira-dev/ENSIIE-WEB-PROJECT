<?php

namespace Controller\Content;

/**
 * Représente la page de reset du mot de passe
 */
class Reset extends \Controller\Content {
	
	/**
	 *
	 * @return string : le titre de la page
	 */
	public function getTitle() {
		return ("Reset");
	}
	
	/**
	 * Renvoie le code html à être inséré dans le contenu de la page
	 * (entre 2 balises <div class="page"> </div>)
	 *
	 * @return string : chemin du fichier .phtml qui correspond au contenu de la page
	 */
	public function getPHTML() {
		return ('/reset.phtml');
	}
}

?>