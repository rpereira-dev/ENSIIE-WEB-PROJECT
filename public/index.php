<?php

/* include */
require('../vendor/autoload.php'); 
define('PROJECT_ROOT', realpath(dirname(__FILE__) . "/../"  ));
define('VIEW_FOLDER', PROJECT_ROOT . "/src/View");

/* recupere la session */
session_start();

/*  */
$bdd = \Model\BDD::instance();

/* recupere l'utilisateur */
$user = \Model\Utilisateur::instance();

/** DEBUT : AFFICHAGE DE LA PAGE */
$pageElementsClass = [
	\Controller\Header::class,
	\Controller\Toastbar::class,
	\Controller\Navbar::class,
	\Controller\Sidebar::class,
	\Controller\Aside::class,
	\Controller\Content::getContent(),
	\Controller\Footer::class
];

foreach ($pageElementsClass as $pageElementClass) {
	$pageElement = new $pageElementClass($bdd, $user);
	$pageElement->afficher();
}


/** FIN : AFFICHAGE DE LA PAGE */
