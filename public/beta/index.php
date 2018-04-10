<?php
    include '../../src/View/all.php';

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
?>
