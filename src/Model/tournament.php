<?php

$API_KEY = "api_key=RGAPI-3a93e60b-35bd-4b77-9a45-498aa673253d";

/**
 *	Effectue une requete aux serveurs de Riot
 *
 *	@param service : le service (e.g: /lol/summoner/v3/summoners/by-name/lousticos)
 *	@param arguments : les argugments requit par le service (voir la doc Riot correspond au service)
 *	@param isPost : false <=> GET , true <=> POST
 */
function riotRequest($service, $arguments, $isPost) {
	global $API_KEY;

	$ch = curl_init();
	$url = "https://euw1.api.riotgames.com" . $service . "?" . $API_KEY . "&" . $arguments;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	echo($url);
	if ($isPost) {
		curl_setopt($ch, CURLOPT_POST, 1);
	}
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	return ($result);
}

function createProvider() {
	return (riotRequest("/lol/tournament/v3/providers",
				"url=localhost:8080/beta&region=EUW",
				true
			)
		);
}

echo ("<!DOCTYPE html>");
echo ("<html>\n");
echo ('<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/></head>');
echo (riotRequest("/lol/summoner/v3/summoners/by-name/Lamoukk", "", false));
echo ("<br></br>");
echo (createProvider());
echo ("</html>");

?>
