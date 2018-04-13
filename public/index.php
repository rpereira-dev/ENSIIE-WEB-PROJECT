<?php

/* include path */
set_include_path(get_include_path() . PATH_SEPARATOR . "../src");
require_once("Model/BDD.php");
require_once("Model/Utilisateur.php");
require_once("View/all.php");

/* recupere la session */
session_start();

/* recupere l'utilisateur */
$bdd = BDD::instance();

/* recupere l'utilisateur */
$user = Utilisateur::instance();

/** DEBUT : AFFICHAGE DE LA PAGE */

// le header de la page HTML
afficher_header();

// affiche le fond du site
afficher_background();

// affiche la partie horizontal en haut du site
afficher_navbar();

// affiche la partie vertical à gauche du site
afficher_sidebar();

// affiche la partie vertical à droite du site
afficher_aside();

// la page et son contenu (milieu de la page)
afficher_page();

// le footer de la page HTML
afficher_footer();

/** FIN : AFFICHAGE DE LA PAGE */

?>
