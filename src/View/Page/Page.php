<?php

namespace View\Page;

/**
 *  Représente la base de donnée
 */
abstract class Page {
    /**
     *  Constructeur
     */
    public function __construct() {
    }

    /**
     *  @return string : le titre de la page
     */
    abstract public function getTitle();

    /**
     *  Affiche la page
     */
    public function afficher() {
?>
        <!-- La page principal -->        
        <div class="page">
            <!-- le titre de la page -->
            <link rel="shortcut icon" href="./images/favicon.ico" />
            <title>
<?php
                $user = \Model\Utilisateur::instance();
                $count = count($user->asJoueur()->getNotifications());
                $title = "ULC : " . $this->getTitle();
                if ($count > 0) {
                    $title = "(" . $count . ") " . $title;
                }
                echo($title);
?>
            </title>

            <!-- le fond d'écran -->
            <canvas class="page-background" id="bgCanvasID"></canvas>

            <!-- le contenu de la page -->
<?php
            $this->afficherContent();
    }

    /**
     *  Affiche la page (entre 2 balises <div class="page"> </div>)
     */
    abstract public function afficherContent();
}

?>