<?php

namespace Controller;

/**
 *  Représente la page (contenu au milieu du site)
 */
abstract class Page {

        /**
     *  Fonction principal qui affiche le contenu
     *  de la page du site (au centre),
     *  en fonction de la variable GET['page']
     */
    public static function afficher() {
        /** les pages afficheables */
        $pages = array(
            "accueil"   => "\Controller\Page\PageAccueil",
            "ecoles"    => "\Controller\Page\PageEcoles",
            "erreur"    => "\Controller\Page\PageErreur",
            "joueurs"   => "\Controller\Page\PageJoueurs",
            "live"      => "\Controller\Page\PageLive",
            "profil"    => "\Controller\Page\PageProfil",
            "tournois"  => "\Controller\Page\PageTournois",
        );

        $pageID = isset($_GET['page']) ? $_GET['page'] : "accueil";
        $pageClass = isset($pages[$pageID]) ? $pages[$pageID] : $pages["erreur"];
        $page = new $pageClass();

        /* affiche le header de la page et le titre */
        include "header.phtml";
        /* affiche le contenu */
        include $page->getPHTML();
    }

    /**
     *  Constructeur
     */
    public function __construct() {
    }

    /**
     *  Renvoie le code html à être inséré dans le contenu de la page
     *  (entre 2 balises <div class="page"> </div>)
     *  @return le fichier .phtml qui correspond au contenu de la page
     */
    abstract public function getPHTML();

    /**
     *  @return string : le titre de la page
     */
    abstract public function getTitle();

}

?>