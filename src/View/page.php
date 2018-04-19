<?php

namespace View\Page;

require('../vendor/autoload.php'); 

/**
 *	Fonction principal qui affiche le contenu
 *	de la page du site (au centre),
 *	en fonction de la variable GET['page']
 */
function afficher() {
	/** les pages afficheables */
	$pages = array(
		"accueil"	=> "\View\Page\PageAccueil",
		"ecoles" 	=> "\View\Page\PageEcoles",
		"erreur" 	=> "\View\Page\PageErreur",
		"joueurs" 	=> "\View\Page\PageJoueurs",
		"live" 		=> "\View\Page\PageLive",
		"tournois" 	=> "\View\Page\PageTournois",
	);

	$pageID = isset($_GET['page']) ? $_GET['page'] : "accueil";
	$pageClass = isset($pages[$pageID]) ? $pages[$pageID] : $pages["erreur"];
	$page = new $pageClass();
	$page->afficher();
}
?>