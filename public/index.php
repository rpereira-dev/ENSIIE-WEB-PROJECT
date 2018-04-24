<?php

/* include */
require('../vendor/autoload.php'); 
define('PROJECT_ROOT', realpath(dirname(__FILE__) . "/../"  ));
define('VIEW_FOLDER', PROJECT_ROOT . "/src/View");

/* recupere la session */
session_start();

/* recupere l'utilisateur */
$bdd = \Model\BDD::instance();

/* recupere l'utilisateur */
$user = \Model\Utilisateur::instance();

/** DEBUT : AFFICHAGE DE LA PAGE */

// le header de la page HTML
\Controller\Header::afficher($user);

//la bar d'informations qui pop des messages en bas du site
\Controller\Toastbar::afficher($user);

// affiche la partie horizontal en haut du site
\Controller\Navbar::afficher($user);

// affiche la partie vertical à gauche du site
\Controller\Sidebar::afficher($user);

// affiche la partie vertical à droite du site
$aside = new \Controller\Aside($bdd, $user);
$aside->afficher();

// la page et son contenu (milieu de la page).
$content = \Controller\Content::afficher($bdd, $user);

// le footer de la page HTML
\Controller\Footer::afficher($user);

/** FIN : AFFICHAGE DE LA PAGE */
