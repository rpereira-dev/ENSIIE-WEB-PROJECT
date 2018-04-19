<?php

namespace View\Page;

/**
 *  Représente la page listant les tournois
 */
class PageLive extends Page {

    /**
     *  @return string : le titre de la page
     */
    public function getTitle() {
    	return ("Live");
    }


    /**
     *  Affiche le contenu de la page (entre 2 balises <div class="page"> </div>)
     */
    public function afficherContent() {
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
<?php
    }
}

?>