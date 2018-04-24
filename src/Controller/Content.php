<?php

namespace Controller;
use Controller\Content;

/**
 *  Représente le contenu au milieu de la page du site
 */
abstract class Content extends PageElement {

    /**
     *  Fonction principal qui renvoie le PageElement à afficher
     *  de la page du site (au centre),
     *  en fonction de la variable GET['page']
     */
    public static function afficher($bdd, $user) {
        /** les pages afficheables */
        $pages = [
            "accueil"   => Content\Accueil::class,
            "ecoles"    => Content\Ecoles::class,
            "erreur"    => Content\Erreur::class,
            "joueurs"   => Content\Joueurs::class,
            "live"      => Content\Live::class,
            "profil"    => Content\Profil::class,
            "tournois"  => Content\Tournois::class,
        ];

        $pageID = isset($_GET['page']) ? $_GET['page'] : "accueil";
        $pageClass = isset($pages[$pageID]) ? $pages[$pageID] : $pages["erreur"];
        $page = new $pageClass($bdd, $user);

        /* affiche le header de la page et le titre */
        include VIEW_FOLDER . "/Content/header.phtml";

        /* affiche le contenu */
        include VIEW_FOLDER . "/Content" . $page->getPHTML();
    }

}