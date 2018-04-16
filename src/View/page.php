<?php

namespace View\Page;

function afficher_accueil() {
?>
	Bienvenue sur l'accueil mdr
<?php
}

function afficher_live_twitch() {
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
function afficher() {
?>

        <!-- La page principal -->        
        <div class="page">
        	<!-- le fond d'écran -->
        	<canvas class="page-background" id="bgCanvasID"></canvas>

        	<!-- contenu de la page -->
        	<div class="page-content">
	        	<?php
	        	if (!isset($_GET['page'])) {
	        		afficher_accueil();
	        	} else {
	        		$page = $_GET['page'];
	        		if ($page == 'twitch') {
		        		afficher_live_twitch();
	        		} else {
		        		afficher_accueil();
	        		}
	        	}
	        	?>
	        </div>

        </div>

<?php
}
?>