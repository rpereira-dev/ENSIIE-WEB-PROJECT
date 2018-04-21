<?php

/* include */
require('../vendor/autoload.php'); 
require_once('../src/View/all.php');

/* recupere la session */
session_start();

/* recupere l'utilisateur */
$bdd = \Model\BDD::instance();

/* recupere l'utilisateur */
$user = \Model\Utilisateur::instance();

/** DEBUT : AFFICHAGE DE LA PAGE */

// le header de la page HTML
\View\Header\afficher();

//la bar d'informations qui pop des messages en bas du site
\View\Toastbar\afficher();

// affiche la partie horizontal en haut du site
\View\Navbar\afficher($user);

// affiche la partie vertical à gauche du site
\View\Sidebar\afficher();

// affiche la partie vertical à droite du site
\View\Aside\afficher($user);

// la page et son contenu (milieu de la page)
\View\Page\afficher();

// le footer de la page HTML
\View\Footer\afficher();

/** FIN : AFFICHAGE DE LA PAGE */

?>
