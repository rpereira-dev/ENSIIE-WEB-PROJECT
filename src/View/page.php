<?php
function afficher_page_content() {
?>
	<!-- Page Content -->
	<div class="page-content">

	    <!-- Twitch début -->
	    <!--<div class="twitch-container">
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
	    </div>-->
	    <!-- Twitch fin -->
	</div>
<?php
}
function afficher_page() {
?>

        <!-- La page principal -->        
        <div class="page">
        	<?php
        	afficher_page_content();
        	?>
        </div>

<?php
}
?>