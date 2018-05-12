/**
 * effectue une requete à l'api (toujours en méthode POST)
 * 
 * @param service:
 *            la chaine de caractère correspondant au service. e.x:
 *            '/user/account/disconnect/'
 * @param callback :
 *            une map reliant les codes de réponses html (200, 404, ...) à une
 *            fonction qui sera appelé en fonction du code de réponse obtenus
 *            par la requête.
 * @param parameters:
 *            une map avec les paramètres de la requête
 */
 function requestAPI(service, callback, parameters={}) {
 	//on s'assure que le service est bien formatté
 	if ((!service.endsWith("/"))) {
 		service = service + "/";
 	}

 	//on s'assure que le service existe
 	if (!(service in API)) {
 		toast("Le service demandé est invalide: " + service);
 		return (false);
 	}

 	//type de la requete
 	var method = API[service];

 	//création de la requete
	var xhr = new XMLHttpRequest();
	xhr.open(method.name, './api' + service, true);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == XMLHttpRequest.DONE) {
			if (xhr.status in callback) {
				callback[xhr.status](xhr.response);
			} else {
				//TODO remove this
				toast("Erreur " + xhr.status + " non gérée sur le service " + service + " : " + xhr.response, "error");
			}
		}
	}
	//envoie de la requete avec les arguments formattés
	xhr.send(method.format(parameters));
 }

/**
 *	constantes pratiques pour distinguer les types de requêtes
 */
var REQUEST = {
	POST: {
		"name"		: 	"POST",
		"format"	: 	function(parameters) {
							var data = new FormData();
							for (var parameterName in parameters) {
								data.append(parameterName, parameters[parameterName]);
							}
							return (data);
						}
	},

	GET: {
		"name"		: 	"GET",
		"format"	: 	function(parameters) {
							var data = "";
							for (var parameterName in parameters) {
								data = data + parameterName + "=" + parameters[parameterName] + "&";
							}
							return (data);
						}

	}
}

/**
 *	Relis un service au type de la requête à envoyer
 */
 var API = {
 	"/user/account/connect/" 					: REQUEST.POST,
 	"/user/account/disconnect/" 				: REQUEST.POST,
 	"/user/account/register/" 					: REQUEST.POST,
 	"/user/account/image/get/" 					: REQUEST.GET,
 	"/user/account/image/set/" 					: REQUEST.POST,
 	"/user/account/password/modify/"			: REQUEST.POST,
 	"/user/account/password/reset/"				: REQUEST.POST,
 	"/user/game/lol/accounts/delete/"			: REQUEST.POST,
 	"/user/game/lol/accounts/get/"				: REQUEST.GET,
 	"/user/game/lol/third-party-code/generate/"	: REQUEST.GET,
 	"/user/game/lol/third-party-code/link/"		: REQUEST.POST,
 	"/user/notification/get/"					: REQUEST.GET,
 	"/user/notification/see/"					: REQUEST.POST,
 	"/user/notification/seeall/"				: REQUEST.POST
 };