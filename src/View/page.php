<?php

namespace View\Page;

function afficher_accueil() {
?>
	Bienvenue sur l'accueil mdr
<?php
}

function afficher_ecoles() {
?>
	Bienvenue sur les écoles mdr
<?php
}

function afficher_joueurs() {
?>
	Bienvenue sur les joueurs mdr
<?php
}

function afficher_tournois() {
?>
	Bienvenue sur les tournois mdr
<?php
}

function afficher_twitch() {
?>
	    <!-- Twitch début -->
	    <div class="twitch-container">
	        <div class="twitch-embed" id="twitch-embed"></div>

	        <script src="https://embed.twitch.tv/embed/v1.js"></script>

	        <script type="text/javascript">
	            var embed = new Twitch.Embed("twitch-embed", {
	                width: "100%",
	                height: "100%",
	                channel: "monstercat",
	                autoplay: false
	            });
	        </script>
	    </div>

	    <!-- Twitch fin -->

<?php
}

function afficher_page_erreur() {
?>
	T'es pommé mec
<?php
}

function afficher() {
?>

        <!-- La page principal -->        
        <div class="page">
        	<!-- le fond d'écran -->
        	<canvas class="page-background" id="bgCanvasID"></canvas>

        	<?php
        	if (!isset($_GET['page'])) {
        		afficher_accueil();
        	} else {
        		$page = $_GET['page'];
        		$afficher_pages = array(
        			"accueil" 	=> "afficher_accueil",
        			"joueurs" 	=> "afficher_joueurs",
        			"ecoles" 	=> "afficher_ecoles",
        			"tournois" 	=> "afficher_tournois",
        			"twitch" 	=> "afficher_twitch"
        		);
        		if (isset($afficher_pages[$page])) {
        			("\View\Page\\" . $afficher_pages[$page])();
        		} else {
        			afficher_page_erreur();
        		}
        	}
        	?>

        </div>

<?php
}
?>