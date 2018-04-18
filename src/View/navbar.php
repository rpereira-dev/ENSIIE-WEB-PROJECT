<?php

namespace View\Navbar;

function afficher() {
?>
    <!-- barre de navigation en haut-->
	<nav class="nav navbar">
		<!-- barre de recherche -->
		<div class="navbar-item">
			<div class="prompt">
				<i class="prompt-logo fa fa-search navbar-search-logo"></i>
				<input class="prompt-input" type="text" placeholder="Rechercher..."/>
			</div>
		</div>
	</nav>

<?php
}

?>