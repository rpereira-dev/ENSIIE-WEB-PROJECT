/**
 *	rediriges vers une autre page du site
 */
function redirectToPage(page) {
    window.location.replace("?page=" + page);
}

/**
 *	rediriges vers une autre page externe au site
 */
function redirect(domain) {
    window.location.replace(domain);
}

/**
 *	effectue une requete à l'api (toujours en méthode POST)
 *
 *	@param service: la chaine de caractère correspondant au service. e.x: '/user/disconnect'
 *	@param callback : 	une map reliant les codes de réponses html (200, 404, ...) à une fonction
 *						qui sera appelé en fonction du code de réponse obtenus par la requête.
 */
 function requestAPI(service, callback, args={}) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", './api' + service, true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		if (xhr.readyState == XMLHttpRequest.DONE) {
			if (!callback[xhr.status]) {
				toast("Une erreur non géré a eu lieu: " + xhr.response + " (code d'erreur " + xhr.status + ")", 0);
			} else {
				callback[xhr.status](xhr.response);
			}
		}
	}

	var arguments = '';
	for (var argName in args) {
		arguments = arguments + argName + '=' + args[argName] + '&';
	}
	console.log(arguments);

	xhr.send(arguments);
 }