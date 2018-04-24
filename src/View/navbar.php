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
		<li class="navbar-item navbar-item-hoverable" style="float:right" onclick="redirectToPage('profil');">
			<div class="navbar-item-profil">
				<span><?php echo $user->asJoueur()->getPseudo(); ?></span>
				<img src="./images/profil/<?php echo $user->asJoueur()->getPseudo(); ?>.png"></img>
			</div>
		</li>

		<li class="navbar-item" style="float:right">
			<i class="navbar-item-icon navbar-item-hoverable fa fa-question"></i>				
		</li>	

		<li class="navbar-item" style="float:right">
			<i class="navbar-item-icon navbar-item-hoverable fa fa-book"></i>
		</li>

		<!-- la cloche des notifications -->
		<li class="navbar-item" id="notification-bell" style="float:right">
			<div class="navbar-item-hoverable navbar-item-bell" onclick="switchNotificationVisiblity();">
				<i class="navbar-item-icon fa fa-bell"></i>
			</div>

			<!-- notifications -->
			<div id="notifications_counter" 	class="notifications-counter" 	style="display: none;"></div>
			<div id="notifications"		 		class="notifications" 			style="display: none;"></div>    

		</li>			

		<?php
	}
?>
	</ul>




		<!-- la cloche des notifications -->
		<script type="text/javascript">
			/** recharges les notifications */
        	var node_notifications 	= document.getElementById("notifications");
        	var node_counter 		= document.getElementById("notifications_counter");

			function loadNotifications() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", 'notifications.php', true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        if (xhr.status == 200) {
                        	var notifications = JSON.parse(xhr.response).notifications;
                        	node_counter.innerHTML = notifications.length;
                        	node_counter.style.display = notifications.length == 0 ? "none" : "";

                        	//supprimes le contenu précèdent
							while (node_notifications.firstChild) {
    							node_notifications.removeChild(node_notifications.firstChild);
							}

                        	//ajoute la notification
                        	for (var i = 0 ; i < notifications.length ; i++) {
                        		var node_notification = document.createElement("notification_" + i);
                        		node_notification.class = "notification";
								node_notifications.appendChild(node_notification);

								var node_notification_content = document.createElement("notification_content_" + i);
								node_notification_content.class = "notification_content";
								node_notification_content.innerHTML = notifications[i].content;
								node_notification.appendChild(node_notification_content);
                        	}

                        } else {
                            console.log("Erreur de connection: " + xhr.response);
                        }
                    }
                }
                xhr.send();
			}
			/** on rappelle la fonction toutes les 5 secondes */
			setInterval(loadNotifications, 5000);
			loadNotifications();

			/** positionne les composants */
			/*var rect = document.getElementById("notification-bell").getBoundingClientRect();
			node_notifications.style.top   = rect.bottom + "px";
			node_notifications.style.left  = rect.left + "px";
			node_counter.style.top  = (rect.bottom  + 0.75 * (rect.top - rect.bottom)) + "px";
			node_counter.style.left = (rect.left + 0.6 * (rect.right - rect.left)) + "px";
*/

			/** rends visible / invisible la barre des notifications */
			function switchNotificationVisiblity() {
				if (node_notifications.style.display == "") {
					fadeOut(node_notifications, 60, 0.25);
				} else {
					fadeIn(node_notifications, 60, 0.25);
				}
			}
		</script>

<?php
}

?>