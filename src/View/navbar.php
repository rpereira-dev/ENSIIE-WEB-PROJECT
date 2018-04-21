<?php

namespace View\Navbar;

function afficher($user) {
?>

    <!-- barre de navigation en haut-->
	<ul class="nav navbar">


		<!-- barre de recherche -->
		<li class="navbar-item" style="float:left">
			<div class="prompt navbar-item-prompt">
				<i class="prompt-logo fa fa-search navbar-search-logo"></i>
				<input class="prompt-input" type="text" placeholder="Rechercher..."/>
			</div>
		</li>


<?php
	if ($user->isConnected()) {
?>


		<li class="navbar-item" style="float:right" onclick="redirectToPage('profil');">
			<div class="navbar-item-profil">
				<span><?php echo $user->asJoueur()->getPseudo(); ?></span>
				<img src="./images/profil/<?php echo $user->asJoueur()->getPseudo(); ?>.png"></img>
			</div>
		</li>

		<li class="navbar-item" style="float:right">
			<i class="navbar-item-icon fa fa-question"></i>				
		</li>	

		<li class="navbar-item" style="float:right">
			<i class="navbar-item-icon fa fa-book"></i>
		</li>

		<li class="navbar-item" style="float:right" onclick="alert('PK TU ME CLIQUES WALA');">
			<i class="navbar-item-icon fa fa-bell">
				<?php
					$count = count($user->asJoueur()->getNotifications());
					if ($count > 0) {
				?>
						<div class="notification">
				<?php
						print($count);
				?>
						</div>
				<?php
					}
				?>
			</i>
		</li>
		<?php
	}
?>

	</ul>

<?php
}

?>